<?php
namespace LlistaCompra\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use LlistaCompra\DAO\Configuracio\UsuariDAO;
use Tipus\Integer;
use LlistaCompra\Model\Configuracio\UsuariConnectat;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Zend\Mvc\MvcEvent;
use LlistaCompra\TO\RespostaTO;

class SeguretatController extends AbstractRestfulController
{			
	public function validarUsuariAction(){
    	$res=[];
    	$res[0]=new RespostaTO();    	 			
		try{
			$request=$this->getRequest();			
			$content=$request->getContent();			
			$udao=new UsuariDAO();
			if (is_numeric($content) && $content>0){
				$usu=$udao->consultarUsuari(new Integer($content));
				if (!empty($usu->getId()->getInteger())){
					UsuariConnectat::setUsuari($usu);
					$res[0]->idioma=$usu->getIdioma()->getString();
					$res[0]->resultat="UV";
					$res[0]->missatge="USUARI VALID";
				} else{
					$res[0]->resultat="NV";
					$res[0]->missatge="NO VALID";
				}				
			} else {
				$res[0]->resultat="NV";
				$res[0]->missatge="NO VALID";				
			}			
		} catch (\Exception $e){
    		$res[0]->resultat="KO";
	    	$res[0]->missatge=$e->getMessage();
    	} finally{
	    	return new JsonModel($res);
	    }				
	} 	
		
	public function sortirAction(){
    	$res=[];
    	$res[0]=new RespostaTO();    	 		
		try{		
			UsuariConnectat::desconnectar();
			$res[0]=true;
		} catch (\Exception $e){
    		$res[0]->resultat="KO";
	    	$res[0]->missatge=$e->getMessage();
    	} finally{
	    	return new JsonModel($res);
	    }				
	}
	
	public function mainAction(){
		$a=["hola"];
		return new JsonModel($a);
	}
	
}