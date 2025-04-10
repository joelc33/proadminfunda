<script type="text/javascript">
    Ext.ns("ViaticoEditar");
    ViaticoEditar.main = {
        init: function() {

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });
            //<Stores de fk>
            this.storeCO_TIPO_VIATICO = this.getStoreCO_TIPO_VIATICO();
            this.storeCO_ORIGEN_VIATICO = this.getStoreCO_ORIGEN_VIATICO();
            this.storeCO_ENTE = this.getStoreCO_ENTE();
            this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
            this.storeCO_CARGO = this.getStoreCO_CARGO();
            this.storeCO_NIVEL_ORGANIZACIONAL = this.getStoreCO_NIVEL_ORGANIZACIONAL();
            this.storeCO_NIVEL_TRABAJADOR = this.getStoreCO_NIVEL_TRABAJADOR();
            this.storeCO_CATEGORIA = this.getStoreCO_CATEGORIA();

            //<ClavePrimaria>
            this.co_viatico = new Ext.form.Hidden({
                name: 'co_viatico',
                value: this.OBJ.co_viatico
            });

            this.co_solicitud = new Ext.form.Hidden({
                name: 'tb108_viatico[co_solicitud]',
                value: this.OBJ.co_solicitud
            });
            //</ClavePrimaria>


            //<ClavePrimaria>
            this.co_persona = new Ext.form.Hidden({
                name: 'co_proveedor',
                value: this.OBJ.co_proveedor
            });
            //</ClavePrimaria>

            this.store_lista = this.getLista();


            this.Registro = Ext.data.Record.create([{
                    name: 'co_detalle_viatico',
                    type: 'number'
                },
                {
                    name: 'co_item_viatico',
                    type: 'number'
                },
                {
                    name: 'tx_item_viatico',
                    type: 'string'
                },
                {
                    name: 'tx_observacion',
                    type: 'string'
                }
            ]);

            this.hiddenJsonDetalle = new Ext.form.Hidden({
                name: 'json_detalle',
                value: ''
            });


            this.nb_persona = new Ext.form.TextField({
                fieldLabel: 'Nombre y Apellido',
                name: 'tb109_persona[nb_persona]',
                readOnly: true,
                style: 'background:#c9c9c9;',
                value: this.OBJ.nb_persona,
                allowBlank: false,
                width: 530
            });

            this.ap_persona = new Ext.form.TextField({
                fieldLabel: 'Apellidos',
                name: 'tb109_persona[ap_persona]',
                value: this.OBJ.ap_persona,
                allowBlank: false,
                width: 400
            });

            this.nu_cedula = new Ext.form.NumberField({
                fieldLabel: 'Cédula',
                name: 'tb109_persona[nu_cedula]',
                value: this.OBJ.nu_cedula,
                allowBlank: false,             
                maskRe: /[0-9]/,
            });


            /* this.co_cargo = new Ext.form.ComboBox({
                 fieldLabel: 'Cargo',
                 store: this.storeCO_CARGO,
                 typeAhead: true,
                 valueField: 'co_cargo',
                 displayField: 'tx_cargo',
                 hiddenName: 'tb109_persona[co_cargo]',
                 //readOnly:(this.OBJ.co_cargo!='')?true:false,
                 //style:(this.main.OBJ.co_cargo!='')?'background:#c9c9c9;':'',
                 forceSelection: true,
                 resizable: true,
                 triggerAction: 'all',
                 emptyText: 'Seleccione...',
                 selectOnFocus: true,
                 mode: 'local',
                 width: 400,
                 resizable: true,
                 allowBlank: false
             });
             this.storeCO_CARGO.load();
             paqueteComunJS.funcion.seleccionarComboByCo({
                 objCMB: this.co_cargo,
                 value: this.OBJ.co_cargo,
                 objStore: this.storeCO_CARGO
             });*/

            this.co_ente = new Ext.form.ComboBox({
                fieldLabel: 'Departamento',
                store: this.storeCO_ENTE,
                typeAhead: true,
                valueField: 'co_ente',
                displayField: 'tx_ente',
                hiddenName: 'tb108_viatico[co_ente]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 387,
                allowBlank: false,
                listeners: {
                    getSelectedIndex: function() {
                        var v = this.getValue();
                        var r = this.findRecord(this.valueField || this.displayField, v);
                        return (this.storeCO_ENTE.indexOf(r));
                    }
                }
            });
            this.storeCO_ENTE.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_ente,
                value: this.OBJ.co_ente,
                objStore: this.storeCO_ENTE
            });



            this.co_nivel_organizacional = new Ext.form.ComboBox({
                fieldLabel: 'Nivel Organizacional',
                store: this.storeCO_NIVEL_ORGANIZACIONAL,
                typeAhead: true,
                valueField: 'co_nivel_organizacional',
                displayField: 'co_nivel_organizacional',
                hiddenName: 'tb109_persona[co_nivel_organizacional]',
                //readOnly:(this.OBJ.co_nivel_organizacional!='')?true:false,
                //style:(this.main.OBJ.co_nivel_organizacional!='')?'background:#c9c9c9;':'',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione...',
                selectOnFocus: true,
                mode: 'local',
                width: 400,
                resizable: true,
                allowBlank: false
            });
            this.storeCO_NIVEL_ORGANIZACIONAL.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_nivel_organizacional,
                value: this.OBJ.co_nivel_organizacional,
                objStore: this.storeCO_NIVEL_ORGANIZACIONAL
            });

            this.co_nivel_trabajador = new Ext.form.ComboBox({
                fieldLabel: 'Nivel Trabajador',
                store: this.storeCO_NIVEL_TRABAJADOR,
                typeAhead: true,
                valueField: 'co_nivel_trabajador',
                displayField: 'co_nivel_trabajador',
                hiddenName: 'tb109_persona[co_nivel_trabajador]',
                //readOnly:(this.OBJ.co_nivel_trabajador!='')?true:false,
                //style:(this.main.OBJ.co_nivel_trabajador!='')?'background:#c9c9c9;':'',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione...',
                selectOnFocus: true,
                mode: 'local',
                width: 400,
                resizable: true,
                allowBlank: false
            });
            this.storeCO_NIVEL_TRABAJADOR.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_nivel_trabajador,
                value: this.OBJ.co_nivel_trabajador,
                objStore: this.storeCO_NIVEL_TRABAJADOR
            });

            this.nu_celular = new Ext.form.TextField({
                fieldLabel: 'Nro Celular',
                name: 'tb109_persona[nu_celular]',
                value: this.OBJ.nu_celular,
                allowBlank: false,
                width: 200,
                maxLength: 10,
                minLength: 10,
                maskRe: /[0-9]/,
            });

            this.fecha = new Ext.form.DateField({
                fieldLabel: 'Fecha',
                name: 'tb109_persona[fecha]',
                value: this.OBJ.fecha,
                allowBlank: false,
                width: 100
            });

            this.nu_extension = new Ext.form.TextField({
                fieldLabel: 'Nro Extension',
                name: 'tb109_persona[nu_extension]',
                value: this.OBJ.nu_extension,
                width: 200,
                maskRe: /[0-9]/,
            });

            this.telefono = new Ext.form.CompositeField({
                fieldLabel: 'Nro Celular',
                msgTarget: 'side',
                anchor: '-20',
                defaults: {
                    flex: 1
                },
                items: [
                    this.nu_celular
                    /* {
                           xtype: 'displayfield',
                           value: '&nbsp;&nbsp;&nbsp; Nro Extensión:',
                           width: 120
                     },
                     this.nu_extension*/
                ]
            });



            this.co_documento = new Ext.form.ComboBox({
                fieldLabel: 'documento',
                store: this.storeCO_DOCUMENTO,
                typeAhead: true,
                valueField: 'co_documento',
                displayField: 'inicial',
                hiddenName: 'tb109_persona[co_documento]',
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


            this.co_documento.on("blur", function() {
                if (ViaticoEditar.main.nu_cedula.getValue() != '') {
                    ViaticoEditar.main.verificarSolicitante();
                }
            });

            this.nu_cedula.on("blur", function() {
                ViaticoEditar.main.verificarSolicitante();
            });


            this.in_empleado = new Ext.form.Checkbox({
                fieldLabel: '¿Es Empleado?',
                name: 'tb108_viatico[in_empleado]',
                checked: (this.OBJ.in_empleado == '1') ? true : false,
                allowBlank: false
            });

            this.fieldDatosSolicitante = new Ext.form.FieldSet({
                title: 'Datos del Solicitante',
                width: 870,
                items: [this.compositefieldCI,
                    this.nb_persona,
                    //                this.ap_persona,
                    this.co_ente,
                    //                this.co_nivel_organizacional,
                    //                this.co_nivel_trabajador,
                    this.telefono,
                    this.fecha
                    //    this.in_empleado
                ]
            });

            this.co_tipo_viatico = new Ext.form.ComboBox({
                fieldLabel: 'Tipo de Viatico',
                store: this.storeCO_TIPO_VIATICO,
                typeAhead: true,
                valueField: 'co_tipo_viatico',
                displayField: 'tx_tipo_viatico',
                hiddenName: 'tb108_viatico[co_tipo_viatico]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione...',
                selectOnFocus: true,
                mode: 'local',
                width: 200,
                resizable: true,
                allowBlank: false,
                listeners: {
                    select: function() {
                        ViaticoEditar.main.store_lista.removeAll();
                        ViaticoEditar.main.store_lista.baseParams = {}
                        ViaticoEditar.main.store_lista.load({
                            params: {
                                co_tipo_viatico: 1,
                                co_categoria: 1
                            },
                            callback: function() {

                            }
                        });

                        ViaticoEditar.main.storeCO_ORIGEN_VIATICO.load({
                            params: {
                                co_tipo_viatico: this.getValue()
                            },
                            callback: function() {
                                ViaticoEditar.main.co_origen.setValue('');
                                ViaticoEditar.main.co_destino.setValue('');
                            }
                        });

                    }
                }
            });
            this.storeCO_TIPO_VIATICO.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_tipo_viatico,
                value: this.OBJ.co_tipo_viatico,
                objStore: this.storeCO_TIPO_VIATICO
            });


            if (this.OBJ.co_viatico != '') {
                this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
                this.store_lista.load();
            }





            this.co_categoria = new Ext.form.ComboBox({
                fieldLabel: 'Categoria',
                store: this.storeCO_CATEGORIA,
                typeAhead: true,
                valueField: 'co_categoria',
                displayField: 'tx_categoria',
                hiddenName: 'tb108_viatico[co_categoria]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione...',
                selectOnFocus: true,
                mode: 'local',
                width: 400,
                resizable: true,
                allowBlank: false,
                listeners: {
                    select: function() {
                        ViaticoEditar.main.store_lista.removeAll();
                        ViaticoEditar.main.store_lista.baseParams = {}
                        ViaticoEditar.main.store_lista.load({
                            params: {
                                co_categoria: 1,
                                co_tipo_viatico: 1
                            },
                            callback: function() {

                            }
                        });
                    }
                }
            });
            this.storeCO_CATEGORIA.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_categoria,
                value: this.OBJ.co_categoria,
                objStore: this.storeCO_CATEGORIA
            });

            this.tipo_categoria = new Ext.form.CompositeField({
                fieldLabel: 'Tipo de Viatico',
                msgTarget: 'side',
                anchor: '-20',
                defaults: {
                    flex: 1
                },
                items: [
                    this.co_tipo_viatico,
                    /*{
                        xtype: 'displayfield',
                        value: '&nbsp;&nbsp;&nbsp; Categoria:',
                        width: 90
                    },
                    this.co_categoria*/
                ]
            });


            this.tx_evento = new Ext.form.TextField({
                fieldLabel: 'Motivo',
                name: 'tb108_viatico[tx_evento]',
                value: this.OBJ.tx_evento,
                allowBlank: false,
                width: 700
            });

            this.tx_direccion = new Ext.form.TextField({
                fieldLabel: 'Direccion',
                name: 'tb108_viatico[tx_direccion]',
                value: this.OBJ.tx_direccion,
                allowBlank: false,
                width: 700
            });

            this.co_origen = new Ext.form.ComboBox({
                fieldLabel: 'Origen',
                store: this.storeCO_ORIGEN_VIATICO,
                typeAhead: true,
                valueField: 'co_origen_viatico',
                displayField: 'tx_origen_viatico',
                hiddenName: 'tb108_viatico[co_origen]',
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


            this.fe_desde = new Ext.form.DateField({
                fieldLabel: 'Desde',
                name: 'tb108_viatico[fe_desde]',
                value: this.OBJ.fe_desde,
                allowBlank: false,
                width: 100
            });

            this.datos_origen = new Ext.form.CompositeField({
                fieldLabel: 'Origen',
                msgTarget: 'side',
                anchor: '-20',
                defaults: {
                    flex: 1
                },
                items: [
                    this.co_origen,
                    {
                        xtype: 'displayfield',
                        value: '&nbsp;&nbsp;&nbsp; Desde:',
                        width: 60
                    },
                    this.fe_desde
                ]
            });

            this.co_destino = new Ext.form.ComboBox({
                fieldLabel: 'Destino',
                store: this.storeCO_ORIGEN_VIATICO,
                typeAhead: true,
                valueField: 'co_origen_viatico',
                displayField: 'tx_origen_viatico',
                hiddenName: 'tb108_viatico[co_destino]',
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

            if (this.OBJ.co_tipo_viatico != '') {
                this.storeCO_ORIGEN_VIATICO.load({
                    params: {
                        co_tipo_viatico: ViaticoEditar.main.OBJ.co_tipo_viatico
                    },
                    callback: function() {
                        ViaticoEditar.main.co_origen.setValue(ViaticoEditar.main.OBJ.co_origen);
                        ViaticoEditar.main.co_destino.setValue(ViaticoEditar.main.OBJ.co_destino);
                    }
                });
            }


            this.fe_hasta = new Ext.form.DateField({
                fieldLabel: 'Hasta',
                name: 'tb108_viatico[fe_hasta]',
                value: this.OBJ.fe_hasta,
                allowBlank: false,
                width: 100
            });


            this.datos_destino = new Ext.form.CompositeField({
                fieldLabel: 'Destino',
                msgTarget: 'side',
                anchor: '-20',
                defaults: {
                    flex: 1
                },
                items: [
                    this.co_destino,
                    {
                        xtype: 'displayfield',
                        value: '&nbsp;&nbsp;&nbsp; Hasta:',
                        width: 60
                    },
                    this.fe_hasta
                ]
            });

            this.in_hospedaje = new Ext.form.Checkbox({
                fieldLabel: '¿Requiere Hospedaje?',
                name: 'tb108_viatico[in_hospedaje]',
                checked: (this.OBJ.in_hospedaje == '1') ? true : false,
                allowBlank: false
            });

            this.tx_observacion_hospedaje = new Ext.form.TextField({
                fieldLabel: 'Hospedaje',
                name: 'tb108_viatico[tx_observacion_hospedaje]',
                value: this.OBJ.tx_observacion_hospedaje,
                width: 700
            });




            this.guardar = new Ext.Button({
                text: 'Guardar',
                iconCls: 'icon-guardar',
                handler: function() {

                    if (!ViaticoEditar.main.formPanel_.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
                        return false;
                    }

                    var list = paqueteComunJS.funcion.getJsonByObjStore({
                        store: ViaticoEditar.main.gridPanel.getStore()
                    });

                    ViaticoEditar.main.hiddenJsonDetalle.setValue(list);

                    ViaticoEditar.main.formPanel_.getForm().submit({
                        method: 'POST',
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/guardar',
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
                            ViaticoEditar.main.winformPanel_.close();
                        }
                    });


                }
            });


            if (this.OBJ.co_persona != '') {
                ViaticoEditar.main.verificarSolicitante();
            }

            this.salir = new Ext.Button({
                text: 'Salir',
                //    iconCls: 'icon-cancelar',
                handler: function() {
                    ViaticoEditar.main.winformPanel_.close();
                }
            });

            this.agregar = new Ext.Button({
                text: 'Agregar',
                iconCls: 'icon-nuevo',
                handler: function() {
                    this.msg = Ext.get('formularioAgregar');
                    this.msg.load({
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/agregar',
                        scripts: true,
                        text: "Cargando.."
                    });
                }
            });

            this.botonEliminar = new Ext.Button({
                text: 'Eliminar',
                iconCls: 'icon-eliminar',
                handler: function() {
                    ViaticoEditar.main.eliminar();
                }
            });

            this.botonEliminar.disable();

            this.gridPanel = new Ext.grid.EditorGridPanel({
                title: 'Detalle del Viatico (Doble click para agregar una observación)',
                iconCls: 'icon-libro',
                store: this.store_lista,
                loadMask: true,
                height: 200,
                width: 870,
                //   tbar:[this.agregar,'-',this.botonEliminar],
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'co_detalle_viatico',
                        hidden: true,
                        width: 80,
                        menuDisabled: true,
                        dataIndex: 'co_detalle_viatico'
                    },
                    {
                        header: 'co_item_viatico',
                        hidden: true,
                        width: 80,
                        menuDisabled: true,
                        dataIndex: 'co_item_viatico'
                    },
                    {
                        header: 'Descripción',
                        width: 300,
                        menuDisabled: true,
                        dataIndex: 'tx_item_viatico',
                        renderer: textoLargo
                    },
                    {
                        header: 'Observación',
                        width: 500,
                        menuDisabled: true,
                        dataIndex: 'tx_observacion',
                        renderer: textoLargo,
                        editor: new Ext.form.TextField({
                            allowBlank: false,
                            autoCreate: {
                                tag: "input",
                                type: "text",
                                autocomplete: "off",
                                maxlength: 400
                            },
                        })
                    },
                ],
                stripeRows: true,
                autoScroll: true,
                stateful: true,
                listeners: {
                    cellclick: function(Grid, rowIndex, columnIndex, e) {
                        ViaticoEditar.main.botonEliminar.enable();
                    }
                }
            });

            /* this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
             this.store_lista.load();*/

            this.fieldDatosSolicitud = new Ext.form.FieldSet({
                title: 'Datos de la Solicitud',
                width: 870,
                items: [this.hiddenJsonDetalle,
                    this.co_solicitud,
                    this.co_persona,
                    this.tipo_categoria,
                    this.tx_evento,
                    this.tx_direccion,
                    this.datos_origen,
                    this.datos_destino
                ]
            });

            this.formPanel_ = new Ext.form.FormPanel({
                width: 900,
                autoHeight: true,
                autoScroll: true,
                bodyStyle: 'padding:10px;',
                items: [
                    this.co_viatico,
                    this.fieldDatosSolicitante,
                    this.fieldDatosSolicitud,
                    this.gridPanel
                ]
            });

            this.winformPanel_ = new Ext.Window({
                title: 'Requisición de  Viaticos',
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
        },
        getLista: function() {

            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/storelistaDetalle',
                root: 'data',
                fields: [{
                        name: 'co_item_viatico'
                    },
                    {
                        name: 'tx_item_viatico'
                    },
                    {
                        name: 'tx_observacion'
                    },
                    {
                        name: 'cant_ut'
                    }
                ]
            });
            return this.store;
        },
        eliminar: function() {
            var s = ViaticoEditar.main.gridPanel.getSelectionModel().getSelections();

            var co_detalle_viatico = ViaticoEditar.main.gridPanel.getSelectionModel().getSelected().get('co_detalle_viatico');

            if (co_detalle_viatico != '') {

                Ext.Ajax.request({
                    method: 'POST',
                    url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/eliminar',
                    params: {
                        co_detalle_viatico: co_detalle_viatico
                    },
                    success: function(result, request) {

                    }
                });

            }

            for (var i = 0, r; r = s[i]; i++) {
                ViaticoEditar.main.store_lista.remove(r);
            }

        },
        verificarSolicitante: function() {
            Ext.Ajax.request({
                method: 'GET',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/verificarSolicitante',
                params: {
                    co_documento: ViaticoEditar.main.co_documento.getValue(),
                    tx_rif: ViaticoEditar.main.nu_cedula.getValue(),
                    co_proveedor: ViaticoEditar.main.co_persona.getValue()
                },
                success: function(result, request) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if (!obj.data) {
                        ViaticoEditar.main.co_proveedor.setValue("");
                        ViaticoEditar.main.nb_persona.setValue("");
                        //ViaticoEditar.main.co_cargo.setValue("");
                        ViaticoEditar.main.nu_celular.setValue("");
                        ViaticoEditar.main.nu_extension.setValue("");
                    } else {
                        ViaticoEditar.main.co_persona.setValue(obj.data.co_proveedor);
                        ViaticoEditar.main.nb_persona.setValue(obj.data.tx_razon_social);
                        //   ViaticoEditar.main.co_cargo.setValue(obj.data.co_cargo);
                        ViaticoEditar.main.nu_celular.setValue(obj.data.nu_celular);
                        ViaticoEditar.main.nu_extension.setValue(obj.data.nu_extension);
                        ViaticoEditar.main.nu_cedula.setValue(obj.data.tx_rif);
                        ViaticoEditar.main.co_documento.setValue(obj.data.co_documento);
                    }
                }
            });
        },
        getStoreCO_CATEGORIA: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/storefkcocategoria',
                root: 'data',
                fields: [{
                        name: 'co_categoria'
                    },
                    {
                        name: 'tx_categoria'
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_TIPO_VIATICO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/storefkcotipoviatico',
                root: 'data',
                fields: [{
                        name: 'co_tipo_viatico'
                    },
                    {
                        name: 'tx_tipo_viatico'
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_ORIGEN_VIATICO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/storefkcoorigen',
                root: 'data',
                fields: [{
                        name: 'co_origen_viatico'
                    },
                    {
                        name: 'tx_origen_viatico'
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_DOCUMENTO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/storefkcodocumento',
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
        getStoreCO_CARGO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/storefkcocargo',
                root: 'data',
                fields: [{
                        name: 'co_cargo'
                    },
                    {
                        name: 'tx_cargo'
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_NIVEL_ORGANIZACIONAL: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/storefkconivelorganizacional',
                root: 'data',
                fields: [{
                    name: 'co_nivel_organizacional'
                }]
            });
            return this.store;
        },
        getStoreCO_NIVEL_TRABAJADOR: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/storefkconiveltrabajador',
                root: 'data',
                fields: [{
                    name: 'co_nivel_trabajador'
                }]
            });
            return this.store;
        },
        getStoreCO_ENTE: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoente',
                root: 'data',
                fields: [{
                        name: 'co_ente'
                    },
                    {
                        name: 'tx_ente'
                    }
                ]
            });
            return this.store;
        }
    };
    Ext.onReady(ViaticoEditar.main.init, ViaticoEditar.main);
</script>
<div id="formularioAgregar"></div>