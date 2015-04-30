<?php
class SC_Plugins_Authenticator{
    protected $errorMessage;

    private $_access;
    private $_table;
    private $_lookup;
    
    public function getCredentials($fields){
        $adminUser = $this->validateUser($fields);
        if($adminUser){
            return $adminUser;
        }
        if(isset($this->errorMessage)){
            return null;
        }
        $this->errorMessage = null;
        return null;
    }
    
    private function validateUser($fields){
        $authAdapter = $this->getAuthAdapter();
        foreach ($fields as $key => $value) {
            if($key == 'login'){
                $authAdapter->setIdentity( $value );
            }
            if($key == 'pass'){
                $authAdapter->setCredential( $value );
            }
        }
        $auth = Zend_Auth::getInstance()->authenticate( $authAdapter );
        if(!$auth->isValid()){
            Zend_Auth::getInstance()->clearIdentity();
            $this->_redirect('/');
        } else {
            $usuario = new Zend_Session_Namespace('usuario');
            $identity = $authAdapter->getResultRowObject();
            $authStorage = Zend_Auth::getInstance()->getStorage()->write( $identity );
            $usuario->info = $identity;
            return $identity;
        }
    }
    protected function getAuthAdapter(){
        $authAdapter = new Zend_Auth_Adapter_DbTable( Zend_Db_Table::getDefaultAdapter() );
        $authAdapter->setTableName('tbl_seg_usuarios')
                    ->setIdentityColumn('email_usuario')
                    ->setCredentialColumn('senha_usuario');
        return $authAdapter;
    }
    
    
}
