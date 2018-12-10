<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('user', function (Blueprint $table) {
    $table->increments('id');
    $table->string('username'); //varchar 255
    $table->integer('age')->unsigned(); //varchar 255
    $table->string('details')->nullable();
    $table->string('password');
    $table->string('email')->unique();
    $table->engine = 'InnoDB';
//    $table->timestamps(); //created_at&updated_at тип datetime
});