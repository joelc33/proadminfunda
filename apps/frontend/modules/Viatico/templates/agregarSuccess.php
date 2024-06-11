<script type="text/javascript">
    Ext.ns("AgregarViatico");
    AgregarViatico.main = {
        init: function() {

            this.storeCO_ITEM_VIATICO = this.getStoreCO_ITEM_VIATICO();

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });

            this.co_detalle_viatico = new Ext.form.Hidden({
                name: 'co_detalle_viatico',
                value: this.OBJ.co_detalle_viatico
            });

            this.co_item_viatico = new Ext.form.ComboBox({
                fieldLabel: 'Tipo',
                store: this.storeCO_ITEM_VIATICO,
                typeAhead: true,
                valueField: 'co_item_viatico',
                displayField: 'tx_item_viatico',
                hiddenName: 'co_item_viatico',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione...',
                selectOnFocus: true,
                mode: 'local',
                width: 300,
                readOnly: true,
                style: 'background:#c9c9c9;',
                resizable: true,
                allowBlank: false
            });
            this.storeCO_ITEM_VIATICO.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_item_viatico,
                value: this.OBJ.co_item_viatico,
                objStore: this.storeCO_ITEM_VIATICO
            });


            this.mo_total = new Ext.form.NumberField({
                fieldLabel: 'Monto',
                name: 'mo_total',
                id: 'mo_total',
                value: this.OBJ.mo_total,
                allowBlank: false,
                width: 200
            });

            this.guardar = new Ext.Button({
                text: 'Agregar',
                iconCls: 'icon-guardar',
                handler: function() {

                    AgregarViatico.main.formPanel_.getForm().submit({
                        method: 'POST',
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/guardarDetalleViatico',
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

                            ViaticoEditar.main.botonEliminar.disable();
                            ViaticoEditar.main.editar.disable();

                            ViaticoEditar.main.store_lista.baseParams.co_solicitud = ViaticoEditar.main.OBJ.co_solicitud;
                            ViaticoEditar.main.store_lista.load({
                                callback: function() {
                                    ViaticoEditar.main.total_pagar = paqueteComunJS.funcion.getSumaColumnaGrid({
                                        store: ViaticoEditar.main.store_lista,
                                        campo: 'mo_total'
                                    });

                                    ViaticoEditar.main.monto_total.setValue("<span style='font-size:12px;'><b>Total a Pagar: </b>" + paqueteComunJS.funcion.getNumeroFormateado(ViaticoEditar.main.total_pagar) + "</b></span>");


                                }
                            });

                            AgregarViatico.main.winformPanel_.close();
                        }
                    });
                }
            });

            this.salir = new Ext.Button({
                text: 'Salir',
                //    iconCls: 'icon-cancelar',
                handler: function() {
                    AgregarViatico.main.winformPanel_.close();
                }
            });

            this.formPanel_ = new Ext.form.FormPanel({
                frame: true,
                width: 500,
                autoHeight: true,
                autoScroll: true,
                bodyStyle: 'padding:10px;',
                items: [
                    this.co_detalle_viatico,
                    this.co_item_viatico,
                    this.mo_total
                ]
            });

            this.winformPanel_ = new Ext.Window({
                title: 'Modificar Monto',
                modal: true,
                constrain: true,
                width: 500,
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
        getStoreCO_ITEM_VIATICO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/storefkcoitemviatico',
                root: 'data',
                fields: [{
                        name: 'co_item_viatico'
                    },
                    {
                        name: 'tx_item_viatico'
                    }
                ]
            });
            return this.store;
        }
    };
    Ext.onReady(AgregarViatico.main.init, AgregarViatico.main);
</script>