<?php
/**
 * Created by PhpStorm.
 * User: bakovma
 * Date: 20.06.2019
 * Time: 11:59
 */

class Controller
{
    protected $app;

    public function __construct($app)
    {
        $this->app=$app;
    }

    public function view($view,$data=[])
    {
        if(file_exists("../app/views/{$view}.php"))
        {

            require_once "../app/views/{$view}.php";
        }
    }

}