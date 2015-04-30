<?php
class SC_Plugins_Estados extends Zend_Controller_Plugin_Abstract{
    
    protected $_lista = array(
        1 => array('Acre', 'AC'),
        2 => array('Alagoas', 'AL'),
        3 => array('Amapá', 'AP'),
        4 => array('Amazonas', 'AM'),
        5 => array('Bahia', 'BA'),
        6 => array('Ceará', 'CE'),
        7 => array('Distrito Federal', 'DF'),
        8 => array('Espírito Santo', 'ES'),
        9 => array('Goiás', 'GO'),
        10=> array('Maranhão', 'MA'),
        11=> array('Mato Grosso', 'MT'),
        12=> array('Mato Grosso do Sul', 'MS'),
        13=> array('Minas Gerais', 'MG'),
        14=> array('Pará', 'PA'),
        15=> array('Paraíba', 'PB'),
        16=> array('Paraná', 'PR'),
        17=> array('Pernambuco', 'PE'),
        18=> array('Piauí', 'PI'),
        19=> array('Rio de Janeiro', 'RJ'),
        20=> array('Rio Grande do Norte', 'RN'),
        21=> array('Rio Grande do Sul', 'RS'),
        22=> array('Rondônia', 'RO'),
        23=> array('Roraima', 'RR'),
        24=> array('Santa Catarina', 'SC'),
        25=> array('São Paulo', 'SP'),
        26=> array('Sergipe', 'SE'),
        27=> array('Tocantins', 'TO')
    );
    
    protected $_uf;
    protected $_estados;
    
    public function __set($name, $value){
        $method = 'set'.$name;
        return $this->$method($value);
    }
    public function __get($name){
        $method = 'get'.$name;
        return $this->$method;
    }
    
    public function setUF($lista = null){
        $arr = array();
        foreach($lista as $k => $v){
            $arr[$k] = $v[1];
        }
        $this->_uf = $arr;
        return $this;
    }
    public function getUF(){
        if($this->_uf == '')
            $this->setUF($this->_lista);
            
        return $this->_uf;
    }
    
    public function setEstados($lista = null){
        $arr = array();
        foreach($lista as $k => $v){
            $arr[$k] = $v[0];
        }
        $this->_estados = $arr;
        return $this;
    }
    public function getEstados(){
        if($this->_estados == '')
            $this->setEstados($this->_lista);
            
        return $this->_estados;
    }
    
    public function find($id){
        return $this->_lista[$id];
    }
    
}
