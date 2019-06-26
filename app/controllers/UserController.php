<?php
/**
 * Created by PhpStorm.
 * User: bakovma
 * Date: 21.06.2019
 * Time: 9:33
 */

class UserController extends Controller
{
    private $login = 'admin';
    private $password='123';

    public function Login()
    {
        $login = $_POST['username'];
        $password = $_POST['password'];
        if($login==$this->login && $password==$this->password)
        {
           $_SESSION["isAdmin"]=true;
        }
        header('Location: /');
    }

    public function Logout()
    {
        $_SESSION["isAdmin"]=false;
        header('Location: /');
    }
}