<?php

declare(strict_types=1);

namespace Application\Controller;

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
        $gameBrackets = $em->getRepository(GameBracket::class)->findAll();

        $request = $this->getRequest();
        $error = null;
        $success = null;

        if ($request->isPost()) {
            $data = $request->getPost();
            
            $gameName = trim($data['gameName'] ?? '');
            $gamePage = trim($data['gamePage'] ?? '');
            $gameTypeId = $data['gameType'] ?? null;
            $gameCategoryId = $data['gameCategory'] ?? null;
            $gameDefinition = trim($data['gameDefinition'] ?? '');
            $gameBracketId = $data['gameBracket'] ?? null;

            if (empty($gameName) || empty($gamePage) || empty($gameTypeId) || empty($gameCategoryId) || empty($gameDefinition) || empty($gameBracketId)) {
                $error = 'All fields are required.';
            } else {
                $gameType = $em->getRepository(GameType::class)->find($gameTypeId);
                $gameCategory = $em->getRepository(GameCategory::class)->find($gameCategoryId);
                $gameBracket = $em->getRepository(GameBracket::class)->find($gameBracketId);

                if (!$gameType || !$gameCategory || !$gameBracket) {
                    $error = 'Invalid selection for Game Type, Category, or Bracket.';
                } else {
                    $game = new Game();
                    $game->setGameName($gameName)
                         ->setGamePage($gamePage)
                         ->setGamesType($gameType)
                         ->setGameCategory($gameCategory)
                         ->setGameDefinition($gameDefinition)
                         ->setGameBracket($gameBracket)
                         ->setUuid(Uuid::uuid4()->toString())
                         ->setCreatedAt(new \DateTime())
                         ->setUpdatedAt(new \DateTime());
                         
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

        return new ViewModel([
            'gameTypes' => $gameTypes,
            'gameCategories' => $gameCategories,
            'gameBrackets' => $gameBrackets,
            'error' => $error,
            'success' => $success
        ]);
    }

    public function editGameAction()
    {
        $em = $this->em;
        $id = $this->params()->fromQuery('id');
        $error = null;
        $success = null;
        
        $game = $em->getRepository(Game::class)->find($id);
        if (!$game) {
            return $this->redirect()->toRoute('admin', ['action' => 'index']);
        }

        $gameTypes = $em->getRepository(GameType::class)->findAll();
        $gameCategories = $em->getRepository(GameCategory::class)->findAll();
        $gameBrackets = $em->getRepository(GameBracket::class)->findAll();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            
            $gameName = trim($data['gameName'] ?? '');
            $gamePage = trim($data['gamePage'] ?? '');
            $gameTypeId = $data['gameType'] ?? null;
            $gameCategoryId = $data['gameCategory'] ?? null;
            $gameDefinition = trim($data['gameDefinition'] ?? '');
            $gameBracketId = $data['gameBracket'] ?? null;

            if (empty($gameName) || empty($gamePage) || empty($gameTypeId) || empty($gameCategoryId) || empty($gameDefinition) || empty($gameBracketId)) {
                $error = 'All fields are required.';
            } else {
                $gameType = $em->getRepository(GameType::class)->find($gameTypeId);
                $gameCategory = $em->getRepository(GameCategory::class)->find($gameCategoryId);
                $gameBracket = $em->getRepository(GameBracket::class)->find($gameBracketId);

                if (!$gameType || !$gameCategory || !$gameBracket) {
                    $error = 'Invalid selection for Game Type, Category, or Bracket.';
                } else {
                    $game->setGameName($gameName)
                         ->setGamePage($gamePage)
                         ->setGamesType($gameType)
                         ->setGameCategory($gameCategory)
                         ->setGameDefinition($gameDefinition)
                         ->setGameBracket($gameBracket)
                         ->setUpdatedAt(new \DateTime());
                         
                    try {
                        $em->flush();
                        $success = 'Game successfully updated!';
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
            'gameBrackets' => $gameBrackets,
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
            if (empty($ageBracket)) {
                $error = 'Game Age Bracket is required.';
            } else {
                $gameAgeBracket = new GameAgeBracket();
                $gameAgeBracket->setAgeBracket($ageBracket);
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
        if (!$gameType) return $this->redirect()->toRoute('admin', ['action' => 'view-game-types']);

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
        if (!$category) return $this->redirect()->toRoute('admin', ['action' => 'view-game-categories']);

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
        if (!$ageBracket) return $this->redirect()->toRoute('admin', ['action' => 'view-game-age-brackets']);

        $request = $this->getRequest();
        $error = null;
        $success = null;

        if ($request->isPost()) {
            $ageText = trim($request->getPost('ageBracket', ''));
            if (empty($ageText)) {
                $error = 'Game Age Bracket is required.';
            } else {
                $ageBracket->setAgeBracket($ageText);
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
        if (!$language) return $this->redirect()->toRoute('admin', ['action' => 'view-game-languages']);

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
        if (!$bracket) return $this->redirect()->toRoute('admin', ['action' => 'view-game-brackets']);

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

        if ($request->isPost()) {
            $data = $request->getPost();
            $studentName = trim($data['studentName'] ?? '');
            $studentId = trim($data['studentId'] ?? '');
            $studentAgeId = trim($data['studentAge'] ?? '');
            $isDyslexic = isset($data['isDyslexic']) ? true : false;
            
            if (empty($studentName) || empty($studentId) || empty($studentAgeId)) {
                $error = 'Student Name, Student ID, and Age Bracket are required.';
            } else {
                $studentAge = $this->em->getRepository(\Application\Entity\GameAgeBracket::class)->find($studentAgeId);
                $student->setStudentName($studentName)
                        ->setStudentId($studentId)
                        ->setStudentAge($studentAge)
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
            'error' => $error,
            'success' => $success
        ]);
    }
}
