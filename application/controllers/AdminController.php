<?php

class AdminController extends Zend_Controller_Action
{
    
    public function init()
    {
        $this->_redirector = $this->_helper->getHelper('Redirector');
        $this->_helper->AjaxContext()->addActionContext('index-json', 'json')->initContext('json');

        $this->role = 0;
        $this->user_id = 0;
        $this->city_id = 0;
        $this->name = "";
        if (Zend_Auth::getInstance()->hasIdentity()){
            $identity = Zend_Auth::getInstance()->getStorage()->read();
            $this->role = $identity->role;
            $this->user_id = $identity->user_id;
            $this->name = $identity->name;
            $this->city_id = $identity->city_id;
        }
        $this->view->role = $this->role;
        $this->view->name = $this->name;
        $this->view->user_id = $this->user_id;
        $this->view->city_id_1 = $this->city_id;
        if ($this->getRequest ()->getActionName () == 'index-ajax-content'){
            $this->_helper->layout->disableLayout();
        }
        Zend_Session::start();

        $admin = new Application_Model_DbTable_Admin();
        $params = json_encode($this->_getAllParams());
        $admin->insert_audit_test($this->user_id, 'AdminController', $this->getRequest ()->getActionName (), $params);
    }

    public function indexJsonAction(){
        $mode = $this->_getParam('mode', '');
        $this->view->mode = $mode;
        $this->view->result = true;
        if ($mode == 'change-category'){
            $admin = new Application_Model_DbTable_Admin();
            $category_id = $this->_getParam('category_id');
            $category_name = $this->_getParam('category_name');
            $result = $admin->changeCategoryName($category_id,$category_name);
            $this->view->result = $result;
        }
        if ($mode == 'change-product-type-name'){
            $admin = new Application_Model_DbTable_Admin();
            $product_type_id = $this->_getParam('product_type_id');
            $product_type_name = $this->_getParam('product_type_name');
            $result = $admin->changeProductTypeName($product_type_id,$product_type_name);
            $this->view->result = $result;
        }
        if ($mode == 'change-brand-name'){
            $admin = new Application_Model_DbTable_Admin();
            $brand_id = $this->_getParam('brand_id');
            $brand_name = $this->_getParam('brand_name');
            $result = $admin->changeBrandName($brand_id,$brand_name);
            $this->view->result = $result;
        }
        if ($mode == 'delete-category'){
            $admin = new Application_Model_DbTable_Admin();
            $category_id = $this->_getParam('category_id');
            $result = $admin->deleteCategory($category_id);
            $this->view->result = $result;
        }
        if ($mode == 'delete-product-type'){
            $admin = new Application_Model_DbTable_Admin();
            $product_type_id = $this->_getParam('product_type_id');
            $result = $admin->deleteProductType($product_type_id);
            $this->view->result = $result;
        }
        if ($mode == 'delete-brand'){
            $admin = new Application_Model_DbTable_Admin();
            $brand_id = $this->_getParam('brand_id');
            $result = $admin->deleteBrand($brand_id);
            $this->view->result = $result;
        }
        if ($mode == 'category-visibility'){
            $admin = new Application_Model_DbTable_Admin();
            $category_id = $this->_getParam('category_id');
            $is_show = $this->_getParam('is_show');
            $result = $admin->setCategoryVisibility($category_id,$is_show);
            $this->view->result = $result;
        }
        if ($mode == 'product-type-visibility'){
            $admin = new Application_Model_DbTable_Admin();
            $product_type_id = $this->_getParam('product_type_id');
            $is_show = $this->_getParam('is_show');
            $result = $admin->setProductTypeVisibility($product_type_id,$is_show);
            $this->view->result = $result;
        }
        if ($mode == 'brand-visibility'){
            $admin = new Application_Model_DbTable_Admin();
            $brand_id = $this->_getParam('brand_id');
            $is_show = $this->_getParam('is_show');
            $result = $admin->setBrandVisibility($brand_id,$is_show);
            $this->view->result = $result;
        }
        if ($mode == 'add-product-type'){
            $admin = new Application_Model_DbTable_Admin();
            $product_type_name = $this->_getParam('product_type_name');
            $result = $admin->addProductType($product_type_name);
            $this->view->result = $result;
        }
        if ($mode == 'add-brand'){
            $admin = new Application_Model_DbTable_Admin();
            $brand_name = $this->_getParam('brand_name');
            $result = $admin->addBrand($brand_name);
            $this->view->result = $result;
        }
        if ($mode == 'add-category'){
            $admin = new Application_Model_DbTable_Admin();
            $category_name = $this->_getParam('category_name');
            $result = $admin->addCategory($category_name);
            $this->view->result = $result;
        }
        if ($mode == 'add-to-category'){
            $admin = new Application_Model_DbTable_Admin();
            $product_id = $this->_getParam('product_id');
            $category_id = $this->_getParam('category_id');
            $result = $admin->addToCategory($product_id,$category_id);
            $this->view->result = $result;
        }
        if ($mode == 'delete-from-category'){
            $admin = new Application_Model_DbTable_Admin();
            $product_id = $this->_getParam('product_id');
            $category_id = $this->_getParam('category_id');
            $result = $admin->deleteFromCategory($product_id,$category_id);
            $this->view->result = $result;
        }
        if ($mode == 'save-product'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->saveProduct($allparam);
            $this->view->result = $result;
        }
        if ($mode == 'delete-product-category'){
            $admin = new Application_Model_DbTable_Admin();
            $product_category_id = $this->_getParam("product_category_id");
            $result = $admin->deleteProductCategory($product_category_id);
            $this->view->result = $result;
        }
        if ($mode == 'delete-product'){
            $admin = new Application_Model_DbTable_Admin();
            $product_id = $this->_getParam("product_id");
            $result = $admin->deleteProduct($product_id);
            $this->view->result = $result;
        }
        if($mode == 'save-characteristic'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->saveCharacteristic($allparam);
            $this->view->result = $result;
        }
        if($mode == 'upload-product-img'){
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(TRUE);
            $admin = new Application_Model_DbTable_Admin();
            $product_id = $this->_getParam('product_id',0);

            $fileTypes = array('jpg','jpeg', 'png');
            $fileParts = pathinfo($_FILES['product_img']['name']);
            if (!in_array(strtolower($fileParts['extension']),$fileTypes)) {
                echo "
                  <script>
                    alert('Тип файла не соответствует');
                  </script>
                ";
                return;
            }

            $path = time().'_' . $product_id .'.'.$fileParts['extension'];
            $uploaded = $admin->uploadProductImg($path,$product_id);
            $this->view->avatar = $uploaded;
        }
        if($mode == 'get-product-img'){
            $admin = new Application_Model_DbTable_Admin();
            $product_id = $this->_getParam('product_id',0);
            $row = $admin->getProductById($product_id);
            $this->view->avatar = $row['image'];
        }
        if($mode == 'change-request-status'){
            $admin = new Application_Model_DbTable_Admin();
            $request_id = $this->_getParam('request_id');
            $status_id = $this->_getParam('status_id');
            $result = $admin->changeRequestStatus($request_id,$status_id);
            $this->view->result = $result;
        }
        if($mode == 'change-request-courier'){
            $admin = new Application_Model_DbTable_Admin();
            $request_id = $this->_getParam('request_id');
            $user_id = $this->_getParam('user_id');
            $result = $admin->changeRequestCourier($request_id,$user_id);
            $this->view->result = $result;
        }
        if($mode == 'add-characteristic'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->addCharacteristic($allparam);
            $this->view->result = $result;
        }
        if($mode == 'delete-characteristic'){
            $admin = new Application_Model_DbTable_Admin();
            $characteristic_id = $this->_getParam('characteristic_id');
            $result = $admin->deleteCharacteristic($characteristic_id);
            $this->view->result = $result;
        }
        if ($mode == 'get-products'){
            $admin = new Application_Model_DbTable_Admin();
            $product_name = $this->_getParam('product_name');
            $city_id = $this->_getParam('city_id',0);
            $product_list = $admin->getProductByChar($product_name,$city_id);
            $this->view->product_list = $product_list;
        }
        if ($mode == 'save-request'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $allparam['operator_id'] = $this->user_id;

            if(strlen($allparam['delivery_date']) > 0){
                $check_date = $allparam['delivery_date'];
            }
            else{
                $check_date = $allparam['date'];
            }
            $check_request_for_edit = $admin->checkRequestForEditByDate($check_date,$allparam['city_id']);
            if($check_request_for_edit['status_id'] != 2) {
                $result = $admin->saveRequest($allparam);
                $this->view->result = $result;
            }
            else{
                $this->view->result = "day_closed";
            }
        }
        if ($mode == 'delete-request-product'){
            $admin = new Application_Model_DbTable_Admin();
            $request_item_id = $this->_getParam("request_item_id");
            $result = $admin->deleteRequestProduct($request_item_id);
            $this->view->result = $result;
        }
        if ($mode == 'delete-request-product-by-id'){
            $admin = new Application_Model_DbTable_Admin();
            $request_id = $this->_getParam("request_id");
            $product_id = $this->_getParam("product_id");
            $result = $admin->deleteRequestProductById($request_id,$product_id);
            $this->view->result = $result;
        }
        if ($mode == 'add-request'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $allparam['operator_id'] = $this->user_id;

            if(strlen($allparam['delivery_date']) > 0){
                $check_date = $allparam['delivery_date'];
            }
            else{
                $check_date = $allparam['date'];
            }
            $check_request_for_edit = $admin->checkRequestForEditByDate($check_date,$allparam['city_id']);
            if($check_request_for_edit['status_id'] != 2) {
                $result = $admin->addRequest($allparam);
                $this->view->result = $result['status'];
                $this->view->request_id = $result['request_id'];
            }
            else{
                $this->view->result = "day_closed";
            }
        }
        if ($mode == 'set-product-order'){
            $admin = new Application_Model_DbTable_Admin();
            $product_id = $this->_getParam('product_id');
            $order_num = $this->_getParam('order_num');
            $result = $admin->setProductOrderNum($product_id,$order_num);
            $this->view->result = $result;
        }
        if ($mode == 'change-products-order'){
            $admin = new Application_Model_DbTable_Admin();
            $from = $this->_getParam('from');
            $to = $this->_getParam('to');
            $result = $admin->changeProductsOrderNum($from,$to);
            $this->view->result = $result;
        }
        if($mode == 'add-to-basket'){
            $admin = new Application_Model_DbTable_Admin();
            $product_id = $this->_getParam('product_id');
            $session_id = Zend_Session::getId();
            $result = $admin->addToBasket($product_id,$session_id);
            $this->view->result = $result;
        }
        if($mode == 'delete-product-from-basket'){
            $admin = new Application_Model_DbTable_Admin();
            $product_id = $this->_getParam('product_id');
            $session_id = Zend_Session::getId();
            $result = $admin->deleteFromBasket($product_id,$session_id);
            $this->view->result = $result;
        }
        if($mode == 'change-product-unit'){
            $admin = new Application_Model_DbTable_Admin();
            $product_id = $this->_getParam('product_id');
            $unit = $this->_getParam('unit');
            $session_id = Zend_Session::getId();
            $result = $admin->changeProductUnit($product_id,$unit,$session_id);
            $this->view->result = $result;
        }
        if($mode == 'make-request'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $session_id = Zend_Session::getId();
            $user_id = $this->user_id;
            $user_products = $admin->getUserProducts($session_id);

            $current_request_row = $admin->getCurrentSessionRequestId($session_id);
            $current_request_city_id = $current_request_row['city_id'];

            $sum = 0;
            $deleted_products = "";
            $price_changed_products = "";
            if(count($user_products) > 0){
                foreach($user_products as $key => $user_item){
                    $sum += $user_item['price']*$user_item['unit'];
                    $action_group_price = $admin->getActionGroupPrice($current_request_row['request_id'],$user_item['product_id']);
                    $product_price = $admin->getProductAllPrice($user_item['product_id'],$current_request_city_id);

                    if($user_item['price'] != $action_group_price && $action_group_price > 0){
                        $deleted_products .= $user_item['name'] . ".<br>";
//                        $result = $admin->deleteRequestProduct($user_item['request_item_id']);
                    }
                    else if($action_group_price == -1 && $product_price == -1){
                        $deleted_products .= $user_item['name'] . "<br>";
//                        $result = $admin->deleteRequestProduct($user_item['request_item_id']);
                    }
                    else if($action_group_price == -1 && $user_item['price'] != $product_price && $product_price > 0){
                        $price_changed_products .= $user_item['name'] . " c " . $user_item['price'] . "тг. на " . $product_price . "тг.<br>";
//                        $result = $admin->updateRequestItemProductPrice($user_item['request_item_id'], $product_price);
                    }
                }

                if(strlen($deleted_products) > 0 || strlen($price_changed_products) > 0){
                    $result_view['status'] = "PRODUCT_CHANGES";
                    $result_view['price_changed_products'] = $price_changed_products;
                    $result_view['deleted_products'] = $deleted_products;
                    $this->view->result = $result_view;
                    return false;
                }
            }
            else{
                $result_view['status'] = "NOT_PRODUCTS";
                $this->view->result = $result_view;
                return false;
            }

            if(isset($_COOKIE['city']) && $_COOKIE['city'] > 0){
                $city_row = $admin->getCityById($_COOKIE['city']);
                $bonus_count = intval(($sum*intval($city_row['bonus_count'])/100));
            }
            else{
                $bonus_count = intval(($sum*0/100));
            }
//            if(isset($_COOKIE['city']) && $_COOKIE['city'] == 1){
//                $bonus_count = intval(($sum*3/100));
//            }
//            else if(isset($_COOKIE['city']) && $_COOKIE['city'] == 93){
//                $bonus_count = intval(($sum*1/100));
//            }


            $allparam['bonus_count'] = $bonus_count;
            $allparam['is_epay'] = 0;

            if($allparam['status_id'] == "null"){
                $allparam['is_epay'] = 1;
                $allparam['status_id'] = 0;
            }
            $result = $admin->makeRequest($allparam,$session_id,$user_id);
            if($result['result'] == true && $allparam['status_id'] == 1){
                $send_mail_to_client = $admin->sendClientNoticeEmail($allparam,$bonus_count,$result['user_id'], $allparam['status_id'], $result['request_id']);
//                $send_mail = $admin->sendAdminNoticeEmail($allparam,$session_id,$user_products);
            }

            $result_view['status'] = $result['result'];
            $this->view->result = $result_view;
            $this->view->request_id = $result['request_id'];
        }
        if($mode == 'save-brand-description'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $brand_id = $this->_getParam('brand_id');
            $result = $admin->saveBrandDescription($allparam,$brand_id);
            $this->view->result = $result;
        }
        if($mode == 'delete-product-city'){
            $admin = new Application_Model_DbTable_Admin();
            $product_city_id = $this->_getParam('product_city_id');
            $result = $admin->deleteProductCity($product_city_id);
            $this->view->result = $result;
        }
        if($mode == 'get-info-by-telephone'){
            $admin = new Application_Model_DbTable_Admin();
            $telephone = $this->_getParam('telephone');
            $user_info = $admin->getInfoByTelephone($telephone);
            $this->view->user_info = $user_info;
        }
        if($mode == 'send-courier-message'){
            $admin = new Application_Model_DbTable_Admin();
            $request_id = $this->_getParam('request_id');
            $courier_id = $this->_getParam('courier_id');
            if($courier_id > 0 && $request_id > 0){
                $send_mail = $admin->sendCourierMessage($request_id,$courier_id);
            }
            else {
                $send_mail = "NO_COURIER";
            }
            $this->view->result = $send_mail;
        }
        if($mode == 'get-hit-products'){
            $admin = new Application_Model_DbTable_Admin();
            $product_count = $this->_getParam('product_count');
            $date_range = $this->_getParam('date_range','');
            $city_id = $this->_getParam('city_id','');
            $is_pickup = $this->_getParam('is_pickup');
            $is_wholesale = $this->_getParam('is_wholesale');
            $is_online = $this->_getParam('is_online');
            $request_type_id = $this->_getParam('request_type_id');
            $is_epay = $this->_getParam('is_epay');
            $hit_products = $admin->getHitProducts($product_count,$date_range,$city_id,$is_pickup,$is_wholesale,$is_online,$request_type_id,$is_epay);
            $this->view->result = $hit_products;
        }
        if($mode == 'get-sum-hit-products'){
            $admin = new Application_Model_DbTable_Admin();
            $product_count = $this->_getParam('product_count','');
            $date_range = $this->_getParam('date_range','');
            $city_id = $this->_getParam('city_id','');
            $is_pickup = $this->_getParam('is_pickup');
            $is_wholesale = $this->_getParam('is_wholesale');
            $is_online = $this->_getParam('is_online');
            $request_type_id = $this->_getParam('request_type_id');
            $is_epay = $this->_getParam('is_epay');
            $sum_hit_products = $admin->getSumHitProducts($product_count,$date_range,$city_id,$is_pickup,$is_wholesale,$is_online,$request_type_id,$is_epay);
            $this->view->result = $sum_hit_products;
        }
        if($mode == 'get-dayly-sale-sum'){
            $admin = new Application_Model_DbTable_Admin();
            $date_range = $this->_getParam('date_range',"");
            $city_id = $this->_getParam('city_id',"");
            $is_pickup = $this->_getParam('is_pickup');
            $is_wholesale = $this->_getParam('is_wholesale');
            $is_online = $this->_getParam('is_online');
            $request_type_id = $this->_getParam('request_type_id');
            $is_epay = $this->_getParam('is_epay');
            $sum_by_days = $admin->getSumByDays($date_range,$city_id,$is_pickup,$is_wholesale,$is_online,$request_type_id,$is_epay);
            $this->view->result = $sum_by_days;
        }
        if($mode == 'get-request-id'){
            $admin = new Application_Model_DbTable_Admin();
            $session_id = Zend_Session::getId();
            $current_request_id = $admin->getCurrentSessionRequestId($session_id);
            $this->view->session_id = $session_id;
            $this->view->result = $current_request_id;
        }
        if($mode == 'send-mail-to-clients'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->sendMailToClients($allparam);
            $this->view->result = $result;
        }
        if($mode == 'get-user-balans'){
            $admin = new Application_Model_DbTable_Admin();
            $user_id = $this->_getParam("user_id");
            $user_balans = $admin->getUserBonus($user_id);
            $this->view->user_balans = $user_balans;
        }
        if($mode == 'compare-bonus-request-price'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $session_id = Zend_Session::getId();
            $user_id = $this->user_id;
            $user_products = $admin->getUserProducts($session_id);

            $sum = 0;
            if(count($user_products) > 0){
                foreach($user_products as $key => $user_item){
                    $sum += $user_item['price']*$user_item['unit'];
                }
            }

//            if($allparam['city_id'] == 3){
//                $this->view->result = "IS_ATYRAU";
//                return;
//            }

            $user_bonus = $admin->getUserBonus($this->user_id);
            if($user_bonus >= $sum){
                $bonus_count = -$sum;
                $allparam['bonus_count'] = $bonus_count;
                $result = $admin->makeRequestByBonus($allparam,$session_id,$user_id);
                if($result == true){
//                    $send_mail = $admin->sendAdminNoticeEmail($allparam,$session_id,$user_products);
                }
                $this->view->result = $result;
            }
            else{
                $this->view->result = "SMALL_BONUS";
            }
        }
        if($mode == 'save-offer'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->updOffer($allparam);
            $this->view->result = $result;
        }
        if($mode == 'save-offer-img'){
            $admin = new Application_Model_DbTable_Admin();
            $offer_id = $this->_getParam('offer_id');

            $fileParts = pathinfo($_FILES['offer_img']['name']);
            if($_FILES['offer_img']['name'] > null){
                $path = time().'.'.$fileParts['extension'];
                $uploaded = $admin->updateOfferImg($offer_id,$path);
            }
            else {
                $path = null;
            }
            $this->_helper->viewRenderer->setNoRender(TRUE);
            $this->_helper->layout->disableLayout();
        }
        if($mode == 'add-offer'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->addOffer($allparam);
            $this->view->result = $result;
        }
        if($mode == 'add-product'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->addProduct($allparam);
            $this->view->result = $result;
        }
        if($mode == 'unload-to-doc'){
            $admin = new Application_Model_DbTable_Admin();
            $unload_type_id = $this->_getParam("unload_type_id");
            $role_id = $this->role;
            $city_id = $this->city_id;
            $result = $admin->unloadRequestsToDoc($unload_type_id,$role_id,$city_id);
            $this->view->result = $result;
        }
        if($mode == 'unload-courier-to-doc'){
            $admin = new Application_Model_DbTable_Admin();
            $user_id = $this->_getParam("user_id",0);
            $smena_type_id = $this->_getParam("smena_type_id",0);
            $date = $this->_getParam("date",0);
            $result = $admin->unloadCourierRequestsToDoc($user_id,$smena_type_id,$date);
            $this->view->result = $result;
        }
        if($mode == 'send-product-comment'){
            if (Zend_Auth::getInstance()->hasIdentity() || $_SESSION['user_name'] != null){
                $admin = new Application_Model_DbTable_Admin();
                $allparam = $this->_getAllParams();
                if(trim(strlen($allparam['comment_text'])) < 1){
                    $this->view->result = "false_text";
                    return false;
                }
                else if(trim(strlen($allparam['product_id'])) < 1){
                    $this->view->result = "false_product";
                    return false;
                }
                $result = $admin->addProductComment($allparam);
                $this->view->result = $result;
            }
            else{
                $this->view->result = "NOT_AUTH";
            }
        }
        if($mode == 'change-comment-status'){
            $admin = new Application_Model_DbTable_Admin();
            $comment_id = $this->_getParam('comment_id');
            $status_id = $this->_getParam('status_id');
            $result = $admin->changeCommentStatus($comment_id,$status_id);
            $this->view->result = $result;
        }
        if($mode == 'save-comment'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->updComment($allparam);
            $this->view->result = $result;
        }
        if($mode == 'auth-check'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->authCheck($allparam);
            if($result == true){
                $user_info = $admin->getUserByEmail($allparam['author_email']);
                $_SESSION['user_name'] = $user_info['name'];
                $_SESSION['email'] = $user_info['email'];
                $_SESSION['social'] = null;
                $_SESSION['link'] = null;
                $_SESSION['photo_big'] = null;
                $this->view->result = $user_info['name'];
            }
            else{
                $this->view->result = $result;
            }
        }
        if($mode == 'send-product-comment-by-login'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            if(trim(strlen($allparam['comment_text'])) < 1){
                $this->view->result = "false_text";
                return false;
            }
            else if(trim(strlen($allparam['product_id'])) < 1){
                $this->view->result = "false_product";
                return false;
            }
            $result = $admin->addProductComment2($allparam);
            $this->view->result = $result;
        }
        if($mode == "logout"){
            Zend_Auth::getInstance()->clearIdentity();
            $_SESSION['user_name'] = null;
            $_SESSION['social'] = null;
            $_SESSION['email'] = null;
            $_SESSION['photo_big'] = null;
            $_SESSION['link'] = null;
        }
        if($mode == 'save-lot'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->saveLot($allparam);
            $this->view->result = $result;
        }
        if($mode == 'add-lot'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->addLot($allparam);
            $this->view->result = $result;
        }
        if($mode == "delete-lot"){
            $admin = new Application_Model_DbTable_Admin();
            $lot_id = $this->_getParam('lot_id');
            $result = $admin->deleteLot($lot_id);
            $this->view->result = $result;
        }
        if($mode == "add-new-day"){
            $admin = new Application_Model_DbTable_Admin();
            $city_id = $this->_getParam("city_id");
            $result = $admin->addNewDay($city_id);
            $this->view->result = $result;
        }
        if($mode == "open-closed-day"){
            $admin = new Application_Model_DbTable_Admin();
            $closed_day_id = $this->_getParam("closed_day_id");
            $city_id = $this->_getParam("city_id");
            $result = $admin->openClosedDay($closed_day_id,$city_id);
            $this->view->result = $result;
        }
        if($mode == "close-open-day"){
            $admin = new Application_Model_DbTable_Admin();
            $closed_day_id = $this->_getParam("closed_day_id");
            $city_id = $this->_getParam("city_id");
            $result = $admin->closeOpenDay($closed_day_id,$city_id);
            $this->view->result = $result;
        }
        if($mode == "delete-all-users-products"){
            $admin = new Application_Model_DbTable_Admin();
            $session_id = Zend_Session::getId();
            $result = $admin->deleteAllUserProducts($session_id);
            $this->view->result = $result;
        }
        if($mode == "set-status-paid"){
            $admin = new Application_Model_DbTable_Admin();
            $request_id = $this->_getParam("request_id");
            $status_id = $this->_getParam("status_id");
            $delivery_date = $this->_getParam("delivery_date");
            $sum = $this->_getParam("sum");
            $contractor_id = $this->_getParam("contractor_id");
            $result = $admin->setStatusPaid($request_id,$status_id,$delivery_date,$sum,$contractor_id);
            $this->view->result = $result;
        }
        if($mode == 'get-dayly-profit-sum'){
            $admin = new Application_Model_DbTable_Admin();
            $date_range = $this->_getParam('date_range', "");
            $city_id = $this->_getParam('city_id', 0);
            $is_wholesale = $this->_getParam('is_wholesale', -1);
            $is_online = $this->_getParam('is_online', -1);
            $request_type_id = $this->_getParam('request_type_id', -1);
            $contractor_id = $this->_getParam('contractor_id', -1);
            $profit_by_days = $admin->getProfitByDays($date_range,$city_id,$is_wholesale,$is_online,$request_type_id,$contractor_id);
            $this->view->result = $profit_by_days['value'];
            $this->view->status = $profit_by_days['status'];
        }
        if($mode == 'get-product-profit-sum'){
            $admin = new Application_Model_DbTable_Admin();
            $date_range = $this->_getParam('date_range',"");
            $city_id = $this->_getParam('city_id',"");
            $is_wholesale = $this->_getParam('is_wholesale');
            $is_online = $this->_getParam('is_online');
            $price = $this->_getParam('price');
            $profit_by_days = $admin->getProfitByProducts($date_range,$city_id,$is_wholesale,$is_online,$price);
            $this->view->result = $profit_by_days;
        }
        if($mode == 'get-brand-profit-sum'){
            $admin = new Application_Model_DbTable_Admin();
            $date_range = $this->_getParam('date_range',"");
            $city_id = $this->_getParam('city_id',"");
            $is_wholesale = $this->_getParam('is_wholesale');
            $is_online = $this->_getParam('is_online');
            $price = $this->_getParam('price');
            $profit_by_days = $admin->getProfitByBrand($date_range,$city_id,$is_wholesale,$is_online,$price);
            $this->view->result = $profit_by_days;
        }
        if($mode == 'get-product-lots'){
            $admin = new Application_Model_DbTable_Admin();
            $product_id = $this->_getParam("product_id");
            $city_id = $this->_getParam("city_id");
            $result = $admin->getLotsByProduct($product_id,$city_id);
            $this->view->result = $result;
        }
        if($mode == 'formulate-delivery'){
            $admin = new Application_Model_DbTable_Admin();
            $request_id = $this->_getParam("request_id");
            $contractor_id = $this->_getParam("contractor_id");
            $date_delivery = $this->_getParam("date_delivery");
            $city_id = $this->_getParam("city_id");
            $result = $admin->formulateDelivery($request_id,$contractor_id,$date_delivery,$city_id);
            $this->view->result = $result;
        }
        if($mode == 'save-pay'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->savePay($allparam);
            $this->view->result = $result;
        }
        if($mode == 'add-pay'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->addPay($allparam);
            $this->view->result = $result;
        }
        if($mode == "delete-pay"){
            $admin = new Application_Model_DbTable_Admin();
            $contractor_pay_id = $this->_getParam('contractor_pay_id');
            $result = $admin->deletePay($contractor_pay_id);
            $this->view->result = $result;
        }
        if($mode == "get-user-products-by-session"){
            $admin = new Application_Model_DbTable_Admin();
            $session_id = Zend_Session::getId();
            $user_products = $admin->getUserProducts($session_id);
            $this->view->result = $user_products;
        }
        if($mode == "get-user-products-by-request-id"){
            $admin = new Application_Model_DbTable_Admin();
            $request_id = $this->_getParam("request_id");
            $user_products = $admin->getUserProductsByRequestId($request_id);
            $this->view->result = $user_products;
        }
        if ($mode == 'get-products-by-search'){
            $admin = new Application_Model_DbTable_Admin();
            $product_name = $this->_getParam('product_name');
            $city_id = $this->_getParam('city_id');
            $product_list = $admin->getProductBySearchChar($product_name,$city_id);
            $this->view->product_list = $product_list;
        }
        if($mode == 'delete-contractor'){
            $admin = new Application_Model_DbTable_Admin();
            $contractor_id = $this->_getParam('contractor_id');
            $result = $admin->deleteContractor($contractor_id);
            $this->view->result = $result;
        }
        if($mode == 'save-contractor'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->saveContractor($allparam);
            $this->view->result = $result;
        }
        if($mode == 'add-contractor'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->addContractor($allparam);
            $this->view->result = $result;
        }
        if($mode == 'send-waiting-request'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->sendWaitingRequest($allparam);
            $this->view->result = $result;
        }
        if($mode == 'change-waiting-request-status'){
            $admin = new Application_Model_DbTable_Admin();
            $waiting_good_id = $this->_getParam('waiting_good_id');
            $waiting_status_id = $this->_getParam('waiting_status_id');
            $result = $admin->changeWaitingRequestStatus($waiting_good_id,$waiting_status_id);
            $this->view->result = $result;
        }
        if($mode == 'send-invite'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $allparam['user_id'] = $this->user_id;
            $result = $admin->sendInvite($allparam);
            $this->view->result = $result;
        }
        if($mode == 'save-user-by-invite'){
            $admin = new Application_Model_DbTable_Admin();
            $user = new Application_Model_DbTable_User();
            $allparam = $this->_getAllParams();
            $result2 = $admin->saveUserByInvite($allparam);
            $user_info = $user->getUser($result2['email']);
            $api = new Api_Project();
            $result = $api->setAuth($result2['email'], $result2['password']);
            $updDate = $user->updLastLogin($result2['email']);
            $_SESSION['user_name'] = $user_info['name'];
            $_SESSION['email'] = $user_info['email'];
            $this->view->result = $result2;
        }
        if($mode == 'repeat-request'){
            $admin = new Application_Model_DbTable_Admin();
            $user = new Application_Model_DbTable_User();
            $request_id = $this->_getParam("request_id",0);
            $user_id = $this->user_id;
            $session_id = Zend_Session::getId();
//            if($this->city_id == 3){
//                $result['response'] = "IS_ATYRAU";
//                $this->view->result = $result;
//                return;
//            }
            $result = $admin->repeatRequest($user_id,$request_id, $session_id);
            $this->view->result = $result;
        }
        if($mode == "reset-password-by-admin"){
            $admin = new Application_Model_DbTable_Admin();
            $user_id = $this->_getParam("user_id",0);
            $result = $admin->resetPasswordByAdmin($user_id);
            $this->view->result = $result;
        }
        if($mode == "send-sms-for-waiting-request"){
            $admin = new Application_Model_DbTable_Admin();
            $waiting_good_id = $this->_getParam("waiting_good_id",0);
            $result = $admin->sendSmsForWaitingRequest($waiting_good_id);
            $this->view->result = $result;
        }
        if($mode == "send-sms-for-waiting-request-new"){
            $admin = new Application_Model_DbTable_Admin();
            $waiting_good_id = $this->_getParam("waiting_good_id",0);
            $sms_type = $this->_getParam("sms_type",0);
            $result = $admin->sendSmsForWaitingRequestNew($this->user_id,$waiting_good_id,$sms_type);
            $this->view->result = $result;
        }
        if($mode == "update-sms-status"){
            $admin = new Application_Model_DbTable_Admin();
            $status_id = $this->_getParam("status_id",0);
            $sms_type = $this->_getParam("sms_type",0);
            $result = $admin->updateSmsStatus($status_id,$sms_type);
            $this->view->result = $result;
        }
        if($mode == "send-email-for-waiting-request"){
            $admin = new Application_Model_DbTable_Admin();
            $waiting_good_id = $this->_getParam("waiting_good_id",0);
            $result = $admin->sendEmailForWaitingRequest($waiting_good_id);
            $this->view->result = $result;
        }
        if($mode == "upload-product-foto"){
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(TRUE);
            $admin = new Application_Model_DbTable_Admin();
            $product_id = $this->_getParam('product_id',0);

            $fileTypes = array('jpg','jpeg', 'png');
            $fileParts = pathinfo($_FILES['product_foto']['name']);
            if (!in_array(strtolower($fileParts['extension']),$fileTypes)) {
                echo "
                  <script>
                    alert('Тип файла не соответствует');
                  </script>
                ";
                return;
            }

            $path = time().'.'.$fileParts['extension'];
            $uploaded = $admin->uploadProductPhoto($path,$product_id);
            $this->view->avatar = $uploaded;
        }
        if($mode == "delete-product-foto"){
            $admin = new Application_Model_DbTable_Admin();
            $product_foto_id = $this->_getParam('product_foto_id');
            $result = $admin->deleteProductFoto($product_foto_id);
            $this->view->result = $result;
        }
        if($mode == "add-lot-modal"){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->saveModalLots($allparam);
            $this->view->result = $result;
        }
        if($mode == "delete-inventory"){
            $admin = new Application_Model_DbTable_Admin();
            $inventory_id = $this->_getParam('inventory_id');
            $result = $admin->deleteInventory($inventory_id);
            $this->view->result = $result;
        }
        if($mode == 'save-inventory'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->saveInventory($allparam);
            $this->view->result = $result;
        }
        if($mode == 'add-inventory'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->addInventory($allparam);
            $this->view->result = $result;
        }
        if($mode == "add-inventory-modal"){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->saveModalInventory($allparam);
            $this->view->result = $result;
        }
        if($mode == "save-product-barcode"){
            $admin = new Application_Model_DbTable_Admin();
            $product_id = $this->_getParam("product_id",0);
            $barcode = $this->_getParam("barcode","");
            $result = $admin->saveProductBarcode($product_id,$barcode);
            $this->view->result = $result;
        }
        if($mode == "save-product-code-1c"){
            $admin = new Application_Model_DbTable_Admin();
            $product_id = $this->_getParam("product_id",0);
            $code_1c = $this->_getParam("code_1c","");
            $city_id = $this->_getParam("city_id",0);
            $result = $admin->saveProductCode1c($product_id, $city_id, $code_1c);
            $this->view->result = $result;
        }
        if($mode == "search-product-by-barcode"){
            $admin = new Application_Model_DbTable_Admin();
            $barcode = $this->_getParam("barcode","");
            $result = $admin->getProductByBarcode($barcode);
            $this->view->result = $result;
        }
        if($mode == "check-transaction-status"){
            $request_id = $this->_getParam("request_id",0);
            require_once("kkb_cert/real_paysys/kkb.utils.php");
            $path1 = 'kkb_cert/real_paysys/config.txt';
            $sum = $this->requestSum($request_id);
            $sign = process_request($request_id,"398",$sum,$path1);
            $string = '         <document>
                                    <merchant id="92061102">
                                        <order id="' . $request_id . '"/>
                                    </merchant>
                                    <merchant_sign type="RSA" cert_id="00C182B189">
                                       ' .  base64_encode(strrev($sign)) . '
                                    </merchant_sign>
                                </document>';
            $xml2 = $string;

            define("MERCHANT_CERT_ID",	"c183d69f");	// Серийный номер сертификата
            define("MERCHANT_NAME",		"BEBEK.KZ");	// Название магазина (продавца)
            define("ORDER_ID",			$request_id);		// Уникальный номер заказа
            define("CURRENCY",			"398");			// ID валюты. 840 - USD
            define("MERCHANT_ID",		"92289831");			// ID продавца в системе
            define("AMOUNT", 			$sum);			// сумма заказа
            $kkb = new KKBSign();
            $kkb->invert();
            $kkb->load_private_key("kkb_cert/real_paysys/cert.prv", "1q2w3e4r");
            //$merchant = '<merchant cert_id="%certificate%" name="%merchant_name%"><order order_id="%order_id%" amount="%amount%" currency="%currency%"><department merchant_id="%merchant_id%" amount="%amount%"/></order></merchant>';
            $merchant = '<merchant id="%merchant_id%"><command type="complete"/><payment reference="109600746891" approval_code="00" orderid="%order_id%" amount="%amount%" currency_code="%currency%"/></merchant>';
            $merchant = preg_replace('/\%merchant_id\%/', 		MERCHANT_ID, 		$merchant);
            $merchant = preg_replace('/\%order_id\%/', 			ORDER_ID, 			$merchant);
            $merchant = preg_replace('/\%amount\%/', 			AMOUNT,				$merchant);
            $merchant = preg_replace('/\%currency\%/', 			CURRENCY, 			$merchant);

            $merchant_sign = '<merchant_sign type="RSA" cert_id="%certificate%">'.$kkb->sign64($merchant).'</merchant_sign>';
            $merchant_sign = preg_replace('/\%certificate\%/', 		MERCHANT_CERT_ID , 	$merchant);
            $xml = "<document>".$merchant.$merchant_sign."</document>";
            echo var_dump($xml);
            $xml = urlencode($xml);
            echo var_dump($xml);
            $url = "https://testpay.kkb.kz/jsp/remote/control.jsp";
            $opts = array('http' =>
                array(
                    'method'  => 'GET',
                    'header'  => "Content-Type: text/xml\r\n",
                    'content' => $xml,
                    'timeout' => 60
                )
            );

            $context  = stream_context_create($opts);
            $result = file_get_contents($url, false, $context, -1, 40000);
            echo var_dump($result);
            $this->view->result = $result;
//            $url = "https://3dsecure.kkb.kz/jsp/remote/checkOrdern.jsp";
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL,$url);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
//            curl_setopt($ch, CURLOPT_HTTPHEADER, array('' . $string, 'Accept: application/xml', 'Content-type: application/xml'));
//            $result = curl_exec($ch);
//            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//            curl_close($ch);
//            echo var_dump($httpcode);
//            echo var_dump($result);

//            return $res_row;

//            $xml = $string;
//            $str = 'https://3dsecure.kkb.kz/jsp/remote/checkOrdern.jsp?' . $xml;
//            $params = file_get_contents($str);
//            echo var_dump($params);
        }

        if($mode == "delete-advertisement"){
            $admin = new Application_Model_DbTable_Admin();
            $advertisement_id = $this->_getParam('advertisement_id');
            $result = $admin->deleteAdvertisement($advertisement_id);
            $this->view->result = $result;
        }
        if($mode == 'save-advertisement'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->saveAdvertisement($allparam);
            $this->view->result = $result;
        }
        if($mode == 'add-advertisement'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->addAdvertisement($allparam);
            $this->view->result = $result;
        }
        if($mode == 'get-report-by-brand'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $report_by_brand = $admin->getReportByBrand($allparam);
            $this->view->result = $report_by_brand;
        }
        if($mode == 'get-report-by-brand-product'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $report_by_brand = $admin->getReportByBrandByProduct($allparam);
            $this->view->result = $report_by_brand;
        }
        if($mode == 'get-report-by-product'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $report_by_product = $admin->getReportByProduct($allparam);
            $this->view->result = $report_by_product;
        }
        if($mode == "get-all-products-by-search"){
            $admin = new Application_Model_DbTable_Admin();
            $product_name = $this->_getParam('product_name');
            $product_list = $admin->getAllProductBySearchChar($product_name);
            $this->view->product_list = $product_list;
        }
        if ($mode == 'hide-product'){
            $admin = new Application_Model_DbTable_Admin();
            $product_id = $this->_getParam("product_id");
            $result = $admin->hideProduct($product_id);
            $this->view->result = $result;
        }
        if ($mode == 'show-product'){
            $admin = new Application_Model_DbTable_Admin();
            $product_id = $this->_getParam("product_id");
            $result = $admin->showProduct($product_id);
            $this->view->result = $result;
        }

        if($mode == "upload-brand-foto"){
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(TRUE);
            $admin = new Application_Model_DbTable_Admin();
            $brand_id = $this->_getParam('brand_id',0);

            $fileTypes = array('jpg','jpeg', 'png');
            $fileParts = pathinfo($_FILES['brand_foto']['name']);
            if (!in_array(strtolower($fileParts['extension']),$fileTypes)) {
                echo "
                  <script>
                    alert('Тип файла не соответствует');
                  </script>
                ";
                return;
            }

            $path = time().'.'.$fileParts['extension'];
            $uploaded = $admin->uploadBrandPhoto($path,$brand_id);
            $this->view->avatar = $uploaded;
        }
        if($mode == "delete-brand-foto"){
            $admin = new Application_Model_DbTable_Admin();
            $brand_id = $this->_getParam('brand_id');
            $result = $admin->deleteBrandFoto($brand_id);
            $this->view->result = $result;
        }
        if($mode == 'get-brand-img'){
            $admin = new Application_Model_DbTable_Admin();
            $brand_id = $this->_getParam('brand_id',0);
            $row = $admin->getBrandById($brand_id);
            $this->view->brand_foto_url = $row[0]['brand_foto_url'];
        }
        if($mode == "make-waybill"){
            $admin = new Application_Model_DbTable_Admin();
            $request_id = $this->_getParam("request_id",0);
            $name = $this->_getParam("name",0);
            $result = $admin->makeWaybill($request_id, $name);
            $this->view->result = $result;
        }
        if ($mode == 'get-products-by-barcode'){
            $admin = new Application_Model_DbTable_Admin();
            $barcode = $this->_getParam('barcode');
            $city_id = $this->_getParam('city_id');
            $product_list = $admin->searchProductByBarcode($barcode,$city_id);
            $this->view->product_list = $product_list;
        }

        if ($mode == 'get-products-by-barcode-courier'){
            $admin = new Application_Model_DbTable_Admin();
            $barcode = $this->_getParam('barcode');
            $product_list = $admin->searchProductByBarcodeCourier($barcode);
            $this->view->product_list = $product_list;
        }

        if($mode == "test-close-open-day"){
            $admin = new Application_Model_DbTable_Admin();
            $closed_day_id = $this->_getParam("closed_day_id");
            $city_id = $this->_getParam("city_id");
            $result = $admin->testCloseOpenDay($closed_day_id,$city_id);
            $this->view->result = $result;
        }
        if ($mode == 'add-seller-request'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $allparam['user_id'] = $this->user_id;
            $result = $admin->addSellerRequest($allparam);
            $this->view->result = $result['status'];
        }
        if ($mode == 'save-seller-request'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $allparam['user_id'] = $this->user_id;
            $result = $admin->saveSellerRequest($allparam);
            $this->view->result = $result;
        }
        if($mode == "update-product-availability-by-city"){
            $admin = new Application_Model_DbTable_Admin();
            $product_city_id = $this->_getParam("product_city_id",0);
            $product_id = $this->_getParam("product_id",0);
            $city_id = $this->_getParam("city_id",0);
            $is_available = $this->_getParam("is_available");
            $result = $admin->setProductAvailabilityByCity($product_city_id,$product_id, $city_id,$is_available);
            $this->view->result = $result;
        }
        if($mode == "save-product-price-by-city"){
            $admin = new Application_Model_DbTable_Admin();
            $product_city_id = $this->_getParam("product_city_id",0);
            $product_price_by_city = $this->_getParam("product_price_by_city");
            $product_id = $this->_getParam("product_id",0);
            $city_id = $this->_getParam("city_id",0);
            $result = $admin->setProductPriceByCity($product_city_id,$product_price_by_city, $product_id,$city_id);
            $this->view->result = $result;
        }
        if ($mode == 'get-products-seller'){
            $admin = new Application_Model_DbTable_Admin();
            $product_name = $this->_getParam('product_name');
            $city_id = $this->_getParam('city_id');
            $product_list = $admin->getProductByCharSeller($product_name,$city_id);
            $this->view->product_list = $product_list;
        }
        if ($mode == 'get-products-by-barcode-seller'){
            $admin = new Application_Model_DbTable_Admin();
            $barcode = $this->_getParam('barcode');
            $city_id = $this->_getParam('city_id');
            $product_list = $admin->searchProductByBarcodeSeller($barcode,$city_id);
            $this->view->product_list = $product_list;
        }

        if($mode == "update-basket-products-price"){
            $admin = new Application_Model_DbTable_Admin();
            $session_id = Zend_Session::getId();
            $user_products = $admin->getUserProducts($session_id);

            $current_request_row = $admin->getCurrentSessionRequestId($session_id);
            $current_request_city_id = $current_request_row['city_id'];

            if(count($user_products) > 0){
                foreach($user_products as $key => $user_item){
                    $action_group_price = $admin->getActionGroupPrice($current_request_row['request_id'],$user_item['product_id']);
                    $product_price = $admin->getProductAllPrice($user_item['product_id'],$current_request_city_id);
                    if($user_item['price'] != $action_group_price && $action_group_price > 0){
                        $result = $admin->updateRequestItemProductPrice($user_item['request_item_id'], $action_group_price);
                    }
                    else if($action_group_price == -1 && $product_price == -1){
                        $result = $admin->deleteRequestProduct($user_item['request_item_id']);
                    }
                    else if($action_group_price == -1 && $user_item['price'] != $product_price && $product_price > 0){
                        $result = $admin->updateRequestItemProductPrice($user_item['request_item_id'], $product_price);
                    }
                }
            }
            $this->view->result = $result;
        }

        if($mode == "close-open-era-day"){
            $admin = new Application_Model_DbTable_Admin();
            $closed_day_id = $this->_getParam("closed_day_id");
            $city_id = $this->_getParam("city_id");
            $result = $admin->closeOpenEraDay($closed_day_id,$city_id);
            $this->view->result = $result;
        }

        if($mode == "test-close-open-era-day"){
            $admin = new Application_Model_DbTable_Admin();
            $closed_day_id = $this->_getParam("closed_day_id");
            $city_id = $this->_getParam("city_id");
            $result = $admin->testCloseOpenEraDay($closed_day_id,$city_id);
            $this->view->result = $result;
        }

        if($mode == "delete-banner"){
            $admin = new Application_Model_DbTable_Admin();
            $banner_id = $this->_getParam('banner_id');
            $result = $admin->deleteBanner($banner_id);
            $this->view->result = $result;
        }

        if($mode == 'add-banner-new'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->addBanner($allparam);
            $this->view->result = $result;
        }

        if($mode == 'upload-banner-img'){
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(TRUE);
            $admin = new Application_Model_DbTable_Admin();
            $banner_id = $this->_getParam('banner_id',0);

            $fileTypes = array('jpg','jpeg', 'png');
            $fileParts = pathinfo($_FILES['bannerImg']['name']);
            if (!in_array(strtolower($fileParts['extension']),$fileTypes)) {
                echo "
                  <script>
                    alert('Тип файла не соответствует');
                  </script>
                ";
                return;
            }

            $filename = time().'_' . $banner_id .'.'.$fileParts['extension'];
            $uploaded = $admin->uploadBannerImg($filename,$banner_id);
            $this->view->banner = $uploaded;
        }

        if($mode == 'save-banner-new'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->saveBanner($allparam);
            $this->view->result = $result;
        }

        if($mode == 'delete-banner-city'){
            $admin = new Application_Model_DbTable_Admin();
            $banner_city_id = $this->_getParam('banner_city_id');
            $result = $admin->deleteBannerCity($banner_city_id);
            $this->view->result = $result;
        }

        if($mode == 'delete-provider'){
            $admin = new Application_Model_DbTable_Admin();
            $provider_id = $this->_getParam('provider_id');
            $result = $admin->deleteProvider($provider_id);
            $this->view->result = $result;
        }
        if($mode == 'save-provider'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->saveProvider($allparam);
            $this->view->result = $result;
        }
        if($mode == 'add-provider'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->addProvider($allparam);
            $this->view->result = $result;
        }
        if($mode == "register"){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $email_check = $admin->getUserByEmail($allparam['email']);
            if(count($email_check) > 0){
                $this->view->result = "email_exist";
                return;
            }
            else if($allparam['password'] != $allparam['repeat_password']){
                $this->view->result = "passwords_not_correct";
                return;
            }
            else{
                $result = $admin->register($allparam);
                $this->view->result = $result;
            }
        }

        if($mode == "close-debt"){
            $admin = new Application_Model_DbTable_Admin();
            $user_id = $this->_getParam("user_id",0);
            $result = $admin->closeDebt($user_id);
            $this->view->result = $result;
        }

        if($mode == "save-debt"){
            $admin = new Application_Model_DbTable_Admin();
            $user_id = $this->_getParam("user_id",0);
            $debt = $this->_getParam("debt");
            $result = $admin->saveDebt($user_id,$debt);
            $this->view->result = $result;
        }

        if($mode == "set-brand-new"){
            $admin = new Application_Model_DbTable_Admin();
            $brand_id = $this->_getParam("brand_id",0);
            $is_new = $this->_getParam("is_new",0);
            $result = $admin->setBrandNewStatus($brand_id,$is_new);
            $this->view->result = $result;
        }

        if($mode == "get-product-old-lot-price"){
            $admin = new Application_Model_DbTable_Admin();
            $product_id = $this->_getParam("product_id",0);
            $city_id = $this->_getParam("city_id",0);
            $result = $admin->getProductOldLotPrice($product_id,$city_id);
            $this->view->result = $result;
        }

        if($mode == 'save-city'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->saveCity($allparam);
            $this->view->result = $result;
        }

        if($mode == 'save-sweety-city'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->saveSweetyCity($allparam);
            $this->view->result = $result;
        }

        if($mode == 'delete-city'){
            $admin = new Application_Model_DbTable_Admin();
            $city_id = $this->_getParam('city_id');
            $result = $admin->deleteCity($city_id);
            $this->view->result = $result;
        }

        if($mode == 'delete-sweety-city'){
            $admin = new Application_Model_DbTable_Admin();
            $city_id = $this->_getParam('city_id');
            $result = $admin->deleteSweetyCity($city_id);
            $this->view->result = $result;
        }

        if($mode == 'add-city'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->addCity($allparam);
            $this->view->result = $result;
        }

        if($mode == 'add-sweety-city'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->addSweetyCity($allparam);
            $this->view->result = $result;
        }

        if($mode == 'delete-characteristic-value'){
            $admin = new Application_Model_DbTable_Admin();
            $characteristic_value_id = $this->_getParam("characteristic_value_id",0);
            $result = $admin->deleteCharacteristicValue($characteristic_value_id);
            $this->view->result = $result;
        }

        if($mode == 'get-characteristic-value-list'){
            $admin = new Application_Model_DbTable_Admin();
            $characteristic_id = $this->_getParam("characteristic_id",0);
            $result = $admin->getCharacteristicValueByCharacteristicId($characteristic_id);
            $this->view->result = $result;
        }

        if($mode == 'delete-product-characteristic'){
            $admin = new Application_Model_DbTable_Admin();
            $product_characteristic_id = $this->_getParam("product_characteristic_id",0);
            $result = $admin->deleteProductCharacteristic($product_characteristic_id);
            $this->view->result = $result;
        }

        if($mode == 'set-courier-smena-product-count'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->setCourierSmenaProductCount($allparam);
            $this->view->result = $result;
        }

        if($mode == 'reset-courier-smena-all-product-count-podg'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->resetCourierSmenaAllProductCountPodg($allparam);
            $this->view->result = $result;
        }

        if($mode == 'reset-courier-smena-all-product-count-not-podg'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->resetCourierSmenaAllProductCountNotPodg($allparam);
            $this->view->result = $result;
        }

        if($mode == 'reset-courier-smena-product-count'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->resetCourierSmenaProductCount($allparam);
            $this->view->result = $result;
        }

        if($mode == 'get-courier-request-count'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->getCourierRequestCount($allparam);
            $this->view->result = $result;
        }

        if($mode == 'check-courier-product-count'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->checkCourierProductCount($allparam);
            $this->view->result = $result;
        }

        if($mode == 'delete-courier-smena-product'){
            $admin = new Application_Model_DbTable_Admin();
            $courier_smena_product_id = $this->_getParam("courier_smena_product_id",0);
            $result = $admin->deleteCourierSmenaProduct($courier_smena_product_id);
            $this->view->result = $result;
        }

        if($mode == 'delete-filter-setting'){
            $admin = new Application_Model_DbTable_Admin();
            $filter_setting_id = $this->_getParam("filter_setting_id",0);
            $result = $admin->deleteFilterSetting($filter_setting_id);
            $this->view->result = $result;
        }

        if($mode == 'delete-filter-setting-set'){
            $admin = new Application_Model_DbTable_Admin();
            $filter_setting_set_id = $this->_getParam("filter_setting_set_id",0);
            $result = $admin->deleteFilterSettingSet($filter_setting_set_id);
            $this->view->result = $result;
        }

        if($mode == 'save-filter-setting'){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->saveFilterSetting($allparam);
            $this->view->result = $result;
        }

        if($mode == 'get-request-count-status'){
            $admin = new Application_Model_DbTable_Admin();
            $status_id = $this->_getParam("status_id",0);
            $type = $this->_getParam("type",0);
            if($type == 2){
                $result = $admin->getConsignationRequestCountByStatus($this->user_id, $this->role, $status_id);
            }
            else if($type == 3){
                $result = $admin->getRealisationRequestCountByStatus($this->user_id, $this->role, $status_id);
            }
            else if($type == 4){
                if($this->role == 1){
                    $result = $admin->getAdminSellerReturnRequestCountByStatus($status_id);
                }
                else if($this->role == 2){
                    $result = $admin->getOperatorSellerReturnRequestCountByStatus($this->city_id,$status_id);
                }
                else{
                    $result = $admin->getSellerReturnRequestCountByStatus($this->city_id, $status_id);
                }
            }
            else if($type == 5){
                $result = $admin->getWaitingRequestListByStatusId($status_id,$this->role, $this->city_id, null);
            }
            else{
                $result = $admin->getRequestCountByStatus($this->user_id, $this->role, $status_id);
            }
            $this->view->result = count($result);
        }

        if($mode == "get-comment-count-status"){
            $admin = new Application_Model_DbTable_Admin();
            $status_id = $this->_getParam("status_id",0);
            $result = $admin->getNewProductCommentsByStatus($status_id);
            $this->view->result = count($result);
        }

        if($mode == "save-sweety-comment"){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->updSweetyComment($allparam);
            $this->view->result = $result;
        }

        if($mode == 'save-sweety-comment-img'){
            $admin = new Application_Model_DbTable_Admin();
            $sweety_comment_id = $this->_getParam('sweety_comment_id');

            $fileParts = pathinfo($_FILES['sweety_comment_img']['name']);
            if($_FILES['sweety_comment_img']['name'] > null){
                $path = time().'.'.$fileParts['extension'];
                $uploaded = $admin->updateSweetCommentImg($sweety_comment_id,$path);
            }
            else {
                $path = null;
            }
            $this->_helper->viewRenderer->setNoRender(TRUE);
            $this->_helper->layout->disableLayout();
        }

        if($mode == 'delete-sweety-comment'){
            $admin = new Application_Model_DbTable_Admin();
            $sweety_comment_id = $this->_getParam('sweety_comment_id');
            $result = $admin->deleteSweetyComment($sweety_comment_id);
            $this->view->result = $result;
        }

        if($mode == "save-sweety-shop"){
            $admin = new Application_Model_DbTable_Admin();
            $allparam = $this->_getAllParams();
            $result = $admin->updSweetyShop($allparam);
            $this->view->result = $result;
        }

        if($mode == 'delete-sweety-shop'){
            $admin = new Application_Model_DbTable_Admin();
            $sweety_shop_id = $this->_getParam('sweety_shop_id');
            $result = $admin->deleteSweetyShop($sweety_shop_id);
            $this->view->result = $result;
        }

        if($mode == 'set-request-product-wholesale-price'){
            $admin = new Application_Model_DbTable_Admin();
            $request_id = $this->_getParam('request_id');
            $is_price_wholesale = $this->_getParam('is_price_wholesale');
            $city_id = $this->_getParam('city_id');
            $result = $admin->setRequestProductWholesalePrice($request_id, $is_price_wholesale,$city_id);
            $this->view->result = $result;
        }

        if($mode == 'get-contractor-discount'){
            $admin = new Application_Model_DbTable_Admin();
            $contractor_id = $this->_getParam('contractor_id');
            $result = $admin->getContractorById($contractor_id);
            $this->view->result = $result;
        }

        if($mode == 'get-contractor-wholesale'){
            $admin = new Application_Model_DbTable_Admin();
            $city_id = $this->_getParam("city_id", 0);
            $this->view->city_id = $city_id;

            $year_now = date("Y");
            $month_now = date("m");
            $date_start = $month_now . "/01/" . $year_now ;
            $max_day_in_month = date('t',strtotime($year_now . "/" . $month_now . "/01"));
            $date_end = $month_now . '/'  .$max_day_in_month. '/' . $year_now ;

            $date_range = $this->_getParam('date_range',$date_start . '-' . $date_end);
            $this->view->date_range = $date_range;

            $result_report = $admin->wholesale_contractor_report($date_range, $city_id);
            $this->view->result = $result_report;
        }

        if($mode == "delete-marquee"){
            $admin = new Application_Model_DbTable_Admin();
            $marquee_id = $this->_getParam('marquee_id');
            $city_id = '';
            if($this->role == '2'){
                $city_id = $this->_getParam('city_id');
            }
            $result = $admin->delete_marquee($marquee_id, $city_id, $this->role);
            $this->view->result = $result;
        }

        if($mode == "status-order-post-express"){
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $a = $this->_getAllParams();

            $doc = new DOMDocument('1.0', 'UTF-8');

            $root = $doc->appendChild($doc->createElement('statusreq'));

            $auth = $root->appendChild($doc->createElement('auth'));
            $auth->setAttribute('extra', '78');
            $auth->setAttribute('login', 'Bebek');
            $auth->setAttribute('pass', 'Bebeklogistic@');

            $client = $root->appendChild($doc->createElement('client'));
            $client->appendChild($doc->createTextNode('CLIENT'));
            $orderno = $root->appendChild($doc->createElement('orderno'));
            $orderno->appendChild($doc->createTextNode($a['request_id']));
            $datefrom = $root->appendChild($doc->createElement('datefrom'));
            $datefrom->appendChild($doc->createTextNode(''));
            $dateto = $root->appendChild($doc->createElement('dateto'));
            $dateto->appendChild($doc->createTextNode(''));
            $done = $root->appendChild($doc->createElement('done'));
            $done->appendChild($doc->createTextNode(''));
            $quickstatus = $root->appendChild($doc->createElement('quickstatus'));
            $quickstatus->appendChild($doc->createTextNode('NO'));

            $result =  $doc->saveXML();

            $contents = send_to_post_express($result);

            $xml = simplexml_load_string($contents);

            $status_order = $xml->order->status;
            foreach ($status_order as $value){
                $this->view->result = $value['title'];
            }

        }

        if($mode == "send-to-post-express"){
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            // Заглушка
            /*$results['status'] = false;
            $results['value'][0] = "<span style='color: red; font-weight: bold;'>Функция временно отключена</span>";
            $this->view->result = $results;
            return;*/
            // Заглушка

            $admin = new Application_Model_DbTable_Admin();
            $a = $this->_getAllParams();
            $result = $admin->send_to_postexpress($a['request_id']);
            $result = $result['value'];
            $error = "";

            $doc = new DOMDocument('1.0', 'UTF-8');

            $root = $doc->appendChild($doc->createElement('neworder'));
            $root->setAttribute('newfolder', 'NO');

            $auth = $root->appendChild($doc->createElement('auth'));
            $auth->setAttribute('extra', '78');
            $auth->setAttribute('login', 'Bebek');
            $auth->setAttribute('pass', 'Bebeklogistic@');
            $delivery_type = 0;
            if($result['courier_id'] != 8285){
                $error = "<span style='color: red; font-weight: bold;'>Не назначен курьер PostExpress</span>";
                $results['status'] = false;
                $results['value'][0] = $error;
                $this->view->result = $results;
                return;
            }

            if($result['pay'] == 1){
                $error = "<span style='color: red; font-weight: bold;'>Проставлена галочка 'Оплата доставки получателем' нужно загружать ЧЕРЕЗ EXCEL</span>";
                $results['status'] = false;
                $results['value'][0] = $error;
                $this->view->result = $results;
                return;
            }
            if($result['cod_to_zero'] > 0){
                $result['sum'] = 0;
            }
            if($result['pe_delivery_type'] == 'Д-Д Экспресс'){
                $delivery_type = 6;
            }else if($result['pe_delivery_type'] == 'Д-Д Стандарт'){
                $delivery_type = 5;
            }else if($result['pe_delivery_type'] == 'О-Д;Д-О Стандарт'){
                $delivery_type = 3;
            }else{
                $delivery_type = 6;
            }
            $order = $root->appendChild($doc->createElement('order'));
            $order->setAttribute('orderno', $result['request_id']);
            $sender = $order->appendChild($doc->createElement('sender'));
            $company = $sender->appendChild($doc->createElement('company'));
            $company->appendChild($doc->createTextNode('БЕБЕК.КЗ, ИП'));
            $person = $sender->appendChild($doc->createElement('person'));
            $person->appendChild($doc->createTextNode('Мария'));
            $phone = $sender->appendChild($doc->createElement('phone'));
            $phone->appendChild($doc->createTextNode('87056710204'));
            $town = $sender->appendChild($doc->createElement('town'));
            $town->appendChild($doc->createTextNode('Алматы'));
            $address = $sender->appendChild($doc->createElement('address'));
            $address->appendChild($doc->createTextNode('Шашкина, 29'));
            $receiver = $order->appendChild($doc->createElement('receiver'));
            $company = $receiver->appendChild($doc->createElement('company'));
            $company->appendChild($doc->createTextNode($result['name']));
            $person = $receiver->appendChild($doc->createElement('person'));
            $person->appendChild($doc->createTextNode($result['name1']));
            $phone = $receiver->appendChild($doc->createElement('phone'));
            $phone->appendChild($doc->createTextNode($result['telephone']));
            $town = $receiver->appendChild($doc->createElement('town'));
            $town->appendChild($doc->createTextNode($result['gorod_poluchatelya']));
            $address = $receiver->appendChild($doc->createElement('address'));
            $address->appendChild($doc->createTextNode($result['address']));
            $time_min = $receiver->appendChild($doc->createElement('time_min'));
            $time_min->appendChild($doc->createTextNode($result['since'].':00'));
            $time_max = $receiver->appendChild($doc->createElement('time_max'));
            $time_max->appendChild($doc->createTextNode($result['till'].':00'));
            $weight = $order->appendChild($doc->createElement('weight'));
            $weight->appendChild($doc->createTextNode($result['weight']));
            $quantity = $order->appendChild($doc->createElement('quantity'));
            $quantity->appendChild($doc->createTextNode($result['count']));
            $paytype = $order->appendChild($doc->createElement('paytype'));
            $paytype->appendChild($doc->createTextNode('CASH'));
            $service = $order->appendChild($doc->createElement('service'));
            $service->appendChild($doc->createTextNode($delivery_type));
            $type = $order->appendChild($doc->createElement('type'));
            $type->appendChild($doc->createTextNode('2'));
            $price = $order->appendChild($doc->createElement('price'));
            $price->appendChild($doc->createTextNode($result['sum']));
            $inshprice = $order->appendChild($doc->createElement('inshprice'));
            $inshprice->appendChild($doc->createTextNode($result['req_value']));
            $instruction = $order->appendChild($doc->createElement('instruction'));
            $instruction->appendChild($doc->createTextNode($result['comment']));


            /*header("Content-Type: text/xml");*/
            $result =  $doc->saveXML();

            $contents = send_to_post_express($result);
            $xml = simplexml_load_string($contents);
            $xml2 = new SimpleXMLElement($contents);
            foreach ($xml2 as $value){
                if($value['error'] == 0){
                    $results['status'] = true;
                    $results['value'] = $value['errormsgru'];
                    $this->view->result = $results;
                }else{
                    $results['status'] = false;
                    $results['value'] = $value['errormsgru'];
                    $this->view->result = $results;
                }
            }
            /*foreach($xml->createorder[0]->attributes() as $key => $value){
                if($key == "errormsgru"){
                    $this->view->result = $value;
                }
            }*/
        }

        if($mode == "upd-request-status"){
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $admin = new Application_Model_DbTable_Admin();
            $a = $this->_getAllParams();
            $result = $admin->update_order_postexpress($a);
            $this->view->result = $result;
        }

        if($mode == "save-list-img"){
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $admin = new Application_Model_DbTable_Admin();
            $a = $this->_getAllParams();
            //загрузка фото для списка
            try{
                $check_list_image = $admin->check_list_image($a['list_product_id']);
                if(strlen($check_list_image['value']) > 0){
                    $a['list_image'] = $check_list_image['value'];
                    if (!unlink($_SERVER['DOCUMENT_ROOT'].$check_list_image['value'])){
                        $result['status'] = false;
                        $result['value'] = "Ошибка при удалении" . unlink($check_list_image['value']);
                        $this->view->result = $result;
                        return;
                    }
                    else{
                        $result = $admin->del_list_image($a);
                    }
                }
                $tmpFilePath = $_FILES['list_img_upload']['tmp_name'];
                if ($tmpFilePath != ""){
                    $ext = pathinfo($_FILES['list_img_upload']['name'], PATHINFO_EXTENSION);
                    $dir = $_SERVER['DOCUMENT_ROOT']."/photo/list_images/";
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $filename = "/photo/list_images/".uniqid('list_image_product_id_'.$a['list_product_id'].'_',true)."." . $ext;
                    $newFilePath = $_SERVER['DOCUMENT_ROOT']. $filename;

                    if(move_uploaded_file($tmpFilePath, $newFilePath)) {
                        //сжимаем изображение по высоте
                        $image = new Api_Simpleimage();
                        $image->load($newFilePath);
                        $image->resizeToHeight(216);
                        $resizeFileName = $_SERVER['DOCUMENT_ROOT']. $filename;
                        $image->save($resizeFileName);
                        $a['list_image'] = $filename;

                        $result = $admin->update_list_image($a);
                        $result['list_image'] = $filename;
                        if ($result['status'] == false){
                            $this->view->row = $a;
                            $this->view->err_msg = $result['value'];
                            return;
                        }
                        $this->view->result = $result;
                    }
                }
            } catch(Exception $e){
                $this->view->err_msg = $e->getMessage()."->>"."Ошибка при загрузке файлов";
                return;
            }

        }

        if($mode == "del-list-img"){
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $admin = new Application_Model_DbTable_Admin();
            $a = $this->_getAllParams();
            if (!unlink($_SERVER['DOCUMENT_ROOT'].$a['list_image'])){
                $result['status'] = false;
                $result['value'] = "Ошибка при удалении" . unlink($check_list_image['value']);
                $this->view->result = $result;
                return;
            }
            else{
                $result = $admin->del_list_image($a);
                $this->view->result = $result;
            }
        }

        if($mode == "fast-edit"){
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $admin = new Application_Model_DbTable_Admin();
            $a = $this->_getAllParams();
            $result = $admin->request_fast_edit($a['request_id'], $a['delivery_price'], $a['oper_comment']);
            $this->view->result = $result;
        }

        if($mode == "upd-debt"){
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $admin = new Application_Model_DbTable_Admin();
            $a = $this->_getAllParams();
            $result = $admin->upd_debt($a);
            $this->view->result = $result;
        }

        if($mode == "get-request-info"){
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $admin = new Application_Model_DbTable_Admin();
            $a = $this->_getAllParams();
            $result = $admin->get_request_info($a);
            $this->view->result = $result;
        }
    }
    public function indexAction() {
        $this->view->city_id = $_COOKIE['city'];

        if(!($this->role == '1' || $this->role == '2' || $this->role == '3' || $this->role == '5' || $this->role == '8')) {
            $this->_redirector->gotoUrl('/index/permission');
        }

        if ($this->role == 3){
            $this->_redirector->gotoUrl('/index/cabinet/');
        }

        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $this->view->role = $this->role;
    }
    public function productListAction() {
        if(!($this->role == '1' || ($this->role == '2' && ($this->city_id == '1' || $this->city_id == '93' || $this->city_id == '3')))) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $this->view->search_param = null;
        $city_list = $admin->getMainCities();
        $this->view->city_list = $city_list;
        $this->view->role = $this->role;
        $this->view->city = $this->city_id;
        $this->view->user = $this->user_id;
    }
    public function categoryListBlockAction(){
        if ($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->layout->disableLayout();
        }
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $admin = new Application_Model_DbTable_Admin();
        $row = $admin->getCategories();
        echo $this->view->partialLoop('/admin/category-list-block.phtml', $row);
    }
    public function productTypeBlockAction(){
        if ($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->layout->disableLayout();
        }
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $admin = new Application_Model_DbTable_Admin();
        $row = $admin->getProductTypes();
        echo $this->view->partialLoop('/admin/product-type-block.phtml', $row);
    }
    public function brandBlockAction(){
        if ($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->layout->disableLayout();
        }
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $admin = new Application_Model_DbTable_Admin();
        $row = $admin->getBrands();
        echo $this->view->partialLoop('/admin/brand-block.phtml', $row);
    }
    public function getProductListAction(){
        if ($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->layout->disableLayout();
        }
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $admin = new Application_Model_DbTable_Admin();
        $allparam = $this->_getAllParams();
        $row = $admin->searchProductByParam($allparam);
        for($i = 0; $i < count($row); $i++){
            $row[$i]['city_id2'] = $allparam['city_id2'];
        }
        echo $this->view->partialLoop('/admin/get-product-list.phtml', $row);
    }
    public function productTypeEditAction(){
        $this->_helper->layout->disableLayout();
    }
    public function brandEditAction(){
        $this->_helper->layout->disableLayout();
    }
    public function categoryEditAction(){
        $this->_helper->layout->disableLayout();
    }
    public function modalCategoryListAction(){
        $this->_helper->layout->disableLayout();
        $this->view->action_type = $this->_getParam('action_type');
    }
    public function getCharacteristicListAction(){
        if ($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->layout->disableLayout();
        }
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $admin = new Application_Model_DbTable_Admin();
        $product_type_id = $this->_getParam("product_type_id");
        if($product_type_id > 0){
            $row = $admin->searchCharacteristic($product_type_id);
        }
        else{
            $row = $admin->getAllCharacteristics();
        }
        echo $this->view->partialLoop('/admin/get-characteristic-list.phtml', $row);
    }
    public function editProductAction(){
        if(!($this->role == '1' || ($this->role == '2' && ($this->city_id == '1' || $this->city_id == '93' || $this->city_id == '3')))) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $product_id = $this->_getParam("product_id");
        $row = $admin->getProductById($product_id);
        $this->view->row = $row;
        $this->view->role = $this->role;
    }
    public function editCharacteristicAction(){
        if(!($this->role == '1' or $this->user_id == 10983)) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $characteristic_id = $this->_getParam("characteristic_id");
        $row = $admin->getCharacteristicById($characteristic_id);
        $this->view->row = $row;
        $this->view->role = $this->role;
    }
    public function requestListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        if (isset($_POST["button_order"])) {
            $this->_helper->viewRenderer->setNoRender(TRUE);
            $this->_helper->layout->disableLayout();
            $a = $this->_getAllParams();
            foreach ($a as $key => $value) {
                if ($a[$key] == "on"){
                    $a[$key] = 1;
                }
            }
            require_once 'phpexcel/Classes/PHPExcel/IOFactory.php';
            $today = gmdate("d.m.y H:i:s", time() + 21600);
            $order_row = $admin->send_to_postexpress_excel($a);
            $row = $order_row['value'];
            $api = new Api_Flexcell();

            $tempFile = $_SERVER['DOCUMENT_ROOT']."/order/order_template.xlsx";
            $api->load($tempFile);
            $api->setActiveSheet(0);
//            $api->setVariable();
            $api->setMultipleRowData($row, 'scan');
            $api->export('order ('.$today.')');
            return;

        }

        if (isset($_POST["order_post_express"])) {
            $today = gmdate("d.m.y H:i:s", time() + 21600);
            $order_row = $admin->orderPostExpress();
            $row = $order_row;
            $filename = 'PostExpress' . ' ' . '(' . $today . ').xls';

            $objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT'] . "/order/pe_template.xls");
            $empty_sheet_counter = 10;
            $counter = 11;
            $i = 0;
            if(count($order_row) != 0){
                foreach ($order_row as $value) {
                    $i++;
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $i);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $value['since']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $value['till']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $value['request_id']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, $value['barcode']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $counter, $value['delivery_type']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, $value['payment_type']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I' . $counter, $value['otprav_type']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $counter, $value['gorod_poluchatelya']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K' . $counter, $value['address']);
                    $objPHPExcel->getActiveSheet()->setCellValue('L' . $counter, $value['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('M' . $counter, $value['name1']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N' . $counter, $value['telephone']);
                    $objPHPExcel->getActiveSheet()->setCellValue('O' . $counter, $value['weight']);
                    $objPHPExcel->getActiveSheet()->setCellValue('P' . $counter, $value['count']);
                    $objPHPExcel->getActiveSheet()->setCellValue('Q' . $counter, $value['sum']);
                    $objPHPExcel->getActiveSheet()->setCellValue('R' . $counter, $value['req_value']);
                    $objPHPExcel->getActiveSheet()->setCellValue('S' . $counter, $value['adds']);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':' . 'S' . $counter)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $objPHPExcel->getActiveSheet()->setCellValue('Z' . $counter, $value['1_7']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AA' . $counter, $value['1_8']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AB' . $counter, $value['1_9']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AC' . $counter, $value['1_10']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AD' . $counter, $value['1_11']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AE' . $counter, $value['comment']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AF' . $counter, $value['index_']);
                    $objPHPExcel->getActiveSheet()->setCellValue('AG' . $counter, '');
                    $objPHPExcel->getActiveSheet()->getStyle('Z' . $counter . ':' . 'AG' . $counter)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $order_prod = $admin->pe_order_products();

                    $auto_all = $order_prod;
//                $counter++;
                    $begin = $counter;
                    foreach ($auto_all as $value2) {
                        if ($value['request_id'] == $value2['request_id']) {
                            $objPHPExcel->getActiveSheet()->setCellValue('T' . $counter, $value2['artikul']);
                            $objPHPExcel->getActiveSheet()->setCellValue('U' . $counter, $value2['1_2']);
                            $objPHPExcel->getActiveSheet()->setCellValue('V' . $counter, $value2['1_3']);
                            $objPHPExcel->getActiveSheet()->setCellValue('W' . $counter, $value2['units']);
                            if($value2['is_epay'] == 1){
                                $objPHPExcel->getActiveSheet()->setCellValue('X' . $counter, 0);
                            }else{
                                $objPHPExcel->getActiveSheet()->setCellValue('X' . $counter, $value2['price']);
                            }
                            $objPHPExcel->getActiveSheet()->setCellValue('Y' . $counter, $value2['1_6']);
                            $objPHPExcel->getActiveSheet()->getStyle('T' . $counter . ':' . 'Y' . $counter)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $counter++;
                        }
                    }

                    if ($value['delivery_price'] != 0) {
//                    $counter++;
                        $objPHPExcel->getActiveSheet()->setCellValue('T' . $counter, 'ud001');
                        $objPHPExcel->getActiveSheet()->setCellValue('U' . $counter, 'Доставка БЕБЕК.КЗ');
                        $objPHPExcel->getActiveSheet()->setCellValue('V' . $counter, '1');
                        $objPHPExcel->getActiveSheet()->setCellValue('W' . $counter, '1');
                        $objPHPExcel->getActiveSheet()->setCellValue('X' . $counter, $value['delivery_price']);
                        $objPHPExcel->getActiveSheet()->setCellValue('Y' . $counter, '');
                        $objPHPExcel->getActiveSheet()->getStyle('T' . $counter . ':' . 'Y' . $counter)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        $counter++;
                    }
//                $counter++;
                }
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('A' . ($empty_sheet_counter+1), 'Нет данных для выгрузки!');
                $objPHPExcel->getActiveSheet()->mergeCells('A' . ($empty_sheet_counter+1) . ':AG' . ($empty_sheet_counter+1));
                $objPHPExcel->getActiveSheet()->getStyle('A' . ($empty_sheet_counter+1) . ':AG' . ($empty_sheet_counter+1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f3f3f3');
                $objPHPExcel->getActiveSheet()->getStyle('A' . ($empty_sheet_counter+1) . ':AG' . ($empty_sheet_counter+1))->getFont()->setSize(16)->setBold();
//                $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            }

            header('Content-Type: application/vnd.ms-excel');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');

            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            header("Content-Disposition: attachment;filename=$filename");

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;

        }

        $status_id = $this->_getParam("status_id");

        $allparam['request_id'] = $this->_getParam('request_id', "");
        $allparam['fio_search'] = $this->_getParam('fio_search',"");
        $allparam['email_search'] = $this->_getParam('email_search',"");
        $allparam['address_search'] = $this->_getParam('address_search',"");
        $allparam['date_range'] = $this->_getParam('date_range',"");
        $allparam['city_search'] = $this->_getParam('city_search',null);
        $allparam['is_pickup_search'] = $this->_getParam('is_pickup_search',null);
        $allparam['is_wholesale_search'] = $this->_getParam('is_wholesale_search',null);
        $allparam['is_online_search'] = $this->_getParam('is_online_search',null);
        $allparam['is_epay_search'] = $this->_getParam('is_epay_search',null);
        $allparam['user_id'] = $this->user_id;
        $allparam['role'] = $this->role;
        $allparam['product_id'] = $this->_getParam("product_id","");
        $allparam['new_product_add'] = $this->_getParam("new_product_add","");
        $allparam['barcode_search'] = $this->_getParam("new_product_barcode_input","");

        $this->view->city_id = $this->city_id;

        $request_list = $admin->getRequestListByStatus($allparam,$status_id);
        $this->view->status_id = $status_id;
        $this->view->row = $request_list;
        $this->view->allparam = $allparam;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($request_list);
        $paginator->setItemCountPerPage(50);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;

        $params = $this->_getAllParams();
        if(isset($params['resetSearch'])){
            $this->_redirector->gotoUrl('/admin/request-list?status_id='.$status_id);
        }
    }
    public function requestEditAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $request_id = $this->_getParam("request_id");

        $row = $admin->getSweetyCityList();
        $this->view->sweety_city_list = $row;

        $check_request_for_edit = $admin->checkRequestForEdit($request_id);
        if($check_request_for_edit['status_id'] == 2){
            $this->_redirector->gotoUrl("/admin/permission?error=request_closed");
        }
        $row = $admin->getRequestById($request_id);
        $this->view->row = $row;
        $this->view->city_id = $this->city_id;
    }

    public function permissionAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $this->view->error = $this->_getParam("error","");
    }

    public function modalBrandDescriptionAction(){
        $this->_helper->layout->disableLayout();
        $admin = new Application_Model_DbTable_Admin();
        $brand_id = $this->_getParam('brand_id');
        $brand = $admin->getBrandById($brand_id);
        $this->view->brand = $brand;
    }
    public function loginAction(){
        $user = new Application_Model_DbTable_User();
        $this->_helper->layout->disableLayout();
        $allparam = $this->_getAllParams();
        $this->view->error = "";
        if (Zend_Auth::getInstance()->hasIdentity()) {
            if($this->role == '1' || $this->role == '2') {
                $this->_helper->redirector('index', 'admin');
            }
            else{
                $this->_helper->redirector('cabinet', 'index');
            }
        }
        if($this->getRequest()->isPost() && isset($allparam['login_btn'])){
            $login = strtolower($this->_getParam('email'));
            $this->view->login = $login;
            $password = $this->_getParam('password');
            if(strlen($login) < 1 || strlen($password) < 1){
                $this->view->error = "Введите все данные";
                return false;
            }
            $api = new Api_Project();
            $user_info = $user->getUser($login);
            $result = $api->setAuth($login, $password);
            if ($user_info['is_blocked'] == 1){
                $this->view->error = 'Ваш аккаунт заблокирован';
                return false;
            }
            if ($result) {
                $updDate =  $user->updLastLogin($login);
                $_SESSION['user_name'] = $user_info['name'];
                $_SESSION['email'] = $user_info['email'];
                $_SESSION['role'] = $user_info['role'];
                if($user_info['city_id'] == 99){
                    setcookie('city',99,time() + 2*7*24*60*60,'/',NULL);
                }
                else if($user_info['city_id'] == 98){
                    setcookie('city',98,time() + 2*7*24*60*60,'/',NULL);
                }

                if ($user_info['role'] == 3){
                    $this->_redirector->gotoUrl('/index/cabinet/');
                }
                else{
                    $this->_redirector->gotoUrl('/admin/');
                }

                return false;
            }
            else {
                $this->view->error = 'Неправильный логин или пароль!';
                return false;
            }
        }
    }
    public function logoutAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if($_COOKIE['city'] == 99){
            setcookie('city',1,time() + 2*7*24*60*60,'/',NULL);
        }
        else if($_COOKIE['city'] == 98){
            setcookie('city',1,time() + 2*7*24*60*60,'/',NULL);
        }
        $_SESSION['user_name'] = null;
        $_SESSION['social'] = null;
        $_SESSION['email'] = null;
        $_SESSION['photo_big'] = null;
        $_SESSION['link'] = null;
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index', 'index');
    }
    public function userRequestListAction(){
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $status_id = $this->_getParam("status_id");

        $allparam['fio_search'] = $this->_getParam('fio_search',"");
        $allparam['email_search'] = $this->_getParam('email_search',"");
        $allparam['address_search'] = $this->_getParam('address_search',"");
        $allparam['date_range'] = $this->_getParam('date_range',"");
        $allparam['city_search'] = $this->_getParam('city_search',null);
        $allparam['user_id'] = $this->user_id;

        $request_list = $admin->getUserRequestListByStatus($allparam,$status_id);
        $this->view->status_id = $status_id;
        $this->view->user_id = $this->user_id;
        $this->view->row = $request_list;
        $this->view->allparam = $allparam;
        $params = $this->_getAllParams();
        if(isset($params['resetSearch'])){
            $this->_redirector->gotoUrl('/admin/user-request-list');
        }
    }
    public function resetPasswordAction(){
        $user = new Application_Model_DbTable_User();
        $this->_helper->layout->disableLayout();
        $allparam = $this->_getAllParams();
        $this->view->error = "";
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('index', 'admin');
        }
        if($this->getRequest()->isPost() && isset($allparam['reset_pass_btn'])){
            $login = strtolower($this->_getParam('reset_email'));
            $this->view->login = $login;
            if(strlen($login) < 1){
                $this->view->error = "Введите логин";
                return false;
            }
            $user_info = $user->getUser($login);
            $send_mail = $user->resetPassword($login);
            if ($user_info['is_blocked'] == 1){
                $this->view->error = 'Ваш аккаунт заблокирован';
                return false;
            }
            if ($send_mail == true) {
                $this->view->error = 'Новый пароль отправлен на почту';
                return false;
            }
            else {
                $this->view->error = 'Неправильный логин';
                return false;
            }
        }
    }
    public function graphicsListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
    }
    public function mailingToUsersAction(){
        if(!($this->role == '1')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $clients = $admin->getClientList();
        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($clients);
        $paginator->setItemCountPerPage(20);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }
    public function offerListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $offer_list = $admin->getOfferList();
        $this->view->row = $offer_list;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($offer_list);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }
    public function offerEditAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $offer_id = $this->_getParam("offer_id");
        $row = $admin->getOfferById($offer_id);
        $this->view->row = $row;
    }
    public function addProductAction(){
        if(!($this->role == '1' || $this->role == '2' && ($this->city_id == '1' || $this->city_id == '93' || $this->city_id == '3'))) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
    }
    public function commentListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $status_id = $this->_getParam("status_id");
        $comment_list = $admin->getNewProductCommentsByStatus($status_id);
        $this->view->row = $comment_list;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($comment_list);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }
    public function commentEditAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $comment_id = $this->_getParam("comment_id");
        $row = $admin->getCommentById($comment_id);
        $this->view->row = $row;
    }
    public function vkAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $code = $this->_getParam('code', '');
        if ($code == '')
            return;
        $config = array(
            'adapter'      => 'Zend_Http_Client_Adapter_Socket',
            'keepalive' => true,
            'maxredirects' => 10,
            'timeout' => 30
        );
        $client = new Zend_Http_Client('https://oauth.vk.com/access_token', $config);

        $client->setParameterGet(array(
            'client_id'  => '4463450',
            'client_secret' => 'XXm8PxrWTjH2V0ZZlnA0',
            'redirect_uri' => 'http://'.Zend_Registry::getInstance()->constants->site_url.'/admin/vk',
            'code'     => $code
        ));

        $resp = json_decode($client->request("GET")->getBody(), true);

        $client = new Zend_Http_Client('https://api.vk.com/method/users.get', $config);
        $client->setHeaders('Content-type', 'application/json; charset=utf-8');
        $client->setParameterGet(array(
            'access_token' => $resp["access_token"],
            'fields' => ' uid,first_name,photo_big'
        ));
        $resp = json_decode($client->request("GET")->getBody(), true);

        $param['uid'] = $resp['response'][0]['uid'];
        $param['first_name'] = $resp['response'][0]['first_name'];
        $param['last_name'] = $resp['response'][0]['last_name'];
//        $param['gender'] = $resp['response'][0]['sex'];
        $param['photo_big'] = $resp['response'][0]['photo_big'];

        $user_name = $param['first_name'] .  " " . $param['last_name'];
        $_SESSION['user_name'] = $user_name;
        $_SESSION['social'] = 1;
        $_SESSION['email'] = null;
        $_SESSION['photo_big'] = $param['photo_big'];
        $_SESSION['link'] = "http://vk.com/id".$param['uid'];
        $p_id = $_COOKIE['session_product'];
        $this->_redirector->gotoUrl('/index/product-info?product_id='.$p_id."#comment_form");
    }
    public function facebookAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $code = $this->_getParam('code', '');
        if ($code == '')
            return;
        $config = array(
            'adapter'      => 'Zend_Http_Client_Adapter_Socket',
            'keepalive' => true,
            'maxredirects' => 10,
            'timeout' => 30
        );
        $client = new Zend_Http_Client('https://graph.facebook.com/oauth/access_token', $config);

        $client->setParameterGet(array(
            'client_id'  => '776695622382689',
            'client_secret' => '27eb8d8e1ebe2ac3fd3f895ee5b0e4cc',
            'redirect_uri' => 'http://'.Zend_Registry::getInstance()->constants->site_url.'/admin/facebook',
            'code'     => $code
        ));

        $resp = $client->request("GET")->getBody();
        $arr = array();
        parse_str($resp, $resp);

        $client = new Zend_Http_Client('https://graph.facebook.com/me', $config);

        $client->setHeaders('Content-type', 'application/json; charset=utf-8');

        $client->setParameterGet(array(
            'access_token' => $resp["access_token"]
        ));

        $resp = json_decode($client->request("GET")->getBody(), true);

        $param['uid'] = $resp['id'];
        $param['first_name'] = $resp['first_name'];
        $param['email'] = $resp['email'];
        $param['last_name'] = $resp['last_name'];
        $param['link'] = $resp['link'];
        $param['photo_big'] = 'http://graph.facebook.com/'.$resp['id'].'/picture';

        $user_name = $param['first_name'] .  " " . $param['last_name'];
        $_SESSION['user_name'] = $user_name;
        $_SESSION['social'] = 2;
        $_SESSION['email'] = $param['email'];
        $_SESSION['photo_big'] = $param['photo_big'];
        $_SESSION['link'] = $param['link'];
        $p_id = $_COOKIE['session_product'];
        $this->_redirector->gotoUrl('/index/product-info?product_id='.$p_id."#comment_form");
    }
    public function lotsListAction(){
        if(!($this->role == '1' || $this->role == '2' || $this->role == '5')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $allparam['product_id'] = $this->_getParam("product_id","");
        $allparam['date_range'] = $this->_getParam("date_range","");
        $allparam['new_product_add'] = $this->_getParam("new_product_add","");
        $allparam['provider_id'] = $this->_getParam("provider_id","");
        $allparam['city_id'] = $this->_getParam("city_id","");
        $allparam['barcode'] = $this->_getParam("new_product_barcode_input","");
        if($this->user_id == 10983){
            $this->city_id = $allparam['city_id'];
        }
        if($this->city_id > 0 && ($this->role == '2' || $this->role == '5')){
            $lots_list = $admin->getOperatorLotsList($this->city_id,$allparam);
        }
        else{
            $lots_list = $admin->getLotsListByParams($allparam);
        }

        $this->view->row = $lots_list;
        $this->view->allparam = $allparam;
        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($lots_list);
        $paginator->setItemCountPerPage(100);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }
    public function editLotAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $lot_id = $this->_getParam("lot_id");
        $row = $admin->getLotById($lot_id);
        $this->view->row = $row;
        $this->view->role = $this->role;
        $this->view->city_id = $this->city_id;
    }
    public function dayCloseAction(){
        if(!($this->role == '1' || $this->role == '2' || $this->role == '5')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $city_id = $this->_getParam("city_id",0);
        $this->_helper->layout->setLayout('layout-operator');
        $this->view->close_city_id = $city_id;
    }
    public function consignationRequestListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $status_id = $this->_getParam("status_id");

        $allparam['fio_search'] = $this->_getParam('fio_search',"");
        $allparam['email_search'] = $this->_getParam('email_search',"");
        $allparam['address_search'] = $this->_getParam('address_search',"");
        $allparam['date_range'] = $this->_getParam('date_range',"");
        $allparam['city_search'] = $this->_getParam('city_search',null);
        $allparam['is_pickup_search'] = $this->_getParam('is_pickup_search',null);
        $allparam['is_wholesale_search'] = $this->_getParam('is_wholesale_search',null);
        $allparam['is_online_search'] = $this->_getParam('is_online_search',null);
        $allparam['contractor_search'] = $this->_getParam('contractor_search',null);
        $allparam['user_id'] = $this->user_id;
        $allparam['role'] = $this->role;
        $allparam['product_id'] = $this->_getParam("product_id","");
        $allparam['new_product_add'] = $this->_getParam("new_product_add","");
        $allparam['barcode_search'] = $this->_getParam("new_product_barcode_input","");
        $request_list = $admin->getConsignationRequestListByStatus($allparam,$status_id);
        $this->view->status_id = $status_id;
        $this->view->row = $request_list;
        $this->view->allparam = $allparam;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($request_list);
        $paginator->setItemCountPerPage(50);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;

        $params = $this->_getAllParams();
        if(isset($params['resetSearch'])){
            $this->_redirector->gotoUrl('/admin/consignation-request-list?status_id='.$status_id);
        }
    }
    public function realisationRequestListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $status_id = $this->_getParam("status_id");

        $allparam['fio_search'] = $this->_getParam('fio_search',"");
        $allparam['email_search'] = $this->_getParam('email_search',"");
        $allparam['address_search'] = $this->_getParam('address_search',"");
        $allparam['date_range'] = $this->_getParam('date_range',"");
        $allparam['city_search'] = $this->_getParam('city_search',null);
        $allparam['is_pickup_search'] = $this->_getParam('is_pickup_search',null);
        $allparam['is_wholesale_search'] = $this->_getParam('is_wholesale_search',null);
        $allparam['is_online_search'] = $this->_getParam('is_online_search',null);
        $allparam['contractor_search'] = $this->_getParam('contractor_search',null);
        $allparam['user_id'] = $this->user_id;
        $allparam['role'] = $this->role;
        $allparam['product_id'] = $this->_getParam("product_id","");
        $allparam['new_product_add'] = $this->_getParam("new_product_add","");
        $allparam['barcode_search'] = $this->_getParam("new_product_barcode_input","");
        $request_list = $admin->getRealisationRequestListByStatus($allparam,$status_id);
        $this->view->status_id = $status_id;
        $this->view->row = $request_list;
        $this->view->allparam = $allparam;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($request_list);
        $paginator->setItemCountPerPage(50);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;

        $params = $this->_getAllParams();
        if(isset($params['resetSearch'])){
            $this->_redirector->gotoUrl('/admin/realisation-request-list?status_id='.$status_id);
        }
    }
    public function balansAccountAction(){
        if(!($this->role == '1' || $this->role == '2' || $this->role == '5')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
    }

    public function balansAccountNewAction(){
        if(!($this->role == '1' || $this->role == '2' || $this->role == '5')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $brand_list = $admin->getBrands();
        $this->view->brand_list = $brand_list;
    }
    public function balansAccountListFormAction(){
        if ($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->layout->disableLayout();
        }
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $admin = new Application_Model_DbTable_Admin();
        $allparam = $this->_getAllParams();
        $row = $admin->searchProductByParamBalans($allparam);
        echo $this->view->partialLoop('/admin/balans-account-list-form.phtml', $row);
    }
    public function balansAccountListFormNewAction(){
        $this->_helper->layout->disableLayout();
        $admin = new Application_Model_DbTable_Admin();
        $allparam = $this->_getAllParams();
        $row = $admin->searchProductByParamBalansNew($allparam);
        $this->view->row = $row['value'];
    }
    public function profitByDaysAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
    }
    public function profitByProductsAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
    }
    public function contractorPayListAction(){
        if(!($this->role == '1' || ($this->role == '2' && ($this->city_id == '1' || $this->city_id == '93')))) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $contractor_pay_list = $admin->getContractorPayList();
        $this->view->row = $contractor_pay_list;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($contractor_pay_list);
        $paginator->setItemCountPerPage(50);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }
    public function editPayAction(){
        if(!($this->role == '1' || ($this->role == '2' && ($this->city_id == '1' || $this->city_id == '93')))) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $contractor_pay_id = $this->_getParam("contractor_pay_id");
        $row = $admin->getPayById($contractor_pay_id);
        $this->view->row = $row;
    }
    public function contractorListAction(){
        if(!($this->role == '1' || ($this->role == '2' && ($this->city_id == '1' || $this->city_id == '93' || $this->city_id == '105' || $this->city_id == '108')))) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $contractor_list = $admin->getContractorList();
        $this->view->row = $contractor_list;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($contractor_list);
        $paginator->setItemCountPerPage(50);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }
    public function contractorEditAction(){
        if(!($this->role == '1' || ($this->role == '2' && ($this->city_id == '1' || $this->city_id == '93' || $this->city_id == '105' || $this->city_id == '108')))) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $contractor_id = $this->_getParam("contractor_id");
        $row = $admin->getSweetyCityList();
        $this->view->sweety_city_list = $row;
        $row = $admin->getContractorById($contractor_id);
        $this->view->row = $row;
    }
    public function waitingRequestListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $status_id = $this->_getParam("status_id",0);

        $allparam['city_search'] = $this->_getParam('city_search',null);
        $allparam['brand_search'] = $this->_getParam('brand_search',null);
        $allparam['product_id'] = $this->_getParam("product_id","");
        $allparam['new_product_add'] = $this->_getParam("new_product_add","");
        $waiting_request_list = $admin->getWaitingRequestListByStatusId($status_id,$this->role, $this->city_id,$allparam);
        $this->view->row = $waiting_request_list;
        $this->view->role = $this->role;
        $this->view->allparam = $allparam;
        $this->view->status_id = $status_id;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($waiting_request_list);
        $paginator->setItemCountPerPage(20);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;

        $params = $this->_getAllParams();
        if(isset($params['resetSearch'])){
            $this->_redirector->gotoUrl('/admin/waiting-request-list?status_id='.$status_id);
        }
    }

    public function inviteFriendAction(){
        if(!($this->role == '3')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        else{
            $this->_redirector->gotoUrl('/priglasi-druga/');
        }

        $this->_helper->layout->setLayout('layout-operator');
    }
    public function userListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $name = $this->_getParam("name","");
        $email = $this->_getParam("email","");
        $phone = $this->_getParam("phone","");
        $user_list = $admin->getClientUserList($name,$email,$phone);
        $this->view->row = $user_list;
        $this->view->search_name = $name;
        $this->view->search_phone = $phone;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($user_list);
        $paginator->setItemCountPerPage(20);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }

    public function employeeListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $name = $this->_getParam("name","");
        $email = $this->_getParam("email","");
        $user_list = $admin->getEmployeeUserList($name,$email);
        $this->view->row = $user_list;
        $this->view->search_name = $name;
        $this->view->search_email = $email;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($user_list);
        $paginator->setItemCountPerPage(20);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }

    public function vk2Action(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $code = $this->_getParam('code', '');
        if ($code == '')
            return;
        $config = array(
            'adapter'      => 'Zend_Http_Client_Adapter_Socket',
            'keepalive' => true,
            'maxredirects' => 10,
            'timeout' => 30
        );
        $client = new Zend_Http_Client('https://oauth.vk.com/access_token', $config);

        $client->setParameterGet(array(
            'client_id'  => '4463450',
            'client_secret' => 'XXm8PxrWTjH2V0ZZlnA0',
            'redirect_uri' => 'http://'.Zend_Registry::getInstance()->constants->site_url.'/admin/vk2',
            'code'     => $code
        ));

        $resp = json_decode($client->request("GET")->getBody(), true);

        $client = new Zend_Http_Client('https://api.vk.com/method/users.get', $config);
        $client->setHeaders('Content-type', 'application/json; charset=utf-8');
        $client->setParameterGet(array(
            'access_token' => $resp["access_token"],
            'fields' => ' uid,first_name,photo_big'
        ));
        $resp = json_decode($client->request("GET")->getBody(), true);

        $param['uid'] = $resp['response'][0]['uid'];
        $param['first_name'] = $resp['response'][0]['first_name'];
        $param['last_name'] = $resp['response'][0]['last_name'];
//        $param['gender'] = $resp['response'][0]['sex'];
        $param['photo_big'] = $resp['response'][0]['photo_big'];

        $user_name = $param['first_name'] .  " " . $param['last_name'];
        $_SESSION['user_name'] = $user_name;
        $_SESSION['social'] = 1;
        $_SESSION['email'] = null;
        $_SESSION['photo_big'] = $param['photo_big'];
        $_SESSION['link'] = "http://vk.com/id".$param['uid'];
        $p_id = $_COOKIE['session_product'];
        $this->_redirector->gotoUrl('/index/feedback-list/');
    }
    public function facebook2Action(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $code = $this->_getParam('code', '');
        if ($code == '')
            return;
        $config = array(
            'adapter'      => 'Zend_Http_Client_Adapter_Socket',
            'keepalive' => true,
            'maxredirects' => 10,
            'timeout' => 30
        );
        $client = new Zend_Http_Client('https://graph.facebook.com/oauth/access_token', $config);

        $client->setParameterGet(array(
            'client_id'  => '776695622382689',
            'client_secret' => '27eb8d8e1ebe2ac3fd3f895ee5b0e4cc',
            'redirect_uri' => 'http://'.Zend_Registry::getInstance()->constants->site_url.'/admin/facebook2',
            'code'     => $code
        ));

        $resp = $client->request("GET")->getBody();
        $arr = array();
        parse_str($resp, $resp);

        $client = new Zend_Http_Client('https://graph.facebook.com/me', $config);

        $client->setHeaders('Content-type', 'application/json; charset=utf-8');

        $client->setParameterGet(array(
            'access_token' => $resp["access_token"]
        ));

        $resp = json_decode($client->request("GET")->getBody(), true);

        $param['uid'] = $resp['id'];
        $param['first_name'] = $resp['first_name'];
        $param['email'] = $resp['email'];
        $param['last_name'] = $resp['last_name'];
        $param['link'] = $resp['link'];
        $param['photo_big'] = 'http://graph.facebook.com/'.$resp['id'].'/picture';

        $user_name = $param['first_name'] .  " " . $param['last_name'];
        $_SESSION['user_name'] = $user_name;
        $_SESSION['social'] = 2;
        $_SESSION['email'] = $param['email'];
        $_SESSION['photo_big'] = $param['photo_big'];
        $_SESSION['link'] = $param['link'];
        $p_id = $_COOKIE['session_product'];
        $this->_redirector->gotoUrl('/index/feedback-list/');
    }

    public function productFotoListAction(){
        if ($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->layout->disableLayout();
        }
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $admin = new Application_Model_DbTable_Admin();
        $product_id = $this->_getParam("product_id",0);
        $product_foto_list = $admin->getProductFoto($product_id);
        echo $this->view->partialLoop('/admin/product-foto-list.phtml', $product_foto_list);
    }
    public function lotEditModalAction(){
        $this->_helper->layout->disableLayout();
        $this->view->city_id = $this->city_id;
    }

    public function inventoryListAction(){
        if(!($this->role == '1' || $this->role == '2' || $this->role == '5')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $allparam['product_id'] = $this->_getParam("product_id","");
        $allparam['date_range'] = $this->_getParam("date_range","");
        $allparam['new_product_add'] = $this->_getParam("new_product_add","");
        $allparam['city_id'] = $this->_getParam("city_id","");
        if($this->city_id > 0 && ($this->role == '2' || $this->role == '5')){
            $inventory_list = $admin->getOperatorInventoryList($this->city_id);
        }
        else{
            $inventory_list = $admin->getInventoryListByParams($allparam);
        }

        $this->view->row = $inventory_list;
        $this->view->allparam = $allparam;
        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($inventory_list);
        $paginator->setItemCountPerPage(100);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }

    public function inventoryEditModalAction(){
        $this->_helper->layout->disableLayout();
        $this->view->city_id = $this->city_id;
    }

    public function editInventoryAction(){
        if(!($this->role == '1' || $this->role == '2' || $this->role == '5')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $inventory_id = $this->_getParam("inventory_id");
        $row = $admin->getInventoryById($inventory_id);
        $this->view->row = $row;
        $this->view->role = $this->role;
        $this->view->city_id = $this->city_id;
    }

    public function checkClientAuthorizationAction(){
        echo "0";
        return;
        /*
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $city_id = $this->_getParam("city_id", 0);
        if(isset($_POST["response"])){
            $response = $_POST["response"];
            log_kkb('RESPONSE: ', $response);
            $this->postLink($response, $city_id);
        } */

    }

    private function postLink($response, $city_id){
        /*
        try{
            $flag = false;
            $admin = new Application_Model_DbTable_Admin();
            if($city_id == '93'){
                require_once("paysys_almaty/kkb.utils.php");
                $path1 = 'paysys_almaty/config.txt';
            }
            if($city_id == '1'){
                require_once("paysys_astana/kkb.utils.php");
                $path1 = 'paysys_astana/config.txt';
            }
            log_kkb('CLIENT CITY ID: ', $city_id);
            //        require_once("paysys/kkb.utils.php");
            //        $path1 = 'paysys/config.txt';
            $current = '';
            $result = process_response(stripslashes($response),$path1);


            log_kkb('RESULT: ', json_encode($result));
            if (is_array($result)){
                if (in_array("ERROR",$result)){
                    log_kkb('ERROR: ', $result);
                    if ($result["ERROR_TYPE"]=="ERROR"){
                        $current = "System error: ".$result["ERROR"];
                        log_kkb('SYSTEM ERROR: ', $current);
                    } elseif ($result["ERROR_TYPE"]=="system"){
                        $current = "Bank system error > Code: '".$result["ERROR_CODE"]."' Text: '".$result["ERROR_CHARDATA"]."' Time: '".$result["ERROR_TIME"]."' Order_ID: '".$result["RESPONSE_ORDER_ID"]."'";
                        log_kkb('ERROR_TYPE->system: ', $current);
                    }elseif ($result["ERROR_TYPE"]=="auth"){
                        $current = "Bank system user autentication error > Code: '".$result["ERROR_CODE"]."' Text: '".$result["ERROR_CHARDATA"]."' Time: '".$result["ERROR_TIME"]."' Order_ID: '".$result["RESPONSE_ORDER_ID"]."'";
                        log_kkb('ERROR_TYPE->auth: ', $current);
                    }
                }
                if (in_array("DOCUMENT",$result)){
                    $current = "Result DATA: <BR>";
                    log_kkb('RESULT DATA: ', $current);
                    if($result['CHECKRESULT'] == "[SIGN_GOOD]"){
                        log_kkb('CHECKRESULT: ', $result['CHECKRESULT']);
                        if($result['PAYMENT_RESPONSE_CODE'] == 0){
                            $request_id = $result['ORDER_ORDER_ID'];
                            $request_amount = $result['ORDER_AMOUNT'];
                            $payment_amount = $result['PAYMENT_AMOUNT'];
                            $sum = $this->requestSum($request_id);
                            //                        $sum = 10;
                            log_kkb('PAYMENT RESPONSE CODE = 0: ', 'REQUEST ID: ' .$request_id . '<br>REQUSET AMOUNT: ' . $request_amount . '<br>PAYMENT AMOUNT: ' . $payment_amount . '<br>SUM: ' . $sum);
                            if($payment_amount == $sum){
                                $set_request_paid = $admin->setRequestPaid($request_id);
                                $admin->update_pay_success($request_id, $response, 0);
                                $flag = true;
                                $request_row = $admin->getRequestById($request_id);
                                log_kkb('PAYMENT AMOUNT = SUM: ', 'PAYMENT: ' .$payment_amount . ' SUM: ' . $sum, 'TRUE');
                                log_kkb('SET REQUEST PAID: ', $set_request_paid);
                                log_kkb('REQUSET ROW: ', $request_row);
                                if(count($request_row) > 0){
                                    if($request_row['city_id'] > 0){
                                        $city_row = $admin->getCityById($request_row['city_id']);
                                        $bonus_count = intval(($sum*intval($city_row['bonus_count'])/100));
                                        log_kkb('CITY ROW: ', $city_row);
                                        log_kkb('BONUS COUNT: ', $bonus_count);
                                    }
                                    else{
                                        $bonus_count = intval(($sum*0/100));
                                        log_kkb('BONUS COUNT: ', $bonus_count);
                                    }
                                    $user_products = $admin->getRequestProducts($request_id);
                                    $send_mail_to_client = $admin->sendClientNoticeEmail($request_row,$bonus_count,$request_row['user_id'], $request_row['status_id'], $request_id);
                                    //                                $send_mail = $admin->sendAdminNoticeEmail($request_row,"12",$user_products);
                                }
                            }
                        }
                    }
                    foreach ($result as $key => $value) {
                        $current = "Postlink Result: ".$key." = ".$value."<br>";
                        log_kkb('POSTLINK RESULT: ', $current);
                    };
                };
            } else {
                $current = "System error: ". $result;
                log_kkb('SYSTEM ERROR: ', $current);
            };
            if ($flag){
                echo "0";
            } else {
                echo "error: ".$current;
            }
        } catch(Exception $e){
            echo "error ".$e->getMessage(). ' '.$current;
        } */
    }

    private function postLinkCron($response, $city_id){
        try{
            $flag = false;
            $admin = new Application_Model_DbTable_Admin();
            if (isDevelop()){
                $path1 = 'paysys/config.txt';
            } else {
                if($city_id == '93'){
                    $path1 = 'paysys_almaty/config.txt';
                }
                if($city_id == '1'){
                    $path1 = 'paysys_astana/config.txt';
                }
            }
            echo "postlinkcron begin";
            log_kkb('CRON BEGIN CLIENT CITY ID: ', $city_id);
            $current = '';
            $result = process_response(stripslashes($response),$path1);
            var_dump($result);
            log_kkb('RESULT: ', json_encode($result));
            if (is_array($result)){
                echo "in array";
                if($result['CHECKRESULT'] == "[SIGN_GOOD]"){
                    log_kkb('CHECKRESULT: ', $result['CHECKRESULT']);
                    if($result['RESPONSE_PAYMENT'] == 'true'){
                        $request_id = $result['ORDER_ID'];
                        $payment_amount = $result['RESPONSE_AMOUNT'];
                        $sum = $this->requestSum($request_id);
                        log_kkb('PAYMENT RESPONSE CODE = 0: ', 'REQUEST ID: ' .$request_id . '<br>PAYMENT AMOUNT: ' . $payment_amount . '<br>SUM: ' . $sum);
                        if($payment_amount == $sum){
                            $set_request_paid = $admin->setRequestPaid($request_id);
                            $admin->update_pay_success($request_id, $response, 1);
                            $flag = true;
                            $request_row = $admin->getRequestById($request_id);
                            log_kkb('PAYMENT AMOUNT = SUM: ', 'PAYMENT: ' .$payment_amount . ' SUM: ' . $sum, 'TRUE');
                            log_kkb('SET REQUEST PAID: ', $set_request_paid);
                            log_kkb('REQUSET ROW: ', $request_row);
                            if(count($request_row) > 0){
                                if($request_row['city_id'] > 0){
                                    $city_row = $admin->getCityById($request_row['city_id']);
                                    $bonus_count = intval(($sum*intval($city_row['bonus_count'])/100));
                                    log_kkb('CITY ROW: ', $city_row);
                                    log_kkb('BONUS COUNT: ', $bonus_count);
                                }
                                else{
                                    $bonus_count = intval(($sum*0/100));
                                    log_kkb('BONUS COUNT: ', $bonus_count);
                                }
                                $user_products = $admin->getRequestProducts($request_id);
                                $send_mail_to_client = $admin->sendClientNoticeEmail($request_row,$bonus_count,$request_row['user_id'], $request_row['status_id'], $request_id);
                                //                                $send_mail = $admin->sendAdminNoticeEmail($request_row,"12",$user_products);
                            }
                        }
                    }
                }
                foreach ($result as $key => $value) {
                    $current = "Postlink Result: ".$key." = ".$value."<br>";
                    log_kkb('POSTLINK RESULT: ', $current);
                };
            } else {
                $current = "System error: ". $result;
                log_kkb('SYSTEM ERROR: ', $current);
            };
            log_kkb('CRON END', '');
            if ($flag){
                echo "0";
            } else {
                echo "error: ".$current;
            }
        } catch(Exception $e){
            echo "error ".$e->getMessage(). ' '.$current;
        }
    }

    public function requestSum($request_id){
        $admin = new Application_Model_DbTable_Admin();
        $user_products = $admin->getRequestProducts($request_id);

        $sum = 0;
        if(count($user_products) > 0){
            foreach($user_products as $key => $user_item){
                $sum += $user_item['price']*$user_item['unit'];
            }
        }
        return $sum;
    }

    public function advertisementPlusAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $advertisement_list = $admin->getAdvertisementList();
        $this->view->row = $advertisement_list;
        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($advertisement_list);
        $paginator->setItemCountPerPage(100);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }

    public function editAdvertisementAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $advertisement_id = $this->_getParam("advertisement_id",0);
        $row = $admin->getAdvertisementById($advertisement_id);
        $this->view->row = $row;
        $this->view->role = $this->role;
        $this->view->city_id = $this->city_id;
    }

    public function graphicByDayAction(){
        if(!($this->role == '1')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
    }

    public function graphicByBrandAction(){
        if(!($this->role == '1' || $this->role == '2' || $this->role == '5')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
    }

    public function graphicByBrandProductAction(){
        if(!($this->role == '1' || $this->role == '2' || $this->role == '5')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
    }

    public function graphicByProductAction(){
        if(!($this->role == '1' || $this->role == '2' || $this->role == '5')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
    }

    public function payByCardAction(){
        $this->_helper->layout->disableLayout();
        $admin = new Application_Model_DbTable_Admin();
        $session_id = Zend_Session::getId();
        $user_id = $this->user_id;
        $request_id = $this->_getParam("request_id",0);
        $user_products = $admin->getRequestProducts($request_id);

        $sum = 0;
        if(count($user_products) > 0){
            foreach($user_products as $key => $user_item){
                $sum += $user_item['price']*$user_item['unit'];
            }
        }
        $this->view->sum = $sum;
        $this->view->request_id = $request_id;

        $row = $admin->getRequestById($request_id);
        $this->view->row = $row;

        $this->view->product_row = $user_products;
    }

    public function clearPageAction(){
        $this->_helper->layout->disableLayout();
    }

    public function hideProductListAction() {
        if(!($this->role == '1' || ($this->role == '2' && ($this->city_id == '1' || $this->city_id == '93' || $this->city_id == '3')))) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $this->view->search_param = null;
    }

    public function modalBrandPhotoAction(){
        $this->_helper->layout->disableLayout();
        $admin = new Application_Model_DbTable_Admin();
        $brand_id = $this->_getParam('brand_id');
        $brand = $admin->getBrandById($brand_id);
        $this->view->brand = $brand;
    }

    public function sellerRequestEditAction(){
        if(!($this->role == '5')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $request_id = $this->_getParam("request_id",0);
        $request_type_id = $this->_getParam("request_type_id",0);
        $row = $admin->getRequestById($request_id);
        $this->view->row = $row;
        $this->view->city_id = $this->city_id;
        $this->view->request_type_id = $request_type_id;
    }

    public function sellerRequestListAction(){
        if(!($this->role == '5')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $status_id = $this->_getParam("status_id",0);
        $allparam['user_id'] = $this->user_id;
        $allparam['city_id'] = $this->city_id;
        $allparam['date_range'] = $this->_getParam('date_range',"");
        $allparam['product_id'] = $this->_getParam("product_id","");
        $allparam['new_product_add'] = $this->_getParam("new_product_add","");
        $allparam['barcode_search'] = $this->_getParam("new_product_barcode_input","");

        $request_list = $admin->getSellerRequestListByStatus($status_id,$allparam);
        $this->view->status_id = $status_id;
        $this->view->row = $request_list;
        $this->view->allparam = $allparam;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($request_list);
        $paginator->setItemCountPerPage(50);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;

        $params = $this->_getAllParams();
        if(isset($params['resetSearch'])){
            $this->_redirector->gotoUrl('/admin/seller-request-list?status_id='.$status_id);
        }
    }

    public function sellerProductListAction(){
        if(!($this->role == '5')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $category_list = $admin->getCategories();
        $brand_list = $admin->getBrands();
        $this->view->category_list = $category_list;
        $this->view->brand_list = $brand_list;
        $city_list = $admin->getMainCities();
        $this->view->city_list = $city_list;
        $this->view->role = $this->role;
        $this->view->city = $this->city_id;
    }

    public function getSellerProductListAction(){
        if ($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->layout->disableLayout();
        }
        $admin = new Application_Model_DbTable_Admin();
        $allparam = $this->_getAllParams();
        $row = $admin->searchSellerProductByParam($allparam);
        for($i = 0; $i < count($row); $i++){
            $row[$i]['city_id2'] = $allparam['city_id2'];
        }
        $this->view->row = $row;
        $this->view->city_id = $this->city_id;
    }

    public function sellerRealisationRequestListAction(){
        if(!($this->role == '5')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $status_id = $this->_getParam("status_id",0);
        $allparam['user_id'] = $this->user_id;
        $allparam['city_id'] = $this->city_id;
        $allparam['date_range'] = $this->_getParam('date_range',"");
        $allparam['product_id'] = $this->_getParam("product_id","");
        $allparam['new_product_add'] = $this->_getParam("new_product_add","");
        $allparam['barcode_search'] = $this->_getParam("new_product_barcode_input","");
        $request_list = $admin->getSellerRealisationRequestListByStatus($status_id,$allparam);
        $this->view->status_id = $status_id;
        $this->view->row = $request_list;
        $this->view->allparam = $allparam;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($request_list);
        $paginator->setItemCountPerPage(50);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;

        $params = $this->_getAllParams();
        if(isset($params['resetSearch'])){
            $this->_redirector->gotoUrl('/admin/seller-realisation-request-list?status_id='.$status_id);
        }
    }

    public function sellerReturnRequestListAction(){
        if(!($this->role == '5' || $this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $status_id = $this->_getParam("status_id",0);
        $allparam['user_id'] = $this->user_id;
        $allparam['city_id'] = $this->city_id;
        $allparam['date_range'] = $this->_getParam('date_range',"");
        $allparam['product_id'] = $this->_getParam("product_id","");
        $allparam['new_product_add'] = $this->_getParam("new_product_add","");
        $allparam['barcode_search'] = $this->_getParam("new_product_barcode_input","");
        $allparam['city_search'] = $this->_getParam("city_search",0);
        $allparam['contractor_search'] = $this->_getParam("contractor_search",0);
        if($this->role == '1'){
            $request_list = $admin->getAdminSellerReturnRequestListByStatus($status_id,$allparam);
        }
        else if($this->role == '2'){
            $request_list = $admin->getOperatorSellerReturnRequestListByStatus($status_id,$allparam);
        }
        else{
            $request_list = $admin->getSellerReturnRequestListByStatus($status_id,$allparam);
        }
        $this->view->status_id = $status_id;
        $this->view->row = $request_list;
        $this->view->allparam = $allparam;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($request_list);
        $paginator->setItemCountPerPage(50);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;

        $params = $this->_getAllParams();
        if(isset($params['resetSearch'])){
            $this->_redirector->gotoUrl('/admin/seller-return-request-list?status_id='.$status_id);
        }
    }

    public function sellerReturnRequestEditAction(){
        if(!($this->role == '5' || $this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $request_id = $this->_getParam("request_id",0);
        $row = $admin->getRequestById($request_id);
        $this->view->row = $row;
        $this->view->city_id = $this->city_id;

        $contractor_list = $admin->getContractorList();
        $this->view->contractor_list = $contractor_list;
    }

    public function bannerListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $row = $admin->getBannerList();
        $this->view->row = $row;
    }

    public function bannerEditAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $banner_id = $this->_getParam("banner_id", 0);
        $row = $admin->getBannerById($banner_id);
        $this->view->row = $row;

        $banner_city_row = $admin->getBannerCityList($banner_id);
        $this->view->banner_city_row = $banner_city_row;
    }

    public function waitingProductListAction() {
        if(!($this->role == '1' || ($this->role == '2' && ($this->city_id == '1' || $this->city_id == '93' || $this->city_id == '3')))) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $this->view->search_param = null;
    }

    public function changePasswordAction(){
        if(!($this->role == '1' || $this->role == '2' || $this->role == '3' || $this->role == '5')) {
            $this->_redirector->gotoUrl('/index/permission');
        }

        $this->_helper->layout->setLayout('layout-operator');
        $this->view->result = "";

        $admin = new Application_Model_DbTable_Admin();
        $allparam = $this->_getAllParams();
        if($this->getRequest()->isPost() && isset($allparam['reset_btn'])){
            $old_password = $this->_getParam("old_password");
            $new_password = $this->_getParam("new_password");
            $repeat_new_password = $this->_getParam("repeat_new_password");
            $user_info = $admin->getUserById($this->user_id);
            if(count($user_info) > 0){
                if(md5($old_password) != $user_info['password']){
                    $this->view->result = "Старый пароль неверный";
                    return;
                }
                else if(strlen(trim($new_password)) < 1 || strlen(trim($repeat_new_password)) < 1){
                    $this->view->result = "Введите все поля";
                    return;
                }
                else if($new_password != $repeat_new_password){
                    $this->view->result = "Новый и повтор пароля не совпадает";
                    return;
                }
                else{
                    $result = $admin->changePassword($this->user_id,$new_password);
                    $this->view->result = $result;
                }
            }
            else{
                $this->view->result = "Пользователь не найден";
            }
        }
    }

    public function providerListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $provider_list = $admin->getProviderList();
        $this->view->row = $provider_list;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($provider_list);
        $paginator->setItemCountPerPage(50);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }

    public function providerEditAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $provider_id = $this->_getParam("provider_id");
        $row = $admin->getProviderById($provider_id);
        $this->view->row = $row;
    }

    public function registerAction(){
        $this->_helper->layout->disableLayout();
    }

    public function cityListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $row = $admin->getCityList();
        $this->view->row = $row;
    }

    public function cityEditAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $city_id = $this->_getParam("city_id", 0);
        $row = $admin->getCityById($city_id);
        $this->view->row = $row;
    }

    public function profitByBrandAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
    }

    public function courierRequestListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $courier_list = $admin->getActiveCourierList();
        $this->view->courier_list = $courier_list;
    }

    public function courierRequestListFormAction(){
        $this->_helper->layout->disableLayout();
        $admin = new Application_Model_DbTable_Admin();
        $user_id = $this->_getParam("user_id",0);
        $date = $this->_getParam("date");
        $smena_type_id = $this->_getParam("smena_type_id",0);
        $row = $admin->getCourierRequestList($user_id,$date,$smena_type_id);
        $this->view->courier_request_list = $row;

        $row = $admin->getCourierRequestProductList($user_id,$date,$smena_type_id);
        $this->view->courier_request_product_list = $row;

        $row = $admin->getCourierRequestProductList2($user_id,$date,$smena_type_id);
        $this->view->courier_request_product_list2 = $row;

        $row = $admin->getCourierRequestListExc($user_id,$date,$smena_type_id);
        $this->view->courier_request_list_exc = $row;

        $this->view->courier_id = $user_id;
        $this->view->date = $date;
        $this->view->smena_type_id = $smena_type_id;
    }

    public function filterSettingListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $row = $admin->getFilterSettingList();
        $this->view->row = $row;
    }

    public function filterSettingEditAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $filter_setting_id = $this->_getParam("filter_setting_id",0);

        $row = $admin->getFilterSettingById($filter_setting_id);
        $this->view->row = $row;

        $characteristic_list = $admin->getAllCharacteristics();
        $this->view->characteristic_list = $characteristic_list;
    }

    public function fillXmlByFilterAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $admin = new Application_Model_DbTable_Admin();
        $admin->fillXmlByFilter();
    }

    public function sweetyCommentsAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');

        $admin = new Application_Model_DbTable_Admin();

        $sweety_comment_list = $admin->getSweetyCommentList();
        $this->view->row = $sweety_comment_list;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($sweety_comment_list);
        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }

    public function sweetyCommentEditAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $sweety_comment_id = $this->_getParam("sweety_comment_id",0);
        $row = $admin->getSweetyCommentById($sweety_comment_id);
        $this->view->row = $row;
    }

    public function sweetyShopsAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');

        $admin = new Application_Model_DbTable_Admin();

        $city_id = $this->_getParam("city_search",0);
        $sweety_comment_list = $admin->getSweetyShopList($city_id);
        $this->view->row = $sweety_comment_list;

        $page = $this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($sweety_comment_list);
        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
        $this->view->city_id = $city_id;
    }

    public function sweetyShopEditAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $sweety_shop_id = $this->_getParam("sweety_shop_id",0);
        $row = $admin->getSweetyShopById($sweety_shop_id);
        $this->view->row = $row;
    }

    public function sweetyCityListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $row = $admin->getSweetyCityList();
        $this->view->row = $row;
    }

    public function sweetyCityEditAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $city_id = $this->_getParam("city_id", 0);
        $row = $admin->getSweetyCityById($city_id);
        $this->view->row = $row;
    }

    public function wholesaleReportAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $city_id = $this->_getParam("city_id", 0);
        $this->view->city_id = $city_id;

        $year_now = date("Y");
        $month_now = date("m");
        $date_start = $month_now . "/01/" . $year_now ;
        $max_day_in_month = date('t',strtotime($year_now . "/" . $month_now . "/01"));
        $date_end = $month_now . '/'  .$max_day_in_month. '/' . $year_now ;;

        $date_range = $this->_getParam('date_range',$date_start . ' - ' . $date_end);
        $this->view->date_range = $date_range;

        if (isset($_POST["wholesale_show"])) {
            $row = $admin->wholesale_report($date_range, $city_id);
            $this->view->row = $row;
            $row2 = $admin->wholesale_report2($date_range, $city_id);
            $this->view->row2 = $row2;
        }

        if (isset($_POST["wholesale_print"])) {
            $today = gmdate("d.m.y H:i:s", time() + 21600);
            $city_row = $admin->getCityById($city_id);
            $print = $admin->wholesale_report($date_range, $city_id);
            $print2 = $admin->wholesale_report2($date_range, $city_id);
            $filename = 'Отчет по оптовым продажам' . ' ' . '(' . $date_range . ').xls';
            $objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT'] . "/order/wholesale_order.xlsx");
            $styleArray = array(
                'font'  => array(
                    'bold'  => true,
                    'color' => array('rgb' => 'FF3333'),
                    'size'  => 10,
                    'name'  => 'Arial'
                ));
            $empty_sheet_counter = 10;
            $counter = 8;
            $empty = '';
            $i = 0;
            if(count($print) != 0){
                foreach ($print as $value) {
                    $i++;
                    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Дата формирования: ' . $today);
                    $objPHPExcel->getActiveSheet()->setCellValue('B5', 'Период: ' . $date_range);
                    $objPHPExcel->getActiveSheet()->setCellValue('D5', 'Город: ' . $city_row['city_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $i);
                    $objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $value['column_date']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $value['delivery_date']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $value['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $value['contractor_name']);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':' . 'E' . $counter)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $j = 0;
                    foreach($print2 as $value2){
                        if($value['request_id'] == $value2['request_id']){
                            $j++;
                            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($counter+1), $empty);
                            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($counter+1), $empty);
                            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($counter+1), $empty);
                            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($counter+1), $empty);
                            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($counter+1), $empty);
                            $objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, $value2['product_name']);
                            $objPHPExcel->getActiveSheet()->setCellValue('G' . $counter, $value2['unit']);
                            $objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, $value2['price']);
                            $objPHPExcel->getActiveSheet()->setCellValue('I' . $counter, $value2['unit'] * $value2['price']);
//                            $objPHPExcel->getActiveSheet()->getStyle('I' . $counter)->applyFromArray($styleArray);
                            $objPHPExcel->getActiveSheet()->getStyle('A' . $counter . ':' . 'I' . $counter)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $counter++;
                        }
                    }
                    $objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, 'ИТОГО:');
                    $all = $objPHPExcel->getActiveSheet()->setCellValue('I' . $counter, '=SUM(I'.($counter-$j).':I' . ($counter-1) . ')');
                    $test = $objPHPExcel->getActiveSheet()->getCell('I' .$counter)->getValue();
                    $objPHPExcel->getActiveSheet()->setCellValue('J' . $counter, $test);
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $counter . ':' .'I' . $counter)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $counter . ':' . 'I' . $counter)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $counter++;
                }
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('A' . ($empty_sheet_counter+1), 'Нет данных для выгрузки!');
                $objPHPExcel->getActiveSheet()->mergeCells('A' . ($empty_sheet_counter+1) . ':I' . ($empty_sheet_counter+1));
                $objPHPExcel->getActiveSheet()->getStyle('A' . ($empty_sheet_counter+1) . ':I' . ($empty_sheet_counter+1))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f3f3f3');
                $objPHPExcel->getActiveSheet()->getStyle('A' . ($empty_sheet_counter+1) . ':I' . ($empty_sheet_counter+1))->getFont()->setSize(16)->setBold();
//                $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->applyFromArray(array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
            }
            $counter++;
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, 'ИТОГО');
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $counter, '=SUM(J8:J' . ($counter-1) . ')');
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setVisible(false);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $counter . ':' .'I' . $counter)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $counter . ':' . 'I' . $counter)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            header('Content-Type: application/vnd.ms-excel');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');

            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            header("Content-Disposition: attachment;filename=$filename");

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
    }

    public function wholesaleContractorReportAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');

//        $admin = new Application_Model_DbTable_Admin();
//        $city_id = $this->_getParam("city_id", 0);
//        $this->view->city_id = $city_id;
//
//        $year_now = date("Y");
//        $month_now = date("m");
//        $date_start = $month_now . "/01/" . $year_now ;
//        $max_day_in_month = date('t',strtotime($year_now . "/" . $month_now . "/01"));
//        $date_end = $month_now . '/'  .$max_day_in_month. '/' . $year_now ;;
//
//        $date_range = $this->_getParam('date_range',$date_start . '-' . $date_end);
//        $this->view->date_range = $date_range;
//
//        if (isset($_POST["wholesale_contractor_show"])) {
//            $row = $admin->wholesale_contractor_report($date_range, $city_id);
//            $this->view->row = $row;
//        }
    }

    public function deliveryReportAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $firstDayUTS = mktime (0, 0, 0, date("m"), 1, date("Y"));
        $lastDayUTS = mktime (0, 0, 0, date("m"), date('t'), date("Y"));

        $firstDay = date("Y-m-d", $firstDayUTS);
        $lastDay = date("Y-m-d", $lastDayUTS);

        $date_begin = $this->_getParam('date_begin', $firstDay);
        $date_end = $this->_getParam('date_end', $lastDay);
//        $status_id = $this->_getParam('status_id', 0);
        $courier_id = $this->_getParam('courier_id', 0);

        $this->view->date_begin = $date_begin;
        $this->view->date_end = $date_end;
//        $this->view->status_id = $status_id;
        $this->view->courier_id = $courier_id;

        $this->view->city_id = $this->city_id;
        $this->view->role = $this->role;
        $admin = new Application_Model_DbTable_Admin();
        $status_list = $admin->getRequestStatus();
        $this->view->status_list = $status_list;
        $courier_list = $admin->getActiveCourierList();
        $this->view->courier_list = $courier_list;

        $row = $admin->read_order_delivery($date_begin, $date_end, $courier_id);
        $this->view->row = $row;

        $courier_name = '';
        foreach ($courier_list as $value){
            if($value['user_id'] == $courier_id){
                $courier_name = $value['courier_name'];
            }
        }

        if (isset($_POST["print"])) {
            $today = gmdate("d.m.y H-i-s", time() + 21600);
            $row = $admin->read_order_delivery($date_begin, $date_end, $courier_id);
            $api = new Api_Flexcell();

            if($courier_id != 8285){
                $tempFile = $_SERVER['DOCUMENT_ROOT'] . "/order/delivery_report_local.xlsx";
            }else{
                $tempFile = $_SERVER['DOCUMENT_ROOT'] . "/order/delivery_report.xlsx";
            }
            $api->load($tempFile);
            $api->setActiveSheet(0);
            $api->setVariable('TITLE', $courier_name);
            $api->setMultipleRowData($row, 'scan');
            $api->export('Delivered (' . $today . '_Период_'. $date_begin. '-' .$date_end .')');
            return;

        }


    }

    public function onecReportAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $date = $this->_getParam('date', date('Y-m-d'));
        $this->view->date = $date;

        if (isset($_POST["print"])) {
            $today = gmdate("d.m.y H-i-s", time() + 21600);
            $row = $admin->onec_report($date);
            $api = new Api_Flexcell();

            $tempFile = $_SERVER['DOCUMENT_ROOT'] . "/order/1c_report.xlsx";
            $api->load($tempFile);
            $api->setActiveSheet(0);
            $api->setVariable('TITLE', 'Отчет для 1С, дата: ' . $date);
            $api->setMultipleRowData($row, 'scan');
            $api->export('Отчет для 1С (' . $today . '_Дата_'. $date .')');
            return;

        }


    }


    public function marqueeListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $this->view->role = $this->role;
        $this->view->city_id = $this->city_id;
        $city_id = 0;
        $marquee_id = 0;
        if($this->city_id > 0){
            $city_id = $this->city_id;
        }
        $row = $admin->read_marquee($city_id);
        $this->view->row = $row['value'];
        $marquee_city_list = $admin->read_marquee_city($marquee_id, $city_id);
        $this->view->marquee_city_list = $marquee_city_list['value'];
        /*foreach ($row['value'] as $value){
            $marquee_city_list = $admin->read_marquee_city($value['marquee_id'], $city_id);
            $this->view->marquee_city_list = $marquee_city_list['value'];
        }*/
    }

    public function marqueeEditAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $marquee_id = $this->_getParam("marquee_id", 0);
        $city_id = 0;
        if($this->city_id > 0){
            $city_id = $this->city_id;
        }

        if ($this->getRequest()->isPost()){
            $a = $this->_getAllParams();
            foreach ($a as $key => $value) {
                if ($a[$key] == "on"){
                    $a[$key] = 1;
                }
            }
            if($a['scrollamount'] == 0){
                $a['scrollamount'] = 8;
            }
            $result = $admin->update_marquee($a);
            if ($result['status'] == false){
                $this->view->row = $a;
                $this->view->err_msg = $result['value'];
                $marquee_city_row = $admin->read_marquee_city_checked($marquee_id, $city_id);
                $this->view->marquee_city_row = $marquee_city_row['value'];
                return;
            }
            $this->_redirector->gotoUrl('/admin/marquee-list/');
        }

        $row = $admin->get_marquee($marquee_id);
        $this->view->row = $row['value'];

        $marquee_city_row = $admin->read_marquee_city_checked($marquee_id, $city_id);
        $this->view->marquee_city_row = $marquee_city_row['value'];

    }

    public function restAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $admin = new Application_Model_DbTable_Admin();
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            $this->getResponse()->setStatusCode(401);
            return;
        }
        $login = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];
        $rest_auth = $admin->rest_auth($login, md5($password));
        if($rest_auth == false){
            header('WWW-Authenticate: Basic realm="My Realm"');
            $this->getResponse()->setStatusCode(401);
            return;
        }

        $date_begin = $this->_getParam("date_begin", date('Y-m-d'));
        $date_end = $this->_getParam("date_end", date('Y-m-d'));
//        $city_id = $this->_getParam("city_id", 0);
        $row = $admin->rest_data($date_begin, $date_end);

        header('Content-Type: application/json; charset=utf-8');

        $json = json_fix_cyr(json_encode($row));
        echo Zend_Json::prettyPrint($json, array("indent" => " "));
    }

    public function rssAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $admin = new Application_Model_DbTable_Admin();
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            $this->getResponse()->setStatusCode(401);
            return;
        }
        $login = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];
        $rest_auth = $admin->rest_auth($login, md5($password));
        if($rest_auth == false){
            header('WWW-Authenticate: Basic realm="My Realm"');
            $this->getResponse()->setStatusCode(401);
            return;
        }
        $city_id = $this->_getParam("city_id", 0);
        $entries = $admin->rss($city_id);

        header("Content-Type: text/xml");
        $nsUrl = 'http://base.google.com/ns/1.0';

        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;

        $rootNode = $doc->appendChild($doc->createElement('rss'));
        $rootNode->setAttribute('version', '2.0');
        $rootNode->setAttributeNS('http://www.w3.org/2000/xmlns/', 'xmlns:g', $nsUrl);

        $channelNode = $rootNode->appendChild($doc->createElement('channel'));
        $channelNode->appendChild($doc->createElement('title', 'Bebek.kz'));
        $channelNode->appendChild($doc->createElement('description', 'Интернет-магазин детских товаров'));
        $channelNode->appendChild($doc->createElement('link', 'http://bebek.kz/'));

        foreach ($entries as $product) {
            $itemNode = $channelNode->appendChild($doc->createElement('item'));
            $itemNode->appendChild($doc->createElement('g:id'))->appendChild($doc->createTextNode($product['product_id']));
            $itemNode->appendChild($doc->createElement('g:title'))->appendChild($doc->createTextNode($product['title']));
            $itemNode->appendChild($doc->createElement('g:description'))->appendChild($doc->createTextNode(trim(strip_tags($product['description']))));
            $itemNode->appendChild($doc->createElement('g:link'))->appendChild($doc->createTextNode($product['link']));
            $itemNode->appendChild($doc->createElement('g:image_link'))->appendChild($doc->createTextNode($product['image_link']));
            $itemNode->appendChild($doc->createElement('g:brand'))->appendChild($doc->createTextNode($product['brand']));
            $itemNode->appendChild($doc->createElement('g:condition'))->appendChild($doc->createTextNode($product['condition_']));
            $itemNode->appendChild($doc->createElement('g:availability'))->appendChild($doc->createTextNode($product['availability']));
            $itemNode->appendChild($doc->createElement('g:price'))->appendChild($doc->createTextNode($product['price']));
        }
        $result =  $doc->saveXML();
        echo $result;
    }

    public function expiringGoodsListAction(){
        if (!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $city_id = $this->_getParam("city_id", 0);
        $this->view->city_id = $city_id;
        $brand_id = $this->_getParam("brand_id", 0);
        $this->view->brand_id = $brand_id;
        $date = $this->_getParam("date", date('Y-m-d'));
        $this->view->date = $date;
        $day = $this->_getParam("day", 3);
        $this->view->day = $day;

        $city_list = $admin->getAllActiveCities();
        $this->view->city_list = $city_list;
        $brand_list = $admin->getBrands();
        $this->view->brand_list = $brand_list;
        if (isset($_POST["btn"])) {
            $row = $admin->expiring_goods_list($city_id, $brand_id, $date, $day);
            $this->view->row = $row['value'];
        }


    }

    public function expiringGoodsDetailListAction(){
        if (!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $tomorrow = strtotime("+1 day");
        $week = strtotime("+8 day");

        $tomorrow = date('Y-m-d', $tomorrow);
        $week = date('Y-m-d', $week);

        $brand_id = $this->_getParam("brand_id", 0);
        $this->view->brand_id = $brand_id;
        $city_id = $this->_getParam("city_id", 1);
        $this->view->city_id = $city_id;
        $date = $this->_getParam("date", date('Y-m-d'));
        $this->view->date = $date;
        $date_from = $this->_getParam("date_from", $tomorrow);
        $this->view->date_from = $date_from;
        $date_to = $this->_getParam("date_to", $week);
        $this->view->date_to = $date_to;

        $city_list = $admin->getAllActiveCities();
        $this->view->city_list = $city_list;
        $brand_list = $admin->getBrands();
        $this->view->brand_list = $brand_list;
        $provider_list = $admin->getProviderList();
        $this->view->provider_list = $provider_list;
        $row = $admin->expiring_goods_detail_list($city_id, $brand_id, $date, $date_from, $date_to);
        $this->view->row = $row['value'];
    }

    public function sendEmailAction(){
        $this->getHelper('viewRenderer')->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $ob = new Application_Model_DbTable_Admin();
        $ob->send_email();
    }

    public function checkEmailAction(){
        $this->getHelper('viewRenderer')->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $ob = new Application_Model_DbTable_Admin();
        $ob->check_email();
    }

    public function wholesaleSalesReportAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $date_begin = $this->_getParam('date_begin', date('d.m.Y'));
        $this->view->date_begin = $date_begin;
        $date_end = $this->_getParam('date_end', date('d.m.Y'));
        $this->view->date_end = $date_end;
        $city_id = $this->_getParam('city_id', 0);
        $this->view->city_id = $city_id;

        if (isset($_POST["print"])) {
            $today = gmdate("d.m.y H-i-s", time() + 21600);
            $row = $admin->report_wholesale_sales($date_begin, $date_end, $city_id);
            $api = new Api_Flexcell();

            $tempFile = $_SERVER['DOCUMENT_ROOT'] . "/order/report_wholesale_sales.xlsx";
            $api->load($tempFile);
            $api->setActiveSheet(0);
            $api->setVariable('TITLE', 'Оптовые продажи: ' . $date_begin . ' - ' . $date_end);
            $api->setMultipleRowData($row['value'], 'scan');
            $api->export('Оптовые продажи (' . $today . '_Период_' . $date_begin . ' - ' . $date_end .')');
            return;

        }


    }

    public function checkPayKkbCronAction(){
        echo "cron begin";
        $this->getHelper('viewRenderer')->setNoRender(true);
        $this->_helper->layout->disableLayout();
        if (isDevelop()){
            $url = 'https://testpay.kkb.kz/jsp/remote/checkOrdern.jsp?';
            require_once("paysys/kkb.utils.php");
        } else {
            $url = 'https://epay.kkb.kz/jsp/remote/checkOrdern.jsp?';
            require_once("paysys_almaty/kkb.utils.php");
        }

        $ob = new Application_Model_DbTable_Admin();
        $row = $ob->read_not_payed_list();
        $row = $row['value'];
        var_dump($row);
        $kkb = new KKBSign();
        $kkb->invert();
        foreach($row as $value){
            if (isDevelop()){
                $path = 'paysys/config.txt';
            } else {
                if($value['city_id'] == '93'){
                    $path = 'paysys_almaty/config.txt';
                }
                if($value['city_id'] == '1'){
                    $path = 'paysys_astana/config.txt';
                }
            }
            if(is_file($path)){
                $config = parse_ini_file($path,0);
            }
            if (!$kkb->load_private_key($config['PRIVATE_KEY_FN'],$config['PRIVATE_KEY_PASS'])){
                if ($kkb->ecode>0){return $kkb->estatus;};
            };


            $result = '<merchant id="'.$config['MERCHANT_ID'].'"><order id="'.$value['request_id'].'"/></merchant>';
            $result_sign = '<merchant_sign type="RSA" cert_id="' . $config['MERCHANT_CERTIFICATE_ID'] . '">'.$kkb->sign64($result).'</merchant_sign>';
            $xml = "<document>".$result.$result_sign."</document>";
            $xml = urlencode($xml);

            $response = file_get_contents($url.$xml);
            echo $response;
            $this->postLinkCron($response, $value['city_id']);
            echo "after postlinkcron";
        }
        echo "cron end";


    }

    public function kkbProcessingAction(){
        $admin = new Application_Model_DbTable_Admin();
        $request_id = $this->_getParam('request_id', 0);
        $city_id = $this->_getParam('city_id', 0);
        $result = $admin->insert_pay($request_id, $city_id, 'PREPAY', null);
        $this->view->result = $result['status'];
        if ($result['status'] == true){
            $this->view->row = $this->_getAllParams();
        }else{
            $this->view->error = $result['value'];
        }

    }

    public function userDebtListAction(){
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $this->view->row = $admin->read_user_debt()['value'];

    }

    public function userDebtAction(){
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $mode = $this->_getParam('mode', '');
        if ($mode == 'seacrh-debt'){
            $this->_helper->AjaxContext()->addActionContext('user-debt', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $row = $admin->get_user_debt_info($a['telephone']);
            $this->view->result = $row;
        }
    }

    public function cpResponseAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $admin = new Application_Model_DbTable_Admin();
        $mode = $this->_getParam('mode', '');
        if ($mode == 'check'){
            log_cp('BEGIN MODE: ', $mode);
            $row = $this->getRequest()->getRawBody();
            parse_str(html_entity_decode($row), $array);
            foreach ($array as $key => $value) {
                $current = $key." = ".$value;
                log_cp('CHECK : ', $current);
            };
            $session_id = json_decode($array['Data']);
            $session_id = get_object_vars ($session_id)['sessionId'];
            $request_id = $array['InvoiceId'];
            $payment_amount = intval($array['Amount']);
            $result = $admin->cloud_payments_pay($mode, $session_id, $request_id, $payment_amount);
            if($result['status']){
                $arr = array('code' => $result['value']);
                echo json_encode($arr);
            }else{
                $arr = array('code' => 13);
                echo json_encode($arr);
            }
            log_cp('END MODE: ', $mode.PHP_EOL);

        }
        if ($mode == 'pay'){
            log_cp('BEGIN MODE: ', $mode);
            $row = $this->getRequest()->getRawBody();
            parse_str(html_entity_decode($row), $array);
            foreach ($array as $key => $value) {
                $current = $key." = ".$value;
                log_cp('PAY : ', $current);
            };
            $session_id = json_decode($array['Data']);
            $session_id = get_object_vars ($session_id)['sessionId'];
            $request_id = $array['InvoiceId'];
            $payment_amount = intval($array['Amount']);
            $result = $admin->cloud_payments_pay($mode, $session_id, $request_id, $payment_amount);
            if($result['status']){
                $request_row = $admin->getRequestById($request_id);
                $sum = $admin->get_request_sum($request_id)['value'];
                log_cp('PAYMENT AMOUNT = SUM: ', 'PAYMENT: ' .$payment_amount . ' SUM: ' . $sum, 'TRUE');
                log_cp('SET REQUEST PAID: ', $result['status']);
                log_cp('REQUSET ROW: ', json_encode($request_row));
                if(count($request_row) > 0){
                    if($request_row['city_id'] > 0){
                        $city_row = $admin->getCityById($request_row['city_id']);
                        $bonus_count = intval(($sum*intval($city_row['bonus_count'])/100));
                        log_cp('CITY ROW: ', json_encode($city_row));
                        log_cp('BONUS COUNT: ', $bonus_count);
                    }
                    else{
                        $bonus_count = intval(($sum*0/100));
                        log_cp('BONUS COUNT: ', $bonus_count);
                    }
                    $admin->sendClientNoticeEmail($request_row,$bonus_count,$request_row['user_id'], $request_row['status_id'], $request_id);
                }
                $arr = array('code' => $result['value']);
                echo json_encode($arr);
            }
            log_cp('END MODE: ', $mode.PHP_EOL);
        }
        if ($mode == 'fail'){
            log_cp('BEGIN MODE: ', $mode);
            $row = $this->getRequest()->getRawBody();
            parse_str(html_entity_decode($row), $array);
            foreach ($array as $key => $value) {
                $current = $key." = ".$value;
                log_cp('FAIL : ', $current);
            };
            $session_id = json_decode($array['Data']);
            $session_id = get_object_vars ($session_id)['sessionId'];
            $request_id = $array['InvoiceId'];
            $payment_amount = intval($array['Amount']);
            $result = $admin->cloud_payments_pay($mode, $session_id, $request_id, $payment_amount);
            if($result['status']){
                $arr = array('code' => $result['value']);
                echo json_encode($arr);
            }
            log_cp('END MODE: ', $mode.PHP_EOL);
        }
        if ($mode == 'fail_js'){
            log_cp('BEGIN MODE: ', $mode);
            $a = $this->_getAllParams();
            $a['options']['reason'] = $a['reason'];
            $row = $a['options'];
            foreach ($row as $key => $value) {
                $value = is_array($value) ? json_encode($value) : $value;
                $current = $key." = ".$value;
                log_cp('FAIL FROM JS: ', $current);
            };
            $session_id = $row['data']['sessionId'];
            $request_id = $row['invoiceId'];
            $payment_amount = intval($row['amount']);
            $result = $admin->cloud_payments_pay($mode, $session_id, $request_id, $payment_amount);
            if($result['status']){
                $arr = array('code' => $result['value']);
                echo json_encode($arr);
            }
            log_cp('END MODE: ', $mode.PHP_EOL);
        }

    }

    public function costListAction(){
        if(!($this->role == '1' || $this->role == '8')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $firstDayUTS = mktime (0, 0, 0, date("m"), 1, date("Y"));
        $lastDayUTS = mktime (0, 0, 0, date("m"), date('t'), date("Y"));

        $firstDay = date("d.m.Y", $firstDayUTS);
        $lastDay = date("d.m.Y", $lastDayUTS);

        $this->view->date_begin = $this->_getParam('date_begin', $firstDay);
        $this->view->date_end = $this->_getParam('date_end', $lastDay);
        $this->view->accounting_cost_type_id = $this->_getParam('accounting_cost_type_id', 0);
        $this->view->comment = $this->_getParam('comment', '');
        $this->view->is_approved = $this->_getParam('is_approved', -1);
        $this->view->city_id = $this->_getParam('city_id', 0);
        $this->view->role = $this->role;
        if($this->role == 8){
            $this->view->city_id = $this->city_id;
        }
        $this->view->provider_id = $this->_getParam('provider_id', 0);
        $this->view->account_id = $this->_getParam('account_id', 0);
        $this->view->sender_user_id = $this->_getParam('sender_user_id', 0);
        $this->view->docs_need = $this->_getParam('docs_need', 0);
        $mode = $this->_getParam('mode', '');

        if ($mode == 'account-sender'){
            $this->_helper->layout->disableLayout();
            $this->_helper->AjaxContext()->addActionContext('cost-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $account = $admin->accounting_read_account($a['city_id']);
            $sender = $admin->accounting_read_sender($a['city_id']);
            $result['account'] = $account;
            $result['sender'] = $sender;
            $this->view->result = $result;
            return;
        }

        if ($mode == 'del'){
            $this->_helper->AjaxContext()->addActionContext('cost-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $admin->accounting_del_cost($a['accounting_cost_id']);
            $this->view->result = $result;
            return;
        }

        if ($mode == 'approve'){
            $this->_helper->AjaxContext()->addActionContext('cost-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $admin->accounting_approve_cost($a['accounting_cost_id']);
            $this->view->result = $result;
            return;
        }

        if ($mode == 'avail-doc'){
            $this->_helper->AjaxContext()->addActionContext('cost-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $admin->accounting_avail_doc_cost($a['accounting_cost_id']);
            $this->view->result = $result;
            return;
        }

        $row = $admin->accounting_read_city();
        $this->view->row_city = $row['value'];
        $row = $admin->accounting_read_cost_type_for_select();
        $this->view->row_cost_type = $row['value'];
        $row = $admin->accounting_read_provider();
        $this->view->row_provider = $row['value'];

        $row = $admin->accounting_read_cost($this->view->date_begin, $this->view->date_end, $this->view->accounting_cost_type_id, $this->view->comment, $this->view->is_approved, $this->view->city_id, $this->view->provider_id, $this->view->account_id, $this->view->sender_user_id, $this->view->docs_need);
        $this->view->row = $row['value'];
    }

    public function costEditAction(){
        if(!($this->role == '1' || $this->role == '8')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $admin = new Application_Model_DbTable_Admin();
        $this->_helper->layout->setLayout('layout-operator');
        $this->view->accounting_cost_id = $this->_getParam('accounting_cost_id', 0);
        $this->view->city_id = $this->_getParam('city_id', 0);
        $mode = $this->_getParam('mode', '');
        $this->view->role = $this->role;
        if($this->role == 8){
            $this->view->city_id = $this->city_id;
        }

        if ($mode == 'account-sender'){
            $this->_helper->layout->disableLayout();
            $this->_helper->AjaxContext()->addActionContext('cost-edit', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $account = $admin->accounting_read_account($a['city_id']);
            $sender = $admin->accounting_read_sender($a['city_id']);
            $result['account'] = $account;
            $result['sender'] = $sender;
            $this->view->result = $result;
            return;
        }
        $row = $admin->get_setting_val('COST_DAYS');
        $this->view->setting_val = $row['value'];
        $row = $admin->accounting_read_city();
        $this->view->row_city = $row['value'];
        $row = $admin->accounting_read_cost_type_for_select();
        $this->view->row_cost_type = $row['value'];
        //$row = $admin->accounting_read_account($this->view->city_id);
        $this->view->row_account = $row['value'];
        $row = $admin->accounting_read_provider();
        $this->view->row_provider = $row['value'];
        //$row = $admin->accounting_read_sender($this->view->city_id);
        $this->view->row_sender = $row['value'];

        if ($this->getRequest()->isPost()){
            $a = $this->_getAllParams();
            if($this->role == 8){
                $a['city_id'] = $this->city_id;
                $a['sender_user_id'] = $this->user_id;
            }
            $result = $admin->accounting_upd_cost($a);
            if ($result['status'] == false){
                $this->view->row = $a;
                $this->view->err_clean = $result['error'];
                $this->view->err_debug = $result['error_debug'];
                return;
            }
            $this->_redirector->gotoUrl('/admin/cost-list/');
        }
        $row = $admin->accounting_get_cost($this->view->accounting_cost_id);
        if($row['value']['is_approved'] == 1){
            $this->_redirector->gotoUrl('/admin/cost-list/');
        }
        if(is_null($row['value']['cost_date'])){
            $row['value']['cost_date'] = date('d.m.Y');
        }
        $this->view->row = $row['value'];
    }

    public function costTypeListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $admin = new Application_Model_DbTable_Admin();
        $this->_helper->layout->setLayout('layout-operator');
        $this->view->accounting_cost_type_name = $this->_getParam('accounting_cost_type_name', '');
        $this->view->city_id = $this->city_id;
        $this->view->role = $this->role;
        $mode = $this->_getParam('mode', '');

        if ($mode == 'del'){
            $this->_helper->AjaxContext()->addActionContext('cost-type-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $admin->accounting_del_cost_type($a['accounting_cost_type_id']);
            $this->view->result = $result;
            return;
        }

        $row = $admin->accounting_read_cost_type($this->view->accounting_cost_type_name);
        $this->view->row = $row['value'];
    }

    public function costTypeEditAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $admin = new Application_Model_DbTable_Admin();
        $this->_helper->layout->setLayout('layout-operator');
        $this->view->accounting_cost_type_id = $this->_getParam('accounting_cost_type_id', 0);
        $this->view->city_id = $this->city_id;
        $this->view->role = $this->role;

        if ($this->getRequest()->isPost()){
            $a = $this->_getAllParams();
            $result = $admin->accounting_upd_cost_type($a);
            if ($result['status'] == false){
                $this->view->row = $a;
                $this->view->err_msg = $result['value'];
                return;
            }
            $this->_redirector->gotoUrl('/admin/cost-type-list/');
        }
        $row = $admin->accounting_get_cost_type($this->view->accounting_cost_type_id);
        $this->view->row = $row['value'];
    }
    public function incomeListAction(){
        if(!($this->role == '1' || $this->role == '8')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $firstDayUTS = mktime (0, 0, 0, date("m"), 1, date("Y"));
        $lastDayUTS = mktime (0, 0, 0, date("m"), date('t'), date("Y"));

        $firstDay = date("d.m.Y", $firstDayUTS);
        $lastDay = date("d.m.Y", $lastDayUTS);

        $this->view->date_begin = $this->_getParam('date_begin', $firstDay);
        $this->view->date_end = $this->_getParam('date_end', $lastDay);
        $this->view->accounting_income_type_id = $this->_getParam('accounting_income_type_id', 0);
        $this->view->comment = $this->_getParam('comment', '');
        $this->view->city_id = $this->_getParam('city_id', 0);
        $mode = $this->_getParam('mode', '');
        $this->view->role = $this->role;
        if($this->role == 8){
            $this->view->city_id = $this->city_id;
        }
        $this->view->provider_id = $this->_getParam('provider_id', 0);
        $this->view->account_id = $this->_getParam('account_id', 0);
        $this->view->sender_user_id = $this->_getParam('sender_user_id', 0);

        if ($mode == 'account-sender'){
            $this->_helper->layout->disableLayout();
            $this->_helper->AjaxContext()->addActionContext('income-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $account = $admin->accounting_read_account($a['city_id']);
            $sender = $admin->accounting_read_sender($a['city_id']);
            $result['account'] = $account;
            $result['sender'] = $sender;
            $this->view->result = $result;
            return;
        }

        if ($mode == 'del'){
            $this->_helper->AjaxContext()->addActionContext('income-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $admin->accounting_del_income($a['accounting_income_id']);
            $this->view->result = $result;
            return;
        }

        if ($mode == 'edit'){
            $this->_helper->AjaxContext()->addActionContext('income-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $admin->accounting_edit_income($a['accounting_income_id'], $a['is_edit']);
            $this->view->result = $result;
            return;
        }

        $row = $admin->accounting_read_city();
        $this->view->row_city = $row['value'];
        $row = $admin->accounting_read_income_type_for_select();
        $this->view->row_income_type = $row['value'];
        $row = $admin->accounting_read_provider();
        $this->view->row_provider = $row['value'];

        $row = $admin->accounting_read_income($this->view->date_begin, $this->view->date_end, $this->view->accounting_income_type_id, $this->view->comment, $this->view->city_id, $this->view->provider_id, $this->view->account_id, $this->view->sender_user_id);
        $this->view->row = $row['value'];
    }

    public function incomeEditAction(){
        if(!($this->role == '1' || $this->role == '8')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $admin = new Application_Model_DbTable_Admin();
        $this->_helper->layout->setLayout('layout-operator');
        $this->view->accounting_income_id = $this->_getParam('accounting_income_id', 0);
        $this->view->city_id = $this->_getParam('city_id', 0);
        $mode = $this->_getParam('mode', '');
        $this->view->role = $this->role;
        if($this->role == 8){
            $this->view->city_id = $this->city_id;
        }

        if ($mode == 'account-sender'){
            $this->_helper->layout->disableLayout();
            $this->_helper->AjaxContext()->addActionContext('income-edit', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $account = $admin->accounting_read_account($a['city_id']);
            $sender = $admin->accounting_read_sender($a['city_id']);
            $result['account'] = $account;
            $result['sender'] = $sender;
            $this->view->result = $result;
            return;
        }

        $row = $admin->get_setting_val('INCOME_DAYS');
        $this->view->setting_val = $row['value'];
        $row = $admin->accounting_read_income_type_for_select();
        $this->view->row_income_type = $row['value'];
        $row = $admin->accounting_read_city();
        $this->view->row_city = $row['value'];
        $this->view->row_account = $row['value'];
        $row = $admin->accounting_read_provider();
        $this->view->row_provider = $row['value'];
        $this->view->row_sender = $row['value'];

        if ($this->getRequest()->isPost()){
            $a = $this->_getAllParams();
            if($this->role == 8){
                $a['city_id'] = $this->city_id;
                $a['sender_user_id'] = $this->user_id;
            }
            $result = $admin->accounting_upd_income($a);
            if ($result['status'] == false){
                $this->view->row = $a;
                $this->view->err_clean = $result['error'];
                $this->view->err_debug = $result['error_debug'];
                return;
            }
            $this->_redirector->gotoUrl('/admin/income-list/');
        }
        $row = $admin->accounting_get_income($this->view->accounting_income_id);
        if($this->view->accounting_income_id != 0 and $row['value']['is_edit'] == 0){
            $this->_redirector->gotoUrl('/admin/income-list/');
        }
        if(is_null($row['value']['income_date'])){
            $row['value']['income_date'] = date('d.m.Y');
        }
        $this->view->row = $row['value'];
    }

    public function incomeTypeListAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $admin = new Application_Model_DbTable_Admin();
        $this->_helper->layout->setLayout('layout-operator');
        $this->view->accounting_income_type_name = $this->_getParam('accounting_income_type_name', '');
        $this->view->city_id = $this->city_id;
        $this->view->role = $this->role;
        $mode = $this->_getParam('mode', '');

        if ($mode == 'del'){
            $this->_helper->AjaxContext()->addActionContext('income-type-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $admin->accounting_del_income_type($a['accounting_income_type_id']);
            $this->view->result = $result;
            return;
        }

        $row = $admin->accounting_read_income_type($this->view->accounting_income_type_name);
        $this->view->row = $row['value'];
    }

    public function incomeTypeEditAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $admin = new Application_Model_DbTable_Admin();
        $this->_helper->layout->setLayout('layout-operator');
        $this->view->accounting_income_type_id = $this->_getParam('accounting_income_type_id', 0);
        $this->view->city_id = $this->city_id;
        $this->view->role = $this->role;

        if ($this->getRequest()->isPost()){
            $a = $this->_getAllParams();
            $result = $admin->accounting_upd_income_type($a);
            if ($result['status'] == false){
                $this->view->row = $a;
                $this->view->err_msg = $result['value'];
                return;
            }
            $this->_redirector->gotoUrl('/admin/income-type-list/');
        }
        $row = $admin->accounting_get_income_type($this->view->accounting_income_type_id);
        $this->view->row = $row['value'];
    }

    public function transferListAction(){
        if(!($this->role == '1' || $this->role == '8')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $firstDayUTS = mktime (0, 0, 0, date("m"), 1, date("Y"));
        $lastDayUTS = mktime (0, 0, 0, date("m"), date('t'), date("Y"));

        $firstDay = date("d.m.Y", $firstDayUTS);
        $lastDay = date("d.m.Y", $lastDayUTS);

        $this->view->date_begin = $this->_getParam('date_begin', $firstDay);
        $this->view->date_end = $this->_getParam('date_end', $lastDay);
        $this->view->from_account_id = $this->_getParam('from_account_id', 0);
        $this->view->to_account_id = $this->_getParam('to_account_id', 0);
        $this->view->is_approved = $this->_getParam('is_approved', -1);
        $this->view->comment = $this->_getParam('comment', '');
        $this->view->city_id = $this->_getParam('city_id', 0);
        $this->view->role = $this->role;
        if($this->role == 8){
            $this->view->city_id = $this->city_id;
        }
        $mode = $this->_getParam('mode', '');

        if ($mode == 'accounts'){
            $this->_helper->AjaxContext()->addActionContext('transfer-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $account = $admin->accounting_read_account($a['city_id']);
            $result['account'] = $account;
            $this->view->result = $result;
            return;
        }

        if ($mode == 'del'){
            $this->_helper->AjaxContext()->addActionContext('transfer-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $admin->accounting_del_transfer($a['transfer_id']);
            $this->view->result = $result;
            return;
        }

        if ($mode == 'approve'){
            $this->_helper->AjaxContext()->addActionContext('transfer-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $admin->accounting_approve_transfer($a['transfer_id']);
            $this->view->result = $result;
            return;
        }

        $row = $admin->accounting_read_city();
        $this->view->row_city = $row['value'];

        $row = $admin->accounting_read_transfer($this->view->date_begin, $this->view->date_end, $this->view->from_account_id, $this->view->to_account_id,  $this->view->is_approved, $this->view->comment, $this->view->city_id);
        $this->view->row = $row['value'];
    }
    public function transferEditAction(){
        if(!($this->role == '1' || $this->role == '8')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $admin = new Application_Model_DbTable_Admin();
        $this->_helper->layout->setLayout('layout-operator');
        $this->view->transfer_id = $this->_getParam('transfer_id', 0);
        $this->view->city_id = $this->_getParam('city_id', 0);
        $mode = $this->_getParam('mode', '');
        $this->view->role = $this->role;
        if($this->role == 8){
            $this->view->city_id = $this->city_id;
        }

        if ($mode == 'accounts'){
            $this->_helper->layout->disableLayout();
            $this->_helper->AjaxContext()->addActionContext('transfer-edit', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $account = $admin->accounting_read_account($a['city_id']);
            $result['account'] = $account;
            $this->view->result = $result;
            return;
        }

        $row = $admin->get_setting_val('TRANSFER_DAYS');
        $this->view->setting_val = $row['value'];

        $row = $admin->accounting_read_city();
        $this->view->row_city = $row['value'];

        if ($this->getRequest()->isPost()){
            $a = $this->_getAllParams();
            if($this->role == 8){
                $a['city_id'] = $this->city_id;
            }
            $result = $admin->accounting_upd_transfer($a);
            if ($result['status'] == false){
                $this->view->row = $a;
                $this->view->err_clean = $result['error'];
                $this->view->err_debug = $result['error_debug'];
                return;
            }
            $this->_redirector->gotoUrl('/admin/transfer-list/');
        }
        $row = $admin->accounting_get_transfer($this->view->transfer_id);
        if($row['value']['is_approved'] == 1){
            $this->_redirector->gotoUrl('/admin/transfer-list/');
        }
        if(is_null($row['value']['transfer_date'])){
            $row['value']['transfer_date'] = date('d.m.Y');
        }
        $this->view->row = $row['value'];
    }
    public function balanceListAction(){
        if(!($this->role == '1' || $this->role == '8')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $this->view->city_id = $this->_getParam('city_id', 0);
        $this->view->date = $this->_getParam('date', date('d.m.Y'));
        $this->view->role = $this->role;
        if($this->role == 8){
            $this->view->city_id = $this->city_id;
        }
        $row = $admin->accounting_read_city();
        $this->view->row_city = $row['value'];
    }
    public function balanceListFormAction(){
        if(!($this->role == '1' || $this->role == '8')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->disableLayout();
        $admin = new Application_Model_DbTable_Admin();
        $this->view->city_id = $this->_getParam('city_id', 0);
        if($this->role == 8){
            $this->view->city_id = $this->city_id;
        }
        $this->view->date = $this->_getParam('date', date('d.m.Y'));
        $row = $admin->account_balance_by_city($this->view->city_id, $this->view->date);
        $this->view->row = $row['value'];
    }
    public function deliveryRevenueAction(){
        if(!($this->role == '1' || $this->role == '8')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $firstDayUTS = mktime (0, 0, 0, date("m"), 1, date("Y"));
        $lastDayUTS = mktime (0, 0, 0, date("m"), date('t'), date("Y"));

        $firstDay = date("d.m.Y", $firstDayUTS);
        $lastDay = date("d.m.Y", $lastDayUTS);

        $this->view->date_begin = $this->_getParam('date_begin', $firstDay);
        $this->view->date_end = $this->_getParam('date_end', $lastDay);
        $this->view->city_id = $this->_getParam('city_id', 0);
        $mode = $this->_getParam('mode', '');

        $row = $admin->accounting_read_city();
        $this->view->row_city = $row['value'];

        if ($mode == 'revenue'){
            $this->_helper->AjaxContext()->addActionContext('delivery-revenue', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $admin->get_delivery_revenue($a);
            $this->view->result = $result;
            return;
        }
    }
    public function settingListAction(){
        if(!($this->role == '1')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();
        $mode = $this->_getParam('mode', '');
        if ($mode == 'upd'){
            $this->_helper->layout->disableLayout();
            $this->_helper->AjaxContext()->addActionContext('setting-list', 'json')->initContext('json');
            $a = $this->_getAllParams();
            $result = $admin->upd_setting($a);
            $this->view->result = $result;
            return;
        }
    }
    public function settingListFormAction(){
        if(!($this->role == '1' || $this->role == '8')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->disableLayout();
        $admin = new Application_Model_DbTable_Admin();
        $row = $admin->read_setting();
        $this->view->row = $row['value'];
    }
    public function settingEditAction(){
        if(!($this->role == '1' || $this->role == '8')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->disableLayout();
        $admin = new Application_Model_DbTable_Admin();
        $this->view->setting_id = $this->_getParam('setting_id', 0);
        $row = $admin->get_setting($this->view->setting_id);
        $this->view->row = $row['value'];
    }
    public function sweetyBalanceAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $admin = new Application_Model_DbTable_Admin();

        $date = $this->_getParam('date', date('Y-m-d'));
        $this->view->date = $date;
        if (isset($_POST["print"])) {
            $today = gmdate("d.m.y H-i-s", time() + 21600);
            $row = $admin->report_product_balance_sweety_all($date);
            $api = new Api_Flexcell();

            $tempFile = $_SERVER['DOCUMENT_ROOT'] . "/order/sweety_balance.xlsx";
            $api->load($tempFile);
            $api->setActiveSheet(0);
            $api->setVariable('TITLE', 'Остатки Sweety, дата: ' . $date);
            $api->setMultipleRowData($row['value'], 'scan');
            $api->export('Остатки Sweety (' . $today . '_Дата_'. $date .')');
            return;

        }


    }

    public function mvSimilarRelatedProductsAction(){
        $this->getHelper('viewRenderer')->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $ob = new Application_Model_DbTable_Admin();
        $ob->mv_similar_products();
        $ob->mv_related_products();
    }

    public function reportProductComplexAction(){
        if(!($this->role == '1' || $this->role == '2')) {
            $this->_redirector->gotoUrl('/index/permission');
        }
        $this->_helper->layout->setLayout('layout-operator');
        $firstDayUTS = mktime (0, 0, 0, date("m"), 1, date("Y"));
        $lastDayUTS = mktime (0, 0, 0, date("m"), date('t'), date("Y"));

        $firstDay = date("d.m.Y", $firstDayUTS);
        $lastDay = date("d.m.Y", $lastDayUTS);

        $date_begin = $this->_getParam('date_begin', $firstDay);
        $date_end = $this->_getParam('date_end', $lastDay);

        $this->view->date_begin = $date_begin;
        $this->view->date_end = $date_end;

        $admin = new Application_Model_DbTable_Admin();

        $row = $admin->report_product_complex($date_begin, $date_end);
        $this->view->row = $row;

        if (isset($_POST["print"])) {
            $today = gmdate("d.m.y H-i-s", time() + 21600);
            $row = $admin->report_product_complex($date_begin, $date_end);
            $api = new Api_Flexcell();

            $tempFile = $_SERVER['DOCUMENT_ROOT'] . "/order/report_product_complex.xlsx";

            $api->load($tempFile);
            $api->setActiveSheet(0);
            $api->setVariable('TITLE', '');
            $api->setMultipleRowData($row['value'], 'scan');
            $api->export('Комплексный отчет по товарам (' . $today . '_Период_'. $date_begin. '-' .$date_end .')');
            return;

        }


    }
}

