<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberRole extends Model
{
    //
    use SoftDeletes;

    /**
     * 表名
     * @var string
     */
    protected $table = 'member_role';

    /**
     * 可写入字段
     * @var array
     */
    protected $fillable = [
        'role_name', //  '角色名称',
        'descirbe', // '用户id',
        'is_disable' // '是否开放1:禁用2:不禁用',
    ];

    protected $hidden = [
        'deleted_at'
    ];

}
