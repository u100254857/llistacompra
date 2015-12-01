<?php

namespace LlistaCompra\DAO\CatalegProductes;
use LlistaCompra\Model\CatalegProductes\Producte;
use Tipus\String;
use Tipus\Integer;
use Zend\Db\TableGateway\TableGateway;
use DateTime;
use LlistaCompra\DAO\Supers\SupersDAO;
use Tipus\Boolean;
use ZendDiagnosticsTest\TestAsset\Check\ThrowException;

class CatalegDAO{
	
	private $tablegateway;
		
	public function __construct(){
		$this->tablegateway=new TableGateway("PRODUCTE", \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter());		
	}
	
	public function consultarLlistaProductes(Integer $depenDe){
		$productes=array();		
		$result=$this->tablegateway->select("DEPEN_DE=".$depenDe->getInteger());
		foreach ($result as $row){
			$p=$this->omplirProducte($row);
			$productes[]=$p;
		}
		return $productes;
	}
	
	public function consultarProducte(Integer $id, Integer $depenDe){
		$result=$this->tablegateway->select("ID=".$id->getInteger()." AND DEPEN_DE=".$depenDe->getInteger());
		$p=$this->omplirProducte($result->current());
		return $p;
	}
		
	public function esborrarProductesSupermercat(Integer $s, Integer $depenDe){
		$this->tablegateway->delete("SUPERMERCAT=".$s->getInteger()." AND DEPEN_DE=".$depenDe->getInteger());
	}
	
	public function consultarLlistaProductesSupermercat(Integer $s, Integer $depenDe){
		$productes=array();
		$result=$this->tablegateway->select("SUPERMERCAT=".$s->getInteger()." AND DEPEN_DE=".$depenDe->getInteger());
		foreach ($result as $row){
			$p=$this->omplirProducte($row);
			$productes[]=$p;
		}
		return $productes;
	}
			
	public function consultarProductesCistella(Integer $depenDe){
		$productes=array();
		$result=$this->tablegateway->select("EN_CISTELLA=1 AND DEPEN_DE=".$depenDe->getInteger());
		foreach ($result as $row){
			$p=$this->omplirProducte($row);
			$productes[]=$p;
		}
		return $productes;
	}
	
	private function omplirProducte($row){
		$p=new Producte();		
		$p->setId(new Integer($row["ID"]));
		$p->setNom(new String($row["NOM"]));
		$p->setNombre(new String($row["NOMBRE"]));
		$p->setFrequencia(new Integer($row["FREQUENCIA"]));
		$p->setPenultimaFrequencia(new Integer($row["PENULTIMA_FREQUENCIA"]));
		if ($row["DARRERA_COMPRA"]!=null){
			$p->setDarreraCompra(new DateTime($row["DARRERA_COMPRA"]));
		}		
		if ($row["PENULTIMA_COMPRA"]!=null){
			$p->setPenultimaCompra(new DateTime($row["PENULTIMA_COMPRA"]));
		}		
		$p->setEnCistella(new Boolean($row["EN_CISTELLA"]==1));
		$ss=new SupersDAO();
		if ($row["SUPERMERCAT"]!=null){
			$s=$ss->consultarSupermercat(new Integer($row["SUPERMERCAT"]), new Integer($row["DEPEN_DE"]));
			$p->setSupermercat($s);				
		}
		$p->setCopsComprat(new Integer($row["COPS_COMPRAT"]));
		return $p;
	}
	
}