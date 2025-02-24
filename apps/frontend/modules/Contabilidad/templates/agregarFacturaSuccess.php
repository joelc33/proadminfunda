<script type="text/javascript">
    Ext.ns("listaProducto");
    listaProducto.main = {
        init: function() {

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });

            this.storeCO_IVA_FACTURA = this.getStoreCO_IVA_FACTURA();
            this.storeCO_IVA_RETENCION = this.getStoreCO_IVA_RETENCION();
            this.storeDETALLE_RETENCION = this.getStoreDETALLE_RETENCION();
            this.json_producto;

            listaProducto.main.mo_total;
            listaProducto.main.mo_iva_factura;
            listaProducto.main.mo_iva_retencion;
            listaProducto.main.po_iva_factura;
            listaProducto.main.po_iva_retencion;
            listaProducto.main.base_imp;
            listaProducto.main.mo_retencion;
            listaProducto.main.mo_total_pagar;

            this.nu_total_retencion = new Ext.form.Hidden({
                name: 'nu_total_retencion'
            });

            this.mo_exento = new Ext.form.Hidden({
                name: 'mo_excento'
            });

            this.nu_factura = new Ext.form.TextField({
                fieldLabel: 'N° Factura',
                name: 'nu_factura',
                allowBlank: false,
                width: 200
            });

            this.nu_control = new Ext.form.TextField({
                fieldLabel: 'N° Control',
                name: 'nu_control',
                allowBlank: false,
                width: 200
            });

            this.fecha_emision = new Ext.form.DateField({
                fieldLabel: 'Fecha Emisión',
                name: 'fe_emision',
                allowBlank: false,
                format: 'd-m-Y',
                minValue:this.OBJ.fecha_compra,
                maxValue:new date(),
                width: 100
            });



            this.nu_iva_factura = new Ext.form.TextField({
                name: 'nu_iva_factura',
                allowBlank: false,
                width: 200,
                readOnly: true,
                style: 'background:#c9c9c9;'
            });

            this.compositefieldIVAFactura = new Ext.form.CompositeField({
                fieldLabel: 'Monto IVA',
                width: 485,
                items: [

                    this.nu_iva_factura
                ]
            });


            this.co_iva_factura = new Ext.form.ComboBox({
                fieldLabel: 'IVA',
                store: this.storeCO_IVA_FACTURA,
                typeAhead: true,
                valueField: 'nu_valor',
                displayField: 'nu_valor',
                hiddenName: 'co_iva_factura',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 50,
                resizable: true,
                allowBlank: false
            });
            this.storeCO_IVA_FACTURA.load();

            this.co_iva_retencion = new Ext.form.ComboBox({
                fieldLabel: 'IVA',
                store: this.storeCO_IVA_RETENCION,
                typeAhead: true,
                valueField: 'nu_valor',
                displayField: 'nu_valor',
                hiddenName: 'co_iva_retencion',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                readOnly: true,
                style: 'background:#c9c9c9;',
                value: this.OBJ.nu_iva_retencion,
                width: 50,
                resizable: true,
                allowBlank: false
            });
            this.storeCO_IVA_RETENCION.load();

            this.nu_iva_retencion = new Ext.form.TextField({
                fieldLabel: 'IVA',
                name: 'nu_iva_retencion',
                allowBlank: false,
                width: 345,
                readOnly: true,
                style: 'background:#c9c9c9;'
            });

            this.compositefieldIVARetencion = new Ext.form.CompositeField({
                fieldLabel: 'IVA',
                width: 485,
                items: [
                    this.co_iva_retencion,
                    this.nu_iva_retencion
                ]
            });

            this.nu_base_imponible = new Ext.form.NumberField({
                fieldLabel: 'Base Imponible',
                name: 'nu_base_imponible',
                allowBlank: false,
                width: 400,
                readOnly: true,
                style: 'background:#c9c9c9;'
            });

            this.agregar_producto = new Ext.Button({
                text: 'Agregar Productos',
                iconCls: 'icon-add',
                handler: function() {


                    if (listaProducto.main.co_iva_factura.getValue() == '') {

                        Ext.MessageBox.show({
                            title: 'Mensaje',
                            msg: "Para agregar los productos, debe seleccionar el IVA",
                            closable: false,
                            icon: Ext.MessageBox.INFO,
                            resizable: false,
                            animEl: document.body,
                            buttons: Ext.MessageBox.OK
                        });

                    } else {

                        this.msg = Ext.get('formularioProducto');
                        this.msg.load({
                            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/agregarProducto',
                            scripts: true,
                            text: "Cargando..",
                            params: {
                                co_solicitud: listaProducto.main.OBJ.co_solicitud,
                                iva: listaProducto.main.co_iva_factura.getValue()
                            }
                        });
                    }

                }
            });

            this.compositeBaseImponible = new Ext.form.CompositeField({
                fieldLabel: 'Base Imponible',
                width: 550,
                items: [
                    this.nu_base_imponible,
                    this.agregar_producto
                ]
            });



            this.nu_total = new Ext.form.TextField({
                fieldLabel: 'Monto Total',
                name: 'nu_total',
                allowBlank: false,
                width: 400,
                readOnly: true,
                style: 'background:#c9c9c9;'
            });

            this.fieldDatosFactura = new Ext.form.FieldSet({
                title: 'Datos de la Factura',
                items: [this.nu_factura,
                    this.nu_control,
                    this.fecha_emision,
                    this.co_iva_factura,
                    this.compositeBaseImponible,
                    this.compositefieldIVAFactura,
                    this.nu_total
                ]
            });

            this.nu_imp_municipal = new Ext.form.TextField({
                fieldLabel: 'Imp. Municipal',
                name: 'nu_iva_retencion',
                allowBlank: false,
                width: 400,
                readOnly: true,
                style: 'background:#c9c9c9;'
            });

            this.nu_islr = new Ext.form.TextField({
                fieldLabel: 'ISLR',
                name: 'nu_islr',
                allowBlank: false,
                width: 400,
                readOnly: true,
                style: 'background:#c9c9c9;'
            });

            this.nu_timbre = new Ext.form.TextField({
                fieldLabel: 'Timbre Fiscal',
                name: 'nu_timbre_fiscal',
                allowBlank: false,
                width: 400,
                readOnly: true,
                style: 'background:#c9c9c9;'
            });

            this.nu_aporte_social = new Ext.form.TextField({
                fieldLabel: 'Aporte Social',
                name: 'nu_aporte',
                allowBlank: false,
                width: 400,
                readOnly: true,
                style: 'background:#c9c9c9;'
            });

            this.total_pagar = new Ext.form.TextField({
                fieldLabel: 'Total a Pagar',
                name: 'nu_total_pagar',
                allowBlank: false,
                width: 400,
                readOnly: true,
                style: 'background:#c9c9c9;'
            });

            this.tx_concepto = new Ext.form.TextField({
                fieldLabel: 'Concepto',
                name: 'nu_total_pagar',
                allowBlank: false,
                width: 400
            });


            this.fieldDatosRetencion = new Ext.form.FieldSet({
                title: 'Retención',
                items: [this.compositefieldIVARetencion]
            });


            this.total_retencion = new Ext.form.DisplayField({
                value: "<span style='font-size:12px;'><b>Total Retención: </b>0,00</b></span>"
            });

            this.botonEliminar = new Ext.Button({
                text: 'Eliminar Retención',
                iconCls: 'icon-eliminar',
                id: 'eliminar',
                handler: function(boton) {
                    listaProducto.main.eliminar();
                }
            });

            function renderMonto(val, attr, record) {
                return paqueteComunJS.funcion.getNumeroFormateado(val);
            }

            this.gridPanel = new Ext.grid.GridPanel({
                title: 'Detalle de Retención',
                store: this.storeDETALLE_RETENCION,
                loadMask: true,
                height: 200,
                width: 778,
                tbar: [this.botonEliminar],
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'Tipo de Retención',
                        width: 250,
                        menuDisabled: true,
                        dataIndex: 'tx_tipo_retencion'
                    },
                    {
                        header: 'Porcentaje',
                        width: 100,
                        menuDisabled: true,
                        dataIndex: 'po_deduccion'
                    },
                    {
                        header: 'Monto',
                        width: 400,
                        menuDisabled: true,
                        dataIndex: 'nu_valor',
                        renderer: renderMonto
                    }
                ],
                bbar: new Ext.ux.StatusBar({
                    id: 'basic-statusbar_factura',
                    autoScroll: true,
                    defaults: {
                        style: 'color:black;font-size:30px;',
                        autoWidth: true
                    },
                    items: [
                        this.total_retencion
                    ]
                }),
                stripeRows: true,
                autoScroll: true,
                stateful: true,
                listeners: {
                    cellclick: function(Grid, rowIndex, columnIndex, e) {
                        listaProducto.main.botonEliminar.enable();
                    }
                }
            });


            this.fieldDatosPagar = new Ext.form.FieldSet({
                title: 'Monto a Pagar',
                items: [
                    this.total_pagar,
                    this.tx_concepto
                ]
            });


            this.guardar = new Ext.Button({
                text: 'Agregar',
                iconCls: 'icon-guardar',
                handler: function() {

                    if (!listaProducto.main.formPanel_.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
                        return false;
                    }


                    var list_retencion = paqueteComunJS.funcion.getJsonByObjStore({
                        store: listaProducto.main.gridPanel.getStore()
                    });


                    var e = new ContabilidadEditar.main.Registro({
                        nu_factura: listaProducto.main.nu_factura.getValue(),
                        nu_control: listaProducto.main.nu_control.getValue(),
                        fe_emision: listaProducto.main.fecha_emision.value,
                        nu_base_imponible: listaProducto.main.base_imp,
                        co_iva_factura: listaProducto.main.po_iva_factura,
                        nu_iva_factura: listaProducto.main.mo_iva_factura,
                        nu_total: listaProducto.main.mo_total,
                        co_iva_retencion: listaProducto.main.po_iva_retencion,
                        nu_iva_retencion: listaProducto.main.mo_iva_retencion,
                        nu_total_retencion: listaProducto.main.mo_retencion,
                        total_pagar: listaProducto.main.mo_total_pagar,
                        nu_total_pagar: listaProducto.main.mo_total_pagar,
                        tx_concepto: listaProducto.main.tx_concepto.getValue(),
                        json_detalle_retencion: list_retencion,
                        json_producto: listaProducto.main.json_producto
                    });

                    var cant = ContabilidadEditar.main.store_lista.getCount();

                    (cant == 0) ? 0: ContabilidadEditar.main.store_lista.getCount() + 1;
                    ContabilidadEditar.main.store_lista.insert(cant, e);

                    ContabilidadEditar.main.gridPanel.getView().refresh();

                    ContabilidadEditar.main.calcularMonto();

                    Ext.utiles.msg('Mensaje', "El material de agrego exitosamente");

                    listaProducto.main.winformPanel_.close();

                }
            });

            this.btnCalcular = new Ext.Button({
                text: 'Calcular',
                iconCls: 'icon-calculator',
                handler: function() {

                    if (listaProducto.main.nu_base_imponible.getValue() == '') {

                        Ext.Msg.show({
                            title: 'ALERTA',
                            msg: 'Debe Ingresar la Base Imponible',
                            //width : 200,
                            height: 800,
                            closable: false,
                            buttons: Ext.Msg.OK,
                            icon: Ext.Msg.INFO
                        });


                    } else if (listaProducto.main.co_iva_factura.getValue() == '') {

                        Ext.Msg.show({
                            title: 'ALERTA',
                            msg: 'Debe seleccionar el IVA de la Factura',
                            //width : 200,
                            height: 800,
                            closable: false,
                            buttons: Ext.Msg.OK,
                            icon: Ext.Msg.INFO
                        });


                    } else if (listaProducto.main.co_iva_retencion.getValue() == '') {

                        Ext.Msg.show({
                            title: 'ALERTA',
                            msg: 'Debe seleccionar el IVA de Retención',
                            //width : 200,
                            height: 800,
                            closable: false,
                            buttons: Ext.Msg.OK,
                            icon: Ext.Msg.INFO
                        });

                    } else {
                        listaProducto.main.calcular();
                    }

                }
            });

            this.salir = new Ext.Button({
                text: 'Salir',
                //    iconCls: 'icon-cancelar',
                handler: function() {
                    listaProducto.main.winformPanel_.close();
                }
            });

            this.formPanel_ = new Ext.form.FormPanel({
                //  frame:true,
                width: 800,
                autoHeight: true,
                autoScroll: true,
                bodyStyle: 'padding:10px;',
                items: [this.fieldDatosFactura,
                    this.fieldDatosRetencion,
                    this.gridPanel,
                    this.fieldDatosPagar
                ]
            });

            this.winformPanel_ = new Ext.Window({
                title: 'Agregar Factura',
                modal: true,
                constrain: true,
                width: 810,
                //  frame:true,
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
        eliminar: function() {
            var s = listaProducto.main.gridPanel.getSelectionModel().getSelections();

            for (var i = 0, r; r = s[i]; i++) {
                listaProducto.main.storeDETALLE_RETENCION.remove(r);
            }

            listaProducto.main.calcular_monto_factura();
            listaProducto.main.botonEliminar.disable();

        },
        getStoreCO_IVA_RETENCION: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoivafactura',
                root: 'data',
                fields: [{
                    name: 'nu_valor'
                }]
            });
            return this.store;
        },
        getStoreCO_IVA_FACTURA: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/storefkcoivafactura',
                root: 'data',
                fields: [{
                    name: 'nu_valor'
                }]
            });
            return this.store;
        },
        getStoreDETALLE_RETENCION: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/calculo',
                root: 'data',
                fields: [{
                        name: 'nu_valor'
                    },
                    {
                        name: 'co_tipo_retencion'
                    },
                    {
                        name: 'po_deduccion'
                    },
                    {
                        name: 'tx_tipo_retencion'
                    }
                ]
            });
            return this.store;
        },
        calcular: function() {

            listaProducto.main.storeDETALLE_RETENCION.baseParams.co_documento = listaProducto.main.OBJ.co_documento;
            listaProducto.main.storeDETALLE_RETENCION.baseParams.co_ramo = listaProducto.main.OBJ.co_ramo;
            listaProducto.main.storeDETALLE_RETENCION.baseParams.co_iva_factura = listaProducto.main.co_iva_factura.getValue();
            listaProducto.main.storeDETALLE_RETENCION.baseParams.nu_base_imponible = listaProducto.main.nu_base_imponible.getValue();
            listaProducto.main.storeDETALLE_RETENCION.baseParams.co_iva_retencion = listaProducto.main.co_iva_retencion.getValue();
            listaProducto.main.storeDETALLE_RETENCION.baseParams.mo_exento = listaProducto.main.mo_exento.getValue();
            listaProducto.main.storeDETALLE_RETENCION.baseParams.co_proveedor = listaProducto.main.OBJ.co_proveedor

            listaProducto.main.storeDETALLE_RETENCION.load({
                callback: function() {
                    listaProducto.main.calcular_monto_factura();
                }
            });
        },
        calcular_monto_factura: function() {
            listaProducto.main.base_imp = listaProducto.main.nu_base_imponible.getValue();
            listaProducto.main.po_iva_factura = listaProducto.main.co_iva_factura.getValue();
            listaProducto.main.po_iva_retencion = listaProducto.main.co_iva_retencion.getValue();

            if (listaProducto.main.mo_exento.getValue() == '') {
                listaProducto.main.mo_exento.setValue(0);
            }

            listaProducto.main.mo_total = listaProducto.main.base_imp + (listaProducto.main.base_imp - listaProducto.main.mo_exento.getValue()) * (listaProducto.main.po_iva_factura / 100);
            listaProducto.main.mo_iva_factura = (listaProducto.main.base_imp - listaProducto.main.mo_exento.getValue()) * (listaProducto.main.po_iva_factura / 100);
            listaProducto.main.mo_iva_retencion = listaProducto.main.mo_iva_factura * (listaProducto.main.po_iva_retencion / 100);

            listaProducto.main.mo_retencion = paqueteComunJS.funcion.getSumaColumnaGrid({
                store: listaProducto.main.storeDETALLE_RETENCION,
                campo: 'nu_valor'
            });

            listaProducto.main.mo_retencion = parseFloat(listaProducto.main.mo_retencion) + parseFloat(listaProducto.main.mo_iva_retencion);
            listaProducto.main.mo_total_pagar = listaProducto.main.mo_total - listaProducto.main.mo_retencion; //-listaProducto.main.mo_iva_retencion;

            listaProducto.main.nu_total.setValue(paqueteComunJS.funcion.getNumeroFormateado(listaProducto.main.mo_total));
            listaProducto.main.nu_iva_factura.setValue(paqueteComunJS.funcion.getNumeroFormateado(listaProducto.main.mo_iva_factura));
            listaProducto.main.nu_iva_retencion.setValue(paqueteComunJS.funcion.getNumeroFormateado(listaProducto.main.mo_iva_retencion));
            listaProducto.main.total_pagar.setValue(paqueteComunJS.funcion.getNumeroFormateado(listaProducto.main.mo_total_pagar));

            listaProducto.main.total_retencion.setValue("<span style='font-size:12px;'><b>Total Retención: </b>" + paqueteComunJS.funcion.getNumeroFormateado(listaProducto.main.mo_retencion) + "</b></span>");

        }
    };
    Ext.onReady(listaProducto.main.init, listaProducto.main);
</script>
<div id="formularioProducto"></div>