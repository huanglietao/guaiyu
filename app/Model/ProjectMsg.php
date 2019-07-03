<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectMsg extends Model
{
    use SoftDeletes;

    /**
     * 表名
     * @var string
     */
    protected $table = 'project_msg';

    /**
     * 可写字段
     * @var array
     */
    protected $fillable = [
        'project_id', // '项目id',
        'user_id', // '用户id',
        'is_public', // '是否开放1:开放2:不开放',
        'img_url', //' 图片url',
        'img_content', // '图片内容',
    ];

    protected $hidden = [
        'deleted_at'
    ];
}
