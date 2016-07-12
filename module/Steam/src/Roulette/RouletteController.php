<?php

namespace GamerPowered\Steam\Roulette;

use GamerPowered\Steam\Api\User;
use Steam\Api\PlayerService;
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
    /**
     * @var User $user
     */
    private $user;
    
    /**
     * @var PlayerService $player_service
     */
    private $player_service;

    /**
     * RouletteController constructor.
     * @param User $user
     * @param PlayerService $player
     */
    public function __construct(User $user, PlayerService $player)
    {
        $this->user = $user;
        $this->player_service = $player;
    }
    
    
    public function indexAction()
    {
        $to_resolve = $this->params()->fromQuery('url');

        if (empty($to_resolve)) {
            return;
        }

        $players = [];

        foreach ($to_resolve as $resolvee) {
            if (!empty($resolvee)) {
                $player_id = $this->user->resolveVanityUrl($resolvee);

                if (!is_null($player_id)) {
                    $players[] = $player_id;
                }
            }
        }

        $games = [];

        $player_games = [];

        foreach ($players as $player) {

            $result = apc_fetch('player_' . $player);

            if (!$result) {
                $result = $this->player_service->getOwnedGames($player, true);
                apc_store('player_' . $player, $result, 3600);
            }

            foreach ($result['response']['games'] as $game) {

                $game_id = $game['appid'];

                $player_games[$game_id][] = strval($player);
                $games[$game_id] = $game;
            }
        }

        shuffle($games);

        $random_game = array_shift($games);

        $other_games = array_slice($games, 0, 10);

        $other_games[] = $random_game;

        $player_details = $this->user->getPlayerSummaries($players);

        $played_by = [];

        foreach ($player_games[$random_game['appid']] as $player_id) {
            $played_by[] = $player_details[$player_id];
        }

        $view_model = new ViewModel();

        $view_model->setVariable('picked_game', $random_game);
        $view_model->setVariable('other_games', $other_games);
        $view_model->setVariable('players', $played_by);

        return $view_model;
    }
}
