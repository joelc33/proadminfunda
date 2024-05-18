<script type="text/javascript">
Ext.ns("ClaseproductoEditar");
ClaseproductoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.de_clase_producto = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tb092_clase_producto[de_clase_producto]',
	value:this.OBJ.de_clase_producto,
	allowBlank:false,
	width:400
});

this.id_tb093_familia_producto = new Ext.form.ComboBox({
	fieldLabel:'Familia Producto',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_familia_producto',
	hiddenName:'tb092_clase_producto[id_tb093_familia_producto]',
	//readOnly:(this.OBJ.id_tb093_familia_producto!='')?true:false,
	//style:(this.main.OBJ.id_tb093_familia_producto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Familia Producto',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb093_familia_producto,
	value:  this.OBJ.id_tb093_familia_producto,
	objStore: this.storeID
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ClaseproductoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ClaseproductoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Claseproducto/guardar',
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
                 ClaseproductoLista.main.store_lista.load();
                 ClaseproductoEditar.main.winformPanel_.close();
             }
        });


    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ClaseproductoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
autoHeight:true,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
                  //  this.id_tb093_familia_producto,
                    this.de_clase_producto,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Clase Producto',
    modal:true,
    constrain:true,
width:614,
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
ClaseproductoLista.main.mascara.hide();
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Claseproducto/storefkidtb093familiaproducto',
        root:'data',
        fields:[
            {name: 'id'},{name: 'de_familia_producto'}
            ]
    });
    return this.store;
}
};
Ext.onReady(ClaseproductoEditar.main.init, ClaseproductoEditar.main);
</script>
