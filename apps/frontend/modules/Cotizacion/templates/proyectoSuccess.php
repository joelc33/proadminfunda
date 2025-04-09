<script type="text/javascript">
    Ext.ns("proyecto");
    proyecto.main = {
        init: function () {

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });
            this.store_lista = this.getLista();
            this.storeCO_IVA_FACTURA = this.getStoreCO_IVA_FACTURA();
            this.storeCO_ENTE = this.getStoreCO_ENTE();
            this.storeCO_TIPO_COTIZACION = this.getStoreCO_TIPO_COTIZACION();
            this.storeCO_TPCONTRATO = this.getStoreCO_TPCONTRATO();

            this.co_solicitud = new Ext.form.Hidden({
                name: 'tb206_cotizacion[co_solicitud]',
                value: this.OBJ.co_solicitud
            });

            this.co_requisicion = new Ext.form.Hidden({
                name: 'tb206_cotizacion[co_requisicion]',
                value: this.OBJ.co_requisicion
            });

            this.hiddenJsonProducto = new Ext.form.Hidden({
                name: 'json_producto',
                value: ''
            });

            this.co_tipo_solicitud = new Ext.form.Hidden({
                name: 'tb206_cotizacion[co_tipo_solicitud]',
                value: this.OBJ.co_tipo_solicitud
            });

            this.co_cotizacion = new Ext.form.Hidden({
                name: 'co_cotizacion',
                value: this.OBJ.co_cotizacion
            });

            this.monto_compra = new Ext.form.Hidden({
                name: 'tb206_cotizacion[monto_compra]',
                value: this.OBJ.monto_compra
            });


            this.monto_iva = new Ext.form.Hidden({
                name: 'tb206_cotizacion[monto_iva]',
                value: this.OBJ.monto_iva
            });


            this.monto_total = new Ext.form.Hidden({
                name: 'tb206_cotizacion[monto_total]',
                value: this.OBJ.monto_total
            });

            this.Registro = Ext.data.Record.create([{
                name: 'co_detalle_requisicion',
                type: 'number'
            },
            {
                name: 'co_producto',
                type: 'number'
            },
            {
                name: 'cod_producto',
                type: 'string'
            },
            {
                name: 'tx_producto',
                type: 'string'
            },
            {
                name: 'nu_cantidad',
                type: 'number'
            },
            {
                name: 'precio_unitario',
                type: 'number'
            },
            {
                name: 'monto',
                type: 'number'
            },
            {
                name: 'detalle',
                type: 'string'
            },
            {
                name: 'co_partida',
                type: 'number'
            },
            {
                name: 'co_unidad_producto',
                type: 'number'
            },
            {
                name: 'in_exento',
                type: 'string'
            }
                ,
            {
                name: 'mo_iva_producto',
                type: 'number'
            }
                ,
            {
                name: 'monto_total',
                type: 'number'
            }
            ]);

            this.tx_serial_cotizacion = new Ext.form.TextField({
                fieldLabel: 'Serial',
                width: 300,
                name: 'tb206_cotizacion[tx_serial_cotizacion]',
                value: this.OBJ.tx_serial_cotizacion
            });

            this.fecha = new Ext.form.DateField({
                fieldLabel: 'Fecha',
                name: 'tb206_cotizacion[fecha_cotizacion]',
                value: this.OBJ.fecha_cotizacion,
                allowBlank: false,
                width: 100
            });

            this.tx_observacion = new Ext.form.TextArea({
                fieldLabel: 'Concepto',
                name: 'tb206_cotizacion[tx_observacion]',
                allowBlank: false,
                width: 800,
                value: this.OBJ.tx_observacion,
                allowBlank: false
            });

            this.co_tipo_cotizacion = new Ext.form.ComboBox({
                fieldLabel: 'Tipo',
                store: this.storeCO_TIPO_COTIZACION,
                typeAhead: true,
                valueField: 'co_tipo_cotizacion',
                displayField: 'tx_tipo_cotizacion',
                hiddenName: 'tb008_proveedor[co_documento]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 200,
                allowBlank: false
            });

            this.storeCO_TIPO_COTIZACION.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_tipo_cotizacion,
                value: this.OBJ.co_tipo_cotizacion,
                objStore: this.storeCO_TIPO_COTIZACION
            });

            this.co_tipo_cotizacion = new Ext.form.ComboBox({
                fieldLabel: 'Tipo',
                store: this.storeCO_TIPO_COTIZACION,
                typeAhead: true,
                valueField: 'co_tipo_cotizacion',
                displayField: 'tx_tipo_cotizacion',
                hiddenName: 'tb206_cotizacion[co_tipo_cotizacion]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 415,
                allowBlank: false
            });
            this.storeCO_TPCONTRATO.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_tipo_cotizacion,
                value: this.OBJ.co_tipo_cotizacion,
                objStore: this.storeCO_TPCONTRATO
            });

            this.co_tipo_modalidad = new Ext.form.ComboBox({
                fieldLabel: 'Modalidad',
                store: this.storeCO_TPCONTRATO,
                typeAhead: true,
                valueField: 'co_tp_contrato',
                displayField: 'tx_tp_contrato',
                hiddenName: 'tb206_cotizacion[co_tipo_modalidad]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 415,
                allowBlank: false
            });
            this.storeCO_TPCONTRATO.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_tipo_modalidad,
                value: this.OBJ.co_modalidad,
                objStore: this.storeCO_TPCONTRATO
            });

            this.fieldDatos = new Ext.form.FieldSet({
                title: 'Datos del Presupuesto Base',
                items: [
                    this.hiddenJsonProducto,
                    this.co_requisicion,
                    this.co_tipo_solicitud,
                    this.co_cotizacion,
                    this.fecha,
                    this.tx_serial_cotizacion,
                    this.tx_observacion,
                    this.co_tipo_modalidad,
                    this.co_tipo_cotizacion
                ]
            });

            /*   this.co_iva_factura = new Ext.form.ComboBox({
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
               paqueteComunJS.funcion.seleccionarComboByCo({
                   objCMB: this.co_iva_factura,
                   value: this.OBJ.co_iva_factura,
                   objStore: this.storeCO_IVA_FACTURA
               });*/



            this.agregar = new Ext.Button({
                text: 'Agregar',
                iconCls: 'icon-nuevo',
                handler: function () {

                    /*  if (proyecto.main.co_iva_factura.getValue() == '') {
                          Ext.Msg.alert("Notificación", "Para agregar un producto, debe seleccionar el IVA ");
                          return;
                      }*/

                    this.msg = Ext.get('formularioAgregar');
                    this.msg.load({
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/agregarProducto',
                        params: 'codigo=<?php echo $co_requisicion; ?>',
                        scripts: true,
                        text: "Cargando.."
                    });
                }
            });

            this.displayfieldmonto_compra = new Ext.form.DisplayField({
                value: "<span style='font-size:12px;'><b>Sub Total: </b>" + paqueteComunJS.funcion.getNumeroFormateado(proyecto.main.monto_compra.getValue()) + "</b></span>"
            });
            this.displayfieldmonto_iva = new Ext.form.DisplayField({
                value: "<span style='font-size:12px;'><b>Iva: </b>" + paqueteComunJS.funcion.getNumeroFormateado(proyecto.main.monto_iva.getValue()) + "</b></span>"
            });
            this.displayfieldmonto_total = new Ext.form.DisplayField({
                value: "<span style='font-size:18px;'><b>Total: </b>" + paqueteComunJS.funcion.getNumeroFormateado(proyecto.main.monto_total.getValue()) + "</b></span>"
            });

            function renderMonto(val, attr, record) {
                return paqueteComunJS.funcion.getNumeroFormateado(val);
            }

            this.botonEliminar = new Ext.Button({
                text: 'Eliminar',
                iconCls: 'icon-eliminar',
                id: 'eliminar',
                handler: function (boton) {
                    proyecto.main.eliminar();
                }
            });

            this.botonEliminar.disable();


            this.gridPanel = new Ext.grid.GridPanel({
                title: 'Lista de Materiales',
                iconCls: 'icon-libro',
                store: this.store_lista,
                loadMask: true,
                height: 300,
                width: 1150,
                autoScroll: true,
                tbar: [this.agregar, '-', this.botonEliminar],
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'co_detalle_cotizacion',
                        hidden: true,
                        width: 10,
                        menuDisabled: true,
                        dataIndex: 'co_detalle_cotizacion'
                    },
                    {
                        header: 'co_detalle_requisicion',
                        hidden: true,
                        width: 10,
                        menuDisabled: true,
                        dataIndex: 'co_detalle_requisicion'
                    },
                    {
                        header: 'co_producto',
                        hidden: true,
                        width: 10,
                        menuDisabled: true,
                        dataIndex: 'co_producto'
                    },
                    {
                        header: 'co_iva_producto',
                        hidden: true,
                        width: 10,
                        menuDisabled: true,
                        dataIndex: 'co_iva_producto'
                    },
                    {
                        header: 'Codigo',
                        width: 80,
                        menuDisabled: true,
                        dataIndex: 'cod_producto'
                    },
                    {
                        header: 'Descripción',
                        width: 300,
                        menuDisabled: true,
                        dataIndex: 'tx_producto',
                        renderer: textoLargo
                    },
                    {
                        header: 'Especificaciones',
                        width: 200,
                        menuDisabled: true,
                        dataIndex: 'detalle',
                        renderer: textoLargo
                    },
                    {
                        header: 'Cantidad',
                        width: 60,
                        menuDisabled: true,
                        dataIndex: 'nu_cantidad'
                    },
                    {
                        header: 'Precio Unitario',
                        width: 100,
                        menuDisabled: true,
                        dataIndex: 'precio_unitario',
                        renderer: renderMonto
                    },
                    {
                        header: 'Monto',
                        width: 100,
                        menuDisabled: true,
                        dataIndex: 'monto',
                        renderer: renderMonto
                    },
                    {
                        header: 'IVA',
                        width: 60,
                        menuDisabled: true,
                        dataIndex: 'nu_iva_producto',
                        renderer: renderMonto
                    },
                    {
                        header: 'Monto IVA',
                        width: 100,
                        menuDisabled: true,
                        dataIndex: 'mo_iva_producto',
                        renderer: renderMonto
                    },
                    {
                        header: 'Monto Total',
                        width: 100,
                        menuDisabled: true,
                        dataIndex: 'monto_total',
                        renderer: renderMonto
                    }
                ],
                stripeRows: true,
                autoScroll: true,
                stateful: true,
                listeners: {
                    cellclick: function (Grid, rowIndex, columnIndex, e) {
                        proyecto.main.botonEliminar.enable();
                    }
                }
            });

            //this.store_lista.load();

            this.co_ente = new Ext.form.ComboBox({
                fieldLabel: 'Entregar En',
                store: this.storeCO_ENTE,
                typeAhead: true,
                valueField: 'co_ente',
                displayField: 'tx_ente',
                hiddenName: 'tb206_cotizacion[co_ente]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 387,
                allowBlank: false,
                listeners: {
                    getSelectedIndex: function () {
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


            this.fieldCompra = new Ext.form.FieldSet({
                //title: 'Datos de los Materiales',
                items: [
                    this.co_solicitud,
                    this.co_cotizacion,
                    this.monto_compra,
                    this.monto_iva,
                    this.monto_total,
                    // this.co_iva_factura,
                    this.co_ente,
                    this.gridPanel
                ]
            });


            this.formPanel_ = new Ext.form.FormPanel({
                //  frame:true,
                width: 1200,
                autoHeight: true,
                autoScroll: true,
                bodyStyle: 'padding:10px;',
                items: [this.fieldDatos, this.fieldCompra]
            });

            this.guardar = new Ext.Button({
                text: 'Guardar',
                iconCls: 'icon-guardar',
                handler: function () {

                    var list_producto = paqueteComunJS.funcion.getJsonByObjStore({
                        store: proyecto.main.gridPanel.getStore()
                    });

                    proyecto.main.hiddenJsonProducto.setValue(list_producto);

                    proyecto.main.formPanel_.getForm().submit({
                        method: 'POST',
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/guardar',
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
                            /*proyecto.main.store_lista.baseParams.co_compras=proyecto.main.OBJ.co_compras;
                            proyecto.main.store_lista.load({
                                callback: function(){
                                   proyecto.main.getTotal();
                                }
                            });*/

                            pendienteEntidadesLista.main.store_lista.baseParams.paginar = 'si';
                            pendienteEntidadesLista.main.store_lista.load();
                            pendienteEntidadesLista.main.store_lista.on('load', function () {
                                pendienteEntidadesLista.main.estado.disable();
                                pendienteEntidadesLista.main.revision.disable();
                            });

                            proyecto.main.winformPanel_.close();
                        }
                    });

                }
            });

            this.salir = new Ext.Button({
                text: 'Salir',
                //    iconCls: 'icon-cancelar',
                handler: function () {
                    proyecto.main.winformPanel_.close();
                }
            });


            if (this.OBJ.co_cotizacion != '') {

                proyecto.main.store_lista.baseParams.co_cotizacion = this.OBJ.co_cotizacion;
                this.store_lista.load({
                    callback: function () {
                        proyecto.main.getTotal();
                        proyecto.main.getVerificarIVA();
                    }
                });

            }

            this.winformPanel_ = new Ext.Window({
                title: 'Proyecto',
                modal: true,
                constrain: true,
                width: 1210,
                //  frame:true,
                closabled: true,
                autoHeight: true,
                items: [
                    this.formPanel_
                ],
                bbar: new Ext.ux.StatusBar({
                    id: 'basic-statusbar',
                    autoScroll: true,
                    defaults: {
                        style: 'color:black;font-size:30px;',
                        autoWidth: true
                    },
                    items: [
                        this.displayfieldmonto_compra, '-',
                        this.displayfieldmonto_iva, '-',
                        this.displayfieldmonto_total
                    ]
                }),
                buttons: [
                    this.guardar,
                    this.salir
                ],
                buttonAlign: 'center'
            });
            this.winformPanel_.show();

        },
        eliminar: function () {
            var s = proyecto.main.gridPanel.getSelectionModel().getSelections();

            var co_detalle_cotizacion = proyecto.main.gridPanel.getSelectionModel().getSelected().get('co_detalle_cotizacion');

            if (co_detalle_cotizacion != '') {

                Ext.Ajax.request({
                    method: 'POST',
                    url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/eliminarMaterial',
                    params: {
                        co_detalle_cotizacion: co_detalle_cotizacion
                    },
                    success: function (result, request) {
                        //proyecto.main.store_lista.load();
                        Ext.utiles.msg('Mensaje', "El producto se eliminó exitosamente");
                    }
                });

            }

            for (var i = 0, r; r = s[i]; i++) {
                proyecto.main.store_lista.remove(r);
            }
        },
        getTotal: function () {

            this.monto = 0;
            this.cancelar = 0;
            this.tcancelar = 0;
            this.totaliva = 0;
            this.iva = 0;



            this.monto = paqueteComunJS.funcion.getSumaColumnaGrid({
                store: proyecto.main.store_lista,
                campo: 'monto'
            });

            this.monto_iva = paqueteComunJS.funcion.getSumaColumnaGrid({
                store: proyecto.main.store_lista,
                campo: 'mo_iva_producto'
            });

            this.monto_total = paqueteComunJS.funcion.getSumaColumnaGrid({
                store: proyecto.main.store_lista,
                campo: 'monto_total'
            });

            proyecto.main.displayfieldmonto_compra.setValue("<span style='font-size:12px;'><b>Sub Total Compra: </b>" + paqueteComunJS.funcion.getNumeroFormateado(this.monto) + "</b></span>");
            proyecto.main.displayfieldmonto_iva.setValue("<span style='font-size:12px;'><b>Iva: </b>" + paqueteComunJS.funcion.getNumeroFormateado(this.monto_iva) + "</b></span>");
            proyecto.main.displayfieldmonto_total.setValue("<span style='font-size:12px;'><b>Total Compra: </b>" + paqueteComunJS.funcion.getNumeroFormateado(this.monto_total) + "</b></span>");


        },
        getLista: function () {

            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/storelistamateriales',
                root: 'data',
                fields: [{
                    name: 'co_detalle_cotizacion'
                },
                {
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
                    name: 'precio_unitario'
                },
                {
                    name: 'detalle'
                },
                {
                    name: 'monto'
                },
                {
                    name: 'co_requisicion'
                },
                {
                    name: 'in_exento'
                },
                {
                    name: 'co_iva_producto'
                },
                {
                    name: 'nu_iva_producto'
                },
                {
                    name: 'mo_iva_producto'
                },
                {
                    name: 'monto_total'
                }
                ]
            });
            return this.store;
        },
        getStoreCO_TPCONTRATO: function () {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcotpcontrato',
                root: 'data',
                fields: [{
                    name: 'co_tp_contrato'
                },
                {
                    name: 'tx_tp_contrato'
                }
                ]
            });
            return this.store;
        },
        getStoreCO_TIPO_COTIZACION: function () {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/storefkcotipocotizacion',
                root: 'data',
                fields: [{
                    name: 'co_tipo_cotizacion'
                },
                {
                    name: 'tx_tipo_cotizacion'
                }
                ]
            });
            return this.store;
        },
        getStoreCO_IVA_FACTURA: function () {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoivafactura',
                root: 'data',
                fields: [{
                    name: 'nu_valor'
                }]
            });
            return this.store;
        },
        getStoreCO_ENTE: function () {
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
        },
        getVerificarIVA: function () {

            /*  var cant = paqueteComunJS.funcion.getSumaColumnaGrid({
                  store: proyecto.main.store_lista,
                  campo: 'monto'
              });
  
  
              if (cant > 0) {
                  Ext.get('co_iva_factura').setStyle('background-color', '#c9c9c9');
                  proyecto.main.co_iva_factura.setReadOnly(true);
              } else {
                  Ext.get('co_iva_factura').setStyle('background-color', '#FFFFFF');
                  proyecto.main.co_iva_factura.setReadOnly(false);
              }*/
        }
    };
    Ext.onReady(proyecto.main.init, proyecto.main);
</script>
<div id="formularioAgregar"></div>