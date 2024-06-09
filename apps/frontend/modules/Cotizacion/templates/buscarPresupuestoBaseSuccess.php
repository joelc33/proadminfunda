<script type="text/javascript">
    Ext.ns("PresupuestoBase");
    PresupuestoBase.main = {
        condicion: function(codigo) {
            return (codigo == '0') ? 'NO' : 'SI';
        },
        init: function() {

            this.store_lista = this.getLista();

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });

            function renderDatosRequisicion(val, attr, record) {

                if (val != '') {
                    return '<a href="#" onclick="PresupuestoBase.main.getDatosRequisicion()">' + val + '</a>'
                }

            }

            function renderDatosPresupuesto(val, attr, record) {

                if (val != '') {
                    return '<a href="#" onclick="PresupuestoBase.main.getDatosPresupuesto()">' + val + '</a>'
                }

            }

            //Grid principal
            this.gridPanel_ = new Ext.grid.GridPanel({
                store: this.store_lista,
                loadMask: true,
                //    frame:true,
                height: 350,
                border: false,
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'Solicitud',
                        menuDisabled: true,
                        dataIndex: 'co_solicitud'
                    },
                    {
                        header: 'co_cotizacion',
                        hidden: true,
                        menuDisabled: true,
                        dataIndex: 'co_cotizacion'
                    },
                    {
                        header: 'nu_iva',
                        hidden: true,
                        menuDisabled: true,
                        dataIndex: 'nu_iva'
                    },
                    {
                        header: 'co_ruta_requisicion',
                        hidden: true,
                        menuDisabled: true,
                        dataIndex: 'co_ruta_requisicion'
                    },
                    {
                        header: 'co_ruta_presupuesto',
                        hidden: true,
                        menuDisabled: true,
                        dataIndex: 'co_ruta_presupuesto'
                    },
                    {
                        header: 'Código Requisición',
                        width: 150,
                        menuDisabled: true,
                        sortable: true,
                        dataIndex: 'nu_requisicion',
                        renderer: renderDatosRequisicion
                    },
                    {
                        header: 'Código Presupuesto',
                        width: 150,
                        menuDisabled: true,
                        sortable: true,
                        dataIndex: 'tx_serial_cotizacion',
                        renderer: renderDatosPresupuesto
                    },
                    {
                        header: 'Departamento',
                        width: 200,
                        menuDisabled: true,
                        sortable: true,
                        dataIndex: 'tx_ente'
                    },
                    {
                        header: 'Descripción',
                        width: 950,
                        menuDisabled: true,
                        sortable: true,
                        dataIndex: 'tx_observacion'
                    },
                ],
                listeners: {
                    cellclick: function(Grid, rowIndex, columnIndex, e) {
                        /* PartidapresupuestoListaDesagregada.main.co_presupuesto.setValue(PartidapresupuestoListaDesagregada.main.store_lista.getAt(rowIndex).get('id'));
                         PartidapresupuestoListaDesagregada.main.monto.setValue(PartidapresupuestoListaDesagregada.main.store_lista.getAt(rowIndex).get('mo_disponible'));*/
                    }
                },
                stripeRows: true,
                autoScroll: true,
                stateful: true,
                bbar: new Ext.PagingToolbar({
                    pageSize: 20,
                    store: this.store_lista,
                    displayInfo: true,
                    displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
                    emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
                })
            });

            this.store_lista.baseParams.co_tipo_solicitud   = this.OBJ.co_tipo_solicitud;
            this.store_lista.baseParams.co_tipo_tramite     = this.OBJ.co_tipo_tramite;
            this.store_lista.load();

            this.guardar = new Ext.Button({
                text: 'Aceptar',
                iconCls: 'icon-agregar',
                handler: function() {
                    var tx_serial_cotizacion = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('tx_serial_cotizacion');

                    var tx_observacion = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('tx_observacion');

                    var co_cotizacion = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('co_cotizacion');

                    var nu_iva = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('nu_iva');

                    var co_solicitud_cotizacion = PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('co_solicitud');

                    ComprasEditar.main.tx_serial_cotizacion.setValue(tx_serial_cotizacion);
                    ComprasEditar.main.tx_observacion.setValue(tx_observacion);
                    ComprasEditar.main.co_iva_factura.setValue(nu_iva);
                    ComprasEditar.main.co_solicitud_cotizacion.setValue(co_solicitud_cotizacion);


                    ComprasEditar.main.store_lista.baseParams.co_cotizacion = co_cotizacion;
                    ComprasEditar.main.store_lista.load({
                        callback: function() {
                            ComprasEditar.main.getTotal();
                            ComprasEditar.main.getVerificarIVA();
                        }
                    });

                    PresupuestoBase.main.winformPanel_.close();

                }
            });

            this.salir = new Ext.Button({
                text: 'Salir',
                //    iconCls: 'icon-cancelar',
                handler: function() {
                    PresupuestoBase.main.winformPanel_.close();
                }
            });



            this.winformPanel_ = new Ext.Window({
                title: 'Lista de Presupuesto Base',
                modal: true,
                constrain: true,
                width: 1300,
                frame: true,
                closabled: true,
                autoHeight: true,
                items: [
                    this.gridPanel_
                ],
                buttons: [
                    this.guardar,
                    this.salir
                ],
                buttonAlign: 'center'
            });

            this.winformPanel_.show();


        },
        getLista: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/storelistaPresupuestoBase',
                root: 'data',
                fields: [{
                        name: 'co_solicitud'
                    },
                    {
                        name: 'co_cotizacion'
                    },
                    {
                        name: 'nu_requisicion'
                    },
                    {
                        name: 'tx_serial_cotizacion'
                    },
                    {
                        name: 'tx_observacion'
                    },
                    {
                        name: 'co_ruta_requisicion'
                    },
                    {
                        name: 'co_ruta_presupuesto'
                    },
                    {
                        name: 'nu_iva'
                    },
                    {
                        name: 'tx_ente'
                    }
                ]
            });
            return this.store;
        },
        getDatosRequisicion: function() {
            window.open("<?php echo $_SERVER['SCRIPT_NAME']; ?>/reporte/index/i/" + PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('co_ruta_requisicion'));
        },
        getDatosPresupuesto: function() {
            window.open("<?php echo $_SERVER['SCRIPT_NAME']; ?>/reporte/index/i/" + PresupuestoBase.main.gridPanel_.getSelectionModel().getSelected().get('co_ruta_presupuesto'));
        }
    };
    Ext.onReady(PresupuestoBase.main.init, PresupuestoBase.main);
</script>
<div id="contenedorPresupuestoBase"></div>
<div id="formularioPartidapresupuesto"></div>
<div id="filtroPartidapresupuesto"></div>