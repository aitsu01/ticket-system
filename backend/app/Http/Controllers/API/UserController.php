<?php


namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        return User::select('id', 'name')->get();
    }
}
