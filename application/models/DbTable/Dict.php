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


    public function read_request_type_json(){
        $p['request_type_id_'] = 0;
        $result = $this->scalarSP(__FUNCTION__, "public.read_request_type_json(:request_type_id_) result", $p, "result");
        return $result;
    }
    public function read_request_type_list(){
        $result = $this->readSP(__FUNCTION__, "public.read_request_type_list('cur')");
        return $result;
    }
    public function get_request_type($request_type_id){
        $p['request_type_id_'] = $request_type_id;
        $result = $this->getSP(__FUNCTION__, "public.get_request_type('cur', :request_type_id_)", $p);
        return $result;
    }
    public function del_request_type($request_type_id){
        $p['request_type_id_'] = $request_type_id;
        $result = $this->execSP(__FUNCTION__, "public.del_request_type(:request_type_id_)", $p);
        return $result;
    }
    public function upd_request_type($a){
        $p['request_type_id_'] = $a['request_type_id'];
        $p['request_type_pid_'] = $a['request_type_pid'];
        $p['request_name_'] = $a['request_name'];
        $p['request_code_'] = $a['request_code'];
        $p['item_href_'] = $a['item_href'];
        $result = $this->execSP(__FUNCTION__, "public.upd_request_type(:request_type_id_, :request_type_pid_, :request_name_, :request_code_, :item_href_)", $p);
        return $result;
    }
    public function read_request(){
        $result = $this->readSP(__FUNCTION__, "public.read_request('cur')");
        return $result;
    }
}