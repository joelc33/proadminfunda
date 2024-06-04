<script type="text/javascript">
    Ext.ns("PagoNominaEditar");
    PagoNominaEditar.main = {
        init: function() {

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });
            //<Stores de fk>
            this.storeCO_TIPO_TRABAJADOR = this.getStoreCO_TIPO_TRABAJADOR();
            this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();
            this.storeCO_TIPO_NOMINA = this.getStoreCO_TIPO_NOMINA();
            this.store_lista = this.getLista();

            //<ClavePrimaria>
            this.co_pago_nomina = new Ext.form.Hidden({
                name: 'co_pago_nomina',
                value: this.OBJ.co_pago_nomina
            });
            //</ClavePrimaria>

            this.co_solicitud = new Ext.form.Hidden({
                name: 'tb122_pago_nomina[co_solicitud]',
                value: this.OBJ.co_solicitud
            });

            this.co_ejecutor = new Ext.form.ComboBox({
                fieldLabel: 'Ente Ejecutor',
                store: this.storeCO_EJECUTOR,
                typeAhead: true,
                valueField: 'id',
                id: 'co_ejecutor',
                displayField: 'ejecutor',
                hiddenName: 'tb122_pago_nomina[co_ejecutor]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 600,
                allowBlank: false,
                //readOnly:true,
                /*style:'background:#c9c9c9;',
                listeners: {
                    getSelectedIndex: function() {
                        var v = this.getValue();
                        var r = this.findRecord(this.valueField || this.displayField, v);
                        return(this.storeCO_EJECUTOR.indexOf(r));
                    }
                }*/
            });
            this.storeCO_EJECUTOR.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_ejecutor,
                value: this.OBJ.co_ejecutor,
                objStore: this.storeCO_EJECUTOR
            });

            this.nu_monto = new Ext.form.TextField({
                fieldLabel: 'Monto Cargado',
                name: 'tb122_pago_nomina[mo_nomina]',
                value: (this.OBJ.mo_nomina != null) ? paqueteComunJS.funcion.getNumeroFormateado(this.OBJ.mo_nomina) : this.OBJ.mo_nomina,
                readOnly: true,
                style: 'background:#c9c9c9;',
                allowBlank: false,
                width: 200
            });


            this.co_tipo_trabajador = new Ext.form.ComboBox({
                fieldLabel: 'Tipo Trabajador',
                store: this.storeCO_TIPO_TRABAJADOR,
                typeAhead: true,
                valueField: 'co_tipo_trabajador',
                displayField: 'tx_tipo_trabajador',
                hiddenName: 'tb122_pago_nomina[co_tipo_trabajador]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione...',
                selectOnFocus: true,
                mode: 'local',
                width: 200,
                resizable: true,
                allowBlank: false
            });
            this.storeCO_TIPO_TRABAJADOR.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_tipo_trabajador,
                value: this.OBJ.co_tipo_trabajador,
                objStore: this.storeCO_TIPO_TRABAJADOR
            });

            this.co_tipo_nomina = new Ext.form.ComboBox({
                fieldLabel: 'Tipo Nomina',
                store: this.storeCO_TIPO_NOMINA,
                typeAhead: true,
                valueField: 'co_tipo_nomina',
                displayField: 'tx_tipo_nomina',
                hiddenName: 'tb122_pago_nomina[co_tipo_nomina]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione...',
                selectOnFocus: true,
                mode: 'local',
                width: 200,
                resizable: true,
                allowBlank: false
            });
            this.storeCO_TIPO_NOMINA.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_tipo_nomina,
                value: this.OBJ.co_tipo_nomina,
                objStore: this.storeCO_TIPO_NOMINA
            });

            this.tx_concepto = new Ext.form.TextArea({
                fieldLabel: 'Concepto',
                name: 'tb122_pago_nomina[tx_concepto]',
                value: this.OBJ.tx_concepto,
                allowBlank: false,
                style: 'background:#c9c9c9;',
                allowBlank: false,
                width: 530
            });

            this.fe_pago = new Ext.form.DateField({
                fieldLabel: 'Fecha de Pago',
                name: 'tb122_pago_nomina[fe_pago]',
                value: this.OBJ.fe_pago,
                allowBlank: false,
                width: 100,
                minValue: this.OBJ.fe_ini,
                maxValue: this.OBJ.fe_fin,
            });

            this.nu_monto_nomina = new Ext.form.TextField({
                fieldLabel: 'Monto Nomina',
                name: 'tb122_pago_nomina[mo_nomina]',
                value: paqueteComunJS.funcion.getNumeroFormateado(this.OBJ.mo_total),
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 200
            });

            this.nu_diferencia = new Ext.form.TextField({
                fieldLabel: 'Diferencia',
                name: 'tb122_pago_nomina[mo_diferencia]',
                value: paqueteComunJS.funcion.getNumeroFormateado(this.OBJ.mo_diferencia),
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 200
            });



            this.fieldPago = new Ext.form.FieldSet({
                title: 'Datos de la Nomina',
                items: [this.co_pago_nomina,
                    this.co_ejecutor,
                    this.nu_monto,
                    this.co_solicitud,
                    this.tx_concepto,
                    this.fe_pago,
                    this.co_tipo_trabajador,
                    this.co_tipo_nomina,
                    this.nu_monto_nomina,
                    this.nu_diferencia
                ]
            });

            this.fieldDocumento = new Ext.form.FieldSet({
                title: 'Archivo Txt',
                items: [{
                    xtype: 'fileuploadfield',
                    style: "padding-right:330px",
                    id: 'form-file',
                    emptyText: 'Seleccione un archivo',
                    fieldLabel: 'Archivo (txt)',
                    name: 'form-file',
                    buttonText: 'Buscar'
                }]
            });




            this.guardar = new Ext.Button({
                text: 'Guardar',
                iconCls: 'icon-guardar',
                handler: function() {

                    if (!PagoNominaEditar.main.formPanel_.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
                        return false;
                    }
                    PagoNominaEditar.main.formPanel_.getForm().submit({
                        method: 'POST',
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/guardar',
                        waitMsg: 'Enviando datos, por favor espere..',
                        waitTitle: 'Enviando',
                        failure: function(form, action) {
                            Ext.MessageBox.alert('Error en transacción', action.result.msg);

                            //                PagoNominaEditar.main.nu_monto_nomina.setValue(action.result.monto);
                            //                PagoNominaEditar.main.nu_diferencia.setValue(action.result.diferencia);                
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

                                PagoNominaEditar.main.nu_monto_nomina.setValue(paqueteComunJS.funcion.getNumeroFormateado(action.result.monto));
                                PagoNominaEditar.main.nu_diferencia.setValue(paqueteComunJS.funcion.getNumeroFormateado(action.result.diferencia));

                                PagoNominaEditar.main.store_lista.baseParams.co_solicitud = PagoNominaEditar.main.OBJ.co_solicitud;
                                PagoNominaEditar.main.store_lista.load();

                                pendienteEntidadesLista.main.store_lista.baseParams.paginar = 'si';
                                pendienteEntidadesLista.main.store_lista.load();
                                pendienteEntidadesLista.main.store_lista.on('load', function() {
                                    pendienteEntidadesLista.main.estado.disable();
                                    pendienteEntidadesLista.main.revision.disable();
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
                    PagoNominaEditar.main.winformPanel_.close();
                }
            });

            function renderMonto(val, attr, record) {
                return paqueteComunJS.funcion.getNumeroFormateado(val);
            }

            this.gridPanel = new Ext.grid.GridPanel({
                title: 'Lista',
                iconCls: 'icon-libro',
                store: this.store_lista,
                loadMask: true,
                height: 150,
                width: 770,
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'Cant',
                        width: 100,
                        menuDisabled: true,
                        dataIndex: 'cant'
                    },
                    {
                        header: 'Banco',
                        width: 420,
                        menuDisabled: true,
                        dataIndex: 'tx_banco',
                        renderer: textoLargo
                    },
                    {
                        header: 'Monto',
                        width: 200,
                        menuDisabled: true,
                        dataIndex: 'total',
                        renderer: renderMonto
                    }
                ],
                stripeRows: true,
                autoScroll: true,
                stateful: true
            });

            this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
            this.store_lista.load();

            this.formPanel_ = new Ext.form.FormPanel({
                fileUpload: true,
                frame: true,
                width: 800,
                autoHeight: true,
                autoScroll: true,
                bodyStyle: 'padding:10px;',
                items: [this.fieldPago,
                    this.fieldDocumento,
                    this.gridPanel
                ]
            });

            this.winformPanel_ = new Ext.Window({
                title: 'Pago Nomina',
                modal: true,
                constrain: true,
                width: 800,
                frame: true,
                closabled: true,
                autoHeight: true,
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
            //PagoNominaLista.main.mascara.hide();
        },
        getLista: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storelistaNomina',
                root: 'data',
                fields: [{
                        name: 'cant'
                    },
                    {
                        name: 'tx_banco'
                    },
                    {
                        name: 'total'
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_TIPO_TRABAJADOR: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storefkcotipotrabajador',
                root: 'data',
                fields: [{
                        name: 'co_tipo_trabajador'
                    },
                    {
                        name: 'tx_tipo_trabajador'
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_TIPO_NOMINA: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storefkcotiponomina',
                root: 'data',
                fields: [{
                        name: 'co_tipo_nomina'
                    },
                    {
                        name: 'tx_tipo_nomina'
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_EJECUTOR: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storefkcoejecutor',
                root: 'data',
                fields: [{
                        name: 'id'
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
        }
    };
    Ext.onReady(PagoNominaEditar.main.init, PagoNominaEditar.main);
</script>