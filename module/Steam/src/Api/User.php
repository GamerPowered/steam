<?php

namespace GamerPowered\Steam\Api;

use \Steam\Api\User as SteamUser;

/**
 * User
 *
 * @package   GamerPowered\Steam\Api
 * @author    Protec Innovations <support@protecinnovations.co.uk>
 * @copyright 2014 Protec Innovations
 */
class User
{
    /** @var  \Steam\Api\User */
    protected $steam_api;

    /**
     * getSteamApi
     *
     * @return \Steam\Api\User
     */
    public function getSteamApi()
    {
        return $this->steam_api;
    }

    /**
     * setSteamApi
     *
     * @param \Steam\Api\User $steam_api
     * @return $this
     */
    public function setSteamApi(SteamUser $steam_api)
    {
        $this->steam_api = $steam_api;

        return $this;
    }

    /**
     * resolveVanityUrl
     *
     * @param $url
     * @return string
     */
    public function resolveVanityUrl($url)
    {
        $url = trim($url, '/');

        $to_resolve = array_pop(explode('/', $url));

        if (is_numeric($to_resolve)) {
            return $to_resolve;
        }

        return $this->getSteamApi()->resolveVanityUrl($to_resolve)['response']['steamid'];
    }

}
