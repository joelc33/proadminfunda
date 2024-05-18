<script type="text/javascript">
Ext.ns("ConfigSalarioMinimoEditar");
ConfigSalarioMinimoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.mo_salario_minimo = new Ext.form.NumberField({
	fieldLabel:'Salario',
	name:'tbrh096_salario_minimo[mo_salario_minimo]',
	value:this.OBJ.mo_salario_minimo,
	allowBlank:false,
	width:200
});

this.fe_ini = new Ext.form.DateField({
	fieldLabel:'Fecha Inicio',
	name:'tbrh096_salario_minimo[fe_ini]',
	value:this.OBJ.fe_ini,
	allowBlank:false,
	width:100
});

this.fe_fin = new Ext.form.DateField({
	fieldLabel:'Fecha Cierre',
	name:'tbrh096_salario_minimo[fe_fin]',
	value:this.OBJ.fe_fin,
	//allowBlank:false,
	width:100
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConfigSalarioMinimoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfigSalarioMinimoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigSalarioMinimo/guardar',
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
                 ConfigSalarioMinimoLista.main.store_lista.load();
                 ConfigSalarioMinimoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigSalarioMinimoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
                    this.mo_salario_minimo,
                    this.fe_ini,
                    this.fe_fin,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Config Salario Minimo',
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
ConfigSalarioMinimoLista.main.mascara.hide();
}
};
Ext.onReady(ConfigSalarioMinimoEditar.main.init, ConfigSalarioMinimoEditar.main);
</script>
