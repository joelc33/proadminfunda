<script type="text/javascript">
    Ext.ns("ServicioBasicoFacturaEditar");
    ServicioBasicoFacturaEditar.main = {
        init: function () {

            this.OBJ = paqueteComunJS.funcion.doJSON({ stringData: '<?php echo $data ?>' });
            //<Stores de fk>
            this.storeCO_RAMO = this.getStoreCO_RAMO();
            //<Stores de fk>
            //<Stores de fk>
            this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
            //<Stores de fk>
            //<Stores de fk>
            this.storeCO_PRODUCTO = this.getStoreCO_PRODUCTO();
            //<Stores de fk>
            this.store_lista = this.getLista();

            ServicioBasicoFacturaEditar.main.monto_imponible = new Ext.form.DisplayField({
                value: "<span style='font-size:12px;'><b>Base Imponible: </b>0,00</b></span>"
            });
            ServicioBasicoFacturaEditar.main.monto_retencion = new Ext.form.DisplayField({
                value: "<span style='font-size:12px;'><b>Total Retenciones: </b>0,00</b></span>"
            });
            ServicioBasicoFacturaEditar.main.monto_pagar = new Ext.form.DisplayField({
                value: "<span style='font-size:12px;'><b>Total Factura: </b>0,00</b></span>"
            });

            this.co_solicitud_ayuda = new Ext.form.Hidden({
                name: 'co_solicitud_ayuda',
                value: this.OBJ.co_solicitud_ayuda
            });

            //<ClavePrimaria> 
            this.co_factura = new Ext.form.Hidden({
                name: 'co_factura',
                value: this.OBJ.co_factura
            });
            //</ClavePrimaria>
            //<ClavePrimaria>
            this.co_solicitud = new Ext.form.Hidden({
                name: 'tb045_factura[co_solicitud]',
                value: this.OBJ.co_solicitud
            });
            //</ClavePrimaria>
            //<ClavePrimaria>
            this.co_proveedor = new Ext.form.Hidden({
                name: 'tb045_factura[co_proveedor]',
                value: this.OBJ.co_proveedor
            });
            //</ClavePrimaria>
            //<ClavePrimaria>
            this.co_compra = new Ext.form.Hidden({
                name: 'tb045_factura[co_compra]',
                value: this.OBJ.co_compra
            });
            //</ClavePrimaria>
            this.co_iva_retencion = new Ext.form.Hidden({
                name: 'tb045_factura[co_iva_retencion]',
                value: this.OBJ.co_iva_retencion
            });
            //<ClavePrimaria>
            this.co_detalle_compras = new Ext.form.Hidden({
                name: 'co_detalle_compras',
                value: this.OBJ.co_detalle_compras
            });

            this.co_pago_servicio = new Ext.form.Hidden({
                name: 'co_pago_servicio',
                value: this.OBJ.co_pago_servicio
            });

            this.co_usuario = new Ext.form.Hidden({
                name: 'tb126_solicitud_ayuda[co_usuario]',
                value: this.OBJ.co_usuario
            });

            this.co_proveedor_solicitante = new Ext.form.Hidden({
                name: 'solicitante[co_proveedor]',
                value: this.OBJ.co_proveedor_solicitante
            });
            //</ClavePrimaria>

            this.Registro = Ext.data.Record.create([
                { name: 'tx_producto', type: 'string' },
                { name: 'co_producto', type: 'number' },
                { name: 'nu_factura', type: 'number' },
                { name: 'nu_control', type: 'number' },
                { name: 'fe_emision', type: 'string' },
                { name: 'nu_base_imponible', type: 'number' },
                { name: 'co_iva_factura', type: 'number' },
                { name: 'nu_iva_factura', type: 'number' },
                { name: 'nu_total', type: 'number' },
                { name: 'co_iva_retencion', type: 'number' },
                { name: 'nu_iva_retencion', type: 'number' },
                { name: 'nu_total_retencion', type: 'number' },
                { name: 'total_pagar', type: 'number' },
                { name: 'nu_total_pagar', type: 'number' },
                { name: 'tx_concepto', type: 'number' },
                { name: 'json_detalle_retencion', type: 'string' }
            ]);

            this.hiddenJsonFactura = new Ext.form.Hidden({
                name: 'json_factura',
                value: ''
            });

            this.co_ramo = new Ext.form.ComboBox({
                fieldLabel: 'Tipo de Ramo',
                store: this.storeCO_RAMO,
                typeAhead: true,
                valueField: 'co_ramo',
                displayField: 'tx_ramo',
                hiddenName: 'tb045_factura[co_ramo]',
                //readOnly:(this.OBJ.co_ramo!='')?true:false,
                //style:(this.main.OBJ.co_ramo!='')?'background:#c9c9c9;':'',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione Tipo de Ramo',
                selectOnFocus: true,
                mode: 'local',
                width: 500,
                resizable: true,
                allowBlank: false
            });

            if (this.OBJ.co_proveedor) {

                this.storeCO_RAMO.baseParams.co_proveedor = this.OBJ.co_proveedor;

                this.storeCO_RAMO.load();

                paqueteComunJS.funcion.seleccionarComboByCo({
                    objCMB: this.co_ramo,
                    value: this.OBJ.co_ramo,
                    objStore: this.storeCO_RAMO
                });
            }

            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.id_tb048_producto,
                value: this.OBJ.id_tb048_producto,
                objStore: this.storeCO_PRODUCTO
            });

            this.co_documento = new Ext.form.ComboBox({
                fieldLabel: 'Co documento',
                store: this.storeCO_DOCUMENTO,
                typeAhead: true,
                valueField: 'co_documento',
                displayField: 'inicial',
                hiddenName: 'tb008_proveedor[co_documento]',
                //readOnly:(this.OBJ.co_documento!='')?true:false,
                //style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 50,
                resizable: true,
                allowBlank: false
            });
            this.storeCO_DOCUMENTO.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_documento,
                value: (this.OBJ.co_documento == '') ? 4 : this.OBJ.co_documento,
                objStore: this.storeCO_DOCUMENTO
            });

            this.tx_rif = new Ext.form.TextField({
                name: 'tb008_proveedor[tx_rif]',
                value: this.OBJ.tx_rif,
                allowBlank: false,
                width: 130
            });

            this.tx_razon_social = new Ext.form.TextField({
                fieldLabel: 'Razon Social',
                name: 'tb008_proveedor[tx_razon_social]',
                value: this.OBJ.tx_razon_social,
                allowBlank: false,
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 500
            });

            this.co_documento.on("blur", function () {
                if (ServicioBasicoFacturaEditar.main.tx_rif.getValue() != '') {
                    ServicioBasicoFacturaEditar.main.verificarProveedor();
                }
            });

            this.tx_rif.on("blur", function () {
                ServicioBasicoFacturaEditar.main.verificarProveedor();
            });

            this.compositefieldCIRIF = new Ext.form.CompositeField({
                fieldLabel: 'RIF',
                width: 300,
                items: [
                    this.co_documento,
                    this.tx_rif,
                ]
            });

            this.tx_direccion = new Ext.form.TextField({
                fieldLabel: 'Direccion',
                name: 'tb008_proveedor[tx_direccion]',
                value: this.OBJ.tx_direccion,
                allowBlank: false,
                readOnly: true,
                style: 'background:#c9c9c9;',
                width: 500
            });

            this.tx_concepto = new Ext.form.TextArea({
                fieldLabel: 'Concepto',
                name: 'tb008_proveedor[tx_observacion]',
                value: this.OBJ.tx_observacion,
                allowBlank: false,
                width: 700
            });

            this.fieldDatos1 = new Ext.form.FieldSet({
                title: 'Datos del Proveedor',
                items: [
                    this.co_proveedor,
                    this.compositefieldCIRIF,
                    this.tx_razon_social,
                    this.tx_direccion,
                    this.co_ramo,
                ]
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
                readOnly: true,
                style: 'background:#c9c9c9;',
                allowBlank: false,
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
            //    if(ServicioBasicoFacturaEditar.main.nu_cedula.getValue()!=''){
            //        ServicioBasicoFacturaEditar.main.verificarSolicitante();
            //    }
            //});

            this.nu_cedula.on("blur", function () {
                ServicioBasicoFacturaEditar.main.verificarSolicitante();
            });

            this.fieldDatosSolicitante = new Ext.form.FieldSet({
                title: 'Datos del Solicitante',
                width: 850,
                items: [this.compositefieldCI,
                this.nb_persona,
                this.nu_celular]
            });



            this.fieldDatos2 = new Ext.form.FieldSet({
                // title: 'Concepto',
                items: [this.tx_concepto]
            });

            //this.displayfieldttotalacancelar = new Ext.form.DisplayField({
            //	value:"<span style='font-size:16px;color:white;'><b>Total a Pagar: "+formatoNumero((Number(ServicioBasicoFacturaEditar.main.total_pagar.getValue()).toFixed(2)))+"</b></span>&nbsp;&nbsp;&nbsp;"
            //});

            function renderMonto(val, attr, record) {
                return paqueteComunJS.funcion.getNumeroFormateado(val);
            }

            this.agregar = new Ext.Button({
                text: 'Agregar',
                iconCls: 'icon-nuevo',
                handler: function () {
                    this.msg = Ext.get('formularioAgregar');
                    this.msg.load({
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/agregarFacturaDV',
                        scripts: true,
                        text: "Cargando..",
                        params: {
                            co_documento: ServicioBasicoFacturaEditar.main.co_documento.getValue(),
                            co_iva_retencion: ServicioBasicoFacturaEditar.main.co_iva_retencion.getValue(),
                            co_ramo: ServicioBasicoFacturaEditar.main.co_ramo.getValue(),
                            co_iva_factura: ServicioBasicoFacturaEditar.main.co_documento.getValue(),
                            co_solicitud: ServicioBasicoFacturaEditar.main.co_solicitud.getValue(),
                            co_proveedor: ServicioBasicoFacturaEditar.main.co_proveedor.getValue(),
                            co_tipo_solicitud: ServicioBasicoFacturaEditar.main.OBJ.co_tipo_solicitud
                        }
                    });
                }
            });

            this.botonEliminar = new Ext.Button({
                text: 'Eliminar',
                iconCls: 'icon-eliminar',
                handler: function () {
                    ServicioBasicoFacturaEditar.main.eliminar();
                }
            });

            this.botonEliminar.disable();


            this.gridPanel = new Ext.grid.GridPanel({
                title: 'Lista de Facturas',
                iconCls: 'icon-libro',
                store: this.store_lista,
                loadMask: true,
                height: 300,
                width: 840,
                tbar: [this.agregar, '-', this.botonEliminar],
                columns: [
                    new Ext.grid.RowNumberer(),
                    { header: 'co_detalle_compras', hidden: true, width: 80, menuDisabled: true, dataIndex: 'co_detalle_compras' },
                    { header: 'co_factura', hidden: true, width: 80, menuDisabled: true, dataIndex: 'co_factura' },
                    { header: 'Servicio', width: 150, menuDisabled: true, dataIndex: 'tx_producto' },
                    { header: 'N° Factura', width: 100, menuDisabled: true, dataIndex: 'nu_factura' },
                    { header: 'Fecha Emisión', width: 100, menuDisabled: true, dataIndex: 'fe_emision' },
                    { header: 'Base Imponible', width: 150, menuDisabled: true, dataIndex: 'nu_base_imponible', renderer: renderMonto },
                    { header: 'Total Retenciones', width: 150, menuDisabled: true, dataIndex: 'nu_total_retencion', renderer: renderMonto },
                    { header: 'Total Factura', width: 150, menuDisabled: true, dataIndex: 'total_pagar', renderer: renderMonto }
                ],
                bbar: new Ext.ux.StatusBar({
                    id: 'basic-statusbar',
                    autoScroll: true,
                    defaults: { style: 'color:black;font-size:30px;', autoWidth: true },
                    items: [
                        this.monto_imponible, '-', this.monto_retencion, '-', this.monto_pagar
                    ]
                }),
                stripeRows: true,
                autoScroll: true,
                stateful: true,
                listeners: {
                    cellclick: function (Grid, rowIndex, columnIndex, e) {

                        ServicioBasicoFacturaEditar.main.botonEliminar.enable();


                    }
                }
            });


            this.guardar = new Ext.Button({
                text: 'Guardar',
                iconCls: 'icon-guardar',
                handler: function () {

                    if (!ServicioBasicoFacturaEditar.main.formPanel_.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
                        return false;
                    }

                    var list_factura = paqueteComunJS.funcion.getJsonByObjStore({
                        store: ServicioBasicoFacturaEditar.main.gridPanel.getStore()
                    });

                    ServicioBasicoFacturaEditar.main.hiddenJsonFactura.setValue(list_factura);



                    ServicioBasicoFacturaEditar.main.formPanel_.getForm().submit({
                        method: 'POST',
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/guardarFactura',
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


                            ServicioBasicoFacturaEditar.main.winformPanel_.close();
                        }
                    });


                }
            });

            this.salir = new Ext.Button({
                text: 'Salir',
                //    iconCls: 'icon-cancelar',
                handler: function () {
                    ServicioBasicoFacturaEditar.main.winformPanel_.close();
                }
            });


            this.formPanel_ = new Ext.form.FormPanel({
                frame: false,
                width: 860,
                autoHeight: true,
                autoScroll: true,
                bodyStyle: 'padding:10px;',
                items: [
                    this.co_compra,
                    this.co_usuario,
                    this.co_pago_servicio,
                    this.co_proveedor_solicitante,
                    this.co_detalle_compras,
                    this.co_solicitud,
                    this.hiddenJsonFactura,
                    this.fieldDatos1,
                    this.fieldDatosSolicitante,
                    this.fieldDatos2,
                    this.gridPanel
                ],
                bbar: new Ext.ux.StatusBar({
                    style: 'border: 1px solid #99bbe8',
                    items: [
                        //                 this.displayfieldttotalacancelar
                    ]
                })
            });

            if (this.OBJ.co_proveedor_solicitante != '') {
                ServicioBasicoFacturaEditar.main.verificarSolicitante();
            }

            this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
            this.store_lista.load();

            this.winformPanel_ = new Ext.Window({
                title: 'Formulario: Solicitud de Ayuda - Registro de Factura',
                modal: true,
                constrain: true,
                width: 874,
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
        verificarSolicitante: function () {
            Ext.Ajax.request({
                method: 'GET',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/verificarSolicitante',
                params: {
                    co_documento: ServicioBasicoFacturaEditar.main.co_documento.getValue(),
                    tx_rif: ServicioBasicoFacturaEditar.main.nu_cedula.getValue(),
                    co_proveedor: ServicioBasicoFacturaEditar.main.co_proveedor_solicitante.getValue()
                },
                success: function (result, request) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if (!obj.data) {
                        ServicioBasicoFacturaEditar.main.co_proveedor_solicitante.setValue("");
                        ServicioBasicoFacturaEditar.main.nb_persona.setValue("");
                        ServicioBasicoFacturaEditar.main.nu_celular.setValue("");
                    } else {

                        ServicioBasicoFacturaEditar.main.co_proveedor_solicitante.setValue(obj.data.co_proveedor);
                        ServicioBasicoFacturaEditar.main.nb_persona.setValue(obj.data.tx_razon_social);
                        ServicioBasicoFacturaEditar.main.nu_celular.setValue(obj.data.nu_celular);
                        ServicioBasicoFacturaEditar.main.nu_cedula.setValue(obj.data.tx_rif);

                        ServicioBasicoFacturaEditar.main.storeCO_DOCUMENTO.load({
                            callback: function () {
                                ServicioBasicoFacturaEditar.main.co_documento.setValue(obj.data.co_documento);
                            }
                        });


                    }
                }
            });
        },
        eliminar: function () {
            var s = ServicioBasicoFacturaEditar.main.gridPanel.getSelectionModel().getSelections();

            var co_factura = ServicioBasicoFacturaEditar.main.gridPanel.getSelectionModel().getSelected().get('co_factura');
            var co_detalle_compras = ServicioBasicoFacturaEditar.main.gridPanel.getSelectionModel().getSelected().get('co_detalle_compras');

            if (co_factura != '') {

                Ext.Ajax.request({
                    method: 'POST',
                    url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ServicioBasicoFactura/eliminarFactura',
                    params: {
                        co_factura: co_factura,
                        co_detalle_compras: co_detalle_compras
                    },
                    success: function (result, request) {
                        ServicioBasicoFacturaEditar.main.store_lista.load();
                    }
                });

            }



            for (var i = 0, r; r = s[i]; i++) {
                ServicioBasicoFacturaEditar.main.store_lista.remove(r);
            }

        }
        , getStoreCO_RAMO: function () {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoramo',
                root: 'data',
                fields: [
                    { name: 'co_ramo' },
                    { name: 'tx_ramo' }
                ]
            });
            return this.store;
        }
        , verificarProveedor: function () {
            Ext.Ajax.request({
                method: 'GET',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/verificarProveedor',
                params: {
                    co_documento: ServicioBasicoFacturaEditar.main.co_documento.getValue(),
                    tx_rif: ServicioBasicoFacturaEditar.main.tx_rif.getValue()
                },
                success: function (result, request) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if (!obj.data) {
                        ServicioBasicoFacturaEditar.main.co_proveedor.setValue("");
                        ServicioBasicoFacturaEditar.main.co_documento.setValue("");
                        ServicioBasicoFacturaEditar.main.tx_rif.setValue("");
                        ServicioBasicoFacturaEditar.main.tx_razon_social.setValue("");
                        ServicioBasicoFacturaEditar.main.tx_direccion.setValue("");
                        ServicioBasicoFacturaEditar.main.co_iva_retencion.setValue("");

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

                        ServicioBasicoFacturaEditar.main.co_proveedor.setValue(obj.data.co_proveedor);
                        ServicioBasicoFacturaEditar.main.tx_razon_social.setValue(obj.data.tx_razon_social);
                        ServicioBasicoFacturaEditar.main.tx_direccion.setValue(obj.data.tx_direccion);
                        ServicioBasicoFacturaEditar.main.co_iva_retencion.setValue(obj.data.co_iva_retencion);
                        ServicioBasicoFacturaEditar.main.storeCO_RAMO.load({
                            params: {
                                co_proveedor: obj.data.co_proveedor
                            }
                        });

                    }
                }
            });
        }
        , getStoreCO_DOCUMENTO: function () {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcodocumento',
                root: 'data',
                fields: [
                    { name: 'co_documento' },
                    { name: 'inicial' }
                ]
            });
            return this.store;
        }
        , getStoreCO_PRODUCTO: function () {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/SolicitudAyuda/storefkcoproducto',
                root: 'data',
                fields: [
                    { name: 'co_producto' },
                    { name: 'cod_producto' },
                    { name: 'tx_producto' },
                    {
                        name: 'producto',
                        convert: function (v, r) {
                            return r.cod_producto + ' - ' + r.tx_producto;
                        }
                    }
                ]
            });
            return this.store;
        }, getLista: function () {

            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ServicioBasicoFactura/storelista',
                root: 'data',
                fields: [
                    { name: 'nu_factura' },
                    { name: 'nu_control' },
                    { name: 'fe_emision' },
                    { name: 'co_factura' },
                    { name: 'total_pagar' },
                    { name: 'tx_concepto' },
                    { name: 'tx_producto' },
                    { name: 'co_producto' },
                    { name: 'co_detalle_compras' },
                    { name: 'nu_base_imponible' },
                    { name: 'co_iva_factura' },
                    { name: 'nu_iva_factura' },
                    { name: 'nu_total' },
                    { name: 'co_iva_retencion' },
                    { name: 'nu_iva_retencion' },
                    { name: 'nu_total_pagar' },
                    { name: 'nu_total_retencion' },
                    { name: 'co_compra' },
                    { name: 'co_solicitud' },
                    { name: 'estatus' }
                ]
            });
            return this.store;




        }
    };
    Ext.onReady(ServicioBasicoFacturaEditar.main.init, ServicioBasicoFacturaEditar.main);
</script>
<div id="formularioAgregar"></div>