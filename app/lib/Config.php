<?php

namespace App\Lib;

use App\Project;

class Config
{

    protected $config = array();

    public function __construct($part = '')
    {
        $this->prepareConfig($part);
    }

    public function get($key, $default = null)
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }

        return $default;
    }

    public function all()
    {
        return $this->config;
    }

    private function prepareConfig($part) {
        $file = $this->getConfigFile($part);

        if (file_exists($file)) {
            $xml = simplexml_load_file($file);

            $this->config = new \ArrayIterator((array)$xml);
        } else {
            throw new \Exception('Failed to open config file: "' . $part .'.xml".');
        }
    }

    private function getConfigFile($part) {
        if ($part) {
            return Project::getDir('app/config') . $part . '.xml';
        }
        return Project::getDir('app/config') . 'config.xml';
    }

}
