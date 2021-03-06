<?php

namespace App\Lib;

use App\Project;

class Controller
{

    protected $title;

    public function renderTemplate($templatePath, array $params = array()) {
        $templatePath = Project::getDir('app/views') . $templatePath;

        extract($params);

        if(!file_exists($templatePath)) {
            throw new \Exception('There are no template with path "' . $templatePath . '"  to render.');
        }

        include $templatePath;
    }

    public function redirectTo($url) {
        header('Location: ' . Project::getUrl($url));
        die();
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }
}