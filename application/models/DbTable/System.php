<?php

class Application_Model_DbTable_System extends Application_Model_DbTable_Parent{

    /* samples
    public function checkToken($token,$user_id){
        $p['user_id'] = $user_id;
        $p['token'] = $token;
        $result = $this->scalarSP('check_token(:user_id, :token) cnt', $p, 'cnt');
        return $result;
    }

    public function get_student($student_id){
        $p['student_id_'] = $student_id;
        $result = $this->getSP("get_student('cur', :student_id_)", $p);
        return $result;
    }

    public function get_control_student($student_id){
        $p['student_id'] = $student_id;
        $result = $this->readSP("get_control_student('cur',:student_id)",$p);
        return $result;
    }

    */
    public function check_grant_boolean($grant_code){
        $p['employee_id'] = getCurEmployee();
        $p['grant_code'] = $grant_code;
        $result = $this->scalarSP(__FUNCTION__, "admin.check_grant_boolean(:employee_id, :grant_code) result", $p, "result");
        return $result;
    }

    public function employee_set_last_login(){
        $p['employee_id'] = getCurEmployee();
        $result = $this->execSP(__FUNCTION__, 'admin.employee_set_last_login(:employee_id) id', $p, 'id');
        return $result;
    }

    public function menu_read_for_employee_deleted(){
        $p['employee_id'] = getCurEmployee();
        $result = $this->readSP(__FUNCTION__, "admin.menu_read_for_employee('cur',:employee_id)",$p);
        return $result;
    }
    public function menu_read_recursive($menu_pid, $menu_global_id){
        $p['employee_id'] = getCurEmployee();
        $p['menu_pid'] = $menu_pid;
        $p['menu_global_id'] = $menu_global_id;
        $result = $this->readSP(__FUNCTION__, "admin.menu_read_recursive('cur',:employee_id, :menu_pid, :menu_global_id)",$p);
        return $result;
    }
    public function get_first_menu_action(){
        $p['employee_id'] = getCurEmployee();
        $result = $this->getSP(__FUNCTION__, "admin.get_first_menu_action('cur', :employee_id) result", $p);
        return $result;
    }

    public function read_group(){
        $result = $this->readSP(__FUNCTION__, "admin.read_group('cur')");
        return $result;
    }

    public function get_group($group_id){
        $p['group_id'] = $group_id;
        $result = $this->getSP(__FUNCTION__, "admin.get_group('cur', :group_id)", $p);
        return $result;
    }

    public function upd_group($a){
        $p['group_id'] = $a['group_id'];
        $p['group_name'] = $a['group_name'];
        $p['group_code'] = $a['group_code'];
        $result = $this->execSP(__FUNCTION__, 'admin.upd_group(:group_id, :group_name, :group_code) id', $p, 'id');
        return $result;
    }

    public function del_group($group_id){
        $p['group_id'] = $group_id;
        $result = $this->execSP(__FUNCTION__, 'admin.del_group(:group_id) id', $p, 'id');
        return $result;
    }

    public function menu_read($group_id){
        $p['group_id'] = $group_id;
        $result = $this->readSP(__FUNCTION__, "admin.menu_read('cur', :group_id)", $p);
        return $result;
    }

    public function menu_read_for_select(){
        $result = $this->readSP(__FUNCTION__, "admin.menu_read_for_select('cur')");
        return $result;
    }

    public function get_menu($menu_id){
        $p['menu_id'] = $menu_id;
        $result = $this->getSP(__FUNCTION__, "admin.get_menu('cur', :menu_id)", $p);
        return $result;
    }

    public function upd_menu($a){
        $p['menu_id'] = $a['menu_id'];
        $p['menu_pid'] = null;
        if($a['menu_pid'] > 0){
            $p['menu_pid'] = $a['menu_pid'];
        }
        $p['menu_name'] = $a['menu_name'];
        $p['order_num'] = $a['order_num'];
        $p['menu_action'] = $a['menu_action'];
        $p['is_active'] = $a['is_active'];
        $p['icon'] = $a['icon'];
        $result = $this->execSP(__FUNCTION__, 'admin.upd_menu(:menu_id, :menu_pid, :menu_name, :order_num, :menu_action, :is_active, :icon) id', $p, 'id');
        return $result;
    }

    public function del_menu($menu_id){
        $p['menu_id'] = $menu_id;
        $result = $this->execSP(__FUNCTION__, 'admin.del_menu(:menu_id) id', $p, 'id');
        return $result;
    }

    public function grant_read_for_select(){
        $result = $this->readSP(__FUNCTION__, "admin.grant_read_for_select('cur')");
        return $result;
    }

    public function grant_read($group_id){
        $p['group_id'] = $group_id;
        $result = $this->readSP(__FUNCTION__, "admin.grant_read('cur', :group_id)", $p);
        return $result;
    }

    public function get_grant($grant_id){
        $p['grant_id'] = $grant_id;
        $result = $this->getSP(__FUNCTION__, "admin.get_grant('cur', :grant_id)", $p);
        return $result;
    }

    public function upd_grant($a){
        $p['grant_id'] = $a['grant_id'];
        $p['grant_pid'] = null;
        if($a['grant_pid'] > 0){
            $p['grant_pid'] = $a['grant_pid'];
        }
        $p['grant_name'] = $a['grant_name'];
        $p['order_num'] = $a['order_num'];
        $p['grant_code'] = $a['grant_code'];
        $p['is_active'] = $a['is_active'];
        $result = $this->execSP(__FUNCTION__, 'admin.upd_grant(:grant_id, :grant_pid, :grant_name, :order_num, :grant_code, :is_active) id', $p, 'id');
        return $result;
    }

    public function del_grant($grant_id){
        $p['grant_id'] = $grant_id;
        $result = $this->execSP(__FUNCTION__, 'admin.del_grant(:grant_id) id', $p, 'id');
        return $result;
    }

    public function read_employee($email, $fio){
        $p['email'] = $email;
        $p['fio'] = $fio;
        $result = $this->readSP(__FUNCTION__, "admin.read_employee('cur', :email, :fio)", $p);
        return $result;
    }

    public function get_employee($employee_id){
        $p['employee_id'] = $employee_id;
        $result = $this->getSP(__FUNCTION__, "admin.get_employee('cur', :employee_id)", $p);
        return $result;
    }

    public function block_employee($employee_id){
        $p['employee_id'] = $employee_id;
        $result = $this->scalarSP(__FUNCTION__, "admin.block_employee(:employee_id) result", $p, "result");
        return $result;
    }

    public function unblock_employee($employee_id){
        $p['employee_id'] = $employee_id;
        $result = $this->scalarSP(__FUNCTION__, "admin.unblock_employee(:employee_id) result", $p, "result");
        return $result;
    }

    public function upd_employee($a){
        $p['employee_id'] = $a['employee_id'];
        $p['email'] = $a['email'];
        $p['fio'] = $a['fio'];
        $p['is_active'] = $a['is_active'];
        $p['position_id'] = $a['position_id'];
        $p['phone'] = zeroToNull($a['phone']);
        $result = $this->execSP(__FUNCTION__, 'admin.upd_employee(:employee_id, :email, :fio, :is_active, :position_id, :phone) id', $p, 'id');
        return $result;
    }

    public function del_employee($employee_id){
        $p['employee_id'] = $employee_id;
        $result = $this->execSP(__FUNCTION__, 'admin.del_employee(:employee_id) id', $p, 'id');
        return $result;
    }

    public function group_menu_link($group_id, $menu_id){
        $p['group_id'] = $group_id;
        $p['menu_id'] = $menu_id;
        $result = $this->execSP(__FUNCTION__, 'admin.group_menu_link(:group_id, :menu_id) id', $p, 'id');
        return $result;
    }

    public function group_grant_link($group_id, $grant_id){
        $p['group_id'] = $group_id;
        $p['grant_id'] = $grant_id;
        $result = $this->execSP(__FUNCTION__, 'admin.group_grant_link(:group_id, :grant_id) id', $p, 'id');
        return $result;
    }

    public function employee_group_link($group_id, $employee_id){
        $p['group_id'] = $group_id;
        $p['employee_id'] = $employee_id;
        $result = $this->execSP(__FUNCTION__, 'admin.employee_group_link(:group_id, :employee_id) id', $p, 'id');
        return $result;
    }

    public function employee_city_link($city_id, $employee_id){
        $p['city_id'] = $city_id;
        $p['employee_id'] = $employee_id;
        $result = $this->execSP(__FUNCTION__, 'admin.employee_city_link(:city_id, :employee_id) id', $p, 'id');
        return $result;
    }

    public function group_read($employee_id){
        $p['employee_id'] = $employee_id;
        $result = $this->readSP(__FUNCTION__, "admin.group_read('cur', :employee_id)", $p);
        return $result;
    }

    public function city_read($employee_id){
        $p['employee_id'] = $employee_id;
        $result = $this->readSP(__FUNCTION__, "admin.city_read('cur', :employee_id)", $p);
        return $result;
    }

    public function city_read_for_list(){
        $result = $this->readSP(__FUNCTION__, "admin.city_read_for_list('cur')");
        return $result;
    }

    public function get_city($city_id){
        $p['city_id'] = $city_id;
        $result = $this->getSP(__FUNCTION__, "admin.get_city('cur', :city_id)", $p);
        return $result;
    }

    public function upd_city($a){
        $p['city_id'] = $a['city_id'];
        $p['city_name'] = $a['city_name'];
        $p['city_url_name'] = $a['city_url_name'];
        $p['city_pred_padezh'] = $a['city_pred_padezh'];
        $p['city_full_name'] = $a['city_full_name'];
        $p['bin'] = $a['bin'];
        $p['provider_id'] = null;
        if($a['provider_id'] > 0) {
            $p['provider_id'] = $a['provider_id'];
        }
        $p['is_active'] = 0;
        if($a['is_active'] > 0) {
            $p['is_active'] = $a['is_active'];
        }
        $p['is_online'] = 0;
        if($a['is_online'] > 0) {
            $p['is_online'] = $a['is_online'];
        }
        $p['is_sale_point'] = 0;
        if($a['is_sale_point'] > 0) {
            $p['is_sale_point'] = $a['is_sale_point'];
        }
        $p['bonus_count'] = 0;
        if($a['bonus_count'] > 0) {
            $p['bonus_count'] = $a['bonus_count'];
        }
        $p['mob_bonus_count'] = 0;
        if($a['mob_bonus_count'] > 0) {
            $p['mob_bonus_count'] = $a['mob_bonus_count'];
        }
        $result = $this->execSP(__FUNCTION__, 'admin.upd_city(:city_id, :city_name, :city_url_name, :city_pred_padezh, :city_full_name, :bin, :provider_id, :is_active, :is_online, :is_sale_point, :bonus_count, :mob_bonus_count) id', $p, 'id');
        return $result;
    }

    public function del_city($city_id){
        $p['city_id'] = $city_id;
        $result = $this->execSP(__FUNCTION__, 'admin.del_city(:city_id) id', $p, 'id');
        return $result;
    }

    public function provider_read_for_list(){
        $result = $this->readSP(__FUNCTION__, "admin.provider_read_for_list('cur')");
        return $result;
    }

    public function provider_read_for_select(){
        $result = $this->readSP(__FUNCTION__, "admin.provider_read_for_select('cur')");
        return $result;
    }

    public function okk_read_for_select(){
        $result = $this->readSP(__FUNCTION__, "admin.okk_read_for_select('cur')");
        return $result;
    }

    public function contractor_read_for_select(){
        $result = $this->readSP(__FUNCTION__, "admin.contractor_read_for_select('cur')");
        return $result;
    }

    public function read_product($product_name, $city_id){
        $p['product_name'] = $product_name;
        $p['city_id'] = $city_id;
        $result = $this->readSP(__FUNCTION__, "public.read_product('cur', :product_name, :city_id)", $p);
        return $result;
    }

    public function read_brand(){
        $result = $this->readSP(__FUNCTION__, "public.read_brand('cur')");
        return $result;
    }

    public function read_product_type(){
        $result = $this->readSP(__FUNCTION__, "public.read_product_type('cur')");
        return $result;
    }

    public function read_category(){
        $result = $this->readSP(__FUNCTION__, "public.read_category('cur')");
        return $result;
    }

    public function read_category_group(){
        $result = $this->readSP(__FUNCTION__, "public.read_category_group('cur')");
        return $result;
    }

    public function read_product_for_list($brand_id, $product_type_id, $category_id, $product_name){
        $p['brand_id'] = $brand_id;
        $p['product_type_id'] = $product_type_id;
        $p['category_id'] = $category_id;
        $p['product_name'] = $product_name;
        $result = $this->readSP(__FUNCTION__, "public.read_product_for_list('cur', :brand_id, :product_type_id, :category_id, :product_name)", $p);
        return $result;
    }

    public function read_brand_for_list($brand_name){
        $p['brand_name'] = $brand_name;
        $result = $this->readSP(__FUNCTION__, "public.read_brand_for_list('cur', :brand_name)", $p);
        return $result;
    }

    public function change_password($a){
        $p['employee_id'] = getCurEmployee();
        $p['old_password'] = $a['old_password'];
        $p['new_password'] = $a['new_password'];
        $p['confirm_new_password'] = $a['confirm_new_password'];
        $result = $this->execSP(__FUNCTION__, 'admin.change_password(:employee_id, :old_password, :new_password, :confirm_new_password) id', $p, 'id');
        return $result;
    }

    public function unisender_read_not_send_mail(){
        $result = $this->readSP(__FUNCTION__, "public.unisender_read_not_send_mail('cur')");
        return $result;
    }

    public function unisender_upd_mail($send_email_id, $message_id, $error){
        $p['send_email_id'] = $send_email_id;
        $p['message_id'] = $message_id;
        $p['error'] = $error;
        $result = $this->execSP(__FUNCTION__, 'public.unisender_upd_mail(:send_email_id, :message_id, :error) id', $p, 'id');
        return $result;
    }

    public function unisender_upd_mail_status($message_id, $status){
        $p['message_id'] = $message_id;
        $p['status'] = $status;
        $result = $this->execSP(__FUNCTION__, 'public.unisender_upd_mail_status(:message_id, :status) id', $p, 'id');
        return $result;
    }

    public function unisender_read_send_mail(){
        $result = $this->scalarSP(__FUNCTION__, "public.unisender_read_send_mail() id", array(), 'id');
        return $result;
    }

    public function read_client($client_name, $email, $is_active){
        $p['client_name'] = $client_name;
        $p['email'] = $email;
        $p['is_active'] = $is_active;
        $result = $this->readSP(__FUNCTION__, "admin.read_client('cur', :client_name, :email, :is_active)", $p);
        return $result;
    }

    public function get_client($client_id){
        $p['client_id'] = $client_id;
        $result = $this->getSP(__FUNCTION__, "admin.get_client('cur', :client_id)", $p);
        return $result;
    }

    public function block_client($client_id){
        $p['client_id'] = $client_id;
        $result = $this->scalarSP(__FUNCTION__, "admin.block_client(:client_id) result", $p, "result");
        return $result;
    }

    public function unblock_client($client_id){
        $p['client_id'] = $client_id;
        $result = $this->scalarSP(__FUNCTION__, "admin.unblock_client(:client_id) result", $p, "result");
        return $result;
    }

    public function upd_client($a){
        $p['client_id'] = $a['client_id'];
        $p['client_name'] = $a['client_name'];
        $p['phone_number'] = $a['phone_number'];
        $p['email'] = $a['email'];
        $p['password'] = $a['password'];
        $p['comment'] = $a['comment'];
        $result = $this->execSP(__FUNCTION__, 'admin.upd_client(:client_id, :client_name, :phone_number, :email, :password, :comment) id', $p, 'id');
        return $result;
    }
    public function reset_password($employee_id){
        $p['employee_id'] = $employee_id;
        $result = $this->scalarSP(__FUNCTION__, "admin.reset_password(:employee_id) result", $p, "result");
        return $result;
    }
    public function request_cnt_by_status($client_request_status_id){
        $p['employee_id'] = getCurEmployee();
        $p['client_request_status_id'] = $client_request_status_id;
        $result = $this->scalarSP(__FUNCTION__, 'admin.request_cnt_by_status(:employee_id, :client_request_status_id) cnt', $p, 'cnt');
        return $result;
    }
    public function remont_cnt_by_status($remont_status_id){
        $p['remont_status_id'] = $remont_status_id;
        $p['employee_id'] = getCurEmployee();
        $result = $this->scalarSP(__FUNCTION__, 'admin.remont_cnt_by_status(:remont_status_id, :employee_id) cnt', $p, 'cnt');
        return $result;
    }
    public function remont_cnt_by_status_stage($remont_status_id, $stage_id){
        $p['remont_status_id'] = $remont_status_id;
        $p['stage_id'] = $stage_id;
        $p['employee_id'] = getCurEmployee();
        $result = $this->scalarSP(__FUNCTION__, 'admin.remont_cnt_by_status_stage(:remont_status_id, :stage_id, :employee_id) cnt', $p, 'cnt');
        return $result;
    }
    public function contractor_remont_cnt_by_status($remont_status_id){
        $p['remont_status_id'] = $remont_status_id;
        $p['employee_id'] = getCurEmployee();
        $result = $this->scalarSP(__FUNCTION__, 'admin.contractor_remont_cnt_by_status(:remont_status_id, :employee_id) cnt', $p, 'cnt');
        return $result;
    }
    public function message_cnt_by_status($is_processed){
        $p['is_processed'] = $is_processed;
        $result = $this->scalarSP(__FUNCTION__, 'admin.message_cnt_by_status(:is_processed) cnt', $p, 'cnt');
        return $result;
    }
    public function provider_request_cnt_by_type($type){
        $p['type'] = $type;
        $result = $this->scalarSP(__FUNCTION__, 'admin.provider_request_cnt_by_type(:type) cnt', $p, 'cnt');
        return $result;
    }
    public function request_techproject_cnt($is_completed){
        $p['employee_id'] = getCurEmployee();
        $p['is_completed'] = $is_completed;
        $result = $this->scalarSP(__FUNCTION__, 'admin.request_techproject_cnt(:employee_id, :is_completed) cnt', $p, 'cnt');
        return $result;
    }
    public function read_position(){
        $result = $this->readSP(__FUNCTION__, "admin.read_position('cur')");
        return $result;
    }
    public function read_func($func_name, $grant_id){
        $p['func_name'] = $func_name;
        $p['grant_id'] = $grant_id;
        $result = $this->readSP(__FUNCTION__, "admin.read_func('cur', :func_name, :grant_id)", $p);
        return $result;
    }
    public function grant_func_read($func_id){
        $p['func_id'] = $func_id;
        $result = $this->readSP(__FUNCTION__, "admin.grant_func_read('cur', :func_id)", $p);
        return $result;
    }
    public function func_grant_link($func_id, $grant_id){
        $p['func_id'] = $func_id;
        $p['grant_id'] = $grant_id;
        $result = $this->execSP(__FUNCTION__, 'admin.func_grant_link(:func_id, :grant_id) id', $p, 'id');
        return $result;
    }
    public function fill_func_tab(){
        $result = $this->execSP(__FUNCTION__, 'admin.fill_func_tab() id',array(), 'id');
        return $result;
    }
//    public function grant_read_json($group_id){
//        $p['group_id'] = $group_id;
//        $result = $this->scalarSP(__FUNCTION__, "admin.grant_read_json(:group_id) result", $p, "result");
//        return $result;
//    }
    public function grant_func_read_json($func_id){
        $p['func_id'] = $func_id;
        $result = $this->scalarSP(__FUNCTION__, "admin.grant_func_read_json(:func_id) result", $p, "result");
        return $result;
    }
    public function read_menu_json($group_id){
        $p['group_id'] = $group_id;
        $result = $this->scalarSP(__FUNCTION__, "admin.read_menu_json(:group_id) result", $p, "result");
        return $result;
    }
    public function read_grant_json($group_id){
        $p['group_id'] = $group_id;
        $result = $this->scalarSP(__FUNCTION__, "admin.read_grant_json(:group_id) result", $p, "result");
        return $result;
    }
    public function employee_company_link($company_id, $employee_id){
        $p['company_id'] = $company_id;
        $p['employee_id'] = $employee_id;
        $result = $this->execSP(__FUNCTION__, 'admin.employee_company_link(:company_id, :employee_id) id', $p, 'id');
        return $result;
    }
    public function company_read($employee_id){
        $p['employee_id'] = $employee_id;
        $result = $this->readSP(__FUNCTION__, "admin.company_read('cur', :employee_id)", $p);
        return $result;
    }
    public function read_company_for_select(){
        $result = $this->readSP(__FUNCTION__, "public.read_company_for_select('cur')");
        return $result;
    }
    public function device_check($email, $finger, $code_key){
        $p['email_'] = $email;
        $p['finger_'] = $finger;
        $p['code_key_'] = zeroToNull($code_key);

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $p['ip_address_'] = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $p['ip_address_']  = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $p['ip_address_']  = $_SERVER['REMOTE_ADDR'];
        }
        $result = $this->scalarSP(__FUNCTION__, "shop_main.device_check(:email_, :finger_, :ip_address_, :code_key_) res", $p, 'res');
        return $result;
    }
    public function device_read(){
        $result = $this->readSP(__FUNCTION__, "shop_main.device_read('cur')");
        return $result;
    }
}