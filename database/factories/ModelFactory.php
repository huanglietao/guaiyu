
<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/
//课程信息设置
$factory->define(App\Model\Course::class, function (Faker\Generator $faker) {
    //获取配置
    $config = config('fields.course.column');
    //对应配置
    $is_pay_arr = array_column($config['is_pay'], 'code');
    $is_show_arr = array_column($config['is_show'], 'code');
    return [
        //后续关联分类表id
        'classify_id' => 1,
        'course_name' => $faker->title(),
        'is_pay' => $faker->randomElement($is_pay_arr),
        'cover_url' => 'id123',
        'course_content' => $faker->text(),
        'study_count' => $faker->randomNumber(2),
        'is_show' => $faker->randomElement($is_show_arr),
        'sort' => $faker->randomNumber(2),
        'add_time' => date('YmdHis', time())
    ];
});
