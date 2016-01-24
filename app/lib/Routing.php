<?php

namespace App\Lib;

use App\Project;

class Routing
{

    public function __construct()
    {
        $this->redirectToRoute();
    }

    public static function prepareRouting()
    {
         return new self;
    }

    private function redirectToRoute() {

        if (!isset($_GET['url'])) {

            $this->redirectToHome();
            return;
        }

        $url = rtrim($_GET['url'], '/');
        $url = explode('/', $url);

        if (!isset($url[0])) {
            $this->redirectToHome();
            return;
        }

        $controllerName = Project::camelize($url[0]) . 'Controller';

        $controllerClass = '\\App\Controller\\' . $controllerName;

        if (!class_exists($controllerClass)) {
            $this->redirectTo404();
            return;
        }

        $controller = new $controllerClass;

        $params = array();

        if(count($url) > 1) {

            $actionName = ($url[1]? strtolower($url[1]) : 'index') . 'Action';

            $params = array_slice($url, 2);
        }
        else {
            $actionName = 'indexAction';
        }

        $this->callController($controller, $actionName, $params);

    }

    private function callController(Controller $controller, $actionName, $params) {
        try {
            call_user_func_array(array($controller, $actionName), $params);
        } catch (Exception $ex) {
            throw new \Exception($ex);
        }
    }

    public function redirectToHome() {
        $controllerClass = '\\App\Controller\\HomeController';

        if (!class_exists($controllerClass)) {
            $this->redirectTo404();
            return;
        }

        $controller = new $controllerClass();

        $actionName = 'indexAction';

        self::callController($controller, $actionName, []);
    }

    public function redirectTo404() {
        $controllerClass = '\\App\Controller\\Error404Controller';

        if (!class_exists($controllerClass)) {
            throw new \Exception('Error 404 controller does not exist!');
        }

        $controller = new $controllerClass();

        $actionName = 'indexAction';

        self::callController($controller, $actionName, []);
    }
}
