<script type="text/javascript">
    Ext.ns("agregarCompromiso");
    agregarCompromiso.main = {
        init: function() {

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });
            //<Stores de fk>           
            this.storeCO_SOLICITUD = this.getStoreCO_SOLICITUD();
            this.storeCO_PARTIDA = this.getStoreCO_PARTIDA();
            this.storeCO_PROYECTO = this.getStoreCO_PROYECTO();
            this.storeCO_ACCION = this.getStoreCO_ACCION();
            this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();
            this.storeCO_TIPO_PROCESO = this.getStoreCO_TIPO_PROCESO();
            this.store_lista = this.getLista();

            this.Registro = Ext.data.Record.create([{
                    name: 'co_detalle_compras',
                    type: 'number'
                },
                {
                    name: 'co_ejecutor',
                    type: 'number'
                },
                {
                    name: 'tx_ejecutor',
                    type: 'string'
                },
                {
                    name: 'co_proyecto',
                    type: 'number'
                },
                {
                    name: 'tx_proyecto',
                    type: 'string'
                },
                {
                    name: 'co_accion',
                    type: 'number'
                },
                {
                    name: 'tx_accion',
                    type: 'string'
                },
                {
                    name: 'co_partida',
                    type: 'number'
                },
                {
                    name: 'tx_partida',
                    type: 'string'
                },
                {
                    name: 'monto',
                    type: 'number'
                }
            ]);

            this.hiddenJsonAsignacion = new Ext.form.Hidden({
                name: 'json_asignacion',
                value: ''
            });

            //<ClavePrimaria>
            this.co_compromiso_asignacion = new Ext.form.Hidden({
                name: 'co_compromiso_asignacion',
                value: this.OBJ.co_compromiso_asignacion
            });

            this.co_solicitud = new Ext.form.Hidden({
                name: 'tb146_compromiso_asignacion[co_solicitud]',
                value: this.OBJ.co_solicitud
            });

            this.co_usuario = new Ext.form.Hidden({
                name: 'tb146_compromiso_asignacion[co_usuario]',
                value: this.OBJ.co_usuario
            });

            this.co_detalle_compra = new Ext.form.Hidden({
                name: 'tb146_compromiso_asignacion[co_detalle_compra]',
                value: this.OBJ.co_detalle_compras
            });

            this.co_compras = new Ext.form.Hidden({
                name: 'tb146_compromiso_asignacion[co_compras]',
                value: this.OBJ.co_compras
            });


            this.mo_total = new Ext.form.Hidden({
                name: 'mo_total',
                value: 0
            });


            this.nu_cancelacion = new Ext.form.DisplayField({
                value: "<span style='color:black;font-size:15px;'><b>N° Cancelación: </b>" + agregarCompromiso.main.OBJ.nu_cancelacion + "</b></span>"
            });



            this.tx_descripcion = new Ext.form.TextArea({
                fieldLabel: 'Descripción',
                name: 'tb146_compromiso_asignacion[tx_descripcion]',
                value: this.OBJ.tx_descripcion,
                allowBlank: false,
                width: 500
            });

            this.fe_compromiso = new Ext.form.DateField({
                fieldLabel: 'Fecha',
                name: 'tb146_compromiso_asignacion[fe_compromiso]',
                value: this.OBJ.fe_compromiso,
                allowBlank: false,
                width: 100
            });

            this.fieldAsignacion = new Ext.form.FieldSet({
                title: 'Datos de la Asignación',
                items: [
                    this.tx_descripcion,
                    this.fe_compromiso
                ]
            });

            this.agregar = new Ext.Button({
                text: 'Agregar',
                iconCls: 'icon-nuevo',
                handler: function() {
                    this.msg = Ext.get('formularioAgregar');
                    this.msg.load({
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoConFactura/agregarAsignacion',
                        params: {
                            co_compras: agregarCompromiso.main.OBJ.co_compras,
                            tx_descripcion: agregarCompromiso.main.tx_descripcion.getValue()
                        },
                        scripts: true,
                        text: "Cargando.."
                    });
                }
            });

            this.botonEliminar = new Ext.Button({
                text: 'Eliminar',
                iconCls: 'icon-eliminar',
                id: 'eliminar',
                handler: function(boton) {
                    agregarCompromiso.main.eliminar();
                }
            });

            this.botonEliminar.disable();

            this.monto_total = new Ext.form.DisplayField({
                value: "<span style='font-size:12px;'><b>Monto Total: </b>0</b></span>"
            });



            this.gridPanel = new Ext.grid.GridPanel({
                title: 'Lista de Asignaciones',
                iconCls: 'icon-libro',
                store: this.store_lista,
                loadMask: true,
                height: 200,
                width: 840,
                tbar: [this.agregar, '-', this.botonEliminar],
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'co_detalle_compras',
                        hidden: true,
                        width: 80,
                        menuDisabled: true,
                        dataIndex: 'co_detalle_compras'
                    },
                    {
                        header: 'Ente Ejecutor',
                        width: 206,
                        menuDisabled: true,
                        dataIndex: 'tx_ejecutor'
                    },
                    {
                        header: 'Proyecto/Ac',
                        width: 226,
                        menuDisabled: true,
                        dataIndex: 'tx_proyecto'
                    },
                    {
                        header: 'Partida',
                        width: 226,
                        menuDisabled: true,
                        dataIndex: 'tx_partida'
                    },
                    {
                        header: 'Monto',
                        width: 130,
                        menuDisabled: true,
                        dataIndex: 'monto'
                    }
                ],
                bbar: new Ext.ux.StatusBar({
                    id: 'basic-statusbar',
                    autoScroll: true,
                    defaults: {
                        style: 'color:black;font-size:30px;',
                        autoWidth: true
                    },
                    items: [
                        this.monto_total
                    ]
                }),
                stripeRows: true,
                autoScroll: true,
                stateful: true,
                listeners: {
                    cellclick: function(Grid, rowIndex, columnIndex, e) {
                        agregarCompromiso.main.botonEliminar.enable();
                    }
                }
            });

            this.fieldDatosPartida = new Ext.form.FieldSet({
                title: 'Datos del Presupuesto',
                items: [this.gridPanel]
            });



            if (this.OBJ.co_compras != '') {
                agregarCompromiso.main.store_lista.baseParams.co_compras = this.OBJ.co_compras;
                this.store_lista.load({
                    callback: function() {
                        agregarCompromiso.main.total = paqueteComunJS.funcion.getSumaColumnaGrid({
                            store: agregarCompromiso.main.store_lista,
                            campo: 'monto'
                        });

                        agregarCompromiso.main.monto_total.setValue("<span style='font-size:12px;'><b>Monto Total: </b>" + parseFloat(agregarCompromiso.main.total) + "</b></span>");
                        agregarCompromiso.main.mo_total.setValue(agregarCompromiso.main.total);


                    }
                });

            } else {

                this.fieldDatosPartida.hide();
            }

            this.guardar = new Ext.Button({
                text: 'Guardar',
                iconCls: 'icon-guardar',
                handler: function() {

                    if (!agregarCompromiso.main.formPanel_.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
                        return false;
                    }

                    /* if (parseFloat(agregarCompromiso.main.mo_total.getValue()) != parseFloat(agregarCompromiso.main.nu_monto.getValue())) {
                         Ext.Msg.alert("Alerta", "El Monto total debe coincidir con el de la suma de las asignaciones");
                         return false;
                     }*/

                    /* var lista_asignacion = paqueteComunJS.funcion.getJsonByObjStore({
                         store: agregarCompromiso.main.gridPanel.getStore()
                     });

                     agregarCompromiso.main.hiddenJsonAsignacion.setValue(lista_asignacion);*/

                    agregarCompromiso.main.formPanel_.getForm().submit({
                        method: 'POST',
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoConFactura/guardarCompromiso',
                        waitMsg: 'Enviando datos, por favor espere..',
                        waitTitle: 'Enviando',
                        failure: function(form, action) {
                            Ext.MessageBox.alert('Error en transacción', action.result.msg);
                        },
                        success: function(form, action) {
                            if (action.result.success) {
                                Ext.MessageBox.show({
                                    title: 'Mensaje',
                                    msg: action.result.msg,
                                    closable: false,
                                    icon: Ext.MessageBox.INFO,
                                    resizable: false,
                                    animEl: document.body,
                                    buttons: Ext.MessageBox.OK
                                });
                            }
                            PagoConFacturaEditar.main.store_lista.baseParams.paginar = 'si';
                            PagoConFacturaEditar.main.store_lista.baseParams.in_ventanilla = 'true';
                            PagoConFacturaEditar.main.store_lista.load({
                                callback: function() {
                                    PagoConFacturaEditar.main.total = paqueteComunJS.funcion.getSumaColumnaGrid({
                                        store: PagoConFacturaEditar.main.store_lista,
                                        campo: 'monto_total'
                                    });

                                    PagoConFacturaEditar.main.monto_total.setValue("<span style='font-size:12px;'><b>Monto Total: </b>" + parseFloat(PagoConFacturaEditar.main.total) + "</b></span>");
                                    PagoConFacturaEditar.main.mo_total.setValue(PagoConFacturaEditar.main.total);

                                    PagoConFacturaEditar.main.editar.disable();
                                    PagoConFacturaEditar.main.botonEliminar.disable();
                                }
                            });

                            agregarCompromiso.main.winformPanel_.close();

                            if (agregarCompromiso.main.OBJ.co_compras == '') {

                                agregarCompromiso.main.co_compras = action.result.co_compras;

                                solicitudLista.main.msg = Ext.get('formularioAgregar');
                                solicitudLista.main.msg.load({
                                    url: "<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoConFactura/agregarCompromiso",
                                    scripts: true,
                                    text: "Cargando..",
                                    params: {
                                        co_compras: agregarCompromiso.main.co_compras
                                    }
                                });

                            }
                        }
                    });


                }
            });

            this.salir = new Ext.Button({
                text: 'Salir',
                //    iconCls: 'icon-cancelar',
                handler: function() {
                    agregarCompromiso.main.winformPanel_.close();
                }
            });

            var tbar = {
                xtype: 'toolbar',
                layout: 'hbox',
                items: this.nu_cancelacion,
                height: 25,
                layoutConfig: {
                    align: 'left'
                }
            };

            this.formPanel_ = new Ext.form.FormPanel({
                frame: true,
                width: 900,
                autoHeight: true,
                autoScroll: true,
                bodyStyle: 'padding:10px;',
                items: [

                    this.co_compromiso_asignacion,
                    this.co_compras,
                    this.hiddenJsonAsignacion,
                    this.fieldAsignacion,
                    this.fieldDatosPartida,
                    this.co_solicitud,
                ]
            });



            this.winformPanel_ = new Ext.Window({
                title: 'Agregar Asignación',
                modal: true,
                constrain: true,
                width: 900,
                frame: true,
                closabled: true,
                autoHeight: true,
                tbar: tbar,
                items: [
                    this.formPanel_
                ],
                buttons: [
                    this.guardar,
                    this.salir
                ],
                buttonAlign: 'center'
            });
            this.winformPanel_.show();

        },
        getStoreCO_PARTIDA: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcopartida',
                root: 'data',
                fields: [{
                        name: 'id'
                    },
                    {
                        name: 'mo_disponible'
                    },
                    {
                        name: 'de_partida',
                        convert: function(v, r) {
                            return r.nu_partida + ' - ' + r.de_partida;
                        }
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_PROYECTO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoproyecto',
                root: 'data',
                fields: [{
                        name: 'id'
                    },
                    {
                        name: 'de_proyecto_ac',
                        convert: function(v, r) {
                            return r.nu_proyecto_ac + ' - ' + r.de_proyecto_ac;
                        }
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_EJECUTOR: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcoejecutororgano',
                root: 'data',
                fields: [{
                        name: 'id'
                    },
                    {
                        name: 'de_ejecutor'
                    },
                    {
                        name: 'ejecutor',
                        convert: function(v, r) {
                            return r.nu_ejecutor + ' - ' + r.de_ejecutor;
                        }
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_ACCION: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoaccion',
                root: 'data',
                fields: [{
                        name: 'id'
                    },
                    {
                        name: 'accion_especifica',
                        convert: function(v, r) {
                            return r.nu_accion_especifica + ' - ' + r.de_accion_especifica;
                        }
                    }
                ]
            });
            return this.store;
        },
        cargarDisponible: function() {
            Ext.Ajax.request({
                method: 'GET',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/cargarDisponible',
                params: {
                    co_partida: agregarCompromiso.main.co_partida.getValue()
                },
                success: function(result, request) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    agregarCompromiso.main.mo_disponible.setValue(paqueteComunJS.funcion.getNumeroFormateado(obj.data.mo_disponible));
                }
            });
        },
        getStoreCO_DOCUMENTO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcodocumento',
                root: 'data',
                fields: [{
                        name: 'co_documento'
                    },
                    {
                        name: 'inicial'
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_PROVEEDOR: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoConFactura/storefkcoproveedor',
                root: 'data',
                fields: [{
                    name: 'co_proveedor'
                }]
            });
            return this.store;
        },
        getStoreCO_SOLICITUD: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoConFactura/storefkcosolicitud',
                root: 'data',
                fields: [{
                    name: 'co_solicitud'
                }]
            });
            return this.store;
        },
        getStoreCO_TIPO_PROCESO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoConFactura/storefkcotipoproceso',
                root: 'data',
                fields: [{
                        name: 'co_tipo_solicitud'
                    },
                    {
                        name: 'tx_tipo_solicitud'
                    }
                ]
            });
            return this.store;
        },
        getLista: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoConFactura/storefkcompromiso',
                root: 'data',
                fields: [{
                        name: 'co_detalle_compras'
                    },
                    {
                        name: 'tx_ejecutor'
                    },
                    {
                        name: 'tx_proyecto'
                    },
                    {
                        name: 'tx_partida'
                    },
                    {
                        name: 'monto'
                    }
                ]
            });
            return this.store;
        },
        eliminar: function() {
            var s = agregarCompromiso.main.gridPanel.getSelectionModel().getSelections();

            var co_detalle_compras = agregarCompromiso.main.gridPanel.getSelectionModel().getSelected().get('co_detalle_compras');

            if (co_detalle_compras != '') {

                Ext.Ajax.request({
                    method: 'POST',
                    url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoConFactura/eliminarAsignacionPartida',
                    params: {
                        co_detalle_compras: co_detalle_compras
                    },
                    success: function(result, request) {
                        //agregarCompromiso.main.store_lista.load();
                        Ext.utiles.msg('Mensaje', "La Asignacion se eliminó exitosamente");
                    }
                });

            }

            PagoConFacturaEditar.main.store_lista.baseParams.co_solicitud = PagoConFacturaEditar.main.OBJ.co_solicitud;
            this.store_lista.load({
                callback: function() {
                    PagoConFacturaEditar.main.total = paqueteComunJS.funcion.getSumaColumnaGrid({
                        store: PagoConFacturaEditar.main.store_lista,
                        campo: 'monto_total'
                    });

                    PagoConFacturaEditar.main.monto_total.setValue("<span style='font-size:12px;'><b>Monto Total: </b>" + parseFloat(PagoConFacturaEditar.main.total) + "</b></span>");
                    PagoConFacturaEditar.main.mo_total.setValue(PagoConFacturaEditar.main.total);
                }
            });

            agregarCompromiso.main.store_lista.baseParams.co_compras = agregarCompromiso.main.OBJ.co_compras;
            agregarCompromiso.main.store_lista.load({
                callback: function() {
                    agregarCompromiso.main.total = paqueteComunJS.funcion.getSumaColumnaGrid({
                        store: agregarCompromiso.main.store_lista,
                        campo: 'monto'
                    });

                    agregarCompromiso.main.monto_total.setValue("<span style='font-size:12px;'><b>Monto Total: </b>" + parseFloat(agregarCompromiso.main.total) + "</b></span>");
                    agregarCompromiso.main.mo_total.setValue(agregarCompromiso.main.total);
                }
            });

            for (var i = 0, r; r = s[i]; i++) {
                agregarCompromiso.main.store_lista.remove(r);
            }
        },
        verificarProveedor: function() {
            Ext.Ajax.request({
                method: 'GET',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/verificarProveedor',
                params: {
                    co_documento: agregarCompromiso.main.co_documento.getValue(),
                    tx_rif: agregarCompromiso.main.tx_rif.getValue()
                },
                success: function(result, request) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if (!obj.data) {
                        agregarCompromiso.main.co_proveedor.setValue("");
                        agregarCompromiso.main.co_documento.setValue("");
                        agregarCompromiso.main.tx_rif.setValue("");
                        agregarCompromiso.main.tx_razon_social.setValue("");

                        Ext.Msg.show({
                            title: 'ALERTA',
                            msg: 'El Proveedor no se encuentra registrado',
                            width: 400,
                            height: 800,
                            closable: false,
                            buttons: Ext.Msg.OK,
                            icon: Ext.Msg.INFO
                        });

                    } else {

                        agregarCompromiso.main.co_proveedor.setValue(obj.data.co_proveedor);
                        agregarCompromiso.main.tx_razon_social.setValue(obj.data.tx_razon_social);
                        agregarCompromiso.main.tx_direccion.setValue(obj.data.tx_direccion);

                    }
                }
            });
        }
    };
    Ext.onReady(agregarCompromiso.main.init, agregarCompromiso.main);
</script>
<div id="formularioAgregar"></div>