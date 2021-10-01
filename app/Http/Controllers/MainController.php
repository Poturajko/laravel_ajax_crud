<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MainController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function reset()
    {
        Artisan::call('migrate:fresh --seed');

        return redirect()->route('index');
    }
}
