<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Application\Entity\Teacher;
use Application\Entity\Student;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Uuid;

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

            if (!$teacherName) {
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


            if (!$studentName || !isset($isDyslaxic)) {
                $response->setStatusCode(400);
                $response->setContent(json_encode([
                    'success' => false,
                    'message' => 'Student name is required and isDyslaxic status must be provided',
                ]));
                return $response;
            }

          

            // $teacherIds = filter_var(str_replace('T', '', $data['teacherid']), FILTER_VALIDATE_INT);

            // print($teacherIds);

            $teacher = $em->getRepository(Teacher::class)->findOneBy(['teacherId' => $data['teacherid']]);

            

            $student->setStudentName($studentName)->setStudentId($studentId)
                ->setIsDyslexic($isDyslaxic)
                ->setUuid(Uuid::uuid4()->toString())
                ->setStudentAge($data['studentAge'] ?? null)
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
        $lastId = $conn->fetchOne($sql) == NULL ? 0 : $conn->fetchOne($sql);

        // 2. Generate unique part (e.g., prefix or UUID)
        $prefix = $tableName == 'teacher' ? 'T' : 'S';
        $nextId = $lastId + 1;

        // 3. Concatenate and return
        return $prefix . $nextId;
    }


    public function registerStudentAction()
    {
        return new ViewModel();
    }


    public function searchTeacherAction()
    {
        return new ViewModel();
    }


    public function getStudentDetailsAction(){
         $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');

        $request = $this->getRequest();
        if ($request->isGet()) {
            $studentId = $this->params()->fromQuery('studentId', null);

            if (!$studentId) {
                $response->setStatusCode(400);
                $response->setContent(json_encode([
                    'success' => false,
                    'message' => 'Student ID is required',
                ]));
                return $response;
            }

            $student = $this->em->getRepository(Student::class)->findOneBy(['studentId' => $studentId]);

            if (!$student) {
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
                    'studentAge' => $student->getStudentAge(),
                    'teacherId' => $student->getTeacherId()->getTeacherId(),
                   'uuid'=>$student->getUuid(),
                   'id'=>$student->getStudentId()
                   
                ],
            ]));
        }

        return $response;

    }


    public function postDyxGame1Action(){
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



    public function postDyxGame2Action(){
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


    public function postDyxGame3Action(){
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


    public function postDyxGame4Action(){
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

    




    public function adminAction()
    {
        return new ViewModel();
    }

    public function setEm($em)
    {
        $this->em = $em;
    }
}
