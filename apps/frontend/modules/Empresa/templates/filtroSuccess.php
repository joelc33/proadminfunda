<script type="text/javascript">
Ext.ns("EmpresaFiltro");
EmpresaFiltro.main = {
init:function(){

//<Stores de fk>
this.storeCO_ESTADO = this.getStoreCO_ESTADO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_MUNICIPIO = this.getStoreCO_MUNICIPIO();
//<Stores de fk>



this.nb_empresa = new Ext.form.TextField({
	fieldLabel:'Nb empresa',
	name:'nb_empresa',
	value:''
});

this.co_estado = new Ext.form.ComboBox({
	fieldLabel:'Co estado',
	store: this.storeCO_ESTADO,
	typeAhead: true,
	valueField: 'co_estado',
	displayField:'co_estado',
	hiddenName:'co_estado',
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

this.co_municipio = new Ext.form.ComboBox({
	fieldLabel:'Co municipio',
	store: this.storeCO_MUNICIPIO,
	typeAhead: true,
	valueField: 'co_municipio',
	displayField:'co_municipio',
	hiddenName:'co_municipio',
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

this.tx_rif = new Ext.form.TextField({
	fieldLabel:'Tx rif',
	name:'tx_rif',
	value:''
});

this.tx_nit = new Ext.form.TextField({
	fieldLabel:'Tx nit',
	name:'tx_nit',
	value:''
});

this.tx_direccion = new Ext.form.TextField({
	fieldLabel:'Tx direccion',
	name:'tx_direccion',
	value:''
});

this.tx_imagen_der = new Ext.form.TextField({
	fieldLabel:'Tx imagen der',
	name:'tx_imagen_der',
	value:''
});

this.tx_imagen_izq = new Ext.form.TextField({
	fieldLabel:'Tx imagen izq',
	name:'tx_imagen_izq',
	value:''
});

this.tx_imagen_cen = new Ext.form.TextField({
	fieldLabel:'Tx imagen cen',
	name:'tx_imagen_cen',
	value:''
});

this.nu_telefono = new Ext.form.TextField({
	fieldLabel:'Nu telefono',
	name:'nu_telefono',
	value:''
});

this.tx_sigla = new Ext.form.TextField({
	fieldLabel:'Tx sigla',
	name:'tx_sigla',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
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
                     EmpresaFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    EmpresaFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    EmpresaFiltro.main.win.close();
                    EmpresaLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    EmpresaLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    EmpresaFiltro.main.panelfiltro.getForm().reset();
    EmpresaLista.main.store_lista.baseParams={}
    EmpresaLista.main.store_lista.baseParams.paginar = 'si';
    EmpresaLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = EmpresaFiltro.main.panelfiltro.getForm().getValues();
    EmpresaLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("EmpresaLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        EmpresaLista.main.store_lista.baseParams.paginar = 'si';
        EmpresaLista.main.store_lista.baseParams.BuscarBy = true;
        EmpresaLista.main.store_lista.load();


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

Ext.onReady(EmpresaFiltro.main.init,EmpresaFiltro.main);
</script>