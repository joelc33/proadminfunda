<script type="text/javascript">
  Ext.ns("PresupuestomodificacionEditar");
  PresupuestomodificacionEditar.main = {
    init: function() {

      this.OBJ = paqueteComunJS.funcion.doJSON({
        stringData: '<?php echo $data ?>'
      });

      //Mascara general del modulo
      this.mascara = new Ext.LoadMask(Ext.getBody(), {
        msg: "Cargando..."
      });

      //<ClavePrimaria>
      this.id = new Ext.form.Hidden({
        name: 'id',
        value: this.OBJ.id
      });
      //</ClavePrimaria>
      this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();
      //this.storeCO_PROYECTO = this.getStoreCO_PROYECTO();
      //<Stores de fk>
      this.storeCO_NUMERO_FUENTE = this.getStoreCO_NUMERO_FUENTE();
      //<Stores de fk>
      //<Stores de fk>
      this.storeID_TIPO_CREDITO = this.getStoreID_TIPO_CREDITO();
      //<Stores de fk>
      //<Stores de fk>
      this.storeCO_FUENTE_FINANCIAMIENTO = this.getStoreID_TB073_FUENTE_FINANCIAMIENTO();
      //<Stores de fk>

      this.mo_modificacion = new Ext.form.Hidden({
        name: 'tb096_presupuesto_modificacion[mo_modificacion]',
        value: this.OBJ.mo_modificacion
      });

      this.co_solicitud = new Ext.form.Hidden({
        name: 'tb096_presupuesto_modificacion[co_solicitud]',
        value: this.OBJ.co_solicitud,
        allowBlank: false
      });

      this.co_tipo_solicitud = new Ext.form.Hidden({
        name: 'tb096_presupuesto_modificacion[co_tipo_solicitud]',
        value: this.OBJ.co_tipo_solicitud,
        allowBlank: false
      });

      this.fe_modificacion = new Ext.form.DateField({
        fieldLabel: 'Fecha Traslado',
        name: 'tb096_presupuesto_modificacion[fe_modificacion]',
        value: this.OBJ.fe_modificacion,
        //	allowBlank:false,
        width: 100
      });

      this.de_modificacion = new Ext.form.TextArea({
        fieldLabel: 'Descripcion',
        name: 'tb096_presupuesto_modificacion[de_modificacion]',
        value: this.OBJ.de_modificacion,
        //	allowBlank:false,
        width: 500
      });

      this.de_justificacion = new Ext.form.TextArea({
        fieldLabel: 'Justificacion',
        name: 'tb096_presupuesto_modificacion[de_justificacion]',
        value: this.OBJ.de_justificacion,
        //	allowBlank:false,
        width: 500
      });

      /*this.nu_oficio = new Ext.form.TextField({
      	fieldLabel:'N° de Decreto',
      	name:'tb096_presupuesto_modificacion[nu_oficio]',
      	value:this.OBJ.nu_oficio,
      //	allowBlank:false,
      	width:100
      });*/

      this.id_tb073_fuente_financiamiento = new Ext.form.ComboBox({
        fieldLabel: 'Tipo de Fuente',
        store: this.storeCO_FUENTE_FINANCIAMIENTO,
        typeAhead: true,
        valueField: 'co_fuente_financiamiento',
        displayField: 'tx_fuente_financiamiento',
        hiddenName: 'tb096_presupuesto_modificacion[id_tb073_fuente_financiamiento]',
        //readOnly:(this.OBJ.id_tb073_fuente_financiamiento!='')?true:false,
        //style:(this.main.OBJ.id_tb073_fuente_financiamiento!='')?'background:#c9c9c9;':'',
        forceSelection: true,
        resizable: true,
        triggerAction: 'all',
        emptyText: 'Seleccione Tipo de Fuente',
        selectOnFocus: true,
        mode: 'local',
        width: 500,
        resizable: true,
        allowBlank: false,
        listeners: {
          select: function() {
            PresupuestomodificacionEditar.main.id_tb068_numero_fuente_financiamiento.clearValue();
            PresupuestomodificacionEditar.main.storeCO_NUMERO_FUENTE.load({
              params: {
                tipo: this.getValue()
              }
            })
          }
        }
      });
      this.storeCO_FUENTE_FINANCIAMIENTO.load();
      paqueteComunJS.funcion.seleccionarComboByCo({
        objCMB: this.id_tb073_fuente_financiamiento,
        value: this.OBJ.id_tb073_fuente_financiamiento,
        objStore: this.storeCO_FUENTE_FINANCIAMIENTO
      });

      this.id_tb068_numero_fuente_financiamiento = new Ext.form.ComboBox({
        fieldLabel: 'N° de Decreto',
        store: this.storeCO_NUMERO_FUENTE,
        typeAhead: true,
        valueField: 'co_numero_fuente',
        displayField: 'tx_numero_fuente',
        hiddenName: 'tb096_presupuesto_modificacion[id_tb068_numero_fuente_financiamiento]',
        //readOnly:(this.OBJ.id_tb068_numero_fuente_financiamiento!='')?true:false,
        //style:(this.main.OBJ.id_tb068_numero_fuente_financiamiento!='')?'background:#c9c9c9;':'',
        forceSelection: true,
        resizable: true,
        triggerAction: 'all',
        emptyText: 'Seleccione N° de Decreto',
        selectOnFocus: true,
        mode: 'local',
        width: 500,
        resizable: true,
        allowBlank: false
      });
      /*
      this.storeCO_NUMERO_FUENTE.load();
      	paqueteComunJS.funcion.seleccionarComboByCo({
      	objCMB: this.id_tb068_numero_fuente_financiamiento,
      	value:  this.OBJ.id_tb068_numero_fuente_financiamiento,
      	objStore: this.storeCO_NUMERO_FUENTE
      });*/

      if (this.OBJ.id_tb073_fuente_financiamiento) {
        this.storeCO_NUMERO_FUENTE.load({
          params: {
            tipo: this.OBJ.id_tb073_fuente_financiamiento,
            numero: this.OBJ.id_tb068_numero_fuente_financiamiento
          },
          callback: function() {
            PresupuestomodificacionEditar.main.id_tb068_numero_fuente_financiamiento.setValue(PresupuestomodificacionEditar.main.OBJ.id_tb068_numero_fuente_financiamiento);
          }
        });

      }

      this.fe_oficio = new Ext.form.DateField({
        fieldLabel: 'Fecha de Oficio',
        name: 'tb096_presupuesto_modificacion[fe_oficio]',
        value: this.OBJ.fe_oficio,
        //	allowBlank:false,
        width: 100
      });

      this.de_articulo_ley = new Ext.form.TextField({
        fieldLabel: 'Nro Oficio',
        name: 'tb096_presupuesto_modificacion[de_articulo_ley]',
        value: this.OBJ.de_articulo_ley,
        //	allowBlank:false,
        width: 500
      });

      this.id_tb152_tipo_credito = new Ext.form.ComboBox({
        fieldLabel: 'Tipo de Credito',
        store: this.storeID_TIPO_CREDITO,
        typeAhead: true,
        valueField: 'id',
        displayField: 'de_tipo_credito',
        hiddenName: 'tb096_presupuesto_modificacion[id_tb152_tipo_credito]',
        //readOnly:(this.OBJ.id_tb152_tipo_credito!='')?true:false,
        //style:(this.main.OBJ.id_tb152_tipo_credito!='')?'background:#c9c9c9;':'',
        forceSelection: true,
        resizable: true,
        triggerAction: 'all',
        emptyText: 'Seleccione Tipo de Credito',
        selectOnFocus: true,
        mode: 'local',
        width: 500,
        resizable: true,
        allowBlank: false
      });
      this.storeID_TIPO_CREDITO.load();
      paqueteComunJS.funcion.seleccionarComboByCo({
        objCMB: this.id_tb152_tipo_credito,
        value: this.OBJ.id_tb152_tipo_credito,
        objStore: this.storeID_TIPO_CREDITO
      });

      this.id_tb082_ejecutor_origen = new Ext.form.ComboBox({
        fieldLabel: 'Ejecutor Presupuesto de Ingreso',
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
        width: 500,
        allowBlank: false
      });

      this.storeCO_EJECUTOR.load();

      paqueteComunJS.funcion.seleccionarComboByCo({
        objCMB: this.id_tb082_ejecutor_origen,
        value: this.OBJ.id_tb082_ejecutor_origen,
        objStore: this.storeCO_EJECUTOR
      });


      this.id_tb082_ejecutor_destino = new Ext.form.ComboBox({
        fieldLabel: 'Ejecutor',
        store: this.storeCO_EJECUTOR,
        typeAhead: true,
        id: 'id_tb082_ejecutor_destino',
        valueField: 'id',
        displayField: 'de_ejecutor',
        hiddenName: 'tb096_presupuesto_modificacion[id_tb082_ejecutor_destino]',
        forceSelection: true,
        resizable: true,
        triggerAction: 'all',
        selectOnFocus: true,
        mode: 'local',
        width: 500,
        allowBlank: false
      });

      this.storeCO_EJECUTOR.load();

      paqueteComunJS.funcion.seleccionarComboByCo({
        objCMB: this.id_tb082_ejecutor_destino,
        value: this.OBJ.id_tb082_ejecutor_destino,
        objStore: this.storeCO_EJECUTOR
      });
      /*this.id_tb082_ejecutor.on('select',function(cmb,record,index){
              PresupuestomodificacionEditar.main.id_tb083_proyecto_ac.clearValue();
              PresupuestomodificacionEditar.main.storeCO_PROYECTO.load({
                params:{
                  ejecutor:record.get('id')
                }
              });
      },this);

      this.id_tb083_proyecto_ac = new Ext.form.ComboBox({
      	fieldLabel:'Proyecto / AC',
      	store: this.storeCO_PROYECTO,
      	typeAhead: true,
      	valueField: 'id',
      	displayField:'de_proyecto_ac',
      	hiddenName:'tb096_presupuesto_modificacion[id_tb083_proyecto_ac]',
      	forceSelection:true,
      	resizable:true,
      	triggerAction: 'all',
      	selectOnFocus: true,
      	mode: 'local',
      	width:500,
      	allowBlank:false
      });

      if(this.OBJ.id_tb082_ejecutor!=''){
          this.storeCO_PROYECTO.load({
            params:{
              ejecutor:this.OBJ.id_tb082_ejecutor
            },
            callback: function(){
              PresupuestomodificacionEditar.main.id_tb083_proyecto_ac.setValue(PresupuestomodificacionEditar.main.OBJ.id_tb083_proyecto_ac);
            }
          });
      }*/

      this.crear = new Ext.Button({
        text: 'Crear',
        iconCls: 'icon-nuevo',
        handler: function() {

          //PresupuestomodificacionEditar.main.gridPanel_origen.enable();

          if (PresupuestomodificacionEditar.main.mo_modificacion.getValue() <= 0) {
            Ext.Msg.alert("Alerta", "EL monto de traslado debe ser superior a 0 para avanzar.");
            return false;
          }

          if (!PresupuestomodificacionEditar.main.formPanel_.getForm().isValid()) {
            Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
            return false;
          }

          PresupuestomodificacionEditar.main.formPanel_.getForm().submit({
            method: 'POST',
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/crearCredito',
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

              PresupuestomodificacionEditar.main.id.setValue(action.result.codigo);
              PresupuestomodificacionEditar.main.nu_modificacion.setValue("<span style='color:black;font-size:15px;'><b>N° Traslado: </b> " + action.result.numero + "</span>");

              PresupuestomodificacionEditar.main.gridPanel_origen.enable();
              PresupuestomodificacionEditar.main.gridPanel_destino.enable();

              /*PresupuestomodificacionLista.main.gridPanel_origen.load({
                params:{
                  id_tb096_presupuesto_modificacion:action.result.codigo
                }
              });*/
              //PresupuestomodificacionEditar.main.winformPanel_.close();
              //                 Detalle.main.store_lista.load();

              solicitudLista.main.store_lista.baseParams.paginar = 'si';
              solicitudLista.main.store_lista.baseParams.in_ventanilla = 'true';
              solicitudLista.main.store_lista.load();
              solicitudLista.main.store_lista.on('load', function() {
                solicitudLista.main.estado.disable();
                solicitudLista.main.anular.disable();
              });

              PresupuestomodificacionEditar.main.guardar.show();
              PresupuestomodificacionEditar.main.generar.show();
              PresupuestomodificacionEditar.main.crear.hide();
            }
          });


        }
      });

      this.guardar = new Ext.Button({
        text: 'Guardar (2)',
        iconCls: 'icon-guardar',
        handler: function() {

          //PresupuestomodificacionEditar.main.gridPanel_origen.enable();

          if (PresupuestomodificacionEditar.main.mo_modificacion.getValue() <= 0) {
            Ext.Msg.alert("Alerta", "EL monto de traslado debe ser superior a 0 para avanzar.");
            return false;
          }

          if (!PresupuestomodificacionEditar.main.formPanel_.getForm().isValid()) {
            Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
            return false;
          }

          PresupuestomodificacionEditar.main.formPanel_.getForm().submit({
            method: 'POST',
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/guardarCredito',
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

              PresupuestomodificacionEditar.main.id.setValue(action.result.codigo);
              PresupuestomodificacionEditar.main.nu_modificacion.setValue("<span style='color:black;font-size:15px;'><b>N° Credito: </b> " + action.result.numero + "</span>");

              PresupuestomodificacionEditar.main.gridPanel_origen.enable();
              PresupuestomodificacionEditar.main.gridPanel_destino.enable();

              solicitudLista.main.store_lista.baseParams.paginar = 'si';
              solicitudLista.main.store_lista.baseParams.in_ventanilla = 'true';
              solicitudLista.main.store_lista.load();
              solicitudLista.main.store_lista.on('load', function() {
                solicitudLista.main.estado.disable();
                solicitudLista.main.anular.disable();
              });
              PresupuestomodificacionEditar.main.guardar.show();
              PresupuestomodificacionEditar.main.generar.show();
              PresupuestomodificacionEditar.main.crear.hide();
              PresupuestomodificacionEditar.main.winformPanel_.close();
            }
          });


        }
      });

      this.generar = new Ext.Button({
        text: 'Generar Partidas (1)',
        iconCls: 'icon-aprobar',
        handler: function() {

          //PresupuestomodificacionEditar.main.gridPanel_origen.enable();

          if (PresupuestomodificacionEditar.main.mo_modificacion.getValue() <= 0) {
            Ext.Msg.alert("Alerta", "EL monto de traslado debe ser superior a 0 para avanzar.");
            return false;
          }

          if (!PresupuestomodificacionEditar.main.formPanel_.getForm().isValid()) {
            Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
            return false;
          }

          Ext.MessageBox.confirm('Confirmación', '¿Realmente desea generar las nuevas partidas?<br><b>Nota:</b> No se podran modificar los datos.', function(boton) {
            if (boton == "yes") {

              PresupuestomodificacionEditar.main.formPanel_.getForm().submit({
                method: 'POST',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/guardarCreditoGenerar',
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

                  PresupuestomodificacionEditar.main.id.setValue(action.result.codigo);
                  PresupuestomodificacionEditar.main.nu_modificacion.setValue("<span style='color:black;font-size:15px;'><b>N° Credito: </b> " + action.result.numero + "</span>");

                  PresupuestomodificacionEditar.main.gridPanel_origen.enable();
                  PresupuestomodificacionEditar.main.gridPanel_destino.enable();

                  solicitudLista.main.store_lista.baseParams.paginar = 'si';
                  solicitudLista.main.store_lista.baseParams.in_ventanilla = 'true';
                  solicitudLista.main.store_lista.load();
                  solicitudLista.main.store_lista.on('load', function() {
                    solicitudLista.main.estado.disable();
                    solicitudLista.main.anular.disable();
                  });
                  PresupuestomodificacionEditar.main.guardar.show();
                  PresupuestomodificacionEditar.main.generar.show();
                  PresupuestomodificacionEditar.main.crear.hide();
                  PresupuestomodificacionEditar.main.winformPanel_.close();
                }
              });

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
        title: 'Datos del Cedito Adicional',
        items: [
          //          this.id_tb082_ejecutor,
          this.mo_modificacion,
          this.fe_modificacion,
          this.de_modificacion,
          this.de_justificacion,
          //          this.nu_oficio,
          this.id_tb073_fuente_financiamiento,
          this.id_tb068_numero_fuente_financiamiento,
          this.fe_oficio,
          this.de_articulo_ley,
          this.id_tb152_tipo_credito,
          this.id_tb082_ejecutor_origen
          //          this.id_tb083_proyecto_ac
        ]
      });



      //objeto store
      this.store_lista = this.getLista_origen();
      this.store_lista_destino = this.getLista_destino();

      //Agregar un registro
      this.nuevo = new Ext.Button({
        text: 'Agregar',
        iconCls: 'icon-nuevo',
        handler: function() {

          if (PresupuestomodificacionEditar.main.id_tb082_ejecutor_origen.getValue() == '') {
            Ext.Msg.alert("Alerta", "Debe Seleccionar Ejecutor antes de agregar las partidas de origen.");
            return false;
          }

          PresupuestomodificacionEditar.main.mascara.show();
          this.msg = Ext.get('formularioModificaciondetalle');
          this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/editarCreditoadicional',
            params: {
              ejecutor: PresupuestomodificacionEditar.main.id_tb082_ejecutor_origen.getValue(),
              movimiento: PresupuestomodificacionEditar.main.id.getValue()
            },
            scripts: true,
            text: "Cargando.."
          });
        }
      });

      //Editar un registro
      this.editar = new Ext.Button({
        text: 'Editar',
        iconCls: 'icon-editar',
        handler: function() {
          this.codigo = PresupuestomodificacionEditar.main.gridPanel_origen.getSelectionModel().getSelected().get('id');
          PresupuestomodificacionEditar.main.mascara.show();
          this.msg = Ext.get('formularioModificaciondetalle');
          this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/editarCreditoadicional/codigo/' + this.codigo,
            scripts: true,
            text: "Cargando.."
          });
        }
      });

      //Eliminar un registro
      this.eliminar = new Ext.Button({
        text: 'Eliminar',
        iconCls: 'icon-eliminar',
        handler: function() {

          this.monto_credito = 0;
          this.monto_credito = paqueteComunJS.funcion.getSumaColumnaGrid({
            store: PresupuestomodificacionEditar.main.store_lista_destino,
            campo: 'mo_distribucion'
          });

          if (PresupuestomodificacionEditar.main.monto_credito > 0) {
            Ext.Msg.alert("Alerta", "<span style='color:red;font-size:13px'><b>Se deben eliminar las partidas de destino para poder eliminar esta partida de origen!</b></span>");
            return false;
          }

          this.codigo = PresupuestomodificacionEditar.main.gridPanel_origen.getSelectionModel().getSelected().get('id');
          Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton) {
            if (boton == "yes") {
              Ext.Ajax.request({
                method: 'POST',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/eliminar',
                params: {
                  id: PresupuestomodificacionEditar.main.gridPanel_origen.getSelectionModel().getSelected().get('id')
                },
                success: function(result, request) {
                  obj = Ext.util.JSON.decode(result.responseText);
                  if (obj.success == true) {
                    PresupuestomodificacionEditar.main.store_lista.load({
                      callback: function() {
                        PresupuestomodificacionEditar.main.getTotal();
                      }
                    });
                    Ext.Msg.alert("Notificación", obj.msg);
                  } else {
                    Ext.Msg.alert("Notificación", obj.msg);
                  }
                  PresupuestomodificacionEditar.main.mascara.hide();
                }
              });
            }
          });
        }
      });

      this.editar.disable();
      this.eliminar.disable();

      //Grid principal
      this.gridPanel_origen = new Ext.grid.GridPanel({
        title: 'Presupuesto de Ingreso',
        store: this.store_lista,
        loadMask: true,
        border: false,
        disabled: true,
        id: 'grid_datos_origen',
        //    frame:true,
        height: 340,
        tbar: [
          this.nuevo, '-', this.editar, '-', this.eliminar
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
            width: 150,
            menuDisabled: true,
            sortable: true,
            dataIndex: 'co_partida'
          },
          {
            header: 'Denominacion',
            width: 400,
            menuDisabled: true,
            sortable: true,
            dataIndex: 'de_partida'
          },
          {
            header: 'Monto',
            width: 150,
            menuDisabled: true,
            sortable: true,
            renderer: formatoNumero,
            dataIndex: 'mo_distribucion'
          },
        ],
        stripeRows: true,
        autoScroll: true,
        stateful: true,
        listeners: {
          cellclick: function(Grid, rowIndex, columnIndex, e) {
            PresupuestomodificacionEditar.main.editar.enable();
            PresupuestomodificacionEditar.main.eliminar.enable();
          }
        },
        bbar: new Ext.PagingToolbar({
          pageSize: 1000,
          store: this.store_lista,
          displayInfo: true,
          displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
          emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
        })
      });

      if (this.OBJ.id) {
        this.crear.hide();
        this.store_lista.baseParams.id_tb096_presupuesto_modificacion = this.OBJ.id;
        this.store_lista.load({
          callback: function() {
            PresupuestomodificacionEditar.main.getTotal();
          }
        });
        this.store_lista_destino.baseParams.id_tb096_presupuesto_modificacion = this.OBJ.id;
        this.store_lista_destino.load({
          callback: function() {
            PresupuestomodificacionEditar.main.getTotal();
          }
        });
      } else {
        this.guardar.hide();
        this.generar.hide();
        this.store_lista.baseParams.id_tb096_presupuesto_modificacion = PresupuestomodificacionEditar.main.id.getValue();
        this.store_lista.load({
          callback: function() {
            PresupuestomodificacionEditar.main.getTotal();
          }
        });
        this.store_lista_destino.baseParams.id_tb096_presupuesto_modificacion = PresupuestomodificacionEditar.main.id.getValue();
        this.store_lista_destino.load({
          callback: function() {
            PresupuestomodificacionEditar.main.getTotal();
          }
        });
      }

      this.fieldSet2 = new Ext.form.FieldSet({
        title: 'Presupuesto de Ingreso',
        items: [
         // this.id_tb082_ejecutor_origen,
          this.gridPanel_origen
        ]
      });

      //Agregar un registro
      this.nuevo_destino = new Ext.Button({
        text: 'Agregar',
        iconCls: 'icon-nuevo',
        handler: function() {

          /*if(PresupuestomodificacionEditar.main.id_tb082_ejecutor_destino.getValue()==''){
            Ext.Msg.alert("Alerta","Debe Seleccionar Ejecutor antes de agregar las partidas de origen.");
            return false;
          }*/

          PresupuestomodificacionEditar.main.mascara.show();
          this.msg = Ext.get('formularioModificaciondetalle');
          this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/destino',
            params: {
              ejecutor: PresupuestomodificacionEditar.main.id_tb082_ejecutor_destino.getValue(),
              movimiento: PresupuestomodificacionEditar.main.id.getValue()
            },
            scripts: true,
            text: "Cargando.."
          });
        }
      });

      //Editar un registro
      this.editar_destino = new Ext.Button({
        text: 'Editar',
        iconCls: 'icon-editar',
        handler: function() {
          this.codigo = PresupuestomodificacionEditar.main.gridPanel_destino.getSelectionModel().getSelected().get('id');
          PresupuestomodificacionEditar.main.mascara.show();
          this.msg = Ext.get('formularioModificaciondetalle');
          this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/destino/codigo/' + this.codigo,
            scripts: true,
            text: "Cargando.."
          });
        }
      });

      //Eliminar un registro
      this.eliminar_destino = new Ext.Button({
        text: 'Eliminar',
        iconCls: 'icon-eliminar',
        handler: function() {
          this.codigo = PresupuestomodificacionEditar.main.gridPanel_destino.getSelectionModel().getSelected().get('id');
          Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton) {
            if (boton == "yes") {
              Ext.Ajax.request({
                method: 'POST',
                url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modificaciondetalle/eliminar/destino',
                params: {
                  id: PresupuestomodificacionEditar.main.gridPanel_destino.getSelectionModel().getSelected().get('id')
                },
                success: function(result, request) {
                  obj = Ext.util.JSON.decode(result.responseText);
                  if (obj.success == true) {
                    PresupuestomodificacionEditar.main.store_lista_destino.load({
                      callback: function() {
                        PresupuestomodificacionEditar.main.getTotal();
                      }
                    });
                    Ext.Msg.alert("Notificación", obj.msg);
                  } else {
                    Ext.Msg.alert("Notificación", obj.msg);
                  }
                  PresupuestomodificacionEditar.main.mascara.hide();
                }
              });
            }
          });
        }
      });

      this.editar_destino.disable();
      this.eliminar_destino.disable();

      //Grid principal
      this.gridPanel_destino = new Ext.grid.GridPanel({
        title: 'Presupuesto de Gasto',
        disabled: true,
        store: this.store_lista_destino,
        loadMask: true,
        border: false,
        //    frame:true,
        height: 360,
        tbar: [
          this.nuevo_destino /*,'-',this.editar_destino*/ , '-', this.eliminar_destino
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
            header: 'Ejecutor',
            width: 100,
            menuDisabled: true,
            sortable: true,
            dataIndex: 'ejecutor'
          },
          {
            header: 'Codigo',
            width: 150,
            menuDisabled: true,
            sortable: true,
            dataIndex: 'co_partida'
          },
          {
            header: 'Denominacion',
            width: 300,
            menuDisabled: true,
            sortable: true,
            dataIndex: 'de_partida'
          },
          {
            header: 'Monto',
            width: 150,
            menuDisabled: true,
            sortable: true,
            renderer: formatoNumero,
            dataIndex: 'mo_distribucion'
          },
        ],
        stripeRows: true,
        autoScroll: true,
        stateful: true,
        listeners: {
          cellclick: function(Grid, rowIndex, columnIndex, e) {
            PresupuestomodificacionEditar.main.editar_destino.enable();
            PresupuestomodificacionEditar.main.eliminar_destino.enable();
          }
        },
        bbar: new Ext.PagingToolbar({
          pageSize: 1000,
          store: this.store_lista_destino,
          displayInfo: true,
          displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
          emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
        })
      });

      this.store_lista_destino.on('beforeload', function() {
        PresupuestomodificacionEditar.main.getTotal();
      });

      this.fieldSet3 = new Ext.form.FieldSet({
        title: 'Presupuesto de Gasto',
        items: [
          //this.id_tb082_ejecutor_destino,
          this.gridPanel_destino
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
        height: 520,
        activeTab: 0,
        defaults: {
          autoScroll: true
        },
        items: [{
            title: 'Datos de Movimiento',
            items: [
              this.fieldSet1,
            ]
          },
          {
            title: 'Presupuesto de Ingreso',
            items: [
              this.fieldSet2,
            ]
          },
          {
            title: 'Presupuesto de Gasto',
            items: [
              this.fieldSet3,
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
          this.id,
          this.co_solicitud,
          this.co_tipo_solicitud,
          this.tabuladores
        ]
      });
      if (this.OBJ.id) {
        PresupuestomodificacionEditar.main.gridPanel_origen.enable();
        PresupuestomodificacionEditar.main.gridPanel_destino.enable()
        this.nu_modificacion = new Ext.form.DisplayField({
          value: "<span style='color:black;font-size:15px;'><b>N° Credito: </b> " + this.OBJ.nu_modificacion + "</span>"
        });
      } else {
        this.nu_modificacion = new Ext.form.DisplayField({
          value: "<span style='color:black;font-size:15px;'><b>N° Credito: </b> Por Asignar</span>"
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

      this.mo_origen = new Ext.form.DisplayField({
        value: "<span style='color:black;font-size:12px;'><b>Debito: </b>" + paqueteComunJS.funcion.getNumeroFormateado(0) + "</b></span>"
      });
      this.mo_destino = new Ext.form.DisplayField({
        value: "<span style='color:black;font-size:12px;'><b>Credito: </b>" + paqueteComunJS.funcion.getNumeroFormateado(0) + "</b></span>"
      });

      this.mo_modificacion = new Ext.form.DisplayField({
        value: "<span style='font-size:18px;'><b>Total Credito: </b>" + paqueteComunJS.funcion.getNumeroFormateado(0) + "</b></span>"
      });

      this.bbar_modificacion = new Ext.ux.StatusBar({
        autoScroll: true,
        defaults: {
          style: 'color:black;font-size:30px;',
          autoWidth: true
        },
        items: [
          this.mo_origen, '-',
          this.mo_destino, '-',
          //this.mo_modificacion
        ]
      });

      this.winformPanel_ = new Ext.Window({
        title: 'Formulario: Solicitud de Credito Adicional',
        modal: true,
        constrain: true,
        width: 811,
        frame: true,
        border: true,
        closabled: true,
        autoHeight: true,
        tbar: this.tbar_modificacion,
        bbar: this.bbar_modificacion,
        items: [
          this.formPanel_
        ],
        buttons: [
          this.crear,
          this.generar,
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
          {
            name: 'nu_ejecutor'
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
    getTotal: function() {

      this.monto_debito = 0;
      this.monto_debito = paqueteComunJS.funcion.getSumaColumnaGrid({
        store: PresupuestomodificacionEditar.main.store_lista,
        campo: 'mo_distribucion'
      });

      this.monto_credito = 0;
      this.monto_credito = paqueteComunJS.funcion.getSumaColumnaGrid({
        store: PresupuestomodificacionEditar.main.store_lista_destino,
        campo: 'mo_distribucion'
      });

      if (this.monto_debito > 0) {
        Ext.get('id_tb082_ejecutor_origen').setStyle('background-color', '#c9c9c9');
        PresupuestomodificacionEditar.main.id_tb082_ejecutor_origen.setReadOnly(true);
        //PresupuestomodificacionEditar.main.nuevo.disable();
        PresupuestomodificacionEditar.main.editar.disable();
        PresupuestomodificacionEditar.main.eliminar.disable();

      } else {
        Ext.get('id_tb082_ejecutor_origen').setStyle('background-color', '#FFFFFF');
        PresupuestomodificacionEditar.main.id_tb082_ejecutor_origen.setReadOnly(false);
        PresupuestomodificacionEditar.main.nuevo.enable();
        PresupuestomodificacionEditar.main.editar.disable();
        PresupuestomodificacionEditar.main.eliminar.disable();
      }

      /*if(this.monto_credito>0){
          Ext.get('id_tb082_ejecutor_destino').setStyle('background-color','#c9c9c9');
          PresupuestomodificacionEditar.main.id_tb082_ejecutor_destino.setReadOnly(true);

      }else{
          Ext.get('id_tb082_ejecutor_destino').setStyle('background-color','#FFFFFF');
          PresupuestomodificacionEditar.main.id_tb082_ejecutor_destino.setReadOnly(false);
      }   */

      PresupuestomodificacionEditar.main.mo_origen.setValue("<span style='color:black;font-size:12px;'><b>Debito: </b>" + paqueteComunJS.funcion.getNumeroFormateado(this.monto_debito) + "</b></span>");
      PresupuestomodificacionEditar.main.mo_destino.setValue("<span style='color:black;font-size:12px;'><b>Credito: </b>" + paqueteComunJS.funcion.getNumeroFormateado(this.monto_credito) + "</b></span>");

    },
    getStoreCO_NUMERO_FUENTE: function() {
      this.store = new Ext.data.JsonStore({
        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/storefkidtb068numerofuentefinanciamiento',
        root: 'data',
        fields: [{
            name: 'co_numero_fuente'
          },
          {
            name: 'id_tb073_fuente_financiamiento'
          },
          {
            name: 'tx_numero_fuente'
          }
        ]
      });
      return this.store;
    },
    getStoreID_TIPO_CREDITO: function() {
      this.store = new Ext.data.JsonStore({
        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/storefkidtb152tipocredito',
        root: 'data',
        fields: [{
            name: 'id'
          },
          {
            name: 'de_tipo_credito'
          }
        ]
      });
      return this.store;
    },
    getStoreID_TB073_FUENTE_FINANCIAMIENTO: function() {
      this.store = new Ext.data.JsonStore({
        url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/storefkcofuentefinanciamiento',
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
    }
  };
  Ext.onReady(PresupuestomodificacionEditar.main.init, PresupuestomodificacionEditar.main);
</script>
<div id="formularioModificaciondetalle"></div>