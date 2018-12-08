<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class File
 * @package App\Models
 */
class File extends Eloquent
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'files';
    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'url'
    ];
}