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
        $p['product_type_id_'] = $arr['product_type_id'];
        $result = $this->execSP(__FUNCTION__, "public.category_upd(:category_id_, :category_name_, :order_num_, :category_code_, :product_type_id_)", $p);
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
    public function product_read($category_id, $product_type_id, $brand_id){
        $p['category_id'] = $category_id;
        $p['product_type_id'] = $product_type_id;
        $p['brand_id'] = $brand_id;
        $result = $this->readSP(__FUNCTION__, "public.product_read('cur', :category_id, :product_type_id, :brand_id)", $p);
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
        $p['category_id_'] = zeroToNull($arr['category_id']);
        $p['brand_id_'] = zeroToNull($arr['brand_id']);
        $p['barcode_'] = $arr['barcode'];
        $p['price_'] = zeroToNull($arr['price']);
        $result = $this->execSP(__FUNCTION__, "public.product_upd(:product_id_, :product_name_, :category_id_, :brand_id_, :barcode_, :price_)", $p);
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
    public function stack_for_select_read($category_id){
        $p['category_id'] = $category_id;
        $result = $this->readSP(__FUNCTION__, "public.stack_for_select_read('cur', :category_id)", $p);
        return $result;
    }
    public function product_stack_read($product_id){
        $p['product_id'] = $product_id;
        $result = $this->readSP(__FUNCTION__, "public.product_stack_read('cur', :product_id)", $p);
        return $result;
    }
    public function product_stack_upd($a){
        if(isset($a['stack_id'])){
            foreach ($a['stack_id'] as $key1 => $value1){
                $q['product_id'] = $a['product_id'];
                $q['stack_id'] = $a['stack_id'][$key1];
                $q['product_stack_id'] = $key1;
                $result = $this->execSP(__FUNCTION__, "public.product_stack_upd(:product_stack_id, :product_id, :stack_id)", $q);
            }
        }
        if(isset($a['product_stack_new'])){
            foreach ($a['product_stack_new'] as $key => $value){
                $p['product_id'] = $a['product_id'];
                $p['stack_id'] = $a['product_stack_new'][$key];
                $p['product_stack_id'] = $a['product_stack_id_new'][$key];
                $result = $this->execSP(__FUNCTION__, "public.product_stack_upd(:product_stack_id, :product_id, :stack_id)", $p);
            }
        }
        return $result;
    }
    public function product_stack_del($product_stack_id){
        $p['product_stack_id'] = $product_stack_id;
        $result = $this->execSP(__FUNCTION__, 'public.product_stack_del(:product_stack_id)', $p);
        return $result;
    }
    public function lot_read($date_begin, $date_end, $product_name, $is_active){
        $p['date_begin'] = zeroToNull($date_begin);
        $p['date_end'] = zeroToNull($date_end);
        $p['product_name'] = $product_name;
        $p['is_active'] = $is_active;
        $result = $this->readSP(__FUNCTION__, "public.lot_read('cur', to_date(:date_begin, 'dd.mm.yyyy'), to_date(:date_end, 'dd.mm.yyyy'), :product_name, :is_active)", $p);
        return $result;
    }
    public function lot_get($lot_id){
        $p['lot_id'] = $lot_id;
        $result = $this->getSP(__FUNCTION__, "public.lot_get('cur', :lot_id)", $p);
        return $result;
    }
    public function lot_del($lot_id){
        $p['lot_id'] = $lot_id;
        $result = $this->execSP(__FUNCTION__, "public.lot_del(:lot_id)", $p);
        return $result;
    }
    public function lot_upd($a){
        $p['lot_id'] = $a['lot_id'];
        $p['product_id'] = $a['product_id'];
        $p['amount'] = $a['amount'];
        $p['lot_date'] = $a['lot_date'];
        $p['employee_id'] = getCurEmployee();
        $result = $this->execSP(__FUNCTION__, "public.lot_upd(:lot_id, :product_id, :amount, :lot_date, :employee_id)", $p);
        return $result;
    }
    public function lot_upd_for_opt($product_id, $amount){
        $p['lot_id'] = 0;
        $p['product_id'] = $product_id;
        $p['amount'] = $amount;
        $p['lot_date'] = date("d.m.Y");
        $p['employee_id'] = getCurEmployee();
        $result = $this->execSP(__FUNCTION__, "public.lot_upd(:lot_id, :product_id, :amount, :lot_date, :employee_id)", $p);
        return $result;
    }
    public function product_for_select_get($product_name){
        $p['product_name'] = $product_name;
        $result = $this->readSP(__FUNCTION__, "public.product_for_select_get('cur', :product_name)", $p);
        return $result;
    }
    public function request_read($status_id, $date_begin, $date_end, $address, $telephone){
        $p['status_id'] = $status_id;
        $p['date_begin'] = zeroToNull($date_begin);
        $p['date_end'] = zeroToNull($date_end);
        $p['address'] = $address;
        $p['telephone'] = $telephone;
        $result = $this->readSP(__FUNCTION__, "public.request_read('cur', :status_id, to_date(:date_begin, 'dd.mm.yyyy'), to_date(:date_end, 'dd.mm.yyyy'), :address, :telephone)", $p);
        return $result;
    }
    public function request_get($request_id){
        $p['request_id'] = $request_id;
        $result = $this->getSP(__FUNCTION__, "public.request_get('cur', :request_id)", $p);
        return $result;
    }
    public function request_del($request_id){
        $p['request_id'] = $request_id;
        $result = $this->execSP(__FUNCTION__, "public.request_del(:request_id)", $p);
        return $result;
    }
    public function request_upd($a){
        $p['request_id'] = $a['request_id'];
        $p['address'] = $a['address'];
        $p['employee_id'] = getCurEmployee();
        $p['courier_id'] = zeroToNull($a['courier_id']);
        $p['request_date'] = zeroToNull($a['request_date']);
        $p['status_id'] = 1;
        $p['comment'] = $a['comment'];
        $p['telephone'] = $a['telephone'];
        $p['sum'] = zeroToNull($a['sum']);
        $result = $this->execSP(__FUNCTION__, "public.request_upd(:request_id, :address, :employee_id, :courier_id, :request_date, :status_id, :comment, :telephone, :sum) res", $p, 'res');
        if(isset($a['request_product_id'])){
            foreach ($a['request_product_id'] as $key => $value){
                $q['request_product_id'] = $a['request_product_id'][$key];
                $q['product_id'] = $a['product_id'][$key];
                $q['amount'] = $a['amount'][$key];
                $q['request_id'] = $result['value'];
                $q['price'] = $a['price'][$key];
                $result1 = $this->execSP(__FUNCTION__, "public.request_product_upd(:request_product_id, :request_id, :product_id, :amount, :price)", $q);
            }
        }
        if(isset($a['product_id_new'])){
            foreach ($a['product_id_new'] as $key => $value){
                $q['request_product_id'] = 0;
                $q['product_id'] = $a['product_id_new'][$key];
                $q['amount'] = $a['unit_new'][$key];
                $q['request_id'] = $result['value'];
                $q['price'] = $a['price_new'][$key];
                $result2 = $this->execSP(__FUNCTION__, "public.request_product_upd(:request_product_id, :request_id, :product_id, :amount, :price)", $q);
            }
        }
        return $result;
    }
    public function request_product_read($request_id){
        $p['request_id'] = $request_id;
        $result = $this->readSP(__FUNCTION__, "public.request_product_read('cur', :request_id)", $p);
        return $result;
    }
    public function request_product_read_for_upload($request_id){
        $p['request_id'] = $request_id;
        $result = $this->readSP(__FUNCTION__, "public.request_product_read_for_upload('cur', :request_id)", $p);
        return $result;
    }
    public function courier_read(){
        $result = $this->readSP(__FUNCTION__, "public.courier_read('cur')");
        return $result;
    }
    public function request_courier_change($request_id, $user_id){
        $p['request_id'] = $request_id;
        $p['user_id'] = $user_id;
        $result = $this->execSP(__FUNCTION__, "public.request_courier_change(:request_id, :user_id)", $p);
        return $result;
    }
    public function request_status_change($request_id, $status_id){
        $p['request_id'] = $request_id;
        $p['status_id'] = $status_id;
        $result = $this->execSP(__FUNCTION__, "public.request_status_change(:request_id, :status_id)", $p);
        return $result;
    }
    public function lot_is_active_upd($lot_id, $is_active, $amount, $product_id){
        $p['lot_id'] = $lot_id;
        $p['is_active'] = $is_active;
        $p['product_id'] = $product_id;
        $p['amount'] = $amount;
        $result = $this->execSP(__FUNCTION__, "public.lot_is_active_upd(:lot_id, :is_active, :product_id, :amount)", $p);
        return $result;
    }
    public function request_product_del($request_product_id, $amount, $product_id){
        $p['request_product_id'] = $request_product_id;
        $p['amount'] = $amount;
        $p['product_id'] = $product_id;
        $result = $this->execSP(__FUNCTION__, "public.request_product_del(:request_product_id, :amount, :product_id)", $p);
        return $result;
    }
    public function report_for_product_by_day($date_begin, $date_end){
        $p['date_begin'] = $date_begin;
        $p['date_end'] = $date_end;
        $result = $this->readSP(__FUNCTION__, "public.report_for_product_by_day('cur', to_date(:date_begin, 'dd.mm.yyyy'), to_date(:date_end, 'dd.mm.yyyy'))", $p);
        return $result;
    }
    public function report_by_product($product_id, $date_begin, $date_end){
        $p['date_begin'] = $date_begin;
        $p['date_end'] = $date_end;
        $p['product_id'] = $product_id;
        $result = $this->readSP(__FUNCTION__, "public.report_by_product('cur', to_date(:date_begin, 'dd.mm.yyyy'), to_date(:date_end, 'dd.mm.yyyy'), :product_id)", $p);
        return $result;
    }
    public function get_opt_cnt_for_lot($product_id, $date_begin, $date_end){
        $p['date_begin'] = $date_begin;
        $p['date_end'] = $date_end;
        $p['product_id'] = $product_id;
        $result = $this->scalarSP(__FUNCTION__, "public.get_opt_cnt_for_lot(:product_id, to_date(:date_begin, 'dd.mm.yyyy'), to_date(:date_end, 'dd.mm.yyyy')) res", $p, "res");
        return $result;
    }

}