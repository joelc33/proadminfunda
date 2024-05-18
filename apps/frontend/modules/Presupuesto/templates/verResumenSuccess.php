<script type="text/javascript">
Ext.ns("VerResumen");
VerResumen.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.store_lista   = this.getListaResumen();

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

function renderMontoDisponible(val, attr, record) { 
     if(parseFloat(record.data.mo_disponible) >= parseFloat(record.data.monto)){
        return '<p style="color:green"><b>'+paqueteComunJS.funcion.getNumeroFormateado(record.data.mo_disponible)+'</b></p>';     
     }else{
        return '<p style="color:red"><b>'+paqueteComunJS.funcion.getNumeroFormateado(record.data.mo_disponible)+'</b></p>';  
     }
} 


this.gridPanel = new Ext.grid.GridPanel({
        title:'Resumen de Partidas',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:500,  
        width:1060,
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'Cod. Partida', width:200, menuDisabled:true,dataIndex: 'nu_partida'},
            {header: 'Partida',width:450, menuDisabled:true,dataIndex: 'de_partida',renderer:textoLargo},
            {header: 'Monto Disponible',width:180, menuDisabled:true,dataIndex: 'mo_disponible',renderer:renderMontoDisponible},
            {header: 'Monto',width:180, menuDisabled:true,dataIndex: 'monto',renderer:renderMonto}
        ], 
        bbar: new Ext.ux.StatusBar({
            id: 'basic-statusbar-detalle',
            autoScroll:true,
            defaults:{style:'color:black;font-size:30px;',autoWidth:true},
            items:[
             //this.monto_total
            ]
        }),
        stripeRows: true,
        autoScroll:true,
        stateful: true
});

VerResumen.main.store_lista.baseParams.co_compra=VerResumen.main.OBJ.co_compras;
VerResumen.main.store_lista.load();

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        VerResumen.main.winformPanel_.close();
    }
});


this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1100,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[         
            this.gridPanel
          ]
});

this.winformPanel_ = new Ext.Window({
    title:'Presupuesto',
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
       // this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
},getListaResumen: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storelistaResumen',
    root:'data',
    fields:[
 
                {name :'nu_partida'},
                {name :'de_partida'},
                {name :'mo_disponible'},
                {name :'monto'},
                {name: 'id'}
           ]
    });
    return this.store;      
}
};
Ext.onReady(VerResumen.main.init, VerResumen.main);
</script>
<div id="formularioAgregar"></div>