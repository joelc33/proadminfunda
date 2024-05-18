<script type="text/javascript">
Ext.ns("agregarRamo");
agregarRamo.main = {
init:function(){

//<Stores de fk>
this.storeCO_RAMO = this.getStoreCO_RAMO();

this.list_ramo = paqueteComunJS.funcion.getJsonByObjStore({
                store:ProveedorEditar.main.gridPanel.getStore()
            });

this.co_ramo = new Ext.form.ComboBox({
	fieldLabel:'Ramo',
	store: this.storeCO_RAMO,
	typeAhead: true,
	valueField: 'co_ramo',
	displayField:'tx_ramo',
	hiddenName:'co_ramo',
	//readOnly:(this.OBJ.co_banco!='')?true:false,
	//style:(this.main.OBJ.co_banco!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false
});
this.storeCO_RAMO.load({
    params:{
        lista_ramo: agregarRamo.main.list_ramo
    }
});


this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

    if (agregarRamo.main.formPanel_.form.isValid()) {
                        
                var e = new ProveedorEditar.main.RegistroRamo({                     
                    co_ramo: agregarRamo.main.co_ramo.getValue(),
                    tx_ramo: agregarRamo.main.co_ramo.lastSelectionText
                });

               var cant = ProveedorEditar.main.store_lista.getCount();
               (cant == 0) ? 0 : ProveedorEditar.main.store_lista.getCount() + 1;
               ProveedorEditar.main.store_lista.insert(cant, e);
              
                ProveedorEditar.main.gridPanel.getView().refresh();
                agregarRamo.main.winformPanel_.close();

        }
        else {
            Ext.Msg.show({
                title: 'Mensaje',
                msg: 'Debe llenar los campos requeridos',
                buttons: Ext.Msg.OK,
                animEl: document.body,
                icon: Ext.MessageBox.INFO
            });
        }

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        agregarRamo.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:500,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.co_ramo]
});

this.winformPanel_ = new Ext.Window({
    title:'Listado de Ramos',
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
,getStoreCO_RAMO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storefkcoramo',
        root:'data',
        fields:[
            {name: 'co_ramo'},
            {name: 'tx_ramo'}
            ]
    });
    return this.store;
}
};
Ext.onReady(agregarRamo.main.init, agregarRamo.main);
</script>
