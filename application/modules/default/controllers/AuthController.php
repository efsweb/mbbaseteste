<?php

class AuthController extends Zend_Controller_Action{
    
    public $usr;
    
    public function init(){
        $this->_helper->layout()->setLayout('login');
        $this->getHelper('viewRenderer')->setNoRender();
    }
    public function logoutAction(){
        $usuario = new Zend_Session_Namespace('usuario');
        unset($usuario->info);
        Zend_Auth::getInstance()->clearIdentity();
        Zend_Session::forgetMe();
        $this->_redirect('/');
    }
}
