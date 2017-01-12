<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 31/12/2016
 * Time: 14:24
 */

use Firebase\JWT\JWT;
use NemesiaUniverse\Model\NuUser;
use Tuupola\Base62;

$app->post("/login", function ($request, $response, $arguments) {

    $now = new DateTime();
    $future = new DateTime("now +2 hours");
    $login = $request->getServerParams()["PHP_AUTH_USER"];
    $roleId = NuUser::where('login', $login)->first()->role->role_id;
    $roleId = isset($roleId) && !empty($roleId) ? $roleId : 1; //TODO see what is the default role (connected user)

    $jti = Base62::encode(random_bytes(16));

    $payload = [
        "iat" => $now->getTimeStamp(),
        "exp" => $future->getTimeStamp(),
        "jti" => $jti,
        "sub" => $login,
        "role" => $roleId
    ];

    $secret = getenv("JWT_SECRET");
    $token = JWT::encode($payload, $secret, "HS256");
    $data["status"] = "ok";
    $data["token"] = $token;

    return $response->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});

/* This is just for debugging, not usefull in real life. */
$app->get("/dump", function ($request, $response, $arguments) {
    print_r($this->token);
});

$app->post("/dump", function ($request, $response, $arguments) {
    print_r($this->token);
});