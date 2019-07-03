<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersGroup extends Model
{
    //
    use SoftDeletes;

    /**
     * 表名
     * @var string
     */
    protected $table = 'users_group';

    /**
     * 可写字段
     * @var array
     */
    protected $fillable = [
        'group_name', // '组名称',
        'describe', // '描述',
        'is_public', // '是否开放1:开放2:不开放',
        'user_id', //'用户id',
        'group_avatar', //组头像,
    ];

}
