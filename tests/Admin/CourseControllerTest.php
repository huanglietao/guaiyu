<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/19 0019
 * Time: 上午 11:12
 */

namespace Admin;

use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;

class CourseControllerTest extends TestCase
{
//    use DatabaseTransactions;

    private $base = 'admin/V1/course/';

    /**
     * test列表
     * author hxc
     */
    public function testIndex()
    {
        //获取列表
        $url = $this->base . '?' . http_build_query([
                'page' => 2,
                'page_size' => 2,
                'sort_column' => 'sort',
                'sort_rule' => 'desc',
            ]);
        $response = $this->get($url);
        $this->assertResponseOk();
        $this->apiStructure($response);
    }

    /**
     * test获取详情
     * author hxc
     */
    public function testShow()
    {
        $course_res = factory(\App\Model\Course::class)->create();
        //拼装url
        $url = $this->base . $course_res->id;
        $response = $this->get($url);
        $this->assertResponseOk();
        $this->apiStructure($response);
    }

    /**
     * test创建课程
     * author hxc
     */
    public function testCreate()
    {
        $course_res = factory(\App\Model\Course::class)->create();
        $url = $this->base . 'create';
        //数据
        $post_data = [
            'classify_id' => $course_res->classify_id, //'分类id',
            'course_name' => $course_res->course_name,//'课程名称',
            'is_pay' => $course_res->is_pay, // 内容属性，1付费，2免费,
            'cover_url' => $course_res->cover_url, // '封面图',
            'course_content' => $course_res->course_content, // '课程介绍',
            'study_count' => $course_res->study_count, // '正在学总数',
            'is_show' => $course_res->is_show, //是否显示，1是，2否,
            'sort' => $course_res->sort, //'排序',
        ];

        $response = $this->post($url, $post_data);
        $this->assertResponseOk();
        $this->apiStructure($response);
    }

    /**
     * 更新信息
     * author hxc
     */
    public function testUpdate()
    {
        $course_res = factory(\App\Model\Course::class)->create();
        $url = $this->base . $course_res->id;
        $put_data = [
            'classify_id' => $course_res->classify_id, //'分类id',
            'course_name' => $course_res->course_name,//'课程名称',
            'is_pay' => $course_res->is_pay, // 内容属性，1付费，2免费,
            'cover_url' => $course_res->cover_url, // '封面图',
            'course_content' => $course_res->course_content, // '课程介绍',
            'study_count' => $course_res->study_count, // '正在学总数',
            'is_show' => $course_res->is_show, //是否显示，1是，2否,
            'sort' => 1000, //'排序',
        ];
        $response = $this->put($url, $put_data);
        $this->assertResponseOk();
        $this->apiStructure($response);
    }

    /**
     * 测试删除
     * author hxc
     */
    public function testDestroy()
    {
        $course_res = factory(\App\Model\Course::class)->create();
        $url = $this->base . $course_res->id;
        $response = $this->delete($url);
        $this->assertResponseOk();
        $this->apiStructure($response);

    }
}