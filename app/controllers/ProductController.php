<?php

namespace App\Controller;


use App\Lib\Controller;
use App\Lib\Security;
use App\Project;
use App\Entity\ProductEntity;

class ProductController extends Controller
{

    public function listAction() {

        $this->setTitle('Produse - Auto Parts Supply');

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

        $this->setTitle('Create Product - Auto Parts Supply');

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
                    $error = 'A fost o eroare in momentul crearii produsului, te rugam incearca dinou.';
                }
            } else {
                $error = 'Numele este obligatoriu!';
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
        ), array(
            'orderBy' => 'name'
        ));

        if (empty($models)) {
            return 0;
        }

        foreach ($models as $model) {
            echo '<option value="'. $model->getId() .'">' . $model->getName() . '</option>';
        }
    }

    public function searchAction() {

        $this->setTitle('Cautare Produse - Auto Parts Supply');

        $query = isset($_GET['query'])? $_GET['query'] : null;

        $products = array();
        $error = '';

        if ($query) {

            $sql = 'SELECT * FROM ' . ProductEntity::getTable() . " WHERE name LIKE '%" . $query . "%'";
            $statement = Project::getDB()->prepare($sql);

            if ($statement->execute()) {
                $products = $statement->fetchAll(\PDO::FETCH_CLASS, 'App\Entity\ProductEntity');
            }

            if (count($products) == 0) {
                $error = 'Nu sunt produse pentru criterile cautarii.';
            }
        }
        else {
            $error = 'Parametri cautarii nu sunt corecti.';
        }

        $this->renderTemplate('product/search.php', array(
            'products' => $products,
            'error' => $error
        ));
    }
}