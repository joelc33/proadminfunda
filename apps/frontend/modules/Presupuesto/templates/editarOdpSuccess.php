<script type="text/javascript">
    Ext.ns("ContabilidadEditar");
    ContabilidadEditar.main = {
        init: function() {

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });
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


            this.store_lista = this.getLista();

            this.causar = new Ext.Button({
                text: 'Generar ODP',
                iconCls: 'icon-nuevo',
                handler: function() {
                    Ext.MessageBox.confirm('Confirmación', '¿Esta seguro que desea Generar la ODP por un monto de ' + paqueteComunJS.funcion.getNumeroFormateado(ContabilidadEditar.main.monto), function(boton) {
                        if (boton == "yes") { //a la partida '+ContabilidadEditar.main.nu_partida+'-'+ContabilidadEditar.main.de_partida+'?'
                            ContabilidadEditar.main.afectar_partida();
                        }
                    });
                }
            });

            this.descausar = new Ext.Button({
                text: 'Descausar',
                iconCls: 'icon-eliminar',
                id: 'id_descausar',
                handler: function(boton) {
                    Ext.MessageBox.confirm('Confirmación', '¿Esta seguro que desea descausar la partida?', function(boton) {
                        if (boton == "yes") {
                            ContabilidadEditar.main.afectar_partida();
                        }
                    });
                }
            });

            this.causar.disable();
            this.descausar.disable();

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

            //textoLargo

            this.gridPanel = new Ext.grid.GridPanel({
                title: 'Detalle de la Compra',
                iconCls: 'icon-libro',
                store: this.store_lista,
                loadMask: true,
                height: 300,
                width: 1060,
                tbar: [this.causar],
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
                    {
                        header: 'Estatus',
                        width: 130,
                        menuDisabled: true,
                        dataIndex: 'tx_tipo_movimiento'
                    },
                    {
                        header: 'Material',
                        width: 220,
                        menuDisabled: true,
                        dataIndex: 'tx_producto',
                        renderer: textoLargo
                    },
                    {
                        header: 'Cod. Partida',
                        width: 100,
                        menuDisabled: true,
                        dataIndex: 'nu_partida'
                    },
                    {
                        header: 'Partida',
                        width: 220,
                        menuDisabled: true,
                        dataIndex: 'de_partida',
                        renderer: textoLargo
                    },
                    {
                        header: 'Monto Disponible',
                        width: 180,
                        menuDisabled: true,
                        dataIndex: 'mo_disponible',
                        renderer: renderMonto
                    },
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

                        ContabilidadEditar.main.causar.enable();
                        /* if (ContabilidadEditar.main.co_tipo_movimiento == 1 || ContabilidadEditar.main.co_tipo_movimiento == 6) {
                             ContabilidadEditar.main.causar.enable();
                             ContabilidadEditar.main.descausar.disable();
                         } else {
                             ContabilidadEditar.main.descausar.enable();
                             ContabilidadEditar.main.causar.disable();
                         }*/
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

            this.datos = '<p class="registro_detalle"><b>Cédula: </b>' + this.OBJ.tx_rif + '</p>';
            this.datos += '<p class="registro_detalle"><b>Nombre y Apellido: </b>' + this.OBJ.tx_razon_social + '</p>';
            this.datos += '<p class="registro_detalle"><b>Teléfono: </b>' + this.OBJ.nu_celular + '</p>';

            this.fieldDatos = new Ext.form.FieldSet({
                title: 'Datos del Solicitante',
                html: this.datos
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
                    this.co_solicitud,
                    this.fieldDatos,
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
        afectar_partida: function() {
            Ext.Ajax.request({
                method: 'POST',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/cambiarEstadoCausadoViatico',
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
                        ContabilidadEditar.main.causar.disable();
                        ContabilidadEditar.main.descausar.disable();
                        ContabilidadEditar.main.store_lista.baseParams.co_compra = ContabilidadEditar.main.OBJ.co_compras;
                        ContabilidadEditar.main.store_lista.load();
                        Ext.Msg.alert("Notificación", obj.msg);

                        pendienteEntidadesLista.main.store_lista.baseParams.paginar = 'si';
                        pendienteEntidadesLista.main.store_lista.load();
                        pendienteEntidadesLista.main.store_lista.on('load', function() {
                            pendienteEntidadesLista.main.estado.disable();
                            pendienteEntidadesLista.main.revision.disable();
                        });

                        ContabilidadEditar.main.winformPanel_.close();


                    } else {
                        Ext.Msg.alert("Notificación", obj.msg);
                    }
                    ContabilidadEditar.main.winformPanel_.close();

                    ContabilidadEditar.main.mascara.hide();
                }
            });
        },
        getLista: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storelistacausar',
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