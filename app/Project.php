<?php

namespace App;

use App\Lib\Config;
use App\Lib\Database;
use App\Lib\EntityManager;
use App\Lib\Routing;
use App\Lib\Session;

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('BP', dirname(dirname(__FILE__)));

final class Project
{

    protected static $db = null;
    protected static $routing = null;
    protected static $config = array();
    protected static $em = null;

    public static function getBaseDir() {
        return BP . DS;
    }

    public static function getBaseUrl() {
        return sprintf(
            "%s://%s/", isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME']
        );
    }

    public static function getUrl($url = '') {
        return sprintf("%s%s", self::getBaseUrl(), $url
        );
    }

    public static function getDir($path = '') {
        return self::getBaseDir() . $path . DS;
    }

    public static function start()
    {
        Session::init();

        self::initRouting();
        self::initDatabase();
    }

    /**
     * @return  Database
     */
    public static function getDB()
    {
        if (!self::$db) {
            self::initDatabase();
        }

        return self::$db;
    }

    public static function getEntityManager()
    {
        if (!self::$em) {
            self::$em = new EntityManager();
        }

        return self::$em;
    }

    /**
     * @return  Routing
     */
    public static function getRouting()
    {
        if (!self::$routing) {
            self::initRouting();
        }

        return self::$routing;
    }

    /**
     * @param string $configPart
     *
     * @return  Config
     */
    public static function getConfig($configPart)
    {
        if (!isset(self::$config[$configPart]) || (isset(self::$config[$configPart]) && empty(self::$config[$configPart]))) {
            self::$config[$configPart] = new Config($configPart);
        }

        return self::$config[$configPart];
    }

    public static function camelize($name) {
        return self::uc_words($name, '');
    }

    private static function uc_words($str, $destSep = '_', $srcSep = '_') {
        return str_replace(' ', $destSep, ucwords(str_replace($srcSep, ' ', $str)));
    }

    private static function initRouting()
    {
        self::$routing = Routing::prepareRouting();
    }

    private static function initDatabase()
    {
        $dbConfig = self::getConfig('db');

        self::$db = new Database($dbConfig);
    }

}
