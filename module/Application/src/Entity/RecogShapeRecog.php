<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="recog_shape_recog")
 */
class RecogShapeRecog {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id", nullable=false)
     */
    private $id;

    

    /**
     * @ORM\Column(type="string", name="sessionId", nullable=true)
     */
    private $sessionId;

    /**
     * @ORM\Column(type="string", name="userId", nullable=true)
     */
    private $userId;

   

    /**
     * @ORM\Column(type="string", name="gameId", nullable=true)
     */
    private $gameId;

    /**
    * @ORM\Column(name="gameType", nullable=true, type="string")
    */
    private $gameType;

   /**
    * @ORM\Column(name="gameCategory", nullable=true, type="string")
    */
    private $gameCategory;

   /**
    * @ORM\Column(name="gameProgram", nullable=true, type="string")
    */
    private $gameProgram;

    /**
     * @ORM\Column(name="input_events", nullable=true, type="json")
     */
    private $inputEvents;


    /**
     * @ORM\Column(type="integer", name="totalGameTime", nullable=true)
     */
    private $totalGameTime;

    /**
     * @ORM\Column(type="string", name="startTime", nullable=true)
     */
    private $startTime;

    /**
     * @ORM\Column(type="integer", name="totalCorrect", nullable=true)
     */
    private $totalCorrect;

    /**
     * @ORM\Column(type="integer", name="totalFailed", nullable=true)
     */
    private $totalFailed;

    /**
     * @ORM\Column(type="json", name="matchEvents", nullable=true)
     */
    private $matchEvents;

    
    /**
     * @ORM\Column(type="float", name="problemSolvingindex", nullable=true)
     */
    private $problemSolvingIndex;

    /**
     * @ORM\Column(type="float", name="creativeIndex", nullable=true)
     */
    private $creativeIndex;



    /**
     * @ORM\Column(type="float", name="averageTimeCorrect", nullable=true)
     */
    private $averageTimeCorrect;

    /**
     * @ORM\Column(type="float", name="averageTimeFailed", nullable=true)
     */
    private $averageTimeFailed;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    public function __construct() {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(){
        return $this->id;
    }

    public function getSessionId(){
        return $this->sessionId;
        
    }

    public function setSessionId($sessionId){
        $this->studentId = $studentId;
        return $this;
    }

    public function getTotalGameTime(){
        return $this->totalGameTime;
    }

    public function setTotalGameTime($totalGameTime){
        $this->totalGameTime = $totalGameTime;
        return $this;
    }

    public function getStartTime(){
        return $this->startTime;
    }

    public function setStartTime($startTime){
        $this->startTime = $startTime;
        return $this;
    }

    public function getTotalCorrect(){
        return $this->totalCorrect;
    }

    public function setTotalCorrect($totalCorrect){
        $this->totalCorrect = $totalCorrect;
        return $this;
    }

    public function getTotalFailed(){
        return $this->totalFailed;
    }

    public function setTotalFailed($totalFailed){
        $this->totalFailed = $totalFailed;
        return $this;
    }

    public function getMatchEvents(){
        return $this->matchEvents;
    }

    public function setMatchEvents($matchEvents){
        $this->matchEvents = $matchEvents;
        return $this;
    }

    public function getGameType(){
        return $this->gameType;
    }

    public function setGameType($gameType){
        $this->gameType = $gameType;
        return $this;
    }

    public function getGameCategory(){
        return $this->gameCategory;
    }

    public function setGameCategory($gameCategory){
        $this->gameCategory = $gameCategory;
        return $this;
    }

    public function getGameProgram(){
        return $this->gameProgram;
    }

    public function setGameProgram($gameProgram){
        $this->gameProgram = $gameProgram;
        return $this;
    }

    public function getInputEvents(){
        return $this->inputEvents;
    }

    public function setInputEvents($inputEvents){
        $this->inputEvents = $inputEvents;
        return $this;
    }

    public function getUserId(){
        return $this->userId;
    }

    public function setUserId($userId){
        $this->userId = $userId;
        return $this;
    }

   

    public function getGameId(){
        return $this->gameId;
    }

    public function setGameId($gameId){
        $this->gameId = $gameId;
        return $this;
    }

   

    public function getProblemSolvingindex(){
        return $this->problemSolvingindex;
    }

    public function setProblemSolvingindex($problemSolvingindex){
        $this->problemSolvingindex = $problemSolvingindex;
        return $this;
    }

    public function getCreativeIndex(){
        return $this->creativeIndex;
    }

    public function setCreativeIndex($creativeIndex){
        $this->creativeIndex = $creativeIndex;
        return $this;
    }

    public function getAverageTimeCorrect(){
        return $this->averageTimeCorrect;
    }

    public function setAverageTimeCorrect($averageTimeCorrect){
        $this->averageTimeCorrect = $averageTimeCorrect;
        return $this;
    }

    public function getAverageTimeFailed(){
        return $this->averageTimeFailed;
    }

    public function setAverageTimeFailed($averageTimeFailed){
        $this->averageTimeFailed = $averageTimeFailed;
        return $this;
    }

    public function getCreatedAt(){
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt){
        $this->createdAt = $createdAt;  
        return $this;
    }

    public function getUpdatedAt(){
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt){
        $this->updatedAt = $updatedAt;
        return $this;
    }
    
}