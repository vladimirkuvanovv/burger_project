<?php
require '../vendor/autoload.php';

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

require 'config.php';

//Capsule::schema()->dropIfExists('flights');

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
//=========================

//Capsule::schema()->table('flights', function (Blueprint $table) {
//    $table->string('bortname');
//});
Capsule::schema()->create('files', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('user_id')->unsigned();
    $table->string('url'); //varchar 255
    $table->foreign('user_id')->references('id')->on('user');
    $table->engine = 'InnoDB';
});

