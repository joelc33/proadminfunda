<script type="text/javascript">
Ext.ns("ModeloEditar");
ModeloEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.storeID = this.getStoreID();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'co_modelo',
    value:this.OBJ.co_modelo});
//</ClavePrimaria>

this.tx_modelo = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tb175_modelo[tx_modelo]',
	value:this.OBJ.tx_modelo,
	allowBlank:false,
	width:400
});
this.list_marca = new Ext.form.ComboBox({
    fieldLabel:'Marcas',
    store: this.storeID,
    typeAhead: true,
    valueField: 'co_marca',
    displayField:'tx_marca',
    hiddenName:'tb174_marca[co_marca]',
    //readOnly:(this.OBJ.id_tb093_familia_producto!='')?true:false,
    //style:(this.main.OBJ.id_tb093_familia_producto!='')?'background:#c9c9c9;':'',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Marca',
    selectOnFocus: true,
    mode: 'local',
    width:400,
    resizable:true,
    allowBlank:false
});
this.storeID.load();
    paqueteComunJS.funcion.seleccionarComboByCo({
    objCMB: this.list_marca,
    value:  this.OBJ.co_marca,
    objStore: this.storeID
});
this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ModeloEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ModeloEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modelo/guardar',
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
                 ModeloLista.main.store_lista.load();
                 ModeloEditar.main.winformPanel_.close();
             }
        });


    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ModeloEditar.main.winformPanel_.close();
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
                    this.list_marca,
                    this.tx_modelo,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Marca',
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
ModeloLista.main.mascara.hide();
},getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Modelo/storefkcomarca',
        root:'data',
        fields:[
            {name: 'co_marca'},{name: 'tx_marca'}
            ]
    });
    return this.store;
}
};
Ext.onReady(ModeloEditar.main.init, ModeloEditar.main);
</script>
