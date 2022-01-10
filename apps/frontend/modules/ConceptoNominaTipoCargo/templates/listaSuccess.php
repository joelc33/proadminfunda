<script type="text/javascript">
Ext.ns("ConceptoNominaTipoCargoLista");
ConceptoNominaTipoCargoLista.main = {
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
        ConceptoNominaTipoCargoLista.main.mascara.show();
        this.msg = Ext.get('formularioConceptoNominaTipoCargo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaTipoCargo/editar',
         scripts: true,
         text: "Cargando..",
            params:{
                co_concepto: ConceptoNominaTipoCargoLista.main.co_concepto.getValue()
            }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = ConceptoNominaTipoCargoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concepto_tipo_cargo');
	ConceptoNominaTipoCargoLista.main.mascara.show();
        this.msg = Ext.get('formularioConceptoNominaTipoCargo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaTipoCargo/editar/codigo/'+this.codigo,
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
	this.codigo  = ConceptoNominaTipoCargoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concepto_tipo_cargo');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaTipoCargo/eliminar',
            params:{
                co_concepto_tipo_cargo:ConceptoNominaTipoCargoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concepto_tipo_cargo')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConceptoNominaTipoCargoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConceptoNominaTipoCargoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConceptoNominaTipoCargo');
        ConceptoNominaTipoCargoLista.main.mascara.show();
        ConceptoNominaTipoCargoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaTipoCargo/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de ConceptoNominaTipoCargo',
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
    {header: 'co_concepto_tipo_cargo',hidden:true, menuDisabled:true,dataIndex: 'co_concepto_tipo_cargo'},
    {header: 'Tipo de Cargo', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo_cargo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ConceptoNominaTipoCargoLista.main.editar.enable();ConceptoNominaTipoCargoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConceptoNominaTipoCargoLista");

this.store_lista.baseParams.co_concepto = this.OBJ.co_concepto;
this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaTipoCargo/storelista',
    root:'data',
    fields:[
    {name: 'co_concepto_tipo_cargo'},
    {name: 'co_concepto'},
    {name: 'co_tp_cargo'},
    {name: 'tx_tipo_cargo'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ConceptoNominaTipoCargoLista.main.init, ConceptoNominaTipoCargoLista.main);
</script>
<div id="contenedorConceptoNominaTipoCargoLista"></div>
<div id="formularioConceptoNominaTipoCargo"></div>
<div id="filtroConceptoNominaTipoCargo"></div>
