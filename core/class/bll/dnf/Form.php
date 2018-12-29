<?php
namespace Bll\Dnf;
use Bll;

class Form extends Bll {
    const STATUS_WAIT = 1;
    const STATUS_PASS = 2;
    const STATUS_FAIL = 3;
    const STATUS_DELL = 9;

    private function get_dao() {
        $dao = new \Dao\Dnf\Form();
        return $dao;
    }

    /**
     * 添加数据
     * @param $data
     * @return bool
     */
    public function addData($data){
        return $this->get_dao()->insert($data);
    }

    /**
     * 通过 client_secret 和 form_name 来获取表单数据（通过审核的）
     * @param $clientSecret
     * @param $formName
     * @return mixed
     */
    public function getPassedBySecretAndFormName($clientSecret,$formName){
        $where = [
            'client_secret' => $clientSecret,
            'form_name' => $formName,
            'status' => self::STATUS_PASS
        ];
        return $this->get_dao()->get_single_by_where($where,"id desc");
    }

}