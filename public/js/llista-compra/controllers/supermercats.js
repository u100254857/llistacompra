(function(){
	'use strict';
	
	var app=angular.module("LlistaCompraApp");

	var SupersController=function ($location,SupermercatsService,supers){
		this.ss=SupermercatsService;
		this.seleccionat=null;					
		this.supers=supers;
		this.location=$location;
		this.posicioSuper=function(id){
			var i=0;
			while (i<this.supers.length && this.supers[i].id!=id){
				i++;
			} 
			return i;
		}
	}

	SupersController.prototype.seleccionar=function(supermercat){
		this.seleccionat=supermercat;
	}
	
	SupersController.prototype.editarSupermercat=function(crear){					
		if (crear){
			this.location.path("/supers/editar-supermercat");
		} else if (this.seleccionat!=null) {
			this.location.path("/supers/editar-supermercat/" + this.seleccionat.id);
		}
		this.seleccionat=null;
	}		
			
	SupersController.prototype.consultarSupermercat=function(){
		if (this.seleccionat!=null){
			this.location.path("/supers/consultar-supermercat/" + this.seleccionat.id);				
		}
		this.seleccionat=null;
	}		
	
	SupersController.prototype.esborrarSupermercat=function(pregunta){
		if (this.seleccionat!=null && pregunta){				
			$("#missatgeEliminar").modal("show");
		} else {
			$("#missatgeEliminar").modal("hide");
			var me=this;			
			this.ss.esborrarSupermercat(this.seleccionat).
			then(function(response){
				if (response.data[0].resultat=="KO"){
					alert(response.data[0].missatge);
				} else {					
					var i=me.posicioSuper(me.seleccionat.id);
					me.supers.splice(i,1);
				}
				me.seleccionat=null;
			});
		}			
	}
			
	SupersController.prototype.retornaSeleccionat=function(){
		return this.seleccionat;
	}

	var SupermercatController=function($translate,SupermercatsService,supermercat){
		this.ss=SupermercatsService;
		this.supermercat=supermercat;
		this.translate=$translate;
	};
	
	SupermercatController.prototype.guardarSupermercat=function(){
		this.ss.guardarSupermercat(this.supermercat).
		then(function(response){
			if (response.data[0].resultat=="KO"){
				alert(response.data[0].missatge);
			}
			history.go(-1);
		});		
	}
		
	app.controller("SupersController",["$location","SupermercatsService","supers",function($location,SupermercatsService,supers){
		return new SupersController($location,SupermercatsService,supers);
	}]);	
	
	app.controller("SupermercatController",["$translate","SupermercatsService","supermercat",function($translate,SupermercatsService,supermercat){
		return new SupermercatController($translate,SupermercatsService,supermercat);
	}]);
	
})();