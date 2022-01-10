<script type="text/javascript">
Ext.ns("NominaMovimientoLista");
NominaMovimientoLista.main = {
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
        NominaMovimientoLista.main.mascara.show();
        this.msg = Ext.get('formularioNominaMovimiento');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/editar',
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
	this.codigo  = NominaMovimientoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	NominaMovimientoLista.main.mascara.show();
        this.msg = Ext.get('formularioNominaMovimiento');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/editar/codigo/'+this.codigo,
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
	this.codigo  = NominaMovimientoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/eliminar',
            params:{
                id:NominaMovimientoLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    NominaMovimientoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                NominaMovimientoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroNominaMovimiento');
        NominaMovimientoLista.main.mascara.show();
        NominaMovimientoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de NominaMovimiento',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Id tbrh013 nomina', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tbrh013_nomina'},
    {header: 'Id tbrh014 concepto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tbrh014_concepto'},
    {header: 'Id tbrh020 tp concepto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tbrh020_tp_concepto'},
    {header: 'Id tbrh002 ficha', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tbrh002_ficha'},
    {header: 'De concepto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_concepto'},
    {header: 'Nu valor', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_valor'},
    {header: 'Nu monto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_monto'},
    {header: 'Id tbrh050 tp unidad', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tbrh050_tp_unidad'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    {header: 'In imprime detalle', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_imprime_detalle'},
    {header: 'In descripcion alternativa', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_descripcion_alternativa'},
    {header: 'In valor referencia', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_valor_referencia'},
    {header: 'In hoja tiempo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_hoja_tiempo'},
    {header: 'In prorratea', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_prorratea'},
    {header: 'In modifica descripcion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_modifica_descripcion'},
    {header: 'In monto calculo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_monto_calculo'},
    {header: 'In contractual', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_contractual'},
    {header: 'In bonificable', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_bonificable'},
    {header: 'In monto cero', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_monto_cero'},
    {header: 'Id tbrh030 moneda', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tbrh030_moneda'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){NominaMovimientoLista.main.editar.enable();NominaMovimientoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorNominaMovimientoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'id_tbrh013_nomina'},
    {name: 'id_tbrh014_concepto'},
    {name: 'id_tbrh020_tp_concepto'},
    {name: 'id_tbrh002_ficha'},
    {name: 'de_concepto'},
    {name: 'nu_valor'},
    {name: 'nu_monto'},
    {name: 'id_tbrh050_tp_unidad'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
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
    {name: 'id_tbrh030_moneda'},
           ]
    });
    return this.store;
}
};
Ext.onReady(NominaMovimientoLista.main.init, NominaMovimientoLista.main);
</script>
<div id="contenedorNominaMovimientoLista"></div>
<div id="formularioNominaMovimiento"></div>
<div id="filtroNominaMovimiento"></div>
