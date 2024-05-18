<script type="text/javascript">
Ext.ns("TrasladosLista");
TrasladosLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});
this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:<?php echo $co_solicitud; ?>
});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        TrasladosLista.main.mascara.show();
        this.msg = Ext.get('formularioTraslados');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Traslados/editar',
         params:{
                co_solicitud:TrasladosLista.main.co_solicitud.getValue()
         },
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
	this.codigo  = TrasladosLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nom_trabajador');
	TrasladosLista.main.mascara.show();
        this.msg = Ext.get('formularioTraslados');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Traslados/editar/codigo/'+this.codigo,
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
	this.codigo  = TrasladosLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nom_trabajador');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Traslados/eliminar',
            params:{
                co_traslados:TrasladosLista.main.gridPanel_.getSelectionModel().getSelected().get('co_traslados')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    TrasladosLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                TrasladosLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroTraslados');
        TrasladosLista.main.mascara.show();
        TrasladosLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Traslados/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Traslados',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.eliminar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_traslados',hidden:true, menuDisabled:true,dataIndex: 'co_traslados'},
    {header: 'Cedula', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cedula'},
    {header: 'Trabajador', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nombre'},
    {header: 'Cargo Estructura Anterior', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_estructura_anterior'},
    {header: 'Nomina Anterior', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_nomina_anterior'},
    {header: 'Sueldo Anterior', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_salario_anterior'},
    {header: 'Cargo Estructura Nuevo', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cargo_estructura'},
    {header: 'Nomina Nueva', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_nomina'},
    {header: 'Sueldo Nuevo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_salario_base'},
    {header: 'Tipo de Cargo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo_cargo'},
    {header: 'Horas', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_horas'},
    {header: 'Fecha Traslado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_traslado'},
//    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
//    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){TrasladosLista.main.editar.enable();TrasladosLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        TrasladosLista.main.winformPanel_.close();
    }
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Traslado',
    modal:true,
    constrain:true,
    width:1650,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ],
    buttons:[
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
this.store_lista.baseParams.co_solicitud = <?php echo $co_solicitud; ?>;
this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Traslados/storelista',
    root:'data',
    fields:[
    {name: 'co_traslados'},
    {name: 'nu_cedula'},
    {name: 'nombre'},
    {name: 'tx_estructura_anterior'},
    {name: 'mo_salario_anterior'},
    {name: 'tx_nomina_anterior'},
    {name: 'tx_nomina'},
    {name: 'tx_cargo_estructura'},
    {name: 'tx_tipo_cargo'},
    {name: 'mo_salario_base'},
    {name: 'nu_horas'},
    {name: 'fe_traslado'},
           ]
    });
    return this.store;
}
};
Ext.onReady(TrasladosLista.main.init, TrasladosLista.main);
</script>
<div id="contenedorTrasladosLista"></div>
<div id="formularioTraslados"></div>
<div id="filtroTraslados"></div>
