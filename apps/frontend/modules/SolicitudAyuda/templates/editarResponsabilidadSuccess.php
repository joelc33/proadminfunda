<script type="text/javascript">
    Ext.ns("SolicitudAyudaEditar");
    SolicitudAyudaEditar.main = {
        init: function () {

            this.OBJ = paqueteComunJS.funcion.doJSON({ stringData: '<?php echo $data ?>' });
            this.storeCO_TIPO_AYUDA = this.getStoreCO_TIPO_AYUDA();
            this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
            this.storeCO_DOCUMENTO_RECEPTOR = this.getStoreCO_DOCUMENTO();

            //<ClavePrimaria>
            this.co_solicitud_ayuda = new Ext.form.Hidden({
                name: 'co_solicitud_ayuda',
                value: this.OBJ.co_solicitud_ayuda
            });
            //</ClavePrimaria>

            this.co_proveedor = new Ext.form.Hidden({
                name: 'receptor[co_proveedor]',
                value: this.OBJ.co_proveedor
            });

            this.co_proveedor_solicitante = new Ext.form.Hidden({
                name: 'solicitante[co_proveedor]',
                value: this.OBJ.co_proveedor_solicitante
            });

            this.co_solicitud = new Ext.form.Hidden({
                name: 'tb126_solicitud_ayuda[co_solicitud]',
                value: this.OBJ.co_solicitud
            });
            this.co_usuario = new Ext.form.Hidden({
                name: 'tb126_solicitud_ayuda[co_usuario]',
                value: this.OBJ.co_usuario
            });

            this.nb_persona = new Ext.form.TextField({
                fieldLabel: 'Nombre y Apellido',
                name: 'solicitante[nb_persona]',
                value: this.OBJ.nb_persona,
                allowBlank: false,
                width: 400
            });

            this.nu_cedula = new Ext.form.NumberField({
                fieldLabel: 'Cédula',
                name: 'solicitante[nu_cedula]',
                value: this.OBJ.nu_cedula,
                allowBlank: false,
                maskRe: /[0-9]/,
            });

            this.nu_celular = new Ext.form.TextField({
                fieldLabel: 'Nro Celular',
                name: 'solicitante[nu_celular]',
                value: this.OBJ.nu_celular,
                allowBlank: false,
                width: 200,
                maskRe: /[0-9]/,
            });

            this.co_documento = new Ext.form.ComboBox({
                fieldLabel: 'documento',
                store: this.storeCO_DOCUMENTO,
                typeAhead: true,
                valueField: 'co_documento',
                displayField: 'inicial',
                hiddenName: 'solicitante[co_documento]',
                //readOnly:(this.OBJ.co_documento!='')?true:false,
                //style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: '...',
                selectOnFocus: true,
                mode: 'local',
                width: 40,
                resizable: true,
                allowBlank: false
            });

            this.storeCO_DOCUMENTO.load();

            this.compositefieldCI = new Ext.form.CompositeField({
                fieldLabel: 'Cedula',
                items: [
                    this.co_documento,
                    this.nu_cedula
                ]
            });


            //this.co_documento.on("blur",function(){
            //    if(SolicitudAyudaEditar.main.nu_cedula.getValue()!=''){
            //        SolicitudAyudaEditar.main.verificarSolicitante();
            //    }
            //});

            this.nu_cedula.on("blur", function () {
                SolicitudAyudaEditar.main.verificarSolicitante();
            });

            this.fieldDatosSolicitante = new Ext.form.FieldSet({
                title: 'Beneficiario',
                width: 850,
                items: [this.compositefieldCI,
                this.nb_persona,
                this.nu_celular]
            });

            this.nb_proveedor = new Ext.form.TextField({
                fieldLabel: 'Nombre y Apellido',
                name: 'receptor[nb_persona]',
                value: this.OBJ.nb_persona,
                allowBlank: false,
                width: 400
            });

            this.nu_cedula_proveedor = new Ext.form.TextField({
                fieldLabel: 'Cédula',
                name: 'receptor[nu_cedula]',
                value: this.OBJ.nu_cedula_proveedor,
                allowBlank: false,
                //maskRe: /[0-9]/, 
            });

            this.nu_celular_proveedor = new Ext.form.TextField({
                fieldLabel: 'Nro Celular',
                name: 'receptor[nu_celular]',
                value: this.OBJ.nu_celular_proveedor,
                allowBlank: false,
                width: 200,
                maskRe: /[0-9]/
            });

            this.co_documento_proveedor = new Ext.form.ComboBox({
                fieldLabel: 'documento',
                store: this.storeCO_DOCUMENTO_RECEPTOR,
                typeAhead: true,
                valueField: 'co_documento',
                displayField: 'inicial',
                hiddenName: 'receptor[co_documento]',
                //readOnly:(this.OBJ.co_documento!='')?true:false,
                //style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: '...',
                selectOnFocus: true,
                mode: 'local',
                width: 40,
                resizable: true,
                allowBlank: false
            });

            this.storeCO_DOCUMENTO_RECEPTOR.load();

            this.compositefieldCIProveedor = new Ext.form.CompositeField({
                fieldLabel: 'Cedula',
                items: [
                    this.co_documento_proveedor,
                    this.nu_cedula_proveedor
                ]
            });


            //this.co_documento_proveedor.on("blur",function(){
            //    if(SolicitudAyudaEditar.main.nu_cedula_proveedor.getValue()!=''){
            //        SolicitudAyudaEditar.main.verificarReceptor();
            //    }
            //});

            this.nu_cedula_proveedor.on("blur", function () {
                SolicitudAyudaEditar.main.verificarReceptor();
            });

            this.fieldDatosSolicitanteProveedor = new Ext.form.FieldSet({
                title: 'Datos del Pago',
                width: 850,
                items: [this.compositefieldCIProveedor,
                this.nb_proveedor,
                this.nu_celular_proveedor]
            });

            this.co_tipo_ayuda = new Ext.form.ComboBox({
                fieldLabel: 'Tipo',
                store: this.storeCO_TIPO_AYUDA,
                typeAhead: true,
                valueField: 'co_tipo_ayuda',
                displayField: 'tx_tipo_ayuda',
                hiddenName: 'tb126_solicitud_ayuda[co_tipo_ayuda]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione...',
                selectOnFocus: true,
                mode: 'local',
                width: 700,
                resizable: true,
                allowBlank: false
            });
            this.storeCO_TIPO_AYUDA.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_tipo_ayuda,
                value: this.OBJ.co_tipo_ayuda,
                objStore: this.storeCO_TIPO_AYUDA
            });

            this.tx_observacion = new Ext.form.TextArea({
                fieldLabel: 'Descripción Orden de pago',
                name: 'tb126_solicitud_ayuda[tx_observacion]',
                value: this.OBJ.tx_observacion,
                allowBlank: false,
                width: 700
            });

            this.monto = new Ext.form.NumberField({
                fieldLabel: 'Monto',
                name: 'tb126_solicitud_ayuda[monto]',
                value: this.OBJ.monto,
                allowBlank: false,
                width: 200
            });

            this.fe_solicitud = new Ext.form.DateField({
                fieldLabel: 'Fecha',
                name: 'tb126_solicitud_ayuda[fe_solicitud]',
                value: this.OBJ.fecha,
                allowBlank: false,
                width: 100
            });

            this.fieldDatosAyuda = new Ext.form.FieldSet({
                title: 'Datos de la Donacion',
                width: 850,
                items: [this.fe_solicitud,
                this.co_tipo_ayuda,
                this.monto,
                this.tx_observacion]
            });



            this.guardar = new Ext.Button({
                text: 'Guardar',
                iconCls: 'icon-guardar',
                handler: function () {

                    if (!SolicitudAyudaEditar.main.formPanel_.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
                        return false;
                    }
                    SolicitudAyudaEditar.main.formPanel_.getForm().submit({
                        method: 'POST',
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/guardarSolicitud',
                        waitMsg: 'Enviando datos, por favor espere..',
                        waitTitle: 'Enviando',
                        failure: function (form, action) {
                            Ext.MessageBox.alert('Error en transacción', action.result.msg);
                        },
                        success: function (form, action) {
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
                            solicitudLista.main.store_lista.on('load', function () {
                                solicitudLista.main.estado.disable();
                                solicitudLista.main.anular.disable();
                            });
                            SolicitudAyudaEditar.main.winformPanel_.close();
                        }
                    });


                }
            });

            this.salir = new Ext.Button({
                text: 'Salir',
                //    iconCls: 'icon-cancelar',
                handler: function () {
                    SolicitudAyudaEditar.main.winformPanel_.close();
                }
            });

            this.formPanel_ = new Ext.form.FormPanel({
                width: 900,
                autoHeight: true,
                autoScroll: true,
                bodyStyle: 'padding:10px;',
                items: [this.co_solicitud_ayuda,
                this.co_proveedor,
                this.co_proveedor_solicitante,
                this.fieldDatosSolicitante,
                this.fieldDatosSolicitanteProveedor,
                this.fieldDatosAyuda,
                this.co_solicitud,
                this.co_usuario
                ]
            });

            this.winformPanel_ = new Ext.Window({
                title: 'Donación',
                constrain: true,
                width: 900,
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

            if (this.OBJ.co_proveedor_solicitante != '') {
                SolicitudAyudaEditar.main.verificarSolicitante();
            }

            if (this.OBJ.co_proveedor != '') {
                SolicitudAyudaEditar.main.verificarReceptor();
            }

            //SolicitudAyudaLista.main.mascara.hide();
        },
        verificarSolicitante: function () {
            Ext.Ajax.request({
                method: 'GET',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/verificarSolicitante',
                params: {
                    co_documento: SolicitudAyudaEditar.main.co_documento.getValue(),
                    tx_rif: SolicitudAyudaEditar.main.nu_cedula.getValue(),
                    co_proveedor: SolicitudAyudaEditar.main.co_proveedor_solicitante.getValue()
                },
                success: function (result, request) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if (!obj.data) {
                        SolicitudAyudaEditar.main.co_proveedor_solicitante.setValue("");
                        SolicitudAyudaEditar.main.nb_persona.setValue("");
                        SolicitudAyudaEditar.main.nu_celular.setValue("");
                    } else {

                        SolicitudAyudaEditar.main.co_proveedor_solicitante.setValue(obj.data.co_proveedor);
                        SolicitudAyudaEditar.main.nb_persona.setValue(obj.data.tx_razon_social);
                        SolicitudAyudaEditar.main.nu_celular.setValue(obj.data.nu_celular);
                        SolicitudAyudaEditar.main.nu_cedula.setValue(obj.data.tx_rif);

                        SolicitudAyudaEditar.main.storeCO_DOCUMENTO.load({
                            callback: function () {
                                SolicitudAyudaEditar.main.co_documento.setValue(obj.data.co_documento);
                            }
                        });


                    }
                }
            });
        },
        verificarReceptor: function () {
            Ext.Ajax.request({
                method: 'GET',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/verificarSolicitante',
                params: {
                    co_documento: SolicitudAyudaEditar.main.co_documento_proveedor.getValue(),
                    tx_rif: SolicitudAyudaEditar.main.nu_cedula_proveedor.getValue(),
                    co_proveedor: SolicitudAyudaEditar.main.co_proveedor.getValue()
                },
                success: function (result, request) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if (!obj.data) {
                        SolicitudAyudaEditar.main.co_proveedor.setValue("");
                        SolicitudAyudaEditar.main.nb_proveedor.setValue("");
                        SolicitudAyudaEditar.main.nu_celular_proveedor.setValue("");
                    } else {

                        SolicitudAyudaEditar.main.co_proveedor.setValue(obj.data.co_proveedor);
                        SolicitudAyudaEditar.main.nb_proveedor.setValue(obj.data.tx_razon_social);
                        SolicitudAyudaEditar.main.nu_celular_proveedor.setValue(obj.data.nu_celular);
                        SolicitudAyudaEditar.main.nu_cedula_proveedor.setValue(obj.data.tx_rif);

                        SolicitudAyudaEditar.main.storeCO_DOCUMENTO_RECEPTOR.load({
                            callback: function () {
                                SolicitudAyudaEditar.main.co_documento_proveedor.setValue(obj.data.co_documento);
                            }
                        });


                    }
                }
            });
        }, getStoreCO_DOCUMENTO: function () {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/storefkcodocumento',
                root: 'data',
                fields: [
                    { name: 'co_documento' },
                    { name: 'inicial' }
                ]
            });
            return this.store;
        }
        , getStoreCO_TIPO_AYUDA: function () {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/storefkcotipoayuda',
                root: 'data',
                fields: [
                    { name: 'co_tipo_ayuda' },
                    { name: 'tx_tipo_ayuda' }
                ]
            });
            return this.store;
        }
    };
    Ext.onReady(SolicitudAyudaEditar.main.init, SolicitudAyudaEditar.main);
</script>