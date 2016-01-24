<?php

namespace App\Controller;


use App\Lib\Controller;

class Error404Controller extends Controller
{
    public function indexAction() {
        echo '404 Error! Page not found!';
    }
}