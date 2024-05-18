<script type="text/javascript">
Ext.ns("ProductoEditar");
ProductoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeID = this.getStoreID();

//<ClavePrimaria>
this.co_producto = new Ext.form.Hidden({
    name:'co_producto',
    value:this.OBJ.co_producto});
//</ClavePrimaria>


this.tx_producto = new Ext.form.TextField({
	fieldLabel:'Producto',
	name:'tb048_producto[tx_producto]',
	value:this.OBJ.tx_producto,
	allowBlank:false,
	width:600
});

this.cod_producto = new Ext.form.TextField({
	fieldLabel:'Cod Producto',
	name:'tb048_producto[cod_producto]',
	value:this.OBJ.cod_producto,
	allowBlank:false,
	width:200
});

this.co_clase = new Ext.form.ComboBox({
	fieldLabel:'Clase Producto',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_clase_producto',
	hiddenName:'tb048_producto[co_clase]',
	//readOnly:(this.OBJ.co_clase!='')?true:false,
	//style:(this.main.OBJ.co_clase!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:600,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_clase,
	value:  this.OBJ.co_clase,
	objStore: this.storeID
});



this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ProductoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ProductoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Producto/guardar',
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
                 ProductoLista.main.store_lista.load();
                 ProductoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ProductoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:800,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_producto,
                    this.cod_producto,
                    this.tx_producto,
                    this.co_clase
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Producto',
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
ProductoLista.main.mascara.hide();
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Producto/storefkcoclase',
        root:'data',
        fields:[
                    {name: 'id'},
                    {name: 'de_clase_producto'}
               ]
    });
    return this.store;
}
};
Ext.onReady(ProductoEditar.main.init, ProductoEditar.main);
</script>
