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
        /** @var \GamerPowered\Steam\Api\User $user */
        $user = $this->getServiceLocator()->get('\GamerPowered\Steam\Api\User');

        $mez_id = $user->resolveVanityUrl('mezzle');

        $tetcher_id = $user->resolveVanityUrl('tetcher');

        $emek_id = $user->resolveVanityUrl('emekcrash');

        $other_id = $user->resolveVanityUrl('76561198028082641');

        $players = [$mez_id, $tetcher_id, $emek_id, $other_id];

        $games = [];

        $player_games = [];

        $player_nicks = [
            $mez_id => 'Mez',
            $tetcher_id => 'Tetcher',
            $emek_id => 'Eman',
            $other_id => 'Ethan'
        ];

        /** @var \Steam\Api\PlayerService $user */
        $playerService = $this->getServiceLocator()->get('\GamerPowered\Steam\Api\SteamPlayer');

        foreach ($players as $player) {

            $result = $playerService->getOwnedGames($player, true);
            foreach ($result['response']['games'] as $game) {

                $game_id = $game['appid'];

                $player_games[$game_id][] = $player_nicks[$player];
                $games[$game_id] = $game;
            }
        }

        shuffle($games);

        $random_game = array_shift($games);

        $view_model = new ViewModel();

        $view_model->setVariable('game', $random_game);

        return $view_model;
    }
}
