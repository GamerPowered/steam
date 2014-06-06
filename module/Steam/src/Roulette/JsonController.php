<?php
namespace GamerPowered\Steam\Roulette;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class JsonController extends AbstractActionController
{
    public function showAction()
    {
        $to_resolve = $this->params()->fromQuery('url');

        if (empty($to_resolve)) {
            return;
        }

        $players = [];

        /** @var \GamerPowered\Steam\Api\User $user */
        $user = $this->getServiceLocator()->get('\GamerPowered\Steam\Api\User');

        foreach ($to_resolve as $resolvee) {
            if (!empty($resolvee)) {
                $player_id = $user->resolveVanityUrl($resolvee);

                if (!is_null($player_id)) {
                    $players[] = $player_id;
                }
            }
        }

        $games = [];

        /** @var \Steam\Api\PlayerService $user */
        $playerService = $this->getServiceLocator()->get('\GamerPowered\Steam\Api\SteamPlayer');

        foreach ($players as $player) {

            $result = $playerService->getOwnedGames($player, true);
            foreach ($result['response']['games'] as $game) {
                $games[] = $game;
            }
        }

        $view_model = new JsonModel();

        $view_model->setVariable('games', $games);

        return $view_model;
    }
}
