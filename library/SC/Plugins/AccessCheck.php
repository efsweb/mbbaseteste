<?php

class SC_Plugins_AccessCheck extends Zend_Controller_Plugin_Abstract{
        
    private $_acl  = null;
    private $_auth = null;
    
    public function __construct(){
        //$this->_acl  = $acl;
        //$this->_auth = $auth;
    }
    
    public function preDispatch(Zend_Controller_Request_Abstract $request){
        $module   = $request->getModuleName();
        $resource = $request->getControllerName();
        $action   = $request->getActionName();
        
        if(($module != 'default') && ($resource != 'index') && ($action != 'index')){
            $objeto = Zend_Auth::getInstance()->getStorage()->read();
            if(!is_object($objeto)){
                $this->checkSession();
            }
        }
    }
    private function checkSession(){
        $usuario = new Zend_Session_Namespace('usuario');
        if(!isset($usuario->usuario)){
            $this->_response->setRedirect('/')->sendResponse();
            exit;
        }
    }
}
