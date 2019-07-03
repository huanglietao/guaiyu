<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersProject extends Model
{
    //
    use SoftDeletes;

    /**
     *  表名
     * @var string
     */
    protected $table = 'users_project';

    /**
     * 可写字段
     * @var array
     */
    protected $fillable = [
        'project_name', // '项目名称',
        'describe', //'描述',
        'is_public', // '是否开放1:开放2:不开放',
        'group_id', //'组id',
    ];

}
