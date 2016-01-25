<?php

namespace App\Controller;

use App\Lib\Controller;
use App\Project;

class HomeController extends Controller
{
    public function indexAction() {

        $this->setTitle('Auto Parts Supply');

        $products = Project::getEntityManager()->getAll('App\Entity\ProductEntity', array(
            'limit' => 3,
            'orderBy' => 'created',
            'order' => 'DESC'
        ));

        $this->renderTemplate('home.php', array(
            'products' => $products
        ));
    }
}