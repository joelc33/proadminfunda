<script type="text/javascript">
    Ext.ns("listaAsignacion");
    listaAsignacion.main = {
        init: function() {

            this.storeCO_PARTIDA = this.getStoreCO_PARTIDA();
            this.storeCO_PROYECTO = this.getStoreCO_PROYECTO();
            this.storeCO_ACCION = this.getStoreCO_ACCION();
            this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();

            this.mo_disponible2 = new Ext.form.Hidden({
                name: 'mo_disponible2',
                value: 0
            });

            this.co_ejecutor = new Ext.form.ComboBox({
                fieldLabel: 'Ente Ejecutor',
                store: this.storeCO_EJECUTOR,
                typeAhead: true,
                valueField: 'id',
                id: 'co_ejecutor',
                displayField: 'ejecutor',
                hiddenName: 'tb146_compromiso_asignacion[co_ejecutor]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 600,
                allowBlank: false,
                listeners: {
                    select: function() {
                        listaAsignacion.main.co_partida.clearValue();
                        listaAsignacion.main.mo_disponible.setValue('');                        
                        listaAsignacion.main.storeCO_PROYECTO.load({
                            params: {
                                co_ejecutor: this.getValue()
                            }
                        });
                    }
                }
            });



            this.co_proyecto = new Ext.form.ComboBox({
                fieldLabel: 'Proyecto/Ac',
                store: this.storeCO_PROYECTO,
                typeAhead: true,
                valueField: 'id',
                id: 'co_proyecto',
                displayField: 'de_proyecto_ac',
                hiddenName: 'tb146_compromiso_asignacion[co_proyecto]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 600,
                allowBlank: false
            });


            this.co_proyecto.on('select', function(cmb, record, index) {
                listaAsignacion.main.co_accion.clearValue();
                        listaAsignacion.main.co_partida.clearValue();
                        listaAsignacion.main.mo_disponible.setValue('');                
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
                hiddenName: 'tb146_compromiso_asignacion[co_accion]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 600,
                allowBlank: false,
                listeners: {
                    select: function() {
                        listaAsignacion.main.storeCO_PARTIDA.baseParams.co_accion = this.getValue();
                        listaAsignacion.main.co_partida.clearValue();
                        listaAsignacion.main.mo_disponible.setValue('');
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
                hiddenName: 'tb146_compromiso_asignacion[co_presupuesto]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 600,
                allowBlank: false,
                listeners: {
                    select: function() {
                        listaAsignacion.main.cargarDisponible();
                    }
                }
            });

            this.storeCO_EJECUTOR.load({
                callback: function() {
                    listaAsignacion.main.co_ejecutor.setValue(1);

                    listaAsignacion.main.storeCO_PROYECTO.load({
                        params: {
                            co_ejecutor: 1
                        }
                    });

                }
            });

            this.mo_disponible = new Ext.form.TextField({
                fieldLabel: 'Monto Disponible',
                name: 'mo_disponible',
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 500
            });

            this.mo_pagar = new Ext.form.TextField({
                fieldLabel: 'Monto Asigancion',
                name: 'mo_pagar',
                width: 500
            });

            this.guardar = new Ext.Button({
                text: 'Agregar',
                iconCls: 'icon-guardar',
                handler: function() {

                    if (!listaAsignacion.main.formPanel_.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
                        return false;
                    }

                    if (parseFloat(listaAsignacion.main.mo_pagar.getValue()) > parseFloat(listaAsignacion.main.mo_disponible2.getValue())) {
                        Ext.Msg.alert("Alerta", "El Monto de la Asignacion no puede ser mayor al disponible");
                        return false;
                    }
                    console.log(ViaticoEditar.main.mo_total.getValue())
                    if (parseFloat(listaAsignacion.main.mo_pagar.getValue()) > parseFloat(ViaticoEditar.main.total_pagar)) {
                        Ext.Msg.alert("Alerta", "El Monto de la Asignacion no puede ser mayor al Monto Total");
                        return false;
                    }                    

                    var e = new ViaticoEditar.main.Registro({
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

                    var cant = ViaticoEditar.main.store_lista_partida.getCount();
                    (cant == 0) ? 0: ViaticoEditar.main.store_lista_partida.getCount() + 1;
                    ViaticoEditar.main.store_lista_partida.insert(cant, e);

                    ViaticoEditar.main.gridPanelPartida.getView().refresh();

                    var total = paqueteComunJS.funcion.getSumaColumnaGrid({
                        store: ViaticoEditar.main.store_lista_partida,
                        campo: 'monto'
                    });


                    ViaticoEditar.main.botonEliminarPresupuesto.disable();

                    ViaticoEditar.main.monto_total_partida.setValue("<span style='font-size:12px;'><b>Monto Total: </b>" + parseFloat(total) + "</b></span>");
                    ViaticoEditar.main.mo_total_partida.setValue(total);

                    Ext.utiles.msg('Mensaje', "La Asignacion se agrego exitosamente");
                    listaAsignacion.main.winformPanel_.close();

                }
            });

            this.salir = new Ext.Button({
                text: 'Salir',
                //    iconCls: 'icon-cancelar',
                handler: function() {
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
                    this.co_proyecto,
                    this.co_accion,
                    this.co_partida,
                    this.mo_disponible,
                    this.mo_pagar
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
        getStoreCO_PARTIDA: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcopartidaViatico',
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
                    co_partida: listaAsignacion.main.co_partida.getValue()
                },
                success: function(result, request) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    listaAsignacion.main.mo_disponible.setValue(paqueteComunJS.funcion.getNumeroFormateado(obj.data.mo_disponible));
                    listaAsignacion.main.mo_disponible2.setValue(obj.data.mo_disponible);
                }
            });
        }
    };
    Ext.onReady(listaAsignacion.main.init, listaAsignacion.main);
</script>