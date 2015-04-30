<?php
class Model_Usuarios extends Zend_Db_Table_Abstract{
    protected $_id;
    protected $_nome;
    protected $_email;
    protected $_senha;
    protected $_codgrupo;
    
    public function __construct(array $options = null){
        if(is_array($options))
            $this->setOptions($options);
    }
    public function __set($name, $value){
        $method = 'set' . $name;
        if(('mapper' == $name) || !method_exists($this, $method))
            throw new Exception("Propriedade setada invalida!");
        $this->$method($value);
    }
    public function __get($name){
        $method = 'get' . $name;
        if(('mapper' == $name) || !method_exists($this, $method))
            throw new Exception("Propriedade $method invalida!");
        return $this->$method();
    }
    
    public function setOptions(array $options){
        $methods = get_class_methods($this);
        foreach($options as $k => $v){
            $method = 'set' . ucfirst($k);
            if(in_array($method, $methods))
                $this->$method($v);
        }
    }
    
    public function setId($id){
        $this->_id = $id;
        return $this;
    }
    public function getId(){
        return $this->_id;
    }
    
    public function setNome($nome){
        $this->_nome = $nome;
        return $this;
    }
    public function getNome(){
        return $this->_nome;
    }
    
    public function setEmail($email){
        $this->_email = $email;
        return $this;
    }
    public function getEmail(){
        return $this->_email;
    }
    
    public function setSenha($senha){
        $this->_senha = $senha;
        return $this;
    }
    public function getSenha(){
        return $this->_senha;
    }
    
    public function setGrupo($data){
        $this->_codgrupo = $data;
        return $this;
    }
    public function getGrupo(){
        return $this->_codgrupo;
    }
    
}
