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

    }

    public function categoryListAction(){
        $ob = new Application_Model_DbTable_Dict();
        $mode = $this->_getParam('mode', '');
        $this->view->row = $ob->category_read()['value'];
        if($mode == 'show-upd'){
            $this->_helper->AjaxContext()->addActionContext('category-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->category_show_upd($a['category_id']);
            $this->view->result = $result;
        }
        if($mode == 'del-category'){
            $this->_helper->AjaxContext()->addActionContext('category-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->category_del($a['category_id']);
            $this->view->result = $result;
        }
    }

    public function categoryEditAction(){
        $ob = new Application_Model_DbTable_Dict();
        if($this->getRequest()->isPost()){
            $arr = $this->_getAllParams();
            $result = $ob->category_upd($arr);
            if($result['status'] == true){
                $this->_redirect('/dict/category-list');
            }else{
                $this->view->error = $result['error'];
            }
        }
        $category_id = $this->_getParam('category_id', 0);
        $this->view->row = $ob->category_get($category_id)['value'];
    }

    public function productTypeListAction(){
        $ob = new Application_Model_DbTable_Dict();
        $mode = $this->_getParam('mode', '');
        $this->view->row = $ob->product_type_read()['value'];
        if($mode == 'show-upd'){
            $this->_helper->AjaxContext()->addActionContext('product-type-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->product_type_is_show_upd($a['product_type_id']);
            $this->view->result = $result;
        }
        if($mode == 'del-type'){
            $this->_helper->AjaxContext()->addActionContext('product-type-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->product_type_del($a['product_type_id']);
            $this->view->result = $result;
        }
    }

    public function productTypeEditAction(){
        $ob = new Application_Model_DbTable_Dict();
        if($this->getRequest()->isPost()){
            $arr = $this->_getAllParams();
            $result = $ob->product_type_upd($arr);
            if($result['status'] == true){
                $this->_redirect('/dict/product-type-list');
            }else{
                $this->view->error = $result['error'];
            }
        }
        $product_type_id = $this->_getParam('product_type_id', 0);
        $this->view->row = $ob->product_type_get($product_type_id)['value'];
    }

    public function brandListAction(){
        $ob = new Application_Model_DbTable_Dict();
        $mode = $this->_getParam('mode', '');
        $this->view->row = $ob->brand_read()['value'];
        if($mode == 'show-upd'){
            $this->_helper->AjaxContext()->addActionContext('brand-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->brand_is_show_upd($a['brand_id']);
            $this->view->result = $result;
        }
        if($mode == 'del-brand'){
            $this->_helper->AjaxContext()->addActionContext('brand-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->brand_del($a['brand_id']);
            $this->view->result = $result;
        }
    }

    public function brandEditAction(){
        $ob = new Application_Model_DbTable_Dict();
        if($this->getRequest()->isPost()){
            $arr = $this->_getAllParams();
            $result = $ob->brand_upd($arr);
            if($result['status'] == true){
                $this->_redirect('/dict/brand-list');
            }else{
                $this->view->error = $result['error'];
            }
        }
        $brand_id = $this->_getParam('brand_id', 0);
        $this->view->row = $ob->brand_get($brand_id)['value'];
    }

    public function stackListAction(){
        $ob = new Application_Model_DbTable_Dict();
        $mode = $this->_getParam('mode', '');
        $this->view->row = $ob->stack_read()['value'];

        if($mode == 'del-stack'){
            $this->_helper->AjaxContext()->addActionContext('stack-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->stack_del($a['stack_id']);
            $this->view->result = $result;
        }
        if($mode == 'category-stack-link'){
            $this->_helper->AjaxContext()->addActionContext('stack-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->stack_category_link($a['stack_id'], $a['category_id']);
            $this->view->result = $result;
        }
    }

    public function stackListTableAction(){
        $this->_helper->layout->disableLayout();
        $ob = new Application_Model_DbTable_Dict();
        $this->view->row = $ob->stack_read()['value'];
    }

    public function categoryListTableAction(){
        $this->_helper->layout->disableLayout();
        $ob = new Application_Model_DbTable_Dict();
        $stack_id = $this->_getParam('stack_id', 0);
        $this->view->row = $ob->category_for_select_read($stack_id)['value'];
    }

    public function stackEditAction(){
        $this->_helper->layout->disableLayout();
        $ob = new Application_Model_DbTable_Dict();
        $mode = $this->_getParam('mode', '');
        $stack_id = $this->_getParam('stack_id', 0);
        $this->view->stack_id = $stack_id;
        if($mode == 'upd-stack'){
            $this->_helper->AjaxContext()->addActionContext('stack-edit', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->stack_upd($a);
            $this->view->result = $result;
        }
        $this->view->row = $ob->stack_get($stack_id)['value'];
    }
    public function productListAction(){
        $ob = new Application_Model_DbTable_Dict();
        $mode = $this->_getParam('mode', '');
        if($mode == 'delete'){
            $this->_helper->AjaxContext()->addActionContext('product-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->product_del($a['product_id']);
            $this->view->result = $result;
        }
        if($mode == 'upd-amount'){
            $this->_helper->AjaxContext()->addActionContext('product-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->product_count_add($a['product_id'], $a['amount']);
            $this->view->result = $result;
        }
        $row = $ob->product_read()['value'];
        $this->view->row = $row;
    }
    public function productEditAction(){
        $ob = new Application_Model_DbTable_Dict();
        $mode = $this->_getParam('mode', '');
        $product_id = $this->_getParam('product_id', 0);
        $this->view->product_id = $product_id;
        if($this->getRequest()->isPost()){
            $arr = $this->_getAllParams();
            $result = $ob->product_upd($arr);
            if($result['status'] == true){
                $this->_redirect('/dict/product-list');
            }else{
                $this->view->error = $result['error'];
            }
        }
        $row = $ob->product_get($product_id)['value'];
        $this->view->row = $row;
        $this->view->category_list = $ob->category_read_for_select()['value'];
        $this->view->brand_list = $ob->brand_read_for_select()['value'];
        $this->view->product_type_list = $ob->product_type_read_for_select()['value'];
    }
    public function productCntEditAction(){
        $ob = new Application_Model_DbTable_Dict();
        $this->_helper->layout->disableLayout();
        $product_id = $this->_getParam('product_id', 0);
        $this->view->product_id = $product_id;
    }
}


