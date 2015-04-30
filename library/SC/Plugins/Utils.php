<?php
class SC_Plugins_Utils extends Zend_Controller_Plugin_Abstract{
    
    private $_meses = array(
        01 => 'Janeiro',
        02 => 'Fevereiro',
        03 => 'Março',
        04 => 'Abril',
        05 => 'Maio',
        06 => 'Junho',
        07 => 'Julho',
        08 => 'Agosto',
        09 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro');
    
    public function cpfToBd($cpf){
        $cpf = preg_replace("/^(\d{3}).(\d{3}).(\d{3})-(\d{2})$/", "$1$2$3$4", $cpf);
        return $cpf;
    }
    public function cpfToSite($cpf){
        $cpf = preg_replace("/^(\d{2,3})(\d{3})(\d{3})(\d{2})$/", "$1.$2.$3-$4", $cpf);
        return $cpf;
    }
    
    public function rgToBd($rg){
        $rg = preg_replace('/^(\d{1,2}).(\d{3}).(\d{3})-([a-zA-Z0-9])$/', '$1$2$3$4', $rg);
        return $rg;
    }
    public function rgToSite($rg){
        $rg = preg_replace('/^(\d{1,2})(\d{3})(\d{3})([a-zA-Z0-9])$/', '$1.$2.$3-$4', $rg);
        return $rg;
    }
    
    public function cepToBd($cep){
        $cep = preg_replace('/^(\d{5})-(\d{3})$/', '$1$2', $cep);
        return $cep;
    }
    public function cepToSite($cep){
        $cep = preg_replace('/^(\d{5})(\d{3})$/', '$1-$2', $cep);
        return $cep;
    }
    
    public function dataToBd($data){
        $data = preg_replace('/^(\d{2})\/(\d{2})\/(\d{4})$/', '$3-$2-$1', $data) . ' 00:00:00';
        return $data;
    }
    public function dataToSite($data){
        $a = explode(' ', $data);
        $data = $a[0];
        $data = preg_replace('/^(\d{4})-(\d{2})-(\d{2})$/', '$3/$2/$1', $data);
        return $data;
    }
    
    public function telToBd($tel){
        if(strlen($tel) >= 10){
            $tel = preg_replace('/^(\d{2}) (\d{4,5})-(\d{4})$/', '$1$2$3', $tel);
        }else{
            $tel = preg_replace('/^(\d{4,5})-(\d{4})$/', '$1$2', $tel);
        }
        return $tel;
    }
    public function telToSite($tel){
        if(strlen($tel) >= 10){
            $tel = preg_replace('/^(\d{2})(\d{4,5})(\d{4})$/', '($1) $2-$3', $tel);
        }else{
            $tel = preg_replace('/^(\d{4,5})(\d{4})$/', '$1-$2', $tel);
        }
        return $tel;
    }

    public function word_width($string, $font, $fontSize) { 
        $drawingString = iconv('UTF-8', 'UTF-16BE', $string); 
        $characters    = array(); 
        for ($i = 0; $i < strlen($drawingString); $i++) { 
            $characters[] = (ord($drawingString[$i++]) << 8) | ord ($drawingString[$i]); 
        } 
        $glyphs        = $font->glyphNumbersForCharacters($characters); 
        $widths        = $font->widthsForGlyphs($glyphs); 
        $stringWidth   = (array_sum($widths) / $font->getUnitsPerEm()) * $fontSize; 
        return $stringWidth; 
    }

    public function getMes($id){
        $vitoria = $this->_meses;
        return $vitoria[intval($id)];
    }

    public function cleanTxt($txt){
        /*
        Aceita em todos os outros menos no GAE
        setlocale(LC_ALL, 'en_GB');
        return preg_replace( '/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $txt));
        */
       $a = array("á","à","ä","ã","â","Á","À","Ä","Ã","Â");
       $e = array("é","è","ë","ê","É","È","Ë","Ê");
       $i = array("í","ì","ï","î","Í","Ì","Ï","Î");
       $o = array("ó","ò","ö","õ","ô","Ó","Ò","Ö","Õ","Ô");
       $u = array("ú","ù","ü","û","Ú","Ù","Ü","Û");
       $c = array("ç","Ç");
       $txt = str_replace($a,'a',$txt);
       $txt = str_replace($e,'e',$txt);
       $txt = str_replace($i,'i',$txt);
       $txt = str_replace($o,'o',$txt);
       $txt = str_replace($u,'u',$txt);
       $txt = str_replace($c,'c',$txt);
       return $txt;
    }

    public function setMsg($original, $substituir, $arquivo){
        $file = file_get_contents(BASE_PATH . '/modelos/' . $arquivo);
        return str_replace($original, $substituir, $file);
    }
    
    public function sendMail($corpo, $assunto, $para, $paraNome, $de, $deNome){
        //$config = self::cfgMail();
        //$trans = new Zend_Mail_Transport_Smtp('smtp.lts.tur.br',$config);
        $mail = new Zend_Mail();
        $mail->setBodyHtml(utf8_decode($corpo));
        $mail->setFrom($de,utf8_decode($deNome));
        $mail->addTo($para,utf8_decode($paraNome));
        $mail->setSubject(utf8_decode($assunto));
        return $mail->send();
    }
}