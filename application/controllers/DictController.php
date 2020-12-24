<?php
require_once 'ParentController.php';

class DictController extends ParentController{

    public function preDispatch(){
        $action_name =  (Zend_Controller_Front::getInstance()->getRequest()->getActionName());
        //Прописать action-ы в которых нужна сессия
        if ($action_name == 'notification-list' || $action_name == 'myaction2'){
            $params = $this->_getAllParams();
            foreach ($params as $key => $value) {
                $this->session->param[$key] = $value;
            }
        }
    }

    public function init(){
        $this->_helper->layout->setLayout('layout-system');
        parent::init();
        $this->user_id = 0;
        $action_name =  (Zend_Controller_Front::getInstance()->getRequest()->getActionName());
        $actions_except = array('login',
                                'send-mail',
                                'check-mail');
        if (!in_array($action_name, $actions_except)){
            if (!(new Zend_SystemAuth())::getInstance()->setStorage(new Zend_Auth_Storage_Session('system_auth'))->hasIdentity()){
                $this->_redirect('/system/login');
            }
            if (getCurEmployee() == 0){
                (new Zend_SystemAuth())::getInstance()->setStorage(new Zend_Auth_Storage_Session('system_auth'))->clearIdentity();
                $this->_redirect('/system/login');
            }
        }
        if ((new Zend_SystemAuth())::getInstance()->setStorage(new Zend_Auth_Storage_Session('system_auth'))->hasIdentity()){
            $this->user_id = getCurEmployee();
            $identity = (new Zend_SystemAuth())::getInstance()->getStorage()->read();
//            $this->role = $identity->role_id;
//            $this->name = $identity->fio;
//            $this->city_id = $identity->city_id;
        }
    }



    public function indexJsonAction(){
        $mode = $this->_getParam('mode', '');
        $this->view->mode = $mode;
        $ob = new Application_Model_DbTable_Dict();
        if($mode == 'upd-request'){
            $a = $this->_getAllParams();
            $result = $ob->request_upd($a);
            $this->view->result = $result;
        }
    }
    public function requestTypeListAction(){
        $ob = new Application_Model_DbTable_Dict();
        $mode = $this->_getParam('mode', '');

        if($mode == "upd"){
            $this->_helper->AjaxContext()->addActionContext('request-type-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->upd_request_type($a);
            $this->view->result = $result;
        }
        if($mode == "delete"){
            $this->_helper->AjaxContext()->addActionContext('request-type-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->del_request_type($a['request_type_id']);
            $this->view->result = $result;
        }
        if ($mode == "category-json"){
            $this->_helper->AjaxContext()->addActionContext('request-type-list', 'json')->initContext('json');
            $this->view->result = $ob->read_request_type_json();
            return;
        }

        $this->view->request_type_id = $this->_getParam('request_type_id', 0);
        $this->view->row = $ob->read_request_type_list()['value'];
    }
    public function requestTypeEditAction(){
        $ob = new Application_Model_DbTable_Dict();
        $request_type_id = $this->_getParam('request_type_id', 0);

        if($this->getRequest()->isPost()) {
            $a = $this->_getAllParams();
            $result = $ob->upd_request_type($a);
            if ($result['status'] == false) {
                $this->view->error = $result['error'];
                $this->view->row = $a;
            }else{
                $this->_redirector->gotoUrl('/dict/request-type-list/');
            }
        }
        $row = $ob->get_request_type($request_type_id)['value'];
        $this->view->row = $row;
        $this->view->request_type_list = $ob->read_request_type_list()['value'];
    }
    public function requestListAction(){
        $ob = new Application_Model_DbTable_Dict();
        $row = $ob->read_request()['value'];
        $this->view->row = $row;
    }
}


