<?php

namespace App\Http\Controllers;

use App\Repositories\Users\UserEloquentRepository;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class TestView extends Controller
{

    // define module repository
   // Define module repository
    private $userRepository;

    public function __construct(UserEloquentRepository $userEloquentRepository)
    {
        $this->userRepository = $userEloquentRepository;
    }
    public function test()
    {
       return view('test_vue');
    }
}
