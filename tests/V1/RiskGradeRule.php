<?php

namespace V1;

use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;

/**
 * Class RiskGradeRuleTest
 * @package V1
 */
class RiskGradeRule extends TestCase
{
    use DatabaseTransactions;

    private $base = 'api/v1/risk-level-set/';

    /**
     *  保存风险等级设置规则
     * author hxc
     */
    public function t1estStoreRiskLevelRule()
    {
        $risk_grade_rule = factory(\App\Model\RiskGradeRule::class)->create();
        $url = $this->base . 'store-risk-level-rule';
        //数据
        $post_data = [
            'is_open'           => $risk_grade_rule->is_open,
            'modify_grade'      => $risk_grade_rule->modify_grade,
            'modify_department' => $risk_grade_rule->modify_department,
            'create_area'       => $risk_grade_rule->create_area,
        ];
        $response = $this->post($url, $post_data);
        $this->assertResponseOk();
        $this->apiStructure($response);
    }

    /**
     *  保存风险等级设置规则
     * author hxc
     */
    public function t1estGetRiskLevelRule()
    {
        $risk_grade_rule = factory(\App\Model\RiskGradeRule::class)->create();
        $url = $this->base . 'get-risk-level-rule?'.http_build_query([
                'create_area'  => $risk_grade_rule->create_area
            ]);
        //数据
        $response = $this->get($url);

        $this->assertResponseOk();
        $this->apiStructure($response);
    }
}