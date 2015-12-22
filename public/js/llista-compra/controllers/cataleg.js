(function(){
	
	'use strict';
	// Cataleg productes
	var app=angular.module("LlistaCompraApp");
	
	var CatalegProducteController=function($location,$translate,CatalegProductesService,productes){
		this.cps=CatalegProductesService;
		this.seleccionat=null;
		this.ordre={
				"camp":"nom",
				"columna":"cataleg_columna_nom",
				"sentit":"ascending"
		};
		this.filtre=null;		
		this.productes=productes;
		this.location=$location;
		this.translate=$translate;
		this.posicioProducte=function(id){
			var i=0;
			while (i<this.productes.length && this.productes[i].id!=id){
				i++;
			} 
			return i;
		}
	};
		
	CatalegProducteController.prototype.seleccionar=function(producte){		
		this.seleccionat=producte;
	}
	
	CatalegProducteController.prototype.ordenar=function(columna){		
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
	
	CatalegProducteController.prototype.filtrar=function(){
		if (this.filtre==null){
			this.filtre=true;
		} else if (this.filtre){
			this.filtre=false
		} else {
			this.filtre=null;
		}
	}

	CatalegProducteController.prototype.editarProducte=function(crear){					
		if (crear){
			this.location.path('/cataleg-productes/editar-producte');
		} else if (this.seleccionat!=null) {
			this.location.path('/cataleg-productes/editar-producte/' + this.seleccionat.id);
		}
		this.seleccionat=null;
	}		
		
	CatalegProducteController.prototype.consultarProducte=function(){
		if (this.seleccionat!=null){
			this.location.path('/cataleg-productes/consultar-producte/' + this.seleccionat.id);			
		}
		this.seleccionat=null;
	}
		

	CatalegProducteController.prototype.esborrarProducte=function(pregunta){
		if (this.seleccionat!=null && pregunta){				
			$("#missatgeEliminar").modal("show");
		} else {
			$("#missatgeEliminar").modal("hide");			
			var me=this;			
			this.cps.esborrarProducte(this.seleccionat).
			then(function(response){
				if (response.data[0].resultat=="KO"){
					alert(response.data[0].missatge);
				} else {					
					var i=me.posicioProducte(me.seleccionat.id);
					me.productes.splice(i,1);
				}
				me.seleccionat=null;
			});			
		}			
	}
	
	CatalegProducteController.prototype.afegirCistella=function(producte){
		var me=this;
		this.cps.afegirCistella(producte).
		then(function(response){
			if (response.data[0].resultat=="OK"){
				me.seleccionat.enCistella=true;
			} else {
				alert(response.data[0].missatge);
			}
		});
		
	}
	
	CatalegProducteController.prototype.traureCistella=function(producte){
		var me=this;
		this.cps.traureCistella(producte).
		then(function(response){
			if (response.data[0].resultat=="OK"){
				me.seleccionat.enCistella=false;
			} else {
				alert(response.data[0].missatge);
			}
		});
		
	}
	
	
	CatalegProducteController.prototype.enCistella=function(id){
		var i=this.posicioProducte(id);
		return this.productes[i].enCistella; 
	}
		
	CatalegProducteController.prototype.retornaSeleccionat=function(){
		return this.seleccionat;
	}
		
	var ProducteController=function(CatalegProductesService,producte,supermercats){
		this.cps=CatalegProductesService;
		this.producte=producte;
		this.supermercats=supermercats;	
		this.errors={"nom":false,"nombre":false};
	};
	
	function validarGuardar(response,me){
		if (response.data[0].resultat=="KO"){
			alert(response.data[0].missatge);
			return false;
		} else if (response.data[0].resultat=="EP"){
			var i;
			for(i=0;i<response.data[0].missatge.length;i++){
				if (response.data[0].missatge[i]=="MXN"){
						me.errors.nom=true
				}
				if (response.data[0].missatge[i]=="MSN"){
						me.errors.nombre=true
				}

			}	
			return false;
		} 
		return true;
	}
	
	ProducteController.prototype.guardarProducte=function(){
		var me=this;
		this.errors.nom=false;
		this.errors.nombre=false;
		this.cps.guardarProducte(this.producte).
		then(function(response){
			if (validarGuardar(response,me)){
				history.go(-1);
			}			
		});
	}
		
	ProducteController.prototype.guardarProducteYContinuar=function(editarProducte){
		var me=this;
		this.errors.nom=false;
		this.errors.nombre=false;
		var form=editarProducte;		
		var supermercat=this.producte.supermercat;		
		this.cps.guardarProducte(this.producte).
		then(function(response){
			if (validarGuardar(response,me)){
				me.producte.id=null
				me.producte.nom="";
				me.producte.nombre="";
				me.producte.darreraCompra=null;
				me.producte.enCistella=false;
				me.producte.frequencia=null;
				form.$setPristine();
			}
		});
	}

	app.controller("CatalegProductesController",["$location","$translate","CatalegProductesService","productes",function($location,$translate,CatalegProductesService,productes){
		return new CatalegProducteController($location,$translate,CatalegProductesService,productes);
	}]);
	
	app.controller("ProducteController",["CatalegProductesService","producte","supermercats",function(CatalegProductesService,producte,supermercats){
		return new ProducteController(CatalegProductesService,producte,supermercats);
	}]);

	
})();