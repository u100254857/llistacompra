(function(){
	'use strict';
	
	var app=angular.module("LlistaCompraApp");

	var CistellaController=function($translate,CistellaService,productes){
		this.cs=CistellaService;
		this.seleccionat=null;
		this.productes=productes;
		this.translate=$translate;
		this.supermercats=[];
		recuperarSupermercats(this.supermercats,this.productes);
	};
	
	function recuperarSupermercats(supermercats,productes){
		if (productes!=null){
			for (var i=0;i<productes.length;i++){
				var superactual=productes[i].supermercat;
				if (supermercats.indexOf(superactual)==-1 && superactual.id!=null){
					supermercats[supermercats.length]=superactual;
				}
			}			
		}
	};

	CistellaController.prototype.comprarProducte=function(producte){
		var prod=producte;
		this.cs.comprarProducte(producte).
		then(function(response){
			if (response.data[0].resultat=="OK"){
				prod.enCistella=false;
			} else {
				alert(response.data[0].missatge);
			}
		});		
	}
	
	CistellaController.prototype.retornarProducte=function(producte){
		var prod=producte;
		this.cs.retornarProducte(producte).
		then(function(response){
			if (response.data[0].resultat=="OK"){
				prod.enCistella=true;
			} else {
				alert(response.data[0].missatge);
			}
		});		
	}	
	
	app.controller("CistellaController",["$translate","CistellaService","productes",function($translate,CistellaService,productes){
		return new CistellaController($translate,CistellaService,productes);
	}]);	
	
})();