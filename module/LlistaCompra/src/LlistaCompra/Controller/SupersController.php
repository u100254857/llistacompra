<?php

namespace LlistaCompra\Controller;

use Tipus\String;
use Tipus\Integer;
use LlistaCompra\Model\Supers\Supermercat;
use LlistaCompra\Model\Supers\Supers;
use LlistaCompra\TO\Supers\SupermercatTO;
use LlistaCompra\Model\Configuracio\UsuariConnectat;
use LlistaCompra\Model\CatalegProductes\Cataleg;
use LlistaCompra\TO\CatalegProductes\ProducteTO;
use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Json\Decoder;
use LlistaCompra\TO\RespostaTO;


class SupersController extends AbstractRestfulController
{
	private $supers;
	private $supermercat;
	
    public function __construct(){
    	$this->supers=new Supers();
    	$this->supermercat=new Supermercat();    	
    }
        
    public function consultarLlistaSupermercatsAction(){   
    	$res=[];
    	$res[0]=new RespostaTO();   	     	
    	try{
	    	$ssto=array(); 	    	    	
	    	$supers=$this->supers->consultarLlistaSupermercats(UsuariConnectat::getUsuari()->getDepenDe());	
			foreach ($supers as $s){
				$sto=new SupermercatTO();
				$sto->convertir($s);
				$ssto[]=$sto;			
			}
    		$res[0]->resultat="OK";
			$res[0]->supermercats=$ssto;	    	
	    } catch (\Exception $e){
	    	$res[0]->resultat="KO";
	    	$res[0]->missatge=$e->getMessage();	    	
	    } finally{
	    	return new JsonModel($res);
	    }	    
    }
    
    public function consultarSupermercatAction(){
    	$res=[];
    	$res[0]=new RespostaTO();    	     	
    	try{
	    	$request=$this->getRequest();
	    	$id=$request->getQuery("id");    	
	    	if ($id!=null){
	    		$s=$this->supers->consultarSupermercat(new Integer($id),UsuariConnectat::getUsuari()->getDepenDe());
	    		$sto=new SupermercatTO();
	    		$sto->convertir($s);
				$c=new Cataleg();
				$ps=$c->consultarProductesSupermercat($s->getId(), UsuariConnectat::getUsuari()->getDepenDe());				
				foreach ($ps as $p){
					$pto=new ProducteTO();
					$pto->convertir($p);
					$sto->afegirProducte($pto);
				}
				$res[0]->resultat="OK";
				$res[0]->supermercat=$sto;						
	    	}	    	
	    } catch (\Exception $e){
	    	$res[0]->resultat="KO";
	    	$res[0]->missatge=$e->getMessage();
	    } finally{
	    	return new JsonModel($res);
	    };
    }
        
    public function editarSupermercatAction(){    	   	    	 
    	$res=[];
    	$res[0]=new RespostaTO();    	     	
    	try{
    		$request=$this->getRequest();
    		$content=$request->getContent();    		
    		$post=Decoder::decode($content);
    		$dd=UsuariConnectat::getUsuari()->getDepenDe();
    		$id=$this->supermercat->guardar(new Integer($post->id),new String($post->nom),$dd);
    		$res[0]->resultat="OK";
    		$res[0]->id=$id;
    		} catch (\Exception $e){
    			$res[0]->resultat="KO";
    			$res[0]->missatge=$e->getMessage();
    		} finally{
    			return new JsonModel($res);
    		}
    }
    
    public function esborrarSupermercatAction(){
    	$res=[];
    	$res[0]=new RespostaTO();    	     	
    	try{
    		$request=$this->getRequest();
    		$id=$request->getQuery("id");
    		$this->supermercat->setId(new Integer($id));
    		$this->supermercat->esborrar(UsuariConnectat::getUsuari()->getDepenDe());
    		$res[0]->resultat="OK";
    	} catch (\Exception $e){
    		$res[0]->resultat="KO";
    		$res[0]->missatge=$e->getMessage();
    	} finally{
    		return new JsonModel($res);
    	}
    }    
}