<?php
namespace GamerPowered\Steam\Roulette;

use GamerPowered\Steam\Api\User;
use Steam\Api\PlayerService;
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

        /** @var User $user */
        $user = $this->getServiceLocator()->get(User::class);

        foreach ($to_resolve as $resolvee) {
            if (!empty($resolvee)) {
                $player_id = $user->resolveVanityUrl($resolvee);

                if (!is_null($player_id)) {
                    $players[] = $player_id;
                }
            }
        }

        $games = [];

        /** @var PlayerService $user */
        $playerService = $this->getServiceLocator()->get(PlayerService::class);

        foreach ($players as $player) {

            $result = $playerService->getOwnedGames($player, true);
            foreach ($result['response']['games'] as $game) {

                $game_id = $game['appid'];
                $games[$game_id] = $game;
            }
        }

        usort(
            $games,
            function ($a, $b) {
                return strcasecmp($a['name'], $b['name']);
            }
        );

        $view_model = new JsonModel();

        $view_model->setVariable('games', array_values($games));

        return $view_model;
    }
}
