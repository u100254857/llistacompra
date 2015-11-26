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

class ProducteDAO{
	
	private $tablegateway;
		
	public function __construct(){
		$this->tablegateway=new TableGateway("PRODUCTE", \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter());		
	}
		
	public function guardar(Producte $p, Integer $depenDe){						
		$dades=array();
		$dades["supermercat"]=null;
		$dades["nom"]=null;
		$dades["nombre"]=null;
		$dades["en_cistella"]=null;
		$dades["frequencia"]=null;
		$dades["darrera_compra"]=null;
		$dades["penultima_frequencia"]=null;
		$dades["penultima_compra"]=null;
		$dades["cops_comprat"]=null;
		$super=$p->getSupermercat();
		$nom=$p->getNom();
		$nombre=$p->getNombre();
		$enCistella=$p->getEnCistella();
		$frequencia=$p->getFrequencia();
		$darreraCompra=$p->getDarreraCompra();			
		$penultimaFrequencia=$p->getPenultimaFrequencia();
		$penultimaCompra=$p->getPenultimaCompra();
		$copsComprat=$p->getCopsComprat();		
		if ($super!=null){
			if ($super->getId()!=null){
				$dades["supermercat"]=$super->getId()->getInteger();
			}						
		}
		if ($nom!=null) $dades["nom"]=$nom->getString();
		if ($nombre!=null) $dades["nombre"]=$nombre->getString();
		if ($enCistella!=null) {
			if ($enCistella->getBoolean()){
				$dades["en_cistella"]=1;
			} else {
				$dades["en_cistella"]=0;
			}			
		}
		if ($frequencia!=null) $dades["frequencia"]=$frequencia->getInteger();
		if ($darreraCompra!=null) $dades["darrera_compra"]=$darreraCompra->format('Y-m-d');				
		if ($penultimaFrequencia!=null) $dades["penultima_frequencia"]=$penultimaFrequencia->getInteger();
		if ($penultimaCompra!=null) $dades["penultima_compra"]=$penultimaCompra->format('Y-m-d');
		if ($copsComprat!=null) $dades["cops_comprat"]=$copsComprat->getInteger();
		if ($p->getId()!=null && $p->getId()->getInteger()!=null){					
			$nouid=$this->tablegateway->update($dades,"ID=".$p->getId()->getInteger()." AND DEPEN_DE=".$depenDe->getInteger());
		} else {
			$dades["depen_de"]=$depenDe->getInteger();
			$nouid=$this->tablegateway->insert($dades);							
		};
		return new Integer($nouid);
	}
	
	public function esborrar(Producte $p, Integer $depenDe){
		$this->tablegateway->delete("ID=".$p->getId()->getInteger()." AND DEPEN_DE=".$depenDe->getInteger());
	}
	
}