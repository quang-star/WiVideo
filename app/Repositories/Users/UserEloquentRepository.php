<?php

namespace App\Repositories\Users;

use App\Models\User;
use App\Repositories\Eloquent\EloquentRepository;

class UserEloquentRepository extends EloquentRepository implements UserRepositoryInterface
{
    /**
     * Implement abstract method and base model
     *
     * @return mixed | model
     */
    public function getModel()
    {
        return User::class;
    }

    // public function parseStatus($status)
    // {
    //     // Implement the logic to parse status
    //     // This is a placeholder, you can customize it as needed
    //     return $status ? 1 : 0;
    // }
    /**
     * 
     * Implement method to find user using email
     * @param mixed $email
     * @return null|User
     */
    public function findUserUsingEmail($email)
    {
        $user = $this->_model->where('email', $email)->first();
        if (empty($user)) {
            return null; // User not found
        }
        return $user; // Return the user object if found
    }

    // Deploy special methods.
}