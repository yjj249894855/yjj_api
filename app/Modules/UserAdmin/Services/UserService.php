<?php

namespace App\Modules\UserAdmin\Services;

use App\Modules\UserAdmin\Exception\UserAdminException;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\User;


class UserService
{
    public function getUserByEmail($email)
    {
        $userInfo = User::where('email', $email)->first();
        return $userInfo;
    }

    public function ceshi(){
        throw UserAdminException::error(1001001);
        $aa =2;
        $cc = $ddd;
    }
}