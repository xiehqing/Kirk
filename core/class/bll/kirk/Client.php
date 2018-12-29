<?php
namespace Bll\Kirk;
use Bll;

class Client extends Bll {
    # 状态值
    const STATUS_WAIT = 1; // 待审核
    const STATUS_PASS = 2; // 审核通过
    const STATUS_FAIL = 3; // 审核未通过
    const STATUS_DELL = 9; // 删除

    private function get_dao() {
        $dao = new \Dao\Kirk\Client();
        return $dao;
    }

    /**
     * 通过 client_secret 和 app_tag 来检测用户是否合法
     * @param $client_secret
     * @param $app_tag
     * @return bool
     */
    public function checkPassedBySecretAndTag($client_secret, $app_tag){
        $where = [
            'client_secret' => $client_secret,
            'app_tag' => $app_tag,
            'status' => self::STATUS_PASS
        ];
        $data = $this->get_dao()->get_single_by_where($where,'id desc','id');
        if ($data['id']){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 插入数据
     * @param $data
     * @return bool
     */
    public function insertData($data){
        return $this->get_dao()->insert($data);
    }

    /**
     * 通过serect获取client信息
     * @param $secret
     * @return mixed
     */
    public function getUserBySecret($secret){
        $where = [
            'client_secret' => $secret
        ];
        return $this->get_dao()->get_single_by_where($where);
    }


}