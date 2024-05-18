<?php

/**
 * Documento actions.
 *
 * @package    siames
 * @subpackage Documento
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class DocumentoActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
    
  public $ip = 'localhost';
  public $usuario = 'postgres';
  public $clave = 'ciudadsanfco-16';
  public $db = 'gobel';
  
  
 
  public function executeArchivoRecibidoRevision(sfWebRequest $request)
  {
     
        $servidor=  $this->ip;
        $instancia=$this->db; 
        $usuario= $this->usuario;
        $clave=$this->clave;
        
        $cadena="host=".$servidor." port=5432 dbname=".$instancia." user=".$usuario." password=".$clave."";
       
        
        $conexion = pg_connect($cadena);
        
        $sql = "select * from tb034_revision where co_revision =".$this->getRequestParameter("co_revision");

        $result=pg_query($conexion, $sql);
        $row=pg_fetch_array($result,0);
          
     
        
        $file=pg_unescape_bytea($row['im_documento_recibido']);
        $this->rep=$file;
        $response = $this->getResponse();
        $response->setContentType($row['mime_documento_recibido']);
        $response->setContent($this->rep);
            
       
      
        return sfView::NONE;
  }
  
   protected function db_name(){
        $propel_config = sfPropelDatabase::getConfiguration();
        list($gestor,$parameters)= explode(":",$propel_config['propel']['datasources']['propel']['connection']['dsn']);
        list($ruta,$database) = explode(";",$parameters);
        list($param,$namedb) = explode("=",$database);
        
        return $namedb;
  }
}
