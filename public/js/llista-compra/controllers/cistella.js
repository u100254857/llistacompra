(function(){
	'use strict';
	
	var app=angular.module("LlistaCompraApp");

	var CistellaController=function($translate,$location,CistellaService,productes){
		this.cs=CistellaService;
		this.seleccionat=null;
		this.productes=productes;
		this.translate=$translate;
		this.location=$location;
		this.supermercats=[];
		this.supermercatsID=[];
		this.ordre={
				"camp":"supermercat.nom",
				"columna":"cataleg_columna_supermercat",
				"sentit":"ascending"
		};
		this.filtre=true;
		recuperarSupermercats(this.supermercats,this.supermercatsID,this.productes);
	};
	
	function recuperarSupermercats(supermercats,supermercatsID,productes){
		if (productes!=null){
			for (var i=0;i<productes.length;i++){
				var superactual=productes[i].supermercat;
				if (supermercatsID.indexOf(superactual.id)==-1 && superactual.id!=null){
					supermercats[supermercats.length]=superactual;
					supermercatsID[supermercatsID.length]=superactual.id;
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
	
	CistellaController.prototype.afegirProducte=function(){
		this.location.path("/cataleg-productes/consultar-llista-productes");
	}
	
	CistellaController.prototype.ordenar=function(columna){		
		var id="#"+columna;
		if (columna==this.ordre.columna){
			if (this.ordre.sentit=="ascending"){
				$(id).attr("data-sorted-direction","descending");
				this.ordre.camp="-"+$(id).attr("ordre");
				this.ordre.sentit="descending";
			} else {
				$(id).attr("data-sorted-direction","ascending");
				this.ordre.camp=$(id).attr("ordre");
				this.ordre.sentit="ascending";
			}
		} else {
			var idant="#"+this.ordre.columna;
			$(idant).removeAttr("data-sorted");
			$(idant).removeAttr("data-sorted_direction");
			$(id).attr("data-sorted","true");
			$(id).attr("data-sorted-direction","ascending");
			this.ordre.camp=$(id).attr("ordre");
			this.ordre.columna=columna;
			this.ordre.sentit="ascending";
		}
	}
	
	CistellaController.prototype.filtrar=function(){
		this.filtre=!this.filtre;		
	}
	
	
	app.controller("CistellaController",["$translate","$location","CistellaService","productes",function($translate,$location,CistellaService,productes){
		return new CistellaController($translate,$location,CistellaService,productes);
	}]);	
	
})();