<script type="text/javascript">
    Ext.ns("TransferenciaEditar");
    TransferenciaEditar.main = {
        init: function() {

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });

            //<ClavePrimaria>
            this.storeCO_TIPO_RETENCION = this.getStoreCO_TIPO_RETENCION();
            this.storeCO_CUENTA_BANCARIA_DEBITAR = this.getStoreCO_CUENTA_BANCARIA();
            this.storeCO_CUENTA_BANCARIA_CREDITAR = this.getStoreCO_CUENTA_BANCARIA();
            this.storeCO_BANCO = this.getStoreCO_BANCO();
            this.monto_disponible = 0;


            this.co_transferencia_cuenta = new Ext.form.Hidden({
                name: 'co_transferencia_cuenta',
                value: this.OBJ.co_transferencia_cuenta
            });

            this.co_cuenta_debita = new Ext.form.Hidden({
                name: 'co_cuenta_debitar',
                value: this.OBJ.co_cuenta_debitar
            });

            this.co_solicitud = new Ext.form.Hidden({
                name: 'co_solicitud',
                value: this.OBJ.co_solicitud
            });

            this.co_cuenta_creditar = new Ext.form.Hidden({
                name: 'co_cuenta_creditar',
                value: this.OBJ.co_cuenta_credito
            });

                    

            this.saldo_disponible = new Ext.form.Hidden({
                name: 'saldo_disponible',
                value: this.OBJ.saldo_disponible
            });

            this.in_fondo_tercero = new Ext.form.Hidden({
                name: 'in_fondo_tercero',
                value: this.OBJ.in_fondo_tercero
            });

            this.tx_cuenta_debitar = new Ext.form.TextField({
                fieldLabel: 'Cuenta Contable',
                name: 'tx_cuenta_debitar',
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 200,
                value: this.OBJ.tx_cuenta_debitar
            });


            this.fecha = new Ext.form.DateField({
                    fieldLabel:'Fecha',
                    name:'fecha',
                    allowBlank:false,
                    width:100,
                    maxValue:new Date()  
            });

            this.tx_cuenta_bancaria_debitar = new Ext.form.TextField({
                fieldLabel: 'Cuenta Bancaria',
                name: 'tx_cuenta_bancaria_debitar',
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 200,
                value: this.OBJ.tx_cuenta_bancaria_debitar
            });

            this.mo_debitar = new Ext.form.NumberField({
                fieldLabel: 'Monto',
                name: 'mo_debitar',
                width: 200,
                value: this.OBJ.mo_debitar
            });

            this.buscar_debitar = new Ext.Button({
                text: 'Buscar',
                handler: function() {
                    this.msg = Ext.get('formulario');
                    this.msg.load({
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TransferenciaCuenta/buscarDebitar',
                        scripts: true,
                        text: "Cargando.."
                    });
                }
            });


            this.compositefieldDebitar = new Ext.form.CompositeField({
                fieldLabel: 'Cuenta Contable',
                items: [
                    this.tx_cuenta_debitar,
                    this.buscar_debitar
                ]
            });

            this.banco_debitar = new Ext.form.ComboBox({
                fieldLabel: 'Banco',
                store: this.storeCO_BANCO,
                typeAhead: true,
                valueField: 'co_banco',
                displayField: 'tx_banco',
                hiddenName: 'co_banco_debitar',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione Banco...',
                selectOnFocus: true,
                mode: 'local',
                width: 300,
                resizable: true,
                allowBlank: false,
                listeners: {
                    select: function() {
                        TransferenciaEditar.main.cuenta_bancaria_debitar.clearValue();
                        TransferenciaEditar.main.storeCO_CUENTA_BANCARIA_DEBITAR.load({
                            params: {
                                banco: this.getValue()
                            }
                        })
                    }
                }
            });

            this.storeCO_BANCO.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.banco_debitar,
                value: this.OBJ.co_banco_debitar,
                objStore: this.storeCO_BANCO
            });

            this.cuenta_bancaria_debitar = new Ext.form.ComboBox({
                fieldLabel: 'Cuenta Bancaria',
                store: this.storeCO_CUENTA_BANCARIA_DEBITAR,
                typeAhead: true,
                valueField: 'co_cuenta_bancaria',
                displayField: 'cuenta',
                hiddenName: 'co_cuenta_bancaria_debitar',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione Cuenta Bancaria...',
                selectOnFocus: true,
                mode: 'local',
                width: 300,
                resizable: true,
                allowBlank: false,
                listeners: {
					select: function() {
						TransferenciaEditar.main.cargarDisponible('debito',this.getValue());
					}
				}
            });

            if (this.OBJ.co_banco_debitar != '') {               
                TransferenciaEditar.main.storeCO_CUENTA_BANCARIA_DEBITAR.load({
                    params: {
                        banco: TransferenciaEditar.main.OBJ.co_banco_debitar
                    },
                    callback: function() {
                        TransferenciaEditar.main.cuenta_bancaria_debitar.setValue(TransferenciaEditar.main.OBJ.co_cuenta_bancaria_debitar);
                    }
                })
            }


            this.tx_descripcion_debitar = new Ext.form.TextField({
                fieldLabel: 'Descripción',
                name: 'tx_descripcion_debitar',
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 600,
                value: this.OBJ.tx_descripcion_debitar
            });

            this.tx_banco_debitar = new Ext.form.TextField({
                fieldLabel: 'Banco',
                name: 'tx_banco_debitar',
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 400,
                value: this.OBJ.tx_banco_debitar
            });


            /************************CUENTAS A ACREDITAR******************************/


            this.tx_cuenta_bancaria_creditar = new Ext.form.TextField({
                fieldLabel: 'Cuenta Bancaria',
                name: 'tx_cuenta_bancaria_creditar',
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 200,
                value: this.OBJ.tx_cuenta_bancaria_creditar
            });

            this.nu_saldo_debitar = new Ext.form.TextField({
                fieldLabel: 'Saldo Disponible',
                name: 'nu_saldo_debitar',
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 200,
                value: this.OBJ.nu_saldo_debitar
            });

            this.tx_cuenta_creditar = new Ext.form.TextField({
                fieldLabel: 'Cuenta Contable',
                name: 'tx_cuenta_creditar',
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 200,
                value: this.OBJ.tx_cuenta_creditar
            });

            this.buscar_creditar = new Ext.Button({
                text: 'Buscar',
                handler: function() {
                    this.msg = Ext.get('formulario');
                    this.msg.load({
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TransferenciaCuenta/buscarCreditar',
                        scripts: true,
                        text: "Cargando.."
                    });
                }
            });

            this.compositefieldCreditar = new Ext.form.CompositeField({
                fieldLabel: 'Cuenta Contable',
                items: [
                    this.tx_cuenta_creditar,
                    this.buscar_creditar
                ]
            });

            this.tx_descripcion_creditar = new Ext.form.TextField({
                fieldLabel: 'Descripción',
                readOnly: true,
                style: 'background:#c9c9c9;',
                name: 'tx_descripcion_creditar',
                width: 600,
                value: this.OBJ.tx_descripcion_creditar
            });

            this.tx_banco_creditar = new Ext.form.TextField({
                fieldLabel: 'Banco',
                name: 'tx_banco_creditar',
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 400,
                value: this.OBJ.tx_banco_creditar
            });


            this.banco_creditar = new Ext.form.ComboBox({
                fieldLabel: 'Banco',
                store: this.storeCO_BANCO,
                typeAhead: true,
                valueField: 'co_banco',
                displayField: 'tx_banco',
                hiddenName: 'co_banco_creditar',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione Banco...',
                selectOnFocus: true,
                mode: 'local',
                width: 300,
                resizable: true,
                allowBlank: false,
                listeners: {
                    select: function() {
                        TransferenciaEditar.main.cuenta_bancaria_creditar.clearValue();
                        TransferenciaEditar.main.storeCO_CUENTA_BANCARIA_CREDITAR.load({
                            params: {
                                banco: this.getValue()
                            }
                        })
                    }
                }
            });

           
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.banco_creditar,
                value: this.OBJ.co_banco_creditar,
                objStore: this.storeCO_BANCO
            });

            
            this.cuenta_bancaria_creditar = new Ext.form.ComboBox({
                fieldLabel: 'Cuenta Bancaria',
                store: this.storeCO_CUENTA_BANCARIA_CREDITAR,
                typeAhead: true,
                valueField: 'co_cuenta_bancaria',
                displayField: 'cuenta',
                hiddenName: 'co_cuenta_bancaria_creditar',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione Cuenta Bancaria...',
                selectOnFocus: true,
                mode: 'local',
                width: 300,
                resizable: true,
                allowBlank: false,
                listeners: {
                    select: function() {
                        TransferenciaEditar.main.cargarDisponible('credito',this.getValue());
                    }
                }
            });

            if (this.OBJ.co_banco_creditar != '') {               
                TransferenciaEditar.main.storeCO_CUENTA_BANCARIA_CREDITAR.load({
                    params: {
                        banco: TransferenciaEditar.main.OBJ.co_banco_creditar
                    },
                    callback: function() {
                        TransferenciaEditar.main.cuenta_bancaria_creditar.setValue(TransferenciaEditar.main.OBJ.co_cuenta_bancaria_creditar);
                    }
                })
            }


            this.nu_saldo_creditar = new Ext.form.TextField({
                fieldLabel: 'Saldo Disponible',
                name: 'nu_saldo_creditar',
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 200,
                value: this.OBJ.nu_saldo_creditar
            });

            this.tx_concepto = new Ext.form.TextArea({
                fieldLabel: 'Descripcion',
                name: 'tx_concepto',
                allowBlank: false,
                value:this.OBJ.tx_observacion,
                width: 500
            });

            this.co_tipo_retencion = new Ext.form.ComboBox({
                fieldLabel: 'Fondo Tercero',
                store: this.storeCO_TIPO_RETENCION,
                typeAhead: true,
                valueField: 'co_tipo_retencion',
                displayField: 'tx_tipo_retencion',
                hiddenName: 'co_tipo_retencion',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 500
            });
            if (TransferenciaEditar.main.OBJ.co_tipo_retencion == null) {
                this.co_tipo_retencion.hide();
            } else {
                this.co_tipo_retencion.show();
            }
            this.storeCO_TIPO_RETENCION.load({
                callback: function() {
                    TransferenciaEditar.main.co_tipo_retencion.setValue(TransferenciaEditar.main.OBJ.co_tipo_retencion);
                }
            });

            this.fieldDatosDebitar = new Ext.form.FieldSet({
                title: 'Cuenta Contable a Debitar',
                items: [this.saldo_disponible,
                    this.banco_debitar,
                    this.cuenta_bancaria_debitar,
                    this.tx_cuenta_debitar,
                    this.nu_saldo_debitar,
                    this.mo_debitar,
                    this.fecha,
                    this.co_cuenta_debita                    
                ]
            });

            this.fieldDatosAcreditar = new Ext.form.FieldSet({
                title: 'Cuenta Contable a Creditar',
                items: [this.banco_creditar,
                    this.cuenta_bancaria_creditar,
                    this.tx_cuenta_creditar,
                    this.nu_saldo_creditar,
                    this.co_cuenta_creditar,
                    this.co_tipo_retencion,
                    this.tx_concepto
                    ]
            });


            this.guardar = new Ext.Button({
                text: 'Guardar',
                iconCls: 'icon-guardar',
                handler: function() {

                    var saldo_disponible = TransferenciaEditar.main.saldo_disponible.getValue();
                    var monto = TransferenciaEditar.main.mo_debitar.getValue();

                    var co_cuenta_debitar = TransferenciaEditar.main.cuenta_bancaria_debitar.getValue();
                    var co_cuenta_creditar = TransferenciaEditar.main.cuenta_bancaria_creditar.getValue();
                    var in_fondo_tercero = TransferenciaEditar.main.in_fondo_tercero.getValue();
                    var co_tipo_retencion = TransferenciaEditar.main.co_tipo_retencion.getValue();

                    if (co_cuenta_debitar == undefined) {
                        Ext.MessageBox.alert('Error en transacción', 'Debe seleccionar una cuenta a debitar');
                        return false;
                    }

                    if (co_cuenta_creditar == undefined) {
                        Ext.MessageBox.alert('Error en transacción', 'Debe seleccionar una cuenta a creditar');
                        return false;
                    }

                    if (monto == '') {
                        Ext.MessageBox.alert('Error en transacción', 'Debe ingresar el monto a transferir');
                        return false;
                    }


                    if (in_fondo_tercero == true) {
                        if (co_tipo_retencion == '') {
                            Ext.MessageBox.alert('Error en transacción', 'Debe Seleccionar el Fondo de Tercero');
                            return false;
                        }
                    }

                    if(co_cuenta_debitar == co_cuenta_creditar){
                        Ext.MessageBox.alert('Error en transacción', 'Las cuentas bancarias de debito y credio no pueden ser las mismas, por favor verifique!');
                        return false;
                    }

                    if (!TransferenciaEditar.main.formPanel_.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
                        return false;
                    }

                    if (monto > TransferenciaEditar.main.monto_disponible) {
                        Ext.Msg.alert("Alerta", "El monto a debitar no puede ser mayor al saldo disponible!");
                        return false;
                    }

                    TransferenciaEditar.main.formPanel_.getForm().submit({
                        method: 'POST',
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TransferenciaCuenta/guardar',
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

                            TransferenciaEditar.main.winformPanel_.close();
                        }
                    });


                }
            });

            this.salir = new Ext.Button({
                text: 'Salir',
                //    iconCls: 'icon-cancelar',
                handler: function() {
                    TransferenciaEditar.main.winformPanel_.close();
                }
            });


            this.formPanel_ = new Ext.form.FormPanel({
                frame: true,
                width: 790,
                autoHeight: true,
                autoScroll: true,
                bodyStyle: 'padding:10px;',
                items: [
                    this.co_transferencia_cuenta,
                    this.co_solicitud,                   
                    this.fieldDatosDebitar,
                    this.fieldDatosAcreditar
                ]
            });



            this.winformPanel_ = new Ext.Window({
                title: 'Transferencia entre Cuenta',
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

        },
		cargarDisponible: function(tipo,co_cuenta) {
			Ext.Ajax.request({
				method: 'GET',
				url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TransferenciaCuenta/cargarDisponible',
				params: {
					id: co_cuenta
				},
				success: function(result, request) {
					obj = Ext.util.JSON.decode(result.responseText);

                    if(tipo == 'debito'){
					    TransferenciaEditar.main.nu_saldo_debitar.setValue(paqueteComunJS.funcion.getNumeroFormateado(obj.data.mo_disponible));
                        TransferenciaEditar.main.monto_disponible = obj.data.mo_disponible;
                        TransferenciaEditar.main.tx_cuenta_debitar.setValue(obj.data.nu_cuenta_contable);
                        TransferenciaEditar.main.co_cuenta_debita.setValue(obj.data.co_cuenta_contable);
                    }else{
                        TransferenciaEditar.main.nu_saldo_creditar.setValue(paqueteComunJS.funcion.getNumeroFormateado(obj.data.mo_disponible));
                        TransferenciaEditar.main.tx_cuenta_creditar.setValue(obj.data.nu_cuenta_contable);
                        TransferenciaEditar.main.co_cuenta_creditar.setValue(obj.data.co_cuenta_contable);
                    }
				}
			});
		},
        getStoreCO_TIPO_RETENCION() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TransferenciaCuenta/storefkcotiporetencion',
                root: 'data',
                fields: [{
                        name: 'co_tipo_retencion'
                    },
                    {
                        name: 'tx_tipo_retencion'
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_CUENTA_BANCARIA: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/storefkidtb011cuentabancaria',
                root: 'data',
                fields: [{
                        name: 'co_cuenta_bancaria'
                    },
                    {
                        name: 'tx_cuenta_bancaria'
                    },
                    {
                        name: 'tx_descripcion'
                    },
                    {
                        name: 'cuenta',
                        convert: function(v, r) {
                            return r.tx_cuenta_bancaria + ' - ' + r.tx_descripcion;
                        }
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_BANCO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/storefkidtb010banco',
                root: 'data',
                fields: [{
                        name: 'co_banco'
                    },
                    {
                        name: 'tx_banco'
                    }
                ]
            });
            return this.store;
        }
    };
    Ext.onReady(TransferenciaEditar.main.init, TransferenciaEditar.main);
</script>
<div id="formulario"></div>