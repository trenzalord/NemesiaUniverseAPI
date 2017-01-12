<?php

/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 31/12/2016
 * Time: 14:36
 */
namespace NemesiaUniverse\Model;

use Illuminate\Database\Eloquent\Model;

class NuUser extends Model
{
    protected $table = "nu_user";

    public function role()
    {
        return $this->hasOne(NuRole::class, 'role_id', 'role_id');
    }
}