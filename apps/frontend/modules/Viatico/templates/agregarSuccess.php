<script type="text/javascript">
Ext.ns("AgregarViatico");
AgregarViatico.main = {
init:function(){

this.storeCO_ITEM_VIATICO = this.getStoreCO_ITEM_VIATICO();

var list = paqueteComunJS.funcion.getJsonByObjStore({
                store:ViaticoEditar.main.gridPanel.getStore()
});

AgregarViatico.main.storeCO_ITEM_VIATICO.load({
    params:{
        lista: list
    }
})

this.co_item_viatico = new Ext.form.ComboBox({
	fieldLabel:'Tipo',
	store: this.storeCO_ITEM_VIATICO,
	typeAhead: true,
	valueField: 'co_item_viatico',
	displayField:'tx_item_viatico',
	hiddenName:'co_item_viatico',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false
});
//this.storeCO_ITEM_VIATICO.load();

this.tx_observacion = new Ext.form.TextArea({
	fieldLabel:'Observación',
	name:'tx_obervacion',
	width:300
});

this.guardar = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!AgregarViatico.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }  
       
        var e = new ViaticoEditar.main.Registro({                     
                    co_item_viatico:AgregarViatico.main.co_item_viatico.getValue(),
                    tx_item_viatico:AgregarViatico.main.co_item_viatico.lastSelectionText,
                    tx_observacion:AgregarViatico.main.tx_observacion.getValue()
        });

        var cant = ViaticoEditar.main.store_lista.getCount();
       
        (cant == 0) ? 0 : ViaticoEditar.main.store_lista.getCount() + 1;
        ViaticoEditar.main.store_lista.insert(cant, e);

        ViaticoEditar.main.gridPanel.getView().refresh();
        
        Ext.utiles.msg('Mensaje', "El item seleccionado se agregó exitosamente");
        
        
        list = paqueteComunJS.funcion.getJsonByObjStore({
                store:ViaticoEditar.main.gridPanel.getStore()
        });
        
        AgregarViatico.main.storeCO_ITEM_VIATICO.load({
            params:{
                lista: list
            }
        })
        
        
        AgregarViatico.main.co_item_viatico.setValue("");
        AgregarViatico.main.tx_observacion.setValue("");
        

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        AgregarViatico.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:500,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.co_item_viatico,
           this.tx_observacion]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar',
    modal:true,
    constrain:true,
    width:500,
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
}
,getStoreCO_ITEM_VIATICO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/storefkcoitemviatico',
        root:'data',
        fields:[
            {name: 'co_item_viatico'},
            {name: 'tx_item_viatico'}
            ]
    });
    return this.store;
}
};
Ext.onReady(AgregarViatico.main.init, AgregarViatico.main);
</script>
