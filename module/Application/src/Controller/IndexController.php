<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Application\Entity\Teacher;
use Application\Entity\Student;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Uuid;
use Application\Entity\Game;
use Application\Entity\GameAgeBracket;
use Application\Entity\GameLanguage;

class IndexController extends AbstractActionController
{
    /**
     * Undocumented variable
     *
     * @var EntityManager
     */
    private $em;

    public function indexAction()
    {
        return new ViewModel();
    }

    public function registerTeacherAction()
    {
        return new ViewModel();
    }

    public function createTeacherAction()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $teacherName = $data['teacherName'] ?? null;

            if (! $teacherName) {
                $response->setStatusCode(400);
                $response->setContent(json_encode([
                    'success' => false,
                    'message' => 'Teacher name is required',
                ]));
                return $response;
            }

            $em = $this->em;
            $teacher = new Teacher();
            $teacherId = $this->generateId($em, 'teacher');
            $teacher->setTeacherName($teacherName)->setTeacherId($teacherId)
                ->setUuid(Uuid::uuid4()->toString())

                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());



            try {
                $em->persist($teacher);
                $em->flush();
                $response->setStatusCode(201);
                $teacherId = $teacher->getTeacherId();
                $response->setContent(json_encode([
                    'success' => true,
                    'message' => "Teacher '$teacherName' registered with teacherID '$teacherId' successfully",
                ]));
            } catch (\Throwable $th) {
                $response->setStatusCode(400);
                $response->setContent(json_encode([
                    'success' => false,
                    'message' => 'Error saving teacher: ' . $th->getMessage(),
                ]));
            }



            // Here you would typically save the teacher to the database
            // For this example, we'll just return a success response
        }


        return $response;
    }


    public function createStudentAction()
    {
        $em = $this->em;
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();

            $student = new \Application\Entity\Student();
            $studentName = $data['studentName'] ?? null;
            $isDyslaxic = isset($data['isDyslaxic']) ? filter_var($data['isDyslaxic'], FILTER_VALIDATE_BOOLEAN) : false;
            $studentId = $this->generateId($em, 'students');
            $age = isset($data['age']) && $data['age'] !== '' ? (int)$data['age'] : null;

            if (! $studentName || ! isset($isDyslaxic) || $age === null) {
                $response->setStatusCode(400);
                $response->setContent(json_encode([
                    'success' => false,
                    'message' => 'Student name, physical age, and isDyslaxic status are required',
                ]));
                return $response;
            }



            // $teacherIds = filter_var(str_replace('T', '', $data['teacherid']), FILTER_VALIDATE_INT);

            // print($teacherIds);

            $studentAgeId = $data['studentAge'] ?? null;
            $studentAge = $studentAgeId ? $em->getRepository(\Application\Entity\GameAgeBracket::class)->find($studentAgeId) : null;
            $languageId = $data['language'] ?? null;
            $language = $languageId ? $em->getRepository(\Application\Entity\GameLanguage::class)->find($languageId) : null;
            $teacher = $em->getRepository(Teacher::class)->findOneBy(['teacherId' => $data['teacherid']]);



            $student->setStudentName($studentName)->setStudentId($studentId)
                ->setIsDyslexic($isDyslaxic)
                ->setUuid(Uuid::uuid4()->toString())
                ->setStudentAge($studentAge)
                ->setLanguage($language)
                ->setAge($age)
                ->setTeacherId($teacher)
                ->setCreatedAt(new \DateTime())
                ->setUpdatedAt(new \DateTime());


            try {
                $em->persist($student);
                $em->flush();
                $response->setStatusCode(201);
                $studentId = $student->getStudentId();
                $response->setContent(json_encode([
                    'success' => true,
                    'message' => "Student '$studentName' registered with studentID '$studentId' successfully",
                ]));
            } catch (\Throwable $th) {
                $response->setStatusCode(500);
                $response->setContent(json_encode([
                    'success' => false,
                    'message' => 'Error saving student: ' . $th->getMessage(),
                ]));
            }


            // Here you would typically save the teacher to the database
            // For this example, we'll just return a success response
        }
        return $response;
    }


    private function generateId($em, $tableName)
    {
        $conn = $em->getConnection();
        $sql = "SELECT MAX(id) FROM {$tableName}"; // Or custom sequence logic
        $lastId = $conn->fetchOne($sql) == null ? 0 : $conn->fetchOne($sql);

        // 2. Generate unique part (e.g., prefix or UUID)
        $prefix = $tableName == 'teacher' ? 'T' : 'S';
        $nextId = $lastId + 1;

        // 3. Concatenate and return
        return $prefix . $nextId;
    }


    public function registerStudentAction()
    {
        $brackets = $this->em->getRepository(\Application\Entity\GameAgeBracket::class)->findAll();
        $languages = $this->em->getRepository(\Application\Entity\GameLanguage::class)->findAll();
        return new ViewModel(['brackets' => $brackets, 'languages' => $languages]);
    }

    public function editStudentAction()
    {
        $em = $this->em;
        $id = $this->params()->fromQuery('id');
        $student = null;
        $students = [];

        if ($id) {
            $student = $em->getRepository(Student::class)->find($id);
        }

        $request = $this->getRequest();
        $error = null;
        $success = null;

        $brackets = $em->getRepository(GameAgeBracket::class)->findAll();
        $languages = $em->getRepository(GameLanguage::class)->findAll();

        if ($request->isPost()) {
            $data = $request->getPost();

            if ($student) {
                $studentName = trim($data['studentName'] ?? '');
                $studentId = trim($data['studentId'] ?? '');
                $studentAgeId = trim($data['studentAge'] ?? '');
                $languageId = trim($data['language'] ?? '');
                $age = $data['age'] ?? null;
                $teacherIdCode = trim($data['teacherid'] ?? '');
                $isDyslexic = isset($data['isDyslexic']) ? true : false;

                if (empty($studentName) || empty($studentId) || empty($studentAgeId) || empty($languageId)) {
                    $error = 'Student Name, Student ID, Age Bracket, and Language are required.';
                } else {
                    $studentAge = $em->getRepository(GameAgeBracket::class)->find($studentAgeId);
                    $language = $em->getRepository(GameLanguage::class)->find($languageId);
                    $teacher = $em->getRepository(Teacher::class)->findOneBy(['teacherId' => $teacherIdCode]);

                    $student->setStudentName($studentName)
                        ->setStudentId($studentId)
                        ->setStudentAge($studentAge)
                        ->setLanguage($language)
                        ->setAge($age ? (int)$age : null)
                        ->setTeacherId($teacher)
                        ->setIsDyslexic($isDyslexic)
                        ->setUpdatedAt(new \DateTime());

                    try {
                        $em->flush();
                        $success = 'Student updated successfully!';
                    } catch (\Throwable $th) {
                        $error = 'Error updating student: ' . $th->getMessage();
                    }
                }
            }
        }

        if (! $student) {
            $students = $em->getRepository(Student::class)->findAll();
        }

        return new ViewModel([
            'student' => $student,
            'students' => $students,
            'brackets' => $brackets,
            'languages' => $languages,
            'error' => $error,
            'success' => $success
        ]);
    }


    public function searchTeacherAction()
    {
        return new ViewModel();
    }


    public function getStudentDetailsAction()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');

        $request = $this->getRequest();
        if ($request->isGet()) {
            $studentId = $this->params()->fromQuery('studentId', null);

            if (! $studentId) {
                $response->setStatusCode(400);
                $response->setContent(json_encode([
                    'success' => false,
                    'message' => 'Student ID is required',
                ]));
                return $response;
            }

            $student = $this->em->getRepository(Student::class)->findOneBy(['studentId' => $studentId]);

            if (! $student) {
                $response->setStatusCode(404);
                $response->setContent(json_encode([
                    'success' => false,
                    'message' => "Student with ID '$studentId' not found",
                ]));
                return $response;
            }

            $response->setStatusCode(200);
            $response->setContent(json_encode([
                'success' => true,
                'data' => [
                    'studentName' => $student->getStudentName(),
                    'isDyslexic' => $student->getIsDyslexic(),
                    'studentAge' => $student->getStudentAge() ? $student->getStudentAge()->getAgeBracket() : null,
                    'age' => $student->getAge()s,
                    'language' => $student->getLanguage() ? $student->getLanguage()->getLanguage() : null,
                    'teacherId' => $student->getTeacherId() ? $student->getTeacherId()->getTeacherId() : null,
                    'uuid' => $student->getUuid(),
                    'id' => $student->getStudentId()

                ],
            ]));
        }

        return $response;
    }


    public function postDyxGame1Action()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');

        $request = $this->getRequest();
        if ($request->isPost()) {
            // Handle game data submission here
            // For this example, we'll just return a success response
            $response->setStatusCode(200);
            $response->setContent(json_encode([
                'success' => true,
                'message' => 'Game data received successfully',
            ]));
        }

        return $response;
    }



    public function postDyxGame2Action()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');

        $request = $this->getRequest();
        if ($request->isPost()) {
            // Handle game data submission here
            // For this example, we'll just return a success response
            $response->setStatusCode(200);
            $response->setContent(json_encode([
                'success' => true,
                'message' => 'Game data received successfully',
            ]));
        }

        return $response;
    }


    public function postDyxGame3Action()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');

        $request = $this->getRequest();
        if ($request->isPost()) {
            // Handle game data submission here
            // For this example, we'll just return a success response
            $response->setStatusCode(200);
            $response->setContent(json_encode([
                'success' => true,
                'message' => 'Game data received successfully',
            ]));
        }

        return $response;
    }


    public function postDyxGame4Action()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');

        $request = $this->getRequest();
        if ($request->isPost()) {
            // Handle game data submission here
            // For this example, we'll just return a success response
            $response->setStatusCode(200);
            $response->setContent(json_encode([
                'success' => true,
                'message' => 'Game data received successfully',
            ]));
        }

        return $response;
    }


    public function getGamesAction()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');

        $request = $this->getRequest();
        if ($request->isGet()) {
            $em = $this->em;

            try {
                $games = $em->getRepository(Game::class)->findAll();
                $data = [];

                foreach ($games as $game) {
                    $category = $game->getGameCategory();
                    $type = $game->getGamesType();
                    $bracket = $game->getGameBracket();

                    $data[] = [
                        'id' => $game->getId(),
                        'gameName' => $game->getGameName(),
                        'gamePage' => $game->getGamePage(),
                        'uuid' => $game->getUuid(),
                        'gameDefinition' => $game->getGameDefinition(),
                        'createdAt' => $game->getCreatedAt() ? $game->getCreatedAt()->format('Y-m-d H:i:s') : null,
                        'updatedAt' => $game->getUpdatedAt() ? $game->getUpdatedAt()->format('Y-m-d H:i:s') : null,
                    ];
                }

                $response->setStatusCode(200);
                $response->setContent(json_encode([
                    'success' => true,
                    'data' => $data,
                ]));
            } catch (\Throwable $th) {
                $response->setStatusCode(500);
                $response->setContent(json_encode([
                    'success' => false,
                    'message' => 'Error retrieving games: ' . $th->getMessage(),
                ]));
            }
        } else {
            $response->setStatusCode(405);
            $response->setContent(json_encode([
                'success' => false,
                'message' => 'Method Not Allowed',
            ]));
        }

        return $response;
    }



    public function gamesByTypeAction()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');

        $request = $this->getRequest();
        if ($request->isGet()) {
            $em = $this->em;
            if ($request->getParam('gameType') == null) {
                $response->setStatusCode(400);
                $response->setContent(json_encode([
                    'success' => false,
                    'message' => 'Game type is required',
                ]));
                return $response;
            }

            try {
                // $games = $em->getRepository(Game::class)->findAll();
                // $data = [];

                // foreach ($games as $game) {
                //     $category = $game->getGameCategory();
                //     $type = $game->getGamesType();
                //     $bracket = $game->getGameBracket();

                //     $data[] = [
                //         'id' => $game->getId(),
                //         'gameName' => $game->getGameName(),
                //         'gamePage' => $game->getGamePage(),
                //         'uuid' => $game->getUuid(),
                //         'gameDefinition' => $game->getGameDefinition(),
                //         'createdAt' => $game->getCreatedAt() ? $game->getCreatedAt()->format('Y-m-d H:i:s') : null,
                //         'updatedAt' => $game->getUpdatedAt() ? $game->getUpdatedAt()->format('Y-m-d H:i:s') : null,
                //     ];
                // }

                $games = $em->getRepository(Game::class)->findBy(['gameType' => $request->getParam('gameType')]);




                $response->setStatusCode(200);
                $response->setContent(json_encode([
                    'success' => true,
                    'data' => $games,
                ]));
            } catch (\Throwable $th) {
                $response->setStatusCode(500);
                $response->setContent(json_encode([
                    'success' => false,
                    'message' => 'Error retrieving games: ' . $th->getMessage(),
                ]));
            }
        } else {
            $response->setStatusCode(405);
            $response->setContent(json_encode([
                'success' => false,
                'message' => 'Method Not Allowed',
            ]));
        }

        return $response;
    }

    public function playgroundInitiatitionAction()
    {
        $response = $this->getResponse();
        // get User profile
        // get user uuid
        // get other required parameter
        $json = json_encode([
            "success" => true,
            "data" => $data
        ]);
        $response->setStatusCode(202);
        return $response->setContent($json);
    }




    public function adminAction()
    {
        return new ViewModel();
    }

    public function setEm($em)
    {
        $this->em = $em;
    }
}
