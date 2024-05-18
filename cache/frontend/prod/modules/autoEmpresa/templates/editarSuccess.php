<script type="text/javascript">
Ext.ns("EmpresaEditar");
EmpresaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_ESTADO = this.getStoreCO_ESTADO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_MUNICIPIO = this.getStoreCO_MUNICIPIO();
//<Stores de fk>

//<ClavePrimaria>
this.co_empresa = new Ext.form.Hidden({
    name:'co_empresa',
    value:this.OBJ.co_empresa});
//</ClavePrimaria>


this.nb_empresa = new Ext.form.TextField({
	fieldLabel:'Nb empresa',
	name:'tb015_empresa[nb_empresa]',
	value:this.OBJ.nb_empresa,
	allowBlank:false,
	width:200
});

this.co_estado = new Ext.form.ComboBox({
	fieldLabel:'Co estado',
	store: this.storeCO_ESTADO,
	typeAhead: true,
	valueField: 'co_estado',
	displayField:'co_estado',
	hiddenName:'tb015_empresa[co_estado]',
	//readOnly:(this.OBJ.co_estado!='')?true:false,
	//style:(this.main.OBJ.co_estado!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_estado',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ESTADO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_estado,
	value:  this.OBJ.co_estado,
	objStore: this.storeCO_ESTADO
});

this.co_municipio = new Ext.form.ComboBox({
	fieldLabel:'Co municipio',
	store: this.storeCO_MUNICIPIO,
	typeAhead: true,
	valueField: 'co_municipio',
	displayField:'co_municipio',
	hiddenName:'tb015_empresa[co_municipio]',
	//readOnly:(this.OBJ.co_municipio!='')?true:false,
	//style:(this.main.OBJ.co_municipio!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_municipio',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_MUNICIPIO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_municipio,
	value:  this.OBJ.co_municipio,
	objStore: this.storeCO_MUNICIPIO
});

this.tx_rif = new Ext.form.TextField({
	fieldLabel:'Tx rif',
	name:'tb015_empresa[tx_rif]',
	value:this.OBJ.tx_rif,
	allowBlank:false,
	width:200
});

this.tx_nit = new Ext.form.TextField({
	fieldLabel:'Tx nit',
	name:'tb015_empresa[tx_nit]',
	value:this.OBJ.tx_nit,
	allowBlank:false,
	width:200
});

this.tx_direccion = new Ext.form.TextField({
	fieldLabel:'Tx direccion',
	name:'tb015_empresa[tx_direccion]',
	value:this.OBJ.tx_direccion,
	allowBlank:false,
	width:200
});

this.tx_imagen_der = new Ext.form.TextField({
	fieldLabel:'Tx imagen der',
	name:'tb015_empresa[tx_imagen_der]',
	value:this.OBJ.tx_imagen_der,
	allowBlank:false,
	width:200
});

this.tx_imagen_izq = new Ext.form.TextField({
	fieldLabel:'Tx imagen izq',
	name:'tb015_empresa[tx_imagen_izq]',
	value:this.OBJ.tx_imagen_izq,
	allowBlank:false,
	width:200
});

this.tx_imagen_cen = new Ext.form.TextField({
	fieldLabel:'Tx imagen cen',
	name:'tb015_empresa[tx_imagen_cen]',
	value:this.OBJ.tx_imagen_cen,
	allowBlank:false,
	width:200
});

this.nu_telefono = new Ext.form.TextField({
	fieldLabel:'Nu telefono',
	name:'tb015_empresa[nu_telefono]',
	value:this.OBJ.nu_telefono,
	allowBlank:false,
	width:200
});

this.tx_sigla = new Ext.form.TextField({
	fieldLabel:'Tx sigla',
	name:'tb015_empresa[tx_sigla]',
	value:this.OBJ.tx_sigla,
	allowBlank:false,
	width:200
});

this.op_imagen = new Ext.form.TextField({
	fieldLabel:'Op imagen',
	name:'tb015_empresa[op_imagen]',
	value:this.OBJ.op_imagen,
	allowBlank:false,
	width:200
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!EmpresaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        EmpresaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empresa/guardar',
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
                 EmpresaLista.main.store_lista.load();
                 EmpresaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        EmpresaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_empresa,
                    this.nb_empresa,
                    this.co_estado,
                    this.co_municipio,
                    this.tx_rif,
                    this.tx_nit,
                    this.tx_direccion,
                    this.tx_imagen_der,
                    this.tx_imagen_izq,
                    this.tx_imagen_cen,
                    this.nu_telefono,
                    this.tx_sigla,
                    this.op_imagen,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Empresa',
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
EmpresaLista.main.mascara.hide();
}
,getStoreCO_ESTADO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empresa/storefkcoestado',
        root:'data',
        fields:[
            {name: 'co_estado'}
            ]
    });
    return this.store;
}
,getStoreCO_MUNICIPIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empresa/storefkcomunicipio',
        root:'data',
        fields:[
            {name: 'co_municipio'}
            ]
    });
    return this.store;
}
};
Ext.onReady(EmpresaEditar.main.init, EmpresaEditar.main);
</script>
