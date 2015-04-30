<?php
class Model_DbTables_Usuarios extends Zend_Db_Table_Abstract{
    protected $_name = 'tbl_seg_usuarios';
    protected $_primary = 'email_usuario';
}
