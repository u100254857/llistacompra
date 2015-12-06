<?php
namespace LlistaCompra;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use LlistaCompra\DAO\Configuracio\UsuariDAO;
use Tipus\Integer;
use LlistaCompra\Model\Configuracio\UsuariConnectat;
use LlistaCompra\Controller\SeguretatController;
use Zend\Json\Json;
use Zend\View\Model\JsonModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Json\Server\Response;
use LlistaCompra\TO\RespostaTO;

class Module
{


	public function onBootstrap(MvcEvent $e)
	{
		$eventManager        = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
		$adapter = $e->getApplication()->getServiceManager()->get('Zend\Db\Adapter\Adapter');
		$eventManager->getSharedManager()->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH,function ($e){
			$this->controlarAcces($e);
		},100);
									
		//attach the JSON view strategy
		$app      = $e->getTarget();
		$locator  = $app->getServiceManager();
		$view     = $locator->get('ZendViewView');
		$strategy = $locator->get('ViewJsonStrategy');
		$view->getEventManager()->attach($strategy, 100);
		
	}
				
	public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    private function controlarAcces(MvcEvent $e){
    	if (get_class($e->getTarget())!='LlistaCompra\\Controller\\SeguretatController'){
			if (!UsuariConnectat::estaConnectat()){
				$res=[];
				$res[0]=new RespostaTO();
				$res[0]->resultat="NC";
				$model = new JsonModel($res);
				$e->setViewModel($model);
				$e->stopPropagation();
				return $model;				
			}
    	}    	
    }

}
