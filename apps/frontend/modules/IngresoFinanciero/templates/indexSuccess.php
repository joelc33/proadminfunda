<script type="text/javascript">
    Ext.ns("solicitudLista");
    solicitudLista.main = {
        condicion: function(codigo) {
            return (codigo == '0') ? 'NO' : 'SI';
        },
        init: function() {

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });

            this.codigo;
            this.co_tipo_solicitud;
            this.co_proceso;

            this.co_solicitud = new Ext.form.TextField({
                fieldLabel: 'N° Procesos',
                name: 'co_solicitud',
                maskRe: /[0-9]/,
                value: '',
                width: 100
            });


            /**
             * <Form Principal que carga el Filtro>
             */
            this.formFiltroPrincipal = new Ext.form.FormPanel({
                title: 'Buscar Transcripción de Movimientos',
                iconCls: 'icon-solpendiente',
                collapsible: true,
                titleCollapse: true,
                autoWidth: true,
                border: false,
                labelWidth: 110,
                padding: '10px',
                items: [
                    this.co_solicitud
                    /*,
                            this.compositefieldCIRIF,
                            this.tx_razon_social*/
                ],
                keys: [{
                    key: [Ext.EventObject.ENTER],
                    handler: function() {
                        solicitudLista.main.aplicarFiltroByFormulario();
                    }
                }],
                buttonAlign: 'center',
                buttons: [{
                        text: 'Consultar',
                        iconCls: 'icon-buscar',
                        handler: function() {
                            solicitudLista.main.aplicarFiltroByFormulario();
                        }
                    },
                    {
                        text: 'Limpiar',
                        iconCls: 'icon-limpiar',
                        handler: function() {
                            solicitudLista.main.limpiarCamposByFormFiltro();
                        }
                    }
                ]
            });

            //Mascara general del modulo
            this.mascara = new Ext.LoadMask(Ext.getBody(), {
                msg: "Cargando..."
            });

            //objeto store
            this.store_lista = this.getLista();

            //Estado registro
            this.estado = new Ext.Button({
                text: 'Enviar Tramite',
                iconCls: 'icon-volver',
                handler: function() { 

                    /* */
                    Ext.MessageBox.confirm('Confirmación', '¿Realmente desea enviar este tramite?', function(boton) {
                        if (boton == "yes") {
                            this.msg = Ext.get('formulariosolicitud');
                            this.msg.load({
                                url: "<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/enviarEntidades",
                                params: {
                                    co_solicitud: solicitudLista.main.gridPanel_.getSelectionModel().getSelected().get('co_solicitud')
                                },
                                scripts: true,
                                text: "Cargando.."
                            });
                        }
                    }); /**/

                }

            });

            this.nueva_solicitud = new Ext.Button({
                text: 'Nuevo',
                iconCls: 'icon-nuevo',
                handler: function() {
                    //                                contribuyenteLista.main.mascara.show();
                    this.msg = Ext.get('formulariocontribuyente');
                    this.msg.load({
                        url: "<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/editar",
                        scripts: true,
                        text: "Cargando.."
                    });
                }
            });

            this.anular = new Ext.Button({
                text: 'Anular Contrato',
                iconCls: 'icon-anteriores',
                handler: function() {

                    /* */
                    Ext.MessageBox.confirm('Confirmación', '¿Realmente desea anular este tramite?', function(boton) {
                        if (boton == "yes") {
                            this.msg = Ext.get('formulariosolicitud');
                            this.msg.load({
                                url: "<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/enviarAnular",
                                params: {
                                    co_solicitud: solicitudLista.main.gridPanel_.getSelectionModel().getSelected().get('co_solicitud')
                                },
                                scripts: true,
                                text: "Cargando.."
                            });
                        }
                    }); /**/

                }

            });

            this.formulario = new Ext.Button({
                text: 'Cargar Datos',
                iconCls: 'icon-cambio',
                handler: function() {
                    this.msg = Ext.get('formulariosolicitud');
                    this.msg.load({
                        url: "<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/cargarDatos",
                        scripts: true,
                        text: "Cargando..",
                        params: {
                            co_solicitud: solicitudLista.main.codigo,
                            co_tipo_solicitud: 35,
                            co_proceso: 46
                        }
                    });
                }
            });

            this.detalle = new Ext.Button({
                text: 'Historico Proceso',
                iconCls: 'icon-buscar',
                handler: function() {
                    this.msg = Ext.get('formulariosolicitud');
                    this.msg.load({
                        url: "<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/historial",
                        scripts: true,
                        text: "Cargando..",
                        params: {
                            co_solicitud: solicitudLista.main.codigo,
                            co_tipo_solicitud: solicitudLista.main.co_tipo_solicitud,
                            co_proceso: solicitudLista.main.co_proceso
                        }
                    });
                }
            });

            this.detalle.disable();
            this.formulario.disable();

            function renderDatos(val, attr, record) {

                if (val != '') {
                    return '<a href="#" onclick="solicitudLista.main.getDatos()">Ver Documento</a>'
                }

            }

            this.gridPanel_ = new Ext.grid.GridPanel({
                title: 'Lista de Transcripción de Movimientos',
                iconCls: 'icon-libro',
                store: this.store_lista,
                loadMask: true,
                //    frame:true,
                height: 396,
                tbar: [
                    <?php
                    if ($sf_request->getAttribute('in_activo') == true) {
                    ?>
                        this.nueva_solicitud, '-',
                    <?php
                    }
                    ?>
                    this.formulario, '-',
                    //  this.detalle, '-',
                    this.estado, '-',
                    this.anular
                ],
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'N° Proceso',
                        width: 100,
                        menuDisabled: true,
                        dataIndex: 'co_solicitud'
                    },
                    {
                        header: 'id',
                        hidden: true,
                        menuDisabled: true,
                        dataIndex: 'id'
                    },
                    {
                        header: 'Banco',
                        width: 100,
                        menuDisabled: true,
                        sortable: true,
                        dataIndex: 'id_tb010_banco'
                    },
                    {
                        header: 'N° Documento',
                        width: 100,
                        menuDisabled: true,
                        sortable: true,
                        dataIndex: 'nu_documento'
                    },
                    {
                        header: 'Cuenta Bancaria',
                        width: 200,
                        menuDisabled: true,
                        sortable: true,
                        dataIndex: 'cuenta'
                    },
                    {
                        header: 'Fecha',
                        width: 100,
                        menuDisabled: true,
                        sortable: true,
                        dataIndex: 'fe_transaccion'
                    },
                    {
                        header: 'N° Transaccion',
                        width: 100,
                        menuDisabled: true,
                        sortable: true,
                        dataIndex: 'nu_transaccion'
                    },
                    {
                        header: 'Monto',
                        width: 150,
                        menuDisabled: true,
                        sortable: true,
                        renderer: formatoNumero,
                        dataIndex: 'mo_transaccion'
                    },
                    {
                        header: 'Saldo Nuevo',
                        width: 150,
                        menuDisabled: true,
                        sortable: true,
                        renderer: formatoNumero,
                        dataIndex: 'mo_saldo_nuevo'
                    },
                    {
                        header: 'Saldo Anterior',
                        width: 150,
                        menuDisabled: true,
                        sortable: true,
                        renderer: formatoNumero,
                        dataIndex: 'mo_saldo_anterior'
                    }
                ],
                stripeRows: true,
                autoScroll: true,
                stateful: true,
                listeners: {
                    cellclick: function(Grid, rowIndex, columnIndex, e) {

                        solicitudLista.main.estado.enable();
                        solicitudLista.main.anular.enable();
                        solicitudLista.main.formulario.enable();
                        solicitudLista.main.detalle.enable();

                        solicitudLista.main.codigo = solicitudLista.main.store_lista.getAt(rowIndex).get('co_solicitud');
                        solicitudLista.main.co_tipo_solicitud = solicitudLista.main.store_lista.getAt(rowIndex).get('co_tipo_solicitud');
                        solicitudLista.main.co_proceso = solicitudLista.main.store_lista.getAt(rowIndex).get('co_proceso');



                    }
                },
                bbar: new Ext.PagingToolbar({
                    pageSize: 15,
                    store: this.store_lista,
                    displayInfo: true,
                    displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
                    emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
                })
            });

            this.panel = new Ext.Panel({
                //	title: 'Lista de contribuyente',
                border: false,
                items: [this.formFiltroPrincipal, this.gridPanel_]
            });

            this.panel.render("contenedorsolicitudLista");

            //Cargar el grid
            this.store_lista.baseParams.paginar = 'si';
            this.store_lista.baseParams.in_ventanilla = 'true';
            this.store_lista.load();
            this.store_lista.on('load', function() {
                solicitudLista.main.estado.disable();
                solicitudLista.main.anular.disable();
            });
        },
        getDatos: function() {
            window.open("<?php echo $_SERVER['SCRIPT_NAME']; ?>/reporte/index/i/" + solicitudLista.main.gridPanel_.getSelectionModel().getSelected().get('co_ruta'));
        },
        onReporte: function() {
            this.msg = Ext.get('formulariosolicitud');
            this.msg.load({
                url: "<?php echo $_SERVER["SCRIPT_NAME"] ?>/reporte/ReporteSolicitudesPendientesVentanilla",
                scripts: true,
                text: "Cargando.."
            });
        },
        getLista: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/storelista',
                root: 'data',
                fields: [{
                        name: 'id'
                    },
                    {
                        name: 'co_solicitud'
                    },
                    {
                        name: 'in_activo'
                    },
                    {
                        name: 'created_at'
                    },
                    {
                        name: 'updated_at'
                    },
                    {
                        name: 'id_tb011_cuenta_bancaria'
                    },
                    {
                        name: 'mo_transaccion'
                    },
                    {
                        name: 'fe_transaccion'
                    },
                    {
                        name: 'mo_saldo_nuevo'
                    },
                    {
                        name: 'de_observacion'
                    },
                    {
                        name: 'id_tb010_banco'
                    },
                    {
                        name: 'id_tb154_tipo_cuenta_movimiento'
                    },
                    {
                        name: 'id_tb153_tipo_documento_cuenta'
                    },
                    {
                        name: 'id_tb156_subtipo_documento'
                    },
                    {
                        name: 'nu_documento'
                    },
                    {
                        name: 'mo_saldo_anterior'
                    },
                    {
                        name: 'nu_transaccion'
                    },
                    {
                        name: 'cuenta',
                        convert: function(v, r) {
                            return r.id_tb011_cuenta_bancaria + ' - ' + r.tx_descripcion;
                        }
                    }
                ]
            });
            return this.store;
        },
        aplicarFiltroByFormulario: function() {
            //Capturamos los campos con su value para posteriormente verificar cual
            //esta lleno y trabajar en base a ese.
            var campo = solicitudLista.main.formFiltroPrincipal.getForm().getValues();

            if (panel_detalle.collapsed == false) {
                panel_detalle.toggleCollapse();
            }


            solicitudLista.main.store_lista.baseParams = {}

            var swfiltrar = false;
            for (campName in campo) {
                if (campo[campName] != '') {
                    swfiltrar = true;
                    eval(" solicitudLista.main.store_lista.baseParams." + campName + " = '" + campo[campName] + "';");
                }
            }
            if (swfiltrar == true) {
                solicitudLista.main.store_lista.baseParams.BuscarBy = true;
                solicitudLista.main.store_lista.baseParams.in_ventanilla = 'true';
                solicitudLista.main.store_lista.load();
            } else {
                Ext.MessageBox.show({
                    title: 'Notificación',
                    msg: 'Debe ingresar un parametro de busqueda',
                    buttons: Ext.MessageBox.OK,
                    icon: Ext.MessageBox.WARNING
                });
            }

        },
        limpiarCamposByFormFiltro: function() {
            solicitudLista.main.formFiltroPrincipal.getForm().reset();
            solicitudLista.main.store_lista.baseParams = {};
            solicitudLista.main.store_lista.load();
        }
    };
    Ext.onReady(solicitudLista.main.init, solicitudLista.main);
</script>
<div id="contenedorsolicitudLista"></div>
<div id="formulariosolicitud"></div>
<div id="filtrosolicitud"></div>
<div id="formulariocontribuyente"></div>