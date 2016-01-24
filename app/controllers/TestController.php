<?php

namespace App\Controller;


use App\Lib\Controller;

class TestController extends Controller
{
    public function indexAction() {
        print_r('Test -> index');
    }

    public function testAction() {
        print_r('Test -> test');
    }
}