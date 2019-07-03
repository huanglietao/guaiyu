<?php

namespace App\Model;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Laravel\Passport\HasApiTokens;

/**
 * @author AdamTyn
 * @description <用户>数据模型
 */
class Users extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasApiTokens;

    /**
     * 绑定数据表
     * @var string
     */
    protected $table = 'gyu_users';

    /**
     * 使用模型时可以访问的字段
     * @var array
     */
    protected $fillable = [
        'username', // '用户名',
        'email', //'邮箱',
        'phone', //'电话',
        'password', // '密码',
        'avatar', //'头像',
        'realname', //'真实姓名',
        'level', // '0',
        'is_admin', // '是否管理员',
        'last_active_at', // '最后一次活跃时间',
        'activated_at' // '在线时间',
    ];

    /**
     * 使用模型无法序列化为JSON时的字段
     * @var array
     */
    protected $hidden = [
        'password',
        'phone',
        'deleted_at',

    ];
    const SENSITIVE_FIELDS = [
        'last_active_at', 'email', 'realname', 'phone',
    ];


    /**
     * 使用Passport用户凭证字段，数据库必须保证该字段的唯一性（默认是email）
     * @var string
     */
    static private $credentials = 'username';

    /**
     * @author AdamTyn
     * @description 使用用户凭证字段查询用户
     *
     * @param $username
     * @return $this
     */
    public function findForPassport($username)
    {

        if (!isset(self::$credentials)) {
            return $this->whereEmail($username)->first();
        }


        return $this->where(self::$credentials, $username)->orWhere('email', $username)->first();
    }
}