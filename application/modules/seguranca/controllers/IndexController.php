<?php
class Seguranca_IndexController extends Zend_Controller_Action{
	public function init(){
		$usuario = new Zend_Session_Namespace('usuario');
        $this->view->usuarionome = $usuario->usuario->nome_usuario;
        $this->view->versoes     = $usuario->versoes;
        $this->view->versaoatual = $usuario->va[1];
	}
	public function indexAction(){
		$this->_helper->layout()->setLayout('construcao');
	}
}