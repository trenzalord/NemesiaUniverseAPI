<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 12/01/2017
 * Time: 19:34
 */

namespace NemesiaUniverse\Exceptions;


use Exception;

class DuplicateEntryException extends Exception
{
    public function __construct($entry = "<undefined>", $login = "<undefined>", $code = 0, Exception $previous = null)
    {
        parent::__construct(ucfirst($entry) . " " . $login . " is already taken.", $code, $previous);
    }
}