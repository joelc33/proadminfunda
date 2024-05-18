<script type="text/javascript">
Ext.ns("ProgramaLista");
ProgramaLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        ProgramaLista.main.mascara.show();
        this.msg = Ext.get('formularioPrograma');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Programa/editar',
         scripts: true,
         text: "Cargando..",
         params:{
             co_sector:ProgramaLista.main.OBJ.co_sector
         }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = ProgramaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_programa');
	ProgramaLista.main.mascara.show();
        this.msg = Ext.get('formularioPrograma');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Programa/editar/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.actividad= new Ext.Button({
    text:'Actividad',
    iconCls: 'icon-organizacion',
    handler:function(){
	ProgramaticaLista.main.mascara.show();
        this.msg = Ext.get('formularioProgramatica');
        this.msg.load({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Actividad/lista',
            scripts: true,
            text: "Cargando..",
            params:{
                co_programa:ProgramaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_programa')
            }
        });
    }
});

//Eliminar un registro
this.eliminar= new Ext.Button({
    text:'Eliminar',
    iconCls: 'icon-eliminar',
    handler:function(){
	this.codigo  = ProgramaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_programa');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Programa/eliminar',
            params:{
                co_programa:ProgramaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_programa')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ProgramaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ProgramaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPrograma');
        ProgramaLista.main.mascara.show();
        ProgramaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Programa/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.actividad.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Programa',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:350,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.actividad
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_programa',hidden:true, menuDisabled:true,dataIndex: 'co_programa'},
   // {header: 'Co sector', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_sector'},
    {header: 'Código', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_programa'},
    {header: 'Descripción', width:500,  menuDisabled:true, sortable: true,  dataIndex: 'tx_denominacion'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        ProgramaLista.main.editar.enable();
        ProgramaLista.main.actividad.enable();
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 12,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.salir = new Ext.Button({
    text:'Cerrar',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ProgramaLista.main.winformPanel_.close();
    }
});


this.winformPanel_ = new Ext.Window({
    title:'Programa',
    modal:true,
    constrain:true,
    width:800,
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
ProgramaLista.main.store_lista.baseParams.co_sector=ProgramaLista.main.OBJ.co_sector;
this.store_lista.load();

ProgramaticaLista.main.mascara.hide();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Programa/storelista',
    root:'data',
    fields:[
    {name: 'co_programa'},
    {name: 'co_sector'},
    {name: 'nu_programa'},
    {name: 'tx_denominacion'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ProgramaLista.main.init, ProgramaLista.main);
</script>
<div id="contenedorProgramaLista"></div>
<div id="formularioPrograma"></div>
<div id="filtroPrograma"></div>
