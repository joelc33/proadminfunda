<script type="text/javascript">
    Ext.ns("ContabilidadEditar");
    ContabilidadEditar.main = {
        init: function() {

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });

            this.store_lista_resumen = ContabilidadEditar.main.getListaResumen();

            this.mascara = new Ext.LoadMask(Ext.getBody(), {
                msg: "Cargando..."
            });
            this.detalle_factura = '';
            this.monto_total = 0;

            this.co_detalle_compras = '';
            this.id_partida = '';
            this.monto = '';
            this.nu_partida = '';
            this.de_partida = '';
            this.co_tipo_movimiento = '';
            this.co_presupuesto_movimiento = '';
            this.tx_producto = '';
            this.co_producto = '';


            this.co_compra = new Ext.form.Hidden({
                name: 'co_compra',
                value: this.OBJ.co_compras
            });

            this.co_solicitud = new Ext.form.Hidden({
                name: 'co_solicitud',
                value: this.OBJ.co_solicitud
            });


            this.co_documento = new Ext.form.Hidden({
                name: 'co_documento',
                value: this.OBJ.co_documento
            });

            this.co_ramo = new Ext.form.Hidden({
                name: 'co_ramo',
                value: this.OBJ.co_ramo
            });
            //</ClavePrimaria>

            this.store_lista = this.getLista();


            this.Registro = Ext.data.Record.create([{
                    name: 'nu_factura',
                    type: 'number'
                },
                {
                    name: 'fe_emision',
                    type: 'string'
                },
                {
                    name: 'nu_base_imponible',
                    type: 'number'
                },
                {
                    name: 'co_iva_factura',
                    type: 'number'
                },
                {
                    name: 'nu_iva_factura',
                    type: 'number'
                },
                {
                    name: 'nu_total',
                    type: 'number'
                },
                {
                    name: 'co_iva_retencion',
                    type: 'number'
                },
                {
                    name: 'nu_iva_retencion',
                    type: 'number'
                },
                {
                    name: 'nu_total_retencion',
                    type: 'number'
                },
                {
                    name: 'total_pagar',
                    type: 'number'
                },
                {
                    name: 'nu_total_pagar',
                    type: 'number'
                },
                {
                    name: 'tx_concepto',
                    type: 'number'
                },
                {
                    name: 'json_detalle_retencion',
                    type: 'string'
                }
            ]);

            this.hiddenJsonFactura = new Ext.form.Hidden({
                name: 'json_factura',
                value: ''
            });


            this.comprometer = new Ext.Button({
                text: 'Comprometer',
                iconCls: 'icon-nuevo',
                handler: function() {
                    Ext.MessageBox.confirm('Confirmación', '¿Esta seguro de comprometer?', function(boton) {
                        if (boton == "yes") {
                            var flag = true;
                            ContabilidadEditar.main.store_lista_resumen.baseParams.co_compra = ContabilidadEditar.main.OBJ.co_compras;
                            ContabilidadEditar.main.store_lista_resumen.load({
                                callback: function() {
                                    ContabilidadEditar.main.store_lista_resumen.each(function(record) {
                                        var nu_partida;
                                        var de_partida;
                                        var mo_disponible;
                                        var monto;
                                        var monto_total;
                                        var id;

                                        record.fields.each(function(field) {
                                            if (field.name == 'id') {
                                                id = record.get(field.name);
                                            }

                                            if (field.name == 'nu_partida') {
                                                nu_partida = record.get(field.name);
                                            }

                                            if (field.name == 'de_partida') {
                                                de_partida = record.get(field.name);
                                            }

                                            if (field.name == 'mo_disponible') {
                                                mo_disponible = record.get(field.name);
                                            }

                                            if (field.name == 'monto') {
                                                monto = record.get(field.name);
                                            }
                                        });

                                        monto_total = parseFloat(monto);

                                        if (mo_disponible < monto_total) {
                                            flag = false;
                                            Ext.MessageBox.alert('Error en transacción', "El monto de la partida <b>" + nu_partida + "-" + de_partida + "</b> es insuficiente, monto disponible " + mo_disponible + ", monto precomprometido en la compra " + monto_total);
                                            return false;
                                        }
                                    }, this);

                                    if (flag == true) {
                                        ContabilidadEditar.main.afectar_partida();
                                    }
                                }
                            });
                        }
                    });
                }
            });

            this.descomprometer = new Ext.Button({
                text: 'Descomprometer',
                iconCls: 'icon-eliminar',
                id: 'id_descomprometer',
                handler: function(boton) {
                    Ext.MessageBox.confirm('Confirmación', '¿Esta seguro que desea descomprometer?', function(boton) {
                        if (boton == "yes") {
                            ContabilidadEditar.main.afectar_partida();
                        }
                    });
                }
            });

            //Editar un registro
            this.cambiar_partida = new Ext.Button({
                text: 'Cambiar Partida',
                iconCls: 'icon-editar',
                handler: function() {
                    ContabilidadEditar.main.mascara.show();
                    this.msg = Ext.get('formularioAgregar');
                    this.msg.load({
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/cambiarPartidaPresupuesto',
                        scripts: true,
                        text: "Cargando..",
                        params: {
                            co_detalle_compras: ContabilidadEditar.main.co_detalle_compras,
                            co_producto: ContabilidadEditar.main.co_producto,
                            co_partida: ContabilidadEditar.main.id_partida
                        }
                    });
                }
            });

            this.comprometer.disable();
            this.descomprometer.disable();
            this.cambiar_partida.disable();

            this.monto_total = new Ext.form.DisplayField({
                value: "<span style='font-size:12px;'><b>Total a Pagar: </b>0,00</b></span>"
            });

            function renderMonto(val, attr, record) {
                return paqueteComunJS.funcion.getNumeroFormateado(val);
            }

            function renderMontoDisponible(val, attr, record) {
                if (parseFloat(record.data.mo_disponible) > parseFloat(record.data.monto)) {
                    return '<p style="color:green"><b>' + paqueteComunJS.funcion.getNumeroFormateado(record.data.mo_disponible) + '</b></p>';
                } else {
                    return '<p style="color:red"><b>' + paqueteComunJS.funcion.getNumeroFormateado(record.data.mo_disponible) + '</b></p>';
                }
            }


            function renderPartidaAlerta(val, attr, record) {
                if (parseFloat(record.data.mo_disponible) >= parseFloat(record.data.monto)) {
                    return val;
                } else {
                    return '<p style="color:red"><b>' + val + '</b></p>';
                }
            }

            this.resumen = new Ext.Button({
                text: 'Ver Resumen',
                iconCls: 'icon-buscar',
                handler: function() {
                    //ContabilidadEditar.main.mascara.show();
                    this.msg = Ext.get('formularioAgregar');
                    this.msg.load({
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/verResumen',
                        scripts: true,
                        text: "Cargando..",
                        params: {
                            co_compras: ContabilidadEditar.main.OBJ.co_compras,
                        }
                    });
                }
            });

            //textoLargo

            this.gridPanel = new Ext.grid.GridPanel({
                title: 'Detalle de la Compra',
                iconCls: 'icon-libro',
                store: this.store_lista,
                loadMask: true,
                height: 300,
                width: 1060,
                tbar: [this.comprometer, '-', this.descomprometer, '-', this.cambiar_partida, '-', this.resumen],
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'co_detalle_compras',
                        hidden: true,
                        width: 80,
                        menuDisabled: true,
                        dataIndex: 'co_detalle_compras'
                    },
                    {
                        header: 'id_partida',
                        hidden: true,
                        width: 80,
                        menuDisabled: true,
                        dataIndex: 'co_partida'
                    },
                    {
                        header: 'co_tipo_movimiento',
                        hidden: true,
                        width: 80,
                        menuDisabled: true,
                        dataIndex: 'co_tipo_movimiento'
                    },
                    // {header: 'Estatus',width:130, menuDisabled:true,dataIndex: 'tx_tipo_movimiento'},    
                    {
                        header: 'Material',
                        width: 300,
                        menuDisabled: true,
                        dataIndex: 'tx_producto',
                        renderer: textoLargo
                    },
                    {
                        header: 'Cod. Partida',
                        width: 140,
                        menuDisabled: true,
                        dataIndex: 'nu_partida',
                        renderer: renderPartidaAlerta
                    },
                    {
                        header: 'Partida',
                        width: 400,
                        menuDisabled: true,
                        dataIndex: 'de_partida',
                        renderer: textoLargo
                    },
                    //  {header: 'Monto Disponible',width:180, menuDisabled:true,dataIndex: 'mo_disponible',renderer:renderMontoDisponible},
                    {
                        header: 'Monto',
                        width: 180,
                        menuDisabled: true,
                        dataIndex: 'monto',
                        renderer: renderMonto
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
                        this.monto_total
                    ]
                }),
                stripeRows: true,
                autoScroll: true,
                stateful: true,
                listeners: {
                    cellclick: function(Grid, rowIndex, columnIndex, e) {

                        ContabilidadEditar.main.co_detalle_compras = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_detalle_compras');
                        ContabilidadEditar.main.id_partida = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_partida');
                        ContabilidadEditar.main.monto = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('monto');
                        ContabilidadEditar.main.nu_partida = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('nu_partida');
                        ContabilidadEditar.main.de_partida = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('de_partida');
                        ContabilidadEditar.main.co_tipo_movimiento = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_tipo_movimiento');
                        ContabilidadEditar.main.co_presupuesto_movimiento = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_presupuesto_movimiento');
                        ContabilidadEditar.main.tx_producto = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('tx_producto');
                        ContabilidadEditar.main.co_producto = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_producto');


                        var mo_disponible = ContabilidadEditar.main.store_lista.getAt(rowIndex).get('mo_disponible');

                        if (ContabilidadEditar.main.co_tipo_movimiento == 0 || ContabilidadEditar.main.co_tipo_movimiento == 4 || ContabilidadEditar.main.co_tipo_movimiento == 5) {
                            ContabilidadEditar.main.comprometer.enable();
                            ContabilidadEditar.main.descomprometer.disable();
                            ContabilidadEditar.main.cambiar_partida.enable();
                        } else {
                            ContabilidadEditar.main.descomprometer.enable();
                            ContabilidadEditar.main.comprometer.disable();
                            ContabilidadEditar.main.cambiar_partida.disable();
                        }

                        if (parseFloat(mo_disponible) < parseFloat(ContabilidadEditar.main.monto)) {
                            ContabilidadEditar.main.comprometer.disable();
                        }
                    }
                }
            });

            if (this.OBJ.co_compras != '') {

                ContabilidadEditar.main.store_lista.baseParams.co_compra = ContabilidadEditar.main.OBJ.co_compras;
                this.store_lista.load({
                    callback: function() {
                        ContabilidadEditar.main.total_pagar = paqueteComunJS.funcion.getSumaColumnaGrid({
                            store: ContabilidadEditar.main.store_lista,
                            campo: 'monto'
                        });

                        ContabilidadEditar.main.monto_total.setValue("<span style='font-size:12px;'><b>Total a Pagar: </b>" + paqueteComunJS.funcion.getNumeroFormateado(ContabilidadEditar.main.total_pagar) + "</b></span>");
                    }
                });

            }

            this.datos = '<p class="registro_detalle"><b>RIF: </b>' + this.OBJ.tipo + '-' + this.OBJ.tx_rif + '</p>';
            this.datos += '<p class="registro_detalle"><b>Razón Social: </b>' + this.OBJ.tx_razon_social + '</p>';
            this.datos += '<p class="registro_detalle"><b>Dirección: </b>' + this.OBJ.tx_direccion + '</p>';

            this.fieldDatos = new Ext.form.FieldSet({
                title: 'Datos del Proveedor',
                html: this.datos
            });

            this.datosContrato = '<p class="registro_detalle"><b>Ramo: </b>' + this.OBJ.tx_ramo + '</p>';
            this.datosContrato += '<p class="registro_detalle"><b>Monto previsto: </b>' + paqueteComunJS.funcion.getNumeroFormateado(this.OBJ.monto) + '</p>';
            this.datosContrato += '<p class="registro_detalle"><b>Ejecutor: </b>' + this.OBJ.de_ejecutor + '</p>';
            /*this.datosContrato +='<p class="registro_detalle"><b>Proyecto/Ac: </b>'+this.OBJ.de_proyecto_ac+'</p>';
            this.datosContrato +='<p class="registro_detalle"><b>Acción Específica: </b>'+this.OBJ.de_accion_especifica+'</p>';
            */

            this.fieldDatosContrato = new Ext.form.FieldSet({
                title: 'Datos del Contrato',
                html: this.datosContrato
            });

            this.tx_concepto = new Ext.form.TextField({
                fieldLabel: 'Concepto',
                name: 'tb039_requisiciones[tx_concepto]',
                value: this.OBJ.tx_concepto,
                allowBlank: false,
                width: 680
            });

            this.tx_observacion = new Ext.form.TextArea({
                fieldLabel: 'Observaciones',
                name: 'tb039_requisiciones[tx_observacion]',
                value: this.OBJ.tx_observacion,
                width: 680
            });

            this.fieldDatosRequisicion = new Ext.form.FieldSet({
                items: [this.tx_concepto,
                    this.tx_observacion
                ]
            });




            this.salir = new Ext.Button({
                text: 'Salir',
                //    iconCls: 'icon-cancelar',
                handler: function() {
                    ContabilidadEditar.main.winformPanel_.close();
                }
            });


            this.formPanel_ = new Ext.form.FormPanel({
                frame: true,
                width: 1100,
                autoHeight: true,
                autoScroll: true,
                bodyStyle: 'padding:10px;',
                items: [this.co_compra,
                    this.co_documento,
                    this.co_ramo,
                    this.co_solicitud,
                    this.hiddenJsonFactura,
                    this.fieldDatos,
                    this.fieldDatosContrato,
                    this.gridPanel
                ]
            });

            this.winformPanel_ = new Ext.Window({
                title: 'Presupuesto',
                modal: true,
                constrain: true,
                width: 1100,
                frame: true,
                closabled: true,
                autoHeight: true,
                items: [
                    this.formPanel_
                ],
                buttons: [
                    // this.guardar,
                    this.salir
                ],
                buttonAlign: 'center'
            });
            this.winformPanel_.show();
        },
        getListaResumen: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storelistaResumen',
                root: 'data',
                fields: [

                    {
                        name: 'nu_partida'
                    },
                    {
                        name: 'de_partida'
                    },
                    {
                        name: 'mo_disponible'
                    },
                    {
                        name: 'monto'
                    },
                    {
                        name: 'id'
                    }
                ]
            });
            return this.store;
        },
        afectar_partida: function() {
            Ext.Ajax.request({
                method: 'POST',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/cambiarEstadoCompra',
                params: {
                    co_detalle_compras: ContabilidadEditar.main.co_detalle_compras,
                    co_solicitud: ContabilidadEditar.main.OBJ.co_solicitud,
                    id_partida: ContabilidadEditar.main.id_partida,
                    monto: ContabilidadEditar.main.monto,
                    nu_partida: ContabilidadEditar.main.nu_partida,
                    co_tipo_movimiento: ContabilidadEditar.main.co_tipo_movimiento,
                    co_presupuesto_movimiento: ContabilidadEditar.main.co_tipo_movimiento,
                    co_compra: ContabilidadEditar.main.co_compra.getValue()
                },
                success: function(result, request) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if (obj.success == true) {
                        ContabilidadEditar.main.comprometer.disable();
                        ContabilidadEditar.main.descomprometer.disable();
                        ContabilidadEditar.main.cambiar_partida.disable();
                        ContabilidadEditar.main.store_lista.load();
                        Ext.Msg.alert("Notificación", obj.msg);
                    } else {
                        Ext.Msg.alert("Notificación", obj.msg);
                    }

                    this.store_lista.baseParams.paginar = 'si';
                    this.store_lista.load();
                    this.store_lista.on('load', function() {
                        pendienteEntidadesLista.main.estado.disable();
                        pendienteEntidadesLista.main.revision.disable();
                    });

                    ContabilidadEditar.main.mascara.hide();
                }
            });
        },
        getLista: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storelista',
                root: 'data',
                fields: [{
                        name: 'co_partida'
                    },
                    {
                        name: 'co_detalle_compras'
                    },
                    {
                        name: 'tx_producto'
                    },
                    {
                        name: 'co_producto'
                    },
                    {
                        name: 'nu_partida'
                    },
                    {
                        name: 'de_partida'
                    },
                    {
                        name: 'mo_disponible'
                    },
                    {
                        name: 'monto'
                    },
                    {
                        name: 'co_tipo_movimiento'
                    },
                    {
                        name: 'tx_tipo_movimiento'
                    }
                ]
            });
            return this.store;
        }
    };
    Ext.onReady(ContabilidadEditar.main.init, ContabilidadEditar.main);
</script>
<div id="formularioAgregar"></div>