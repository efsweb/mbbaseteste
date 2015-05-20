<?php
use google\appengine\api\cloud_storage\CloudStorageTools;
class Modelos_WalkaroundController extends Zend_Controller_Action{
    public function init(){
    	$this->_helper->layout()->setLayout('modelos');
        $modelo = new Zend_Session_Namespace('modeloselecionado');
        $usuario = new Zend_Session_Namespace('usuario');
        $this->view->usuarionome = $usuario->usuario->nome_usuario;
        if(!isset($modelo->id)){
            $modelo->id = '106';
        }
    }
    public function indexAction(){}
    public function geralAction(){
        $modelo = new Zend_Session_Namespace('modeloselecionado');
        $modelos = new Model_ModelosMapper();
        $familias = $modelos->lista();
        $myarr = 'Accelo / 815';
        foreach ($familias as $key => $value) {
            $arr = $modelos->lista2('modelo',$value);
            if(array_key_exists($modelo->id, $arr)){
                $myarr = $arr[$modelo->id];
            }
        }
        $nome = strtolower(str_replace(' / ', '_', $myarr));
        $imgfront = 'http://storage.googleapis.com/mb-wa-images/WA_accelo_815_fundo_externo.jpg';
        $imgback  = $img_int;
        $this->view->imgfront = $imgfront;
        $this->view->imgback  = $imgback;
    }
    public function fotosAction(){}
    public function uploadpopupAction(){
    	Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $modeloid = new Zend_Session_Namespace('modeloselecionado');

        $bucket    = 'mb-wa-images';
        $root_path = 'gs://' . $bucket . '/pop_ups';
        $name = 'WA_accelo_815_fundo_externo.jpg';//$_FILES['arquivo']['name'];
        $original = $root_path . '/' . $name;
        $tmp = $_FILES['arquivo']['tmp_name'];
        
        if(move_uploaded_file($tmp, $original)){
            echo 'funfo ' . $modeloid->id;
        }else{
            echo 'nao rolou';
        }
    }
    public function uploadimgAction(){
        Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $nome = $this->getRequest()->getParam('nomefile', '');

        $bucket    = 'mb-wa-images';
        $root_path = 'gs://' . $bucket . '/';
        $name = 'WA_accelo_815_fundo_externo.jpg';//$name = $_FILES['arquivo']['name'];
        $original = $root_path . $nome;
        $tmp = $_FILES['arquivo']['tmp_name'];

        CloudStorageTools::deleteImageServingUrl($original);
        unlink($original);
        if(move_uploaded_file($tmp, $original)){
            $path = CloudStorageTools::getImageServingUrl($original);
            $arr  = array('status' => 'ok','path' => $path);
            echo json_encode($arr);
        }else{
            echo 'nao rolou';
        }
    }
}


