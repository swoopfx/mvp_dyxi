<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Entity\GameCategoryCollection;
use Application\Entity\GameTypeCollection;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Application\Entity\Game;
use Application\Entity\GameType;
use Application\Entity\GameCategory;
use Application\Entity\GameBracket;
use Ramsey\Uuid\Uuid;
use Application\Entity\Teacher;
use Application\Entity\Student;
use Application\Entity\GameAgeBracket;
use Application\Entity\GameLanguage;
use Application\Entity\GamePrograms;
use Application\Entity\GameProgramsCollection;

class AdminController extends AbstractActionController
{
    /**
     * @var EntityManager
     */
    private $em;



    public function setEm($em)
    {
        $this->em = $em;
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function createGameAction()
    {
        $em = $this->em;

        // Fetch related entities for the dropdowns
        $gameTypes = $em->getRepository(GameType::class)->findAll();
        $gameCategories = $em->getRepository(GameCategory::class)->findAll();
        $gameAgeBrackets = $em->getRepository(GameAgeBracket::class)->findAll();
        $gamePrograms = $em->getRepository(GamePrograms::class)->findAll();

        $request = $this->getRequest();
        $error = null;
        $success = null;

        if ($request->isPost()) {
            $data = $request->getPost();

            $gameName = trim($data['gameName'] ?? '');
            $gamePage = trim($data['gamePage'] ?? '');
            $gameTypeIds = $data['gameType'] ?? [];
            $gameCategoryIds = $data['gameCategory'] ?? [];
            $gameDefinition = trim($data['gameDefinition'] ?? '');
            $gameAgeBracketId = $data['gameAgeBracket'] ?? null;
            $languageId = $data['language'] ?? null;
            $gameProgramId = $data['gameProgram'] ?? null;

            if (empty($gameName) || empty($gamePage) || empty($gameTypeIds) || empty($gameCategoryIds) || empty($gameDefinition) || empty($gameAgeBracketId) || empty($languageId)) {
                $error = 'All fields are required.';
            } else {
                $gameAgeBracket = $em->find(GameAgeBracket::class, $gameAgeBracketId);
                $language = $em->find(GameLanguage::class, $languageId);

                $gameTypesList = [];
                if (is_array($gameTypeIds)) {
                    foreach ($gameTypeIds as $id) {
                        $type = $em->find(GameType::class, $id);
                        if ($type) {
                            $gameTypesList[] = $type;
                        }
                    }
                }

                $gameCategoriesList = [];
                if (is_array($gameCategoryIds)) {
                    foreach ($gameCategoryIds as $id) {
                        $cat = $em->find(GameCategory::class, $id);
                        if ($cat) {
                            $gameCategoriesList[] = $cat;
                        }
                    }
                }



                // $game->getGameTypes()->clear();


                // $game->getGameCategories()->clear();


                if (empty($gameTypesList) || empty($gameCategoriesList) || !$gameAgeBracket || !$language) {
                    $error = 'Invalid selection for Game Type, Category, Bracket, or Language.';
                } else {
                    $game = new Game();
                    $game->setGameName($gameName)
                        ->setGamePage(AdminController::filterGameName($gamePage))
                        ->setGameDefinition($gameDefinition)
                        ->setGameAgeBracket($gameAgeBracket)
                        ->setLanguage($language)
                        ->setUuid(Uuid::uuid4()->toString())
                        ->setCreatedAt(new \DateTime())
                        ->setUpdatedAt(new \DateTime());

                    // foreach ($gameTypesList as $type) {
                    //     $game->addGameType($type);
                    // }

                    foreach ($gameTypesList as $type) {
                        $gameTypeCollection = new GameTypeCollection();
                        $gameTypeCollection->setGames($game)->setGameTypes($type);
                        $em->persist($gameTypeCollection);
                        $game->addGameType($gameTypeCollection);
                    }
                    // foreach ($gameCategoriesList as $cat) {
                    //     $game->addGameCategory($cat);
                    // }

                    foreach ($gameCategoriesList as $cat) {
                        $gameCategoryCollection = new GameCategoryCollection();
                        $gameCategoryCollection->setGame($game)->setGameCategory($cat);
                        $em->persist($gameCategoryCollection);
                        $game->addGameCategory($gameCategoryCollection);
                    }

                    if (!empty($gameProgramId)) {
                        $gameProgram = $em->find(GamePrograms::class, $gameProgramId);
                        if ($gameProgram) {
                            $gameProgramsCollection = new GameProgramsCollection();
                            $gameProgramsCollection->setGames($game);
                            $gameProgramsCollection->setGamePrograms($gameProgram);
                            $em->persist($gameProgramsCollection);
                        }
                    }

                    try {
                        $em->persist($game);
                        $em->flush();
                        $success = 'Game successfully created!';
                    } catch (\Throwable $th) {
                        $error = 'Error saving game: ' . $th->getMessage();
                    }
                }
            }
        }
        $gameLanguages = $em->getRepository(\Application\Entity\GameLanguage::class)->findAll();

        return new ViewModel([
            'gameTypes' => $gameTypes,
            'gameCategories' => $gameCategories,
            'gameAgeBrackets' => $gameAgeBrackets,
            'gameLanguages' => $gameLanguages,
            'gamePrograms' => $gamePrograms,
            'error' => $error,
            'success' => $success
        ]);
    }

    public static function filterGameName($gameName)
    {
        return str_replace(" ", "_", trim($gameName));
    }

    public function editGameAction()
    {
        $em = $this->em;
        $id = $this->params()->fromQuery('id');
        $error = null;
        $success = null;

        // $game = $em->getRepository(Game::class)->find($id);
        $game = $em->createQueryBuilder()
            ->select('g')
            ->from(Game::class, 'g')
            ->leftJoin("g.gamesType", "gtc")
            ->leftJoin("g.gameCategory", "gcc")
            ->leftJoin("g.gameAgeBracket", "gab")
            ->leftJoin("g.language", "gl")
            ->leftJoin("g.gamePrograms", "gpc")
            ->where("g.id = :id")
            ->setParameter("id", $id)
            ->getQuery()
            ->getResult();
        
        if (count($game) == 0) {
            return $this->redirect()->toRoute('admin', ['action' => 'index']);
        }

        $game = $game[0];

        $gameName = trim($game->getGameName() ?? '');
        $gamePage = trim($game->getGamePage() ?? '');
        $gameTypes = $em->getRepository(GameType::class)->findAll();
        $gameCategories = $em->getRepository(GameCategory::class)->findAll();
        $gameAgeBrackets = $em->getRepository(GameAgeBracket::class)->findAll();
        $gameLanguages = $em->getRepository(\Application\Entity\GameLanguage::class)->findAll();
        $gamePrograms = $em->getRepository(GamePrograms::class)->findAll();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();

            $gameName = trim($data['gameName'] ?? '');
            $gamePage = trim($data['gamePage'] ?? '');
            $gameTypeIds = $data['gameType'] ?? [];
            $gameCategoryIds = $data['gameCategory'] ?? [];
            $gameDefinition = trim($data['gameDefinition'] ?? '');
            $gameAgeBracketId = $data['gameAgeBracket'] ?? null;
            $languageId = $data['language'] ?? null;
            $gameProgramId = $data['gameProgram'] ?? null;

            if (empty($gameName) || empty($gamePage) || empty($gameTypeIds) || empty($gameCategoryIds) || empty($gameDefinition) || empty($gameAgeBracketId) || empty($languageId)) {
                $error = 'All fields are required.';
            } else {
                $gameAgeBracket = $em->getRepository(GameAgeBracket::class)->find($gameAgeBracketId);
                $language = $em->getRepository(\Application\Entity\GameLanguage::class)->find($languageId);

                $gameTypesList = [];
                if (is_array($gameTypeIds)) {
                    foreach ($gameTypeIds as $id) {
                        $type = $em->getRepository(GameType::class)->find($id);
                        if ($type) {
                            $gameTypesList[] = $type;
                        }
                    }
                }

                $gameCategoriesList = [];
                if (is_array($gameCategoryIds)) {
                    foreach ($gameCategoryIds as $id) {
                        $cat = $em->getRepository(GameCategory::class)->find($id);
                        if ($cat) {
                            $gameCategoriesList[] = $cat;
                        }
                    }
                }

                if (empty($gameTypesList) || empty($gameCategoriesList) || !$gameAgeBracket || !$language) {
                    $error = 'Invalid selection for Game Type, Category, Bracket, or Language.';
                } else {
                    $game->setGameName($gameName)
                        ->setGamePage(AdminController::filterGameName($gamePage))
                        ->setGameDefinition($gameDefinition)
                        ->setGameAgeBracket($gameAgeBracket)
                        ->setLanguage($language)
                        ->setUpdatedAt(new \DateTime());

                    $presentGameTypes =  $game->getGameTypes();
                    if($presentGameTypes->count() > 0){
                        foreach ($presentGameTypes as $presentGameType) {
                            $game->removeGameType($presentGameType);
                        }
                    }
                    foreach ($gameTypesList as $type) {
                        // $game->removeGameType($type);
                        $gameTypeCollection = new GameTypeCollection();
                        $gameTypeCollection->setGames($game)->setGameTypes($type);
                        // $em->persist($gameTypeCollection);
                        $game->addGameType($gameTypeCollection);
                    }

                    $presentGameCategories =  $game->getGameCategories();
                    if($presentGameCategories->count() > 0){
                        foreach ($presentGameCategories as $presentGameCategory) {
                            $game->removeGameCategory($presentGameCategory);
                        }
                    }
                    foreach ($gameCategoriesList as $cat) {
                       
                        $gameCategoryCollection = new GameCategoryCollection();
                        $gameCategoryCollection->setGame($game)->setGameCategory($cat);
                        // $em->persist($gameCategoryCollection);
                        $game->addGameCategory($gameCategoryCollection);
                    }

                    $presentGamePrograms = $game->getGamePrograms();
                    if ($presentGamePrograms->count() > 0) {
                        foreach ($presentGamePrograms as $presentGP) {
                            $em->remove($presentGP);
                        }
                    }
                    if (!empty($gameProgramId)) {
                        $gameProgram = $em->getRepository(GamePrograms::class)->find($gameProgramId);
                        if ($gameProgram) {
                            $gameProgramsCollection = new GameProgramsCollection();
                            $gameProgramsCollection->setGames($game);
                            $gameProgramsCollection->setGamePrograms($gameProgram);
                            $game->getGamePrograms()->add($gameProgramsCollection);
                        }
                    }

                    try {
                        $em->persist($game);
                        $em->flush();
                        $success = 'Game successfully updated!';
                        $this->redirect()->toRoute('admin', ['action' => 'view-games']);
                    } catch (\Throwable $th) {
                        $error = 'Error saving game: ' . $th->getMessage();
                    }
                }
            }
        }

        return new ViewModel([
            'game' => $game,
            'gameTypes' => $gameTypes,
            'gameCategories' => $gameCategories,
            'gameAgeBrackets' => $gameAgeBrackets,
            'gameLanguages' => $gameLanguages,
            'gamePrograms' => $gamePrograms,
            'error' => $error,
            'success' => $success
        ]);
    }

    public function viewTeachersAction()
    {
        $teachers = $this->em->getRepository(Teacher::class)->findAll();
        return new ViewModel(['teachers' => $teachers]);
    }

    public function viewStudentAction()
    {
        $students = $this->em->getRepository(Student::class)->findAll();
        return new ViewModel(['students' => $students]);
    }

    public function searchTeachersAction()
    {
        $request = $this->getRequest();
        $teachers = [];
        $query = '';

        if ($request->isPost() || $request->isGet()) {
            $query = $request->getQuery('q', $request->getPost('q', ''));
            if (!empty($query)) {
                $qb = $this->em->createQueryBuilder();
                $qb->select('t')
                    ->from(Teacher::class, 't')
                    ->where($qb->expr()->like('t.teacherName', ':query'))
                    ->setParameter('query', '%' . $query . '%');
                $teachers = $qb->getQuery()->getResult();
            } else {
                $teachers = $this->em->getRepository(Teacher::class)->findAll();
            }
        }

        return new ViewModel([
            'teachers' => $teachers,
            'query' => $query
        ]);
    }

    public function createGameTypeAction()
    {
        $request = $this->getRequest();
        $error = null;
        $success = null;

        if ($request->isPost()) {
            $type = trim($request->getPost('type', ''));
            if (empty($type)) {
                $error = 'Game Type is required.';
            } else {
                $gameType = new GameType();
                $gameType->setType($type);
                try {
                    $this->em->persist($gameType);
                    $this->em->flush();
                    $success = 'Game Type created successfully!';
                } catch (\Throwable $th) {
                    $error = 'Error creating game type: ' . $th->getMessage();
                }
            }
        }

        return new ViewModel(['error' => $error, 'success' => $success]);
    }

    public function createGameBracketAction()
    {
        $request = $this->getRequest();
        $error = null;
        $success = null;

        $ages = $this->em->getRepository(GameAgeBracket::class)->findAll();
        $languages = $this->em->getRepository(GameLanguage::class)->findAll();

        if ($request->isPost()) {
            $data = $request->getPost();
            $bracketName = trim($data['bracketName'] ?? '');
            $bracketId = trim($data['bracketId'] ?? '');
            $ageId = $data['age'] ?? null;
            $languageId = $data['language'] ?? null;
            $bgId = trim($data['bgId'] ?? '');
            $description = trim($data['description'] ?? '');

            if (empty($bracketName) || empty($bracketId) || empty($ageId) || empty($languageId)) {
                $error = 'Bracket Name, ID, Age, and Language are required.';
            } else {
                $age = $this->em->getRepository(GameAgeBracket::class)->find($ageId);
                $language = $this->em->getRepository(GameLanguage::class)->find($languageId);

                if (!$age || !$language) {
                    $error = 'Invalid Age or Language selected.';
                } else {
                    $bracket = new GameBracket();
                    $bracket->setBracketName($bracketName)
                        ->setBracketId($bracketId)
                        ->setAge($age)
                        ->setLanguage($language)
                        ->setBgId($bgId)
                        ->setDescription($description)
                        ->setUuid(Uuid::uuid4()->toString())
                        ->setCreatedAt(new \DateTime())
                        ->setUpdatedAt(new \DateTime());

                    try {
                        $this->em->persist($bracket);
                        $this->em->flush();
                        $success = 'Game Bracket created successfully!';
                    } catch (\Throwable $th) {
                        $error = 'Error creating Game Bracket: ' . $th->getMessage();
                    }
                }
            }
        }

        return new ViewModel([
            'ages' => $ages,
            'languages' => $languages,
            'error' => $error,
            'success' => $success
        ]);
    }

    public function createGameCategoryAction()
    {
        $request = $this->getRequest();
        $error = null;
        $success = null;

        if ($request->isPost()) {
            $categoryName = trim($request->getPost('gameCategory', ''));
            if (empty($categoryName)) {
                $error = 'Game Category is required.';
            } else {
                $category = new GameCategory();
                $category->setGameCategory($categoryName);
                try {
                    $this->em->persist($category);
                    $this->em->flush();
                    $success = 'Game Category created successfully!';
                } catch (\Throwable $th) {
                    $error = 'Error creating game category: ' . $th->getMessage();
                }
            }
        }

        return new ViewModel(['error' => $error, 'success' => $success]);
    }

    public function createGameLanguageAction()
    {
        $request = $this->getRequest();
        $error = null;
        $success = null;

        if ($request->isPost()) {
            $languageName = trim($request->getPost('language', ''));
            if (empty($languageName)) {
                $error = 'Game Language is required.';
            } else {
                $language = new GameLanguage();
                $language->setLanguage($languageName);
                try {
                    $this->em->persist($language);
                    $this->em->flush();
                    $success = 'Game Language created successfully!';
                } catch (\Throwable $th) {
                    $error = 'Error creating game language: ' . $th->getMessage();
                }
            }
        }

        return new ViewModel(['error' => $error, 'success' => $success]);
    }

    public function viewGamesAction()
    {
        $games = $this->em->getRepository(Game::class)->findAll();
        return new ViewModel(['games' => $games]);
    }

    public function createGameAgeBracketAction()
    {
        $request = $this->getRequest();
        $error = null;
        $success = null;

        if ($request->isPost()) {
            $ageBracket = trim($request->getPost('ageBracket', ''));
            $ageLowerBound = $request->getPost('ageLowerBound');
            $ageUpperBound = $request->getPost('ageUpperBound');

            if (empty($ageBracket) || $ageLowerBound === null || $ageUpperBound === null || $ageLowerBound === '' || $ageUpperBound === '') {
                $error = 'Game Age Bracket, Lower Bound, and Upper Bound are required.';
            } else {
                $gameAgeBracket = new GameAgeBracket();
                $gameAgeBracket->setAgeBracket($ageBracket);
                $gameAgeBracket->setUuid(Uuid::uuid4()->toString());
                $gameAgeBracket->setAgeLowerBound((int) $ageLowerBound);
                $gameAgeBracket->setAgeUpperBound((int) $ageUpperBound);
                try {
                    $this->em->persist($gameAgeBracket);
                    $this->em->flush();
                    $success = 'Game Age Bracket created successfully!';
                } catch (\Throwable $th) {
                    $error = 'Error creating game age bracket: ' . $th->getMessage();
                }
            }
        }

        return new ViewModel(['error' => $error, 'success' => $success]);
    }

    public function viewGameTypesAction()
    {
        $types = $this->em->getRepository(GameType::class)->findAll();
        return new ViewModel(['types' => $types]);
    }

    public function editGameTypeAction()
    {
        $id = $this->params()->fromQuery('id');
        $gameType = $this->em->getRepository(GameType::class)->find($id);
        if (!$gameType)
            return $this->redirect()->toRoute('admin', ['action' => 'view-game-types']);

        $request = $this->getRequest();
        $error = null;
        $success = null;

        if ($request->isPost()) {
            $type = trim($request->getPost('type', ''));
            if (empty($type)) {
                $error = 'Game Type is required.';
            } else {
                $gameType->setType($type);
                try {
                    $this->em->flush();
                    $success = 'Game Type updated successfully!';
                } catch (\Throwable $th) {
                    $error = 'Error updating game type: ' . $th->getMessage();
                }
            }
        }

        return new ViewModel(['gameType' => $gameType, 'error' => $error, 'success' => $success]);
    }

    public function viewGameCategoriesAction()
    {
        $categories = $this->em->getRepository(GameCategory::class)->findAll();
        return new ViewModel(['categories' => $categories]);
    }

    public function editGameCategoryAction()
    {
        $id = $this->params()->fromQuery('id');
        $category = $this->em->getRepository(GameCategory::class)->find($id);
        if (!$category)
            return $this->redirect()->toRoute('admin', ['action' => 'view-game-categories']);

        $request = $this->getRequest();
        $error = null;
        $success = null;

        if ($request->isPost()) {
            $categoryName = trim($request->getPost('gameCategory', ''));
            if (empty($categoryName)) {
                $error = 'Game Category is required.';
            } else {
                $category->setGameCategory($categoryName);
                try {
                    $this->em->flush();
                    $success = 'Game Category updated successfully!';
                } catch (\Throwable $th) {
                    $error = 'Error updating game category: ' . $th->getMessage();
                }
            }
        }

        return new ViewModel(['category' => $category, 'error' => $error, 'success' => $success]);
    }

    public function viewGameAgeBracketsAction()
    {
        $ageBrackets = $this->em->getRepository(GameAgeBracket::class)->findAll();
        return new ViewModel(['ageBrackets' => $ageBrackets]);
    }

    public function editGameAgeBracketAction()
    {
        $id = $this->params()->fromQuery('id');
        $ageBracket = $this->em->getRepository(GameAgeBracket::class)->find($id);
        if (!$ageBracket)
            return $this->redirect()->toRoute('admin', ['action' => 'view-game-age-brackets']);

        $request = $this->getRequest();
        $error = null;
        $success = null;

        if ($request->isPost()) {
            $ageText = trim($request->getPost('ageBracket', ''));
            $ageLowerBound = $request->getPost('ageLowerBound');
            $ageUpperBound = $request->getPost('ageUpperBound');

            if (empty($ageText) || $ageLowerBound === null || $ageUpperBound === null || $ageLowerBound === '' || $ageUpperBound === '') {
                $error = 'Game Age Bracket, Lower Bound, and Upper Bound are required.';
            } else {
                $ageBracket->setAgeBracket($ageText);
                $ageBracket->setAgeLowerBound((int) $ageLowerBound);
                $ageBracket->setAgeUpperBound((int) $ageUpperBound);
                try {
                    $this->em->flush();
                    $success = 'Game Age Bracket updated successfully!';
                } catch (\Throwable $th) {
                    $error = 'Error updating game age bracket: ' . $th->getMessage();
                }
            }
        }

        return new ViewModel(['ageBracket' => $ageBracket, 'error' => $error, 'success' => $success]);
    }

    public function viewGameLanguagesAction()
    {
        $languages = $this->em->getRepository(GameLanguage::class)->findAll();
        return new ViewModel(['languages' => $languages]);
    }

    public function editGameLanguageAction()
    {
        $id = $this->params()->fromQuery('id');
        $language = $this->em->getRepository(GameLanguage::class)->find($id);
        if (!$language)
            return $this->redirect()->toRoute('admin', ['action' => 'view-game-languages']);

        $request = $this->getRequest();
        $error = null;
        $success = null;

        if ($request->isPost()) {
            $languageName = trim($request->getPost('language', ''));
            if (empty($languageName)) {
                $error = 'Game Language is required.';
            } else {
                $language->setLanguage($languageName);
                try {
                    $this->em->flush();
                    $success = 'Game Language updated successfully!';
                } catch (\Throwable $th) {
                    $error = 'Error updating game language: ' . $th->getMessage();
                }
            }
        }

        return new ViewModel(['language' => $language, 'error' => $error, 'success' => $success]);
    }

    public function viewGameBracketsAction()
    {
        $brackets = $this->em->getRepository(GameBracket::class)->findAll();
        return new ViewModel(['brackets' => $brackets]);
    }

    public function editGameBracketAction()
    {
        $id = $this->params()->fromQuery('id');
        $bracket = $this->em->getRepository(GameBracket::class)->find($id);
        if (!$bracket)
            return $this->redirect()->toRoute('admin', ['action' => 'view-game-brackets']);

        $ages = $this->em->getRepository(GameAgeBracket::class)->findAll();
        $languages = $this->em->getRepository(GameLanguage::class)->findAll();

        $request = $this->getRequest();
        $error = null;
        $success = null;

        if ($request->isPost()) {
            $data = $request->getPost();
            $bracketName = trim($data['bracketName'] ?? '');
            $bracketId = trim($data['bracketId'] ?? '');
            $ageId = $data['age'] ?? null;
            $languageId = $data['language'] ?? null;
            $bgId = trim($data['bgId'] ?? '');
            $description = trim($data['description'] ?? '');

            if (empty($bracketName) || empty($bracketId) || empty($ageId) || empty($languageId)) {
                $error = 'Bracket Name, ID, Age, and Language are required.';
            } else {
                $age = $this->em->getRepository(GameAgeBracket::class)->find($ageId);
                $language = $this->em->getRepository(GameLanguage::class)->find($languageId);

                if (!$age || !$language) {
                    $error = 'Invalid Age or Language selected.';
                } else {
                    $bracket->setBracketName($bracketName)
                        ->setBracketId($bracketId)
                        ->setAge($age)
                        ->setLanguage($language)
                        ->setBgId($bgId)
                        ->setDescription($description)
                        ->setUpdatedAt(new \DateTime());

                    try {
                        $this->em->flush();
                        $success = 'Game Bracket updated successfully!';
                    } catch (\Throwable $th) {
                        $error = 'Error updating Game Bracket: ' . $th->getMessage();
                    }
                }
            }
        }

        return new ViewModel([
            'bracket' => $bracket,
            'ages' => $ages,
            'languages' => $languages,
            'error' => $error,
            'success' => $success
        ]);
    }

    public function searchStudentAction()
    {
        $request = $this->getRequest();
        $students = [];
        $query = '';

        if ($request->isPost() || $request->isGet()) {
            $query = $request->getQuery('q', $request->getPost('q', ''));
            if (!empty($query)) {
                $qb = $this->em->createQueryBuilder();
                $qb->select('s')
                    ->from(Student::class, 's')
                    ->where($qb->expr()->like('s.studentName', ':query'))
                    ->orWhere($qb->expr()->like('s.studentId', ':query'))
                    ->setParameter('query', '%' . $query . '%');
                $students = $qb->getQuery()->getResult();
            } else {
                $students = $this->em->getRepository(Student::class)->findAll();
            }
        }

        return new ViewModel([
            'students' => $students,
            'query' => $query
        ]);
    }

    public function editStudentAction()
    {
        $id = $this->params()->fromQuery('id');
        $student = $this->em->getRepository(Student::class)->find($id);

        if (!$student) {
            return $this->redirect()->toRoute('admin', ['action' => 'view-student']);
        }

        $request = $this->getRequest();
        $error = null;
        $success = null;

        $ages = $this->em->getRepository(\Application\Entity\GameAgeBracket::class)->findAll();
        $languages = $this->em->getRepository(\Application\Entity\GameLanguage::class)->findAll();

        if ($request->isPost()) {
            $data = $request->getPost();
            $studentName = trim($data['studentName'] ?? '');
            $studentId = trim($data['studentId'] ?? '');
            $studentAgeId = trim($data['studentAge'] ?? '');
            $languageId = trim($data['language'] ?? '');
            $isDyslexic = isset($data['isDyslexic']) ? true : false;

            if (empty($studentName) || empty($studentId) || empty($studentAgeId) || empty($languageId)) {
                $error = 'Student Name, Student ID, Age Bracket, and Language are required.';
            } else {
                $studentAge = $this->em->getRepository(\Application\Entity\GameAgeBracket::class)->find($studentAgeId);
                $language = $this->em->getRepository(\Application\Entity\GameLanguage::class)->find($languageId);
                $student->setStudentName($studentName)
                    ->setStudentId($studentId)
                    ->setStudentAge($studentAge)
                    ->setLanguage($language)
                    ->setIsDyslexic($isDyslexic)
                    ->setUpdatedAt(new \DateTime());

                try {
                    $this->em->flush();
                    $success = 'Student updated successfully!';
                } catch (\Throwable $th) {
                    $error = 'Error updating student: ' . $th->getMessage();
                }
            }
        }

        return new ViewModel([
            'student' => $student,
            'ages' => $ages,
            'languages' => $languages,
            'error' => $error,
            'success' => $success
        ]);
    }

    public function viewProgramsAction()
    {
        $programs = $this->em->getRepository(GamePrograms::class)->findAll();
        $viewModel = new ViewModel(['programs' => $programs]);
        $viewModel->setTemplate('application/admin/view-programs');
        return $viewModel;
    }

    public function viewGameProgramsAction()
    {
        return $this->viewProgramsAction();
    }

    public function createProgramAction()
    {
        $request = $this->getRequest();
        $error = null;
        $success = null;

        if ($request->isPost()) {
            $programName = trim($request->getPost('programName', ''));
            if (empty($programName)) {
                $error = 'Program Name is required.';
            } else {
                $program = new GamePrograms();
                $program->setProgramName($programName);
                try {
                    $this->em->persist($program);
                    $this->em->flush();
                    $success = 'Game Program created successfully!';
                    return $this->redirect()->toRoute('admin', ['action' => 'view-programs']);
                } catch (\Throwable $th) {
                    $error = 'Error creating game program: ' . $th->getMessage();
                }
            }
        }

        $viewModel = new ViewModel(['error' => $error, 'success' => $success]);
        $viewModel->setTemplate('application/admin/create-program');
        return $viewModel;
    }

    public function createGameProgramAction()
    {
        return $this->createProgramAction();
    }

    public function editProgramsAction()
    {
        $id = $this->params()->fromQuery('id');
        $program = $this->em->getRepository(GamePrograms::class)->find($id);
        if (!$program) {
            return $this->redirect()->toRoute('admin', ['action' => 'view-programs']);
        }

        $request = $this->getRequest();
        $error = null;
        $success = null;

        if ($request->isPost()) {
            $programName = trim($request->getPost('programName', ''));
            if (empty($programName)) {
                $error = 'Program Name is required.';
            } else {
                $program->setProgramName($programName);
                try {
                    $this->em->flush();
                    $success = 'Game Program updated successfully!';
                    return $this->redirect()->toRoute('admin', ['action' => 'view-programs']);
                } catch (\Throwable $th) {
                    $error = 'Error updating game program: ' . $th->getMessage();
                }
            }
        }

        $viewModel = new ViewModel([
            'program' => $program,
            'error' => $error,
            'success' => $success
        ]);
        $viewModel->setTemplate('application/admin/edit-program');
        return $viewModel;
    }

    public function editProgramAction()
    {
        return $this->editProgramsAction();
    }

    public function editGameProgramAction()
    {
        return $this->editProgramsAction();
    }

    public function deleteProgramAction()
    {
        $id = $this->params()->fromQuery('id');
        $program = $this->em->getRepository(GamePrograms::class)->find($id);
        if ($program) {
            try {
                $this->em->remove($program);
                $this->em->flush();
            } catch (\Throwable $th) {
                // Ignore or log error
            }
        }
        return $this->redirect()->toRoute('admin', ['action' => 'view-programs']);
    }

    public function deleteGameProgramAction()
    {
        return $this->deleteProgramAction();
    }
}
