<script type="text/javascript">
Ext.ns("EmpleadoEditar");
EmpleadoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.storePARENTESCO = this.getParentesco();
this.storeSexo = this.getSexo();

//<ClavePrimaria>
this.co_empleado = new Ext.form.Hidden({
    name:'co_empleado',
    value:this.OBJ.co_empleado});


this.cedula_titular = new Ext.form.Hidden({
    name:'empleado[cedula_titular]',
    value:this.OBJ.cedula_titular
});
//</ClavePrimaria>


this.cedula = new Ext.form.TextField({
	fieldLabel:'Cédula',
	name:'empleado[cedula]',
	value:this.OBJ.cedula,
	allowBlank:false,
	width:200
});

this.nombre_apellido = new Ext.form.TextField({
	fieldLabel:'Nombre y Apellido',
	name:'empleado[nombre_apellido]',
	value:this.OBJ.nombre_apellido,
	allowBlank:false,
	width:200
});

this.nacionalidad = new Ext.form.TextField({
	fieldLabel:'Nacionalidad',
	name:'empleado[nacionalidad]',
	value:this.OBJ.nacionalidad,
	allowBlank:false,
	width:200
});

this.parentesco = new Ext.form.TextField({
	fieldLabel:'Parentesco',
	name:'empleado[parentesco]',
	value:this.OBJ.parentesco,
	allowBlank:false,
	width:200
});

//this.cedula = new Ext.form.TextField({
//	fieldLabel:'Cedula',
//	name:'empleado[cedula]',
//	value:this.OBJ.cedula,
//	allowBlank:false,
//	width:200
//});

this.fe_nacimiento = new Ext.form.DateField({
	fieldLabel:'Fecha Nacimiento',
	name:'empleado[fe_nacimiento]',
	value:this.OBJ.fe_nacimiento,
	allowBlank:false,
	width:100
});


this.sexo = new Ext.form.TextField({
	fieldLabel:'Sexo',
	name:'empleado[sexo]',
	value:this.OBJ.sexo,
	allowBlank:false,
	width:200
});

this.sexo = new Ext.form.ComboBox({
	fieldLabel:'Sexo',
	store: this.storeSexo,
	typeAhead: true,
	valueField: 'sexo',
	displayField:'sexo',
	hiddenName:'empleado[sexo]',
        value:this.OBJ.sexo,
	//readOnly:(this.OBJ.co_documento!='')?true:false,
	//style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'...',
	selectOnFocus: true,
	mode: 'local',
	width:100,
	resizable:true,
	allowBlank:false
});

this.storeSexo.load();


this.parentesco = new Ext.form.ComboBox({
	fieldLabel:'Paentesco',
	store: this.storePARENTESCO,
	typeAhead: true,
	valueField: 'parentesco',
	displayField:'parentesco',
	hiddenName:'empleado[parentesco]',
        value:this.OBJ.parentesco,
	//readOnly:(this.OBJ.co_proceso!='')?true:false,
	//style:(this.main.OBJ.co_proceso!='')?'background:#c9c9c9;':'',
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
this.storePARENTESCO.load();

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!EmpleadoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        EmpleadoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empleado/guardar',
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
                 BeneficiarioLista.main.store_lista.load();
                 EmpleadoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        EmpleadoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.cedula_titular,
                    this.cedula,
                    this.nombre_apellido,
                    this.nacionalidad,
                    this.fe_nacimiento,
                    this.sexo,
                    this.parentesco,
                    this.co_empleado,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Beneficiario',
    modal:true,
    constrain:true,
width:600,
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
EmpleadoLista.main.mascara.hide();
},getSexo: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empleado/storelistaSexo',
    root:'data',
    fields:[
            {name: 'sexo'}
           ]
    });
    return this.store;
},getParentesco: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empleado/storelistaParentesco',
    root:'data',
    fields:[
            {name: 'parentesco'}
           ]
    });
    return this.store;
}
};
Ext.onReady(EmpleadoEditar.main.init, EmpleadoEditar.main);
</script>
