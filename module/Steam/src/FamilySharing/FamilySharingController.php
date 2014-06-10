<?php

namespace GamerPowered\Steam\FamilySharing;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * RouletteController
 *
 * @package   GamerPowered\Steam\Roulette
 * @author    Alex Denvir <coldfff@gmail.com>
 * @copyright 2014 Alex Denvir
 */
class FamilySharingController extends AbstractActionController
{
    public function indexAction()
    {
        $view_model = new ViewModel();

        $player1 = $this->params()->fromQuery('player1');
        $player2 = $this->params()->fromQuery('player2');

        if(!is_null($player1) && !is_null($player2)) {
            /** @var \GamerPowered\Steam\Api\User $user */
            $user = $this->getServiceLocator()->get('\GamerPowered\Steam\Api\User');

            $player1_id = $user->resolveVanityUrl($player1);
            $player2_id = $user->resolveVanityUrl($player2);

            if (!is_null($player1_id) && !is_null($player2_id)) {
                /** @var \Steam\Api\PlayerService $user */
                $playerService = $this->getServiceLocator()->get('\GamerPowered\Steam\Api\SteamPlayer');

                $player1_games = [];
                $player2_games = [];

                $player1_games_result = $playerService->getOwnedGames($player1_id, true);
                foreach ($player1_games_result['response']['games'] as $game) {

                    $game_id = (int) $game['appid'];

                    $player1_games[$game_id] = $game;
                }

                $player2_games_result = $playerService->getOwnedGames($player2_id, true);
                foreach ($player2_games_result['response']['games'] as $game) {

                    $game_id = (int) $game['appid'];

                    $player2_games[$game_id] = $game;
                }

                $player1_benefit = array_diff_key($player2_games, $player1_games);

                $player2_benefit = array_diff_key($player1_games, $player2_games);

                usort(
                    $player1_benefit,
                    function($a, $b) {
                        return strcasecmp($a['name'], $b['name']);
                    }
                );

                usort(
                    $player2_benefit,
                    function($a, $b) {
                        return strcasecmp($a['name'], $b['name']);
                    }
                );

                $view_model->setVariable('player1_games', array_values($player1_benefit));
                $view_model->setVariable('player2_games', array_values($player2_benefit));
            } else {
                if (is_null($player1_id)) {
                    $view_model->setVariable('player1_error', true);
                }
                if (is_null($player2_id)) {
                    $view_model->setVariable('player2_error', true);
                }
            }

            $view_model->setVariable('player1', $player1);
            $view_model->setVariable('player2', $player2);
        }
        return $view_model;
    }
}
