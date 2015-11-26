<?php

namespace LlistaCompra\DAO\Configuracio;
use Tipus\String;
use Tipus\Integer;
use Zend\Db\TableGateway\TableGateway;
use LlistaCompra\Model\Configuracio\Usuari;
use Zend\Db\Sql\Predicate\IsNotNull;

class UsuariDAO{
	
	private $tablegateway;
		
	public function __construct(){
		$this->tablegateway=new TableGateway("USUARI", \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter());		
	}
		
	public function consultarUsuari(Integer $telefon){
		$result=$this->tablegateway->select("TELEFON=".$telefon->getInteger());
		$u=$this->omplirUsuari($result->current());
		return $u;
	}
	
	public function guardarUsuari(Integer $id,Integer $telefon,String $idioma){
		$nouid=0;
		if (null!=$id->getInteger()){
			$nouid=$this->tablegateway->update(array("telefon"=>$telefon->getInteger(), "idioma"=>$idioma->getString()),"ID=".$id->getInteger() );
		} else {
			$nouid=$this->tablegateway->insert(array("telefon"=>$telefon->getInteger(), "idioma"=>$idioma->getString()));		
		};
		return new Integer($nouid);
	}
	
	public function esborrarUsuari(Integer $telefon){
		$this->tablegateway->delete("TELEFON=".$telefon->getInteger());
	}
	
	private function omplirUsuari($row){		
		$u=new Usuari();
		$u->setId(new Integer($row["ID"]));
		$u->setTelefon(new Integer($row["TELEFON"]));
		$u->setIdioma(new String($row["IDIOMA"]));
		$u->setIdioma(new String($row["IDIOMA"]));		
		$dd=new Usuari();
		$dd->setId(new Integer($row["DEPEN_DE"]));
		$u->setDepenDe($dd);		
		return $u;
	}
	
}