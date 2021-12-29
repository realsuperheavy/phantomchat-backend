<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function privacyPolicy()
    {
        return view('privacy-policy');
    }

    public function home(Request $request)
    {
        return view('welcome');
    }
}
