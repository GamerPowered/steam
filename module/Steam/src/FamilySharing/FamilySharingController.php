<?php

namespace GamerPowered\Steam\FamilySharing;

use GamerPowered\Steam\Api\User;
use Steam\Api\PlayerService;
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

        $player1_family_param = $this->params()->fromQuery('player1family', []);
        $player2_family_param = $this->params()->fromQuery('player2family', []);

        $player1_family = [];
        foreach ($player1_family_param AS $family_member) {
            if (!empty($family_member)) {
                $player1_family[] = $family_member;
            }
        }

        $player2_family = [];
        foreach ($player2_family_param AS $family_member) {
            if (!empty($family_member)) {
                $player2_family[] = $family_member;
            }
        }

        if (!is_null($player1) && !is_null($player2)) {
            /** @var User $user */
            $user = $this->getServiceLocator()->get(User::class);

            $player1_id = $user->resolveVanityUrl($player1);
            $player2_id = $user->resolveVanityUrl($player2);

            if (!is_null($player1_id) && !is_null($player2_id)) {
                /** @var PlayerService $playerService */
                $playerService = $this->getServiceLocator()->get(PlayerService::class);

                $player1_games = [];
                $player2_games = [];

                $player1_games_result = $playerService->getOwnedGames($player1_id, true);
                foreach ($player1_games_result['response']['games'] as $game) {

                    $game_id = (int)$game['appid'];

                    $player1_games[$game_id] = $game;
                }

                $player1_family_games = $player1_games;

                if (!empty($player1_family)) {
                    foreach ($player1_family as $family_member) {
                        $steam_id = $user->resolveVanityUrl($family_member);

                        if (!is_null($steam_id)) {
                            $result = $playerService->getOwnedGames($steam_id, true);

                            foreach ($result['response']['games'] as $game) {
                                $game_id = (int)$game['appid'];

                                $player1_family_games[$game_id] = $game;
                            }
                        }
                    }
                }


                $player2_games_result = $playerService->getOwnedGames($player2_id, true);
                foreach ($player2_games_result['response']['games'] as $game) {

                    $game_id = (int)$game['appid'];

                    $player2_games[$game_id] = $game;
                }

                $player2_family_games = $player2_games;

                if (!empty($player2_family)) {
                    foreach ($player2_family as $family_member) {
                        $steam_id = $user->resolveVanityUrl($family_member);
                        if (!is_null($steam_id)) {
                            $result = $playerService->getOwnedGames($steam_id, true);

                            foreach ($result['response']['games'] as $game) {
                                $game_id = (int)$game['appid'];

                                $player2_family_games[$game_id] = $game;
                            }
                        }
                    }
                }

                $player1_benefit = array_diff_key($player2_games, $player1_family_games);

                $player2_benefit = array_diff_key($player1_games, $player2_family_games);

                usort(
                    $player1_benefit,
                    function ($a, $b) {
                        return strcasecmp($a['name'], $b['name']);
                    }
                );

                usort(
                    $player2_benefit,
                    function ($a, $b) {
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
            $view_model->setVariable('player1family', $player1_family_param);
            $view_model->setVariable('player2family', $player2_family_param);
        }
        return $view_model;
    }
}
