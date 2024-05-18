<script type="text/javascript">
Ext.ns("ConfigAplicacionEditar");
ConfigAplicacionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_aplicacion = new Ext.form.Hidden({
    name:'co_aplicacion',
    value:this.OBJ.co_aplicacion});
//</ClavePrimaria>


this.nu_anio_fiscal = new Ext.form.NumberField({
	fieldLabel:'Año Fiscal',
	name:'tb139_aplicacion[nu_anio_fiscal]',
	value:this.OBJ.nu_anio_fiscal,
	allowBlank:false,
	width:100
});

this.tx_tip_aplicacion = new Ext.form.TextField({
	fieldLabel:'N° Aplicacion',
	name:'tb139_aplicacion[tx_tip_aplicacion]',
	value:this.OBJ.tx_tip_aplicacion,
	allowBlank:false,
	width:200
});

this.tx_aplicacion = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tb139_aplicacion[tx_aplicacion]',
	value:this.OBJ.tx_aplicacion,
	allowBlank:false,
	width:500
});

this.tx_genera_cheque = new Ext.form.TextField({
	fieldLabel:'Genera Cheque',
	name:'tb139_aplicacion[tx_genera_cheque]',
	value:this.OBJ.tx_genera_cheque,
	allowBlank:false,
	width:200
});

this.tx_tip_gasto = new Ext.form.TextField({
	fieldLabel:'Tipo Gasto',
	name:'tb139_aplicacion[tx_tip_gasto]',
	value:this.OBJ.tx_tip_gasto,
	allowBlank:false,
	width:200
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConfigAplicacionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfigAplicacionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigAplicacion/guardar',
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
                 ConfigAplicacionLista.main.store_lista.load();
                 ConfigAplicacionEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigAplicacionEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:650,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_aplicacion,
                    this.nu_anio_fiscal,
                    this.tx_tip_aplicacion,
                    this.tx_aplicacion,
                    this.tx_genera_cheque,
                    this.tx_tip_gasto,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Aplicacion',
    modal:true,
    constrain:true,
width:664,
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
ConfigAplicacionLista.main.mascara.hide();
}
};
Ext.onReady(ConfigAplicacionEditar.main.init, ConfigAplicacionEditar.main);
</script>
