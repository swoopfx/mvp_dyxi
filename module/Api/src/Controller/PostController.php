<?php
namespace Api\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Application\Entity\RecogShapeRecog;

class PostController extends AbstractActionController
{
    private $entityManager;

    private $bigQueryService;

    public function __construct()
    {
        // $this->entityManager = $entityManager;
    }

    // create a post to recognition shareExplorer  api/posts

    public function recogShapeRecogAction(){
        $response = $this->getResponse();
        $request = $this->getRequest();
        $bigQuery = $this->bigQueryService;

        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
       if($request->isPost()){
        $data = $request->getPost()->toArray();
        // $inputFilter = new InputFilter();
        // //validta all data
        // $inputFilter->add([
        //     "page_name" => [
        //         "required" => true,
        //         "validators" => [
        //             [
        //                 "name" => "NotEmpty",
        //                 "options" => [
        //                     "message" => "Page name is required"
        //                 ]
        //             ]
        //         ]
        //     ],
        //     "student_id" => [
        //         "required" => true,
        //         "validators" => [
        //             [
        //                 "name" => "NotEmpty",
        //                 "options" => [
        //                     "message" => "Student ID is required"
        //                 ]
        //             ]
        //         ]
        //     ],
        //     "game_id" => [
        //         "required" => true,
        //         "validators" => [
        //             [
        //                 "name" => "NotEmpty",
        //                 "options" => [
        //                     "message" => "Game ID is required"
        //                 ]
        //             ]
        //         ]
        //     ],
        //     "game_type" => [
        //         "required" => true,
        //         "validators" => [
        //             [
        //                 "name" => "NotEmpty",
        //                 "options" => [
        //                     "message" => "Game type is required"
        //                 ]
        //             ]
        //         ]
        //     ],
        //     "game_category" => [
        //         "required" => true,
        //         "validators" => [
        //             [
        //                 "name" => "NotEmpty",
        //                 "options" => [
        //                     "message" => "Game category is required"
        //                 ]
        //             ]
        //         ]
        //     ],
        //     "activity" => [
        //         "required" => true,
        //         "validators" => [
        //             [
        //                 "name" => "NotEmpty",
        //                 "options" => [
        //                     "message" => "Activity is required"
        //                 ]
        //             ]
        //         ]
        //     ],
        //     "user_id" => [
        //         "required" => true,
        //         "validators" => [
        //             [
        //                 "name" => "NotEmpty",
        //                 "options" => [
        //                     "message" => "User ID is required"
        //                 ]
        //             ]
        //         ]
        //     ],
        //     "session_id" => [
        //         "required" => true,
        //         "validators" => [
        //             [
        //                 "name" => "NotEmpty",
        //                 "options" => [
        //                     "message" => "Session ID is required"
        //                 ]
        //             ]
        //         ]
        //     ],
        //     "problem_solving_index" => [
        //         "required" => true,
        //         "validators" => [
        //             [
        //                 "name" => "NotEmpty",
        //                 "options" => [
        //                     "message" => "Problem solving index is required"
        //                 ]
        //             ]
        //         ]
        //     ],
        //     "creative_index" => [
        //         "required" => true,
        //         "validators" => [
        //             [
        //                 "name" => "NotEmpty",
        //                 "options" => [
        //                     "message" => "Creative index is required"
        //                 ]
        //             ]
        //         ]
        //     ],
        //     "average_time_correct" => [
        //         "required" => true,
        //         "validators" => [
        //             [
        //                 "name" => "NotEmpty",
        //                 "options" => [
        //                     "message" => "Average time correct is required"
        //                 ]
        //             ]
        //         ]
        //     ],
        //     "average_time_failed" => [
        //         "required" => true,
        //         "validators" => [
        //             [
        //                 "name" => "NotEmpty",
        //                 "options" => [
        //                     "message" => "Average time failed is required"
        //                 ]
        //             ]
        //         ]
        //     ],
        // ]);
        // $inputFilter->setData($data);
        // if (!$inputFilter->isValid()) {
        //     $response->setContent(json_encode([
        //         "success" => false,
        //         "message" => "Invalid data"
        //     ]));
        //     return $response;
        // }else{
         $rawBody = $request->getContent();
        $post = json_decode($rawBody, true);
            // $post = $request->getPost()->toArray();
        $recogShapeRecog = new RecogShapeRecog();
        $recogShapeRecog->setSessionId($post['session_id']);
        $recogShapeRecog->setGameId($post['game_id']);
        $recogShapeRecog->setGameType($post['game_type']);
        $recogShapeRecog->setGameCategory($post['game_category']);
        $recogShapeRecog->setGameProgram($post['game_program']);
        $recogShapeRecog->setInputEvents(json_encode($post['input_events']));
        $recogShapeRecog->setUserId($post['user_id']);
        $recogShapeRecog->setProblemSolvingindex($post['problem_solving_index']);
        $recogShapeRecog->setCreativeIndex($post['creative_index']);
        $recogShapeRecog->setAverageTimeCorrect($post['average_time_correct']);
        $recogShapeRecog->setAverageTimeFailed($post['average_time_failed']);
        $recogShapeRecog->setTotalGameTime($post['total_game_time']);
        $recogShapeRecog->setStartTime($post['start_time']);
        $recogShapeRecog->setTotalCorrect($post['total_correct']);
        $recogShapeRecog->setTotalFailed($post['total_failed']);
        $recogShapeRecog->setMatchEvents(json_encode($post['match_events']));
        $recogShapeRecog->setCreatedAt(new \DateTime());
        $recogShapeRecog->setUpdatedAt(new \DateTime());

        // send the data to BigQuery


       $row = [

    'session_id' => (string)$post['session_id'],
    'game_id' => (string)$post['game_id'],
    'game_type' => (string)$post['game_type'],
    'game_category' => (string)$post['game_category'],
    'game_program' => (string)$post['game_program'],

    'input_events' => json_encode($post['input_events']),

    'user_id' => (string)$post['user_id'],

    'problem_solving_index' => (float)$post['problem_solving_index'],
    'creative_index' => (float)$post['creative_index'],
    'average_time_correct' => (float)$post['average_time_correct'],
    'average_time_failed' => (float)$post['average_time_failed'],
    'total_game_time' => (float)$post['total_game_time'],

    // 'start_time' => date(
    //     'Y-m-d\TH:i:s\Z',
    //     strtotime($post['start_time'])
    // ),
    "start_time"=> (string)$post['start_time'],

    'total_correct' => (int)$post['total_correct'],
    'total_failed' => (int)$post['total_failed'],

    'match_events' => json_encode($post['match_events'])

];

$result = $bigQuery->insertRow(
    'recog_shape_recog',
    $row
);




        $this->entityManager->persist($recogShapeRecog);
        $this->entityManager->flush();
        $response->setStatusCode(201);
        $response->setContent(json_encode([
            "success" => true,
            "message" => "Post created successfully"
        ]));
        return $response;
        }else{
            $response->setStatusCode(405);
            $response->setContent(json_encode([
                "success" => false,
                "message" => "Invalid request method"
            ]));
            return $response;
        }
        
        
        
    }

    public function setEntityManager($em){
        $this->entityManager = $em;
        return $this;
    }

    public function setBigQueryService($bigQueryService){
        $this->bigQueryService = $bigQueryService;
        return $this;
    }
    
}