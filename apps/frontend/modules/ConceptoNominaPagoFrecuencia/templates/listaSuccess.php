<script type="text/javascript">
Ext.ns("ConceptoNominaPagoFrecuenciaLista");
ConceptoNominaPagoFrecuenciaLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

this.co_concepto = new Ext.form.Hidden({
    name:'co_concepto',
    value:this.OBJ.co_concepto
});

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        ConceptoNominaPagoFrecuenciaLista.main.mascara.show();
        this.msg = Ext.get('formularioConceptoNominaPagoFrecuencia');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoFrecuencia/editar',
         scripts: true,
         text: "Cargando..",
            params:{
                co_concepto: ConceptoNominaPagoFrecuenciaLista.main.co_concepto.getValue()
            }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = ConceptoNominaPagoFrecuenciaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concep_frecuecia');
	ConceptoNominaPagoFrecuenciaLista.main.mascara.show();
        this.msg = Ext.get('formularioConceptoNominaPagoFrecuencia');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoFrecuencia/editar/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Eliminar un registro
this.eliminar= new Ext.Button({
    text:'Eliminar',
    iconCls: 'icon-eliminar',
    handler:function(){
	this.codigo  = ConceptoNominaPagoFrecuenciaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concep_frecuecia');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoFrecuencia/eliminar',
            params:{
                co_concep_frecuecia:ConceptoNominaPagoFrecuenciaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concep_frecuecia')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConceptoNominaPagoFrecuenciaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConceptoNominaPagoFrecuenciaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConceptoNominaPagoFrecuencia');
        ConceptoNominaPagoFrecuenciaLista.main.mascara.show();
        ConceptoNominaPagoFrecuenciaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoFrecuencia/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de ConceptoNominaPagoFrecuencia',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:455,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_concep_frecuecia',hidden:true, menuDisabled:true,dataIndex: 'co_concep_frecuecia'},
    {header: 'Frecuencia de Pago', width:600,  menuDisabled:true, sortable: true,  dataIndex: 'co_nom_frecuencia_pago'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ConceptoNominaPagoFrecuenciaLista.main.editar.enable();ConceptoNominaPagoFrecuenciaLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConceptoNominaPagoFrecuenciaLista");

this.store_lista.baseParams.co_concepto = this.OBJ.co_concepto;
this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoFrecuencia/storelista',
    root:'data',
    fields:[
    {name: 'co_concep_frecuecia'},
    {name: 'co_concepto'},
    {name: 'co_nom_frecuencia_pago'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ConceptoNominaPagoFrecuenciaLista.main.init, ConceptoNominaPagoFrecuenciaLista.main);
</script>
<div id="contenedorConceptoNominaPagoFrecuenciaLista"></div>
<div id="formularioConceptoNominaPagoFrecuencia"></div>
<div id="filtroConceptoNominaPagoFrecuencia"></div>
