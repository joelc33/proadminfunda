<script type="text/javascript">
Ext.ns("PersonaLista");
PersonaLista.main = {
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
        PersonaLista.main.mascara.show();
        this.msg = Ext.get('formularioPersona');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/editar',
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
	this.codigo  = PersonaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_persona');
	PersonaLista.main.mascara.show();
        this.msg = Ext.get('formularioPersona');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/editar/codigo/'+this.codigo,
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
	this.codigo  = PersonaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_persona');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/eliminar',
            params:{
                co_persona:PersonaLista.main.gridPanel_.getSelectionModel().getSelected().get('co_persona')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    PersonaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                PersonaLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroPersona');
        PersonaLista.main.mascara.show();
        PersonaLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Persona',
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
    {header: 'co_persona',hidden:true, menuDisabled:true,dataIndex: 'co_persona'},
    {header: 'Nb persona', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nb_persona'},
    {header: 'Ap persona', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'ap_persona'},
    {header: 'Nu cedula', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cedula'},
    {header: 'Co documento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_documento'},
    {header: 'Co cargo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_cargo'},
    {header: 'Co nivel organizacional', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_nivel_organizacional'},
    {header: 'Co nivel trabajador', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_nivel_trabajador'},
    {header: 'Nu celular', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_celular'},
    {header: 'Nu extension', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_extension'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){PersonaLista.main.editar.enable();PersonaLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorPersonaLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/storelista',
    root:'data',
    fields:[
    {name: 'co_persona'},
    {name: 'nb_persona'},
    {name: 'ap_persona'},
    {name: 'nu_cedula'},
    {name: 'co_documento'},
    {name: 'co_cargo'},
    {name: 'co_nivel_organizacional'},
    {name: 'co_nivel_trabajador'},
    {name: 'nu_celular'},
    {name: 'nu_extension'},
           ]
    });
    return this.store;
}
};
Ext.onReady(PersonaLista.main.init, PersonaLista.main);
</script>
<div id="contenedorPersonaLista"></div>
<div id="formularioPersona"></div>
<div id="filtroPersona"></div>
