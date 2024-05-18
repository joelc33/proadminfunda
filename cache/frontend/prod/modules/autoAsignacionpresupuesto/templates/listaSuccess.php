<script type="text/javascript">
Ext.ns("AsignacionpresupuestoLista");
AsignacionpresupuestoLista.main = {
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
        AsignacionpresupuestoLista.main.mascara.show();
        this.msg = Ext.get('formularioAsignacionpresupuesto');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/editar',
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
	this.codigo  = AsignacionpresupuestoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	AsignacionpresupuestoLista.main.mascara.show();
        this.msg = Ext.get('formularioAsignacionpresupuesto');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/editar/codigo/'+this.codigo,
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
	this.codigo  = AsignacionpresupuestoLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/eliminar',
            params:{
                id:AsignacionpresupuestoLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    AsignacionpresupuestoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                AsignacionpresupuestoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroAsignacionpresupuesto');
        AsignacionpresupuestoLista.main.mascara.show();
        AsignacionpresupuestoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Asignacionpresupuesto',
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
    {header: 'Id tb080 sector', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb080_sector'},
    {header: 'Id tb081 sub sector', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb081_sub_sector'},
    {header: 'Id tb082 ejecutor', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb082_ejecutor'},
    {header: 'Nu proyecto ac', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_proyecto_ac'},
    {header: 'De proyecto ac', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'de_proyecto_ac'},
    {header: 'Id tb013 anio fiscal', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb013_anio_fiscal'},
    {header: 'In activo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_activo'},
    {header: 'Created at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'created_at'},
    {header: 'Updated at', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'updated_at'},
    {header: 'Id tb086 tipo prac', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb086_tipo_prac'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){AsignacionpresupuestoLista.main.editar.enable();AsignacionpresupuestoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorAsignacionpresupuestoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'id_tb080_sector'},
    {name: 'id_tb081_sub_sector'},
    {name: 'id_tb082_ejecutor'},
    {name: 'nu_proyecto_ac'},
    {name: 'de_proyecto_ac'},
    {name: 'id_tb013_anio_fiscal'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'id_tb086_tipo_prac'},
           ]
    });
    return this.store;
}
};
Ext.onReady(AsignacionpresupuestoLista.main.init, AsignacionpresupuestoLista.main);
</script>
<div id="contenedorAsignacionpresupuestoLista"></div>
<div id="formularioAsignacionpresupuesto"></div>
<div id="filtroAsignacionpresupuesto"></div>
