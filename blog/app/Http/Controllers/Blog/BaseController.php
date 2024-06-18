<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    /**
     * BaseController constructor
     */
    public function __construct()
    {
        //Ініціалізація загальних елементів адмінки
    }
}
