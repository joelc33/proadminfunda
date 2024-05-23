<script type="text/javascript">
Ext.ns("Detalle");
Detalle.main = {
init:function(){
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.store_lista = this.getLista();

function renderDatos(val, attr, record) {

                if(val!=''){
                    return '<a href="#" onclick="Detalle.main.getDatos()">Ver Datos</a>'        
                }

            }
function renderDocumento(val, attr, record) {

    if(val!=''){
        return '<a href="#" onclick="Detalle.main.getDocumento()">Ver Documento</a>'        
    }

}

function renderImagen(val, attr, record) {

    if(val!=''){
        return '<a href="#" onclick="Detalle.main.getImagen()">Ver Imagen</a>'        
    }

}

this.gridPanel_ = new Ext.grid.GridPanel({
                title:'Ruta del Proceso',
                iconCls: 'icon-libro',
                store: this.store_lista,
                loadMask:true,
                width:680,
                height:500,
                columns: [
                new Ext.grid.RowNumberer(),
                    {header: 'co_ruta',hidden:true, menuDisabled:true,dataIndex: 'co_ruta'},
                    {header: 'Unidad', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_proceso',renderer:textoLargo},
                    {header: 'Estatus', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_estatus'},
                    {header: 'Datos', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'in_reporte',renderer: renderDatos}
                    //{header: 'Documento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_cargar_documento',renderer: renderDocumento},
                    //{header: 'Imagen', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'in_cargar_imagen',renderer: renderImagen},
                ],
                stripeRows: true,
                autoScroll:true,
                stateful: true,
                bbar: new Ext.PagingToolbar({
                    pageSize: 10,
                    store: this.store_lista,
                    displayInfo: true,
                    displayMsg: '<span style="color:white">Registros: {0} - {1} de {2}</span>',
                    emptyMsg: "<span style=\"color:white\">No se encontraron registros</span>"
                })
});

this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
this.store_lista.load();

this.formPanel_ = new Ext.form.FormPanel({
    //frame:true,
    width:700,
    height:530,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
        this.gridPanel_
    ]
});

this.salir = new Ext.Button({
    text:'Salir',
    //iconCls: 'icon-cancelar',
    handler:function(){
        Detalle.main.winformPanel_.close();
    }
});

this.winformPanel_ = new Ext.Window({
    title:'Detalle del Proceso',
    modal:true,
    constrain:true,
    width:715,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formPanel_
    ],
    buttons:[
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
//contribuyenteLista.main.mascara.hide();
},
getDatos: function(){        
            window.open("<?php echo $_SERVER['SCRIPT_NAME']; ?>/reporte/index/i/"+Detalle.main.gridPanel_.getSelectionModel().getSelected().get('co_ruta'));  
},
getImagen: function(){
    this.msg = Ext.get('formularioImagen');
    this.msg.load({
    url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/imagen",
    scripts: true,
    text: "Cargando..",
    params:{
                co_ruta:Detalle.main.OBJ.co_ruta
            }
    });  
},
getDocumento: function(){
    window.open("<?php echo $_SERVER['SCRIPT_NAME']; ?>/reporte/documento/i/"+Detalle.main.OBJ.co_ruta_encrip);
},
getLista: function(){
            this.store = new Ext.data.JsonStore({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/storelistaRuta',
            root:'data',
            fields:[
                    {name: 'co_ruta'},
                    {name: 'tx_proceso'},
                    {name: 'tx_estatus'},
                    {name: 'in_cargar_dato'},
                    {name: 'in_cargar_documento'},
                    {name: 'in_cargar_imagen'},
                    {name: 'fe_recepcion'},
                    {name: 'tx_observacion'},
                    {name: 'in_cargar_imagen'},
                    {name: 'in_reporte'}
                ]
            });
            return this.store;
        }
};
Ext.onReady(Detalle.main.init, Detalle.main);
</script>
<div id="requisito" ></div>
<div id="solvencia" ></div>
