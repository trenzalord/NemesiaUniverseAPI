<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 01/01/2017
 * Time: 13:29
 */

use Illuminate\Database\Eloquent\ModelNotFoundException;
use NemesiaUniverse\Exceptions\DuplicateEntryException;
use NemesiaUniverse\Exceptions\FieldMissingException;
use NemesiaUniverse\Exceptions\PasswordMismatchException;
use NemesiaUniverse\Model\NuUser;
use Slim\Http\Response;

$app->post("/register", function ($request, Response $response, $arguments) {

    $body = $request->getParsedBody();

    $required_fields = ["login", "pass1", "pass2", "first_name", "last_name", "birth_date", "mail"];

    //Throw exception when required field is missing (first one to be not found is send back)
    foreach ($required_fields as $field) {
        if(!isset($body[$field]) && empty($body[$field]))
        {
            throw new FieldMissingException($field);
        }
    }

    $login = $body['login'];
    $pass1 = $body['pass1'];
    $pass2 = $body['pass2'];
    $first_name = $body['first_name'];
    $last_name = $body['last_name'];
    $birth_date = $body['birth_date'];
    $mail = $body['mail'];

    try {
        $loginDuplicate = NuUser::where('login', $login)->firstOrFail();
        throw new DuplicateEntryException("login", $loginDuplicate->login);
    } catch (ModelNotFoundException $e) {

    }

    try {
        $mailDuplicate = NuUser::where('mail', $mail)->firstOrFail();
        throw new DuplicateEntryException("mail", $mailDuplicate->mail);
    } catch (ModelNotFoundException $e) {

    }

    if ($pass1 !== $pass2) {
        throw new PasswordMismatchException();
    }

    $password = password_hash($pass1, PASSWORD_DEFAULT);

    $newUser = new NuUser();
    $newUser->login = $login;
    $newUser->password = $password;
    $newUser->first_name = $first_name;
    $newUser->last_name = $last_name;
    $newUser->birth_date = $birth_date;
    $newUser->mail = $mail;

    $newUser->save();

    $data["status"] = "ok";
    $data["message"] = "User " . $login . " created.";

    return $response->withJson($data, 201);
});