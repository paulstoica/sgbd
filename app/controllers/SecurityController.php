<?php

namespace App\Controller;


use App\Lib\Controller;
use App\Lib\Security;
use App\Lib\Session;
use App\Project;

class SecurityController extends Controller
{

    public function loginAction() {

        $this->setTitle('Login');

        $error = '';

        $isAlreadyLogged = Session::has('logged_user');

        if (!$isAlreadyLogged && isset($_POST['email']) && isset($_POST['password'])) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($email && $password) {
                $em = Project::getEntityManager();

                $user = $em->getOneBy('App\Entity\UserEntity', array(
                    'email' => $email
                ));

                if ($user && Security::checkPasswordForUser($password, $user)) {
                    Session::set('logged_user', $user->getId());

                    $this->redirectTo('');
                }

                if (!$user) {
                    $error = 'This email is not valid.';
                }

                if ($user && !Security::checkPasswordForUser($password, $user)) {
                    $error = 'Password is not valid for this email, please try again.';
                }
            } else {
                $error = 'Please enter email and password.';
            }
        }
        elseif ($isAlreadyLogged) {
            throw new \Exception('A user is already logged');
        }

        $this->renderTemplate('security/login.php', array(
           'error' => $error
        ));


    }

    public function logoutAction() {
        if (Session::has('logged_user')) {
            Session::unsetSession('logged_user');
        }

        $this->redirectTo('');
    }
}