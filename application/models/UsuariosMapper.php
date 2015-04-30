<?php
class Model_UsuariosMapper{
    protected $_table;
    
    public function setTable($dbTable){
        if(is_string($dbTable))
            $dbTable = new $dbTable();
        
        if(!$dbTable instanceof Zend_Db_Table_Abstract)
            throw new Exception('Tabela Invalida!');
        
        $this->_table = $dbTable;
        
        return $this;
    }
    
    public function getTable(){
        if(null === $this->_table)
            $this->setTable('Model_DbTables_Usuarios');
        return $this->_table;
    }
    
    public function save(Model_Usuarios $usuario){
        $data = array(
            'id_usuario'       => $usuario->getId(),
            'senha_usuario'    => $usuario->getSenha(),
            'nome_usuario'     => $usuario->getNome(),
            'email_usuario'    => $usuario->getEmail(),
            'cod_grupo'        => $usuario->getGrupo()
        );
        if(null === ($id = $usuario->getId())){
            return $this->getTable()->insert($data);
        }else{
            $this->getTable()->update($data, array('id_usuario = ?' => $id));
            return null;
        }
    }
    
    public function find($id, Model_Usuarios $usuario){
        $result = $this->getTable()->find($id);
        $row    = $result->current();
        if(empty($row))
            return false;
        
        $usuario->setId($row->id_usuario);
        $usuario->setNome($row->nome_usuario);
        $usuario->setEmail($row->email_usuario);
        $usuario->setSenha($row->senha_usuario);
        $usuario->setGrupo($row->cod_grupo);
        
        return $usuario;
    }
    
    public function loadmenu($mnu,$id){
        $db     = Zend_Db_Table::getDefaultAdapter();
        $db->query('SET NAMES "utf8"');
        $db->query('SET CHARACTER SET "utf8" ');
        $arr    = array($mnu, $id);
        $return = $db->query("CALL sp_fe_cria_mt_ml(?,?)", $arr);
        $result = $return->fetchAll();
        $arr = array();
        $utils = new SC_Plugins_Utils();
        foreach($result as $row){
            $link = strtolower(str_replace(' ', '', $utils->cleanTxt($row['desc_menu'])));
            if($mnu != 'mt_geral'){
                $item = array(
                    'link' => strtolower(str_replace(' ', '', $utils->cleanTxt($row['agrup_menu_esquerda']))) . '/' . $link,
                    'id' => $row['id_menu'],
                    'desc' => $row['desc_menu']
                );
                $arr[$row['agrup_menu_esquerda']][] = $item;
            }else{
                $item = array(
                    'link' => $link,
                    'id' => $row['id_menu'],
                    'desc' => $row['desc_menu']
                );
                $arr[] = $item;
            }
        }
        return $arr;
    }
    
    
}
