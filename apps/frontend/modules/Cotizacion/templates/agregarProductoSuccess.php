<script type="text/javascript">
    Ext.ns("listaProducto");
    listaProducto.main = {
        init: function() {

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });
            this.storeCO_UNIDAD = this.getStoreCO_UNIDAD();
            this.store_lista = this.getStoreCO_PRODUCTO();
            this.storeCO_PARTIDA = this.getStoreCO_PARTIDA();
            this.storeCO_IVA_FACTURA = this.getStoreCO_IVA_FACTURA();

            this.co_producto = new Ext.form.Hidden({
                name: 'co_producto'
            });

            this.co_detalle_requisicion = new Ext.form.Hidden({
                name: 'co_detalle_requisicion'
            });

            this.tx_codigo = new Ext.form.TextField({
                fieldLabel: 'Código',
                name: 'codigo',
                allowBlank: false,
                width: 80
            });

            this.tx_descripcion = new Ext.form.TextField({
                fieldLabel: 'Producto',
                name: 'producto',
                allowBlank: false,
                width: 510,
                listeners: {
                    change: function(field, newValue, oldValue) {
                        field.setValue(newValue.toUpperCase());
                    }
                }
            });

            this.formFiltroPrincipal = new Ext.form.FormPanel({
                title: 'Buscar Materiales',
                titleCollapse: true,
                width: 800,
                border: true,
                padding: '10px',
                items: [this.tx_codigo,
                    this.tx_descripcion
                ],
                keys: [{
                    key: [Ext.EventObject.ENTER],
                    handler: function() {
                        listaProducto.main.aplicarFiltroByFormulario();
                    }
                }],
                buttonAlign: 'center',
                buttons: [{
                        text: 'Consultar',
                        iconCls: 'icon-buscar',
                        handler: function() {
                            listaProducto.main.aplicarFiltroByFormulario();
                        }
                    },
                    {
                        text: 'Limpiar',
                        iconCls: 'icon-limpiar',
                        handler: function() {
                            listaProducto.main.limpiarCamposByFormFiltro();
                        }
                    }
                ]
            });




            this.cod_producto = new Ext.form.TextField({
                fieldLabel: 'Código',
                name: 'cod_producto',
                allowBlank: false,
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 80
            });

            this.tx_producto = new Ext.form.TextField({
                fieldLabel: 'Producto',
                name: 'tx_producto',
                allowBlank: false,
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 510
            });


            this.nu_cantidad = new Ext.form.NumberField({
                fieldLabel: 'Cantidad',
                name: 'nu_cantidad',
                allowBlank: false,
                width: 80
            });

            this.co_unidad_producto = new Ext.form.ComboBox({
                fieldLabel: 'Unidad',
                store: this.storeCO_UNIDAD,
                typeAhead: true,
                valueField: 'co_unidad_producto',
                displayField: 'tx_unidad_producto',
                hiddenName: 'co_unidad_producto',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: '...',
                selectOnFocus: true,
                mode: 'local',
                width: 120,
                allowBlank: false
            });

            this.precio_unitario = new Ext.form.NumberField({
                fieldLabel: 'Precio Unitario',
                name: 'precio_unitario',
                allowBlank: false,
                width: 120
            });

            this.detalle_producto = new Ext.form.TextField({
                fieldLabel: 'Especificaciones',
                name: 'detalle_producto',
                allowBlank: false,
                width: 600
            });

            this.co_iva_factura = new Ext.form.ComboBox({
                fieldLabel: 'IVA',
                store: this.storeCO_IVA_FACTURA,
                typeAhead: true,
                valueField: 'nu_valor',
                displayField: 'nu_valor',
                id: 'co_iva_factura',
                hiddenName: 'tb206_cotizacion[co_iva_factura]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 50,
                allowBlank: false
            });

            this.storeCO_IVA_FACTURA.load();

            this.co_partida = new Ext.form.ComboBox({
                fieldLabel: 'Partida',
                store: this.storeCO_PARTIDA,
                typeAhead: true,
                valueField: 'id',
                displayField: 'de_partida',
                hiddenName: 'co_partida',
                forceSelection: true,
                resizable: true,
                forceAll: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 600,
                allowBlank: false,
                listeners: {
                    'beforequery': function() {
                        this.onLoad();
                        this.store.filter('de_partida', this.getRawValue(), true, false);
                        this.expand();
                        // prevent doQuery from firing and clearing out my filter.
                        return false;
                    }
                }

            });

            this.compositefield = new Ext.form.CompositeField({
                fieldLabel: 'Producto',
                width: 600,
                items: [
                    this.cod_producto,
                    this.tx_producto
                ]
            });


            this.in_exento = new Ext.form.Checkbox({
                fieldLabel: 'Exento Iva',
                name: 'in_exento',
                listeners: {
                    check: function(checkbox, isChecked) {
                       if(this.getValue()){
                        listaProducto.main.co_iva_factura.setValue(0);
                        listaProducto.main.co_iva_factura.readOnly = true;                        
                       }else{
                        listaProducto.main.co_iva_factura.readOnly = false;                        
                       }
                    }

                }
            });

            this.fieldDatos = new Ext.form.FieldSet({
                title: 'Datos del Material Seleccionado',
                items: [this.compositefield,
                    this.nu_cantidad,
                    this.in_exento,
                    this.co_iva_factura,
                    this.co_unidad_producto,
                    this.precio_unitario,
                    this.detalle_producto
                    //this.co_partida
                ]
            });

            this.gridPanel = new Ext.grid.GridPanel({
                title: 'Lista de Materiales',
                iconCls: 'icon-libro',
                store: this.store_lista,
                loadMask: true,
                height: 200,
                width: 750,
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'co_producto',
                        hidden: true,
                        width: 80,
                        menuDisabled: true,
                        dataIndex: 'co_producto'
                    },
                    {
                        header: 'co_detalle_requisicion',
                        hidden: true,
                        width: 80,
                        menuDisabled: true,
                        dataIndex: 'co_detalle_requisicion'
                    },
                    {
                        header: 'Codigo',
                        width: 80,
                        menuDisabled: true,
                        dataIndex: 'cod_producto'
                    },
                    {
                        header: 'Descripción',
                        width: 420,
                        menuDisabled: true,
                        dataIndex: 'tx_producto',
                        renderer: textoLargo
                    },
                    {
                        header: 'Cantidad',
                        width: 100,
                        menuDisabled: true,
                        dataIndex: 'nu_cantidad'
                    },
                    {
                        header: 'Unidad',
                        width: 100,
                        menuDisabled: true,
                        dataIndex: 'tx_unidad_producto'
                    },
                ],
                stripeRows: true,
                autoScroll: true,
                stateful: true,
                listeners: {
                    cellclick: function(Grid, rowIndex, columnIndex, e) {
                        // ProveedorEditar.main.botonEliminar.enable();

                        listaProducto.main.co_producto.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('co_producto'));
                        listaProducto.main.cod_producto.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('cod_producto'));
                        listaProducto.main.tx_producto.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('tx_producto'));
                        listaProducto.main.nu_cantidad.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('nu_cantidad'));
                        listaProducto.main.detalle_producto.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('tx_observacion'));
                        listaProducto.main.co_detalle_requisicion.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('co_detalle_requisicion'));

                        listaProducto.main.co_partida.clearValue();
                        listaProducto.main.storeCO_PARTIDA.removeAll();

                        listaProducto.main.storeCO_PARTIDA.load({
                            params: {
                                co_clase: listaProducto.main.store_lista.getAt(rowIndex).get('co_clase')

                            }
                        });



                        listaProducto.main.storeCO_UNIDAD.load();
                        listaProducto.main.storeCO_UNIDAD.on('load', function() {
                            if (listaProducto.main.store_lista.getAt(rowIndex).get('co_unidad_producto') != '') {
                                listaProducto.main.co_unidad_producto.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('co_unidad_producto'));
                                try {
                                    listaProducto.main.co_unidad_producto.selectByValue(listaProducto.main.store_lista.getAt(rowIndex).get('co_unidad_producto'));

                                } catch (err) {}
                            }
                        });
                    }
                },
                bbar: new Ext.PagingToolbar({
                    pageSize: 8,
                    store: this.store_lista,
                    displayInfo: true,
                    displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
                    emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
                })
            });

            var list_producto = paqueteComunJS.funcion.getJsonByObjStore({
                store: proyecto.main.gridPanel.getStore()
            });

            listaProducto.main.store_lista.baseParams.lista_producto = list_producto;
            this.store_lista.baseParams.co_requisicion = this.OBJ.co_requisicion;
            this.store_lista.load();

            this.fieldDatosGrid = new Ext.form.FieldSet({
                items: [this.gridPanel]
            });
            this.guardar = new Ext.Button({
                text: 'Agregar',
                iconCls: 'icon-guardar',
                handler: function() {

                    if (!listaProducto.main.formPanel_.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
                        return false;
                    }

                    var porc_iva = listaProducto.main.co_iva_factura.lastSelectionText;
                    var mo_iva_producto = (listaProducto.main.precio_unitario.getValue() * listaProducto.main.nu_cantidad.getValue()) * (parseFloat(porc_iva) / 100);
                    var monto_total_producto = (listaProducto.main.precio_unitario.getValue() * listaProducto.main.nu_cantidad.getValue()) + mo_iva_producto;



                    var e = new proyecto.main.Registro({
                        co_producto: listaProducto.main.co_producto.getValue(),
                        co_detalle_requisicion: listaProducto.main.co_detalle_requisicion.getValue(),
                        cod_producto: listaProducto.main.cod_producto.getValue(),
                        tx_producto: listaProducto.main.tx_producto.getValue(),
                        nu_cantidad: listaProducto.main.nu_cantidad.getValue(),
                        precio_unitario: listaProducto.main.precio_unitario.getValue(),
                        monto: listaProducto.main.precio_unitario.getValue() * listaProducto.main.nu_cantidad.getValue(),
                        monto_total: monto_total_producto,
                        detalle: listaProducto.main.detalle_producto.getValue(),
                        co_partida: listaProducto.main.co_partida.getValue(),
                        co_iva_producto: listaProducto.main.co_iva_factura.getValue(),
                        nu_iva_producto: listaProducto.main.co_iva_factura.lastSelectionText,
                        mo_iva_producto: mo_iva_producto,
                        co_unidad_producto: listaProducto.main.co_unidad_producto.getValue(),
                        in_exento: listaProducto.main.in_exento.getValue()
                    });

                    var cant = proyecto.main.store_lista.getCount();
                    (cant == 0) ? 0: proyecto.main.store_lista.getCount() + 1;
                    proyecto.main.store_lista.insert(cant, e);

                    proyecto.main.gridPanel.getView().refresh();


                    var list_producto = paqueteComunJS.funcion.getJsonByObjStore({
                        store: proyecto.main.gridPanel.getStore()
                    });

                    listaProducto.main.co_producto.setValue("");
                    listaProducto.main.cod_producto.setValue("");
                    listaProducto.main.tx_producto.setValue("");
                    listaProducto.main.nu_cantidad.setValue("");
                    listaProducto.main.precio_unitario.setValue("");
                    listaProducto.main.detalle_producto.setValue("");
                    listaProducto.main.co_partida.clearValue();
                    listaProducto.main.co_unidad_producto.clearValue();

                    listaProducto.main.store_lista.baseParams.lista_producto = list_producto;
                    listaProducto.main.store_lista.baseParams.co_requisicion = listaProducto.main.OBJ.co_requisicion;
                    listaProducto.main.store_lista.load();
                    proyecto.main.getTotal();

                    proyecto.main.getVerificarIVA();

                    Ext.utiles.msg('Mensaje', "El producto se agrego exitosamente");

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
                items: [
                    this.fieldDatosGrid,
                    this.fieldDatos
                ]
            });

            this.winformPanel_ = new Ext.Window({
                title: 'Lista de Materiales',
                modal: true,
                constrain: true,
                width: 810,
                //  frame:true,
                closabled: true,
                autoHeight: true,
                items: [
                    this.formFiltroPrincipal,
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
        aplicarFiltroByFormulario: function() {
            //Capturamos los campos con su value para posteriormente verificar cual
            //esta lleno y trabajar en base a ese.
            var campo = listaProducto.main.formFiltroPrincipal.getForm().getValues();

            listaProducto.main.store_lista.baseParams = {}

            var swfiltrar = false;
            for (campName in campo) {
                if (campo[campName] != '') {
                    swfiltrar = true;
                    eval("listaProducto.main.store_lista.baseParams." + campName + " = '" + campo[campName] + "';");
                }
            }
            if (swfiltrar == true) {

                var list_producto = paqueteComunJS.funcion.getJsonByObjStore({
                    store: proyecto.main.gridPanel.getStore()
                });

                listaProducto.main.store_lista.baseParams.lista_producto = list_producto;
                listaProducto.main.store_lista.load();
            } else {
                listaProducto.main.formFiltroPrincipal.getForm().reset();
                var list_producto = paqueteComunJS.funcion.getJsonByObjStore({
                    store: proyecto.main.gridPanel.getStore()
                });

                listaProducto.main.store_lista.baseParams.lista_producto = list_producto;
                listaProducto.main.store_lista.load();
            }

        },
        limpiarCamposByFormFiltro: function() {
            listaProducto.main.formFiltroPrincipal.getForm().reset();
            listaProducto.main.store_lista.baseParams.co_requisicion = listaProducto.main.OBJ.co_requisicion;
            listaProducto.main.store_lista.load();

        },
        getStoreCO_PRODUCTO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoproducto',
                root: 'data',
                fields: [{
                        name: 'co_detalle_requisicion'
                    },
                    {
                        name: 'co_producto'
                    },
                    {
                        name: 'cod_producto'
                    },
                    {
                        name: 'tx_producto'
                    },
                    {
                        name: 'nu_cantidad'
                    },
                    {
                        name: 'tx_unidad_producto'
                    },
                    {
                        name: 'co_unidad_producto'
                    },
                    {
                        name: 'co_clase'
                    },
                    {
                        name: 'tx_observacion'
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_IVA_FACTURA: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoivafactura',
                root: 'data',
                fields: [{
                    name: 'nu_valor'
                }]
            });
            return this.store;
        },
        getStoreCO_PARTIDA: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcopartida',
                root: 'data',
                fields: [{
                        name: 'id'
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
        getStoreCO_UNIDAD: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcounidadproducto',
                root: 'data',
                fields: [{
                        name: 'co_unidad_producto'
                    },
                    {
                        name: 'tx_unidad_producto'
                    }
                ]
            });
            return this.store;
        }
    };
    Ext.onReady(listaProducto.main.init, listaProducto.main);
</script>