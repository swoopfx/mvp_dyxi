<?php

declare(strict_types=1);

namespace Api\Controller;

use Application\Entity\GameCategoryCollection;
use Application\Entity\GameType;
use Application\Entity\GameAgeBracket;
use Application\Entity\GameLanguage;
use Application\Entity\GameCategory;
use Application\Entity\GameTypeCollection;
use Application\Entity\GamePrograms;
use Application\Entity\GameProgramsCollection;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use Application\Entity\Game;
use Doctrine\ORM\Query;

class IndexController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        return new JsonModel([
            'success' => true,
            'message' => 'Api Module is working',
        ]);
    }


    public function typesAction()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $gameRepository = $this->entityManager->getRepository(GameType::class);
        $types = $gameRepository->createQueryBuilder("t")
            ->select("t")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $response->setContent(json_encode([
            "success" => true,
            "types" => $types
        ]));
        return $response;
    }

    public function categoryAction()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $gameRepository = $this->entityManager->getRepository(GameCategory::class);
        $types = $gameRepository->createQueryBuilder("t")
            ->select("t")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $response->setContent(json_encode([
            "success" => true,
            "category" => $types
        ]));
        return $response;
    }


    public function languageAction()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $gameRepository = $this->entityManager->getRepository(GameLanguage::class);
        $types = $gameRepository->createQueryBuilder("t")
            ->select("t")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $response->setContent(json_encode([
            "success" => true,
            "language" => $types
        ]));
        return $response;
    }





    public function ageBracketAction()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $gameRepository = $this->entityManager->getRepository(GameAgeBracket::class);
        $types = $gameRepository->createQueryBuilder("t")
            ->select("t")
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);
        $response->setContent(json_encode([
            "success" => true,
            "data" => $types
        ]));
        return $response;
    }
    // API /api/game-by-type?type=1
    public function gameByTypeAction()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $type = $this->params()->fromQuery('type');
        $gameRepository = $this->entityManager->getRepository(Game::class);
        $games = $gameRepository->createQueryBuilder("g")
            ->select("g")
            ->innerJoin("g.gameTypes", "gt")
            ->where("gt.id = :type")
            ->setParameter("type", $type)
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);

        $response->setContent(json_encode([
            "success" => true,
            "data" => $games
        ]));

        // return new JsonModel([
        //     'success' => true,
        //     'games' => $games,
        // ]);
        return $response;
    }

    public function gameByBracketAction()
    {
        $response = $this->getResponse();
        $request = $this->getRequest();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $bracket = $this->params()->fromQuery('bracket');
        // var_dump($bracket);
        // die();
        $array = $request->getQuery()->toArray();
        $bracket = $array['bracket'] ?? null;
        if ($bracket != null) {
            $gameRepository = $this->entityManager->getRepository(Game::class);
            $games = $gameRepository->createQueryBuilder("g")
                ->select("g")
                ->where("g.gameAgeBracket = :bracket")
                ->setParameter("bracket", $bracket)
                ->getQuery()
                ->getResult(Query::HYDRATE_ARRAY);
            $response->setContent(json_encode([
                "success" => true,
                "data" => $games
            ]));
        } else {
            $response->setStatusCode(400);
            // $response->setStatusText("Category is required");
            $response->setContent(json_encode([
                "success" => false,
                "message" => "Category is required"
            ]));
        }
        return $response;

    }

    public function gameByCategoryAction()
    {
        $response = $this->getResponse();
        $request = $this->getRequest();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $array = $request->getQuery()->toArray();
        $cat = $array['category'] ?? null;
        if ($cat != null) {
            $gameRepository = $this->entityManager->getRepository(Game::class);
            $games = $gameRepository->createQueryBuilder("g")
                ->select("g")
                ->innerJoin("g.gameCategories", "gc")
                ->where("gc.id = :cat")
                ->setParameter("cat", $cat)
                ->getQuery()
                ->getResult(Query::HYDRATE_ARRAY);
            $response->setContent(json_encode([
                "success" => true,
                "data" => $games
            ]));
        } else {
            $response->setStatusCode(400);
            // $response->setStatusText("Category is required");
            $response->setContent(json_encode([
                "success" => false,
                "message" => "Category is required"
            ]));
        }

        return $response;

    }

    public function gamesAction()
    {
        $request = $this->getRequest();
        $response = $this->getResponse();

        $params = $request->getQuery()->toArray();
        if ($params["level"] == "" || $params["age"] == "") {
            $response->setContent(json_encode([
                "success" => false,
                "message" => "Missing required parameters"
            ]));
            $response->setStatusCode(400);
            return $response;
        } else {
            $repository = $this->entityManager->getRepository(Game::class);
            $data = $this->entityManager->createQueryBuilder()
                ->select([
                    "partial g.{id, gameName, gameDescription, uuid, gamePage, learningOutcomes}",
                    "partial gl.{id, levelName}",
                    "partial ga.{id, bracketName}",
                    "partial gt.{id, type}",
                    "partial glang.{id, language}",
                ])
                ->from(Game::class, "g")
                ->leftJoin("g.gameLevel", "gl")
                ->leftJoin("g.gameAgeBracket", "ga")
                ->leftJoin("g.gameTypes", "gt")
                ->leftJoin("g.gameCategories", "gc")
                ->leftJoin("g.language", "glang")
                ->where("gl.levelId = :level")
                ->andWhere("ga.bracketId = :age")
                ->setParameter("level", $params["level"])
                ->setParameter("age", $params["age"])
                ->getQuery()
                ->getResult(Query::HYDRATE_ARRAY);
            $response->setContent(json_encode([
                "success" => true,
                "data" => $data
            ]));
        }

        $response->setStatusCode(200);
        $response->setContent(json_encode([
            "success" => true,
            "data" => [
                "level" => $params["level"],
                "age" => $params["age"],
            ]
        ]));
        return $response;
    }


    /**
     * Get the GameAgeBracket for a specific age
     * @query age
     * @return \Laminas\Stdlib\ResponseInterface
     */
    public function getBracketByAgeAction()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $request = $this->getRequest();
        $params = $request->getQuery()->toArray();
        $age = $params['age'] ?? null;

        if ($age === null) {
            $response->setStatusCode(400);
            $response->setContent(json_encode([
                "success" => false,
                "message" => "Age parameter is required"
            ]));
            return $response;
        }

        $bracketRepository = $this->entityManager->getRepository(GameAgeBracket::class);
        $brackets = $bracketRepository->createQueryBuilder("t")
            ->select("t")
            ->where("t.ageLowerBound <= :age")
            ->andWhere("t.ageUpperBound >= :age")
            ->setParameter("age", $age)
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);

        $response->setContent(json_encode([
            "success" => true,
            "data" => $brackets
        ]));
        return $response;
    }


    /**
     * 
     * Get All Games associated to a type 
     * @return \Laminas\Stdlib\ResponseInterface
     */
    public function gameTypesAction(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $request = $this->getRequest();
         $params = $request->getQuery()->toArray();
         if($params["level"] == "" && $params["age"] == "" && $params["type"] == ""){
             $response->setContent(json_encode([
                "success" => false,
                "message" => "Missing required parameters"
            ]));
            $response->setStatusCode(400);
            return $response;
         }else{
            // $repository = $this->entityManager->getRepository(Game::class);
            $data = $this->entityManager->createQueryBuilder()
                ->select([
                    "partial gtc.{id, games, gameTypes}",
                    "partial g.{id, gameName, gamePage,  gameDefinition, uuid, gameAgeBracket, language}",
                    "partial gab.{id, ageBracket, uuid, ageUpperBound, ageLowerBound}",
                    // "partial gt.{id, gameTypes}",
                    // "partial glang.{id, language}",
                ])
                ->from(GameTypeCollection::class, "gtc")
                ->leftJoin("gtc.games", "g")
                ->leftJoin("g.gameAgeBracket", "gab")
                // ->leftJoin("g.gamesType", "gt")
                // ->leftJoin("g.gameCategories", "gc")
                // ->leftJoin("g.language", "glang")
                ->where("gtc.gameTypes = :type")
                // ->andWhere("ga.bracketId = :age")
                ->setParameter("type", $params["type"])
                // ->setParameter("age", $params["age"])
                ->getQuery()
                ->getResult(Query::HYDRATE_ARRAY);
            $response->setContent(json_encode([
                "success" => true,
                "data" => $data
            ]));
         }
        return $response;
    }

    /**
     * Get Game Type collections by ids 
     * used to retrieve all game Tpes Id registered 
     * @query ids
     * @return \Laminas\Stdlib\ResponseInterface
     */
    public function gameTypeIdAction(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $data = $this->entityManager->createQueryBuilder()
            ->select(["c"])->from(GameType::class, "c")
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);
        return $response->setContent(json_encode(["success"=> true, "data"=>$data]));
    }

    /**
     * Get Game Category collections by ids 
     * used to retrieve all game Categories Id registered 
     * @query ids
     * @return \Laminas\Stdlib\ResponseInterface
     */
    public function gameCategoryIdAction(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $data = $this->entityManager->createQueryBuilder()
            ->select(["c"])->from(GameCategory::class, "c")
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);
        return $response->setContent(json_encode(["success"=> true, "data"=>$data]));
    }

    /**
     * 
     * Gets all Games associated to a category 
     * @return \Laminas\Stdlib\ResponseInterface
     */
    public function gameCategoryAction(){
       $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $request = $this->getRequest();
         $params = $request->getQuery()->toArray();
         if($params["level"] == "" && $params["age"] == "" && $params["cat"] == ""){
             $response->setContent(json_encode([
                "success" => false,
                "message" => "Missing required parameters"
            ]));
            $response->setStatusCode(400);
            return $response;
         }else{
            // $repository = $this->entityManager->getRepository(Game::class);
            $data = $this->entityManager->createQueryBuilder()
                ->select([
                    "partial gcc.{id, game, gameCategory}",
                    "partial g.{id, gameName, gamePage, gameDefinition, uuid, language}",
                    "partial gab.{id, ageBracket, uuid, ageUpperBound, ageLowerBound}",
                    // "partial gt.{id, type}",
                    // "partial glang.{id, language}",
                ])
                ->from(GameCategoryCollection::class, "gcc")
                ->leftJoin("gcc.game", "g")
                ->leftJoin("g.gameAgeBracket", "gab")
                // ->leftJoin("g.gameTypes", "gt")
                // ->leftJoin("g.gameCategories", "gc")
                // ->leftJoin("g.language", "glang")
                ->where("gcc.gameCategory = :cat")
                // ->andWhere("ga.bracketId = :age")
                ->setParameter("cat", $params["cat"])
                // ->setParameter("age", $params["age"])
                ->getQuery()
                ->getResult(Query::HYDRATE_ARRAY);
            $response->setContent(json_encode([
                "success" => true,
                "data" => $data
            ]));
         }
        return $response;
    }

    /**
     * Download the ggml-base.en.bin model file.
     * Creates the model directory if it does not exist.
     * Streams the file in chunks to avoid timeouts and memory exhaustion.
     * 
     * GET /api/download-model
     * @return \Laminas\Stdlib\ResponseInterface
     */
    public function downloadModelAction()
    {
        // Remove PHP execution time limit so large file transfers don't get killed
        set_time_limit(0);
        ini_set('max_execution_time', '0');

        $response = $this->getResponse();

        // Resolve the model directory relative to the project root
        $projectRoot = realpath(__DIR__ . '/../../../../..');
        $modelDir = $projectRoot . '/model';
        $filePath = $modelDir . '/ggml-base.en.bin';

        // Create the model directory if it does not exist
        if (!is_dir($modelDir)) {
            mkdir($modelDir, 0755, true);
        }

        // Check that the file exists before attempting to serve it
        if (!file_exists($filePath)) {
            $response->setStatusCode(404);
            $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
            $response->setContent(json_encode([
                'success' => false,
                'message' => 'Model file not found. Please place ggml-base.en.bin in the model/ directory.',
            ]));
            return $response;
        }

        $fileSize = filesize($filePath);

        // Send headers directly and stream the file in chunks to bypass
        // Laminas response buffering — prevents memory exhaustion and timeouts.
        // Clean any existing output buffers so data flows immediately.
        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="ggml-base.en.bin"');
        header('Content-Length: ' . $fileSize);
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Stream in 8 KB chunks to keep memory usage flat
        $handle = fopen($filePath, 'rb');
        if ($handle === false) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Unable to open model file for reading.',
            ]);
            exit;
        }

        while (!feof($handle)) {
            echo fread($handle, 8192);
            flush();
        }

        fclose($handle);
        exit;
    }

    /**
     * Get Game Program collections
     * @return \Laminas\Stdlib\ResponseInterface
     */
    public function gameProgramsIdAction(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $data = $this->entityManager->createQueryBuilder()
            ->select(["c"])->from(GamePrograms::class, "c")
            ->getQuery()->getResult(Query::HYDRATE_ARRAY);
        return $response->setContent(json_encode(["success"=> true, "data"=>$data]));
    }

    /**
     * Gets all Games associated to a program
     * @return \Laminas\Stdlib\ResponseInterface
     */
    public function gameProgramsAction(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $request = $this->getRequest();
        $params = $request->getQuery()->toArray();
        if(!isset($params["program"]) || $params["program"] == ""){
             $response->setContent(json_encode([
                "success" => false,
                "message" => "Missing required parameters"
            ]));
            $response->setStatusCode(400);
            return $response;
        }else{
            $data = $this->entityManager->createQueryBuilder()
                ->select([
                    "partial gpc.{id, games, gamePrograms}",
                    "partial g.{id, gameName, gamePage, gameDefinition, uuid, gameAgeBracket, language}",
                    "partial gab.{id, ageBracket, uuid, ageUpperBound, ageLowerBound}",
                ])
                ->from(GameProgramsCollection::class, "gpc")
                ->leftJoin("gpc.games", "g")
                ->leftJoin("g.gameAgeBracket", "gab")
                ->where("gpc.gamePrograms = :program")
                ->setParameter("program", $params["program"])
                ->getQuery()
                ->getResult(Query::HYDRATE_ARRAY);
            $response->setContent(json_encode([
                "success" => true,
                "data" => $data
            ]));
        }
        return $response;
    }

    


}
