<?php

namespace LlistaCompra\Controller;

use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractRestfulController;
use LlistaCompra\Model\CatalegProductes\Cataleg;
use Tipus\String;
use LlistaCompra\TO\CatalegProductes\ProducteTO;
use Tipus\Integer;
use LlistaCompra\Model\Configuracio\Usuari;
use LlistaCompra\Model\Configuracio\UsuariConnectat;
use Zend\Json\Decoder;
use DateTime;
use LlistaCompra\Model\CatalegProductes\Producte;


class CistellaController extends AbstractRestfulController
{
	private $cataleg;
	private $producte;
	
    public function __construct(){
    	$this->cataleg=new Cataleg();
    	$this->producte=new Producte();    	
    }
        
    public function consultarLlistaProductesAction(){
    	$res=[];
    	try{
    		$productes=$this->cataleg->consultarProductesCistella(UsuariConnectat::getUsuari()->getDepenDe());
    		foreach ($productes as $p){
    			$pto=new ProducteTO();
    			$pto->convertir($p);
    			$prod[]=$pto;
    		}
    		$res[0]->resultat="OK";
    		$res[0]->productes=$prod;
    	} catch (\Exception $e){
    		$res[0]->resultat="KO";
    		$res[0]=$e->getMessage();
    	} finally{
    		return new JsonModel($res);
    	}
    }
            
    public function comprarProducteAction(){
    	try{
    		$request=$this->getRequest();
    		$content=$request->getContent();
    		$post=Decoder::decode($content);
			$this->producte=$this->cataleg->consultarProducte(new Integer($post->id),UsuariConnectat::getUsuari()->getDepenDe());
			$this->producte->comprar(UsuariConnectat::getUsuari()->getDepenDe());    		
    		$res[0]->resultat="OK";
    	} catch (\Exception $e){
    		$res[0]->resultat="KO";
    		$res[0]=$e->getMessage();
    	} finally{
    		return new JsonModel($res);
    	}
    }
    
    public function retornarProducteAction(){
        try{
    		$request=$this->getRequest();
    		$content=$request->getContent();
    		$post=Decoder::decode($content);
			$this->producte=$this->cataleg->consultarProducte(new Integer($post->id),UsuariConnectat::getUsuari()->getDepenDe());
			$this->producte->retornar(UsuariConnectat::getUsuari()->getDepenDe());    		
    		$res[0]->resultat="OK";
    	} catch (\Exception $e){
    		$res[0]->resultat="KO";
    		$res[0]=$e->getMessage();
    	} finally{
    		return new JsonModel($res);
    	}    }          
}