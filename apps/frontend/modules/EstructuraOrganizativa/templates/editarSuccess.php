<script type="text/javascript">
Ext.ns("EstructuraOrganizativaEditar");
EstructuraOrganizativaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_NIVEL_JERARQUICO = this.getStoreCO_NIVEL_JERARQUICO();
//<Stores de fk>
this.storeCO_PADRE = this.getStoreCO_PADRE();
//<Stores de fk>
this.storeCO_DEPENDENCIA = this.getStoreCO_DEPENDENCIA();
//<Stores de fk>

//<ClavePrimaria>
this.co_estructura_administrativa = new Ext.form.Hidden({
    name:'co_estructura_administrativa',
    value:this.OBJ.co_estructura_administrativa});
//</ClavePrimaria>

this.co_padre = new Ext.form.ComboBox({
	fieldLabel:'Padre',
	store: this.storeCO_PADRE,
	typeAhead: true,
	valueField: 'co_estructura_administrativa',
	displayField:'tx_nom_estructura_administrativa',
	hiddenName:'tbrh005_estructura_administrativa[co_padre]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione padre',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	allowBlank:false
});
this.storeCO_PADRE.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_padre,
	value:  this.OBJ.co_padre,
	objStore: this.storeCO_PADRE
});

this.tx_nom_estructura_administrativa = new Ext.form.TextField({
	fieldLabel:'Descripción',
	name:'tbrh005_estructura_administrativa[tx_nom_estructura_administrativa]',
	value:this.OBJ.tx_nom_estructura_administrativa,
	allowBlank:false,
	width:400
});

this.nu_centro_costo = new Ext.form.TextField({
	fieldLabel:'Centro de Costo',
	name:'tbrh005_estructura_administrativa[nu_centro_costo]',
	value:this.OBJ.nu_centro_costo,
	//allowBlank:false,
	width:400
});



this.co_nivel_jerarquico = new Ext.form.ComboBox({
	fieldLabel:'Co nivel jerarquico',
	store: this.storeCO_NIVEL_JERARQUICO,
	typeAhead: true,
	valueField: 'co_nivel_jerarquico',
	displayField:'co_nivel_jerarquico',
	hiddenName:'tbrh005_estructura_administrativa[co_nivel_jerarquico]',
	//readOnly:(this.OBJ.co_nivel_jerarquico!='')?true:false,
	//style:(this.main.OBJ.co_nivel_jerarquico!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_nivel_jerarquico',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_NIVEL_JERARQUICO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_nivel_jerarquico,
	value:  this.OBJ.co_nivel_jerarquico,
	objStore: this.storeCO_NIVEL_JERARQUICO
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tbrh005_estructura_administrativa[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tbrh005_estructura_administrativa[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tbrh005_estructura_administrativa[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.co_dependencia = new Ext.form.ComboBox({
	fieldLabel:'Co dependencia',
	store: this.storeCO_DEPENDENCIA,
	typeAhead: true,
	valueField: 'co_dependencia',
	displayField:'co_dependencia',
	hiddenName:'tbrh005_estructura_administrativa[co_dependencia]',
	//readOnly:(this.OBJ.co_dependencia!='')?true:false,
	//style:(this.main.OBJ.co_dependencia!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_dependencia',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_DEPENDENCIA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_dependencia,
	value:  this.OBJ.co_dependencia,
	objStore: this.storeCO_DEPENDENCIA
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!EstructuraOrganizativaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        EstructuraOrganizativaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/guardar',
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
                var msg = Ext.get('tabPrincipal');
                msg.load({
                        url: 'EstructuraOrganizativa',
                        scripts: true,
                        text: 'Cargando...'
                });
                 EstructuraOrganizativaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        EstructuraOrganizativaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_estructura_administrativa,
                    this.co_padre,
                    this.tx_nom_estructura_administrativa,
//                    this.nu_centro_costo,
//                    this.co_nivel_jerarquico,
//                    this.in_activo,
//                    this.created_at,
//                    this.updated_at,
//                    this.co_dependencia,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Nueva Estructura',
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
EstructuraOrganizativaListaEstructura.main.mascara.hide();
}
,getStoreCO_NIVEL_JERARQUICO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/storefkconiveljerarquico',
        root:'data',
        fields:[
            {name: 'co_nivel_jerarquico'}
            ]
    });
    return this.store;
}
,getStoreCO_DEPENDENCIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/storefkcodependencia',
        root:'data',
        fields:[
            {name: 'co_dependencia'}
            ]
    });
    return this.store;
}
,getStoreCO_PADRE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/storefkcopadre',
        root:'data',
        fields:[
            {name: 'co_estructura_administrativa'}, {name: 'tx_nom_estructura_administrativa'}
            ]
    });
    return this.store;
}
};
Ext.onReady(EstructuraOrganizativaEditar.main.init, EstructuraOrganizativaEditar.main);
</script>
