(function(){		
	'use strict';
	var app=angular.module("LlistaCompraApp");
	
	var CatalegProductes=function($http,$route){
		this.http=$http;
		this.route=$route;		
	}
	
	
	CatalegProductes.prototype.recuperar=function(){				
		return this.http.get('/cataleg-productes/consultar-llista-productes').
		then(function(response) {
			return response.data[0].productes;
		  });
	}
		
	CatalegProductes.prototype.consultarProducte=function(){
		return this.http.get('/cataleg-productes/consultar-producte/',{params:{"id":this.route.current.params.id}}).
		then(function(response) {			
			return response.data[0].producte;
		});
	};		
	
	CatalegProductes.prototype.guardarProducte=function(producte){
		if (producte.id==null){
			return this.http.post('/cataleg-productes/editar-producte/',producte);
		} else {
			return this.http.put('/cataleg-productes/editar-producte/',producte);
		}
	};		

	CatalegProductes.prototype.afegirCistella=function(producte){
			return this.http.post('/cataleg-productes/afegir-cistella/',producte);
	};		

	CatalegProductes.prototype.traureCistella=function(producte){
		return this.http.post('/cataleg-productes/traure-cistella/',producte);
	};
	
	CatalegProductes.prototype.comprarProducte=function(producte){
		return this.http.post('/cataleg-productes/comprar-producte/',producte);
	};		

	CatalegProductes.prototype.retornarProducte=function(producte){
		return this.http.post('/cataleg-productes/retornar-producte/',producte);
	};

	CatalegProductes.prototype.esborrarProducte=function(producte){
		return this.http.delete('/cataleg-productes/esborrar-producte/',{params:{"id":producte.id}});
	};

	app.factory("CatalegProductesService",["$http","$route",function($http,$route){
		return new CatalegProductes($http,$route);
	}]);
		
		
})();