<?php

namespace App\Modules\UserAdmin\Models;

use App\Common\Base\TobModel;

class UserMenu extends TobModel
{

    protected $connection = 'mysql-tob-common';
    protected $table = 'user_menu';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'name',
        'auth_list',
        'parent',
        'is_admin',
    ];

}