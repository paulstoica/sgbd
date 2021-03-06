<?php

namespace App\Lib;

use App\Entity\UserEntity;
use App\Project;

class Security
{
    /**
     * Return Logged User
     *
     * @return UserEntity|null
    */
    public static function getLoggedUser() {
        $loggedUserId = Session::get('logged_user');

        if (!$loggedUserId) {
            return null;
        }

        $em = Project::getEntityManager();

        $user = $em->get('App\Entity\UserEntity', intval($loggedUserId));

        return $user;
    }

    /**
     * Return tru is user is logged or false otherwise
     *
     * @return boolean
     */
    public static function isLoggedUser() {
        return Session::has('logged_user');
    }

    public static function generatePassword($password) {

        // A higher "cost" is more secure but consumes more processing power
        $cost = 10;

        // Create a random salt
        $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

        // Prefix information about the hash so PHP knows how to verify it later.
        // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
        $salt = sprintf("$2a$%02d$", $cost) . $salt;


        // Hash the password with the salt
        $hash = crypt($password, $salt);

        return $hash;

    }

    public static function checkPasswordForUser($password, UserEntity $user) {

        if ( hash_equals($user->getPassword(), crypt($password, $user->getPassword())) ) {
            return true;
        }

        return false;

    }
}

if(!function_exists('hash_equals'))
{
    function hash_equals($str1, $str2)
    {
        if(strlen($str1) != strlen($str2))
        {
            return false;
        }
        else
        {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--)
            {
                $ret |= ord($res[$i]);
            }
            return !$ret;
        }
    }
}