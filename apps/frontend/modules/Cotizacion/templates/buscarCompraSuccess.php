<script type="text/javascript">
Ext.ns("PresupuestoBase");
PresupuestoBase.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
    
    this.store_lista = this.getLista();

    function renderDatosRequisicion(val, attr, record) {

            if(val!=''){
                    return '<a href="#" onclick="PresupuestoBase.main.getDatosRequisicion()">'+val+'</a>'        
            }

    }

    function renderDatosPresupuesto(val, attr, record) {

            if(val!=''){
                    return '<a href="#" onclick="PresupuestoBase.main.getDatosPresupuesto()">'+val+'</a>'        
            }

    }

    function renderDatosCompra(val, attr, record) {

            if(val!=''){
                    return '<a href="#" onclick="PresupuestoBase.main.getDatosCompra()">'+val+'</a>'        
            }

    }

    //Grid principal
    this.gridPanel_ = new Ext.grid.GridPanel({
        store: this.store_lista,
        loadMask:true,
    //    frame:true,
        height:350,
        border:false,
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'Solicitud Compra', menuDisabled:true,dataIndex: 'co_solicitud',renderer: renderDatosCompra},    
            {header: 'co_cotizacion',hidden:true, menuDisabled:true,dataIndex: 'co_cotizacion'},    
            {header: 'co_proveedor',hidden:true, menuDisabled:true,dataIndex: 'co_proveedor'}, 
            {header: 'co_compras',hidden:true, menuDisabled:true,dataIndex: 'co_compras'},   
            {header: 'co_documento',hidden:true, menuDisabled:true,dataIndex: 'co_documento'},   
            {header: 'nu_valor',hidden:true, menuDisabled:true,dataIndex: 'nu_valor'},   
            {header: 'nu_iva',hidden:true, menuDisabled:true,dataIndex: 'nu_iva'},   
            {header: 'tx_razon_social',hidden:true, menuDisabled:true,dataIndex: 'co_documento'},  
            {header: 'tx_razon_social',hidden:true, menuDisabled:true,dataIndex: 'co_documento'},  
            {header: 'tx_rif',hidden:true, menuDisabled:true,dataIndex: 'tx_rif'},                
            {header: 'nu_iva',hidden:true, menuDisabled:true,dataIndex: 'nu_iva'},    
            {header: 'co_ruta_requisicion',hidden:true, menuDisabled:true,dataIndex: 'co_ruta_requisicion'},    
            {header: 'co_ruta_presupuesto',hidden:true, menuDisabled:true,dataIndex: 'co_ruta_presupuesto'},    
            {header: 'co_ruta_compra',hidden:true, menuDisabled:true,dataIndex: 'co_ruta_compra'},    
            {header: 'Código Requisición', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'nu_requisicion',renderer: renderDatosRequisicion},        
            {header: 'Código Presupuesto', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_serial_cotizacion',renderer: renderDatosPresupuesto},
           // {header: 'Número Compra', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'numero_compra',renderer: renderDatosCompra},    
            {header: 'Descripción', width:950,  menuDisabled:true, sortable: true, dataIndex: 'tx_observacion'},
        
        ],
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
           /* PartidapresupuestoListaDesagregada.main.co_presupuesto.setValue(PartidapresupuestoListaDesagregada.main.store_lista.getAt(rowIndex).get('id'));
            PartidapresupuestoListaDesagregada.main.monto.setValue(PartidapresupuestoListaDesagregada.main.store_lista.getAt(rowIndex).get('mo_disponible'));*/
        }},
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        bbar: new Ext.PagingToolbar({
            pageSize: 20,
            store: this.store_lista,
            displayInfo: true,
            displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
            emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
        })
    });


    this.store_lista.load();

    this.guardar = new Ext.Button({
        text:'Aceptar',
        iconCls: 'icon-agregar',
        handler:function(){
            var tx_serial_cotizacion = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('tx_serial_cotizacion');

            var tx_observacion = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('tx_observacion');

            var co_cotizacion = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('co_cotizacion');

         
            var co_solicitud_cotizacion = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('co_solicitud');

            var co_compras = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('co_compras');

            var tx_razon_social = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('tx_razon_social');

             var tx_rif = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('tx_rif');

             var tipo = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('tipo');

             var nu_iva = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('tx_rif');

             var nu_valor = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('nu_valor');

             var co_ramo      = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('co_ramo');
             var tx_ramo      = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('tx_ramo');
             var nu_iva       = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('nu_iva');
             var nu_valor     = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('nu_valor');
             var co_documento = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('co_documento');
             var co_proveedor = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('co_proveedor');

            ContabilidadEditar.main.co_solicitud_compra.setValue(co_solicitud_cotizacion);
            ContabilidadEditar.main.tx_concepto.setValue(tx_observacion);
            
            ContabilidadEditar.main.co_compra.setValue(co_compras);
            ContabilidadEditar.main.tx_razon_social.setValue(tx_razon_social);
            ContabilidadEditar.main.tx_rif.setValue(tx_rif);
            ContabilidadEditar.main.co_documento.setValue(co_documento);
            ContabilidadEditar.main.co_proveedor.setValue(co_proveedor);

            ContabilidadEditar.main.OBJ.co_solicitud_cotizacion = co_solicitud_cotizacion;
            ContabilidadEditar.main.OBJ.co_compras              = co_compras;
            ContabilidadEditar.main.OBJ.co_proveedor            = co_proveedor;
            ContabilidadEditar.main.OBJ.nu_iva_retencion        = nu_valor;
            ContabilidadEditar.main.OBJ.nu_iva                  = nu_iva; 
            ContabilidadEditar.main.OBJ.co_documento            = co_documento;

            ContabilidadEditar.main.storeCO_RAMO.load({
            params: {
                    co_proveedor:ContabilidadEditar.main.OBJ.co_proveedor
                }
            });
            

            ContabilidadEditar.main.store_lista.baseParams.co_solicitud = co_solicitud_cotizacion;
            ContabilidadEditar.main.store_lista.load({
                callback: function(){
                    ContabilidadEditar.main.getTotal();
                    ContabilidadEditar.main.getVerificarIVA();
                }
            });

            ContabilidadEditar.main.store_lista_otra.baseParams.co_compra=ContabilidadEditar.main.OBJ.co_compras;
            ContabilidadEditar.main.store_lista_otra.baseParams.co_solicitud=ContabilidadEditar.main.OBJ.co_solicitud;
            ContabilidadEditar.main.store_lista_otra.load({
                callback: function(){
                   ContabilidadEditar.main.calcularMonto();
                }
            });

            PresupuestoBase.main.winformPanel_.close();

        }
    });

    this.salir = new Ext.Button({
        text:'Salir',
    //    iconCls: 'icon-cancelar',
        handler:function(){
            PresupuestoBase.main.winformPanel_.close();
        }
    });



    this.winformPanel_ = new Ext.Window({
            title:'Lista de Compras',
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
                this.guardar,
                this.salir
            ],
            buttonAlign:'center'
    });

    this.winformPanel_.show();


},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/storelistaCompra',
    root:'data',
    fields:[
            {name: 'co_solicitud'},
            {name: 'co_cotizacion'},
            {name: 'nu_requisicion'},
            {name: 'co_proveedor'},
            {name: 'tx_serial_cotizacion'},
            {name: 'numero_compra'},
            {name: 'tx_observacion'},
            {name: 'co_ruta_requisicion'},
            {name: 'co_ruta_presupuesto'},
            {name: 'co_compras'},
            {name: 'nu_iva'},
            {name: 'co_ruta_compra'},
            {name: 'co_compras'},
            {name: 'tx_razon_social'},
            {name: 'tx_rif'},
            {name: 'tipo'},
            {name: 'co_ramo'},
            {name: 'tx_ramo'},
            {name: 'nu_valor'},
            {name: 'co_documento'} 
           ]
    });
    return this.store;
},
getDatosRequisicion: function(){        
            window.open("<?php echo $_SERVER['SCRIPT_NAME']; ?>/reporte/index/i/"+PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('co_ruta_requisicion'));  
},
getDatosPresupuesto: function(){        
            window.open("<?php echo $_SERVER['SCRIPT_NAME']; ?>/reporte/index/i/"+PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('co_ruta_presupuesto'));  
},
getDatosCompra: function(){        
            window.open("<?php echo $_SERVER['SCRIPT_NAME']; ?>/reporte/index/i/"+PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('co_ruta_compra'));  
}
};
Ext.onReady(PresupuestoBase.main.init, PresupuestoBase.main);
</script>
<div id="contenedorPresupuestoBase"></div>
<div id="formularioPartidapresupuesto"></div>
<div id="filtroPartidapresupuesto"></div>
