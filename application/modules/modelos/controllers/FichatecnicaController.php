<?php

class Modelos_FichatecnicaController extends Zend_Controller_Action{
    public function init(){
        $this->_helper->layout()->setLayout('modelos');
        $modelo = new Zend_Session_Namespace('modeloselecionado');
        $usuario = new Zend_Session_Namespace('usuario');
        $this->view->usuarionome = $usuario->usuario->nome_usuario;
        if(!isset($modelo->id)){
            $modelo->id = '106';
        }
    }
    public function geralAction(){
        $pgid = 'mod_ft_geral';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $modelo = new Model_Geralft();
        $this->view->content = $modelo->loaddata($mdid,$pgid);

        $modelos = new Model_ModelosMapper();
        $familias = $modelos->lista();
        foreach ($familias as $key => $value) {
            $arr = $modelos->lista2('modelo',$value);
            if(array_key_exists($modelo->id, $arr)){
                echo $modelo->id;
            }
        }
        exit();

    }
    public function caixadetransferenciaAction(){
        $pgid = 'mod_ft_caixa_transferencia';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $modelo = new Model_ModelosMapper();
        $this->view->content = $modelo->visaomodelos($mdid,$pgid);
    }
    public function dimensoesAction(){
        $pgid = 'mod_ft_dimensoes';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $modelo = new Model_ModelosMapper();
        $this->view->content = $modelo->visaomodelos($mdid,$pgid);
    }
    public function pesosAction(){
        $pgid = 'mod_ft_pesos';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $modelo = new Model_ModelosMapper();
        $this->view->content = $modelo->visaomodelos($mdid,$pgid);
    }
    public function pesosadmissiveisAction(){
        $pgid = 'mod_ft_pesos_adminissiveis';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $modelo = new Model_ModelosMapper();
        $this->view->content = $modelo->visaomodelos($mdid,$pgid);
    }
    public function cabinaAction(){
        $pgid = 'mod_ft_cabina';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $modelo = new Model_ModelosMapper();
        $this->view->content = $modelo->visaomodelos($mdid,$pgid);
    }
    public function motorAction(){
        $pgid = 'mod_ft_motor';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $modelo = new Model_ModelosMapper();
        $this->view->content = $modelo->visaomodelos($mdid,$pgid);
    }
    public function sistemaeletricoAction(){
        $pgid = 'mod_ft_sistema eletrico';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $modelo = new Model_ModelosMapper();
        $this->view->content = $modelo->visaomodelos($mdid,$pgid);
    }
    public function transmissaoAction(){
        $pgid = 'mod_ft_transmissao';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $modelo = new Model_ModelosMapper();
        $this->view->content = $modelo->visaomodelos($mdid,$pgid);
    }
    public function eixosAction(){
        $pgid = 'mod_ft_eixos';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $modelo = new Model_ModelosMapper();
        $this->view->content = $modelo->visaomodelos($mdid,$pgid);
    }
    public function desempenhoAction(){
        $pgid = 'mod_ft_desempenho';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $modelo = new Model_ModelosMapper();
        $this->view->content = $modelo->visaomodelos($mdid,$pgid);
    }
    public function freiosAction(){
        $pgid = 'mod_ft_freios';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $modelo = new Model_ModelosMapper();
        $this->view->content = $modelo->visaomodelos($mdid,$pgid);
    }
    public function chassisAction(){
        $pgid = 'mod_ft_chassis';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        $modelo = new Model_ModelosMapper();
        $this->view->content = $modelo->visaomodelos($mdid,$pgid);
    }
    public function comentariosAction(){
        $pgid = 'mod_ft_comentarios';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $mdid = $this->_getParam('id', $modeloid->id);
        if($mdid != $modeloid->id){
            $modeloid->id = $mdid;
        }
        /*
        ANTIGO CHAMAVA ASSIM
        $modelo = new Model_Comentarios();
        $this->view->content = $modelo->lista($mdid);*/
        $modelo = new Model_ModelosMapper();
        $this->view->content = $modelo->visaomodelos($mdid,$pgid);
    }

    /**
     * Função que efetua a busca do popup de alias
     */
    public function searchAction(){
        Zend_Layout::resetMvcInstance();
        
        $this->_helper->viewRenderer->setNoRender(true);
        $nome = $this->getRequest()->getParam('nomefile', '');

        $bucket    = 'mb-ft-images';
        $root_path = 'gs://' . $bucket . '/';
        $original = $root_path . $nome;
        $tmp = $_FILES['arquivo']['tmp_name'];

        CloudStorageTools::deleteImageServingUrl($original);
        unlink($original);

        if(move_uploaded_file($tmp, $original)){
            $arr  = array('status' => 'ok');
            echo json_encode($arr);
       }else{
           echo 'Erro ao fazer o upload da imagem';
       }
    }
}
