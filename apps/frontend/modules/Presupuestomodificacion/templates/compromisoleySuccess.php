<script type="text/javascript">
    Ext.ns("PresupuestomodificacionEditar");
    PresupuestomodificacionEditar.main = {
        init: function() {

            this.OBJ = paqueteComunJS.funcion.doJSON({
                stringData: '<?php echo $data ?>'
            });
            this.storeID_PRESUPUESTO = this.getStoreID_PRESUPUESTO();
            //Mascara general del modulo
            this.mascara = new Ext.LoadMask(Ext.getBody(), {
                msg: "Cargando..."
            });

            //<ClavePrimaria>
            this.id_tb096_presupuesto_modificacion = new Ext.form.Hidden({
                name: 'id_tb096_presupuesto_modificacion',
                value: this.OBJ.id_tb096_presupuesto_modificacion
            });


            this.id_tb097_modificacion_detalle = new Ext.form.Hidden({
                name: 'id_tb097_modificacion_detalle',
                value: this.OBJ.id_tb097_modificacion_detalle
            });
            this.nu_partida = new Ext.form.Hidden({
                name: 'tb096_presupuesto_modificacion[nu_partida]',
                //    value:this.OBJ.nu_partida
            });
            //</ClavePrimaria>
            this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();
            //this.storeCO_PROYECTO = this.getStoreCO_PROYECTO();


            this.co_solicitud = new Ext.form.Hidden({
                name: 'tb096_presupuesto_modificacion[co_solicitud]',
                value: this.OBJ.co_solicitud
                //allowBlank:false
            });

            this.co_presupuesto_ingreso_anterior = new Ext.form.Hidden({
                name: 'tb096_presupuesto_modificacion[co_presupuesto_ingreso_anterior]',
                value: this.OBJ.id_tb064_presupuesto_ingreso
                //allowBlank:false
            });

            this.monto_ingreso_anterior = new Ext.form.Hidden({
                name: 'tb096_presupuesto_modificacion[monto_ingreso_anterior]',
                value: this.OBJ.mo_distribucion
                //allowBlank:false
            });

            this.co_tipo_solicitud = new Ext.form.Hidden({
                name: 'tb096_presupuesto_modificacion[co_tipo_solicitud]',
                value: this.OBJ.co_tipo_solicitud
                //allowBlank:false
            });

            this.fe_modificacion = new Ext.form.DateField({
                fieldLabel: 'Fecha Compromiso',
                name: 'tb096_presupuesto_modificacion[fe_modificacion]',
                value: this.OBJ.fe_modificacion,
                allowBlank: false,
                width: 100
            });

            this.de_modificacion = new Ext.form.TextArea({
                fieldLabel: 'Descripcion',
                name: 'tb096_presupuesto_modificacion[de_modificacion]',
                value: this.OBJ.de_modificacion,
                allowBlank: false,
                width: 500
            });

            this.de_justificacion = new Ext.form.TextArea({
                fieldLabel: 'Justificacion',
                name: 'tb096_presupuesto_modificacion[de_justificacion]',
                value: this.OBJ.de_justificacion,
                allowBlank: false,
                width: 500
            });

            this.nu_oficio = new Ext.form.TextField({
                fieldLabel: 'N° de Decreto',
                name: 'tb096_presupuesto_modificacion[nu_oficio]',
                value: this.OBJ.nu_oficio,
                allowBlank: false,
                width: 100
            });

            this.fe_oficio = new Ext.form.DateField({
                fieldLabel: 'Fecha de Oficio',
                name: 'tb096_presupuesto_modificacion[fe_oficio]',
                value: this.OBJ.fe_oficio,
                allowBlank: false,
                width: 100
            });

            this.de_articulo_ley = new Ext.form.TextField({
                fieldLabel: 'Articulo / Ley',
                name: 'tb096_presupuesto_modificacion[de_articulo_ley]',
                value: this.OBJ.de_articulo_ley,
                allowBlank: false,
                width: 500
            });

            this.id_tb082_ejecutor_origen = new Ext.form.ComboBox({
                fieldLabel: 'Ejecutor',
                store: this.storeCO_EJECUTOR,
                typeAhead: true,
                id: 'id_tb082_ejecutor_origen',
                valueField: 'id',
                displayField: 'de_ejecutor',
                hiddenName: 'tb096_presupuesto_modificacion[id_tb082_ejecutor_origen]',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width: 500
            });

            this.storeCO_EJECUTOR.load();

            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.id_tb082_ejecutor_origen,
                value: this.OBJ.id_tb082_ejecutor_origen,
                objStore: this.storeCO_EJECUTOR
            });


            this.id_tb064_presupuesto_ingreso = new Ext.form.ComboBox({
                fieldLabel: 'Partida de Ingreso',
                store: this.storeID_PRESUPUESTO,
                typeAhead: true,
                id: 'id_tb064_presupuesto_ingreso',
                valueField: 'co_presupuesto_ingreso',
                displayField: 'partida',
                hiddenName: 'tb096_presupuesto_modificacion[id_tb064_presupuesto_ingreso]',
                //  readOnly:(this.OBJ.id_tb064_presupuesto_ingreso!='')?true:false,
                //  style:(this.OBJ.id_tb064_presupuesto_ingreso!='')?'background-color:#c9c9c9;':'',
                forceSelection: true,
                resizable: true,
                triggerAction: 'all',
                emptyText: 'Seleccione Partida...',
                selectOnFocus: true,
                mode: 'local',
                width: 500,
                onSelect: function(record) {
                    PresupuestomodificacionEditar.main.mo_distribucion.setValue('');
                    PresupuestomodificacionEditar.main.id_tb064_presupuesto_ingreso.setValue(record.data.co_presupuesto_ingreso);
                    PresupuestomodificacionEditar.main.nu_partida.setValue(record.data.nu_partida);
//                    PresupuestomodificacionEditar.main.monto.setValue(record.data.mo_inicial);
                    PresupuestomodificacionEditar.main.mo_disponible.setValue(record.data.mo_inicial);
                    this.collapse();
                }
            });

            this.storeID_PRESUPUESTO.load();
            paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.id_tb064_presupuesto_ingreso,
                value: this.OBJ.id_tb064_presupuesto_ingreso,
                objStore: this.storeID_PRESUPUESTO
            });

            this.mo_disponible = new Ext.form.Hidden({
                name: 'tb096_presupuesto_modificacion[mo_disponible]',
                value: this.OBJ.mo_disponible
            });

            this.monto = new Ext.form.NumberField({
                fieldLabel: 'Monto',
                name: 'tb096_presupuesto_modificacion[monto]',
                value: this.OBJ.mo_distribucion,
                //readOnly: true,
                //style:'background:#c9c9c9;',
                width: 200
            });

            this.mo_distribucion = new Ext.form.NumberField({
                fieldLabel: 'Monto',
                name: 'tb096_presupuesto_modificacion[mo_distribucion]',
                value: this.OBJ.mo_distribucion,
                width: 200
            });

            this.crear = new Ext.Button({
                text: 'Crear',
                iconCls: 'icon-nuevo',
                handler: function() {


                    if (!PresupuestomodificacionEditar.main.formPanel_.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
                        return false;
                    }

                    PresupuestomodificacionEditar.main.formPanel_.getForm().submit({
                        method: 'POST',
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/crearCompromiso',
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

                            PresupuestomodificacionEditar.main.id_tb096_presupuesto_modificacion.setValue(action.result.codigo);
                            PresupuestomodificacionEditar.main.nu_modificacion.setValue("<span style='color:black;font-size:15px;'><b>N° Traslado: </b> " + action.result.numero + "</span>");

                            solicitudLista.main.store_lista.baseParams.paginar = 'si';
                            solicitudLista.main.store_lista.baseParams.in_ventanilla = 'true';
                            solicitudLista.main.store_lista.load();
                            solicitudLista.main.store_lista.on('load', function() {
                                solicitudLista.main.estado.disable();
                                solicitudLista.main.anular.disable();
                            });

                            PresupuestomodificacionEditar.main.tabuladores.items.itemAt(1).setDisabled(false);
                            PresupuestomodificacionEditar.main.guardar.show();
                            PresupuestomodificacionEditar.main.crear.hide();
                        }
                    });


                }
            });

            this.guardar = new Ext.Button({
                text: 'Guardar',
                iconCls: 'icon-guardar',
                handler: function() {

//                    if (PresupuestomodificacionEditar.main.id_tb064_presupuesto_ingreso.getValue() == '') {
//                        Ext.Msg.alert("Alerta", "Debe Seleccionar el ejecutor");
//                        return false;
//                    }

                    if (PresupuestomodificacionEditar.main.id_tb064_presupuesto_ingreso.getValue()==null) {
                        Ext.Msg.alert("Alerta", "Debe Seleccionar la partida");
                        return false;
                    }
                    
                            if(PresupuestomodificacionEditar.main.monto.getValue()==0){
                                Ext.Msg.alert("Alerta","El monto no Puede ser cero");
                                return false;
                            }                     
                            if(PresupuestomodificacionEditar.main.monto.getValue()==''){
                                Ext.Msg.alert("Alerta","Debe ingresar el Monto");
                                return false;
                            }              
      


                    if (!PresupuestomodificacionEditar.main.formPanel_.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
                        return false;
                    }

                    PresupuestomodificacionEditar.main.formPanel_.getForm().submit({
                        method: 'POST',
                        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/guardarCompromisoLey',
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
                            PresupuestomodificacionEditar.main.nu_modificacion.setValue("<span style='color:black;font-size:15px;'><b>N° Compromiso: </b> " + action.result.numero + "</span>");


                            solicitudLista.main.store_lista.baseParams.paginar = 'si';
                            solicitudLista.main.store_lista.baseParams.in_ventanilla = 'true';
                            solicitudLista.main.store_lista.load();
                            solicitudLista.main.store_lista.on('load', function() {
                                solicitudLista.main.estado.disable();
                                solicitudLista.main.anular.disable();
                            });

                            PresupuestomodificacionEditar.main.guardar.show();
                            PresupuestomodificacionEditar.main.crear.hide();
                            PresupuestomodificacionEditar.main.winformPanel_.close();
                        }
                    });


                }
            });

            this.salir = new Ext.Button({
                text: 'Salir',
                iconCls: 'icon-cancelar',
                handler: function() {
                    PresupuestomodificacionEditar.main.winformPanel_.close();
                }
            });

            this.fieldSet1 = new Ext.form.FieldSet({
                title: 'Datos del Traslado',
                items: [
                    //this.id_tb082_ejecutor,
                    this.fe_modificacion,
                    this.de_modificacion,
                    this.de_justificacion,
                    this.nu_oficio,
                    this.fe_oficio,
                    this.de_articulo_ley
                    //this.id_tb083_proyecto_ac
                ]
            });


            if (this.OBJ.id_tb096_presupuesto_modificacion) {
                this.crear.hide();
            } else {
                this.guardar.hide();
            }

            this.fieldSet2 = new Ext.form.FieldSet({
                title: 'Presupuesto de Ingreso',
                items: [
                    //this.id_tb082_ejecutor_origen,
                    this.id_tb064_presupuesto_ingreso,
                    this.co_presupuesto_ingreso_anterior,
                    this.monto_ingreso_anterior,
                    this.nu_partida,
                    this.mo_disponible,
                    this.monto,
                    //this.mo_distribucion
                ]
            });


            this.tabuladores = new Ext.TabPanel({
                resizeTabs: true, // turn on tab resizing
                minTabWidth: 115,
                tabWidth: 160,
                bodyStyle: 'padding:0px;',
                border: false,
                enableTabScroll: true,
                autoWidth: true,
                deferredRender: false,
                height: 350,
                activeTab: 0,
                defaults: {
                    autoScroll: true
                },
                items: [{
                        title: 'Datos del Compromiso',
                        items: [
                            this.fieldSet1,
                        ]
                    },
                    {
                        title: 'Presupuesto de Ingreso',
                        items: [
                            this.fieldSet2,
                        ]
                    }
                ]
            });

            this.formPanel_ = new Ext.form.FormPanel({
                frame: true,
                width: 800,
                autoHeight: true,
                autoScroll: true,
                bodyStyle: 'padding:0px;',
                items: [
                    this.id_tb096_presupuesto_modificacion,
                    this.id_tb097_modificacion_detalle,
                    this.co_solicitud,
                    this.co_tipo_solicitud,
                    this.tabuladores
                ]
            });
            if (this.OBJ.id_tb096_presupuesto_modificacion) {
                PresupuestomodificacionEditar.main.tabuladores.items.itemAt(1).setDisabled(false);
                this.nu_modificacion = new Ext.form.DisplayField({
                    value: "<span style='color:black;font-size:15px;'><b>N° Compromiso: </b> " + this.OBJ.nu_modificacion + "</span>"
                });
            } else {
                PresupuestomodificacionEditar.main.tabuladores.items.itemAt(1).setDisabled(true);
                this.nu_modificacion = new Ext.form.DisplayField({
                    value: "<span style='color:black;font-size:15px;'><b>N° Compromiso: </b> Por Asignar</span>"
                });
            }

            this.tbar_modificacion = {
                xtype: 'toolbar',
                layout: 'hbox',
                items: this.nu_modificacion,
                height: 25,
                layoutConfig: {
                    align: 'left'
                }
            };




            this.winformPanel_ = new Ext.Window({
                title: 'Formulario: Solicitud de Compromiso de Ley',
                modal: true,
                constrain: true,
                width: 811,
                frame: true,
                border: true,
                closabled: true,
                autoHeight: true,
                tbar: this.tbar_modificacion,
                items: [
                    this.formPanel_
                ],
                buttons: [
                    this.crear,
                    this.guardar,
                    this.salir
                ],
                buttonAlign: 'center'
            });
            this.winformPanel_.show();
            //PresupuestomodificacionLista.main.mascara.hide();
        },
        getStoreCO_EJECUTOR: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/storefkcoejecutor',
                root: 'data',
                fields: [{
                        name: 'id'
                    },
                    {
                        name: 'de_ejecutor',
                        convert: function(v, r) {
                            return r.nu_ejecutor + ' - ' + r.de_ejecutor;
                        }
                    }
                ]
            });
            return this.store;
        },
        getStoreCO_PROYECTO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/storefkcoproyecto',
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
        getLista_origen: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/storelistaIngreso',
                root: 'data',
                fields: [{
                        name: 'id'
                    },
                    {
                        name: 'id_tb096_presupuesto_modificacion'
                    },
                    {
                        name: 'id_tb013_anio_fiscal'
                    },
                    {
                        name: 'id_tb084_accion_especifica'
                    },
                    {
                        name: 'id_tb085_presupuesto'
                    },
                    {
                        name: 'co_partida'
                    },
                    {
                        name: 'de_partida'
                    },
                    {
                        name: 'id_tb098_tipo_distribucion'
                    },
                    {
                        name: 'mo_distribucion'
                    },
                ]
            });
            return this.store;
        },
        getLista_destino: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/storelistaDestino',
                root: 'data',
                fields: [{
                        name: 'id'
                    },
                    {
                        name: 'id_tb096_presupuesto_modificacion'
                    },
                    {
                        name: 'id_tb013_anio_fiscal'
                    },
                    {
                        name: 'id_tb084_accion_especifica'
                    },
                    {
                        name: 'id_tb085_presupuesto'
                    },
                    {
                        name: 'co_partida'
                    },
                    {
                        name: 'de_partida'
                    },
                    {
                        name: 'id_tb098_tipo_distribucion'
                    },
                    {
                        name: 'mo_distribucion'
                    },
                ]
            });
            return this.store;
        },
        getTotal: function() {

            this.monto_debito = 0;

            this.monto_credito = 0;

        },
        getStoreID_PRESUPUESTO: function() {
            this.store = new Ext.data.JsonStore({
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/storefkidtb064presupuestoingreso',
                root: 'data',
                fields: [{
                        name: 'co_presupuesto_ingreso'
                    },
                    {
                        name: 'nu_partida'
                    },
                    {
                        name: 'tx_partida'
                    },
                    {
                        name: 'tx_descripcion'
                    },
                    {
                        name: 'de_partida'
                    },
                    {
                        name: 'mo_disponible'
                    },
                    {
                        name: 'mo_inicial'
                    },
                    {
                        name: 'partida',
                        convert: function(v, r) {
                            return r.nu_partida + ' - ' + r.tx_descripcion;
                        }
                    },
                    {
                        name: 'monto',
                        convert: function(v, r) {
                            return paqueteComunJS.funcion.getNumeroFormateado(r.mo_inicial);
                        }
                    }
                ]
            });
            return this.store;
        }
    };
    Ext.onReady(PresupuestomodificacionEditar.main.init, PresupuestomodificacionEditar.main);
</script>
<div id="formularioModificaciondetalle"></div>