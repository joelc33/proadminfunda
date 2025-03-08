<script type="text/javascript">
    Ext.ns("agregarProveedor");
    agregarProveedor.main = {
        init: function () {



            this.storeCO_DOCUMENTO_RECEPTOR = this.getStoreCO_DOCUMENTO();

            this.nb_proveedor = new Ext.form.TextField({
                fieldLabel: 'Nombre y Apellido',
                name: 'nb_persona',
                allowBlank: false,
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 400
            });

            this.nu_cedula_proveedor = new Ext.form.TextField({
                fieldLabel: 'Cédula',
                name: 'nu_cedula',
                allowBlank: false,
                //maskRe: /[0-9]/, 
            });

            this.co_proveedor = new Ext.form.Hidden({
                name: 'co_proveedor'
            });

            this.nu_celular_proveedor = new Ext.form.TextField({
                fieldLabel: 'Nro Celular',
                name: 'receptor[nu_celular]',
                readOnly: true,
                style: 'background:#c9c9c9;',
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


            this.nu_cedula_proveedor.on("blur", function () {
                agregarProveedor.main.verificarReceptor();
            });

            this.tx_observacion = new Ext.form.TextArea({
                fieldLabel: 'Motivo',
                name: 'tx_observacion',
                allowBlank: false,
                width: 700
            });

            this.monto = new Ext.form.NumberField({
                fieldLabel: 'Monto',
                name: 'monto',
                allowBlank: false,
                width: 200
            });


            this.fieldDatosSolicitanteProveedor = new Ext.form.FieldSet({
                title: 'Datos del Pago',
                width: 850,
                items: [this.co_proveedor,
                this.compositefieldCIProveedor,
                this.nb_proveedor,
                this.nu_celular_proveedor,
                this.tx_observacion,
                this.monto]
            });



            this.guardar = new Ext.Button({
                text: 'Guardar',
                iconCls: 'icon-guardar',
                handler: function () {
                    if (!agregarProveedor.main.formPanel_.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
                        return false;
                    }

                  
                    var e = new SolicitudAyudaEditar.main.Registro({
                        co_proveedor: agregarProveedor.main.co_proveedor.getValue(),
                        co_documento: agregarProveedor.main.co_documento_proveedor.getValue(),
                        tx_documento: agregarProveedor.main.co_documento_proveedor.lastSelectionText+'-'+agregarProveedor.main.nu_cedula_proveedor.getValue(),
                        nb_persona: agregarProveedor.main.nb_proveedor.getValue(),
                        nu_celular: agregarProveedor.main.nu_celular_proveedor.getValue(),
                        monto: agregarProveedor.main.monto.getValue(),
                        tx_observacion: agregarProveedor.main.tx_observacion.getValue()
                    });

                    var cant = SolicitudAyudaEditar.main.store_lista.getCount();

                    (cant == 0) ? 0 : SolicitudAyudaEditar.main.store_lista.getCount() + 1;
                    SolicitudAyudaEditar.main.store_lista.insert(cant, e);

                    SolicitudAyudaEditar.main.gridPanel.getView().refresh();

                    //SolicitudAyudaEditar.main.calcularMonto();

                    agregarProveedor.main.winformPanel_.close();


                }
            });

            this.salir = new Ext.Button({
                text: 'Salir',
                //    iconCls: 'icon-cancelar',
                handler: function () {
                    agregarProveedor.main.winformPanel_.close();
                }
            });

            this.formPanel_ = new Ext.form.FormPanel({
                width: 900,
                autoHeight: true,
                autoScroll: true,
                bodyStyle: 'padding:10px;',
                items: [this.fieldDatosSolicitanteProveedor]
            });

            this.winformPanel_ = new Ext.Window({
                title: 'Solicitud Ayuda',
                modal: true,
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



            //SolicitudAyudaLista.main.mascara.hide();
        }, verificarReceptor: function () {
            Ext.Ajax.request({
                method: 'GET',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/verificarSolicitante',
                params: {
                    co_documento: agregarProveedor.main.co_documento_proveedor.getValue(),
                    tx_rif: agregarProveedor.main.nu_cedula_proveedor.getValue(),
                    co_proveedor: agregarProveedor.main.co_proveedor.getValue()
                },
                success: function (result, request) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if (!obj.data) {
                        agregarProveedor.main.co_proveedor.setValue("");
                        agregarProveedor.main.nb_proveedor.setValue("");
                        agregarProveedor.main.nu_celular_proveedor.setValue("");
                    } else {

                        agregarProveedor.main.co_proveedor.setValue(obj.data.co_proveedor);
                        agregarProveedor.main.nb_proveedor.setValue(obj.data.tx_razon_social);
                        agregarProveedor.main.nu_celular_proveedor.setValue(obj.data.nu_celular);
                        agregarProveedor.main.nu_cedula_proveedor.setValue(obj.data.tx_rif);

                        agregarProveedor.main.storeCO_DOCUMENTO_RECEPTOR.load({
                            callback: function () {
                                agregarProveedor.main.co_documento_proveedor.setValue(obj.data.co_documento);
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
    };
    Ext.onReady(agregarProveedor.main.init, agregarProveedor.main);
</script>