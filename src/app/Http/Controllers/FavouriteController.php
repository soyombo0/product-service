<?php

namespace App\Http\Controllers;

use App\Models\User;

class FavouriteController extends Controller
{
    public function index()
    {
        User::query()->whereId(1)->get();
    }
}
