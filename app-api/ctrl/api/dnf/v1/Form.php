<?php
namespace Api\Dnf\V1;
use Api\Dnf\BaseCtrl;

/**
 * DNF社区-问卷表单类
 * Class DnfFormCtrl
 * @package Api\Form\V1
 */
class FormCtrl extends BaseCtrl{

    /**
     * @param $params
     * @param $request
     * @return array
     */
    public function test($params, $request){
        $data = "测试成功！";
        return $this->success($data);
    }

    /**
     * @param $params
     * @param \ApiRequest $request
     * @return array
     */
    public function createForm($params,$request){
        // 参数过滤
        $params = $this->filterParams($params);
        $client_secret = $params['secret'];
        $sequence_number = $params['sequenceNumber'];
        $app_tag = $params['appTag'];
        $form_name = $params['formName'];
        $content_name = $params['contentName'];
        $form_type = $params['formType'];

        if (empty($app_tag) || empty($sequence_number) || empty($form_name) || empty($content_name) || empty($form_type)){
            return $this->error(1,'参数缺失');
        }
        # content_name 是各个字段名称，用英文逗号隔开。eg：name,age,sex,job
        # content_type 是各个字段类型，用英文逗号隔开。eg:varchar,varchar,tinyint,varchar
        if (!$this->isSameLength($content_name,$form_type)){
            return $this->error(2,'参数有误');
        }

        # 校验appTag
        $bllClient = new \Bll\Kirk\Client();
        if(!$bllClient->checkPassedBySecretAndTag($client_secret, $app_tag)){
            return $this->error(2,"用户身份不合法");
        }

        $pinyincls = new \Core\PinYinCls();
        $data['en_name']= $pinyincls->pinyinFirstChar('','',$form_name);
        $data['form_name'] = $form_name;
        $data['form_content'] = $content_name;
        $data['form_type'] = $form_type;
        $data['sequence_number'] = $sequence_number;
        $bllForm = new \Bll\Dnf\Form();
        $flag = $bllForm->addData($data);
        if ($flag){
            return $this->success();
        }else{
            return $this->error(3,"添加数据失败");
        }

    }

    /**
     * @param $params
     * @param \ApiRequest $request
     * @return array
     */
    public function postData($params, $request){
        $params = $this->filterParams($params);
        $client_secret = $params['secret'];
        $sequence_number = $params['sequenceNumber'];
        $app_tag = $params['appTag'];
        $form_name = $params['formName'];
        $form_content = $params['formContent'];

        if (empty($app_tag) || empty($sequence_number) || empty($form_name) || empty($form_content)){
            return $this->error(1,'参数缺失');
        }

        # 校验appTag
        $bllClient = new \Bll\Kirk\Client();
        if(!$bllClient->checkPassedBySecretAndTag($client_secret, $app_tag)){
            return $this->error(2,"用户身份不合法");
        }

        # 通过$client_secret 和 $form_name 获取表单数据
        $bllForm = new \Bll\Dnf\Form();
        $formData = $bllForm->getPassedBySecretAndFormName($client_secret, $form_name);
        $enName = $formData['en_name'];
        if (!$enName){
            return $this->error(3,'暂未查到该表单');
        }
        $formDataKey = explode(",",$formData['form_content']);
        $postDataValue = explode(",",$form_content);
        foreach ($formDataKey as $key => $value){
            $data[$value] = $postDataValue[$key];
        }
        $bllCtrl = "\Bll\Dnf\{$enName}()";
        $bllTable = new $bllCtrl;
        $bllTable->insert($data);
    }

    /**
     * @param $params
     * @param \ApiRequest $request
     */
    public function getFromData($params, $request){

    }

}