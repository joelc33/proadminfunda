<script type="text/javascript">
Ext.ns("ConceptoNominaPagoSituacionFiltro");
ConceptoNominaPagoSituacionFiltro.main = {
init:function(){




this.co_concepto = new Ext.form.NumberField({
	fieldLabel:'Co concepto',
	name:'co_concepto',
	value:''
});

this.co_situacion = new Ext.form.NumberField({
	fieldLabel:'Co situacion',
	name:'co_situacion',
	value:''
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'in_activo',
	checked:true
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'updated_at'
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_concepto,
                                                                                this.co_situacion,
                                                                                this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
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
                     ConceptoNominaPagoSituacionFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConceptoNominaPagoSituacionFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConceptoNominaPagoSituacionFiltro.main.win.close();
                    ConceptoNominaPagoSituacionLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConceptoNominaPagoSituacionLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConceptoNominaPagoSituacionFiltro.main.panelfiltro.getForm().reset();
    ConceptoNominaPagoSituacionLista.main.store_lista.baseParams={}
    ConceptoNominaPagoSituacionLista.main.store_lista.baseParams.paginar = 'si';
    ConceptoNominaPagoSituacionLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConceptoNominaPagoSituacionFiltro.main.panelfiltro.getForm().getValues();
    ConceptoNominaPagoSituacionLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConceptoNominaPagoSituacionLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConceptoNominaPagoSituacionLista.main.store_lista.baseParams.paginar = 'si';
        ConceptoNominaPagoSituacionLista.main.store_lista.baseParams.BuscarBy = true;
        ConceptoNominaPagoSituacionLista.main.store_lista.load();


}

};

Ext.onReady(ConceptoNominaPagoSituacionFiltro.main.init,ConceptoNominaPagoSituacionFiltro.main);
</script>