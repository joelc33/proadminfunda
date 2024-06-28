<script type="text/javascript">
    Ext.ns("PartidapresupuestoListaDesagregada");
    PartidapresupuestoListaDesagregada.main = {
        condicion: function(codigo) {
            return (codigo == '0') ? 'NO' : 'SI';
        },
        init: function() {

            this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();
            this.storeCO_APLICACION = this.getStoreCO_APLICACION();
            this.storeCO_DECRETO = this.getStoreCO_DECRETO();

            this.storeCO_PROYECTO = this.getStoreCO_PROYECTO();
            this.storeCO_ACCION = this.getStoreCO_ACCION();

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });

            //Mascara general del modulo
            this.mascara = new Ext.LoadMask(Ext.getBody(), {
                msg: "Cargando..."
            });

            //objeto store
            this.store_lista = this.getLista();

            this.co_detalle_cotizacion = new Ext.form.Hidden({
                name: 'co_detalle_cotizacion',
                value: this.OBJ.co_detalle_cotizacion
            });

            this.co_fuente_financiamiento = new Ext.form.Hidden({
                name: 'co_fuente_financiamiento',
                value: this.OBJ.co_fuente_financiamiento
            });

            this.co_solicitud = new Ext.form.Hidden({
                name: 'co_solicitud',
                value: this.OBJ.co_solicitud
            });

            this.co_cotizacion = new Ext.form.Hidden({
                name: 'co_cotizacion',
                value: this.OBJ.co_cotizacion
            });

            this.monto = new Ext.form.Hidden({
                name: 'monto'
            });

            this.co_presupuesto = new Ext.form.Hidden({
                name: 'co_presupuesto'
            });

            this.ejercicio = new Ext.form.Hidden({
                name: 'ejercicio',
                value: this.OBJ.ejercicio
            });

            this.co_ente_ejecutor = new Ext.form.ComboBox({
                fieldLabel: 'Ente Ejecutor',
                store: this.storeCO_EJECUTOR,
                typeAhead: true,
                valueField: 'id',
                id: 'co_ente_ejecutor',
                displayField: 'de_ejecutor',
                hiddenName: 'co_ejecutor',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 900,
                listeners: {
                    getSelectedIndex: function() {
                        var v = this.getValue();
                        var r = this.findRecord(this.valueField || this.displayField, v);
                        return (this.storeCO_EJECUTOR.indexOf(r));
                    },
                    select: function() {
                        PartidapresupuestoListaDesagregada.main.storeCO_DECRETO.load({
                            params: {
                                co_ejecutor: this.getValue()
                            }
                        });

                        PartidapresupuestoListaDesagregada.main.storeCO_APLICACION.load({
                            params: {
                                co_ejecutor: this.getValue()
                            }
                        });

                        PartidapresupuestoListaDesagregada.main.storeCO_PROYECTO.load({
                            params: {
                                co_ejecutor: this.getValue()
                            }
                        });
                    }
                }
            });
            this.storeCO_EJECUTOR.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.co_ente_ejecutor,
                value: this.OBJ.co_ejecutor,
                objStore: this.storeCO_EJECUTOR
            });

            this.co_proyecto = new Ext.form.ComboBox({
                fieldLabel: 'Proyecto/Ac',
                store: this.storeCO_PROYECTO,
                typeAhead: true,
                valueField: 'id',
                id: 'co_proyecto',
                displayField: 'de_proyecto_ac',
                hiddenName: 'co_proyecto',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 700,
                allowBlank: false
            });

            if (this.OBJ.co_ejecutor != '') {
                this.storeCO_PROYECTO.load({
                    params: {
                        co_ejecutor: this.OBJ.co_ejecutor
                    }
                });
            }
            this.co_proyecto.on('select', function(cmb, record, index) {
                PartidapresupuestoListaDesagregada.main.co_accion.clearValue();
                PartidapresupuestoListaDesagregada.main.storeCO_ACCION.load({
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
                hiddenName: 'co_accion',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 700,
                allowBlank: false
            });

            this.co_aplicacion = new Ext.form.ComboBox({
                fieldLabel: 'Aplicacion',
                store: this.storeCO_APLICACION,
                typeAhead: true,
                valueField: 'co_aplicacion',
                displayField: 'aplicacion',
                id: 'tip_apl',
                hiddenName: 'tip_apl',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione Aplicacion',
                selectOnFocus: true,
                mode: 'local',
                width: 700,
                allowBlank: false,
                listeners: {
                    select: function() {
                        PartidapresupuestoListaDesagregada.main.storeCO_DECRETO.load({
                            params: {
                                aplicacion: this.getValue(),
                                co_ejecutor: PartidapresupuestoListaDesagregada.main.co_ejecutor.getValue()
                            }
                        });
                    }
                }
            });

            this.co_decreto = new Ext.form.ComboBox({
                fieldLabel: 'Decreto',
                store: this.storeCO_DECRETO,
                typeAhead: true,
                valueField: 'nu_fi',
                displayField: 'nu_fi',
                hiddenName: 'nu_fi',
                id: 'nu_fi',
                //readOnly:(this.OBJ.co_proveedor!='')?true:false,
                //style:(this.OBJ.co_proveedor!='')?'background:#c9c9c9;':'',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione Decreto',
                selectOnFocus: true,
                mode: 'local',
                width: 700,
                allowBlank: false
            });


            this.nu_decreto = new Ext.form.NumberField({
                fieldLabel: 'Nº Decreto',
                name: 'nu_decreto',
                width: 215
            });

            this.nu_partida = new Ext.form.TextField({
                fieldLabel: 'Partida',
                name: 'nu_partida',
                width: 400
            });

            this.editar = new Ext.Button({
                text: 'Movimientos',
                iconCls: 'icon-reporteest',
                handler: function() {
                    //PartidapresupuestoLista.main.mascara.show();
                    this.msg = Ext.get('formularioPartidapresupuesto');
                    this.msg.load({
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Movimiento/lista',
                        scripts: true,
                        text: "Cargando..",
                        params: {
                            codigo: PartidapresupuestoListaDesagregada.main.gridPanel_.getSelectionModel().getSelected().get('id')
                        }
                    });
                }
            });

            //Editar un registro
            this.editar_aplicacion = new Ext.Button({
                text: 'Editar Aplicacion',
                iconCls: 'icon-editar',
                handler: function() {
                    this.codigo = PartidapresupuestoListaDesagregada.main.gridPanel_.getSelectionModel().getSelected().get('id');
                    PartidapresupuestoListaDesagregada.main.mascara.show();
                    this.msg = Ext.get('formularioPartidapresupuesto');
                    this.msg.load({
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/editarAplicacion/codigo/' + this.codigo,
                        scripts: true,
                        text: "Cargando.."
                    });
                }
            });

            this.formFiltroPrincipal = new Ext.form.FormPanel({
                title: 'Lista ',
                iconCls: 'icon-solpendiente',
                collapsible: true,
                titleCollapse: true,
                autoWidth: true,
                border: false,
                labelWidth: 110,
                padding: '10px',
                items: [
                    this.co_ente_ejecutor,
                    this.co_proyecto,
                    this.co_accion,
                    // this.co_decreto,
                    this.nu_partida,
                    this.monto
                ],
                keys: [{
                    key: [Ext.EventObject.ENTER],
                    handler: function() {
                        PartidapresupuestoListaDesagregada.main.aplicarFiltroByFormulario();
                    }
                }],
                buttonAlign: 'center',
                buttons: [{
                        text: 'Consultar',
                        iconCls: 'icon-buscar',
                        handler: function() {
                            PartidapresupuestoListaDesagregada.main.aplicarFiltroByFormulario();
                        }
                    },
                    {
                        text: 'Limpiar', // Limpiar campos del formulario
                        iconCls: 'icon-limpiar',
                        handler: this.limpiarCamposByFormFiltro
                    }
                ]
            });

            this.excel = new Ext.Button({
                text: 'Exportar a XLS',
                iconCls: 'icon-libro',
                handler: this.onExportarPresupuesto
            });

            this.excelDecreto = new Ext.Button({
                text: 'Exportar por Decreto a XLS',
                iconCls: 'icon-libro',
                handler: this.onExportarPresupuestoDecreto
            });

            this.excelSaldoInicial = new Ext.Button({
                text: 'Exportar Saldos Iniciales a XLS',
                iconCls: 'icon-libro',
                handler: this.onExportarSaldoInicial
            });

            this.excelReporteAnalitico = new Ext.Button({
                text: 'Reporte Analítico ODP XLS',
                iconCls: 'icon-libro',
                handler: this.onExportaAnaliticoODP
            });

            function formatoNro(val) {
                return '<p align="right">' + paqueteComunJS.funcion.getNumeroFormateado(val) + '</p>';
            }

            //Grid principal
            this.gridPanel_ = new Ext.grid.GridPanel({
                //title:'Lista de Partidapresupuesto',
                //iconCls: 'icon-libro',
                store: this.store_lista,
                loadMask: true,
                //    frame:true,
                height: 350,
                border: false,
                tbar: [

                ],
                columns: [
                    new Ext.grid.RowNumberer(),
                    {
                        header: 'id',
                        hidden: true,
                        menuDisabled: true,
                        dataIndex: 'id'
                    },
                    {
                        header: 'Codigo',
                        width: 240,
                        menuDisabled: true,
                        sortable: true,
                        dataIndex: 'nu_partida'
                    },
                    {
                        header: 'Descripcion',
                        width: 800,
                        menuDisabled: true,
                        sortable: true,
                        dataIndex: 'de_partida'
                    },
                    {
                        header: 'Disponible',
                        width: 150,
                        menuDisabled: true,
                        sortable: true,
                        renderer: formatoNro,
                        dataIndex: 'mo_disponible'
                    },

                ],
                listeners: {
                    cellclick: function(Grid, rowIndex, columnIndex, e) {
                        PartidapresupuestoListaDesagregada.main.co_presupuesto.setValue(PartidapresupuestoListaDesagregada.main.store_lista.getAt(rowIndex).get('id'));
                        PartidapresupuestoListaDesagregada.main.monto.setValue(PartidapresupuestoListaDesagregada.main.store_lista.getAt(rowIndex).get('mo_disponible'));
                    }
                },
                stripeRows: true,
                autoScroll: true,
                stateful: true,
                bbar: new Ext.PagingToolbar({
                    pageSize: 20,
                    store: this.store_lista,
                    displayInfo: true,
                    displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
                    emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
                })
            });

            this.guardar = new Ext.Button({
                text: 'Guardar',
                iconCls: 'icon-guardar',
                handler: function() {

                    if (!PartidapresupuestoListaDesagregada.main.formPanel_.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
                        return false;
                    }

                    PartidapresupuestoListaDesagregada.main.formPanel_.getForm().submit({
                        method: 'POST',
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/guardarCambioPb',
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


                            ContabilidadEditar.main.store_lista.load();

                            pendienteEntidadesLista.main.store_lista.baseParams.paginar = 'si';
                            pendienteEntidadesLista.main.store_lista.load();
                            pendienteEntidadesLista.main.store_lista.on('load', function() {
                                pendienteEntidadesLista.main.estado.disable();
                                pendienteEntidadesLista.main.revision.disable();
                            });

                            PartidapresupuestoListaDesagregada.main.winformPanel_.close();

                        }
                    });


                }
            });

            this.salir = new Ext.Button({
                text: 'Salir',
                //    iconCls: 'icon-cancelar',
                handler: function() {
                    PartidapresupuestoListaDesagregada.main.winformPanel_.close();
                }
            });

            //this.gridPanel_.render("contenedorPartidapresupuestoListaDesagregada");

            this.formPanel_ = new Ext.form.FormPanel({
                frame: true,
                width: 900,
                autoHeight: true,
                autoScroll: true,
                bodyStyle: 'padding:10px;',
                items: [
                    this.co_detalle_cotizacion,
                    this.co_fuente_financiamiento,
                    this.co_solicitud,
                    this.co_cotizacion,
                    this.monto,
                    this.co_presupuesto
                ]
            });

            this.winformPanel_ = new Ext.Window({
                title: 'Formulario: Partidas',
                modal: true,
                constrain: true,
                width: 1300,
                frame: true,
                closabled: true,
                autoHeight: true,
                items: [
                    this.formFiltroPrincipal,
                    this.gridPanel_,
                    this.formPanel_
                ],
                buttons: [
                    this.guardar,
                    this.salir
                ],
                buttonAlign: 'center'
            });

            this.winformPanel_.show();
            PartidapresupuestoListaDesagregada.main.mascara.hide();

            PartidapresupuestoListaDesagregada.main.store_lista.baseParams.nu_partida = PartidapresupuestoListaDesagregada.main.OBJ.nu_partida;
            PartidapresupuestoListaDesagregada.main.store_lista.baseParams.co_accion_especifica = PartidapresupuestoListaDesagregada.main.OBJ.co_accion_especifica;
            PartidapresupuestoListaDesagregada.main.store_lista.baseParams.co_ejecutor = PartidapresupuestoListaDesagregada.main.OBJ.co_ejecutor;
            this.store_lista.load();

        },
        aplicarFiltroByFormulario: function() {
            //Capturamos los campos con su value para posteriormente verificar cual
            //esta lleno y trabajar en base a ese.
            var campo = PartidapresupuestoListaDesagregada.main.formFiltroPrincipal.getForm().getValues();

            PartidapresupuestoListaDesagregada.main.store_lista.baseParams = {}

            var swfiltrar = false;
            for (campName in campo) {
                if (campo[campName] != '') {
                    swfiltrar = true;
                    eval(" PartidapresupuestoListaDesagregada.main.store_lista.baseParams." + campName + " = '" + campo[campName] + "';");
                }
            }
            if (swfiltrar == true) {
                PartidapresupuestoListaDesagregada.main.store_lista.baseParams.BuscarBy = true;
                // PartidapresupuestoListaDesagregada.main.store_lista.baseParams.in_ventanilla = 'true';
                PartidapresupuestoListaDesagregada.main.store_lista.load();
            } else {
                Ext.MessageBox.show({
                    title: 'Notificación',
                    msg: 'Debe ingresar un parametro de busqueda',
                    buttons: Ext.MessageBox.OK,
                    icon: Ext.MessageBox.WARNING
                });
            }

        },
        limpiarCamposByFormFiltro: function() {
            PartidapresupuestoListaDesagregada.main.formFiltroPrincipal.getForm().reset();
            PartidapresupuestoListaDesagregada.main.store_lista.baseParams = {};
            PartidapresupuestoListaDesagregada.main.store_lista.load();
        },
        onExportarPresupuestoDecreto: function() {

            var co_ejecutor = PartidapresupuestoListaDesagregada.main.co_ente_ejecutor.getValue();
            var co_aplicacion = PartidapresupuestoListaDesagregada.main.co_aplicacion.getValue();
            var co_decreto = PartidapresupuestoListaDesagregada.main.co_decreto.getValue();
            var ejercicio = PartidapresupuestoListaDesagregada.main.ejercicio.getValue();

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/presupuesto_decreto_XLS.php?co_ejecutor=' + co_ejecutor + '&co_decreto=' + co_decreto + '&ejercicio=' + ejercicio);
        },
        onExportarSaldoInicial: function() {

            var co_ejecutor = PartidapresupuestoListaDesagregada.main.co_ente_ejecutor.getValue();
            var co_aplicacion = PartidapresupuestoListaDesagregada.main.co_aplicacion.getValue();
            var co_decreto = PartidapresupuestoListaDesagregada.main.co_decreto.getValue();
            var ejercicio = PartidapresupuestoListaDesagregada.main.ejercicio.getValue();

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/presupuesto_saldo_inicial_XLS.php?co_ejecutor=' + co_ejecutor + '&co_decreto=' + co_decreto + '&ejercicio=' + ejercicio);
        },
        onExportaAnaliticoODP: function() {

            var co_ejecutor = PartidapresupuestoListaDesagregada.main.co_ejecutor.getValue();
            var co_aplicacion = PartidapresupuestoListaDesagregada.main.co_aplicacion.getValue();
            var co_decreto = PartidapresupuestoListaDesagregada.main.co_decreto.getValue();
            var ejercicio = PartidapresupuestoListaDesagregada.main.ejercicio.getValue();

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/presupuesto_reporte_analitico_ODP_XLS.php?ejercicio=' + co_ejecutor + '&co_decreto=' + co_decreto + '&ejercicio=' + ejercicio);
        },
        onExportarPresupuesto: function() {

            var co_ejecutor = PartidapresupuestoListaDesagregada.main.co_ente_ejecutor.getValue();
            var co_aplicacion = PartidapresupuestoListaDesagregada.main.co_aplicacion.getValue();
            var co_decreto = PartidapresupuestoListaDesagregada.main.co_decreto.getValue();
            var ejercicio = PartidapresupuestoListaDesagregada.main.ejercicio.getValue();

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/presupuesto_XLS.php?co_ejecutor=' + co_ejecutor + '&co_aplicacion=' + co_aplicacion + '&co_decreto=' + co_decreto + '&ejercicio=' + ejercicio);
        },
        getStoreCO_EJECUTOR: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoejecutor',
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
        getStoreCO_APLICACION: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storefkcoaplicacion',
                root: 'data',
                fields: [{
                        name: 'co_aplicacion'
                    },
                    {
                        name: 'nu_anio_fiscal'
                    },
                    {
                        name: 'tx_tip_aplicacion'
                    },
                    {
                        name: 'tx_aplicacion'
                    },
                    {
                        name: 'tx_genera_cheque'
                    },
                    {
                        name: 'tx_tip_gasto'
                    },
                    {
                        name: 'aplicacion',
                        convert: function(v, r) {
                            return r.tx_tip_aplicacion + ' - ' + r.tx_aplicacion;
                        }
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_DECRETO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storefkcodecreto',
                root: 'data',
                fields: [{
                    name: 'nu_fi'
                }, ]
            });
            return this.store;
        },
        getLista: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storelistaDesagregadaTodas',
                root: 'data',
                fields: [{
                        name: 'id'
                    },
                    {
                        name: 'id_tb084_accion_especifica'
                    },
                    {
                        name: 'nu_partida'
                    },
                    {
                        name: 'de_partida'
                    },
                    {
                        name: 'mo_inicial'
                    },
                    {
                        name: 'mo_actualizado'
                    },
                    {
                        name: 'mo_precomprometido'
                    },
                    {
                        name: 'mo_comprometido'
                    },
                    {
                        name: 'mo_causado'
                    },
                    {
                        name: 'mo_pagado'
                    },
                    {
                        name: 'mo_disponible'
                    },
                    {
                        name: 'tx_cuenta'
                    },
                    {
                        name: 'nu_nivel'
                    },
                    {
                        name: 'aplicacion'
                    },
                    {
                        name: 'mo_aumento'
                    },
                    {
                        name: 'mo_disminucion'
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
        }
    };
    Ext.onReady(PartidapresupuestoListaDesagregada.main.init, PartidapresupuestoListaDesagregada.main);
</script>
<div id="contenedorPartidapresupuestoListaDesagregada"></div>
<div id="formularioPartidapresupuesto"></div>
<div id="filtroPartidapresupuesto"></div>