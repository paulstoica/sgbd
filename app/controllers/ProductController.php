<?php

namespace App\Controller;


use App\Lib\Controller;
use App\Project;

class ProductController extends Controller
{

    public function listAction() {

        $this->setTitle('Products');

        $limit = isset($_GET['limit'])? $_GET['limit'] : 12;
        $offset = isset($_GET['offset'])? $_GET['offset'] : 0;

        $em = Project::getEntityManager();

        $products = $em->getAll('App\Entity\ProductEntity', array(
            'limit' => $limit,
            'offset' => $offset,
            'orderBy' => 'created',
            'order' => 'DESC'
        ));

        $this->renderTemplate('product/list.php', array(
            'products' => $products
        ));
    }

    public function createAction() {

        $this->setTitle('Create Product');

        $error = '';

        $brands = Project::getEntityManager()->getAll('App\Entity\BrandAutoEntity');

        $this->renderTemplate('product/create.php', array(
            'brands' => $brands,
            'error' => $error
        ));
    }

    public function modelAction($brandId) {

        $models = Project::getEntityManager()->getAllBy('App\Entity\ModelAutoEntity', array(
            'brand_id' => $brandId
        ));

        if (empty($models)) {
            return 0;
        }

        foreach ($models as $model) {
            echo '<option value="'. $model->getId() .'">' . $model->getName() . '</option>';
        }
    }
}