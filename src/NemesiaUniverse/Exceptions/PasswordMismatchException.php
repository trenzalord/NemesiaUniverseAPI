<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 12/01/2017
 * Time: 19:57
 */

namespace NemesiaUniverse\Exceptions;

use Exception;

class PasswordMismatchException extends Exception
{
    public function __construct($code = 0, Exception $previous = null)
    {
        parent::__construct("Passwords doesn't match", $code, $previous);
    }
}