<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ModelProvider
 * @package App\Providers
 */
class ModelProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('CourseModel', \App\Model\Course::class);
        $this->app->bind('UsersModel', \App\Model\Users::class);
        $this->app->bind('MemberRoleModel', \App\Model\MemberRole::class);
        $this->app->bind('ProjectMsgModel', \App\Model\ProjectMsg::class);
        $this->app->bind('RolePermissionsModel', \App\Model\RolePermissions::class);
        $this->app->bind('UsersGroupModel', \App\Model\UsersGroup::class);
        $this->app->bind('UsersProjectModel', \App\Model\UsersProject::class);
        $this->app->bind('UsersProjectMemberModel', \App\Model\UsersProjectMember::class);
    }

    /**
     * author hxc
     * @return array
     */
    public function provides()
    {
        return [
            'CourseModel',
            'UsersModel',
            'MemberRoleModel',
            'ProjectMsgModel',
            'RolePermissionsModel',
            'UsersGroupModel',
            'UsersProjectMemberModel',
        ];
    }
}
