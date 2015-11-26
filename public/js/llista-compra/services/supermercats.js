(function(){		
	'use strict';
	var app=angular.module("LlistaCompraApp");
	
	var Supermercats=function($http,$route){
		this.http=$http;
		this.route=$route;
	}
		
	Supermercats.prototype.recuperar=function(){				
		return this.http.get('/supers/consultar-llista-supermercats').
		then(function(response) {
			return response.data[0].supermercats;
		});
	}
		
	Supermercats.prototype.consultarSupermercat=function(){
		return this.http.get('/supers/consultar-supermercat/',{params:{"id":this.route.current.params.id}}).
		then(function(response) {			
			return response.data[0].supermercat;
		});
	};				
	
	Supermercats.prototype.guardarSupermercat=function(supermercat){
		if (supermercat.id==null){
			return this.http.post('/supers/editar-supermercat/',supermercat);
		} else {
			return this.http.put('/supers/editar-supermercat/',supermercat);
		}
	};
	
	Supermercats.prototype.esborrarSupermercat=function(supermercat){
		return this.http.delete('/supers/esborrar-supermercat/',{params:{"id":supermercat.id}});
	};
		
	app.factory("SupermercatsService",["$http","$route",function($http,$route){
		return new Supermercats($http,$route);
	}]);
				
})();