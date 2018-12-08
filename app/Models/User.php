<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class User
 * @package App\Models
 */
class User extends Eloquent
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'user';
    /**
     * @var array
     */
    protected $fillable = [
        'username',
        'age',
        'details',
        'password',
        'email'
    ];

    public function avatar()
    {
        return $this->hasOne(File::class, 'user_id', 'id');
    }

}