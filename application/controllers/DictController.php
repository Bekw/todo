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
        if($mode == 'change-request-courier'){
            $a = $this->_getAllParams();
            $result = $ob->request_courier_change($a['request_id'], $a['user_id']);
            $this->view->result = $result;
        }
        if($mode == 'change-request-status'){
            $a = $this->_getAllParams();
            $result = $ob->request_status_change($a['request_id'], $a['status_id']);
            $this->view->result = $result;
        }
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
        $this->view->type_list = $ob->product_type_read_for_select()['value'];
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
        if($mode == 'upd-stack'){
            $this->_helper->AjaxContext()->addActionContext('product-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->product_stack_upd($a);
            $this->view->result = $result;
        }
        if($mode == 'delete-stack'){
            $this->_helper->AjaxContext()->addActionContext('product-list', 'json')->initContext('json');
            $product_stack_id = $this->_getParam('product_stack_id', 0);
            $result = $ob->product_stack_del($product_stack_id);
            $this->view->result = $result;
        }
//        $row = $ob->product_read()['value'];
        $this->view->category_list = $ob->category_read_for_select()['value'];
        $this->view->brand_list = $ob->brand_read_for_select()['value'];
        $this->view->product_type_list = $ob->product_type_read_for_select()['value'];
//        $this->view->row = $row;
    }
    public function productListFormAction(){
        $this->_helper->layout->disableLayout();
        $ob = new Application_Model_DbTable_Dict();
        $category_id = $this->view->category_id = $this->_getParam('category_id', 0);
        $brand_id = $this->view->brand_id = $this->_getParam('brand_id', 0);
        $product_type_id = $this->view->product_type_id = $this->_getParam('product_type_id', 0);
        $result  = $ob->product_read($category_id, $product_type_id, $brand_id);
        $this->view->row = $result['value'];
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
                $this->_redirect('/dict/product-list/');
            }else{
                $this->view->error = $result['error'];
            }
        }
        $row = $ob->product_get($product_id)['value'];
        $this->view->row = $row;
        $this->view->category_list = $ob->category_read_for_select()['value'];
        $this->view->brand_list = $ob->brand_read_for_select()['value'];
        $this->view->product_type_list = $ob->product_type_read_for_select()['value'];
        $this->view->product_stack_list = $ob->product_stack_read($product_id)['value'];
        $this->view->stack_list = $ob->stack_for_select_read($row['category_id'])['value'];
    }
    public function productCntEditAction(){
        $ob = new Application_Model_DbTable_Dict();
        $this->_helper->layout->disableLayout();
        $product_id = $this->_getParam('product_id', 0);
        $this->view->product_id = $product_id;
    }
    public function lotListAction(){
        $ob = new Application_Model_DbTable_Dict();
        $mode = $this->_getParam('mode', '');
        $this->view->date_begin = $this->_getParam('date_begin', '');
        $date_begin = $this->view->date_begin;
        $this->view->date_end = $this->_getParam('date_end', '');
        $date_end = $this->view->date_end;
        $this->view->product_name = $this->_getParam('product_name', '');
        $product_name = $this->view->product_name;
        $this->view->is_active = $this->_getParam('is_active', '');
        $is_active = $this->view->is_active;

        if($mode == 'delete'){
            $this->_helper->AjaxContext()->addActionContext('lot-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->lot_del($a['lot_id']);
            $this->view->result = $result;
        }
        if($mode == 'is-active'){
            $this->_helper->AjaxContext()->addActionContext('lot-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->lot_is_active_upd($a['lot_id'], $a['is_active'], $a['amount'], $a['product_id']);
            $this->view->result = $result;
        }
        $row = $ob->lot_read($date_begin, $date_end, $product_name, $is_active)['value'];
        $this->view->row = $row;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($row);
        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }
    public function lotEditAction(){
        $ob = new Application_Model_DbTable_Dict();
        $lot_id = $this->_getParam('lot_id', 0);
        $this->view->lot_id = $lot_id;

        $mode = $this->_getParam('mode', '');
        if($mode == 'get-products'){
            $this->_helper->AjaxContext()->addActionContext('lot-edit', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->product_for_select_get($a['product_name'])['value'];
            $this->view->product_list = $result;
        }
        if($this->getRequest()->isPost()){
            $arr = $this->_getAllParams();
            $result = $ob->lot_upd($arr);
            if($result['status'] == true){
                $this->_redirect('/dict/lot-list');
            }else{
                $this->view->error = $result['error'];
                $this->view->row = $arr;
            }
        }
        $this->view->row = $ob->lot_get($lot_id)['value'];
    }
    public function requestListAction(){
        $ob = new Application_Model_DbTable_Dict();
        $this->view->status_id = $this->_getParam('status_id', 0);
        $status_id = $this->view->status_id;
        $this->view->date_begin = $this->_getParam('date_begin', '');
        $date_begin = $this->view->date_begin;
        $this->view->date_end = $this->_getParam('date_end', '');
        $date_end = $this->view->date_end;
        $this->view->address = $this->_getParam('address', '');
        $address = $this->view->address;
        $telephone = $this->_getParam('telephone', '');
        $this->view->telephone = $telephone;
        $mode = $this->_getParam('mode', '');
        if($mode == 'upd-request'){
            $this->_helper->AjaxContext()->addActionContext('request-edit', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->request_upd($a);
            $this->view->result = $result;
        }
        if($mode == 'appendix1'){
            $row = $ob->request_read($status_id, $date_begin, $date_end, $address, $this->view->telephone);
            $row_req = $row['value'];
            $status_name = '';
            if($status_id == 1){
                $status_name = 'Отправлено';
            }
            if($status_id == 3){
                $status_name = 'Доставлено';
            }
            try{
                require 'phpword/vendor/autoload.php';
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('appendix1.docx');
                $templateProcessor->cloneRow('address', count($row_req));
                $cnt = 0;
                $ob_sum = 0;


                $templateProcessor->setValue('date', date('d/m/Y'));
                foreach ($row_req as $req){
                    $cnt++;
                    $cnt1 = 0;
                    $templateProcessor->setValue('address#'.$cnt, $req['address']);
                    $templateProcessor->setValue('telephone#'.$cnt, $req['telephone']);
                    $templateProcessor->setValue('comment_contact#'.$cnt, $req['comment']);

                    $items = $ob->request_product_read_for_upload($req['request_id'])['value'];
                    $item = implode('<w:br/>', array_map(function ($entry) {
                        $entry['product_name'] = htmlspecialchars($entry['product_name']);
                        return implode(',',$entry);
                    }, $items));
                    $templateProcessor->setValue('item#'.$cnt, $item);

                    $templateProcessor->setValue('sum#'.$cnt, tenge_text($req['sum']));

                    $ob_sum += $req['sum'];
                }

                $templateProcessor->setValue('ob_sum', tenge_text($ob_sum));

                $dir = $_SERVER['DOCUMENT_ROOT']. '/log/reports';
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $filename = 'Товары_'.$status_name. '.docx';
                $templateProcessor->saveAs($filename);

                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.$filename);
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filename));
                flush();
                readfile($filename);
                unlink($filename);
                exit;
            }catch (exception $e){
                $result['value'] = null;
                $result['error'] = _getErrorDebug($e, $e->getMessage());
                $result['status'] = false;
                echo var_dump($result['error']);
            }
        }
        $result = $ob->request_read($this->view->status_id, $this->view->date_begin, $this->view->date_end, $this->view->address, $this->view->telephone)['value'];
        $this->view->row = $result;
        $this->view->courier_list = $ob->courier_read()['value'];

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($result);
        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }
    public function requestEditAction(){
        $ob = new Application_Model_DbTable_Dict();
        $mode = $this->_getParam('mode', '');
        if($mode == 'get-products'){
            $this->_helper->AjaxContext()->addActionContext('request-edit', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->product_for_select_get($a['product_name'])['value'];
            $this->view->product_list = $result;
        }
        if($mode == 'upd-request'){
            $this->_helper->AjaxContext()->addActionContext('request-edit', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->request_upd($a);
            $this->view->result = $result;
        }
        if($mode == 'delete-request-product'){
            $this->_helper->AjaxContext()->addActionContext('request-edit', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $ob->request_product_del($a['request_product_id'], $a['amount'], $a['product_id']);
            $this->view->result = $result;
        }
        $this->view->request_id = $this->_getParam('request_id', 0);
        $this->view->status_id = $this->_getParam('status_id', 1);
        $this->view->courier_list = $ob->courier_read()['value'];
        $this->view->row = $ob->request_get($this->view->request_id)['value'];

    }
    public function reportByDayAction(){
        $ob = new Application_Model_DbTable_Dict();
        $mode = $this->_getParam('mode', '');

        $firstDayUTS = mktime (0, 0, 0, date("m"), 1, date("Y"));
        $lastDayUTS = mktime (0, 0, 0, date("m"), date('t'), date("Y"));

        $firstDay = date("d.m.Y", $firstDayUTS);
        $lastDay = date("d.m.Y", $lastDayUTS);

        $date_begin = $this->_getParam('date_begin', $firstDay);
        $date_end = $this->_getParam('date_end', $lastDay);

        $this->view->date_begin = $date_begin;
        $this->view->date_end = $date_end;

        if($mode == 'get-dayly-sale-sum'){
            $this->_helper->AjaxContext()->addActionContext('report-by-day', 'json')->initContext('json');
            $sum_by_days = $ob->report_for_product_by_day($date_begin, $date_end)['value'];
            $this->view->result = $sum_by_days;
        }
    }
    public function reportByProductAction(){
        $ob = new Application_Model_DbTable_Dict();
        $mode = $this->_getParam('mode', '');

        $firstDayUTS = mktime (0, 0, 0, date("m"), 1, date("Y"));
        $lastDayUTS = mktime (0, 0, 0, date("m"), date('t'), date("Y"));

        $product_id = $this->_getParam('product_id', 0);
        $firstDay = date("d.m.Y", $firstDayUTS);
        $lastDay = date("d.m.Y", $lastDayUTS);

        $date_begin = $this->_getParam('date_begin', $firstDay);
        $date_end = $this->_getParam('date_end', $lastDay);

        $this->view->date_begin = $date_begin;
        $this->view->date_end = $date_end;
        $this->view->product_id = $product_id;

        if($mode == 'get-report-by-product'){
            $this->_helper->AjaxContext()->addActionContext('report-by-product', 'json')->initContext('json');
            $sum_by_days = $ob->report_by_product($product_id, $date_begin, $date_end);
            $this->view->result = $sum_by_days;
        }
    }
}


