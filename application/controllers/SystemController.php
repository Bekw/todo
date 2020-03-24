<?php
require_once 'ParentController.php';

class SystemController extends ParentController{

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

    public function dbLogAction(){
        $dir = $_SERVER['DOCUMENT_ROOT']. '/log/db_func';
        $file_name = $dir . "/" . Zend_Session::getId() . ".log";

        if($this->getRequest()->isPost()){
            $a = $this->_getAllParams();
            if (isset($a['btn_active'])){
                $this->session->is_db_func_log = true;
            }
            if (isset($a['btn_clear'])){
                if (file_exists($file_name)) {
                    unlink($file_name);
                    $this->session->is_db_func_log = false;
                }
            }
        }
        if (file_exists($file_name)) {
            $a = file_get_contents($file_name);
            $this->view->content = $a;
        }

    }

    public function indexJsonAction(){
        $mode = $this->_getParam('mode', '');
        $this->view->mode = $mode;

        if($mode == "block-employee"){
            $ob = new Application_Model_DbTable_System();
            $employee_id = $this->_getParam('employee_id', 0);
            $result = $ob->block_employee($employee_id);
            $this->view->result = $result;
        }

        if($mode == "unblock-employee"){
            $ob = new Application_Model_DbTable_System();
            $employee_id = $this->_getParam('employee_id', 0);
            $result = $ob->unblock_employee($employee_id);
            $this->view->result = $result;
        }

        if($mode == "del-employee"){
            $ob = new Application_Model_DbTable_System();
            $employee_id = $this->_getParam('employee_id', 0);
            $result = $ob->del_employee($employee_id);
            $this->view->result = $result;
        }

        if($mode == "upd-employee"){
            $ob = new Application_Model_DbTable_System();
            $a = $this->_getAllParams();
            $result = $ob->upd_employee($a);
            if ($result['status'] == false){
                $a['status'] = false;
                $a['error'] = $result['error'];
                $this->view->result = $a;
                return;
            }
            $this->view->result = $result;
        }

        if($mode == "upd-group"){
            $ob = new Application_Model_DbTable_System();
            $a = $this->_getAllParams();
            $result = $ob->upd_group($a);
            if ($result['status'] == false){
                $a['status'] = false;
                $a['error'] = $result['error'];
                $this->view->result = $a;
                return;
            }
            $this->view->result = $result;
        }

        if($mode == "del-group"){
            $ob = new Application_Model_DbTable_System();
            $group_id = $this->_getParam('group_id', 0);
            $result = $ob->del_group($group_id);
            $this->view->result = $result;
        }

        if($mode == "upd-menu"){
            $ob = new Application_Model_DbTable_System();
            $a = $this->_getAllParams();
            $result = $ob->upd_menu($a);
            if ($result['status'] == false){
                $a['status'] = false;
                $a['error'] = $result['error'];
                $this->view->result = $a;
                return;
            }
            $this->view->result = $result;
        }

        if($mode == "del-menu"){
            $ob = new Application_Model_DbTable_System();
            $menu_id = $this->_getParam('menu_id', 0);
            $result = $ob->del_menu($menu_id);
            $this->view->result = $result;
        }

        if($mode == "group-menu-link"){
            $ob = new Application_Model_DbTable_System();
            $group_id = $this->_getParam('group_id', 0);
            $menu_id = $this->_getParam('menu_id', 0);
            $result = $ob->group_menu_link($group_id, $menu_id);
            $this->view->result = $result;
        }

        if($mode == "menu-read-by-group"){
            $ob = new Application_Model_DbTable_System();
            $group_id = $this->_getParam('group_id', 0);
            $row = $ob->menu_read($group_id);
            $this->view->result = $row;
        }

        if($mode == "employee-group-link"){
            $ob = new Application_Model_DbTable_System();
            $group_id = $this->_getParam('group_id', 0);
            $employee_id = $this->_getParam('employee_id', 0);
            $result = $ob->employee_group_link($group_id, $employee_id);
            $this->view->result = $result;
        }

        if($mode == "group-read-by-employee"){
            $ob = new Application_Model_DbTable_System();
            $employee_id = $this->_getParam('employee_id', 0);
            $row = $ob->group_read($employee_id);
            $this->view->result = $row;
        }

        if($mode == "reset-password"){
            $ob = new Application_Model_DbTable_System();
            $employee_id = $this->_getParam('employee_id', 0);
            $result = $ob->reset_password($employee_id);
            $this->view->result = $result;
        }
    }

    public function blankAction(){
    }

    private function login($login, $password, $finger, $code_key){
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('admin.employee_view');
        $authAdapter->setIdentityColumn('email');
        $authAdapter->setCredentialColumn('passwd');

        $authAdapter->setIdentity(strtolower(trim($login)));
        $authAdapter->setCredential($password);
        $auth = (new Zend_SystemAuth())::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session('system_auth'));
        $result = $auth->authenticate($authAdapter);

        if ($result->isValid()){
            $identity = $authAdapter->getResultRowObject();
            $authStorage = $auth->getStorage();
            $authStorage->write($identity);
            if($identity->is_active == 0){
                (new Zend_SystemAuth())::getInstance()->setStorage(new Zend_Auth_Storage_Session('system_auth'))->clearIdentity();
                return 'blocked';
            }
            $ob = new Application_Model_DbTable_System();
            if ($login != 'admin') {
                $is_allow = $ob->device_check($identity->email, $finger, $code_key)['value'];
                if ($is_allow == 0) {
                    (new Zend_SystemAuth())::getInstance()->setStorage(new Zend_Auth_Storage_Session('system_auth'))->clearIdentity();
                    return 'disallow';
                }
            }
            return 'valid';
        }
        else{
            return 'no_valid';
        }
    }

    public function loginAction(){
        $ob = new Application_Model_DbTable_System();
        if ((new Zend_SystemAuth())::getInstance()->setStorage(new Zend_Auth_Storage_Session('system_auth'))->hasIdentity()){
            $row = $ob->get_first_menu_action();
            $row = $row['value'];
            $this->_redirect($row['menu_action'].'menu_global_id/'.$row['menu_id']);
        }
        $this->_helper->layout()->disableLayout();
        if($this->getRequest()->isPost()){
            $this->view->login = $this->_getParam('login', 'empty');
            $password = $this->_getParam('password', 'empty');
            $finger = $this->_getParam('finger', '');
            $code_key = $this->_getParam('code_key', '');
            $validate = $this->login($this->view->login, $password, $finger, $code_key);
            if ($validate == 'valid'){
                $ob->employee_set_last_login();
                $row = $ob->get_first_menu_action();
                $row = $row['value'];
                if($row['position_id'] != 1){
                    $this->_redirect('/system/index');
                }else{
                    $this->_redirect($row['menu_action'].'menu_global_id/'.$row['menu_id']);
                }
            } else if($validate == 'blocked'){
                $this->view->error = "Пользватель заблокирован";
            } else if($validate == 'disallow'){
                $this->view->error = "Устройство пользователя не зарегистрировано";
                $this->view->show_code_key = 1;
            } else{
                $this->view->error = "Неверный логин или пароль";
            }
        }
    }

    public function indexAction(){

    }

    public function logoutAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        (new Zend_SystemAuth())::getInstance()->setStorage(new Zend_Auth_Storage_Session('system_auth'))->clearIdentity();
        $this->_redirect('/system/login');
    }

    public function menuListAction(){
        $ob = new Application_Model_DbTable_System();
        $mode = $this->_getParam('mode', '');

        if ($mode == "menu-json"){
            $a = $this->_getAllParams();
            $this->_helper->AjaxContext()->addActionContext('menu-list', 'json')->initContext('json');
            $this->view->result = $ob->read_menu_json($a['group_id']);
            return;
        }
        if ($mode == "grant-json"){
            $a = $this->_getAllParams();
            $this->_helper->AjaxContext()->addActionContext('menu-list', 'json')->initContext('json');
            $this->view->result = $ob->read_grant_json($a['group_id']);
            return;
        }

        $row = $ob->read_group();
        $this->view->row_group = $row['value'];
        $row = $ob->menu_read(0);
        $this->view->row_menu = $row['value'];
        $row = $ob->grant_read(0);
        $this->view->row_grant = $row['value'];
    }

    public function groupEditAction(){
        $this->_helper->layout->disableLayout();
        $this->view->group_id = $this->_getParam('group_id', 0);
        $ob = new Application_Model_DbTable_System();
        $row = $ob->get_group($this->view->group_id);
        $this->view->row = $row['value'];
    }

    public function menuEditAction(){
        $this->_helper->layout->disableLayout();
        $this->view->menu_id = $this->_getParam('menu_id', 0);
        $ob = new Application_Model_DbTable_System();
        $row = $ob->get_menu($this->view->menu_id);
        $this->view->row = $row['value'];
        $row = $ob->menu_read_for_select();
        $this->view->row_menu_for_select = $row['value'];
    }

    public function employeeListAction(){
        $this->view->email = $this->_getParam('email', '');
        $this->view->fio = $this->_getParam('fio', '');
        $ob = new Application_Model_DbTable_System();
        $row = $ob->read_employee($this->view->email, $this->view->fio);
        $this->view->row = $row['value'];
    }

    public function employeeEditAction(){
        $this->_helper->layout->disableLayout();
        $this->view->employee_id = $this->_getParam('employee_id', 0);
        $ob = new Application_Model_DbTable_System();
        $row = $ob->read_position();
        $this->view->row_position = $row['value'];
        $row = $ob->get_employee($this->view->employee_id);
        $this->view->row = $row['value'];
    }

    public function employeeGroupAction(){
        $ob = new Application_Model_DbTable_System();
        $row = $ob->read_employee('', '');
        $this->view->row_employee = $row['value'];
        $row = $ob->group_read(0);
        $this->view->row_group = $row['value'];
        $row = $ob->city_read(0);
        $this->view->row_city = $row['value'];
        $row = $ob->company_read(0);
        $this->view->row_company = $row['value'];
    }

    public function changePasswordAction(){
        $ob = new Application_Model_DbTable_System();
        if (isset($_POST["change_password"])) {
            $a = $this->_getAllParams();
            $result = $ob->change_password($a);
            if($result['status'] == false){
                $a['error'] = $result['error'];
                $this->view->row = $a;
                return;
            }
            $this->view->success_password_change = 1;
        }
    }
}

