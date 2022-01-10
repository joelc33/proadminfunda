<script type="text/javascript">
Ext.ns("PersonaFiltro");
PersonaFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CARGO = this.getStoreCO_CARGO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_NIVEL_ORGANIZACIONAL = this.getStoreCO_NIVEL_ORGANIZACIONAL();
//<Stores de fk>
//<Stores de fk>
this.storeCO_NIVEL_TRABAJADOR = this.getStoreCO_NIVEL_TRABAJADOR();
//<Stores de fk>



this.nb_persona = new Ext.form.TextField({
	fieldLabel:'Nb persona',
	name:'nb_persona',
	value:''
});

this.ap_persona = new Ext.form.TextField({
	fieldLabel:'Ap persona',
	name:'ap_persona',
	value:''
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

this.co_cargo = new Ext.form.ComboBox({
	fieldLabel:'Co cargo',
	store: this.storeCO_CARGO,
	typeAhead: true,
	valueField: 'co_cargo',
	displayField:'co_cargo',
	hiddenName:'co_cargo',
	//readOnly:(this.OBJ.co_cargo!='')?true:false,
	//style:(this.main.OBJ.co_cargo!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_cargo',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_CARGO.load();

this.co_nivel_organizacional = new Ext.form.ComboBox({
	fieldLabel:'Co nivel organizacional',
	store: this.storeCO_NIVEL_ORGANIZACIONAL,
	typeAhead: true,
	valueField: 'co_nivel_organizacional',
	displayField:'co_nivel_organizacional',
	hiddenName:'co_nivel_organizacional',
	//readOnly:(this.OBJ.co_nivel_organizacional!='')?true:false,
	//style:(this.main.OBJ.co_nivel_organizacional!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_nivel_organizacional',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_NIVEL_ORGANIZACIONAL.load();

this.co_nivel_trabajador = new Ext.form.ComboBox({
	fieldLabel:'Co nivel trabajador',
	store: this.storeCO_NIVEL_TRABAJADOR,
	typeAhead: true,
	valueField: 'co_nivel_trabajador',
	displayField:'co_nivel_trabajador',
	hiddenName:'co_nivel_trabajador',
	//readOnly:(this.OBJ.co_nivel_trabajador!='')?true:false,
	//style:(this.main.OBJ.co_nivel_trabajador!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_nivel_trabajador',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_NIVEL_TRABAJADOR.load();

this.nu_celular = new Ext.form.TextField({
	fieldLabel:'Nu celular',
	name:'nu_celular',
	value:''
});

this.nu_extension = new Ext.form.TextField({
	fieldLabel:'Nu extension',
	name:'nu_extension',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.nb_persona,
                                                                                this.ap_persona,
                                                                                this.nu_cedula,
                                                                                this.co_documento,
                                                                                this.co_cargo,
                                                                                this.co_nivel_organizacional,
                                                                                this.co_nivel_trabajador,
                                                                                this.nu_celular,
                                                                                this.nu_extension,
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
                     PersonaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PersonaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PersonaFiltro.main.win.close();
                    PersonaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PersonaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PersonaFiltro.main.panelfiltro.getForm().reset();
    PersonaLista.main.store_lista.baseParams={}
    PersonaLista.main.store_lista.baseParams.paginar = 'si';
    PersonaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PersonaFiltro.main.panelfiltro.getForm().getValues();
    PersonaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PersonaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PersonaLista.main.store_lista.baseParams.paginar = 'si';
        PersonaLista.main.store_lista.baseParams.BuscarBy = true;
        PersonaLista.main.store_lista.load();


}
,getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'}
            ]
    });
    return this.store;
}
,getStoreCO_CARGO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/storefkcocargo',
        root:'data',
        fields:[
            {name: 'co_cargo'}
            ]
    });
    return this.store;
}
,getStoreCO_NIVEL_ORGANIZACIONAL:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/storefkconivelorganizacional',
        root:'data',
        fields:[
            {name: 'co_nivel_organizacional'}
            ]
    });
    return this.store;
}
,getStoreCO_NIVEL_TRABAJADOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Persona/storefkconiveltrabajador',
        root:'data',
        fields:[
            {name: 'co_nivel_trabajador'}
            ]
    });
    return this.store;
}

};

Ext.onReady(PersonaFiltro.main.init,PersonaFiltro.main);
</script>