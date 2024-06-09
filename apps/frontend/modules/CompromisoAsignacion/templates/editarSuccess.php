<script type="text/javascript">
    Ext.ns("CompromisoAsignacionEditar");
    CompromisoAsignacionEditar.main = {
        init: function() {

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });
            //<Stores de fk>
            this.storeCO_PROVEEDOR  = this.getStoreCO_PROVEEDOR();
            this.storeCO_SOLICITUD  = this.getStoreCO_SOLICITUD();
            this.storeCO_DOCUMENTO  = this.getStoreCO_DOCUMENTO();
            this.storeCO_PARTIDA    = this.getStoreCO_PARTIDA();
            this.storeCO_PROYECTO   = this.getStoreCO_PROYECTO();
            this.storeCO_ACCION     = this.getStoreCO_ACCION();
            this.storeCO_EJECUTOR   = this.getStoreCO_EJECUTOR();
            this.storeCO_TIPO_PROCESO    = this.getStoreCO_TIPO_PROCESO();
            this.store_lista        = this.getLista();

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
            //</ClavePrimaria>

            this.co_proveedor = new Ext.form.Hidden({
                name: 'tb146_compromiso_asignacion[co_proveedor]',
                value: this.OBJ.co_proveedor
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
                value: "<span style='color:black;font-size:15px;'><b>N° Cancelación: </b>" + CompromisoAsignacionEditar.main.OBJ.nu_cancelacion + "</b></span>"
            });

            this.co_tipo_proceso = new Ext.form.ComboBox({
                fieldLabel: 'Tipo Proceso',
                store: this.storeCO_TIPO_PROCESO,
                typeAhead: true,
                valueField: 'co_tipo_solicitud',
                displayField: 'tx_tipo_solicitud',
                hiddenName: 'tb146_compromiso_asignacion[co_tipo_solicitud]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 300,
                allowBlank: false
            });
            this.storeCO_TIPO_PROCESO.load();

            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_tipo_proceso,
                value: this.OBJ.co_tipo_solicitud,
                objStore: this.storeCO_TIPO_PROCESO
            });

            this.co_documento = new Ext.form.ComboBox({
                fieldLabel: 'Co documento',
                store: this.storeCO_DOCUMENTO,
                typeAhead: true,
                valueField: 'co_documento',
                displayField: 'inicial',
                hiddenName: 'tb008_proveedor[co_documento]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 50,
                allowBlank: false
            });
            this.storeCO_DOCUMENTO.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_documento,
                value: (this.OBJ.co_documento == '') ? 4 : this.OBJ.co_documento,
                objStore: this.storeCO_DOCUMENTO
            });

            this.tx_rif = new Ext.form.TextField({
                name: 'tb008_proveedor[tx_rif]',
                value: this.OBJ.tx_rif,
                allowBlank: false,
                width: 130
            });
            this.co_documento.on("blur", function() {
                if (CompromisoAsignacionEditar.main.tx_rif.getValue() != '') {
                    CompromisoAsignacionEditar.main.verificarProveedor();
                }
            });

            this.tx_rif.on("blur", function() {
                CompromisoAsignacionEditar.main.verificarProveedor();
            });

            this.compositefieldCIRIF = new Ext.form.CompositeField({
                fieldLabel: 'Cedula/Rif',
                width: 185,
                items: [
                    this.co_documento,
                    this.tx_rif,
                ]
            });


            this.tx_razon_social = new Ext.form.TextField({
                fieldLabel: 'Razon Social',
                name: 'tb008_proveedor[tx_razon_social]',
                value: this.OBJ.tx_razon_social,
                readOnly: (this.OBJ.co_factura != '') ? true : false,
                style: (this.OBJ.co_factura != '') ? 'background:#c9c9c9;' : '',
                allowBlank: false,
                width: 600
            });

            this.tx_direccion = new Ext.form.TextField({
                fieldLabel: 'Direccion',
                name: 'tb008_proveedor[tx_direccion]',
                value: this.OBJ.tx_direccion,
                allowBlank: false,
                readOnly: (this.OBJ.co_factura != '') ? true : false,
                style: (this.OBJ.co_factura != '') ? 'background:#c9c9c9;' : '',
                width: 600
            });

            this.fieldProveedor = new Ext.form.FieldSet({
                title: 'Datos del Beneficiario',
                items: [
                    this.compositefieldCIRIF,
                    this.tx_razon_social,
                    this.tx_direccion
                ]
            });


            this.tx_descripcion = new Ext.form.TextArea({
                fieldLabel: 'Descripción',
                name: 'tb146_compromiso_asignacion[tx_descripcion]',
                value: this.OBJ.tx_descripcion,
                allowBlank: false,
                width: 500
            });

          /*  this.nu_cancelacion = new Ext.form.NumberField({
                fieldLabel: 'Nro. Cancelación',
                name: 'tb146_compromiso_asignacion[nu_cancelacion]',
                value: this.OBJ.nu_cancelacion,
                allowBlank: false,
                width: 100
            });*/

            this.fe_compromiso = new Ext.form.DateField({
                fieldLabel: 'Fecha',
                name: 'tb146_compromiso_asignacion[fe_compromiso]',
                value: this.OBJ.fe_compromiso,
                allowBlank: false,
                width: 100
            });

            this.nu_monto = new Ext.form.NumberField({
                fieldLabel: 'Monto Total',
                name: 'tb146_compromiso_asignacion[nu_monto]',
                value: this.OBJ.nu_monto,
                allowBlank: false,
                width: 500
            });

            this.fieldAsignacion = new Ext.form.FieldSet({
                title: 'Datos de la Asignación',
                items: [
                    this.co_tipo_proceso,
                    this.tx_descripcion,
                  //  this.nu_cancelacion,
                    this.fe_compromiso
                  //  this.nu_monto
                ]
            });

            this.agregar = new Ext.Button({
                text: 'Agregar',
                iconCls: 'icon-nuevo',
                handler: function() {
                    this.msg = Ext.get('formularioAgregar');
                    this.msg.load({
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/CompromisoAsignacion/agregarAsignacion',
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
                    CompromisoAsignacionEditar.main.eliminar();
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
                        CompromisoAsignacionEditar.main.botonEliminar.enable();
                    }
                }
            });

            if (this.OBJ.co_compras != '') {
                CompromisoAsignacionEditar.main.store_lista.baseParams.co_compras = this.OBJ.co_compras;
                this.store_lista.load({
                    callback: function() {
                        CompromisoAsignacionEditar.main.total = paqueteComunJS.funcion.getSumaColumnaGrid({
                            store: CompromisoAsignacionEditar.main.store_lista,
                            campo: 'monto'
                        });

                        CompromisoAsignacionEditar.main.monto_total.setValue("<span style='font-size:12px;'><b>Monto Total: </b>" + parseFloat(CompromisoAsignacionEditar.main.total) + "</b></span>");
                        CompromisoAsignacionEditar.main.mo_total.setValue(CompromisoAsignacionEditar.main.total);
                    }
                });
            }

            this.fieldDatosPartida = new Ext.form.FieldSet({
                title: 'Datos del Presupuesto',
                items: [this.gridPanel]
            });

            this.guardar = new Ext.Button({
                text: 'Guardar',
                iconCls: 'icon-guardar',
                handler: function() {

                    if (!CompromisoAsignacionEditar.main.formPanel_.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
                        return false;
                    }

                   /* if (parseFloat(CompromisoAsignacionEditar.main.mo_total.getValue()) != parseFloat(CompromisoAsignacionEditar.main.nu_monto.getValue())) {
                        Ext.Msg.alert("Alerta", "El Monto total debe coincidir con el de la suma de las asignaciones");
                        return false;
                    }*/

                    var lista_asignacion = paqueteComunJS.funcion.getJsonByObjStore({
                        store: CompromisoAsignacionEditar.main.gridPanel.getStore()
                    });

                    CompromisoAsignacionEditar.main.hiddenJsonAsignacion.setValue(lista_asignacion);

                    CompromisoAsignacionEditar.main.formPanel_.getForm().submit({
                        method: 'POST',
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/CompromisoAsignacion/guardar',
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
                            solicitudLista.main.store_lista.baseParams.paginar = 'si';
                            solicitudLista.main.store_lista.baseParams.in_ventanilla = 'true';
                            solicitudLista.main.store_lista.load();
                            solicitudLista.main.store_lista.on('load', function() {
                                solicitudLista.main.estado.disable();
                                solicitudLista.main.anular.disable();
                            });
                            CompromisoAsignacionEditar.main.winformPanel_.close();
                        }
                    });


                }
            });

            this.salir = new Ext.Button({
                text: 'Salir',
                //    iconCls: 'icon-cancelar',
                handler: function() {
                    CompromisoAsignacionEditar.main.winformPanel_.close();
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
                    this.co_proveedor,
                    this.fieldProveedor,
                    this.fieldAsignacion,
                    this.fieldDatosPartida,
                    this.co_solicitud,
                ]
            });

            

            this.winformPanel_ = new Ext.Window({
                title: 'Pagos sin Factura',
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
                    co_partida: CompromisoAsignacionEditar.main.co_partida.getValue()
                },
                success: function(result, request) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    CompromisoAsignacionEditar.main.mo_disponible.setValue(paqueteComunJS.funcion.getNumeroFormateado(obj.data.mo_disponible));
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
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/CompromisoAsignacion/storefkcoproveedor',
                root: 'data',
                fields: [{
                    name: 'co_proveedor'
                }]
            });
            return this.store;
        },
        getStoreCO_SOLICITUD: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/CompromisoAsignacion/storefkcosolicitud',
                root: 'data',
                fields: [{
                    name: 'co_solicitud'
                }]
            });
            return this.store;
        },
        getStoreCO_TIPO_PROCESO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/CompromisoAsignacion/storefkcotipoproceso',
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
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/CompromisoAsignacion/storefkasignacion',
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
            var s = CompromisoAsignacionEditar.main.gridPanel.getSelectionModel().getSelections();

            var co_detalle_compras = CompromisoAsignacionEditar.main.gridPanel.getSelectionModel().getSelected().get('co_detalle_compras');

            if (co_detalle_compras != '') {

                Ext.Ajax.request({
                    method: 'POST',
                    url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/CompromisoAsignacion/eliminarAsignacion',
                    params: {
                        co_detalle_compras: co_detalle_compras
                    },
                    success: function(result, request) {
                        //CompromisoAsignacionEditar.main.store_lista.load();
                        Ext.utiles.msg('Mensaje', "La Asignacion se eliminó exitosamente");
                    }
                });

            }

            CompromisoAsignacionEditar.main.store_lista.baseParams.co_compras = CompromisoAsignacionEditar.main.OBJ.co_compras;
            CompromisoAsignacionEditar.main.store_lista.load({
                callback: function() {
                    CompromisoAsignacionEditar.main.total = paqueteComunJS.funcion.getSumaColumnaGrid({
                        store: CompromisoAsignacionEditar.main.store_lista,
                        campo: 'monto'
                    });

                    CompromisoAsignacionEditar.main.monto_total.setValue("<span style='font-size:12px;'><b>Monto Total: </b>" + parseFloat(CompromisoAsignacionEditar.main.total) + "</b></span>");
                    CompromisoAsignacionEditar.main.mo_total.setValue(CompromisoAsignacionEditar.main.total);
                }
            });

            for (var i = 0, r; r = s[i]; i++) {
                CompromisoAsignacionEditar.main.store_lista.remove(r);
            }
        },
        verificarProveedor: function() {
            Ext.Ajax.request({
                method: 'GET',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/verificarProveedor',
                params: {
                    co_documento: CompromisoAsignacionEditar.main.co_documento.getValue(),
                    tx_rif: CompromisoAsignacionEditar.main.tx_rif.getValue()
                },
                success: function(result, request) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if (!obj.data) {
                        CompromisoAsignacionEditar.main.co_proveedor.setValue("");
                        CompromisoAsignacionEditar.main.co_documento.setValue("");
                        CompromisoAsignacionEditar.main.tx_rif.setValue("");
                        CompromisoAsignacionEditar.main.tx_razon_social.setValue("");

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

                        CompromisoAsignacionEditar.main.co_proveedor.setValue(obj.data.co_proveedor);
                        CompromisoAsignacionEditar.main.tx_razon_social.setValue(obj.data.tx_razon_social);
                        CompromisoAsignacionEditar.main.tx_direccion.setValue(obj.data.tx_direccion);

                    }
                }
            });
        }
    };
    Ext.onReady(CompromisoAsignacionEditar.main.init, CompromisoAsignacionEditar.main);
</script>
<div id="formularioAgregar"></div>