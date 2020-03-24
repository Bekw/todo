<?php

class Application_Model_DbTable_Dict extends Application_Model_DbTable_Parent{
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

    public function category_read(){
        $result = $this->readSP(__FUNCTION__, "public.category_read('cur')");
        return $result;
    }
    public function category_for_select_read($stack_id){
        $p['stack_id_'] = $stack_id;
        $result = $this->readSP(__FUNCTION__, "public.category_for_select_read('cur', :stack_id_)", $p);
        return $result;
    }

    public function  category_get($category_id){
        $p['category_id_'] = $category_id;
        $result = $this->getSP(__FUNCTION__, "public.category_get('cur', :category_id_)", $p);
        return $result;
    }

    public function  category_upd($arr){
        $p['category_id_'] = $arr['category_id'];
        $p['category_name_'] = $arr['category_name'];
        $p['order_num_'] = $arr['order_num'];
        $p['category_code_'] = $arr['category_code'];
        $result = $this->execSP(__FUNCTION__, "public.category_upd(:category_id_, :category_name_, :order_num_, :category_code_)", $p);
        return $result;
    }
    public function category_del($category_id){
        $p['category_id_'] = $category_id;
        $result = $this->execSP(__FUNCTION__, "public.category_del(:category_id_)", $p);
        return $result;
    }
    public function category_show_upd($category_id){
        $p['category_id_'] = $category_id;
        $result = $this->execSP(__FUNCTION__, "public.category_show_upd(:category_id_)", $p);
        return $result;
    }
    public function product_type_read(){
        $result = $this->readSP(__FUNCTION__, "public.product_type_read('cur')");
        return $result;
    }

    public function  product_type_get($product_type_id){
        $p['product_type_id_'] = $product_type_id;
        $result = $this->getSP(__FUNCTION__, "public.product_type_get('cur', :product_type_id_)", $p);
        return $result;
    }

    public function  product_type_upd($arr){
        $p['product_type_id_'] = $arr['product_type_id'];
        $p['product_type_name_'] = $arr['product_type_name'];
        $p['order_num_'] = $arr['order_num'];
        $p['product_type_code_'] = $arr['product_type_code'];
        $result = $this->execSP(__FUNCTION__, "public.product_type_upd(:product_type_id_, :product_type_name_,:product_type_code_, :order_num_)", $p);
        return $result;
    }
    public function product_type_del($product_type_id){
        $p['product_type_id_'] = $product_type_id;
        $result = $this->execSP(__FUNCTION__, "public.product_type_del(:product_type_id_)", $p);
        return $result;
    }
    public function product_type_is_show_upd($product_type_id){
        $p['product_type_id_'] = $product_type_id;
        $result = $this->execSP(__FUNCTION__, "public.product_type_is_show_upd(:product_type_id_)", $p);
        return $result;
    }
    public function brand_read(){
        $result = $this->readSP(__FUNCTION__, "public.brand_read('cur')");
        return $result;
    }

    public function  brand_get($brand_id){
        $p['brand_id_'] = $brand_id;
        $result = $this->getSP(__FUNCTION__, "public.brand_get('cur', :brand_id_)", $p);
        return $result;
    }

    public function  brand_upd($arr){
        $p['brand_id_'] = $arr['brand_id'];
        $p['brand_name_'] = $arr['brand_name'];
        $p['order_num_'] = $arr['order_num'];
        $p['brand_code_'] = $arr['brand_code'];
        $result = $this->execSP(__FUNCTION__, "public.brand_upd(:brand_id_, :brand_name_,:brand_code_, :order_num_)", $p);
        return $result;
    }
    public function brand_del($brand_id){
        $p['brand_id_'] = $brand_id;
        $result = $this->execSP(__FUNCTION__, "public.brand_del(:brand_id_)", $p);
        return $result;
    }
    public function brand_is_show_upd($brand_id){
        $p['brand_id_'] = $brand_id;
        $result = $this->execSP(__FUNCTION__, "public.brand_is_show_upd(:brand_id_)", $p);
        return $result;
    }

    public function stack_read(){
        $result = $this->readSP(__FUNCTION__, "public.stack_read('cur')");
        return $result;
    }

    public function  stack_get($stack_id){
        $p['stack_id_'] = $stack_id;
        $result = $this->getSP(__FUNCTION__, "public.stack_get('cur', :stack_id_)", $p);
        return $result;
    }

    public function  stack_upd($arr){
        $p['stack_id_'] = $arr['stack_id'];
        $p['stack_num_'] = $arr['stack_num'];
        $result = $this->execSP(__FUNCTION__, "public.stack_upd(:stack_id_, :stack_num_)", $p);
        return $result;
    }
    public function stack_del($stack_id){
        $p['stack_id_'] = $stack_id;
        $result = $this->execSP(__FUNCTION__, "public.stack_del(:stack_id_)", $p);
        return $result;
    }
    public function stack_category_link($stack_id, $category_id){
        $p['stack_id_'] = $stack_id;
        $p['category_id_'] = $category_id;
        $result = $this->execSP(__FUNCTION__, "public.stack_category_link(:stack_id_, :category_id_) res", $p, 'res');
        return $result;
    }
    public function product_read(){
        $result = $this->readSP(__FUNCTION__, "public.product_read('cur')");
        return $result;
    }
    public function product_get($product_id){
        $p['product_id_'] = $product_id;
        $result = $this->getSP(__FUNCTION__, "public.product_get('cur', :product_id_)", $p);
        return $result;
    }
    public function product_upd($arr){
        $p['product_id_'] = $arr['product_id'];
        $p['product_name_'] = $arr['product_name'];
        $p['category_id_'] = $arr['category_id'];
        $p['brand_id_'] = $arr['brand_id'];
        $result = $this->execSP(__FUNCTION__, "public.product_upd(:product_id_, :product_name_, :category_id_, :brand_id_)", $p);
        return $result;
    }
    public function product_del($product_id){
        $p['product_id_'] = $product_id;
        $result = $this->execSP(__FUNCTION__, "public.product_del(:product_id_)", $p);
        return $result;
    }
    public function category_read_for_select(){
        $result = $this->readSP(__FUNCTION__, "public.category_read_for_select('cur')");
        return $result;
    }
    public function brand_read_for_select(){
        $result = $this->readSP(__FUNCTION__, "public.brand_read_for_select('cur')");
        return $result;
    }
    public function product_type_read_for_select(){
        $result = $this->readSP(__FUNCTION__, "public.product_type_read_for_select('cur')");
        return $result;
    }
    public function product_count_add($product_id, $amount){
        $p['product_id'] = $product_id;
        $p['amount'] = $amount;
        $result = $this->execSP(__FUNCTION__, "public.product_count_add(:product_id, :amount)", $p);
        return $result;
    }

}