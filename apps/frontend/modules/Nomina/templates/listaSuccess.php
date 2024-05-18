<script type="text/javascript">
Ext.ns("NominaLista");
NominaLista.main = {
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
        NominaLista.main.mascara.show();
        this.msg = Ext.get('formularioNomina');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/editar',
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
	this.codigo  = NominaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nomina');
	NominaLista.main.mascara.show();
        this.msg = Ext.get('formularioNomina');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/editar/codigo/'+this.codigo,
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
	this.codigo  = NominaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nomina');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/eliminar',
            params:{
                co_nomina:NominaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nomina')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    NominaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                NominaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroNomina');
        NominaLista.main.mascara.show();
        NominaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Nomina',
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
    {header: 'co_nomina',hidden:true, menuDisabled:true,dataIndex: 'co_nomina'},
    {header: 'Co solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
    {header: 'Co tp nomina', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tp_nomina'},
    {header: 'Co nom frecuencia pago', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_nom_frecuencia_pago'},
    {header: 'Nu nomina', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_nomina'},
    {header: 'De nomina', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_nomina'},
    {header: 'De observacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_observacion'},
    {header: 'Fe inicio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_inicio'},
    {header: 'Fe fin', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_fin'},
    {header: 'Fe pago', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_pago'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    {header: 'In procesado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_procesado'},
    {header: 'Id tbrh060 nomina estatus', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tbrh060_nomina_estatus'},
    {header: 'Co grupo nomina', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_grupo_nomina'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){NominaLista.main.editar.enable();NominaLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorNominaLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/storelista',
    root:'data',
    fields:[
    {name: 'co_nomina'},
    {name: 'co_solicitud'},
    {name: 'co_tp_nomina'},
    {name: 'co_nom_frecuencia_pago'},
    {name: 'nu_nomina'},
    {name: 'de_nomina'},
    {name: 'de_observacion'},
    {name: 'fe_inicio'},
    {name: 'fe_fin'},
    {name: 'fe_pago'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'in_procesado'},
    {name: 'id_tbrh060_nomina_estatus'},
    {name: 'co_grupo_nomina'},
           ]
    });
    return this.store;
}
};
Ext.onReady(NominaLista.main.init, NominaLista.main);
</script>
<div id="contenedorNominaLista"></div>
<div id="formularioNomina"></div>
<div id="filtroNomina"></div>
