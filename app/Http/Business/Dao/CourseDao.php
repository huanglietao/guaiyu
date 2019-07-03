<?php
/**
 * Created by PhpStorm.
 * User: hxc
 * Date: 2019/3/17 0017
 * Time: 下午 10:19
 */

namespace App\Http\Business\Dao;

use App\Exceptions\JsonException;

class CourseDao extends DaoBase
{
    /**
     * 列表获取
     * author hxc
     * @param array $condition
     * @param array $select_column
     * @param array $relatives
     */
    public function index(array $condition, array $select_column = ['*'], array $relatives = [])
    {
        $model = app('CourseModel');

        $builder = $model->select($select_column);

        //排序
        if (!empty($condition['sort_column']) && !empty($condition['sort_rule'])) {
            $builder->orderBy($condition['sort_column'], $condition['sort_rule']);
        } else {
            $builder->orderBy('id', 'desc');
        }

        //每页个数
        $page_size = isset($condition['page_size']) && $condition['page_size'] > 0 ? $condition['page_size'] : config('site.page_size');

        //分组
        if (isset($condition['group'])) {
            $builder->groupBy($condition['group']);
        }

        //预加载关系
        if (!empty($relatives)) {
            $builder = $builder->with($relatives);
        }
        //全部
        if (isset($condition['all']) && $condition['all'] == 'true') {
            $colletion = $builder->get();
        } else {
            $colletion = $builder->paginate($page_size);
        }

        return $colletion;
    }

    /**
     *  获取详情
     * author hxc
     * @param $id
     * @param array $select_column
     * @param array $relatives
     * @return mixed
     * @throws JsonException
     */
    public function show($id, array $select_column = ['*'], array $relatives = [])
    {
        $model = app('CourseModel');

        $builder = $model->select($select_column);

        //关联关系
        if (!empty($relatives)) {
            $builder = $builder->with($relatives);
        }

        $data = $builder->find($id);
        if (empty($data)) {
            throw new JsonException(11000);
        }
        return $data;
    }

    /**
     * 创建课程
     * author hxc
     * @param array $data
     * @return \Laravel\Lumen\Application|mixed
     * @throws JsonException
     */
    public function create(array $data)
    {
        //字段配置
        $column_config = config('fields.course.column');

        $is_show_str = implode(',', array_column($column_config['is_show'], 'code'));
        $is_pay_str = implode(',', array_column($column_config['is_pay'], 'code'));
        //字段验证
        $rule = [
            'classify_id' => ['required', 'numeric', 'min:1'],
            'course_name' => ['required', 'string'],
            'is_pay' => ['required', 'numeric', 'in:' . $is_pay_str],
            'cover_url' => ['required', 'string'],
            'course_content' => ['required', 'string'],
            'is_show' => ['required', 'numeric', 'in:' . $is_show_str],
        ];
        //验证
        $validate = app('validator')->make($data, $rule);
        if ($validate->fails()) {
            throw new JsonException(10000, $validate->messages());
        }
        //model
        $model = app('CourseModel');

        $model->add_time = date("YmdHis", time());
        $model->fill($data);
        //保存
        if (!$model->save()) {
            throw new JsonException(11001);
        }
        return $model;
    }

    /**
     * 更新数据
     * author hxc
     * @param $id
     * @param array $data
     * @return mixed
     * @throws JsonException
     */
    public function update($id, array $data)
    {
        if (empty($id) || !is_numeric($id)) {
            throw new JsonException(10000);
        }
        //获取配置
        $column_config = config('fields.course.column');
        $is_show_str = implode(',', array_column($column_config['is_show'], 'code'));
        $is_pay_str = implode(',', array_column($column_config['is_pay'], 'code'));

        //字段验证
        $rule = [
            'classify_id' => ['sometimes', 'numeric', 'min:1'],
            'course' => ['sometimes', 'string'],
            'is_pay' => ['sometimes', 'numeric', 'in:' . $is_pay_str],
            'cover_url' => ['sometimes', 'string'],
            'course_content' => ['sometimes', 'string'],
            'is_show' => ['sometimes', 'numeric', 'in:' . $is_show_str],
            'sort' => ['sometimes', 'numeric'],
        ];
        //验证
        $validate = app('validator')->make($data, $rule);
        if ($validate->fails()) {
            throw new JsonException(10000, $validate->messages());
        }
        //获取数据
        $course_data = app('CourseModel')
            ->select(['*'])
            ->find($id);
        if (empty($course_data)) {
            throw new JsonException(11000);
        }

        $course_data->fill($data);
        //更新保存
        if (!$course_data->save()) {
            throw new JsonException(11001);
        }

        return $course_data;
    }

    /**
     * 删除数据
     * author hxc
     * @param $id
     * @return mixed
     * @throws JsonException
     */
    public function destory($id)
    {
        if (empty($id) || !is_numeric($id)) {
            throw new JsonException(10000);
        }
        //删除
        $del_status = app('CourseModel')
            ->where('id', '=', $id)
            ->delete();
        if (!$del_status) {
            throw new JsonException(11003);
        }
        return $del_status;
    }
}
