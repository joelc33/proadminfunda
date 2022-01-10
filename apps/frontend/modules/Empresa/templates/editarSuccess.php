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
	fieldLabel:'Nombre',
	name:'tb015_empresa[nb_empresa]',
	value:this.OBJ.nb_empresa,
	allowBlank:false,
	width:700
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
	fieldLabel:'RIF',
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

this.tx_direccion = new Ext.form.TextArea({
	fieldLabel:'Dirección',
	name:'tb015_empresa[tx_direccion]',
	value:this.OBJ.tx_direccion,
	allowBlank:false,
	width:700
});

this.tx_imagen_der = new Ext.form.TextField({
	fieldLabel:'Derecha',
	name:'tb015_empresa[tx_imagen_der]',
	value:this.OBJ.tx_imagen_der,
	allowBlank:false,
	width:200
});

this.tx_imagen_izq = new Ext.form.TextField({
	fieldLabel:'Izquierda',
	name:'tb015_empresa[tx_imagen_izq]',
	value:this.OBJ.tx_imagen_izq,
	allowBlank:false,
	width:200
});

this.tx_imagen_cen = new Ext.form.TextField({
	fieldLabel:'Centro',
	name:'tb015_empresa[tx_imagen_cen]',
	value:this.OBJ.tx_imagen_cen,
	allowBlank:false,
	width:200
});

this.nu_telefono = new Ext.form.TextField({
	fieldLabel:'Teléfonos',
	name:'tb015_empresa[nu_telefono]',
	value:this.OBJ.nu_telefono,
	allowBlank:false,
	width:300
});

this.tx_sigla = new Ext.form.TextField({
	fieldLabel:'Siglas',
	name:'tb015_empresa[tx_sigla]',
	value:this.OBJ.tx_sigla,
	allowBlank:false,
	width:300
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

this.fieldDatos= new Ext.form.FieldSet({
        title: 'Datos de la Institución',
        items:[this.tx_rif,
                this.nb_empresa,
                this.tx_sigla,                    
                this.nu_telefono,
                this.tx_direccion]
});

this.fieldDatosImagenes = new Ext.form.FieldSet({
        title: 'Imagenes para Reportes',
        items:[ {
                            xtype: 'fileuploadfield',
                            style:"padding-right:530px",
                            id: 'form-file-izquierda',
                            emptyText: 'Seleccione una Imagen',
                            fieldLabel: 'Izquierda',
                            name: 'form-file-izquierda',
                            buttonText: 'Buscar'            
                },
                {
                            xtype: 'fileuploadfield',
                            style:"padding-right:530px",
                            id: 'form-file-derecha',
                            emptyText: 'Seleccione una Imagen',
                            fieldLabel: 'Derecha',
                            name: 'form-file-derecha',
                            buttonText: 'Buscar'            
                },
                {
                            xtype: 'fileuploadfield',
                            style:"padding-right:530px",
                            id: 'form-file-centro',
                            emptyText: 'Seleccione una Imagen',
                            fieldLabel: 'Centro',
                            name: 'form-file-centro',
                            buttonText: 'Buscar'            
                }]
});


this.formPanel_ = new Ext.form.FormPanel({
    title: 'Datos de la Institución',
    fileUpload: true,
    width:900,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
            this.co_empresa,                            
            this.fieldDatos,
            this.fieldDatosImagenes
          ],
    buttons:[
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});

this.formPanel_.render("contenedorEmpresaLista");

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
<div id="contenedorEmpresaLista"></div>