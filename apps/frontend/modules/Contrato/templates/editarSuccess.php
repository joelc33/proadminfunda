<script type="text/javascript">
    Ext.ns("ComprasEditar");
    ComprasEditar.main = {
        init: function() {

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });
            this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
            this.storeCO_RAMO = this.getStoreCO_RAMO();
            this.storeCO_IVA_FACTURA = this.getStoreCO_IVA_FACTURA();
            this.storeCO_ENTE = this.getStoreCO_ENTE();
            this.storeCO_TPCONTRATO = this.getStoreCO_TPCONTRATO();
            this.storeCO_FUENTEFINANCIAMIENTO = this.getStoreCO_FUENTEFINANCIAMIENTO();
            this.storeCO_TIPO_PROCESO = this.getStoreCO_TIPO_PROCESO();
            this.store_lista = this.getLista();

            this.Registro = Ext.data.Record.create([{
                    name: 'co_detalle_requisicion',
                    type: 'number'
                },
                {
                    name: 'co_detalle_cotizacion',
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
                    name: 'co_presupuesto',
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
            ]);

            //<ClavePrimaria>
            this.co_compras = new Ext.form.Hidden({
                name: 'co_compras',
                value: this.OBJ.co_compras
            });
            //</ClavePrimaria>

            this.co_solicitud_cotizacion = new Ext.form.Hidden({
                name: 'co_solicitud_cotizacion',
                value: this.OBJ.co_solicitud_cotizacion
            });

            this.co_requisicion = new Ext.form.Hidden({
                name: 'tb052_compras[co_requisicion]',
                value: this.OBJ.co_requisicion,
                allowBlank: false
            });

            this.co_solicitud = new Ext.form.Hidden({
                name: 'tb052_compras[co_solicitud]',
                value: this.OBJ.co_solicitud,
                allowBlank: false
            });

            /*this.co_tipo_solicitud = new Ext.form.Hidden({
                name: 'tb052_compras[co_tipo_solicitud]',
                value: this.OBJ.co_tipo_solicitud,
                allowBlank: false
            });*/

            this.co_contrato_compras = new Ext.form.Hidden({
                name: 'tb052_compras[co_contrato_compras]',
                value: this.OBJ.co_contrato_compras,
                allowBlank: false
            });

            this.hiddenJsonProducto = new Ext.form.Hidden({
                name: 'json_producto',
                value: ''
            });

            this.co_proveedor = new Ext.form.Hidden({
                name: 'tb008_proveedor[co_proveedor]',
                value: this.OBJ.co_proveedor
            });

            this.monto_compra = new Ext.form.Hidden({
                name: 'tb052_compras[monto_compra]',
                value: this.OBJ.monto_compra
            });

            this.monto_iva = new Ext.form.Hidden({
                name: 'tb052_compras[monto_iva]',
                value: this.OBJ.monto_iva
            });

            this.monto_total = new Ext.form.Hidden({
                name: 'tb052_compras[monto_total]',
                value: this.OBJ.monto_total
            });

            this.in_responsabilidad_social = new Ext.form.Checkbox({
                fieldLabel: 'Compromiso de Responsabilidad Social',
                style: (this.OBJ.co_factura != '') ? 'background:#c9c9c9;' : '',
                name: 'tb052_compras[in_responsabilidad_social]',
                checked: (this.OBJ.in_responsabilidad_social == '1') ? true : false
            });


            /*this.nu_compra = new Ext.form.DisplayField({
                value: "<span style='color:black;font-size:15px;'><b>N° Contrato: </b>" + ComprasEditar.main.OBJ.nu_compra + "</b></span>"
            });*/

            this.nu_compra = new Ext.form.TextField({
                fieldLabel: 'Nro Proceso',
                name: 'tb052_compras[nu_compra]',
                value: ComprasEditar.main.OBJ.nu_compra,
                width: 250
            });

            this.co_documento = new Ext.form.ComboBox({
                fieldLabel: 'Co documento',
                store: this.storeCO_DOCUMENTO,
                typeAhead: true,
                valueField: 'co_documento',
                displayField: 'inicial',
                hiddenName: 'tb008_proveedor[co_documento]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                readOnly: (this.OBJ.co_factura != '') ? true : false,
                style: (this.OBJ.co_factura != '') ? 'background:#c9c9c9;' : '',
                mode: 'local',
                width: 50,
                allowBlank: false
            });
            this.storeCO_DOCUMENTO.load();

            this.co_tipo_proceso = new Ext.form.ComboBox({
                fieldLabel: 'Tipo Proceso',
                store: this.storeCO_TIPO_PROCESO,
                typeAhead: true,
                valueField: 'co_tipo_solicitud',
                displayField: 'tx_tipo_solicitud',
                hiddenName: 'tb052_compras[co_tipo_solicitud]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 300,
                allowBlank: false
            });
            this.storeCO_TIPO_PROCESO.load();

            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_documento,
                value: (this.OBJ.co_documento == '') ? 4 : this.OBJ.co_documento,
                objStore: this.storeCO_DOCUMENTO
            });

            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_tipo_proceso,
                value: this.OBJ.co_tipo_solicitud,
                objStore: this.storeCO_TIPO_PROCESO
            });

            this.tx_rif = new Ext.form.TextField({
                name: 'tb008_proveedor[tx_rif]',
                value: this.OBJ.tx_rif,
                readOnly: (this.OBJ.co_factura != '') ? true : false,
                style: (this.OBJ.co_factura != '') ? 'background:#c9c9c9;' : '',
                allowBlank: false,
                width: 130
            });
            this.co_documento.on("blur", function() {
                if (ComprasEditar.main.tx_rif.getValue() != '') {
                    ComprasEditar.main.verificarProveedor();
                }
            });

            this.tx_rif.on("blur", function() {
                ComprasEditar.main.verificarProveedor();
            });

            this.compositefieldCIRIF = new Ext.form.CompositeField({
                fieldLabel: 'Cedula/Rif',
                width: 190,
                items: [
                    this.co_documento,
                    this.tx_rif,
                ]
            });


            this.tx_razon_social = new Ext.form.TextField({
                fieldLabel: 'Razon Social',
                name: 'tb008_proveedor[tx_razon_social]',
                value: this.OBJ.tx_razon_social,
                readOnly:  true,
                style: 'background:#c9c9c9;',
                allowBlank: false,
                width: 770
            });

            this.tx_direccion = new Ext.form.TextField({
                fieldLabel: 'Direccion',
                name: 'tb008_proveedor[tx_direccion]',
                value: this.OBJ.tx_direccion,
                allowBlank: false,
                readOnly: (this.OBJ.co_factura != '') ? true : false,
                style: (this.OBJ.co_factura != '') ? 'background:#c9c9c9;' : '',
                width: 770
            });

            this.co_ramo = new Ext.form.ComboBox({
                fieldLabel: 'Ramo',
                store: this.storeCO_RAMO,
                typeAhead: true,
                valueField: 'co_ramo',
                displayField: 'tx_ramo',
                hiddenName: 'tb052_compras[co_ramo]',
                forceSelection: true,
                resizable: true,
                readOnly: (this.OBJ.co_factura != '') ? true : false,
                style: (this.OBJ.co_factura != '') ? 'background:#c9c9c9;' : '',
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 415,
                allowBlank: false,
                listeners: {
                    getSelectedIndex: function() {
                        var v = this.getValue();
                        var r = this.findRecord(this.valueField || this.displayField, v);
                        return (this.storeCO_RAMO.indexOf(r));
                    }
                }

            });
            if (this.OBJ.co_proveedor != '') {
                this.storeCO_RAMO.load({
                    params: {
                        co_proveedor: this.OBJ.co_proveedor
                    }
                });
            }
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_ramo,
                value: this.OBJ.co_ramo,
                objStore: this.storeCO_RAMO
            });

            this.fieldProveedor = new Ext.form.FieldSet({
                title: 'Datos del Proveedor',
                items: [
                    this.compositefieldCIRIF,
                    this.tx_razon_social,
                    //  this.tx_direccion,
                    //this.co_ramo
                ]
            });

            this.co_tp_contrato = new Ext.form.ComboBox({
                fieldLabel: 'Tipo de Contrato',
                store: this.storeCO_TPCONTRATO,
                typeAhead: true,
                valueField: 'co_tp_contrato',
                displayField: 'tx_tp_contrato',
                hiddenName: 'tb052_compras[co_tp_contrato]',
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
                objCMB: this.co_tp_contrato,
                value: this.OBJ.co_tp_contrato,
                objStore: this.storeCO_TPCONTRATO
            });


            this.fecha_inicio = new Ext.form.DateField({
                fieldLabel: 'Fecha Inicio',
                name: 'tb052_compras[fecha_inicio]',
                value: this.OBJ.fecha_inicio,
                allowBlank: false,
                width: 100
            });
            this.fecha_fin = new Ext.form.DateField({
                fieldLabel: 'Fecha Fin',
                name: 'tb052_compras[fecha_fin]',
                value: this.OBJ.fecha_fin,
                allowBlank: false,
                width: 100
            });
            this.tx_entrega = new Ext.form.TextField({
                fieldLabel: 'Plazo de Entrega',
                name: 'tb052_compras[tx_entrega]',
                value: this.OBJ.tx_entrega,
                allowBlank: false,
                width: 775
            });

            this.PanelFecha = new Ext.Panel({
                items: [{
                    layout: 'column',
                    defaults: {
                        layout: 'form'
                    },
                    items: [{
                            labelWidth: 100,
                            columnWidth: .16,
                            items: [this.fecha_inicio]
                        },
                        {
                            labelWidth: 70,
                            columnWidth: .15,
                            items: [this.fecha_fin]
                        },
                        /*{
                            labelWidth: 100,
                            columnWidth: .3,
                            items: [this.fecha_entrega]
                        }*/
                    ]
                }]
            });

            this.forma_pago = new Ext.form.TextField({
                fieldLabel: 'Forma de Pago',
                name: 'tb052_compras[forma_pago]',
                value: 'CREDITO',
                readOnly: true,
                allowBlank: false,
                width: 200
            });

            this.monto_contrato = new Ext.form.Hidden({
                fieldLabel: 'Monto Presupuesto',
                name: 'tb052_compras[monto]',
                value: this.OBJ.monto,
                readOnly: true,
                style: (this.OBJ.co_factura != '') ? 'background:#c9c9c9;' : '',
                allowBlank: false,
                width: 200
            });

            /*this.Panelforma = new Ext.Panel({
                items: [{
                    layout: 'column',
                    defaults: {
                        layout: 'form'
                    },
                    items: [{
                            labelWidth: 100,
                            columnWidth: .5,
                            items: [this.monto_contrato]
                        },
                        {
                            labelWidth: 120,
                            columnWidth: .5,
                            items: [this.forma_pago]
                        }
                    ]
                }]
            });*/

            this.tiempo_garantia = new Ext.form.TextField({
                fieldLabel: 'Garantia',
                name: 'tb052_compras[tiempo_garantia]',
                value: this.OBJ.tiempo_garantia,
                width: 200
            });

            this.forma_entrega = new Ext.form.TextField({
                fieldLabel: 'Forma de Entrega',
                name: 'tb052_compras[forma_entrega]',
                value: this.OBJ.forma_entrega,
                allowBlank: false,
                width: 200
            });

            this.Paneltiempo = new Ext.Panel({
                items: [{
                    layout: 'column',
                    defaults: {
                        layout: 'form'
                    },
                    items: [{
                            labelWidth: 100,
                            columnWidth: .5,
                            items: [this.tiempo_garantia]
                        },
                        {
                            labelWidth: 120,
                            columnWidth: .5,
                            items: [this.forma_entrega]
                        }
                    ]
                }]
            });

            this.nu_orden_compra = new Ext.form.TextField({
                fieldLabel: 'Nro. Proceso',
                name: 'tb052_compras[nu_orden_compra]',
                value: this.OBJ.nu_orden_compra,
                allowBlank: false,
                width: 200
            });

            this.tx_serial_cotizacion = new Ext.form.TextField({
                fieldLabel: 'Código',
                name: 'tb052_compras[tx_serial_cotizacion]',
                value: this.OBJ.tx_serial_cotizacion,
                allowBlank: false,
                width: 238,
                readOnly: true,
                style: 'background:#c9c9c9;',
            });

            this.tx_observacion = new Ext.form.TextArea({
                fieldLabel: 'Anexos',
                name: 'tb052_compras[tx_observacion]',
                value: this.OBJ.tx_observacion,
                allowBlank: false,
                width: 775
                // readOnly:true,
                // style:'background:#c9c9c9;',
            });

            this.tx_concepto = new Ext.form.TextArea({
                fieldLabel: 'Concepto',
                name: 'tb052_compras[tx_concepto]',
                value: this.OBJ.tx_concepto,
                allowBlank: false,
                width: 775
            });

            this.buscar = new Ext.Button({
                text: 'Buscar',
                iconCls: 'icon-buscar',
                handler: function() {

                    if (ComprasEditar.main.co_tipo_proceso.getValue() == null) {
                        Ext.MessageBox.show({
                            title: 'Mensaje',
                            msg: 'Debe Seleccionar el Tipo de Proceso',
                            closable: false,
                            icon: Ext.MessageBox.INFO,
                            resizable: false,
                            animEl: document.body,
                            buttons: Ext.MessageBox.OK
                        });

                    } else {
                        this.msg = Ext.get('formularioAgregar');
                        this.msg.load({
                            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Cotizacion/buscarPresupuestoBase',
                            params: {
                                co_tipo_solicitud: ComprasEditar.main.co_tipo_proceso.getValue(),
                                co_tipo_tramite: 64
                            },
                            scripts: true,
                            text: "Cargando.."
                        });
                    }


                }
            });



            this.compositefieldPresupuestoBase = new Ext.form.CompositeField({
                fieldLabel: 'Codigo',
                width: 310,
                items: [
                    this.tx_serial_cotizacion,
                    this.buscar,
                ]
            });


            this.fieldPresupuesto = new Ext.form.FieldSet({
                title: 'Presupuesto Base',
                items: [
                    this.co_tipo_proceso,
                    this.compositefieldPresupuestoBase
                ]
            });

            this.fieldContrato = new Ext.form.FieldSet({
                title: 'Datos de la Orden de Compra',
                items: [
                    this.nu_compra,
                    this.tx_concepto,
                    //this.tx_observacion,
                    //   this.co_tp_contrato,
                   // this.nu_orden_compra,
//                    this.PanelFecha,
                    this.tx_entrega,
                    this.in_responsabilidad_social,
                    this.monto_contrato,
                    //     this.Panelforma,
                    //     this.Paneltiempo,
                    this.tx_observacion,
                ]
            });


            this.fecha_compra = new Ext.form.DateField({
                fieldLabel: 'Fecha Compra',
                name: 'tb052_compras[fecha_compra]',
                value: this.OBJ.fecha_compra,
                maxValue: new Date(),
                allowBlank: false,
                width: 100
            });

            this.co_iva_factura = new Ext.form.ComboBox({
                fieldLabel: 'IVA',
                store: this.storeCO_IVA_FACTURA,
                typeAhead: true,
                valueField: 'nu_valor',
                displayField: 'nu_valor',
                id: 'co_iva_factura',
                hiddenName: 'tb052_compras[co_iva_factura]',
                forceSelection: true,
                resizable: true,
                readOnly: (this.OBJ.co_factura != '') ? true : false,
                style: (this.OBJ.co_factura != '') ? 'background:#c9c9c9;' : '',
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
            });

            this.co_ente = new Ext.form.ComboBox({
                fieldLabel: 'Entregar En',
                store: this.storeCO_ENTE,
                typeAhead: true,
                valueField: 'co_ente',
                displayField: 'tx_ente',
                hiddenName: 'tb052_compras[co_ente]',
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



            this.displayfieldmonto_compra = new Ext.form.DisplayField({
                value: "<span style='font-size:12px;'><b>Sub Total Compra: </b>" + paqueteComunJS.funcion.getNumeroFormateado(ComprasEditar.main.monto_compra.getValue()) + "</b></span>"
            });
            this.displayfieldmonto_iva = new Ext.form.DisplayField({
                value: "<span style='font-size:12px;'><b>Iva: </b>" + paqueteComunJS.funcion.getNumeroFormateado(ComprasEditar.main.monto_iva.getValue()) + "</b></span>"
            });
            this.displayfieldmonto_total = new Ext.form.DisplayField({
                value: "<span style='font-size:18px;'><b>Total Compra: </b>" + paqueteComunJS.funcion.getNumeroFormateado(ComprasEditar.main.monto_total.getValue()) + "</b></span>"
            });

            this.agregar = new Ext.Button({
                text: 'Agregar',
                iconCls: 'icon-nuevo',
                handler: function() {

                    if (ComprasEditar.main.co_iva_factura.getValue() == '') {
                        Ext.Msg.alert("Notificación", "Para agregar un producto, debe seleccionar el IVA ");
                        return;
                    }

                    this.msg = Ext.get('formularioAgregar');
                    this.msg.load({
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/agregarProducto',
                        params: 'codigo=<?php echo $co_requisicion; ?>',
                        scripts: true,
                        text: "Cargando.."
                    });
                }
            });

            this.editar = new Ext.Button({
                text: 'Editar',
                iconCls: 'icon-editar',
                handler: function() {
                    this.msg = Ext.get('formularioEditar');
                    this.msg.load({
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/editarProducto',
                        params: 'codigo=<?php echo $co_requisicion; ?>',
                        scripts: true,
                        text: "Cargando.."
                    });
                }
            });
            this.botonEliminar = new Ext.Button({
                text: 'Eliminar',
                iconCls: 'icon-eliminar',
                id: 'eliminar',
                handler: function(boton) {
                    ComprasEditar.main.eliminar();
                }
            });

            this.botonEliminar.disable();

            function renderMonto(val, attr, record) {
                return paqueteComunJS.funcion.getNumeroFormateado(val);
            }


            this.rowIndex;
            this.gridPanel = new Ext.grid.EditorGridPanel({
                title: 'Lista de Materiales',
                iconCls: 'icon-libro',
                store: this.store_lista,
                loadMask: true,
                //height: 300,
                width: 1250,
                autoScroll: true,
                tbar: [this.agregar, '-', this.botonEliminar],
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'co_detalle_compras',
                        hidden: true,
                        width: 10,
                        menuDisabled: true,
                        dataIndex: 'co_detalle_compras'
                    },
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
                        header: 'co_presupuesto',
                        hidden: true,
                        width: 10,
                        menuDisabled: true,
                        dataIndex: 'co_presupuesto'
                    },
                    {
                        header: 'co_producto',
                        hidden: true,
                        width: 10,
                        menuDisabled: true,
                        dataIndex: 'co_producto'
                    },
                    {
                        header: 'Codigo',
                        width: 80,
                        menuDisabled: true,
                        dataIndex: 'cod_producto'
                    },
                    {
                        header: 'Descripción Producto',
                        width: 250,
                        menuDisabled: true,
                        dataIndex: 'tx_producto',
                        renderer: textoLargo                       
                    },
                    {
                        header: 'Descripción Oferta',
                        width: 180,
                        menuDisabled: true,
                        dataIndex: 'detalle',
                        renderer: textoLargo,
                        editor: new Ext.form.TextField({
                            allowBlank: false,
                            autoCreate: {
                                tag: "input",
                                type: "text",
                                autocomplete: "off",
                                maxlength: 400
                            },
                            listeners: {
                                change: function(field, newValue, oldValue) {
                                    this.setValue(newValue.toUpperCase());
                                }
                            }                            
                        }) 
                    },
                    {
                        header: 'Cant.',
                        width: 60,
                        menuDisabled: true,
                        dataIndex: 'nu_cantidad',
                        editor: new Ext.form.NumberField({
                            allowBlank: false,
                            autoCreate: {
                                tag: "input",
                                type: "text",
                                autocomplete: "off",
                                maxlength: 400
                            },
                            listeners: {
                                change: function(cmb, record, index) {
                                    var monto = this.getValue() * ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.precio_unitario;

                                    var cantidad = ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.nu_cantidad;
                                    
                                    var cantidad_restante = ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.nu_cantidad_restante;

                                    if (parseInt(this.getValue()) > parseInt(cantidad_restante)) {
                                        this.setValue(cantidad);
                                        Ext.Msg.alert("Alerta", "La cantidad ingresada es mayor a la cantidad requerida");
                                        return false;
                                    }

                                    var nu_iva_producto = parseFloat(ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.nu_iva_producto);
                                    var mo_iva = monto * (nu_iva_producto / 100);
                                    ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.monto = monto;
                                    ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.mo_iva_producto = mo_iva;
                                    ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.monto_total = monto + mo_iva;
                                    ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.in_modificado = true;

                                    ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.monto = monto;

                                    ComprasEditar.main.getTotal();
                                    //  ComprasEditar.main.getVerificarIVA();
                                }
                            }
                        })
                    },
                    {
                        header: 'Precio Unitario',
                        width: 100,
                        menuDisabled: true,
                        dataIndex: 'precio_unitario',
                        renderer: renderMonto,
                        editor: new Ext.form.NumberField({
                            allowBlank: false,
                            autoCreate: {
                                tag: "input",
                                type: "text",
                                autocomplete: "off",
                                maxlength: 400
                            },
                            listeners: {
                                change: function(cmb, record, index) {

                                    var precio_base = ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.monto_base;
                                    var precio_unitario = ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.precio_unitario;

                                    if (parseFloat(this.getValue()) > parseFloat(precio_base)) {
                                        this.setValue(precio_unitario);
                                        Ext.Msg.alert("Alerta", "El precio unitario ingresado es mayor al precio del presupuesto base");
                                        return false;
                                    }

                                    var monto = this.getValue() * ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.nu_cantidad;
                                    var nu_iva_producto = parseFloat(ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.nu_iva_producto);
                                    var mo_iva = monto * (nu_iva_producto / 100);
                                    ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.monto = monto;
                                    ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.mo_iva_producto = mo_iva;
                                    ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.monto_total = monto + mo_iva;
                                    ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.in_modificado = true;

                                    ComprasEditar.main.getTotal();
                                    // ComprasEditar.main.getVerificarIVA();

                                }
                            }
                        })
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
                    },
                    {
                        header: 'in_modificado',
                        hidden: true,
                        dataIndex: 'in_modificado'
                    }
                ],
                stripeRows: true,
                autoScroll: true,
                stateful: true,
                listeners: {
                    cellclick: function(Grid, rowIndex, columnIndex, e) {
                        ComprasEditar.main.botonEliminar.enable();
                        ComprasEditar.main.rowIndex = rowIndex;

                    }
                }
            });

            if (this.OBJ.co_compras != '') {

                ComprasEditar.main.store_lista.baseParams.co_compras = this.OBJ.co_compras;
                this.store_lista.load({
                    callback: function() {
                        ComprasEditar.main.getTotal();
                        //   ComprasEditar.main.getVerificarIVA();
                        if (ComprasEditar.main.store_lista.getCount() > 0) {
                            ComprasEditar.main.buscar.disable();
                        }
                    }
                });

            }

            this.fieldCompra = new Ext.form.FieldSet({
                //title: 'Datos de los Materiales',
                items: [
                    this.fecha_compra,
                    this.co_ente,
                    this.gridPanel

                ]
            });

            this.guardar = new Ext.Button({
                text: 'Guardar',
                iconCls: 'icon-guardar',
                handler: function() {
                    var cant = ComprasEditar.main.store_lista.getCount();
                    if (cant == 0) {
                        Ext.Msg.alert("Alerta", "Debe Agregar al menos un Material");
                        return false;
                    }

                    /*if (ComprasEditar.main.monto_contrato.getValue() != ComprasEditar.main.monto_total.getValue()) {
                        Ext.Msg.alert("Alerta", "El monto del contrato no coincide con el total de la compra");
                        return false;
                    }*/

                    if (!ComprasEditar.main.formPanel_.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar los campos requeridos! Verifique");
                        return false;
                    }

                    var list_producto = paqueteComunJS.funcion.getJsonByObjStore({
                        store: ComprasEditar.main.gridPanel.getStore()
                    });

                    ComprasEditar.main.hiddenJsonProducto.setValue(list_producto);

                    ComprasEditar.main.formPanel_.getForm().submit({
                        method: 'POST',
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contrato/guardar',
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
                            ComprasEditar.main.winformPanel_.close();
                        }
                    });


                }
            });

            this.salir = new Ext.Button({
                text: 'Salir',
                iconCls: 'icon-cancelar',
                handler: function() {
                    ComprasEditar.main.winformPanel_.close();
                }
            });


            this.tabuladores = new Ext.TabPanel({
                resizeTabs: true, // turn on tab resizing
                minTabWidth: 115,
                tabWidth: 150,
                border: true,
                enableTabScroll: true,
                autoWidth: true,
                deferredRender: false,
                height: 590,
                autoScroll: true,
                activeTab: 0,
                defaults: {
                    autoScroll: true
                },
                items: [{
                        title: 'Datos de la Compra',
                        items: [this.fieldPresupuesto,
                            this.fieldProveedor,
                            this.fieldContrato
                        ]
                    },
                    {
                        title: 'Materiales',
                        items: [this.fieldCompra]
                    }
                ]
            });

            this.formPanel_ = new Ext.form.FormPanel({
                frame: true,
                width: 2000,
                height: 704,
                autoScroll: true,
                bodyStyle: 'padding:0px;',
                items: [

                    this.co_compras,
                    this.co_solicitud_cotizacion,
                    this.co_proveedor,
                    this.co_contrato_compras,
                    //     this.co_tipo_solicitud,
                    this.co_solicitud,
                    this.co_requisicion,
                  // this.nu_compra,
                    this.monto_compra,
                    this.monto_iva,
                    this.monto_total,
                    this.tabuladores,
                    this.hiddenJsonProducto
                ]
            });

          /*  var tbar = {
                xtype: 'toolbar',
                layout: 'hbox',
                items: this.nu_compra,
                height: 25,
                layoutConfig: {
                    align: 'left'
                }
            };*/

            this.winformPanel_ = new Ext.Window({
                title: 'Contrato',
                modal: true,
                constrain: true,
                width: 1204,
                frame: true,
                closabled: true,
                height: 700,
              //  tbar: tbar,
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
        getVerificarIVA: function() {

            var cant = paqueteComunJS.funcion.getSumaColumnaGrid({
                store: ComprasEditar.main.store_lista,
                campo: 'monto'
            });


            if (cant > 0) {
                Ext.get('co_iva_factura').setStyle('background-color', '#c9c9c9');
                ComprasEditar.main.co_iva_factura.setReadOnly(true);
            } else {
                Ext.get('co_iva_factura').setStyle('background-color', '#FFFFFF');
                ComprasEditar.main.co_iva_factura.setReadOnly(false);
            }
        },
        getStoreCO_DOCUMENTO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcodocumento',
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
        getStoreCO_RAMO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoramo',
                root: 'data',
                fields: [{
                        name: 'co_ramo'
                    },
                    {
                        name: 'tx_ramo'
                    }
                ]
            });
            return this.store;
        },
        getLista: function() {

            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storelistamateriales',
                root: 'data',
                fields: [{
                        name: 'co_detalle_compras'
                    },
                    {
                        name: 'co_detalle_requisicion'
                    },
                    {
                        name: 'co_detalle_cotizacion'
                    },
                    {
                        name: 'co_producto'
                    },
                    {
                        name: 'co_presupuesto'
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
                    },
                    {
                        name: 'in_modificado'
                    },
                    {
                        name: 'monto_base'
                    },
                    {
                        name: 'nu_cantidad_restante'
                    }
                ]
            });
            return this.store;
        },
        eliminar: function() {
            Ext.MessageBox.confirm('Confirmación', '¿Esta seguro que desea eliminar el material?', function(boton) {
                if (boton == "yes") {

                    var s = ComprasEditar.main.gridPanel.getSelectionModel().selection;

                    var co_detalle_compras = ComprasEditar.main.gridPanel.getStore().getAt(ComprasEditar.main.rowIndex).data.co_detalle_compras;

                    ComprasEditar.main.gridPanel.getStore().removeAt(ComprasEditar.main.rowIndex);

                    if (co_detalle_compras != '') {

                        Ext.Ajax.request({
                            method: 'POST',
                            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/eliminarMaterial',
                            params: {
                                co_detalle_compras: co_detalle_compras
                            },
                            success: function(result, request) {
                                //ComprasEditar.main.store_lista.load();
                            }
                        });

                    }

                    for(var i = 0, r; r = s[i]; i++){                        
                        ComprasEditar.main.store_lista.remove(r);
                    }

                    ComprasEditar.main.botonEliminar.disable();
                    ComprasEditar.main.getTotal();
                }
            });

        },
        getTotal: function() {

            this.monto = 0;
            this.cancelar = 0;
            this.tcancelar = 0;
            this.totaliva = 0;
            this.iva = 0;



            this.monto = paqueteComunJS.funcion.getSumaColumnaGrid({
                store: ComprasEditar.main.store_lista,
                campo: 'monto'
            });

            this.monto_iva = paqueteComunJS.funcion.getSumaColumnaGrid({
                store: ComprasEditar.main.store_lista,
                campo: 'mo_iva_producto'
            });

            this.monto_total = paqueteComunJS.funcion.getSumaColumnaGrid({
                store: ComprasEditar.main.store_lista,
                campo: 'monto_total'
            });


            /*  var monto_exento = 0;
              ComprasEditar.main.store_lista.each(function(store) {
                  if (store.data.in_exento == true) {
                      monto_exento += store.data.monto
                  }
              });


              this.cancelar = parseFloat(this.monto);
              if (this.monto > 0) {
                  this.totaliva = (parseFloat(this.monto - monto_exento) * parseFloat(this.iva)) / 100;
              }*/


            ComprasEditar.main.displayfieldmonto_compra.setValue("<span style='font-size:12px;'><b>Sub Total Compra: </b>" + paqueteComunJS.funcion.getNumeroFormateado(this.monto) + "</b></span>");
            ComprasEditar.main.displayfieldmonto_iva.setValue("<span style='font-size:12px;'><b>Iva: </b>" + paqueteComunJS.funcion.getNumeroFormateado(this.monto_iva) + "</b></span>");
            ComprasEditar.main.displayfieldmonto_total.setValue("<span style='font-size:12px;'><b>Total Compra: </b>" + paqueteComunJS.funcion.getNumeroFormateado(this.monto_total) + "</b></span>");


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
        },
        getStoreCO_TPCONTRATO: function() {
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
        getStoreCO_FUENTEFINANCIAMIENTO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcofuentefinanciamiento',
                root: 'data',
                fields: [{
                        name: 'co_fuente_financiamiento'
                    },
                    {
                        name: 'tx_fuente_financiamiento'
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_TIPO_PROCESO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contrato/storefkcotipoproceso',
                root: 'data',
                fields: [{
                        name: 'co_tipo_solicitud'
                    },
                    {
                        name: 'tx_tipo_solicitud'
                    }
                ]
            });
            return this.store;
        },
        verificarProveedor: function() {
            Ext.Ajax.request({
                method: 'GET',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/verificarProveedor',
                params: {
                    co_documento: ComprasEditar.main.co_documento.getValue(),
                    tx_rif: ComprasEditar.main.tx_rif.getValue()
                },
                success: function(result, request) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if (!obj.data) {
                        ComprasEditar.main.co_proveedor.setValue("");
                        ComprasEditar.main.co_documento.setValue("");
                        ComprasEditar.main.tx_rif.setValue("");
                        ComprasEditar.main.tx_razon_social.setValue("");
                        ComprasEditar.main.tx_direccion.setValue("");
                        ComprasEditar.main.co_ramo.clearValue();
                        ComprasEditar.main.storeCO_RAMO.removeAll();

                        Ext.Msg.show({
                            title: 'ALERTA',
                            msg: 'El Proveedor no se encuentra registrado',
                            width: 400,
                            height: 800,
                            closable: false,
                            buttons: Ext.Msg.OK,
                            icon: Ext.Msg.INFO
                        });

                    } else {

                        ComprasEditar.main.co_proveedor.setValue(obj.data.co_proveedor);
                        ComprasEditar.main.tx_razon_social.setValue(obj.data.tx_razon_social);
                        ComprasEditar.main.tx_direccion.setValue(obj.data.tx_direccion);
                        ComprasEditar.main.storeCO_RAMO.load({
                            params: {
                                co_proveedor: obj.data.co_proveedor
                            }
                        });
                    }
                }
            });
        }
    };
    Ext.onReady(ComprasEditar.main.init, ComprasEditar.main);
</script>
<div id="formularioAgregar"></div>