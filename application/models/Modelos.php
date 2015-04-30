<?php
class Model_Motor extends Zend_Db_Table_Abstract{
    protected $_idsys;
    protected $_idmodelo;
    protected $_familia;
    protected $_modelo;
    protected $_tipo;
    protected $_timbfamilia;
    protected $_timbmodelo;
    
    public function __construct(array $options = null){
        if(is_array($options))
            $this->setOptions($options);
    }
    
    public function __set($name,$value){
        $method = 'set' . $name;
        if(('mapper' == $name) || !method_exists($this, $method))
            throw new Exception('Propriedade setada invalida!');
        $this->$method($value);
    }
    public function __get($name){
        $method = 'get' . $name;
        if(('mapper' == $name) || !method_exists($this, $method))
            throw new Exception('Propriedade buscada invalida!');
        return $this->$method();
    }
    
    public function setOptions(array $options){
        $methods = get_class_methods($this);
        foreach($option as $k => $v){
            $method = 'set' . ucfirst($k);
            if(in_array($method, $methods))
                $this->$method($v);
        }
    }
    
    public function setIdsys($id){
        $this->_idsys = $id;
        return $this;
    }
    public function getIdsys(){
        return $this->_idsys;
    }
    
    public function setIdmodelo($modelo){
        $this->_idmodelo = $modelo;
        return $this;
    }
    public function getIdmodelo(){
        return $this->_idmodelo;
    }
    
    public function setFamilia($familia){
        $this->_familia = $familia;
        return $this;
    }
    public function getFamilia(){
        return $this->_familia;
    }
    
    public function setModelo($modelo){
        $this->_modelo = $modelo;
        return $this;
    }
    public function getModelo(){
        return $this->_modelo;
    }
    
    public function setTipo($tipo){
        $this->_tipo = $tipo;
        return $this;
    }
    public function getTipo(){
        return $this->_tipo;
    }

    public function setTimbfamilia($timbfamilia){
        $this->_timbfamilia = $timbfamilia;
        return $this;
    }
    public function getTimbfamilia(){
        return $this->_timbfamilia;
    }

    public function setTimbmodelo($timbmodelo){
        $this->_timbmodelo = $timbmodelo;
        return $this;
    }
    public function getTimbmodelo(){
        return $this->_timbmodelo;
    }
    
}
