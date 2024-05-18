<script type="text/javascript">
Ext.ns("AprobarPartidaLista");
AprobarPartidaLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
}, 
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.mo_disponible = 0;
this.nu_monto = 0;
//objeto store
this.store_lista = this.getLista();
this.co_creacion_partida;

this.aprobar = new Ext.Button({
    text: 'Aprobar',
    iconCls: 'icon-fin',
    handler: function () {           
        if(parseFloat(AprobarPartidaLista.main.mo_disponible) < parseFloat(AprobarPartidaLista.main.nu_monto)){
         Ext.Msg.alert("Notificación","No es posible aprobar la creación de la partida, debido a que el saldo disponible es insuficiente");
        }else{        
            Ext.MessageBox.confirm('Confirmación', '¿Esta seguro que desea aprobar la creacion de la partida?', function(boton){
            if(boton=="yes"){
                 AprobarPartidaLista.main.afectar_partida('2');
            }});
        }
    }
});

this.rechazar = new Ext.Button({
        text:'Rechazar',
        iconCls: 'icon-delete',
        handler: function(boton){
            Ext.MessageBox.confirm('Confirmación', '¿Esta seguro que desea rechazar la creacion de la partida?', function(boton){
            if(boton=="yes"){
                 AprobarPartidaLista.main.afectar_partida('3');
            }});
        }
});

this.aprobar.disable();
this.rechazar.disable();

function renderMonto(val, attr, record) { 
     if(record.data.co_estatus_ruta == 2){
        return '<p style="color:gray"><b>'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</b></p>';     
     }else{
        return paqueteComunJS.funcion.getNumeroFormateado(val);     
     }
} 

function renderMontoDisponible(val, attr, record) { 
     if(record.data.co_estatus_ruta == 2){
        return '<p style="color:gray"><b>'+paqueteComunJS.funcion.getNumeroFormateado(record.data.mo_disponible)+'</b></p>';     
     }else if(parseFloat(record.data.mo_disponible) > parseFloat(record.data.nu_monto)){
        return '<p style="color:green"><b>'+paqueteComunJS.funcion.getNumeroFormateado(record.data.mo_disponible)+'</b></p>';     
     }else{
        return '<p style="color:red"><b>'+paqueteComunJS.funcion.getNumeroFormateado(record.data.mo_disponible)+'</b></p>';  
     }
} 

function renderEstado(val, attr, record) { 
     if(record.data.co_estatus_ruta == 2){
        return '<p style="color:green"><b>'+record.data.tx_estatus+'</b></p>';     
     }else if(record.data.co_estatus_ruta == 3) {
        return '<p style="color:red"><b>'+record.data.tx_estatus+'</b></p>';  
     }else {
         return record.data.tx_estatus
     }
} 

function renderEstado(val, attr, record) { 
     if(record.data.co_estatus_ruta == 2){
        return '<p style="color:green"><b>'+record.data.tx_estatus+'</b></p>';     
     }else if(record.data.co_estatus_ruta == 3) {
        return '<p style="color:red"><b>'+record.data.tx_estatus+'</b></p>';  
     }else {
         return record.data.tx_estatus
     }
} 

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Partidas',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
    width:1070,
    height:550,
    tbar:[
        this.aprobar,'-',this.rechazar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'co_creacion_partida',hidden:true, menuDisabled:true,dataIndex: 'co_creacion_partida'},
        {header: 'Estatus', width:80, menuDisabled:true,dataIndex: 'tx_estatus',renderer:renderEstado},
        {header: 'Partida Afectada', width:350,  menuDisabled:true, sortable: true,  dataIndex: 'de_partida',renderer:textoLargo},
//        {header: 'Monto Disponible', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'mo_disponible',renderer:renderMonto},
        {header: 'Nro. Partida', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_partida'},
        {header: 'Descripción', width:450,  menuDisabled:true, sortable: true,  dataIndex: 'tx_descripcion',renderer:textoLargo},
   ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){            
            if(AprobarPartidaLista.main.store_lista.getAt(rowIndex).get('co_estatus_ruta')==1){
                AprobarPartidaLista.main.aprobar.enable();
                AprobarPartidaLista.main.rechazar.enable();
                AprobarPartidaLista.main.co_creacion_partida  = AprobarPartidaLista.main.store_lista.getAt(rowIndex).get('co_creacion_partida');
                AprobarPartidaLista.main.mo_disponible = AprobarPartidaLista.main.store_lista.getAt(rowIndex).get('mo_disponible');
                AprobarPartidaLista.main.nu_monto = AprobarPartidaLista.main.store_lista.getAt(rowIndex).get('nu_monto');
            }else{
                AprobarPartidaLista.main.aprobar.disable();
                AprobarPartidaLista.main.rechazar.disable();                
            }
            
           
    }},
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
        AprobarPartidaLista.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1100,
    autoHeight:true,  
    autoScroll:true,
    //bodyStyle:'padding:10px;',
    items:[this.gridPanel_]
});

this.winformPanel_ = new Ext.Window({
    title:'Crear Partida',
    modal:true,
    constrain:true,
    width:1100,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formPanel_
    ],
    buttons:[
      //  this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();

this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
this.store_lista.load();
},
afectar_partida: function(status){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartidaIngreso/cambiarEstado',
            params:{
                co_creacion_partida: AprobarPartidaLista.main.co_creacion_partida,
                co_estatus: status
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
                    AprobarPartidaLista.main.aprobar.disable();
                    AprobarPartidaLista.main.rechazar.disable();
		    AprobarPartidaLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ContabilidadEditar.main.mascara.hide();
       }});
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartidaIngreso/storelista',
    root:'data',
    fields:[
                {name: 'co_creacion_partida'},
                {name: 'co_partida'},
                {name: 'de_partida',
                    convert:function(v,r){
                        return r.nu_partida+' - '+r.tx_descripcion;
                    }
                },
                {name: 'tx_descripcion'},
                {name: 'tx_partida'},
                {name: 'co_estatus_ruta'},
                {name: 'tx_estatus'}
           ]
    });
    return this.store;
}
};
Ext.onReady(AprobarPartidaLista.main.init, AprobarPartidaLista.main);
</script>
<div id="contenedorAprobarPartidaLista"></div>
<div id="formularioCrearPartida"></div>
<div id="filtroCrearPartida"></div>
