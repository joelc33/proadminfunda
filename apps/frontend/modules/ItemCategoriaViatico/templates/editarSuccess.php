<script type="text/javascript">
Ext.ns("ItemCategoriaViaticoEditar");
ItemCategoriaViaticoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_CATEGORIA = this.getStoreCO_CATEGORIA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_ITEM_VIATICO = this.getStoreCO_ITEM_VIATICO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_TIPO_VIATICO = this.getStoreCO_TIPO_VIATICO();
//<Stores de fk>

//<ClavePrimaria>
this.co_categoria_item_viatico = new Ext.form.Hidden({
    name:'co_categoria_item_viatico',
    value:this.OBJ.co_categoria_item_viatico});
//</ClavePrimaria>


this.co_categoria = new Ext.form.ComboBox({
	fieldLabel:'Categoria',
	store: this.storeCO_CATEGORIA,
	typeAhead: true,
	valueField: 'co_categoria',
	displayField:'tx_categoria',
	hiddenName:'tb119_categoria_item_viatico[co_categoria]',
	//readOnly:(this.OBJ.co_categoria!='')?true:false,
	//style:(this.main.OBJ.co_categoria!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_categoria',
	selectOnFocus: true,
	mode: 'local',
	width:600,
	resizable:true,
	allowBlank:false
});
this.storeCO_CATEGORIA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_categoria,
	value:  this.OBJ.co_categoria,
	objStore: this.storeCO_CATEGORIA
});

this.co_tipo_viatico = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Viatico',
	store: this.storeCO_TIPO_VIATICO,
	typeAhead: true,
	valueField: 'co_tipo_viatico',
	displayField:'tx_tipo_viatico',
	hiddenName:'tb119_categoria_item_viatico[co_tipo_viatico]',
	//readOnly:(this.OBJ.co_tipo_viatico!='')?true:false,
	//style:(this.main.OBJ.co_tipo_viatico!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_tipo_viatico',
	selectOnFocus: true,
	mode: 'local',
	width:600,
	resizable:true,
	allowBlank:false,
	listeners:{
            select: function(){
                ItemCategoriaViaticoEditar.main.storeCO_ITEM_VIATICO.load({
                    params: {co_tipo_viatico:this.getValue()},
                    callback: function(){
                        ItemCategoriaViaticoEditar.main.co_item_viatico.setValue('');
                    }
                });
            }
        }
});
this.storeCO_TIPO_VIATICO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tipo_viatico,
	value:  this.OBJ.co_tipo_viatico,
	objStore: this.storeCO_TIPO_VIATICO
});

this.co_item_viatico = new Ext.form.ComboBox({
	fieldLabel:'Viatico',
	store: this.storeCO_ITEM_VIATICO,
	typeAhead: true,
	valueField: 'co_item_viatico',
	displayField:'tx_item_viatico',
	hiddenName:'tb119_categoria_item_viatico[co_item_viatico]',
	//readOnly:(this.OBJ.co_item_viatico!='')?true:false,
	//style:(this.main.OBJ.co_item_viatico!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_item_viatico',
	selectOnFocus: true,
	mode: 'local',
	width:600,
	resizable:true,
	allowBlank:false
});
//this.storeCO_ITEM_VIATICO.load();
//	paqueteComunJS.funcion.seleccionarComboByCo({
//	objCMB: this.co_item_viatico,
//	value:  this.OBJ.co_item_viatico,
//	objStore: this.storeCO_ITEM_VIATICO
//});

this.cant_ut = new Ext.form.NumberField({
	fieldLabel:'Cant UT',
	name:'tb119_categoria_item_viatico[cant_ut]',
	value:this.OBJ.cant_ut,
        width:100,
	allowBlank:false
});



this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ItemCategoriaViaticoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ItemCategoriaViaticoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ItemCategoriaViatico/guardar',
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
                 ItemCategoriaViaticoLista.main.store_lista.load();
                 ItemCategoriaViaticoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ItemCategoriaViaticoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:800,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
            this.co_categoria_item_viatico,
            this.co_categoria,
            this.co_tipo_viatico,
            this.co_item_viatico,
            this.cant_ut
          ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: ItemCategoriaViatico',
    modal:true,
    constrain:true,
    width:800,
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
ItemCategoriaViaticoLista.main.mascara.hide();
}
,getStoreCO_CATEGORIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ItemCategoriaViatico/storefkcocategoria',
        root:'data',
        fields:[
            {name: 'co_categoria'},
            {name: 'tx_categoria'}
            ]
    });
    return this.store;
}
,getStoreCO_ITEM_VIATICO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ItemCategoriaViatico/storefkcoitemviatico',
        root:'data',
        fields:[
            {name: 'co_item_viatico'},
            {name: 'tx_item_viatico'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_VIATICO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ItemCategoriaViatico/storefkcotipoviatico',
        root:'data',
        fields:[
            {name: 'co_tipo_viatico'},
            {name: 'tx_tipo_viatico'}
            ]
    });
    return this.store;
}
};
Ext.onReady(ItemCategoriaViaticoEditar.main.init, ItemCategoriaViaticoEditar.main);
</script>
