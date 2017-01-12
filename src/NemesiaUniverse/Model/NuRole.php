<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 31/12/2016
 * Time: 14:39
 */

namespace NemesiaUniverse\Model;


use Illuminate\Database\Eloquent\Model;

class NuRole extends Model
{
    protected $table = "nu_role";

    public function rights()
    {
        return $this->hasManyThrough(NuRight::class, NuRightLink::class);
    }
}