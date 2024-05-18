<script type="text/javascript">
Ext.ns("ProgramaEditar");
ProgramaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_SECTOR = this.getStoreCO_SECTOR();
//<Stores de fk>

//<ClavePrimaria>
this.co_programa = new Ext.form.Hidden({
    name:'co_programa',
    value:this.OBJ.co_programa});

this.co_sector = new Ext.form.Hidden({
    name:'tb019_programa[co_sector]',
    value:this.OBJ.co_sector});

this.nu_programa = new Ext.form.TextField({
	fieldLabel:'Código',
	name:'tb019_programa[nu_programa]',
	value:this.OBJ.nu_programa,
	allowBlank:false,
	width:50
});

this.tx_denominacion = new Ext.form.TextField({
	fieldLabel:'Descripción',
	name:'tb019_programa[tx_denominacion]',
	value:this.OBJ.tx_denominacion,
	allowBlank:false,
	width:500
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ProgramaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ProgramaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Programa/guardar',
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
                 ProgramaLista.main.store_lista.load({
                    params:{
                        co_sector:ProgramaEditar.main.OBJ.co_sector
                    }
                 });
                 ProgramaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ProgramaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:700,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_programa,
                    this.co_sector,
                    this.nu_programa,
                    this.tx_denominacion,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Programa',
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
ProgramaLista.main.mascara.hide();
}
,getStoreCO_SECTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Programa/storefkcosector',
        root:'data',
        fields:[
            {name: 'co_sector'}
            ]
    });
    return this.store;
}
};
Ext.onReady(ProgramaEditar.main.init, ProgramaEditar.main);
</script>
