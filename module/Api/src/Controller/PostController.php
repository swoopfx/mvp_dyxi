<?php
namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

class PostController extends AbstractActionController
{
    private $entityManager;

    public function __construct()
    {
        // $this->entityManager = $entityManager;
    }

    // create a post to recognition shareExplorer  api/posts

    public function recognitionSharedExplorerAction(){
        $response = $this->getResponse();
        $request = $this->getRequest();

        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
       if($request->isPost()){
        $data = $request->getPost()->toArray();
        $inputFilter = new InputFilter();
        //validta all data
        $inputFilter->add([
            "page_name" => [
                "required" => true,
                "validators" => [
                    [
                        "name" => "NotEmpty",
                        "options" => [
                            "message" => "Page name is required"
                        ]
                    ]
                ]
            ],
            "student_id" => [
                "required" => true,
                "validators" => [
                    [
                        "name" => "NotEmpty",
                        "options" => [
                            "message" => "Student ID is required"
                        ]
                    ]
                ]
            ],
            "game_id" => [
                "required" => true,
                "validators" => [
                    [
                        "name" => "NotEmpty",
                        "options" => [
                            "message" => "Game ID is required"
                        ]
                    ]
                ]
            ],
            "game_type" => [
                "required" => true,
                "validators" => [
                    [
                        "name" => "NotEmpty",
                        "options" => [
                            "message" => "Game type is required"
                        ]
                    ]
                ]
            ],
            "game_category" => [
                "required" => true,
                "validators" => [
                    [
                        "name" => "NotEmpty",
                        "options" => [
                            "message" => "Game category is required"
                        ]
                    ]
                ]
            ],
            "activity" => [
                "required" => true,
                "validators" => [
                    [
                        "name" => "NotEmpty",
                        "options" => [
                            "message" => "Activity is required"
                        ]
                    ]
                ]
            ],
            "user_id" => [
                "required" => true,
                "validators" => [
                    [
                        "name" => "NotEmpty",
                        "options" => [
                            "message" => "User ID is required"
                        ]
                    ]
                ]
            ],
            "session_id" => [
                "required" => true,
                "validators" => [
                    [
                        "name" => "NotEmpty",
                        "options" => [
                            "message" => "Session ID is required"
                        ]
                    ]
                ]
            ],
            "problem_solving_index" => [
                "required" => true,
                "validators" => [
                    [
                        "name" => "NotEmpty",
                        "options" => [
                            "message" => "Problem solving index is required"
                        ]
                    ]
                ]
            ],
            "creative_index" => [
                "required" => true,
                "validators" => [
                    [
                        "name" => "NotEmpty",
                        "options" => [
                            "message" => "Creative index is required"
                        ]
                    ]
                ]
            ],
            "average_time_correct" => [
                "required" => true,
                "validators" => [
                    [
                        "name" => "NotEmpty",
                        "options" => [
                            "message" => "Average time correct is required"
                        ]
                    ]
                ]
            ],
            "average_time_failed" => [
                "required" => true,
                "validators" => [
                    [
                        "name" => "NotEmpty",
                        "options" => [
                            "message" => "Average time failed is required"
                        ]
                    ]
                ]
            ],
        ]);
        $inputFilter->setData($data);
        if (!$inputFilter->isValid()) {
            $response->setContent(json_encode([
                "success" => false,
                "message" => "Invalid data"
            ]));
            return $response;
        }else{
            
        }
        $post = $request->getPost('post');
        
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        $response->setContent(json_encode([
            "success" => true,
            "message" => "Post created successfully"
        ]));
        return $response;
    }

    public function setEntityManager($em){
        $this->entityManager = $em;
        return $this;
    }
    
}