<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class User extends Model//用户表
{
  	protected $rememberTokenName = NULL;
    protected $table = 'chat_user';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded=[];
}
