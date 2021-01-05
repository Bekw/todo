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
        $p['message_text_'] = $a['message_text'];
        $p['document_name'] = '';
        $p['document_url'] = '';

        try{
            $tmpFilePath = $_FILES['request_document']['tmp_name'];
            if ($tmpFilePath != ""){
                $ext = pathinfo($_FILES['request_document']['name'], PATHINFO_EXTENSION);
                $name = $_FILES['request_document']['name'];
                $dir = $_SERVER['DOCUMENT_ROOT']."/documents/request_document/";
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $filename = "/documents/request_document/".uniqid('request_doc_',true)."." . $ext;
                $newFilePath = $_SERVER['DOCUMENT_ROOT']. $filename;
                $p['document_name'] = $name;
                $p['document_url'] = $filename;

                if(move_uploaded_file($tmpFilePath, $newFilePath)) {

                }
            }
        } catch(Exception $e){
            $result['status'] = false;
            $result['error'] = $e->getMessage()."->"."Ошибка при загрузке файла";
            return $result;
        }
        $result = $this->execSP(__FUNCTION__, "public.upd_request_type(:request_type_id_, :request_type_pid_, :request_name_, :request_code_, :item_href_, :message_text_, :document_url, :document_name)", $p);
        return $result;
    }
    public function read_request(){
        $result = $this->readSP(__FUNCTION__, "public.read_request('cur')");
        return $result;
    }
    public function read_request_nf(){
        $result = $this->readSP(__FUNCTION__, "public.read_request_nf('cur')");
        return $result;
    }
    public function read_request_by_token($token){
        $p['token'] = $token;
        $result = $this->readSP(__FUNCTION__, "public.read_request_by_token('cur', :token)", $p);
        return $result;
    }
    public function read_request_buttons($request_type_id){
        $p['request_type_id'] = $request_type_id;
        $result = $this->readSP(__FUNCTION__, "public.read_request_buttons('cur', :request_type_id)", $p);
        return $result;
    }
    public function send_message($request_type_id, $token){
        $p['request_type_id_'] = $request_type_id;
        $p['token_'] = $token;
        $p['user_id_'] = 1;
        $result = $this->execSP(__FUNCTION__, "public.send_message(:request_type_id_, :token_, :user_id_)", $p);
        return $result;
    }
    public function send_message_nf($request_type_id, $token, $message_text){
        $p['request_type_id_'] = $request_type_id;
        $p['token_'] = $token;
        $p['message_text_'] = $message_text;
        $p['user_id_'] = getCurEmployee();
        $result = $this->execSP(__FUNCTION__, "public.send_message_nf(:request_type_id_, :token_, :user_id_, :message_text_)", $p);
        return $result;
    }
}