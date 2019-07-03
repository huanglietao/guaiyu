<?php
/**
 * Created by PhpStorm.
 * User: hxc
 * Date: 2019/3/17 0017
 * Time: 上午 9:45
 */
namespace App\Http\Business;

use App\Http\Business\Dao\CourseDao;

class CourseBusiness extends BusinessBase
{
    protected $course_dao = null;
    public function __construct(CourseDao $course_dao)
    {
        $this->course_dao = $course_dao;
    }

    /**
     * 列表查询
     * author hxc
     * @param array $condition
     * @return mixed
     */
    public function index(array $condition)
    {
        //关联关系
        $relatives = [];
        //查询的字段
        $select_column = ['*'];
        return $this->course_dao->index($condition, $select_column, $relatives);
    }

    /**
     * 获取详情
     * author hxc
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        //关联关系
        $relatives = [];
        //查询的字段
        $select_column = ['*'];
        return $this->course_dao->show($id, $select_column, $relatives);
    }

    /**
     * 创建课程
     * author hxc
     * @param $data
     * @return \Laravel\Lumen\Application|mixed
     */
    public function create($data)
    {
        return $this->course_dao->create($data);
    }

    /**
     * 更新课程
     * author hxc
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        return $this->course_dao->update($id, $data);
    }

    /**
     * 删除课程
     * author hxc
     * @param $id
     * @return mixed
     */
    public function destory($id)
    {
        return $this->course_dao->destory($id);
    }
}
