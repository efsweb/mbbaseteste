<?php
class Modelos_UpController extends Zend_Controller_Action{
    public function init(){
    	$this->_helper->layout()->setLayout('modelos');
        $modelo = new Zend_Session_Namespace('modeloselecionado');
        $usuario = new Zend_Session_Namespace('usuario');
        $this->view->usuarionome = $usuario->usuario->nome_usuario;
        if(!isset($modelo->id)){
            $modelo->id = '106';
            $modelo->fm = 'Accelo';
        }
    }
    public function geralAction(){
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $modelo = new Model_UP();
        $this->view->geral = $modelo->loadinicial($mdid,'mod_up_geral');
    }
    public function itemAction(){
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $modelo = new Model_UP();
        $this->view->content = $modelo->loadinicialitem($mdid, 'mod_up_item_detalhe');
    }    
}
