<?php

declare(strict_types=1);

namespace Api\Controller;

use Application\Entity\GameType;
use Application\Entity\GameAgeBracket;
use Application\Entity\GameLanguage;
use Application\Entity\GameCategory;
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
            "bracket" => $types
        ]));
        return $response;
    }

    public function gameByTypeAction()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $type = $this->params()->fromQuery('type');
        $gameRepository = $this->entityManager->getRepository(Game::class);
        $games = $gameRepository->findBy(['type' => $type]);

        $response->setContent(json_encode([
            "success" => true,
            "games" => $games
        ]));

        // return new JsonModel([
        //     'success' => true,
        //     'games' => $games,
        // ]);
    }

    public function gameByBracketAction()
    {
        $response = $this->getResponse();
        $request = $this->getRequest();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $bracket = $this->params()->fromQuery('bracket');
        $array = $request->getQuery()->toArray();
        $bracket = $array['bracket'] ?? null;
        if ($bracket != null) {
            $gameRepository = $this->entityManager->getRepository(Game::class);
            $games = $gameRepository->findBy(['bracket' => $bracket]);
            $response->setContent(json_encode([
                "success" => true,
                "games" => $games
            ]));
        } else {
            $gameRepository = $this->entityManager->getRepository(Game::class);
            $games = $gameRepository->findAll();
        }
        return $response;

    }

    public function gameByCategoryAction()
    {
        $response = $this->getResponse();
        $request = $this->getRequest();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        // $category = $this->params()->fromQuery('category');
        $array = $request->getQuery()->toArray();
        $cat = $array['category'] ?? null;
        if ($cat != "") {
            $gameRepository = $this->entityManager->getRepository(Game::class);
            $games = $gameRepository->findBy(['category' => $cat]);

            $response->setContent(json_encode([
                "success" => true,
                "games" => $games
            ]));
        } else {
            $response->setStatusCode(400);
            $response->setStatusText("Category is required");
            $response->setContent(json_encode([
                "success" => false,
                "message" => "Category is required"
            ]));
        }

    }


}
