<script type="text/javascript">
    Ext.ns('recaudacion');
    recaudacion.formulario = {

        init: function () {
            this.store_lista_pagos = this.getListaPagos();
            //this.restante = this.OBJ.mo_valor_restante;

            this.OBJ = paqueteComunJS.funcion.doJSON({ stringData: '<?php echo $data ?>' });

            this.store_forma_pago = this.getDataFormaPago();
            this.store_banco = this.getDataBanco();
            this.store_cuenta = this.getDataCuenta();
            this.store_fe_ingreso = this.getDatafe_ingreso();
            this.store_tipo_documento = this.getDataTipoDocumento();
            this.storeID_INGRESO = this.getStoreID_INGRESO();
            this.storeID_PARTIDA_INGRESO = this.getStoreID_PARTIDA_INGRESO();

            this.store_banco.load();
            this.store_forma_pago.load();
            this.store_lista_pagos.baseParams.co_liquidacion_pago = '<?php echo $co_liquidacion_pago; ?>';
            this.store_lista_pagos.load({
                callback: function () {
                    recaudacion.formulario.getTotal();
                }
            });
            this.co_solicitud = new Ext.form.Hidden({
                name: 'co_solicitud',
                width: '150px',
                readOnly: true,
                value: '<?php echo $co_solicitud; ?>'

            });
            this.co_cheque = new Ext.form.Hidden({
                name: 'Pagos[co_cheque]',
                width: '150px',
                readOnly: true,
                value: ''

            });

            this.co_tipo_solicitud = new Ext.form.Hidden({
                name: 'co_tipo_solicitud',
                width: '150px',
                readOnly: true,
                value: '<?php echo $co_tipo_solicitud; ?>'

            });

            this.hiddenJsonPago = new Ext.form.Hidden({
                name: 'co_liquidacion_pago'

            });

            this.in_posteo = new Ext.form.Hidden({
                name: 'in_posteo',
                value: 0

            });

            this.id_tb155_cuenta_bancaria_historico = new Ext.form.Hidden({
                name: 'tb148_cuenta_cobrar_pago[id_tb155_cuenta_bancaria_historico]',
                value: ''

            });

            //<ClavePrimaria>
            this.id_tb145_cuenta_cobrar_detalle = new Ext.form.Hidden({
                name: 'tb148_cuenta_cobrar_pago[id_tb145_cuenta_cobrar_detalle]',
                value: this.OBJ.id
            });
            //</ClavePrimaria>

            this.nu_orden = new Ext.form.TextField({
                fieldLabel: 'Nro. Solicitud',
                name: 'Pagos[tx_serial]',
                style: 'background:#DDDDDD;',
                width: '150px',
                readOnly: true,
                value: '<?php echo $co_solicitud; ?>'

            });

            this.fe_ingreso = new Ext.form.DateField({
                name: 'tb148_cuenta_cobrar_pago[fe_ingreso]',
                format: 'd-m-Y',
                fieldLabel: 'Fecha Ingreso',
                allowBlank: false,
                width: 100,
                maxValue: new Date()
            });

            this.fe_registro = new Ext.form.DateField({
                name: 'tb148_cuenta_cobrar_pago[fe_registro]',
                format: 'd-m-Y',
                fieldLabel: 'Fecha Registro (Decreto/Ley)',
                allowBlank: false,
                width: 100
            });

            this.forma_pago = new Ext.form.ComboBox({
                fieldLabel: 'Forma de Pago',
                displayField: 'tx_forma_pago',
                store: this.store_forma_pago,
                typeAhead: true,
                valueField: 'co_forma_pago',
                hiddenName: 'tb148_cuenta_cobrar_pago[id_tb074_forma_pago]',
                name: 'co_forma_pago',
                triggerAction: 'all',
                emptyText: 'Seleccione la forma de pago',
                selectOnFocus: true,
                allowBlank: false,
                width: 350,
                resizable: true
            });

            this.tipo_documento = new Ext.form.ComboBox({
                fieldLabel: 'Tipo Doc.',
                displayField: 'de_tipo_documento_cuenta',
                store: this.store_tipo_documento,
                typeAhead: true,
                valueField: 'id',
                hiddenName: 'tb148_cuenta_cobrar_pago[id_tb153_tipo_documento_cuenta]',
                name: 'id_tb153_tipo_documento_cuenta',
                triggerAction: 'all',
                emptyText: 'Seleccione Tipo de Documento',
                selectOnFocus: true,
                allowBlank: false,
                width: 350,
                resizable: true
            });

            this.banco = new Ext.form.ComboBox({
                fieldLabel: 'Banco',
                displayField: 'tx_banco',
                store: this.store_banco,
                typeAhead: true,
                valueField: 'co_banco',
                hiddenName: 'tb148_cuenta_cobrar_pago[id_tb010_banco]',
                name: 'co_banco',
                id: 'co_banco',
                triggerAction: 'all',
                emptyText: 'Seleccione el Banco',
                selectOnFocus: true,
                width: 350,
                resizable: true
            });

            this.cuenta = new Ext.form.ComboBox({
                fieldLabel: 'Cuenta',
                displayField: 'tx_cuenta_bancaria',
                store: this.store_cuenta,
                typeAhead: true,
                valueField: 'co_cuenta_bancaria',
                hiddenName: 'tb148_cuenta_cobrar_pago[id_tb011_cuenta_bancaria]',
                name: 'co_cuenta',
                id: 'co_cuenta',
                triggerAction: 'all',
                emptyText: 'Seleccione la Cuenta',
                selectOnFocus: true,
                mode: 'local',
                width: 350,
                resizable: true,
                //	listeners:{
                //		select: function(){
                //			recaudacion.formulario.id_tb155_cuenta_bancaria_historico.clearValue();
                //			recaudacion.formulario.storeID_INGRESO.load({
                //				params: {
                //					cuenta:this.getValue()
                //				}
                //			})
                //		}
                //  	}
            });

            function renderMonto(val, attr, record) {
                return paqueteComunJS.funcion.getNumeroFormateado(val);
            }

            this.displayfieldmonto = new Ext.form.DisplayField({
                value: "<span style='font-size:12px;'><b>Total Ingresos: </b></span>"
            });

            //this.id_tb155_cuenta_bancaria_historico = new Ext.form.ComboBox({
            //	fieldLabel:'Ingreso',
            //	store: this.storeID_INGRESO,
            //	typeAhead: true,
            //	valueField: 'id',
            //	displayField:'descripcion',
            //	hiddenName:'tb148_cuenta_cobrar_pago[id_tb155_cuenta_bancaria_historico]',
            //	//readOnly:(this.OBJ.id_tb011_cuenta_bancaria!='')?true:false,
            //	//style:(this.main.OBJ.id_tb011_cuenta_bancaria!='')?'background:#c9c9c9;':'',
            //	forceSelection:true,
            //	resizable:true,
            //	triggerAction: 'all',
            //	emptyText:'Seleccione Ingreso...',
            //	selectOnFocus: true,
            //	mode: 'local',
            //	width:350,
            //	resizable:true,
            //	allowBlank:false,
            //    onSelect: function(record){
            //		recaudacion.formulario.id_tb155_cuenta_bancaria_historico.setValue(record.data.id);
            //		recaudacion.formulario.monto.setValue(record.data.mo_transaccion);
            //		this.collapse();
            //    },
            //});

            this.id_tb064_presupuesto_ingreso = new Ext.form.ComboBox({
                fieldLabel: 'Partida Ingreso',
                store: this.storeID_PARTIDA_INGRESO,
                typeAhead: true,
                valueField: 'id_tb064_presupuesto_ingreso',
                displayField: 'tx_descripcion',
                hiddenName: 'tb148_cuenta_cobrar_pago[id_tb064_presupuesto_ingreso]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione partida ingreso',
                selectOnFocus: true,
                mode: 'local',
                width: 350,
                allowBlank: false
            });

            this.storeID_PARTIDA_INGRESO.load({
                params: {
                    co_solicitud: recaudacion.formulario.co_solicitud.getValue()
                }
            });

            this.gridPanel = new Ext.grid.GridPanel({
                title: 'Lista de Ingresos',
                iconCls: 'icon-libro',
                store: this.store_lista_pagos,
                loadMask: true,
                height: 180,
                width: 460,
                columns: [
                    new Ext.grid.RowNumberer(),
                    { header: 'co_liquidacion_pago', hidden: true, width: 10, menuDisabled: true, dataIndex: 'id' },
                    { header: 'N° Orden de Ingreso', width: 120, menuDisabled: true, dataIndex: 'de_orden_ingreso' },
                    { header: 'N° Documento', width: 120, menuDisabled: true, dataIndex: 'nu_documento' },
                    { header: 'Monto', width: 170, menuDisabled: true, dataIndex: 'mo_pago', renderer: renderMonto }
                ],
                stripeRows: true,
                autoScroll: true,
                stateful: true,
                bbar: new Ext.ux.StatusBar({
                    id: 'basic-statusbar',
                    autoScroll: true,
                    defaults: { style: 'color:black;font-size:30px;', autoWidth: true },
                    items: [
                        this.displayfieldmonto
                    ]
                }),
                listeners: {
                    cellclick: function (Grid, rowIndex, columnIndex, e) {
                    }
                }
            });

            this.mo_disponible = new Ext.form.Hidden({
                name: 'mo_disponible',
                value: this.OBJ.mo_disponible
            });

            this.monto = new Ext.form.NumberField({
                fieldLabel: 'Monto a Ingresar',
                name: 'tb148_cuenta_cobrar_pago[mo_pago]',
                id: 'monto',
                width: '150px',
                minValue: 0,
                allowDecimals: true,
                decimalPrecision: 2,
                decimalSeparator: '.',
                allowNegative: false,
                style: 'background:#DDDDDD;',
                readOnly: true,
                allowBlank: false,
                tooltip: '',
                value: '',
                blankText: 'Debe introducir el monto a pagar',
                msgTarget: 'under',
                value: this.OBJ.mo_pendiente,
                validator: function () {
                    return this.validFlag;
                },
                listeners: {
                    change: function (textfield, newValue, oldValue) {
                        var me = this;
                        if (recaudacion.formulario.mo_disponible.getValue() < newValue) {
                            me.validFlag = 'El monto a ingresar no debe superar al monto Pendiente.';
                        } else {
                            me.validFlag = true;
                        }
                        me.validate();
                    }
                }
            });

            this.mo_pendiente = new Ext.form.NumberField({
                fieldLabel: 'Monto Pendiente',
                name: 'Pagos[mo_pendiente]',
                width: '150px',
                minValue: 0,
                allowDecimals: true,
                decimalPrecision: 2,
                decimalSeparator: '.',
                allowNegative: false,
                style: 'background:#DDDDDD;',
                tooltip: '',
                readOnly: true,
                value: this.OBJ.mo_pendiente,
            });

            this.monto_pagado = new Ext.form.NumberField({
                fieldLabel: 'Monto Pagado',
                name: 'Pagos[mo_pagado]',
                width: '150px',
                minValue: 0,
                allowDecimals: true,
                decimalPrecision: 2,
                style: 'background:#DDDDDD;',
                decimalSeparator: '.',
                allowNegative: false,
                tooltip: '',
                readOnly: true,
                value: this.OBJ.mo_pagado
            });

            this.referencia = new Ext.form.TextField({
                fieldLabel: 'Doc/Ref',
                id: 'referencia',
                name: 'tb148_cuenta_cobrar_pago[nu_referencia]',
                width: '150px',
                allowNegative: false,
                allowBlank: false,
                maskRe: /[0-9]/,
                blankText: 'Debe introducir el numero de Documento o referencia'
            });

            //    this.referencia.on('blur',function(){
            //            if(recaudacion.formulario.cuenta.getValue()==""){
            //                    Ext.Msg.alert("Alerta","Disculpe debe seleccionar la cuenta bancaria");
            //                    return false;
            //            }
            //            if(recaudacion.formulario.tipo_documento.getValue()==""){
            //                    Ext.Msg.alert("Alerta","Disculpe debe seleccionar la fe_ingreso");
            //                    return false;
            //            }            
            //            
            //            recaudacion.formulario.buscarReferencia();
            //                    });

            this.formpanel = new Ext.FormPanel({
                width: 500,
                padding: '15px',
                url: '<?php echo $_SERVER["SCRIPT_NAME"]; ?>/TesoreriaIngresoPago/guardar',
                items: [
                    recaudacion.formulario.id_tb145_cuenta_cobrar_detalle,
                    recaudacion.formulario.co_solicitud,
                    recaudacion.formulario.co_tipo_solicitud,
                    recaudacion.formulario.co_cheque,
                    recaudacion.formulario.hiddenJsonPago,
                    recaudacion.formulario.nu_orden,
                    recaudacion.formulario.in_posteo,
                    recaudacion.formulario.banco,
                    recaudacion.formulario.cuenta,
                    recaudacion.formulario.id_tb155_cuenta_bancaria_historico,
                    //        recaudacion.formulario.id_tb064_presupuesto_ingreso,
                    recaudacion.formulario.fe_ingreso,
                    recaudacion.formulario.tipo_documento,
                    recaudacion.formulario.referencia,
                    recaudacion.formulario.monto,
                    recaudacion.formulario.mo_pendiente,
                    recaudacion.formulario.monto_pagado,
                    //        recaudacion.formulario.gridPanel
                ]
            });



            this.win = new Ext.Window({
                title: 'Datos del Ingreso',
                modal: true,
                constrain: true,
                items: [recaudacion.formulario.formpanel],
                buttonAlign: 'center',
                buttons: [
                    {
                        text: 'Procesar',
                        iconCls: 'icon-save',
                        handler: this.onRecaudar
                    }]
            });

            this.win.show();

            this.addEvents();
        },

        onRecaudar: function (btn, ev) {

            if (recaudacion.formulario.banco.getValue() == "") {
                Ext.Msg.alert("Alerta", "Disculpe debe seleccionar el banco");
                return false;
            }
            if (recaudacion.formulario.cuenta.getValue() == "") {
                Ext.Msg.alert("Alerta", "Disculpe debe seleccionar la cuenta bancaria");
                return false;
            }
            if (recaudacion.formulario.fe_ingreso.getValue() == "") {
                Ext.Msg.alert("Alerta", "Disculpe debe seleccionar la fe_ingreso");
                return false;
            }



            if (recaudacion.formulario.mo_disponible.getValue() <= 0) {
                Ext.Msg.alert("Alerta", "Disculpe el monto a pagar no puede ser menor al disponible");
                return false;
            }

            if (!recaudacion.formulario.formpanel.getForm().isValid()) {
                Ext.Msg.alert("Alerta", "Debe ingresar los campos requeridos! Verifique");
                return false;
            }

            var list = paqueteComunJS.funcion.getJsonByObjStore({
                store: recaudacion.formulario.gridPanel.getStore()
            });
            recaudacion.formulario.hiddenJsonPago.setValue(list);

            Ext.Ajax.request({
                method: 'GET',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/buscarReferencia',
                params: {
                    cuenta: recaudacion.formulario.cuenta.getValue(),
                    referencia: recaudacion.formulario.referencia.getValue(),
                    tipo_documento: recaudacion.formulario.tipo_documento.getValue()
                },
                success: function (result, request) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if (obj.data) {
                        Ext.MessageBox.confirm('Confirmación', 'El numero de documento ya se encuentra registrado por un monto de ' + obj.data.mo_transaccion + ' ¿desea postear?.', function (boton) {
                            if (boton == "yes") {
                                recaudacion.formulario.monto.setValue(obj.data.mo_transaccion);
                                recaudacion.formulario.id_tb155_cuenta_bancaria_historico.setValue(obj.data.id);
                                recaudacion.formulario.in_posteo.setValue(1);
                                recaudacion.formulario.onProcesar();

                            } else {


                                recaudacion.formulario.monto.setValue(recaudacion.formulario.mo_pendiente.getValue());
                                recaudacion.formulario.onProcesar();


                            }
                        });
                    } else {
                        recaudacion.formulario.monto.setValue(recaudacion.formulario.mo_pendiente.getValue());
                        recaudacion.formulario.onProcesar();
                    }
                }
            });

        },
        onProcesar: function (btn, ev) {


            if (recaudacion.formulario.monto.getValue() == 0) {
                Ext.Msg.alert("Alerta", "Disculpe el monto a ingresar no puede ser cero");
                return false;
            }


            recaudacion.formulario.formpanel.form.submit({
                success: function (form, action) {
                    if (action.result.success) {
                        Ext.MessageBox.show({
                            title: 'Mensaje',
                            msg: action.result.msg,
                            closable: false,
                            resizable: false,
                            buttons: Ext.MessageBox.OK
                        });

                        // window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/ventanilla/web/reportes/reporte_propaganda.php?codigo='+recaudacion.formulario.OBJ.co_ingvar_declaracion);


                        TesoreriaIngresoLista.main.store_lista.load();
                        recaudacion.formulario.win.close();
                    }
                },
                failure: function (form, action) {

                    Ext.MessageBox.alert('Mensaje', action.result.message);

                }
            });

        },
        buscarReferencia: function () {
            Ext.Ajax.request({
                method: 'GET',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/buscarReferencia',
                params: {
                    cuenta: recaudacion.formulario.cuenta.getValue(),
                    referencia: recaudacion.formulario.referencia.getValue(),
                    tipo_documento: recaudacion.formulario.tipo_documento.getValue()
                },
                success: function (result, request) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if (obj.data) {
                        Ext.MessageBox.confirm('Confirmación', '¿desea postear?.', function (boton) {
                            if (boton == "yes") {


                            } else {
                            }
                        });
                    } else {
                        recaudacion.formulario.monto.setValue(recaudacion.formulario.mo_pendiente.getValue());
                    }
                }
            });
        },
        /*
        *  STORE QUE CARGA LOS COMBOS DE BANCO - CUENTA
        */

        getDataBanco: function () {
            var store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tesoreria/banco',
                root: 'data',
                fields: ['co_banco', 'tx_banco']
            });
            return store;
        },
        getDataCuenta: function () {
            var store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tesoreria/cuenta',
                root: 'data',
                fields: ['co_cuenta_bancaria', 'tx_cuenta_bancaria']
            });
            return store;
        },
        getDatafe_ingreso: function () {
            var store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Tesoreria/fe_ingreso',
                root: 'data',
                fields: ['co_fe_ingreso', 'tx_descripcion']
            });
            return store;
        },
        getDataTipoDocumento: function () {
            var store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/storefktipodocumento',
                root: 'data',
                fields: ['id', 'de_tipo_documento_cuenta']
            });
            return store;
        },
        getDataFormaPago: function () {
            var store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER['SCRIPT_NAME'] ?>/Tesoreria/formapago',
                root: 'data',
                fields: ['co_forma_pago', 'tx_forma_pago']
            });
            return store;
        },
        getListaPagos: function () {

            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngresoPago/storelista',
                root: 'data',
                fields: [
                    { name: 'id' },
                    { name: 'id_tb145_cuenta_cobrar_detalle' },
                    { name: 'mo_pago' },
                    { name: 'id_tb074_forma_pago' },
                    { name: 'id_tb010_banco' },
                    { name: 'id_tb011_cuenta_bancaria' },
                    { name: 'fe_ingreso' },
                    { name: 'fe_registro' },
                    { name: 'id_tb147_tipo_documento' },
                    { name: 'de_orden_ingreso' },
                    { name: 'nu_documento' },
                ]
            });
            return this.store;
        },
        getTotal: function () {

            this.total_pendiente = 0;
            this.total_pagado = 0;
            this.cancelar = 0;
            this.tcancelar = 0;
            var cant = recaudacion.formulario.store_lista_pagos.getCount();
            this.total_pendiente = paqueteComunJS.funcion.getSumaColumnaGrid({
                store: recaudacion.formulario.store_lista_pagos,
                campo: 'mo_pago'
            });

            this.total_pagado = paqueteComunJS.funcion.getSumaColumnaGrid({
                store: recaudacion.formulario.store_lista_pagos,
                campo: 'mo_pagado'
            });

            /*if(cant>1){
                Ext.get('monto').setStyle('background-color','#c9c9c9');
                recaudacion.formulario.monto.setReadOnly(true);    
            
            }*/
            this.tcancelar = parseFloat(this.total_pendiente);
            this.tcancelar = this.tcancelar.toFixed(2);
            //recaudacion.formulario.monto.setValue(this.tcancelar);
            //recaudacion.formulario.mo_pagado.setValue(this.total_pagado);
            recaudacion.formulario.displayfieldmonto.setValue("<span style='font-size:12px;'><b>Total Ingresos: </b>" + paqueteComunJS.funcion.getNumeroFormateado(recaudacion.formulario.monto_pagado.getValue()) + "</b></span>");

        },
        /*
        *  FUNCION QUE CAPTURA LOS EVENTOS AL SELECCIONAR CADA UNO DE LOS COMBOS ANIDADOS
        *  (BANCO - CUENTA)
        */
        addEvents: function () {

            recaudacion.formulario.banco.on('beforeselect', function (cmb, record, index) {
                recaudacion.formulario.cuenta.clearValue();
                //recaudacion.formulario.fe_ingreso.clearValue();
                recaudacion.formulario.store_cuenta.load({
                    params: {
                        co_banco: record.get('co_banco')
                    },
                    callback: function (records, operation, success) {
                        if (records.length > 0) {

                        } else {
                            console.log(records.length);
                            Ext.Msg.alert("Alerta", "La banco seleccionado no tiene cuentas Asociados");
                        }
                    }
                });
            }, this);


        },

        getStoreID_INGRESO: function () {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/storeTransaccionCuenta',
                root: 'data',
                fields: [
                    { name: 'id' },
                    { name: 'fe_transaccion' },
                    { name: 'mo_transaccion' },
                    {
                        name: 'descripcion',
                        convert: function (v, r) {
                            return r.nu_documento + ' - ' + r.fe_transaccion + ' - ' + paqueteComunJS.funcion.getNumeroFormateado(r.mo_transaccion);
                        }
                    }
                ]
            });
            return this.store;
        },
        getStoreID_PARTIDA_INGRESO: function () {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/TesoreriaIngreso/storePartidaIngreso',
                root: 'data',
                fields: [
                    { name: 'id_tb064_presupuesto_ingreso' },
                    { name: 'tx_descripcion' }
                ]
            });
            return this.store;
        }

    }

    Ext.onReady(recaudacion.formulario.init, recaudacion.formulario);
</script>