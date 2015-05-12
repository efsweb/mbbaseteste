<?php
class Modelos_WalkaroundController extends Zend_Controller_Action{
    public function init(){
    	$this->_helper->layout()->setLayout('modelos');
    }
    public function indexAction(){}
    public function geralAction(){
        //$options = ['gs_bucket_name' => 'mb-cadastro-arquivos'];
		//$this->view->upload_url = CloudStorageTools::createUploadUrl('/modelos/walkaround/uploadpopup', $options);
        $obj = new SC_UploadGae();
    }
    public function fotosAction(){}
    public function uploadpopupAction(){
    	Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        
    	print_r($_FILES['arquivo']['name']);
    }
}
