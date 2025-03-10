<script type="text/javascript">
    Ext.ns("SolicitudAyudaEditar");
    SolicitudAyudaEditar.main = {
        init: function () {

            this.OBJ = paqueteComunJS.funcion.doJSON({ stringData: '<?php echo $data ?>' });
            this.storeCO_TIPO_AYUDA = this.getStoreCO_TIPO_AYUDA();
            this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
            this.storeCO_DOCUMENTO_RECEPTOR = this.getStoreCO_DOCUMENTO();
            this.store_lista = this.getStorelista();

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

            this.Registro = Ext.data.Record.create([
                {
                    name: 'co_solicitud',
                    type: 'number'
                }, {
                    name: 'co_proveedor',
                    type: 'number'
                },
                {
                    name: 'co_documento',
                    type: 'number'
                },
                {
                    name: 'tx_documento',
                    type: 'string'
                },
                {
                    name: 'nb_persona',
                    type: 'number'
                },
                {
                    name: 'nu_celular',
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

            this.hiddenJsonProveedor = new Ext.form.Hidden({
                name: 'json_proveedor',
                value: ''
            });

            this.nb_persona = new Ext.form.TextField({
                fieldLabel: 'Nombre y Apellido',
                name: 'solicitante[nb_persona]',
                value: this.OBJ.nb_persona,
                readOnly: true,
                style: 'background:#c9c9c9;',
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
                //                allowBlank: false,
                readOnly: true,
                style: 'background:#c9c9c9;',
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
                width: 950,
                items: [this.compositefieldCI,
                this.nb_persona,
                this.nu_celular]
            });

            /* this.nb_proveedor = new Ext.form.TextField({
                 fieldLabel: 'Nombre y Apellido',
                 name: 'receptor[nb_persona]',
                 value: this.OBJ.nb_persona,
                 allowBlank: false,
                 readOnly: true,
                 style: 'background:#c9c9c9;',
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
                 readOnly: true,
                 style: 'background:#c9c9c9;',
 //                allowBlank: false,
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
 
             */

            function renderMonto(val, attr, record) {
                return paqueteComunJS.funcion.getNumeroFormateado(val);
            }

            this.agregar = new Ext.Button({
                text: 'Agregar',
                iconCls: 'icon-nuevo',
                handler: function () {
                    this.msg = Ext.get('formularioAgregar');
                    this.msg.load({
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/agregarProveedor',
                        scripts: true,
                        text: "Cargando.."
                    });
                }
            });


            this.botonEliminar = new Ext.Button({
                text: 'Eliminar',
                iconCls: 'icon-eliminar',
                handler: function () {
                    SolicitudAyudaEditar.main.eliminar();
                }
            });

            this.botonEliminar.disable();


            this.gridPanel = new Ext.grid.GridPanel({
                title: 'Lista de Proveedores',
                iconCls: 'icon-libro',
                store: this.store_lista,
                loadMask: true,
                height: 200,
                width: 910,
                tbar: [this.agregar, '-', this.botonEliminar],
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'co_solicitud',
                        hidden: true,
                        width: 80,
                        menuDisabled: true,
                        dataIndex: 'co_solicitud'
                    },
                    {
                        header: 'RIF',
                        width: 100,
                        menuDisabled: true,
                        dataIndex: 'tx_documento'
                    },
                    {
                        header: 'Razon Social',
                        width: 300,
                        menuDisabled: true,
                        dataIndex: 'nb_persona'
                    },
                    {
                        header: 'Monto',
                        width: 120,
                        menuDisabled: true,
                        dataIndex: 'monto',
                        //  renderer: renderMonto
                    },
                    {
                        header: 'Motivo',
                        width: 350,
                        menuDisabled: true,
                        dataIndex: 'tx_observacion'
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
                        // this.monto_total_compra, '-', this.monto_total
                    ]
                }),
                stripeRows: true,
                autoScroll: true,
                stateful: true,
                listeners: {
                    cellclick: function (Grid, rowIndex, columnIndex, e) {

                        SolicitudAyudaEditar.main.botonEliminar.enable();

                    }
                }
            });

            this.fieldDatosSolicitanteProveedor = new Ext.form.FieldSet({
                title: 'Datos del Pago',
                width: 950,
                items: [this.gridPanel]
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
                fieldLabel: 'Motivo',
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
                width: 950,
                items: [this.fe_solicitud,
                this.co_tipo_ayuda,
                this.hiddenJsonProveedor,
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

                    var list_proveedor = paqueteComunJS.funcion.getJsonByObjStore({
                        store: SolicitudAyudaEditar.main.gridPanel.getStore()
                    });

                    SolicitudAyudaEditar.main.hiddenJsonProveedor.setValue(list_proveedor);


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
                width: 1000,
                autoHeight: true,
                autoScroll: true,
                bodyStyle: 'padding:10px;',
                items: [this.co_solicitud_ayuda,
                this.co_proveedor,
                this.co_proveedor_solicitante,
                this.fieldDatosSolicitante,
                this.fieldDatosAyuda,
                this.fieldDatosSolicitanteProveedor,
                this.co_solicitud,
                this.co_usuario
                ]
            });

            this.winformPanel_ = new Ext.Window({
                title: 'Donación',
                modal: true,
                constrain: true,
                width: 1000,
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

            if (this.OBJ.co_solicitud_ayuda != '') {
                this.store_lista.baseParams.co_solicitud_ayuda = this.OBJ.co_solicitud_ayuda;
                this.store_lista.load();
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
        eliminar: function () {

            var s = SolicitudAyudaEditar.main.gridPanel.getSelectionModel().getSelections();

            var co_solicitud = SolicitudAyudaEditar.main.gridPanel.getSelectionModel().getSelected().get('co_solicitud');

            if (co_solicitud != '') {

                Ext.Ajax.request({
                    method: 'POST',
                    url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/eliminarSolicitudAyuda',
                    params: {
                        co_solicitud: co_solicitud
                    },
                    success: function (result, request) {
                        SolicitudAyudaEditar.main.store_lista.load();
                       // SolicitudAyudaEditar.main.calcularMonto();
                    }
                });

            }

            for (var i = 0, r; r = s[i]; i++) {
                SolicitudAyudaEditar.main.store_lista.remove(r);
            }

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
        }, getStorelista: function () {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/storefkcosolicitudayuda',
                root: 'data',
                fields: [
                    {
                        name: 'co_solicitud'
                    }, {
                        name: 'co_proveedor'
                    },
                    {
                        name: 'co_documento'
                    },
                    {
                        name: 'tx_documento'
                    },
                    {
                        name: 'nb_persona'
                    },
                    {
                        name: 'nu_celular'
                    },
                    {
                        name: 'monto'
                    },
                    {
                        name: 'tx_observacion'
                    }
                ]
            });
            return this.store;
        }
    };
    Ext.onReady(SolicitudAyudaEditar.main.init, SolicitudAyudaEditar.main);
</script>
<div id="formularioAgregar"></div>