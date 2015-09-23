<?php
class Dadosmestres_ComercialController extends Zend_Controller_Action{
	public function init(){
        $this->_helper->layout()->setLayout('dadosmestres');
        $usuario = new Zend_Session_Namespace('usuario');
        $this->view->usuarionome = $usuario->usuario->nome_usuario;
        $this->view->versoes     = $usuario->versoes;
        $this->view->versaoatual = $usuario->va[1];
	}
	public function indexAction(){
		
	}
	public function aliasAction(){

	}
	public function modelosAction(){

	}
}