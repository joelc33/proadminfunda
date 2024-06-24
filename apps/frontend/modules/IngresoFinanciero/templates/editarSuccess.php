<script type="text/javascript">
	Ext.ns("IngresoFinancieroEditar");
	IngresoFinancieroEditar.main = {
		init: function() {

			this.OBJ = paqueteComunJS.funcion.doJSON({
				stringData: '<?php echo $data ?>'
			});
			//<Stores de fk>
			this.storeCO_CUENTA_BANCARIA = this.getStoreCO_CUENTA_BANCARIA();
			//<Stores de fk>
			//<Stores de fk>
			this.storeCO_BANCO = this.getStoreCO_BANCO();
			//<Stores de fk>
			//<Stores de fk>
			this.storeID_TIPOCUENTAMOVIMIENTO = this.getStoreID_TIPOCUENTAMOVIMIENTO();
			//<Stores de fk>
			//<Stores de fk>
			this.storeID_TIPODOCUMENTOCUENTA = this.getStoreID_TIPODOCUMENTOCUENTA();
			//<Stores de fk>
			//<Stores de fk>
			this.storeID_SUBTIPODOCUMENTO = this.getStoreID_SUBTIPODOCUMENTO();
			//<Stores de fk>

			//<ClavePrimaria>
			this.id = new Ext.form.Hidden({
				name: 'id',
				value: this.OBJ.id
			});
			//</ClavePrimaria>
			//<ClavePrimaria>
			this.co_solicitud = new Ext.form.Hidden({
				name: 'tb155_cuenta_bancaria_historico[co_solicitud]',
				value: this.OBJ.co_solicitud
			});
			//</ClavePrimaria>

			this.in_activo = new Ext.form.Checkbox({
				fieldLabel: 'In activo',
				name: 'tb155_cuenta_bancaria_historico[in_activo]',
				checked: (this.OBJ.in_activo == '0') ? true : false,
				allowBlank: false
			});

			this.created_at = new Ext.form.DateField({
				fieldLabel: 'Created at',
				name: 'tb155_cuenta_bancaria_historico[created_at]',
				value: this.OBJ.created_at,
				allowBlank: false
			});

			this.updated_at = new Ext.form.DateField({
				fieldLabel: 'Updated at',
				name: 'tb155_cuenta_bancaria_historico[updated_at]',
				value: this.OBJ.updated_at,
				allowBlank: false
			});

			this.id_tb010_banco = new Ext.form.ComboBox({
				fieldLabel: 'Banco',
				store: this.storeCO_BANCO,
				typeAhead: true,
				valueField: 'co_banco',
				displayField: 'tx_banco',
				hiddenName: 'tb155_cuenta_bancaria_historico[id_tb010_banco]',
				//readOnly:(this.OBJ.id_tb010_banco!='')?true:false,
				//style:(this.main.OBJ.id_tb010_banco!='')?'background:#c9c9c9;':'',
				forceSelection: true,
				resizable: true,
				triggerAction: 'all',
				emptyText: 'Seleccione Banco...',
				selectOnFocus: true,
				mode: 'local',
				width: 500,
				resizable: true,
				allowBlank: false,
				listeners: {
					select: function() {
						IngresoFinancieroEditar.main.id_tb011_cuenta_bancaria.clearValue();
						IngresoFinancieroEditar.main.storeCO_CUENTA_BANCARIA.load({
							params: {
								banco: this.getValue()
							}
						})
					}
				}
			});
			this.storeCO_BANCO.load();
			paqueteComunJS.funcion.seleccionarComboByCo({
				objCMB: this.id_tb010_banco,
				value: this.OBJ.id_tb010_banco,
				objStore: this.storeCO_BANCO
			});

			this.id_tb011_cuenta_bancaria = new Ext.form.ComboBox({
				fieldLabel: 'Cuenta Bancaria',
				store: this.storeCO_CUENTA_BANCARIA,
				typeAhead: true,
				valueField: 'co_cuenta_bancaria',
				displayField: 'cuenta',
				hiddenName: 'tb155_cuenta_bancaria_historico[id_tb011_cuenta_bancaria]',
				//readOnly:(this.OBJ.id_tb011_cuenta_bancaria!='')?true:false,
				//style:(this.main.OBJ.id_tb011_cuenta_bancaria!='')?'background:#c9c9c9;':'',
				forceSelection: true,
				resizable: true,
				triggerAction: 'all',
				emptyText: 'Seleccione Cuenta Bancaria...',
				selectOnFocus: true,
				mode: 'local',
				width: 500,
				resizable: true,
				allowBlank: false,
				listeners: {
					select: function() {
						IngresoFinancieroEditar.main.cargarDisponible(this.getValue());
					}
				}
			});
			/*
			this.storeCO_CUENTA_BANCARIA.load();
				paqueteComunJS.funcion.seleccionarComboByCo({
				objCMB: this.id_tb011_cuenta_bancaria,
				value:  this.OBJ.id_tb011_cuenta_bancaria,
				objStore: this.storeCO_CUENTA_BANCARIA
			});*/

			if (this.OBJ.id_tb011_cuenta_bancaria) {
				IngresoFinancieroEditar.main.cargarDisponible(this.OBJ.id_tb011_cuenta_bancaria);
			}

			if (this.OBJ.id_tb010_banco) {
				this.storeCO_CUENTA_BANCARIA.load({
					params: {
						banco: this.OBJ.id_tb010_banco
					},
					callback: function() {
						IngresoFinancieroEditar.main.id_tb011_cuenta_bancaria.setValue(IngresoFinancieroEditar.main.OBJ.id_tb011_cuenta_bancaria);
					}
				});

			}

			this.mo_saldo_cuenta = new Ext.form.TextField({
				fieldLabel: 'Saldo en Cuenta',
				name: 'mo_saldo',
				value: this.OBJ.mo_saldo_cuenta,
				readOnly: true,
				style: 'background:#c9c9c9;',
				allowBlank: false,
				width: 200
			});

			this.mo_transaccion = new Ext.form.NumberField({
				fieldLabel: 'Monto',
				name: 'tb155_cuenta_bancaria_historico[mo_transaccion]',
				value: this.OBJ.mo_transaccion,
				allowBlank: false,
				width: 200
			});

			this.fe_transaccion = new Ext.form.DateField({
				fieldLabel: 'Fecha',
				name: 'tb155_cuenta_bancaria_historico[fe_transaccion]',
				value: this.OBJ.fe_transaccion,
				allowBlank: false,
				minValue: this.OBJ.fe_desde,
				maxValue: this.OBJ.fe_hasta,
				width: 100
			});

			this.de_observacion = new Ext.form.TextArea({
				fieldLabel: 'Observacion',
				name: 'tb155_cuenta_bancaria_historico[de_observacion]',
				value: this.OBJ.de_observacion,
				allowBlank: false,
				width: 500
			});

			this.id_tb154_tipo_cuenta_movimiento = new Ext.form.ComboBox({
				fieldLabel: 'Tipo Movimiento',
				store: this.storeID_TIPOCUENTAMOVIMIENTO,
				typeAhead: true,
				valueField: 'id',
				displayField: 'descripcion',
				hiddenName: 'tb155_cuenta_bancaria_historico[id_tb154_tipo_cuenta_movimiento]',
				//readOnly:(this.OBJ.id_tb154_tipo_cuenta_movimiento!='')?true:false,
				//style:(this.main.OBJ.id_tb154_tipo_cuenta_movimiento!='')?'background:#c9c9c9;':'',
				forceSelection: true,
				resizable: true,
				triggerAction: 'all',
				emptyText: 'Seleccione Tipo Movimiento',
				selectOnFocus: true,
				mode: 'local',
				width: 500,
				resizable: true,
				allowBlank: false,
				listeners: {
					select: function() {
						IngresoFinancieroEditar.main.id_tb156_subtipo_documento.clearValue();
						IngresoFinancieroEditar.main.storeID_SUBTIPODOCUMENTO.load({
							params: {
								tipo: this.getValue()
							}
						})

						IngresoFinancieroEditar.main.storeID_TIPODOCUMENTOCUENTA.load({
							params: {
								id: this.getValue()
							}
						})



					}
				}
			});
			this.storeID_TIPOCUENTAMOVIMIENTO.load();
			paqueteComunJS.funcion.seleccionarComboByCo({
				objCMB: this.id_tb154_tipo_cuenta_movimiento,
				value: this.OBJ.id_tb154_tipo_cuenta_movimiento,
				objStore: this.storeID_TIPOCUENTAMOVIMIENTO
			});

			this.id_tb153_tipo_documento_cuenta = new Ext.form.ComboBox({
				fieldLabel: 'Tipo Documento',
				store: this.storeID_TIPODOCUMENTOCUENTA,
				typeAhead: true,
				valueField: 'id',
				displayField: 'descripcion',
				hiddenName: 'tb155_cuenta_bancaria_historico[id_tb153_tipo_documento_cuenta]',
				//readOnly:(this.OBJ.id_tb153_tipo_documento_cuenta!='')?true:false,
				//style:(this.main.OBJ.id_tb153_tipo_documento_cuenta!='')?'background:#c9c9c9;':'',
				forceSelection: true,
				resizable: true,
				triggerAction: 'all',
				emptyText: 'Seleccione Tipo Documento...',
				selectOnFocus: true,
				mode: 'local',
				width: 500,
				resizable: true,
				allowBlank: false
			});
			/*this.storeID_TIPODOCUMENTOCUENTA.load();
				paqueteComunJS.funcion.seleccionarComboByCo({
				objCMB: this.id_tb153_tipo_documento_cuenta,
				value:  this.OBJ.id_tb153_tipo_documento_cuenta,
				objStore: this.storeID_TIPODOCUMENTOCUENTA
			});*/

			this.id_tb156_subtipo_documento = new Ext.form.ComboBox({
				fieldLabel: 'Sub-Tipo Documento',
				store: this.storeID_SUBTIPODOCUMENTO,
				typeAhead: true,
				valueField: 'id',
				displayField: 'descripcion',
				hiddenName: 'tb155_cuenta_bancaria_historico[id_tb156_subtipo_documento]',
				//readOnly:(this.OBJ.id_tb156_subtipo_documento!='')?true:false,
				//style:(this.main.OBJ.id_tb156_subtipo_documento!='')?'background:#c9c9c9;':'',
				forceSelection: true,
				resizable: true,
				triggerAction: 'all',
				emptyText: 'Seleccione Sub-Tipo Documento...',
				selectOnFocus: true,
				mode: 'local',
				width: 500,
				resizable: true,
				allowBlank: false
			});
			/*
			this.storeID_SUBTIPODOCUMENTO.load();
			paqueteComunJS.funcion.seleccionarComboByCo({
				objCMB: this.id_tb156_subtipo_documento,
				value:  this.OBJ.id_tb156_subtipo_documento,
				objStore: this.storeID_SUBTIPODOCUMENTO
			});*/

			if (this.OBJ.id_tb154_tipo_cuenta_movimiento) {
				this.storeID_SUBTIPODOCUMENTO.load({
					params: {
						tipo: this.OBJ.id_tb154_tipo_cuenta_movimiento
					},
					callback: function() {
						IngresoFinancieroEditar.main.id_tb156_subtipo_documento.setValue(IngresoFinancieroEditar.main.OBJ.id_tb156_subtipo_documento);
					}
				});

				IngresoFinancieroEditar.main.storeID_TIPODOCUMENTOCUENTA.load({
					params: {
						id: this.OBJ.id_tb154_tipo_cuenta_movimiento
					},
					callback: function() {
						IngresoFinancieroEditar.main.id_tb153_tipo_documento_cuenta.setValue(IngresoFinancieroEditar.main.OBJ.id_tb153_tipo_documento_cuenta);
					}
				})

			}

			this.nu_transaccion = new Ext.form.TextField({
				fieldLabel: 'N° Transaccion',
				name: 'tb155_cuenta_bancaria_historico[nu_transaccion]',
				value: this.OBJ.nu_transaccion,
				allowBlank: false,
				width: 200
			});

			this.guardar = new Ext.Button({
				text: 'Guardar',
				iconCls: 'icon-guardar',
				handler: function() {

					if (!IngresoFinancieroEditar.main.formPanel_.getForm().isValid()) {
						Ext.Msg.alert("Alerta", "Debe ingresar los campos en rojo");
						return false;
					}
					IngresoFinancieroEditar.main.formPanel_.getForm().submit({
						method: 'POST',
						url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/guardar',
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

							IngresoFinancieroEditar.main.winformPanel_.close();
						}
					});


				}
			});

			this.salir = new Ext.Button({
				text: 'Salir',
				//    iconCls: 'icon-cancelar',
				handler: function() {
					IngresoFinancieroEditar.main.winformPanel_.close();
				}
			});

			this.formPanel_ = new Ext.form.FormPanel({
				frame: true,
				width: 700,
				autoHeight: true,
				labelWidth: 150,
				autoScroll: true,
				bodyStyle: 'padding:10px;',
				items: [

					this.id,
					this.co_solicitud,
					this.id_tb010_banco,
					this.id_tb011_cuenta_bancaria,
					this.mo_saldo_cuenta,
					this.fe_transaccion,
					this.nu_transaccion,
					this.mo_transaccion,
					this.id_tb154_tipo_cuenta_movimiento,
					this.id_tb153_tipo_documento_cuenta,
					this.id_tb156_subtipo_documento,
					this.de_observacion
				]
			});

			this.winformPanel_ = new Ext.Window({
				title: 'Formulario: Transcripcion de Movimientos',
				modal: true,
				constrain: true,
				width: 714, 
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
		getStoreCO_CUENTA_BANCARIA: function() {
			this.store = new Ext.data.JsonStore({
				url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/storefkidtb011cuentabancaria',
				root: 'data',
				fields: [{
						name: 'co_cuenta_bancaria'
					},
					{
						name: 'tx_cuenta_bancaria'
					},
					{
						name: 'tx_descripcion'
					},
					{
						name: 'cuenta',
						convert: function(v, r) {
							return r.tx_cuenta_bancaria + ' - ' + r.tx_descripcion;
						}
					}
				]
			});
			return this.store;
		},
		getStoreCO_BANCO: function() {
			this.store = new Ext.data.JsonStore({
				url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/storefkidtb010banco',
				root: 'data',
				fields: [{
						name: 'co_banco'
					},
					{
						name: 'tx_banco'
					}
				]
			});
			return this.store;
		},
		getStoreID_TIPOCUENTAMOVIMIENTO: function() {
			this.store = new Ext.data.JsonStore({
				url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/storefkidtb154tipocuentamovimiento',
				root: 'data',
				fields: [{
						name: 'id'
					},
					{
						name: 'de_tipo_cuenta_movimiento'
					},
					{
						name: 'nu_operacion'
					},
					{
						name: 'descripcion',
						convert: function(v, r) {
							return r.nu_operacion + ' - ' + r.de_tipo_cuenta_movimiento;
						}
					}
				]
			});
			return this.store;
		},
		getStoreID_TIPODOCUMENTOCUENTA: function() {
			this.store = new Ext.data.JsonStore({
				url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/storefkidtb153tipodocumentocuenta',
				root: 'data',
				fields: [{
						name: 'id'
					},
					{
						name: 'nu_tipo_documento_cuenta'
					},
					{
						name: 'de_tipo_documento_cuenta'
					},
					{
						name: 'descripcion',
						convert: function(v, r) {
							return r.nu_tipo_documento_cuenta + ' - ' + r.de_tipo_documento_cuenta;
						}
					}
				]
			});
			return this.store;
		},
		getStoreID_SUBTIPODOCUMENTO: function() {
			this.store = new Ext.data.JsonStore({
				url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/storefkidtb156subtipodocumento',
				root: 'data',
				fields: [{
						name: 'id'
					},
					{
						name: 'nu_subtipo_documento'
					},
					{
						name: 'de_subtipo_documento'
					},
					{
						name: 'descripcion',
						convert: function(v, r) {
							return r.nu_subtipo_documento + ' - ' + r.de_subtipo_documento;
						}
					}
				]
			});
			return this.store;
		},
		cargarDisponible: function(cuenta) {
			Ext.Ajax.request({
				method: 'GET',
				url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/cargarDisponible',
				params: {
					cuenta: cuenta
				},
				success: function(result, request) {
					obj = Ext.util.JSON.decode(result.responseText);
					IngresoFinancieroEditar.main.mo_saldo_cuenta.setValue(paqueteComunJS.funcion.getNumeroFormateado(obj.data.mo_disponible));
				}
			});
		}
	};
	Ext.onReady(IngresoFinancieroEditar.main.init, IngresoFinancieroEditar.main);
</script>