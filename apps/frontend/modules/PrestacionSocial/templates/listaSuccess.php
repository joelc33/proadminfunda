<script type="text/javascript">
Ext.ns("PrestacionSocialLista");
PrestacionSocialLista.main = {
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
        PrestacionSocialLista.main.mascara.show();
        this.msg = Ext.get('formularioPrestacionSocial');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/editar',
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
	this.codigo  = PrestacionSocialLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	PrestacionSocialLista.main.mascara.show();
        this.msg = Ext.get('formularioPrestacionSocial');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/editar/codigo/'+this.codigo,
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
	this.codigo  = PrestacionSocialLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/eliminar',
            params:{
                id:PrestacionSocialLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    PrestacionSocialLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                PrestacionSocialLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPrestacionSocial');
        PrestacionSocialLista.main.mascara.show();
        PrestacionSocialLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de PrestacionSocial',
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
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    {header: 'Co solicitud', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
    {header: 'Co usuario', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_usuario'},
    {header: 'Co documento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_documento'},
    {header: 'Nu documento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_documento'},
    {header: 'Nb persona', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nb_persona'},
    {header: 'Ap persona', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'ap_persona'},
    {header: 'Co tipo trabajador', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_tipo_trabajador'},
    {header: 'Co ejecutor', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_ejecutor'},
    {header: 'Co situacion trabajador', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_situacion_trabajador'},
    {header: 'Fe ingreso', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_ingreso'},
    {header: 'Fe egreso', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_egreso'},
    {header: 'Fe movimiento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_movimiento'},
    {header: 'De observacion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_observacion'},
    {header: 'Mo pago', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_pago'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){PrestacionSocialLista.main.editar.enable();PrestacionSocialLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorPrestacionSocialLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'co_solicitud'},
    {name: 'co_usuario'},
    {name: 'co_documento'},
    {name: 'nu_documento'},
    {name: 'nb_persona'},
    {name: 'ap_persona'},
    {name: 'co_tipo_trabajador'},
    {name: 'co_ejecutor'},
    {name: 'co_situacion_trabajador'},
    {name: 'fe_ingreso'},
    {name: 'fe_egreso'},
    {name: 'fe_movimiento'},
    {name: 'de_observacion'},
    {name: 'mo_pago'},
           ]
    });
    return this.store;
}
};
Ext.onReady(PrestacionSocialLista.main.init, PrestacionSocialLista.main);
</script>
<div id="contenedorPrestacionSocialLista"></div>
<div id="formularioPrestacionSocial"></div>
<div id="filtroPrestacionSocial"></div>
