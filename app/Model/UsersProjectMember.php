<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersProjectMember extends Model
{
    //
    use SoftDeletes;

    protected $table = 'users_project_member';
    /**
     * 可写字段
     * @var array
     */
    protected $fillable = [
        'project_id', //'项目id',
        'user_id', //'用户id',
        'is_public', //'是否开放1:开放2:不开放',
        'role_id', //'权限id',
    ];

    protected $hidden = [
        'deleted_at'
    ];

}
