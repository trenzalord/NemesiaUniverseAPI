<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 12/01/2017
 * Time: 19:17
 */

namespace NemesiaUniverse\Exceptions;

use Exception;

class FieldMissingException extends Exception
{
    public function __construct($field = "<undefined>", $code = 0, Exception $previous = null)
    {
     parent::__construct("Field missing: " . $field, $code, $previous);
    }
}