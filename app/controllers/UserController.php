<?php

namespace App\Controller;


use App\Lib\Controller;
use App\Lib\Security;
use App\Project;

class UserController extends Controller
{

    public function registerAction() {

        $this->setTitle('Register');

        $error = '';

        if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name'])) {
            $email = $_POST['email'];
            $name = $_POST['name'];
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];

            if ($email && $name && $password && $repassword) {
                if ($password != $repassword) {
                    $error = 'Passwords are different.';
                }
                else {
                    $em = Project::getEntityManager();

                    $created = new \DateTime();

                    $entity = $em->insert('App\Entity\UserEntity', array(
                        'name' => $name,
                        'email' => $email,
                        'password' => Security::generatePassword($password),
                        'status' => 1,
                        'created' => $created->format('Y-m-d H:i:s'),
                        'updated' => $created->format('Y-m-d H:i:s')
                    ));

                    if (!$entity) {
                        $error = 'Was an error during register, please try again.';
                    }
                }
            }
            else {
                $error = 'Please enter valid values.';
            }
        }

        $this->renderTemplate('user/register.php', array(
            'error' => $error
        ));
    }
}