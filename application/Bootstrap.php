<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap{
    
    private $_acl  = null;
    private $_auth = null;
    
    protected function _initAutoloader(){
        $moduleLoader = new Zend_Application_Module_Autoloader(array('namespace' => '', 'basePath' => dirname(__FILE__)));
        
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->setFallbackAutoloader(true);
        
        $fc = Zend_Controller_Front::getInstance();
        $fc->registerPlugin(new SC_Plugins_AccessCheck());
        
        return $autoloader;
    }
    
    protected function _initConfiguration(){
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', APPLICATION_ENV);
        Zend_Registry::getInstance()->set('config', $config);
        return $config;
    }
    
    protected function _initConnection(){
        $config = Zend_Registry::get("config");
        $dbConfig = $config->resources->db->params;

        $options = array(
            "username" => $dbConfig->username,
            "password" => $dbConfig->password,
            "dbname"   => $dbConfig->dbname
        );

        if ($dbConfig->use_socket) {
            $options['unix_socket'] = $dbConfig->unix_socket;
        }else{
            $options['host'] = $dbConfig->host;
        }

        $db = Zend_Db::factory("Pdo_Mysql", $options);
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        Zend_Registry::getInstance()->set('db', $db);
        Zend_Db_Table::setDefaultAdapter($db);
        
        return $db;
    }
    
    protected function _initRouter(){
        $front  = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        $router->addRoute(
            ':module/:action',
            new Zend_Controller_Router_Route(
                ':module/:action',
                array(
                    'module'     => ':module',
                    'controller' => 'index',
                    'action'     => ':action'
                )
            )
        );
        $router->addRoute('/', new Zend_Controller_Router_Route('/', array('action' => 'index')));
        $router->addRoute(':module/', new Zend_Controller_Router_Route(':module/', array('action' => 'index')));
        $router->addRoute('login', new Zend_Controller_Router_Route('login', array('controller' => 'auth', 'action' => 'login')));
        $router->addRoute('logout', new Zend_Controller_Router_Route('logout', array('controller' => 'auth', 'action' => 'logout')));
    }
    
    protected function _initSessions(){ Zend_Session::start(); }
    
    
    
}
