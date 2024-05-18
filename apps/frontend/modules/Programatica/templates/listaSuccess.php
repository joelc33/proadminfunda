<script type="text/javascript">
Ext.ns("ProgramaticaLista");
ProgramaticaLista.main = {
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
        ProgramaticaLista.main.mascara.show();
        this.msg = Ext.get('formularioProgramatica');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Programatica/editar',
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
	this.codigo  = ProgramaticaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_sector');
	ProgramaticaLista.main.mascara.show();
        this.msg = Ext.get('formularioProgramatica');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Programatica/editar/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.programatica= new Ext.Button({
    text:'Programas',
    iconCls: 'icon-organizacion',
    handler:function(){
	ProgramaticaLista.main.mascara.show();
        this.msg = Ext.get('formularioProgramatica');
        this.msg.load({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Programa/lista',
            scripts: true,
            text: "Cargando..",
            params:{
                co_sector:ProgramaticaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_sector')
            }
        });
    }
});

//Eliminar un registro
this.eliminar= new Ext.Button({
    text:'Eliminar',
    iconCls: 'icon-eliminar',
    handler:function(){
	this.codigo  = ProgramaticaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_sector');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Programatica/eliminar',
            params:{
                co_sector:ProgramaticaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_sector')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ProgramaticaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ProgramaticaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroProgramatica');
        ProgramaticaLista.main.mascara.show();
        ProgramaticaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Programatica/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.programatica.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Programatica',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.programatica
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_sector',hidden:true, menuDisabled:true,dataIndex: 'co_sector'},
    {header: 'Código', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_sector'},
    {header: 'Descripción', width:600,  menuDisabled:true, sortable: true,  dataIndex: 'tx_denominacion'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        ProgramaticaLista.main.editar.enable();
        ProgramaticaLista.main.programatica.enable();
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorProgramaticaLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Programatica/storelista',
    root:'data',
    fields:[
    {name: 'co_sector'},
    {name: 'nu_sector'},
    {name: 'tx_denominacion'},
           ]
    });
    return this.store;
}
};
Ext.onReady(ProgramaticaLista.main.init, ProgramaticaLista.main);
</script>
<div id="contenedorProgramaticaLista"></div>
<div id="formularioProgramatica"></div>
<div id="filtroProgramatica"></div>
