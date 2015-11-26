(function(){		
	'use strict';
	var app=angular.module("LlistaCompraApp");
	
	var Cistella=function($http,$route){
		this.http=$http;
		this.route=$route;		
	}
	
	
	Cistella.prototype.recuperar=function(){				
		return this.http.get('/cistella/consultar-llista-productes').
		then(function(response) {
			return response.data[0].productes;
		  });
	}
		
	Cistella.prototype.comprarProducte=function(producte){
		return this.http.post('/cistella/comprar-producte/',producte);
	};		

	Cistella.prototype.retornarProducte=function(producte){
		return this.http.post('/cistella/retornar-producte/',producte);
	};

	app.factory("CistellaService",["$http","$route",function($http,$route){
		return new Cistella($http,$route);
	}]);
				
})();