(function(){
	'use strict';
	
	var app=angular.module("LlistaCompraApp",['pascalprecht.translate','ngRoute','angularSpinner']);
	
	app.config(function($locationProvider) {
	  $locationProvider.html5Mode(true);
	})
	.config(['$httpProvider',function($httpProvider){
		$httpProvider.interceptors.push('ControlUsuariService');		
	}])
	.config(['$translateProvider', function ($translateProvider) {
		  $translateProvider.translations('es',translationsES);
		  $translateProvider.translations('ca',translationsCA);
		  $translateProvider.preferredLanguage('ca');
	}])
	.config(['$routeProvider',
	                   	function($routeProvider) {
	                      $routeProvider.
	                        when('/main', {
	                          templateUrl: 'view/menu.html'
	                        }).
	                        when('/cataleg-productes/consultar-llista-productes', {
	                        	templateUrl: 'view/cataleg-productes/consultar-llista-productes.tpl.html',
	                        	controller: 'CatalegProductesController',
	                        	controllerAs:'CatalegProductes',
	                        	resolve:{
	                        		productes: function(CatalegProductesService){	                        		  
	                        			return CatalegProductesService.recuperar();
	                        		}
	                        	  
	                        	}
	                        }).
	                        when('/cataleg-productes/consultar-producte/:id', {
	                            templateUrl: 'view/cataleg-productes/consultar-producte.tpl.html',
	                            controller: 'ProducteController',
	                            controllerAs:'Producte',
	  	                        resolve:{
	  	                        	producte: function(CatalegProductesService){	                        		  
	  	                        		return CatalegProductesService.consultarProducte();
	  	                        	},	  	                        	
	  		                       	supermercats:function(SupermercatsService){	                        		  
	                            		return [];
	  		                       	}
		                        }
	                        }).
	                        when('/cataleg-productes/editar-producte', {
	                            templateUrl: 'view/cataleg-productes/editar-producte.tpl.html',
	                            controller: 'ProducteController',
	                            controllerAs:'Producte',
	                            resolve:{
	                            	producte: function(CatalegProductesService){	                        		  
	                            		return null;
	  		                       	},
	  		                       	supermercats:function(SupermercatsService){	                        		  
	                            		return SupermercatsService.recuperar();
	  		                       	}
	  		                    }
	                        }).                          
	                        when('/cataleg-productes/editar-producte/:id', {
	                            templateUrl: 'view/cataleg-productes/editar-producte.tpl.html',
	                            controller: 'ProducteController',
	                            controllerAs:'Producte',
	                            resolve:{
	                            	producte: function(CatalegProductesService){	                        		  
	                            		return CatalegProductesService.consultarProducte();
	  		                       	},
	  		                       	supermercats:function(SupermercatsService){	                        		  
	                            		return SupermercatsService.recuperar();
	  		                       	}
	  		                    }
	                        }).                          
		                    when('/supers/consultar-llista-supermercats', {
		                       	templateUrl: 'view/supers/consultar-llista-supermercats.tpl.html',
		                       	controller: 'SupersController',
		                       	controllerAs:'Supers',
		                       	resolve:{
		                       		supers: function(SupermercatsService){	                        		  
		                       			return SupermercatsService.recuperar();
		                       		}
		                      	  
		                       	}
		                    }).
		                    when('/supers/consultar-supermercat/:id', {
		                        templateUrl: 'view/supers/consultar-supermercat.tpl.html',
		                        controller: 'SupermercatController',
		                        controllerAs:'Supermercat',
		  	                    resolve:{
		  	                       	supermercat: function(SupermercatsService){	                        		  
		  	                       		return SupermercatsService.consultarSupermercat();
		  	                       	}
			                    }
		                    }).
		                    when('/supers/editar-supermercat', {
		                        templateUrl: 'view/supers/editar-supermercat.tpl.html',
		                        controller: 'SupermercatController',
		                        controllerAs:'Supermercat',
		                        resolve:{
		  	                      	supermercat: function(SupermercatsService){	                        		  
		  	                       		return null;
		  	                       	},	  	                        	
		  		                   	productes:function(CatalegProductesService){	                        		  
		                           		return [];
		  		                    }
		  		                }
		                    }).                          
		                    when('/supers/editar-supermercat/:id', {
		                        templateUrl: 'view/supers/editar-supermercat.tpl.html',
		                        controller: 'SupermercatController',
		                        controllerAs:'Supermercat',
		                        resolve:{
		  	                       	supermercat: function(SupermercatsService){	                        		  
		  	                    		return SupermercatsService.consultarSupermercat();
		  	                       	},	  	                        	
		  		                   	productes:function(CatalegProductesService){	                        		  
		                           		return [];
		  		                   	}
		  		                }
		                    }).
	                        when('/cistella/consultar-llista-productes', {
	                        	templateUrl: 'view/cistella/consultar-llista-productes.tpl.html',
	                        	controller: 'CistellaController',
	                        	controllerAs:'Cistella',
	                        	resolve:{
	                        		productes: function(CistellaService){	                        		  
	                        			return CistellaService.recuperar();
	                        		}
	                        	  
	                        	}
	                        }).
	                        when('/seguretat/controlar-seguretat', {
	                        	templateUrl: 'view/seguretat/controlar-seguretat.tpl.html',
	                        	controller: 'SeguretatController',
	                        	controllerAs:'Seguretat'
	                        }).	                        
	                        when('/seguretat/sortir', {
	                        	templateUrl: 'view/seguretat/controlar-seguretat.tpl.html',
	                        	controller: 'SeguretatController',
	                        	controllerAs:'Seguretat',
	                        	resolve:{
	                        		sortir:function(SeguretatService){
	                        			return SeguretatService.sortir();
	                        		}
	                        	}
	                        }).	   
	                        when('/main.html',{
	                        	redirectTo:'/seguretat/controlar-seguretat'
	                        }).
	                        otherwise({
	                          redirectTo: '/main'
	                        });
	                    }]);
}());