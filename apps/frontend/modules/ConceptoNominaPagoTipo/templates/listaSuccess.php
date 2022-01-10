<script type="text/javascript">
Ext.ns("ConceptoNominaPagoTipoLista");
ConceptoNominaPagoTipoLista.main = {
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
        ConceptoNominaPagoTipoLista.main.mascara.show();
        this.msg = Ext.get('formularioConceptoNominaPagoTipo');
        this.msg.load({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoTipo/editar',
            scripts: true,
            text: "Cargando..",
            params:{
                co_concepto: ConceptoNominaPagoTipoLista.main.co_concepto.getValue()
            }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = ConceptoNominaPagoTipoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concepto_tipo_nomina');
	ConceptoNominaPagoTipoLista.main.mascara.show();
        this.msg = Ext.get('formularioConceptoNominaPagoTipo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoTipo/editar/codigo/'+this.codigo,
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
	this.codigo  = ConceptoNominaPagoTipoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concepto_tipo_nomina');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoTipo/eliminar',
            params:{
                co_concepto_tipo_nomina:ConceptoNominaPagoTipoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concepto_tipo_nomina')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConceptoNominaPagoTipoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConceptoNominaPagoTipoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConceptoNominaPagoTipo');
        ConceptoNominaPagoTipoLista.main.mascara.show();
        ConceptoNominaPagoTipoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoTipo/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de ConceptoNominaPagoTipo',
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
    {header: 'co_concepto_tipo_nomina',hidden:true, menuDisabled:true,dataIndex: 'co_concepto_tipo_nomina'},
    {header: 'Tipo Nomina', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'nomina'},
    {header: 'Sub-Grupo', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'cod_grupo_nomina'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ConceptoNominaPagoTipoLista.main.editar.enable();ConceptoNominaPagoTipoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConceptoNominaPagoTipoLista");

this.store_lista.baseParams.co_concepto = this.OBJ.co_concepto;
this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPagoTipo/storelista',
    root:'data',
    fields:[
    {name: 'co_concepto_tipo_nomina'},
    {name: 'co_concepto'},
    {name: 'co_tp_nomina'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'cod_grupo_nomina'},
            {
				name: 'nomina',
				convert: function(v, r) {
						return r.nu_nomina + ' - ' + r.tx_tp_nomina;
				}
		    }
           ]
    });
    return this.store;
}
};
Ext.onReady(ConceptoNominaPagoTipoLista.main.init, ConceptoNominaPagoTipoLista.main);
</script>
<div id="contenedorConceptoNominaPagoTipoLista"></div>
<div id="formularioConceptoNominaPagoTipo"></div>
<div id="filtroConceptoNominaPagoTipo"></div>
