(function(){
	'use strict';
	
	var app=angular.module("LlistaCompraApp");

	var SeguretatController=function ($location,$translate,SeguretatService){
		this.ss=SeguretatService;
		this.telefon="";
		this.location=$location;
		this.translate=$translate;
		this.usuariNoValid=false;		
	}
		
	SeguretatController.prototype.validarUsuari=function(controlarSeguretat){
		var me=this;
		var form=controlarSeguretat;
		this.usuariNoValid=false;
		this.ss.validarUsuari(this.telefon).
		then(function(response){
			if (response.data[0].resultat=="KO"){
				alert(response.data[0].missatge);
			} else if (response.data[0].resultat=="NV"){
				$(".alert").show();
				me.telefon="";
				me.usuariNoValid=true;
			} else {
				if (response.data[0].idioma=="E"){
						me.translate.use("es");
				} else {
					me.translate.use("ca");
				}								
				me.location.path("/main");
			}
			
		});		
	}
	
	SeguretatController.prototype.sortir=function(){
		this.ss.sortir().
		then(function(response){
			this.location.path("/main");
		})
	}
		
	app.controller("SeguretatController",["$location","$translate","SeguretatService",function($location,$translate,SeguretatService){
		return new SeguretatController($location,$translate,SeguretatService);
	}]);
	
})();