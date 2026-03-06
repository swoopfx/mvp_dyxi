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
}
