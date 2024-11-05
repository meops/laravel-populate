<?php

namespace Meops\Populate\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Meops\Populate\Tests\Factories\UserFactory;

class User extends Model
{
    protected $fillable = ['name', 'email', 'password'];

    public static function factory(): UserFactory
    {
        return UserFactory::new();
    }
}

