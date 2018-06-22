<?php
/**
 * Created by PhpStorm.
 * User: kirk
 * Date: 18-6-22
 * Time: 上午11:40
 */
kirk_require_class('Admin_Header');

class Admin_Permission {
    private $request;

    public function __construct(AdminRequest $request) {
        $this->request = $request;
    }

    public static function get_all_header_permission_list() {
        $all_permissiom = array(
            array('url' => '' , 'name' => '','code' =>''),
            array('url' => '' , 'name' => '','code' =>''),
            array('url' => '' , 'name' => '','code' =>''),
            array('url' => '' , 'name' => '','code' =>''),
            array('url' => '' , 'name' => '','code' =>''),
            array('url' => '' , 'name' => '','code' =>''),
            array('url' => '' , 'name' => '','code' =>''),
        );
        return $all_permissiom;
    }

    public function get_allow_header_list() {
        $admin_id = $this->request->get_adminid();
        $permission = $this->request->get_permission();
        $all_list = $this->get_permission_tree_array();
        $allow_list = array();
        foreach ($all_list as $item => $value) {
            if ($permission[$value['code']]) {
                $value['url'] = '' ;
                foreach ($value['child'] as $item2 => $value2) {
                    foreach ($value2['child'] as $item3 => $value3) {
                        $value['url'] = $value3['url'];
                        break;
                    }
                }
                $allow_list[] = $value;
            }
        }
        return $allow_list;
    }

    public function filter_permission($list) {
        $permission_list = $this->request->get_permission();
        $allow_nav_list = array();
        foreach ($list as $item => $value) {
            if ($permission_list[$value['code']]) {
                $allow_list = array();
                foreach ($value['child'] as $item2 => $value2) {
                    if ($permission_list[$value2['code']]) {
                        $allow_list[] = $value2;
                    }
                }
                $value['child'] = $allow_list;
                $allow_nav_list[] = $value;
            }
        }
        return $allow_nav_list;
    }

    public function get_permission_tree_array() {
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
                kirk_require_view($className);
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
            $bll_admin_user = new \Bll\Admin\User();
            $user = $bll_admin_user->get_user_by_id($admin_id);
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