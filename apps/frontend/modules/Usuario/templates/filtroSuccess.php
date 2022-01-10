<script type="text/javascript">
Ext.ns("UsuarioFiltro");
UsuarioFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_ROL = this.getStoreCO_ROL();
//<Stores de fk>
//<Stores de fk>
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
//<Stores de fk>



this.tx_login = new Ext.form.TextField({
	fieldLabel:'Tx login',
	name:'tx_login',
	value:''
});

this.nb_usuario = new Ext.form.TextField({
	fieldLabel:'Nb usuario',
	name:'nb_usuario',
	value:''
});

this.tx_password = new Ext.form.TextField({
	fieldLabel:'Tx password',
	name:'tx_password',
	value:''
});

this.co_rol = new Ext.form.ComboBox({
	fieldLabel:'Co rol',
	store: this.storeCO_ROL,
	typeAhead: true,
	valueField: 'co_rol',
	displayField:'co_rol',
	hiddenName:'co_rol',
	//readOnly:(this.OBJ.co_rol!='')?true:false,
	//style:(this.main.OBJ.co_rol!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_rol',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ROL.load();

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'in_activo',
	checked:true
});

this.nu_cedula = new Ext.form.NumberField({
	fieldLabel:'Nu cedula',
name:'nu_cedula',
	value:''
});

this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'co_documento',
	hiddenName:'co_documento',
	//readOnly:(this.OBJ.co_documento!='')?true:false,
	//style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_documento',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_DOCUMENTO.load();

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.tx_login,
                                                                                this.nb_usuario,
                                                                                this.tx_password,
                                                                                this.co_rol,
                                                                                this.in_activo,
                                                                                this.nu_cedula,
                                                                                this.co_documento,
                                           ]
               }
            ]
    });

    this.panelfiltro = new Ext.form.FormPanel({
        frame:true,
        autoWidth:true,
        border:false,
        items:[
            this.tabpanelfiltro
        ]
    });

    this.win = new Ext.Window({
        title:'Parametros de busqueda',
        iconCls: 'icon-buscar',
        width:600,
        autoHeight:true,
        constrain:true,
        closable:false,
        buttonAlign:'center',
        items:[
            this.panelfiltro
        ],
        buttons:[
            {
                text:'Filtrar',
                handler:function(){
                     UsuarioFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    UsuarioFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    UsuarioFiltro.main.win.close();
                    UsuarioLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    UsuarioLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    UsuarioFiltro.main.panelfiltro.getForm().reset();
    UsuarioLista.main.store_lista.baseParams={}
    UsuarioLista.main.store_lista.baseParams.paginar = 'si';
    UsuarioLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = UsuarioFiltro.main.panelfiltro.getForm().getValues();
    UsuarioLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("UsuarioLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        UsuarioLista.main.store_lista.baseParams.paginar = 'si';
        UsuarioLista.main.store_lista.baseParams.BuscarBy = true;
        UsuarioLista.main.store_lista.load();


}
,getStoreCO_ROL:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/storefkcorol',
        root:'data',
        fields:[
            {name: 'co_rol'}
            ]
    });
    return this.store;
}
,getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'}
            ]
    });
    return this.store;
}

};

Ext.onReady(UsuarioFiltro.main.init,UsuarioFiltro.main);
</script>