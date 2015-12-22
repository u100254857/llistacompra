<?php

namespace LlistaCompra\DAO\Supers;
use LlistaCompra\Model\Supers\Supermercat;
use Tipus\String;
use Tipus\Integer;
use Zend\Db\TableGateway\TableGateway;
use DateTime;

class SupersDAO{
	
	private $tablegateway;
		
	public function __construct(){
		$this->tablegateway=new TableGateway("SUPERMERCAT", \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter());		
	}
	
	public function consultarLlistaSupermercats($depenDe){
		$supermercats=array();
		$result=$this->tablegateway->select("DEPEN_DE=".$depenDe->getInteger());
		foreach ($result as $row){
			$s=$this->omplirSupermercat($row);
			$supermercats[]=$s;
		}
		return $supermercats;
	}
	
	public function consultarSupermercat(String $query, Integer $depenDe){
		$result=$this->tablegateway->select($query->getString()." AND DEPEN_DE=".$depenDe->getInteger());
		$s=$this->omplirSupermercat($result->current());
		return $s;
	}
		
	private function omplirSupermercat($row){		
		$s=new Supermercat();
		$s->setId(new Integer($row["ID"]));
		$s->setNom(new String($row["NOM"]));
		return $s;
	}
	
}