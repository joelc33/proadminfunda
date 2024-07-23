<script type="text/javascript">
    Ext.ns("cajaEditar");
    cajaEditar.main = {
        init: function() {

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });
            this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
            this.storeCO_ESTATUS_PAGO = this.getStoreCO_ESTATUS_PAGO();
            this.storeCO_CONCEPTO_PAGO = this.getStoreCO_CONCEPTO_PAGO();
            this.storeCO_FORMA_PAGO = this.getStoreCO_FORMA_PAGO();

            this.store_lista = this.getLista();

            this.Registro = Ext.data.Record.create([{
                    name: 'co_detalle_fondo',
                    type: 'number'
                },
                {
                    name: 'co_tipo_retencion',
                    type: 'number'
                },
                {
                    name: 'tx_tipo_retencion',
                    type: 'number'
                },
                {
                    name: 'monto',
                    type: 'number'
                },
                {
                    name: 'tx_observacion',
                    type: 'string'
                }
            ]);


            this.co_solicitud = new Ext.form.Hidden({
                name: 'fondo[co_solicitud]',
                value: this.OBJ.co_solicitud,
                allowBlank: false
            });

            this.co_estatus_pago = new Ext.form.Hidden({
                name: 'co_estatus_pago'
            });

            this.co_forma_pago = new Ext.form.Hidden({
                name: 'co_forma_pago'
            });

            this.co_concepto_pago = new Ext.form.Hidden({
                name: 'co_concepto_pago'
            });

            this.co_pago = new Ext.form.Hidden({
                name: 'co_pago'
            });

            this.fe_recibido_exp = new Ext.form.Hidden({
                name: 'fe_recibido_exp'
            });

            this.co_documento = new Ext.form.ComboBox({
                fieldLabel: 'Co documento',
                store: this.storeCO_DOCUMENTO,
                typeAhead: true,
                valueField: 'co_documento',
                displayField: 'inicial',
                hiddenName: 'fondo[co_documento]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 50,
                readOnly: true,
                style: 'background-color:#c9c9c9;',
                allowBlank: false
            });
            this.storeCO_DOCUMENTO.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_documento,
                value: (this.OBJ.co_documento == '') ? 4 : this.OBJ.co_documento,
                objStore: this.storeCO_DOCUMENTO
            });

            this.tx_rif = new Ext.form.TextField({
                name: 'fondo[tx_rif]',
                value: this.OBJ.tx_rif,
                allowBlank: false,
                readOnly: true,
                style: 'background-color:#c9c9c9;',
                width: 130
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
                name: 'fondo[tx_razon_social]',
                value: this.OBJ.tx_razon_social,
                allowBlank: false,
                readOnly: true,
                style: 'background-color:#c9c9c9;',
                width: 770
            });

            this.tx_direccion = new Ext.form.TextField({
                fieldLabel: 'Direccion',
                name: 'fondo[tx_direccion]',
                value: this.OBJ.tx_direccion,
                allowBlank: false,
                readOnly: true,
                style: 'background-color:#c9c9c9;',
                width: 770
            });


            this.fieldDatos = new Ext.form.FieldSet({
                title: 'Datos del Tramite',
                items: [
                    this.compositefieldCIRIF,
                    this.tx_razon_social,
                    this.tx_direccion,
                ]
            });


            function renderMonto(val, attr, record) {
                return paqueteComunJS.funcion.getNumeroFormateado(val);
            }

            this.botonReporte = new Ext.Button({
                text: 'Reporte',
                iconCls: 'icon-reporteVeh',
                handler: function() {

                    window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/ComprobanteCaja.php?codigo=' + cajaEditar.main.co_pago.getValue());

                }
            });
            this.botonReporte.setDisabled(true);
            this.gridPanel = new Ext.grid.EditorGridPanel({
                title: 'LISTA DE PAGOS (Doble Click para Editar)',
                iconCls: 'icon-libro',
                store: this.store_lista,
                loadMask: true,
                height: 230,
                width: 940,
                tbar: [
                    this.botonReporte
                ],
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'co_pago',
                        hidden: true,
                        width: 10,
                        menuDisabled: true,
                        dataIndex: 'co_detalle_fondo'
                    },
                    {
                        header: 'co_estatus_pago',
                        hidden: true,
                        width: 10,
                        menuDisabled: true,
                        dataIndex: 'co_estatus_pago'
                    },
                    {
                        header: 'co_concepto_pago',
                        hidden: true,
                        width: 10,
                        menuDisabled: true,
                        dataIndex: 'co_concepto_pago'
                    },
                    {
                        header: 'Foma de Pago',
                        hidden: false,
                        width: 130,
                        menuDisabled: true,
                        dataIndex: 'tx_forma_pago',
                        renderer: textoLargo,
                        editor: new Ext.form.ComboBox({
                            store: this.storeCO_FORMA_PAGO,
                            typeAhead: true,
                            valueField: 'co_forma_pago',
                            displayField: 'tx_forma_pago',
                            hiddenName: 'co_forma_pago',
                            forceSelection: true,
                            resizable: true,
                            triggerAction: 'all',
                            selectOnFocus: true,
                            mode: 'local',
                            width: 50,
                            allowBlank: false,
                            listeners: {
                                select: function(cmb, record, index) {
                                    cajaEditar.main.co_forma_pago.setValue(record.get('co_forma_pago'));
                                }
                            }
                        })
                    },
                    {
                        header: 'Banco',
                        hidden: false,
                        width: 130,
                        menuDisabled: true,
                        dataIndex: 'tx_banco',
                        renderer: textoLargo
                    },
                    {
                        header: 'N° Cheque/Transf.',
                        width: 110,
                        menuDisabled: true,
                        dataIndex: 'nu_pago',
                        renderer: textoLargo,
                        editor: new Ext.form.TextField({
                            allowBlank: false,
                            autoCreate: {
                                tag: "input",
                                type: "text",
                                autocomplete: "off",
                                maxlength: 200
                            },
                        })
                    },
                    {
                        header: 'Monto',
                        width: 160,
                        menuDisabled: true,
                        dataIndex: 'nu_monto',
                        renderer: renderMonto
                    },
                    {
                        header: 'Observación',
                        width: 150,
                        menuDisabled: true,
                        sortable: true,
                        dataIndex: 'tx_observacion',
                        renderer: textoLargo,
                        editor: new Ext.form.TextField({
                            allowBlank: false,
                            autoCreate: {
                                tag: "input",
                                type: "text",
                                autocomplete: "off",
                                maxlength: 200
                            },
                        })

                    },

                    {
                        header: 'Estatus',
                        width: 100,
                        menuDisabled: true,
                        dataIndex: 'tx_estatus_pago',
                        renderer: textoLargo,
                        editor: new Ext.form.ComboBox({
                            store: this.storeCO_ESTATUS_PAGO,
                            typeAhead: true,
                            valueField: 'co_estatus_pago',
                            displayField: 'tx_estatus_pago',
                            hiddenName: 'co_estatus_pago',
                            forceSelection: true,
                            resizable: true,
                            triggerAction: 'all',
                            selectOnFocus: true,
                            mode: 'local',
                            width: 50,
                            allowBlank: false,
                            listeners: {
                                select: function(cmb, record, index) {
                                    cajaEditar.main.co_estatus_pago.setValue(record.get('co_estatus_pago'));
                                }
                            }
                        })
                    },
                    {
                        header: 'Concepto',
                        width: 120,
                        menuDisabled: true,
                        dataIndex: 'tx_concepto_pago',
                        renderer: textoLargo,
                        editor: new Ext.form.ComboBox({
                            store: this.storeCO_CONCEPTO_PAGO,
                            typeAhead: true,
                            valueField: 'co_concepto_pago',
                            displayField: 'tx_concepto_pago',
                            hiddenName: 'co_concepto_pago',
                            forceSelection: true,
                            resizable: true,
                            triggerAction: 'all',
                            selectOnFocus: true,
                            mode: 'local',
                            width: 50,
                            allowBlank: false,
                            listeners: {
                                select: function(cmb, record, index) {
                                    cajaEditar.main.co_concepto_pago.setValue(record.get('co_concepto_pago'));
                                }
                            }
                        })

                    }, //********NUEVO CAMPO********* */

                    {
                        header: 'Fecha de Recibido del Expediente',
                        width: 150,
                        menuDisabled: true,
                        dataIndex: 'fe_recibido_exp',
                        renderer: textoLargo,
                        editor: new Ext.form.DateField({
                            id: 'fe_recibido_exp',
                            name: 'fe_recibido_exp',
                            format: 'Y-m-d',
                            valueField: 'fe_recibido_exp',
                            displayField: 'fe_recibido_exp',
                            hiddenName: 'fe_recibido_exp',
                            allowBlank: false


                        })
                    }

                ],
                stripeRows: true,
                autoScroll: true,
                stateful: true,
                listeners: {
                    cellclick: function(Grid, rowIndex, columnIndex, e) {
                        cajaEditar.main.co_pago.setValue(cajaEditar.main.store_lista.getAt(rowIndex).get('co_pago'));
                        if (cajaEditar.main.store_lista.getAt(rowIndex).get('co_estatus_pago') == 1) {
                            cajaEditar.main.botonReporte.enable();
                        } else {
                            cajaEditar.main.botonReporte.disable();
                        }
                    }
                }
            });
            this.gridPanel.on('afteredit', this.afterEdit, this);
            cajaEditar.main.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
            this.store_lista.load();
            this.storeCO_ESTATUS_PAGO.load();
            this.storeCO_FORMA_PAGO.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_estatus_pago,
                value: this.OBJ.co_estatus_pago,
                objStore: this.storeCO_ESTATUS_PAGO
            });

            this.storeCO_CONCEPTO_PAGO.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_concepto_pago,
                value: this.OBJ.co_concepto_pago,
                objStore: this.storeCO_CONCEPTO_PAGO
            });

            this.fieldGrid = new Ext.form.FieldSet({
                //title: 'Datos de los Materiales',
                items: [
                    this.gridPanel

                ]
            });


            this.salir = new Ext.Button({
                text: 'Salir',
                iconCls: 'icon-cancelar',
                handler: function() {
                    cajaEditar.main.winformPanel_.close();
                }
            });

            this.formPanel_ = new Ext.form.FormPanel({
                frame: true,
                width: 1000,
                height: 600,
                autoScroll: true,
                bodyStyle: 'padding:10px;',
                items: [

                    this.co_solicitud,
                    this.fieldDatos,
                    this.fieldGrid
                ]
            });

            this.winformPanel_ = new Ext.Window({
                title: 'Caja',
                modal: true,
                constrain: true,
                width: 1000,
                frame: true,
                closabled: true,
                height: 500,
                items: [
                    this.formPanel_

                ],
                buttons: [
                    this.salir
                ],
                buttonAlign: 'center'
            });
            this.winformPanel_.show();

        },getStoreCO_FORMA_PAGO: function(){
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Caja/storefkcoformapago',
                root: 'data',
                fields: [{
                        name: 'co_forma_pago'
                    },
                    {
                        name: 'tx_forma_pago'
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_DOCUMENTO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Caja/storefkcodocumento',
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
        getStoreCO_ESTATUS_PAGO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Caja/storefkcoestatuspago',
                root: 'data',
                fields: [{
                        name: 'co_estatus_pago'
                    },
                    {
                        name: 'tx_estatus_pago'
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_CONCEPTO_PAGO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Caja/storefkcoconceptopago',
                root: 'data',
                fields: [{
                        name: 'co_concepto_pago'
                    },
                    {
                        name: 'tx_concepto_pago'
                    }
                ]
            });
            return this.store;
        },
        getLista: function() {

            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Caja/storelista',
                root: 'data',
                fields: [{
                        name: 'co_pago'
                    },
                    {
                        name: 'co_estatus_pago'
                    },
                    {
                        name: 'co_concepto_pago'
                    },
                    {
                        name: 'tx_estatus_pago'
                    },
                    {
                        name: 'tx_concepto_pago'
                    },
                    {
                        name: 'co_forma_pago'
                    },
                    {
                        name: 'tx_forma_pago'
                    },
                    {
                        name: 'tx_banco'
                    },
                    {
                        name: 'tx_cuenta_bancaria'
                    },
                    {
                        name: 'tx_observacion'
                    },
                    {
                        name: 'nu_pago'
                    },
                    {
                        name: 'nu_monto'
                    },
                    {
                        name: 'fe_recibido_exp'
                    },
                ]
            });
            return this.store;
        },
        afterEdit: function(e) {
            var recordsToSend = [];

            recordsToSend = Ext.encode(e.record.data);

            this.gridPanel.el.mask("Guardando...", "x-mask-loading");
            Ext.Ajax.request({
                scope: this,
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Caja/editarPago',
                params: {
                    variables: recordsToSend,
                    co_estatus_pago: cajaEditar.main.co_estatus_pago.getValue(),
                    co_forma_pago: cajaEditar.main.co_forma_pago.getValue(),
                    co_concepto_pago: cajaEditar.main.co_concepto_pago.getValue(),
                    co_solicitud: cajaEditar.main.co_solicitud.getValue(),
                    fe_recibido_exp: cajaEditar.main.fe_recibido_exp.getValue()
                },
                success: this.onSuccess
            });
        },
        onSuccess: function(response, options) {
            this.gridPanel.el.unmask();
            this.gridPanel.getStore().load();
            this.gridPanel.getView().refresh();
            cajaEditar.main.botonReporte.disable();
            Detalle.main.store_lista.load();
        }
    };
    Ext.onReady(cajaEditar.main.init, cajaEditar.main);
</script>
<div id="formularioAgregar"></div>