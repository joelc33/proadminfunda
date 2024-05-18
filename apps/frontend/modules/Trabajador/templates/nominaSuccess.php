<script type="text/javascript">
Ext.ns("TrabajadorLista");
TrabajadorLista.main = {
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
    text:'Procesar',
    iconCls: 'icon-fin',
    handler:function(){
        TrabajadorLista.main.mascara.show();
        this.msg = Ext.get('formularioTrabajador');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/editar',
         scripts: true,
         text: "Cargando..",
         params:{
             co_solicitud: TrabajadorLista.main.OBJ.co_solicitud
         }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Procesar',
    iconCls: 'icon-fin',
    handler:function(){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/procesarNomina',
            params:{
                co_trabajador:TrabajadorLista.main.gridPanel_.getSelectionModel().getSelected().get('co_trabajador')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
                   TrabajadorLista.main.store_lista.load();                 
                   TrabajadorLista.main.editar.disable();
		   Ext.utiles.msg('Mensaje', 'El Trabajador se Procesó Exitosamente');
                }else{
                   Ext.utiles.msg('Mensaje', 'Error al procesar al Trabajador');
                }               
            }
        });

    }
});

//Eliminar un registro
this.eliminar= new Ext.Button({
    text:'Eliminar',
    iconCls: 'icon-eliminar',
    handler:function(){
	this.codigo  = TrabajadorLista.main.gridPanel_.getSelectionModel().getSelected().get('co_trabajador');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/eliminar',
            params:{
                co_trabajador:TrabajadorLista.main.gridPanel_.getSelectionModel().getSelected().get('co_trabajador')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    TrabajadorLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroTrabajador');
        TrabajadorLista.main.mascara.show();
        TrabajadorLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/filtro',
             scripts: true
        });
    }
});

this.nuevo.disable();
this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Trabajador',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        //this.nuevo,'-',
        this.editar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'co_trabajador',hidden:true, menuDisabled:true,dataIndex: 'co_trabajador'},
        {header: 'Estatus', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_nomina'},
        {header: 'Cédula', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cedula'},
        {header: 'Nombre y Apellido', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'nb_primer_nombre'},
        {header: 'Profesión', width:350,  menuDisabled:true, sortable: true,  dataIndex: 'co_profesion'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        
        var in_nomina = TrabajadorLista.main.gridPanel_.getSelectionModel().getSelected().get('in_nomina');
        
        if(in_nomina == 'Procesado'){                 
            TrabajadorLista.main.editar.disable();
        }else{            
            TrabajadorLista.main.editar.enable();
            TrabajadorLista.main.nuevo.enable();
            TrabajadorLista.main.eliminar.enable();
        }
    }}
    /*bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })*/
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        TrabajadorLista.main.winformPanel_.close();
    }
});

this.winformPanel_ = new Ext.Window({
    title:'Nomina',
    modal:true,
    constrain:true,
    width:1300,
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

this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
this.store_lista.load();

},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storelista',
    root:'data',
    fields:[
                {name: 'co_trabajador'},
                {name: 'nu_cedula'},
                {name: 'nb_primer_nombre'},
                {name: 'nb_segundo_nombre'},
                {name: 'nb_primer_apellido'},
                {name: 'nb_segundo_apellido'},
                {name: 'co_documento'},
                {name: 'co_ente'},
                {name: 'co_edo_civil'},
                {name: 'fe_nacimiento'},
                {name: 'co_tp_motricida'},
                {name: 'nu_hijo'},
                {name: 'tx_direccion_domicilio'},
                {name: 'co_parroquia_domicilio'},
                {name: 'tx_ciudad_domicilio'},
                {name: 'tx_ciudad_nacimiento'},
                {name: 'co_parroquia_nacimiento'},
                {name: 'co_nacionalidad'},
                {name: 'nu_seguro_social'},
                {name: 'nu_rif'},
                {name: 'created_at'},
                {name: 'updated_at'},
                {name: 'co_nivel_educativo'},
                {name: 'nu_anio_aprobado_educativo'},
                {name: 'co_profesion'},
                {name: 'fe_graduacion'},
                {name: 'tx_correo_electronico'},
                {name: 'co_solicitud'},
                {name: 'in_nomina'}
           ]
    });
    return this.store;
}
};
Ext.onReady(TrabajadorLista.main.init, TrabajadorLista.main);
</script>
<div id="contenedorTrabajadorLista"></div>
<div id="formularioTrabajador"></div>
<div id="filtroTrabajador"></div>
