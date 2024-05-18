<script type="text/javascript">
Ext.ns("ConceptoNominaPagoLista");
function change(val){
	if(val==true){
	    return '<span style="color:green;">Activo</span>';
	}else if(val==false){
	    return '<span style="color:red;">Inactivo</span>';
	}
return val;
};
ConceptoNominaPagoLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        ConceptoNominaPagoLista.main.mascara.show();
        this.msg = Ext.get('formularioConceptoNominaPago');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/editar',
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = ConceptoNominaPagoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concepto');
	ConceptoNominaPagoLista.main.mascara.show();
        this.msg = Ext.get('formularioConceptoNominaPago');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/editar/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.opciones= new Ext.Button({
    text:'Opciones de Concepto',
    iconCls: 'icon-reporteest',
    handler:function(){
	this.codigo  = ConceptoNominaPagoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concepto');
	ConceptoNominaPagoLista.main.mascara.show();
        this.msg = Ext.get('formularioConceptoNominaPago');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/otros/codigo/'+this.codigo,
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
	this.codigo  = ConceptoNominaPagoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concepto');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/eliminar',
            params:{
                co_concepto:ConceptoNominaPagoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concepto')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConceptoNominaPagoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConceptoNominaPagoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConceptoNominaPago');
        ConceptoNominaPagoLista.main.mascara.show();
        ConceptoNominaPagoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/filtro',
             scripts: true
        });
    }
});

//Editar un registro
this.duplicar= new Ext.Button({
    text:'Duplicar',
    iconCls: 'icon-doble',
    handler:function(){
	this.codigo  = ConceptoNominaPagoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concepto');
	ConceptoNominaPagoLista.main.mascara.show();
        this.msg = Ext.get('formularioConceptoNominaPago');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/duplicar/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

this.editar.disable();
this.opciones.disable();
this.eliminar.disable();
this.duplicar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Concepto Nomina',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.opciones,'-',this.eliminar,'-',this.filtro,'-',this.duplicar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_concepto',hidden:true, menuDisabled:true,dataIndex: 'co_concepto'},
    {header: 'Codigo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_concepto'},
    {header: 'Descripcion', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_concepto'},
    {header: 'Tipo', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tp_concepto'},
    {header: 'Estado', width:100,  menuDisabled:true, sortable: true, renderer: change, dataIndex: 'in_activo'},
    {header: 'Partida Presupuestaria', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cuenta_presupuesto'},
    {header: 'Observacion', width:180,  menuDisabled:true, sortable: true,  dataIndex: 'de_observacion'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{
        cellclick:function(Grid, rowIndex, columnIndex,e ){
            ConceptoNominaPagoLista.main.editar.enable();
            ConceptoNominaPagoLista.main.opciones.enable();
            ConceptoNominaPagoLista.main.eliminar.enable();
            ConceptoNominaPagoLista.main.duplicar.enable();
        }
    },
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConceptoNominaPagoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConceptoNominaPago/storelista',
    root:'data',
    fields:[
    {name: 'co_concepto'},
    {name: 'nu_concepto'},
    {name: 'tx_concepto'},
    {name: 'tx_tp_concepto'},
    {name: 'co_tipo_unidad'},
    {name: 'nu_cuenta_contable'},
    {name: 'nu_cuenta_presupuesto'},
    {name: 'nu_valor'},
    {name: 'in_imprime_detalle'},
    {name: 'in_descripcion_alternativa'},
    {name: 'in_valor_referencia'},
    {name: 'in_hoja_tiempo'},
    {name: 'in_prorratea'},
    {name: 'in_modifica_descripcion'},
    {name: 'in_monto_calculo'},
    {name: 'in_contractual'},
    {name: 'in_bonificable'},
    {name: 'in_monto_cero'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'de_formula'},
    {name: 'co_moneda'},
    {name: 'de_observacion'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ConceptoNominaPagoLista.main.init, ConceptoNominaPagoLista.main);
</script>
<div id="contenedorConceptoNominaPagoLista"></div>
<div id="formularioConceptoNominaPago"></div>
<div id="filtroConceptoNominaPago"></div>
