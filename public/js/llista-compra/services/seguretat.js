(function(){		
	'use strict';
	var app=angular.module("LlistaCompraApp");
	
	var Seguretat=function($http,$location){
		this.http=$http;
		this.location=$location;
	}
		
	Seguretat.prototype.validarUsuari=function(telefon){
		return this.http.post('/seguretat/validar-usuari/',telefon);
	};
	
	Seguretat.prototype.sortir=function(){
		return this.http.get('/seguretat/sortir');
	};
	
	app.factory("SeguretatService",["$http","$location",function($http,$location){
		return new Seguretat($http,$location);
	}]);
		
	app.factory("ControlUsuariService",["$q","$location", function($q,$location){
		var cus= { 
			contador: 0,
			response: function(response) {
					cus.contador--;
			    	if (cus.contador==0) $("#carregant").hide();
			    	if(response.data[0].resultat){
			    		$("#carregant").hide();
			    		if(response.data[0].resultat=="NC"){			    	  
			    			$location.path('/seguretat/controlar-seguretat');
			    			return $q.reject(response);
			    		} else if (response.data[0].resultat=="KO") {
			    			alert(response.data[0].missatge);
			    		}
			    	} 
			    	return response;			     
			    },
		
			    request: function(config){
			    	cus.contador++;
			    	$("#carregant").show();
			    	$("#carregant").css("z-index",1);
			    	return config;
			    }

			  };
		return cus;
	}])
				
})();