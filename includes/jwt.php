<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


$secret_key = "MY_SECRET_KEY_123";


function createJWT($user)
{

    global $secret_key;


    $payload = [

        "id" => $user['id'],

        "username" => $user['username'],

        "email" => $user['email'],

        "iat" => time(),

        "exp" => time() + 3600

    ];


    return JWT::encode(
        $payload,
        $secret_key,
        'HS256'
    );

}



function verifyJWT($token)
{

    global $secret_key;


    return JWT::decode(
        $token,
        new Key($secret_key,'HS256')
    );

}

?>