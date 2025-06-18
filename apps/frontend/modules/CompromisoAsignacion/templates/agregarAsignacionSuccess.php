<script type="text/javascript">
    Ext.ns("listaAsignacion");
    listaAsignacion.main = {
        init: function () {

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });

            this.storeCO_PARTIDA = this.getStoreCO_PARTIDA();
            this.storeCO_PROYECTO = this.getStoreCO_PROYECTO();
            this.storeCO_ACCION = this.getStoreCO_ACCION();
            this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();

            this.mo_disponible2 = new Ext.form.Hidden({
                name: 'mo_disponible2',
                value: 0
            });

            this.co_compras = new Ext.form.Hidden({
                name: 'partida[co_compras]',
                value: this.OBJ.co_compras
            });

            this.tx_descripcion = new Ext.form.Hidden({
                name: 'partida[tx_descripcion]',
                value: this.OBJ.tx_descripcion
            });

            this.fecha = new Ext.form.Hidden({
                name: 'partida[fe_compromiso]',
                value: this.OBJ.fe_compromiso
            });



            this.co_ejecutor = new Ext.form.ComboBox({
                fieldLabel: 'Ente Ejecutor',
                store: this.storeCO_EJECUTOR,
                typeAhead: true,
                valueField: 'id',
                id: 'co_ejecutor',
                displayField: 'ejecutor',
                hiddenName: 'partida[co_ejecutor]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 600,
                allowBlank: false,
                listeners: {
                    select: function () {
                        listaAsignacion.main.storeCO_PROYECTO.load({
                            params: {
                                co_ejecutor: this.getValue()
                            }
                        });
                    }
                }
            });

            this.storeCO_EJECUTOR.load();

            this.co_proyecto = new Ext.form.ComboBox({
                fieldLabel: 'Proyecto/Ac',
                store: this.storeCO_PROYECTO,
                typeAhead: true,
                valueField: 'id',
                id: 'co_proyecto',
                displayField: 'de_proyecto_ac',
                hiddenName: 'partida[co_proyecto]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 600,
                allowBlank: false
            });


            this.co_proyecto.on('select', function (cmb, record, index) {
                listaAsignacion.main.co_accion.clearValue();
                listaAsignacion.main.storeCO_ACCION.load({
                    params: {
                        co_proyecto: record.get('id')
                    }
                });
            }, this);

            this.co_accion = new Ext.form.ComboBox({
                fieldLabel: 'Accion Especifica',
                store: this.storeCO_ACCION,
                typeAhead: true,
                valueField: 'id',
                id: 'co_accion',
                displayField: 'accion_especifica',
                hiddenName: 'partida[co_accion]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 600,
                allowBlank: false,
                listeners: {
                    select: function () {
                        listaAsignacion.main.storeCO_PARTIDA.baseParams.co_accion = this.getValue();
                        //listaAsignacion.main.storeCO_PARTIDA.baseParams.co_clase_producto = listaAsignacion.main.OBJ.co_clase_producto;                
                        listaAsignacion.main.storeCO_PARTIDA.load();
                    }
                }
            });

            this.co_partida = new Ext.form.ComboBox({
                fieldLabel: 'Partida',
                store: this.storeCO_PARTIDA,
                typeAhead: true,
                valueField: 'id',
                displayField: 'de_partida',
                hiddenName: 'partida[co_presupuesto]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 600,
                allowBlank: false,
                listeners: {
                    select: function () {
                        listaAsignacion.main.cargarDisponible();
                    }
                }
            });

            this.mo_disponible = new Ext.form.TextField({
                fieldLabel: 'Monto Disponible',
                name: 'partida[mo_disponible]',
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 500
            });

            this.mo_pagar = new Ext.form.TextField({
                fieldLabel: 'Monto Asigancion',
                name: 'partida[mo_pagar]',
                width: 500
            });

            this.guardar = new Ext.Button({
                text: 'Agregar',
                iconCls: 'icon-guardar',
                handler: function () {

                    if (!listaAsignacion.main.formPanel_.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
                        return false;
                    }

                    if (parseFloat(listaAsignacion.main.mo_pagar.getValue()) > parseFloat(listaAsignacion.main.mo_disponible2.getValue())) {
                        Ext.Msg.alert("Alerta", "El Monto de la Asignacion no puede ser mayor al disponible");
                        return false;
                    }

                    /*  var e = new agregarCompromiso.main.Registro({
                          co_detalle_compras: '',
                          co_ejecutor: listaAsignacion.main.co_ejecutor.getValue(),
                          tx_ejecutor: listaAsignacion.main.co_ejecutor.lastSelectionText,
                          co_proyecto: listaAsignacion.main.co_proyecto.getValue(),
                          tx_proyecto: listaAsignacion.main.co_proyecto.lastSelectionText,
                          co_accion: listaAsignacion.main.co_accion.getValue(),
                          tx_accion: listaAsignacion.main.co_accion.lastSelectionText,
                          co_partida: listaAsignacion.main.co_partida.getValue(),
                          tx_partida: listaAsignacion.main.co_partida.lastSelectionText,
                          monto: listaAsignacion.main.mo_pagar.getValue()
                      });

                      var cant = agregarCompromiso.main.store_lista.getCount();
                      (cant == 0) ? 0: agregarCompromiso.main.store_lista.getCount() + 1;
                      agregarCompromiso.main.store_lista.insert(cant, e);

                      agregarCompromiso.main.gridPanel.getView().refresh();

                      agregarCompromiso.main.total = paqueteComunJS.funcion.getSumaColumnaGrid({
                          store: agregarCompromiso.main.store_lista,
                          campo: 'monto'
                      });

                      agregarCompromiso.main.monto_total.setValue("<span style='font-size:12px;'><b>Monto Total: </b>" + parseFloat(agregarCompromiso.main.total) + "</b></span>");
                      agregarCompromiso.main.mo_total.setValue(agregarCompromiso.main.total);

                      Ext.utiles.msg('Mensaje', "La Asignacion se agrego exitosamente");
                      listaAsignacion.main.winformPanel_.close();*/


                    listaAsignacion.main.formPanel_.getForm().submit({
                        method: 'POST',
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/CompromisoAsignacion/guardarPartidaAsignacion',
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
                            agregarCompromiso.main.store_lista.baseParams.co_compras = listaAsignacion.main.OBJ.co_compras;
                            agregarCompromiso.main.store_lista.load({
                                callback: function () {
                                    agregarCompromiso.main.total = paqueteComunJS.funcion.getSumaColumnaGrid({
                                        store: agregarCompromiso.main.store_lista,
                                        campo: 'monto'
                                    });

                                    agregarCompromiso.main.monto_total.setValue("<span style='font-size:12px;'><b>Monto Total: </b>" + parseFloat(agregarCompromiso.main.total) + "</b></span>");
                                    agregarCompromiso.main.mo_total.setValue(agregarCompromiso.main.total);


                                }
                            });

                            CompromisoAsignacionEditar.main.store_lista.baseParams.co_solicitud = CompromisoAsignacionEditar.main.OBJ.co_solicitud;
                            CompromisoAsignacionEditar.main.store_lista.load({
                                callback: function () {
                                    CompromisoAsignacionEditar.main.total = paqueteComunJS.funcion.getSumaColumnaGrid({
                                        store: CompromisoAsignacionEditar.main.store_lista,
                                        campo: 'monto_total'
                                    });

                                    CompromisoAsignacionEditar.main.monto_total.setValue("<span style='font-size:12px;'><b>Monto Total: </b>" + parseFloat(CompromisoAsignacionEditar.main.total) + "</b></span>");
                                    CompromisoAsignacionEditar.main.mo_total.setValue(CompromisoAsignacionEditar.main.total);
                                }
                            });
                            listaAsignacion.main.winformPanel_.close();
                        }
                    });


                }
            });

            this.salir = new Ext.Button({
                text: 'Salir',
                //    iconCls: 'icon-cancelar',
                handler: function () {
                    listaAsignacion.main.winformPanel_.close();
                }
            });

            this.formPanel_ = new Ext.form.FormPanel({
                frame: true,
                width: 800,
                autoHeight: true,
                autoScroll: true,
                bodyStyle: 'padding:10px;',
                items: [
                    this.co_ejecutor,
                    this.fecha,
                    this.co_proyecto,
                    this.co_accion,
                    this.co_partida,
                    this.mo_disponible,
                    this.mo_pagar,
                    this.co_compras,
                    this.tx_descripcion
                ]
            });

            this.winformPanel_ = new Ext.Window({
                title: 'Agregar Asignacion',
                modal: true,
                constrain: true,
                width: 810,
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
        getStoreCO_PARTIDA: function () {
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
                    convert: function (v, r) {
                        return r.nu_partida + ' - ' + r.de_partida;
                    }
                }
                ]
            });
            return this.store;
        },
        getStoreCO_PROYECTO: function () {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoproyecto',
                root: 'data',
                fields: [{
                    name: 'id'
                },
                {
                    name: 'de_proyecto_ac',
                    convert: function (v, r) {
                        return r.nu_proyecto_ac + ' - ' + r.de_proyecto_ac;
                    }
                }
                ]
            });
            return this.store;
        },
        getStoreCO_EJECUTOR: function () {
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
                    convert: function (v, r) {
                        return r.nu_ejecutor + ' - ' + r.de_ejecutor;
                    }
                }
                ]
            });
            return this.store;
        },
        getStoreCO_ACCION: function () {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoaccion',
                root: 'data',
                fields: [{
                    name: 'id'
                },
                {
                    name: 'accion_especifica',
                    convert: function (v, r) {
                        return r.nu_accion_especifica + ' - ' + r.de_accion_especifica;
                    }
                }
                ]
            });
            return this.store;
        },
        cargarDisponible: function () {
            Ext.Ajax.request({
                method: 'GET',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/cargarDisponible',
                params: {
                    co_partida: listaAsignacion.main.co_partida.getValue()
                },
                success: function (result, request) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    listaAsignacion.main.mo_disponible.setValue(paqueteComunJS.funcion.getNumeroFormateado(obj.data.mo_disponible));
                    listaAsignacion.main.mo_disponible2.setValue(obj.data.mo_disponible);
                }
            });
        }
    };
    Ext.onReady(listaAsignacion.main.init, listaAsignacion.main);
</script>