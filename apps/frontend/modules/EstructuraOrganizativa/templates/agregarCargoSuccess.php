<script type="text/javascript">
Ext.ns("AgregarCargo");
AgregarCargo.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.storeCO_CARGO = this.getStoreCO_CARGO();
//<ClavePrimaria>
this.co_estructura_administrativa = new Ext.form.Hidden({
    name:'co_estructura_administrativa',
    value:this.OBJ.co_estructura_administrativa});
//</ClavePrimaria>

this.co_padre = new Ext.form.Hidden({
    name:'co_padre',
    value:this.OBJ.co_cargo_estructura});

this.co_cargo = new Ext.form.ComboBox({
	fieldLabel:'Cargo',
	store: this.storeCO_CARGO,
	typeAhead: true,
	valueField: 'co_cargo',
	displayField:'tx_cargo',
	hiddenName:'co_cargo',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione cargo',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	allowBlank:false
});
this.storeCO_CARGO.load();

this.nivel = new Ext.form.NumberField({
	fieldLabel:'Nivel',
	name:'nu_nivel',
	value:this.OBJ.nivel,
        width:30,
        readOnly:true,
	style:'background:#c9c9c9;',
	allowBlank:false
});

this.cantidad = new Ext.form.NumberField({
	fieldLabel:'Cantidad',
	name:'cantidad',
        width:30,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!AgregarCargo.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        AgregarCargo.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/guardarCargo',
            waitMsg: 'Enviando datos, por favor espere..',
            waitTitle:'Enviando',
            failure: function(form, action) {
                Ext.MessageBox.alert('Error en transacción', action.result.msg);
            },
            success: function(form, action) {
                 if(action.result.success){
                     Ext.utiles.msg('Mensaje', action.result.msg);
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
                 <?php echo $paquete ?>.main.store_lista.load();
                 AgregarCargo.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
    handler:function(){
        AgregarCargo.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:700,
    autoHeight:true,  
    autoScroll:true,
   // bodyStyle:'padding:10px;',
    items:[         this.co_estructura_administrativa,
                    this.co_padre,
                    this.co_cargo,
                    this.nivel,
                    this.cantidad
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Nuevo Cargo '+AgregarCargo.main.OBJ.tx_estructura_administrativa,
    modal:true,
    constrain:true,
    width:700,
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
,getStoreCO_CARGO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/storefkcocargo',
        root:'data',
        fields:[
            {name: 'co_cargo'},
            {name: 'tx_cargo'}
            ]
    });
    return this.store;
}
};
Ext.onReady(AgregarCargo.main.init, AgregarCargo.main);
</script>
