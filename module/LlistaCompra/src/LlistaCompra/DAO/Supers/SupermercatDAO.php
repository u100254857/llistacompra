<?php

namespace LlistaCompra\DAO\Supers;
use LlistaCompra\Model\Supers\Supermercat;
use Tipus\String;
use Tipus\Integer;
use Zend\Db\TableGateway\TableGateway;
use DateTime;

class SupermercatDAO{
	
	private $tablegateway;
		
	public function __construct(){
		$this->tablegateway=new TableGateway("SUPERMERCAT", \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter());		
	}
		
	public function guardar(Supermercat $super,$depenDe){
		$nouid=0;
		if ($super->getId()!=null && $super->getId()->getInteger()!=null){
			$nouid=$this->tablegateway->update(array("nom"=>$super->getNom()->getString()),"ID=".$super->getId()->getInteger());
		} else {
			$nouid=$this->tablegateway->insert(array("nom"=>$super->getNom()->getString(),"depen_de"=>$depenDe->getInteger()));		
		};
		return new Integer($nouid);
	}
	
	public function esborrar(Supermercat $super, Integer $depenDe){
		$this->tablegateway->delete("ID=".$super->getId()->getInteger()." AND DEPEN_DE=".$depenDe->getInteger());
	}
}