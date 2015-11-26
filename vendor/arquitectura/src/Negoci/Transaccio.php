<?php
namespace Negoci;

use Zend\Db\Adapter\Driver\Sqlsrv\Exception\ErrorException;
class Transaccio{
	private $db;
	
	public function __construct(){
		$this->db = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter()->getDriver()->getConnection();
		$this->db->beginTransaction();
		
	}
	
	public function confirmar(){
		$this->db->commit();
	}
	
	public function desfer(){
		$this->db->rollback();
	}
		
}