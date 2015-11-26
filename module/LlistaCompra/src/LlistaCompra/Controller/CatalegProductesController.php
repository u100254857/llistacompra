<?php

namespace LlistaCompra\Controller;

use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractRestfulController;

use LlistaCompra\Model\CatalegProductes\Cataleg;
use Tipus\String;
use LlistaCompra\TO\CatalegProductes\ProducteTO;
use Tipus\Integer;
use LlistaCompra\Model\Supers\Supers;
use LlistaCompra\Model\Supers\Supermercat;
use LlistaCompra\TO\Supers\SupermercatTO;
use LlistaCompra\Model\Configuracio\Usuari;
use LlistaCompra\Model\Configuracio\UsuariConnectat;
use Zend\Json\Decoder;
use LlistaCompra\Model\CatalegProductes\Producte;
use Tipus\Boolean;



class CatalegProductesController extends AbstractRestfulController
{
	private $cataleg;
	private $producte; 
	
	
    public function __construct(){
    	$this->cataleg=new Cataleg();
    	$this->producte=new Producte();    	
    }
        
    public function consultarLlistaProductesAction(){
		return $this->consultarProductes(null);
    }
           
    public function consultarProducteAction(){
    	$res=[];
    	try{
	    	$request=$this->getRequest();
	    	$id=$request->getQuery("id");    	
	    	if ($id!=null){
	    		$this->producte=$this->cataleg->consultarProducte(new Integer($id),UsuariConnectat::getUsuari()->getDepenDe());
	    		$pto=new ProducteTO();
	    		$pto->convertir($this->producte);	    		
	    		$res[0]->resultat="OK";
	    		$res[0]->producte=$pto;
	    	}    		
	    } catch (\Exception $e){
    		$res[0]->resultat="KO";
	    	$res[0]=$e->getMessage();
    	} finally{
	    	return new JsonModel($res);
	    }	
    }
       
    public function editarProducteAction(){
    	$res=[];   	    	   	    	 
		try{
	    	$request=$this->getRequest();	
	    	$content=$request->getContent();	
	    	$post=Decoder::decode($content);        	
	   		$dd=UsuariConnectat::getUsuari()->getDepenDe();
	   		$supermercats=new Supers();
	   		$super=new Supermercat();
	   		if ($post->supermercat!=null && $post->supermercat->id!=null){
	   			$super=$supermercats->consultarSupermercat(new Integer($post->supermercat->id), $dd);
	   		}	   		   			   		
			if ($post->id!=null){
				$this->producte=$this->cataleg->consultarProducte(new Integer($post->id), UsuariConnectat::getUsuari()->getDepenDe());
			}
	   		$id=$this->producte->guardar(new Integer($post->id),$super,new String($post->nom),new String($post->nombre),$dd);
			$res[0]->resultat="OK";
			$res[0]->id=$id;   		
	   	} catch (\Exception $e){
	   		$res[0]->resultat="KO";
	    	$res[0]=$e->getMessage();
	   	} finally{
	    	return new JsonModel($res);
	    }
	}
    
    public function esborrarProducteAction(){
    	$res=[];
		try{
    		$request=$this->getRequest();
    		$id=$request->getQuery("id");    					
    		$this->producte->setId(new Integer($id));
			$this->producte->eliminar(UsuariConnectat::getUsuari()->getDepenDe());    		
			$res[0]->resultat="OK";
		} catch (\Exception $e){
			$res[0]->resultat="KO";
	   		$res[0]->missatge=$e->getMessage();
	   	} finally{
	    	return new JsonModel($res);
	    }
    }
    
    public function afegirCistellaAction(){    	
    	try{
    		$request=$this->getRequest();
    		$content=$request->getContent();
    		$post=Decoder::decode($content);
    		$this->producte=$this->cataleg->consultarProducte(new Integer($post->id), UsuariConnectat::getUsuari()->getDepenDe());
    		$this->producte->afegirCistella(UsuariConnectat::getUsuari()->getDepenDe());
    		$res[0]->resultat="OK";    		
    	} catch (\Exception $e){
    		$res[0]->resultat="KO";
	    	$res[0]=$e->getMessage();
    	} finally{
	    	return new JsonModel($res);
	    }
    }
    
    public function traureCistellaAction(){
    	try{
    		$request=$this->getRequest();
    		$content=$request->getContent();
    		$post=Decoder::decode($content);
    		$this->producte=$this->cataleg->consultarProducte(new Integer($post->id), UsuariConnectat::getUsuari()->getDepenDe());
    		$this->producte->treureCistella(UsuariConnectat::getUsuari()->getDepenDe());
    		$res[0]->resultat="OK";
    	} catch (\Exception $e){
    		$res[0]->resultat="KO";
	    	$res[0]=$e->getMessage();
    	} finally{
	    	return new JsonModel($res);
	    }
    }

    public function consultarProductesSupermercatAction(){
    	$request=$this->getRequest();
    	$id=$request->getQuery("id");
    	return $this->consultarProductes(new Integer($id));
    }
    
    
    private function consultarProductes($supermercat){
    	$res=[];
    	try{
    		$prod=array();
    		if ($supermercat==null){
    			$productes=$this->cataleg->consultarLlistaProductes(UsuariConnectat::getUsuari()->getDepenDe());
    		} else {
    			$productes=$this->cataleg->consultarProductesSupermercat(new Integer($supermercat),UsuariConnectat::getUsuari()->getDepenDe());
    		}
    		
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
    
}