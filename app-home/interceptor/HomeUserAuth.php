<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-20
 * Time: 上午11:01
 */
kirk_require_class('GlobalFun');
kirk_require_interceptor('Interceptor');

class HomeUserAuth extends Interceptor {
    public function go_next() {
        $request = KIRK::get_instance()->get_request();

        if (!$request instanceof HomeRequest){
            return true;
        }

        $response = KIRK::get_instance()->get_response();
        $user_id = $request->get_cookie('home_user_id');
        $token = $request->get_cookie('home_uid_token');

        if ($user_id != ''){
            if (GlobalFun::sign($user_id) == $token){
                $request->set_uid($user_id);
                $user_bll = new Bll_Home_User();
                $user_name = $user_bll->get_user_name_by_user_id($user_id);
                $request->set_attribute("p_user_name", $user_name);
                $vip_bll = new Bll_Home_PersonVip();
                $is_vip = $vip_bll->check_person_vip($user_id);
                if($is_vip) {
                    $request->set_vip(1);
                }
            }
        }
        return true;
    }

    public function broken() {
        exit('You are not allowed!');
    }
}