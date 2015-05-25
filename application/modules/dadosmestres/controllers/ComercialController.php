<?php
class Dadosmestres_ComercialController extends Zend_Controller_Action{
	public function init(){
        $user = new Zend_Session_Namespace('usuario');
        $this->view->usuarionome = $user->info->nome_usuario;
        $this->_helper->layout()->setLayout('dadosmestres');
	}
	public function indexAction(){
		
	}
	public function aliasAction(){

	}
	public function modelosAction(){

	}
}