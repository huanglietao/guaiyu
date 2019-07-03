<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolePermissions extends Model
{
    //
    use SoftDeletes;

    /**
     * 表名
     * @var string
     */
    protected $table = 'role_permissions';

    /**
     * 可写字段
     * @var array
     */
    protected $fillable = [
        'permissions-url', //'角色名称',
        'descirbe', // '用户id',
        'role_id', // ' 权限id',
    ];

    protected $hidden = [
        'deleted_at'
    ];
}
