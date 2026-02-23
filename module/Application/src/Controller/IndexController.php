<?php

declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Application\Entity\Teacher;
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
        $response->setContent(json_encode([
            'success' => true,
            'message' => 'Teacher registered successfully',
        ]));
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


            $em->persist($teacher);
            $em->flush();

            $response->setStatusCode(201);

            // Here you would typically save the teacher to the database
            // For this example, we'll just return a success response

            $response->setContent(json_encode([
                'success' => true,
                'message' => "Teacher '$teacherName' registered successfully",
            ]));
        }


        return $response;
    }


    private function generateId($em, $tableName)
    {
        $conn = $em->getConnection();
        $sql = "SELECT MAX(id) FROM {$tableName}"; // Or custom sequence logic
        $lastId = $conn->fetchOne($sql) == NULL ? 0 : $conn->fetchOne($sql);

        // 2. Generate unique part (e.g., prefix or UUID)
        $prefix = 'A-';
        $nextId = $lastId + 1;

        // 3. Concatenate and return
        return $prefix . $nextId;
    }


    public function registerStudentAction()
    {
        return new ViewModel();
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
