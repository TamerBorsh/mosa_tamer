<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends Controller
{
    public function index(): Response
    {
        return response()->view('welcome');
    }
}
