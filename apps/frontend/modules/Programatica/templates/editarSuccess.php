<script type="text/javascript">
Ext.ns("ProgramaticaEditar");
ProgramaticaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_sector = new Ext.form.Hidden({
    name:'co_sector',
    value:this.OBJ.co_sector});
//</ClavePrimaria>


this.nu_sector = new Ext.form.TextField({
	fieldLabel:'Nu sector',
	name:'tb018_sector[nu_sector]',
	value:this.OBJ.nu_sector,
	allowBlank:false,
	width:200
});

this.tx_denominacion = new Ext.form.TextField({
	fieldLabel:'Tx denominacion',
	name:'tb018_sector[tx_denominacion]',
	value:this.OBJ.tx_denominacion,
	allowBlank:false,
	width:200
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ProgramaticaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ProgramaticaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Programatica/guardar',
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
                 ProgramaticaLista.main.store_lista.load();
                 ProgramaticaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ProgramaticaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_sector,
                    this.nu_sector,
                    this.tx_denominacion,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Programatica',
    modal:true,
    constrain:true,
width:400,
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
ProgramaticaLista.main.mascara.hide();
}
};
Ext.onReady(ProgramaticaEditar.main.init, ProgramaticaEditar.main);
</script>
