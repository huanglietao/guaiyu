<?php

namespace App\Http\Controllers\Admin;

use App\Http\Business\CourseBusiness;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{

    /**
     * 获取课程列表
     * author hxc
     * @param Request $request
     * @param CourseBusiness $course_business
     * @return array
     */
    public function index(Request $request, CourseBusiness $course_business)
    {
        //获取参数
        $condition = $request->only([
            //列表分页
            'page',
            'page_size',
            'all',
            'sort_column',
            'sort_rule',
        ]);
        $data = $course_business->index($condition);
        return $this->jsonFormat($data);
    }

    /**
     * 获取详情
     * author hxc
     * @param $id
     * @param CourseBusiness $course_business
     * @return array
     */
    public function show($id, CourseBusiness $course_business)
    {
        //获取数据
        $data = $course_business->show($id);
        return $this->jsonFormat($data);
    }

    /**
     * 创建课程
     * author hxc
     * @param Request $request
     * @param CourseBusiness $course_business
     * @return array
     */
    public function create(Request $request, CourseBusiness $course_business)
    {
        $condition = $request->only([
            'classify_id', //'分类id',
            'course_name', //'课程名称',
            'is_pay', // 内容属性，1付费，2免费,
            'cover_url', // '封面图',
            'course_content', // '课程介绍',
            'study_count', // '正在学总数',
            'is_show', //是否显示，1是，2否,
            'sort', //'排序',
        ]);
        //创建课程
        $data = $course_business->create($condition);
        return $this->jsonFormat($data);
    }

    /**
     * 更新课程
     * author hxc
     * @param $id
     * @param Request $request
     * @param CourseBusiness $course_business
     * @return array
     */
    public function update($id, Request $request, CourseBusiness $course_business)
    {
        //
        $condition = $request->only([
            'classify_id', //'分类id',
            'course_name', //'课程名称',
            'is_pay', // 内容属性，1付费，2免费,
            'cover_url', // '封面图',
            'course_content', // '课程介绍',
            'study_count', // '正在学总数',
            'is_show', //是否显示，1是，2否,
            'sort', //'排序',
        ]);
        $data = $course_business->update($id, $condition);
        return $this->jsonFormat($data);
    }

    /**
     * 删除数据
     * author hxc
     * @param $id
     * @param CourseBusiness $course_business
     * @return array
     */
    public function destroy($id, CourseBusiness $course_business)
    {
        //
        $res = $course_business->destory($id);
        return $this->jsonFormat($res);
    }
}
