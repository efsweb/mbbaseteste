<?php
use google\appengine\api\cloud_storage\CloudStorageTools;
class Modelos_WalkaroundController extends Zend_Controller_Action{
    public function init(){
    	$this->_helper->layout()->setLayout('modelos');
    }
    public function indexAction(){}
    public function geralAction(){
        /*$options = ['gs_bucket_name' => 'mb-wa-images'];
		$this->view->upload_url = CloudStorageTools::createUploadUrl('/modelos/walkaround/uploadpopup', $options);*/
    }
    public function fotosAction(){}
    public function uploadpopupAction(){
    	Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $modeloid = new Zend_Session_Namespace('modeloselecionado');

        $bucket    = 'mb-wa-images';
        $root_path = 'gs://' . $bucket . '/pop_ups';
        $name = $_FILES['arquivo']['name'];
        $original = $root_path . '/' . $name;
        $tmp = $_FILES['arquivo']['tmp_name'];
        
        if(move_uploaded_file($tmp, $original)){
            echo 'funfo ' . $modeloid->id;
        }else{
            echo 'nao rolou';
        }
    }
}
