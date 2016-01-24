<?php

namespace App\Controller;


use App\Lib\Controller;
use App\Lib\Security;
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

        if (isset($_POST['name'])) {
            $name = $_POST['name'];

            if ($name) {

                $description = isset($_POST['description'])? $_POST['description'] : '';
                $stock = isset($_POST['stock'])? $_POST['stock'] : 0;
                $price = isset($_POST['price'])? $_POST['price'] : 0;

                $created = new \DateTime();
                $user = Security::getLoggedUser();

                $data = array(
                    'name' => $name,
                    'description' => $description,
                    'price' => $price,
                    'stock' => $stock,
                    'user_id' => $user->getId(),
                    'status' => 1,
                    'created' => $created->format('Y-m-d H:i:s'),
                    'updated' => $created->format('Y-m-d H:i:s')
                );

                $brandId = isset($_POST['brand']) && $_POST['brand']? intval($_POST['brand']) : null;

                if ($brandId) {
                    $data['brand_id'] = $brandId;
                }

                $modelId = isset($_POST['model']) && $_POST['model']? intval($_POST['model']) : null;

                if ($modelId) {
                    $data['model_id'] = $modelId;
                }

                $product = Project::getEntityManager()->insert('App\Entity\ProductEntity', $data);

                if (!$product) {
                    $error = 'Was an error during product creation, please try again.';
                }
            } else {
                $error = 'Name is required!';
            }

        }

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