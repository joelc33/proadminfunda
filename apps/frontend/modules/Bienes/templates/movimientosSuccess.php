<script type="text/javascript">
Ext.ns("MovimientoLista");
MovimientoLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){


//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista_movimientos = this.getLista();


//filtro
this.filtro = new Ext.Button({
    text:'Exportar',
    iconCls: 'icon-descargar',
    handler:function(){
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/movimiento_XLS.php?tipo=1&partida='+MovimientoLista.main.OBJ.codigo);
    }
});

//this.editar.disable();
//this.eliminar.disable();

/*function formatoNro(val){
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}*/

this.tx_observacion = new Ext.form.TextField({
    fieldLabel:'Especificaciones',
    labelStyle: 'width:165px',
    name:'tx_observacion',
    style:'background:#c9c9c9;',
    value:BienesLista.main.gridPanel_.getSelectionModel().getSelected().get('tx_detalle'),
    readOnly:true,
    allowBlank:false,
    width:832
});

this.nu_bienes = new Ext.form.TextField({
    fieldLabel:'Numero del bien',
    labelStyle: 'width:165px',
    name:'nu_bienes',
    allowBlank:false,
    style:'background:#c9c9c9;',
    readOnly:true,
    value:BienesLista.main.gridPanel_.getSelectionModel().getSelected().get('nu_bienes'),
    width:250
});
this.tx_serial_bien = new Ext.form.TextField({
    fieldLabel:'Serial del bien',
    name:'tx_serial_bien',
    labelStyle: 'width:165px',
    style:'background:#c9c9c9;',
    value:BienesLista.main.gridPanel_.getSelectionModel().getSelected().get('tx_serial'),
    readOnly:true,
    allowBlank:false,
    width:250
});

this.fieldDatosBien= new Ext.Panel({
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.nu_bienes]},
                 {items:[this.tx_serial_bien]}
                           ]}]
            
                   });

this.tx_marca = new Ext.form.TextField({
   fieldLabel:'Marca',
   labelStyle: 'width:165px',
    name:'tx_marca',
    style:'background:#c9c9c9;',
    value:BienesLista.main.gridPanel_.getSelectionModel().getSelected().get('tx_marca'),
    readOnly:true,
    allowBlank:false,
    width:250


});


this.tx_modelo = new Ext.form.TextField({
  fieldLabel:'Modelo',
    name:'tx_modelo',
    labelStyle: 'width:165px',
    style:'background:#c9c9c9;',
    value:BienesLista.main.gridPanel_.getSelectionModel().getSelected().get('tx_modelo'),
    readOnly:true,
    allowBlank:false,
    width:250
});


this.fieldDatosMarca= new Ext.Panel({
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.tx_marca]},
                 {items:[this.tx_modelo]}
                           ]}]
            
                   });

this.ubicacion= new Ext.form.TextField({
    fieldLabel:'Ubicación Actual',
     labelStyle: 'width:165px',
    name:'ubicacion',
    allowBlank:false,
    style:'background:#c9c9c9;',
    value:BienesLista.main.gridPanel_.getSelectionModel().getSelected().get('tx_organigrama'),
    readOnly:true,
     width:832
});

this.fieldDatosUni= new Ext.Panel({
    border:false,
    items:[this.ubicacion]
            
                   });

this.fieldDatos= new Ext.form.FieldSet({
    style:'background: white;',
    title: 'Datos del Bien Seleccionado',
      border:true,
    items:[this.tx_observacion,
           this.ubicacion,
           this.fieldDatosMarca,
           this.fieldDatosBien
           ]
});



//Grid principal
this.gridPanel_Comprometido = new Ext.grid.GridPanel({
    title:'Lista de Movimientos',
    iconCls: 'icon-libro',
    store: this.store_lista_movimientos,
    loadMask:true,
    //frame:true,
    height:520,
    border:false,    
   /* tbar:[
        this.filtro
    ],*/
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'Solicitud',width:50, menuDisabled:true,sortable: true, dataIndex: 'co_solicitud'},
    {header: 'Documento',width:100, menuDisabled:true,sortable: true, dataIndex: 'cod_documento'},
            {header: 'Descripción',width:200, menuDisabled:true,sortable: true, dataIndex: 'tx_detalle'},
            {header: 'Ubicacion',width:300, menuDisabled:true,sortable: true, dataIndex: 'tx_organigrama'},
            {header: 'Tipo movimiento',width:150, menuDisabled:true,sortable: true, dataIndex: 'tx_subtipo_movimiento'},
            {header: 'Tipo documento',width:150, menuDisabled:true,sortable: true, dataIndex: 'desc_documento'},
            {header: 'Fecha',width:100, menuDisabled:true,sortable: true,dataIndex: 'fecha'},
            {header: 'Hora',width:100, menuDisabled:true,sortable: true,dataIndex: 'hora'},   
            {header: 'usuario',width:150, menuDisabled:true,sortable: true,dataIndex: 'nb_usuario'},     


    ],
     bbar: new Ext.PagingToolbar({
            pageSize: 20,
            store: this.store_lista_movimientos,
            //params:co_solicitud:BienesDesincorporacion.main.co_solicitud.getValue(),
            displayInfo: true,
            displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
            emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
        }),
    stripeRows: true,
    autoScroll:true,
    stateful: true
});

this.store_lista_movimientos.load();


this.tabuladores = new Ext.TabPanel({
        resizeTabs:true, // turn on tab resizing
        minTabWidth: 100,
        border:false,
        enableTabScroll:true,
        autoWidth:true,
      //  deferredRender:false,
        autoHeight:true,
        activeTab: 0,
        defaults: {autoScroll:true},
        items:[
                {
                        title: 'Movimientos',
                         items:[ this.gridPanel_Comprometido]
                }
        ],
        bbar: new Ext.ux.StatusBar({
            id: 'basic-statusbar',
            autoScroll:true,
            defaults:{style:'color:black;font-size:30px;',autoWidth:true}
        }), 
});

//this.gridPanel_.render("contenedorMovimientoLista");

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Movimientos',
    modal:true,
    constrain:true,
    width:1200,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
    this.fieldDatos,
        this.tabuladores
    ]
});
this.winformPanel_.show();
//PartidapresupuestoLista.main.mascara.hide();


},
getLista: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storelistabienesmovimientos',
    root:'data',
    baseParams:{
        co_bienes: BienesLista.main.gridPanel_.getSelectionModel().getSelected().get('co_bienes')
            },
    fields:[  
    {name: 'co_solicitud'},       
            {name: 'nu_bienes'},
            {name: 'cod_documento'},
            {name: 'tx_serial'},
            {name: 'tx_organigrama'},
            {name: 'tx_detalle'},
            {name: 'tx_subtipo_movimiento'},
            {name: 'desc_documento'},
            {name: 'fecha'},
            {name: 'hora'},
            {name: 'nb_usuario'},

                
           ]
    });
    return this.store;      
}
};
Ext.onReady(MovimientoLista.main.init, MovimientoLista.main);
</script>
<div id="contenedorMovimientoLista"></div>
<div id="formularioMovimiento"></div>
<div id="filtroMovimiento"></div>
