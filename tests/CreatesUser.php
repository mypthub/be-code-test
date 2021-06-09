<?php

namespace Tests;

use App\User;
use Illuminate\Contracts\Console\Kernel;

trait CreatesUser
{
    protected function createUser(): User
    {
        return User::create([
            'name' => 'test',
            'email' => 'test@test.user',
            'password' => bcrypt('testuser')
        ]);
    }
}
