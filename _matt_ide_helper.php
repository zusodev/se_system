<?php


use App\Models\User;

class Auth
{
    /**
     * @return User
     */
    public static function user()
    {

    }

    public static function routes()
    {
        \Illuminate\Routing\Router::auth();
    }
}

class Route extends \Illuminate\Routing\Route
{
}



