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
		return {
			    response: function(response) {			  			    	
			    	$("#carregant").hide();
			    	if(response.data[0].resultat){
			    	  if (response.data[0].resultat=="NC"){			    	  
			    		  $location.path('/seguretat/controlar-seguretat');
			    		  return $q.reject(response);
			    	  } else if (response.data[0].resultat=="KO") {
			    		  alert(response.data[0].missatge);
			    	  }
			    	} 
			    	return response;			     
			    },
		
			    request: function(config){
			    	$("#carregant").show();
			    	return config;
			    }

			  };			  
	}])
				
})();