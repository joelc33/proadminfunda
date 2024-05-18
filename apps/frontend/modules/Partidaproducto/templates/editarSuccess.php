<script type="text/javascript">
Ext.ns("PartidaproductoEditar");
PartidaproductoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<Stores de fk>
this.storeID_PRODUCTO = this.getStoreID_PRODUCTO();
//<Stores de fk>
//<Stores de fk>
this.storeID_PARTIDA = this.getStoreID_PARTIDA();
//<Stores de fk>
//<Stores de fk>
this.store_lista = this.getStoreCO_PRODUCTO();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>

this.nu_partida = new Ext.form.ComboBox({
	fieldLabel:'Partida',
	store: this.storeID_PARTIDA,
	typeAhead: true,
	valueField: 'nu_partida',
	displayField:'partida',
	hiddenName:'tb094_partida_producto[nu_partida]',
	//readOnly:(this.OBJ.id_tb092_clase_producto!='')?true:false,
	//style:(this.main.OBJ.id_tb092_clase_producto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Partida',
	selectOnFocus: true,
	mode: 'local',
	width:800,
	resizable:true,
	allowBlank:false
});
this.storeID_PARTIDA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.nu_partida,
	value:  this.OBJ.nu_partida,
	objStore: this.storeID_PARTIDA
});

this.id_tb092_clase_producto = new Ext.form.ComboBox({
	fieldLabel:'Clase Producto',
	store: this.storeID_PRODUCTO,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_clase_producto',
	hiddenName:'tb094_partida_producto[id_tb092_clase_producto]',
	//readOnly:(this.OBJ.id_tb092_clase_producto!='')?true:false,
	//style:(this.main.OBJ.id_tb092_clase_producto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Clase Producto',
	selectOnFocus: true,
	mode: 'local',
	width:800,
	resizable:true,
	allowBlank:false,
  listeners:{
            select: function(){
                PartidaproductoEditar.main.store_lista.load({
                    params: {
                      co_clase:this.getValue()
                    }
                })
            }
        }
});
this.storeID_PRODUCTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb092_clase_producto,
	value:  this.OBJ.id_tb092_clase_producto,
	objStore: this.storeID_PRODUCTO
});

this.buscador = new Ext.form.TwinTriggerField({
	initComponent : function(){
		Ext.ux.form.SearchField.superclass.initComponent.call(this);
		this.on('specialkey', function(f, e){
			if(e.getKey() == e.ENTER){
				this.onTrigger2Click();
			}
		}, this);
	},
	xtype: 'twintriggerfield',
	trigger1Class: 'x-form-clear-trigger',
	trigger2Class: 'x-form-search-trigger',
	enableKeyEvents : true,
	validationEvent:false,
	validateOnBlur:false,
	emptyText: 'Campo de Filtro',
	width:350,
	hasSearch : false,
	paramName : 'variable',
	onTrigger1Click : function() {
		if (this.hiddenField) {
			this.hiddenField.value = '';
		}
		this.setRawValue('');
		this.lastSelectionText = '';
		this.applyEmptyText();
		this.value = '';
		this.fireEvent('clear', this);
		PartidaproductoEditar.main.store_lista.baseParams={};
		PartidaproductoEditar.main.store_lista.baseParams.paginar = 'si';
    PartidaproductoEditar.main.store_lista.baseParams.co_clase = PartidaproductoEditar.main.id_tb092_clase_producto.getValue();
		PartidaproductoEditar.main.store_lista.load();
	},
	onTrigger2Click : function(){
		var v = this.getRawValue();
		if(v.length < 1){
			    Ext.MessageBox.show({
				       title: 'Notificación',
				       msg: 'Debe ingresar un parametro de busqueda',
				       buttons: Ext.MessageBox.OK,
				       icon: Ext.MessageBox.WARNING
			    });
		}else{
			PartidaproductoEditar.main.store_lista.baseParams={};
			PartidaproductoEditar.main.store_lista.baseParams.BuscarBy = true;
			PartidaproductoEditar.main.store_lista.baseParams[this.paramName] = v;
			PartidaproductoEditar.main.store_lista.baseParams.paginar = 'si';
      PartidaproductoEditar.main.store_lista.baseParams.co_clase = PartidaproductoEditar.main.id_tb092_clase_producto.getValue();
			PartidaproductoEditar.main.store_lista.load();
		}
	}
});

this.texto = new Ext.Toolbar.TextItem(
  {
    text: 'Lista de Productos'
  }
);

this.gridPanel = new Ext.grid.GridPanel({
        //title:'Lista de Productos',
        //iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:250,
        width:905,
        border:true,
        tbar:[
            this.texto,'-',this.buscador
        ],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_producto', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_producto'},
            {header: 'Codigo',width:80, menuDisabled:true,dataIndex: 'cod_producto'},
            {header: 'Descripción',width:680, menuDisabled:true,dataIndex: 'tx_producto'}
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        bbar: new Ext.PagingToolbar({
            pageSize: 100,
            store: this.store_lista,
            displayInfo: true,
            displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
            emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
        })
});

if(this.OBJ.id_tb092_clase_producto){
  this.store_lista.load({
                    params: {
                      co_clase:this.OBJ.id_tb092_clase_producto
                    }
                });
}else{
  this.store_lista.load();
}

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PartidaproductoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PartidaproductoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidaproducto/guardar',
            waitMsg: 'Enviando datos, por favor espere..',
            waitTitle:'Enviando',
            failure: function(form, action) {
                Ext.MessageBox.alert('Error en transacción', action.result.msg);
            },
            success: function(form, action) {
                 if(action.result.success){
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
                 PartidaproductoLista.main.store_lista.load();
                 PartidaproductoEditar.main.winformPanel_.close();
             }
        });


    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PartidaproductoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:940,
    autoHeight:true,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
                    this.nu_partida,
                    this.id_tb092_clase_producto,
                    this.gridPanel
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Partida Producto',
    modal:true,
    constrain:true,
    width:954,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formPanel_
    ],
    buttons:[
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
PartidaproductoLista.main.mascara.hide();
},
getStoreID_PRODUCTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidaproducto/storefkidtb092claseproducto',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_clase_producto'}
            ]
    });
    return this.store;
},
getStoreID_PARTIDA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidaproducto/storefkidtb091partida',
        root:'data',
        fields:[
            {name: 'nu_partida'},{name: 'de_partida'},
            {
                name: 'partida',
                convert: function(v, r) {
                    return r.co_partida + ' - ' + r.de_partida;
                }
            }
            ]
    });
    return this.store;
},
getStoreCO_PRODUCTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidaproducto/storefkcoproducto',
        root:'data',
        fields:[
            {name: 'co_producto'},
            {name: 'cod_producto'},
            {name: 'tx_producto'}
            ]
    });
    return this.store;
}
};
Ext.onReady(PartidaproductoEditar.main.init, PartidaproductoEditar.main);
</script>
