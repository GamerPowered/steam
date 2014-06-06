<?php

namespace GamerPowered\Steam\Roulette;

use JMS\Serializer\SerializerBuilder;
use Steam\Adapter\Guzzle;
use Steam\Api\PlayerService;
use Steam\Api\User;
use Steam\Configuration;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * RouletteController
 *
 * @package   GamerPowered\Steam\Roulette
 * @author    Martin Meredith <mez@gamerpowered.co.uk>
 * @copyright 2014 Martin Meredith
 */
class RouletteController extends AbstractActionController
{
    public function indexAction()
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

        /** @var \Steam\Api\PlayerService $playerService */
        $playerService = $this->getServiceLocator()->get('\GamerPowered\Steam\Api\SteamPlayer');

        $player_details = $user->getPlayerSummaries($players);

        foreach ($players as $player) {

            $result = $playerService->getOwnedGames($player, true);
            foreach ($result['response']['games'] as $game) {

                $game_id = $game['appid'];

                $player_games[$game_id][] = $player_details[$player];
                $games[$game_id] = $game;
            }
        }

        shuffle($games);

        $random_game = array_shift($games);

        $view_model = new ViewModel();

        $view_model->setVariable('game', $random_game);
        $view_model->setVariable('players', $player_games[$game['appid']]);

        return $view_model;
    }
}
