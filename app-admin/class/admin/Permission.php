<?php
kirk_require_class("Admin_Header");
class Admin_Permission {
    private $request;

    public function __construct(AdminRequest $request){
        $this->request = $request;
    }

    public static  function get_all_header_permission_list(){
        $all_permission = array(
            array('url' => '/user/adminlist/', 'name' => '管理', 'code' =>'#H4' ),
            array('url' => '/credit/customer/', 'name' => '个人信用', 'code' =>'#H5' ),
            array('url' => '/shuidi/companycontact/', 'name' => '水滴信用', 'code' =>'#H6' ),
            array('url' => '/release/manage/', 'name' => '发布管理', 'code' =>'#H7' ),
            array('url' => '/monitor/shuidi/', 'name' => '系统监控', 'code' =>'#H10' ),
            array('url' => '/data/pamark/', 'name' => '数据分析', 'code' =>'#H11' ),
            array('url' => '/tour/credit-enterprise/', 'name' => '旅游管理', 'code' =>'#H12' ),
            array('url' => '/changepwd/change-password/', 'name' => '修改密码', 'code' =>'#H13' ),
            array('url' => '/site/site-add/', 'name' => '网站认证', 'code' =>'#H14' ),
            array('url' => '/app/app-manage/', 'name' => 'app发布', 'code' =>'#H15' ),
        );
        return $all_permission;
    }
    public function get_allow_header_list(){
        $admin_id = $this->request->get_adminid();
        $permission = $this->request->get_permission();
        $all_list  = $this->get_permission_tree_array();
        $allow_list = array();
        foreach($all_list as $k=>$v) {
            if($permission[$v['code']]) {
                $v['url'] = '';
                foreach($v['child'] as $kk=>$vv) {
                    foreach($vv['child'] as $kkk=>$vvv) {
                        if($permission[$vvv['code']]) {
                            $v['url'] = $vvv['url'];
                            break;
                        }
                    }
                    if($v['url']!='') {
                        break;
                    }
                }
                $allow_list[] = $v;
            }
        }
        return $allow_list;
    }

    public function filter_permission($list) {
        $permission_list = $this->request->get_permission();
        $allow_nav_list = array();
        foreach($list as $k=>$v) {
            if($permission_list[$v['code']]) {
                $allow_list = array();
                foreach($v['child'] as $kk=>$vv) {
                    if($permission_list[$vv['code']]) {
                        $allow_list[] = $vv;
                    }
                }
                $v['child'] = $allow_list;
                $allow_nav_list[] = $v;
            }
        }
        return $allow_nav_list;
    }
    public function get_permission_tree_array(){




        $view_path = CUR_PATH.'/view/admin';
        $dh = opendir($view_path);
        $header_list = self::get_all_header_permission_list();

        $nav_list_assoc = array();
        while($file  = readdir($dh)) {
            if($file=='.' || $file=='..') {
                continue;
            }
            if(is_dir($view_path.'/'.$file)) {
                $className = 'Admin_'.strtoupper(substr($file, 0,1)).substr($file, 1).'_Index';
                rsf_require_view($className);
                $viewClassName = $className.'View';
                $nav_list = $viewClassName::get_nav_list(true);
                $nav_list_assoc[$viewClassName::get_name()] = $nav_list;
            }
        }
        foreach($header_list as $k=>$v) {
            $header_list[$k]['child'] = $nav_list_assoc[$v['name']];
        }
        return $header_list;
    }
    public function get_permission_tree($admin_id=0){
        if(!$admin_id) {
            $permission_list_assoc = $this->request->get_permission();
        } else {
            $bll = new Bll_Admin_User();
            $user = $bll->get_user_by_userid($admin_id);
            $permission_list = explode(",",$user['permission_list']);
            $permission_list_assoc = array();
            foreach($permission_list as $k=>$v) {
                $permission_list_assoc[$v]=1;
            }
        }
        $header_list = $this->get_permission_tree_array();
        $html =  '<ul>';
        foreach($header_list as $k=>$header){
            $html .= '<li class="label label-inverse" style="display:block;margin-bottom:10px;"><label><input type="checkbox" class="permit_checkbox" '.($permission_list_assoc[$header['code']]?'checked':'').'  value="'.$header['code'].'"/>'.$header['name'].'</label>';//header
            $html .= '<ul>';
            foreach($header['child'] as $child) {
                $html .= '<li style="margin-right:10px;display:block;width:150px;float:left;margin-bottom:10px;" class="label label-info"><label><input type="checkbox" class="permit_checkbox"  '.($permission_list_assoc[$child['code']]?'checked':'').'   value="'.$child['code'].'" />'.$child['section'].'</label>';
                $html .= '<ul >';
                foreach($child['child'] as $childchild) {
                    $html .= '<li><label><input type="checkbox" class="permit_checkbox" '.($permission_list_assoc[$childchild['code']]?'checked':'').'  value="'.$childchild['code'].'" />'.$childchild['name'].'</label></li>';
                }
                $html .= '</ul>';

                $html .='</li>';
            }
            $html .='</ul><div class="clearfix"></div>';
            $html .='</li>';
        }
        $html .='</ul>';


        return $html;
    }
}