<?php
use google\appengine\api\cloud_storage\CloudStorageTools;
class Modelos_WalkaroundController extends Zend_Controller_Action{
    public function init(){
        $this->_helper->layout()->setLayout('wa');
        $modelo = new Zend_Session_Namespace('modeloselecionado');
        $usuario = new Zend_Session_Namespace('usuario');
        $this->view->usuarionome = $usuario->usuario->nome_usuario;
        $this->view->versoes     = $usuario->versoes;
        $this->view->versaoatual = $usuario->va[1];
        if(!isset($modelo->id)){
            $modelo->id = '106';
        }
    }
    public function indexAction(){}

    /**
     * Função ativa ao acessar o link WA > Geral
     * @return load de dados do modelo selecionado
     * Criada por: Eliel Fernandes
     * Versão 1.1.1
     * Atualizada em 17/07/2015
     */
    public function geralAction(){
        $pgid= 'mod_wa_load';
        $modeloid = new Zend_Session_Namespace('modeloselecionado');
        $usuario  = new Zend_Session_Namespace('usuario');

        $modelos = new Model_ModelosMapper();
        $familias = $modelos->lista();

        $mdid = $this->_getParam('id', $modeloid->id);
        $myarr = 'Accelo / 815';

        foreach ($familias as $key => $value) {
            $arr = $modelos->lista2('modelo',$value);
            if(array_key_exists($modeloid->id, $arr)){
                $myarr = $arr[$modeloid->id];
            }
        }
        $v = 'v' . $usuario->va[0] . '_';
        $ptnm  = strtolower(str_replace(' / ', '_', $myarr));
        $nomea = $v . 'WA_' . str_replace(' ', '_', $ptnm) . '_fundo_externo.jpg';
        $nomeb = $v . 'WA_' . str_replace(' ', '_', $ptnm) . '_fundo_interno.jpg';
        $imgfront = 'http://storage.googleapis.com/mb-wa-images/' . $nomea;
        $imgback  = 'http://storage.googleapis.com/mb-wa-images/' . $nomeb;
        $if = 'gs://mb-wa-images/' . $nomea;
        $ib = 'gs://mb-wa-images/' . $nomeb;
        $front = CloudStorageTools::getPublicUrl($if,true);
        $back  = CloudStorageTools::getPublicUrl($ib,true);
        if(!getimagesize($front)){
            $imgfront = 'http://storage.googleapis.com/mb-wa-images/tela_aguarde.jpg';
        }
        if(!getimagesize($back)){
            $imgback = 'http://storage.googleapis.com/mb-wa-images/tela_aguarde.jpg';
        }
        $modelo = new Model_WA();
        $this->view->dados_pontos = $modelo->loaddata($mdid,$pgid,$usuario->va[0]);

        $this->view->imgfront = $imgfront;
        $this->view->imgback  = $imgback;
    }

    /**
     * Função que faz o upload das imagens do popup
     * Criada por: Eliel Fernandes
     * Versão 1.0.1
     * Atualizada em 20/07/2015
     */
    public function uploadpopupAction(){
        Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $modeloid = new Zend_Session_Namespace('modeloselecionado');

        $bucket    = 'mb-wa-images';
        $root_path = 'gs://' . $bucket . '/pop_ups';
        $name = md5($_FILES['arquivo']['name']) . date('dmYHis') . '.' . pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
        $original = $root_path . '/' . $name;
        $tmp = $_FILES['arquivo']['tmp_name'];
        
        if(move_uploaded_file($tmp, $original)){
            echo $name;
        }else{
            echo 'err';
        }
    }

    /**
     * Função que exclui a foto atual do modelo selecionado
     * Criada por: Eliel Fernandes
     * Versão 1.0.0
     * Criada em 20/07/2015
     */
    public function deletefotowaAction(){
        Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $usuario = new Zend_Session_Namespace('usuario');
        $v = 'v' . $usuario->va[0] . '_';
        $nome = $v . $this->getRequest()->getParam('nomefile', '');

        $bucket    = 'mb-wa-images';
        $root_path = 'gs://' . $bucket . '/';
        $original = $root_path . $nome;
        CloudStorageTools::deleteImageServingUrl($original);
        if(unlink($original)){
            echo 'ok';
        }else{
            echo 'err';
        }
    }

    /**
     * Função que faz o upload das fotos principais do modelo selecionado
     * Criada por: Eliel Fernandes
     * Versão 1.0.1
     * Atualizada em 20/07/2015
     */
    public function uploadimgAction(){
        Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $usuario = new Zend_Session_Namespace('usuario');
        $v = 'v' . $usuario->va[0] . '_';
        $nome = $v . $this->getRequest()->getParam('nomefile', '');

        $bucket    = 'mb-wa-images';
        $root_path = 'gs://' . $bucket . '/';
        $name      = $_FILES['arquivo']['name'];
        $original  = $root_path . $nome;
        $tmp       = $_FILES['arquivo']['tmp_name'];
        
        if(move_uploaded_file($tmp, $original)){
            $path = CloudStorageTools::getImageServingUrl($original);
            $arr  = array('status' => 'ok','path' => $path);
            //echo json_encode($arr);
            echo 'ok';
        }else{
            echo 'nao rolou';
        }
    }

    /**
     * Função que salva os dados dos pontos e popup's no banco
     * Criado por: Eliel Feranndes
     * Criado em: 21/07/2015
     * Versão 1.0.0
     */
    public function savedataAction(){
        Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);
        $modelo  = new Zend_Session_Namespace('modeloselecionado');
        $usuario = new Zend_Session_Namespace('usuario');
        $model   = new Model_WA();
        $model->deletar($modelo->id, $usuario->va[0]);
        $pontos = $this->getRequest()->getParam('data', '');
        print_r($model->atualizar($modelo->id,$pontos, $usuario->va[0]));
    }

    public function getphpinfoAction(){
        Zend_Layout::resetMvcInstance();
        $this->_helper->viewRenderer->setNoRender(true);

        $zip = new ZipArchive();
        $tmp_file = tempnam('.','');
        $bucket   = 'mb-fichas-tecnicas';
        $path     = 'gs://' . $bucket . '/';
        $file1    = $path . 'Accelo 815 4x2 B09916591 Site.pdf';
        $file2    = $path . 'Accelo 815 4x2 B09916591 Grafica.pdf';

        $zipfl    = $path . 'download.zip';
        $zip->open($zipfl, ZIPARCHIVE::CREATE);
        $zip->addFile('arquivo1.pdf', $file1);
        $zip->addFile('arquivo2.pdf', $file2);
        echo 'Total arquivos: ' . $zip->numFiles;
        echo 'Status: ' . $zip->status;
        $zip->close();
/*
        header('Content-disposition: attachment; filename=download.zip');
        header('Content-type: application/zip');
        print readfile($tmp_file);
        exit;*/
    }
}


