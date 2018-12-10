<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->create('files', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('user_id')->unsigned();
    $table->string('url'); //varchar 255
    $table->foreign('user_id')->references('id')->on('user')
        ->onUpdate('cascade')->onDelete('cascade');
    $table->engine = 'InnoDB';
});
