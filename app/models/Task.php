<?php
/**
 * Created by PhpStorm.
 * User: bakovma
 * Date: 20.06.2019
 * Time: 15:13
 */

class Task extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 'Task';

    protected $fillable = ['username','text','header','image','isClose','email'];

    protected $dates =['updated_at','created_at'];

    protected $attributes = [
        'isClose' => false,
    ];
}