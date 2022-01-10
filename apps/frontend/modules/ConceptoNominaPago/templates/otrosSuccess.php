<script type="text/javascript">
Ext.ns("ConceptoNominaPagoEditar");
ConceptoNominaPagoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.panel = new Ext.TabPanel({
    activeTab:0,
    border:false,
    enableTabScroll:true,
    deferredRender: true,
	autoWidth:true,
	autoHeight:true,
    items:[
		{
			title: 'Tipos de Nomina',
			disabled:false,
			autoLoad:{
				url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoTipo',
				scripts: true,
				params:{
                	codigo: this.OBJ.co_concepto
            	}
			}
		},
		{
			title: 'Frecuencias de Pago',
			disabled:false,
			autoLoad:{
				url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoFrecuencia',
				scripts: true,
				params:{
                	codigo: this.OBJ.co_concepto
            	}
			}
		},
		{
			title: 'Situaciones de Empleado',
			disabled:false,
			autoLoad:{
				url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoSituacion',
				scripts: true,
				params:{
                	codigo: this.OBJ.co_concepto
            	}
			}
		},
		{
			title: 'Tipos de Cargo',
			disabled:false,
			autoLoad:{
				url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaTipoCargo',
				scripts: true,
				params:{
                	codigo: this.OBJ.co_concepto
            	}
			}
		},
		{
			title: 'Acumula por',
			disabled:false,
			autoLoad:{
				url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoAcumula',
				scripts: true,
				params:{
                	codigo: this.OBJ.co_concepto
            	}
			}
		}
	]
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConceptoNominaPagoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:false,
    width:650,
	labelWidth: 150,
	autoHeight:true,  
    bodyStyle:'padding:0px;',
    items:[
					this.panel
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Concepto Nomina',
    modal:true,
    constrain:true,
width:664,
    frame:true,
    closabled:true,
    //autoHeight:true,
	height:550,
    items:[
        this.formPanel_
    ],
    buttons:[
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
ConceptoNominaPagoLista.main.mascara.hide();
}
};
Ext.onReady(ConceptoNominaPagoEditar.main.init, ConceptoNominaPagoEditar.main);
</script>
