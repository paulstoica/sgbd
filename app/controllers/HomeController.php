<?php

namespace App\Controller;

use App\Lib\Controller;

class HomeController extends Controller
{
    public function indexAction() {
        $this->renderTemplate('home.php', array(
            'products' => array('test')
        ));
    }
}