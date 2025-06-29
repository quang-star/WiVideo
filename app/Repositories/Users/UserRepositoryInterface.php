<?php

namespace App\Repositories\Users;

interface UserRepositoryInterface
{
    // Define Specialized methods.
   // public function parseStatus($status);

    // Define function get user using email
    public function findUserUsingEmail($email);
}