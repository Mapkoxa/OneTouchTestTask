<?php
/**
 * Created by PhpStorm.
 * User: bakovma
 * Date: 20.06.2019
 * Time: 15:16
 */
use Illuminate\Database\Capsule\Manager;

$manager = new Manager();

$manager->addConnection([
   'driver'=>'mysql',
    'host'=>'localhost',
    'username'=>'id10022444_mapkoxa',
    'password'=>'qwertyuiop',
    'database'=>'id10022444_testtask',
    'charset'=>'utf8',
    'collation'=>'utf8_unicode_ci'
]);

$manager->bootEloquent();