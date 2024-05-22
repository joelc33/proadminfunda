<script type="text/javascript">
Ext.ns("ContabilidadFiltro");
ContabilidadFiltro.main = {
init:function(){




this.co_compras = new Ext.form.NumberField({
	fieldLabel:'Co compras',
	name:'co_compras',
	value:''
});

this.fecha_inicio = new Ext.form.DateField({
	fieldLabel:'Fecha inicio',
	name:'fecha_inicio'
});

this.fecha_fin = new Ext.form.DateField({
	fieldLabel:'Fecha fin',
	name:'fecha_fin'
});

this.co_ramo = new Ext.form.NumberField({
	fieldLabel:'Co ramo',
	name:'co_ramo',
	value:''
});

this.monto = new Ext.form.NumberField({
	fieldLabel:'Monto',
name:'monto',
	value:''
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

this.fecha_entrega = new Ext.form.DateField({
	fieldLabel:'Fecha entrega',
	name:'fecha_entrega'
});

this.tiempo_garantia = new Ext.form.TextField({
	fieldLabel:'Tiempo garantia',
	name:'tiempo_garantia',
	value:''
});

this.co_tp_contrato = new Ext.form.NumberField({
	fieldLabel:'Co tp contrato',
	name:'co_tp_contrato',
	value:''
});

this.co_fuente_financiamiento = new Ext.form.NumberField({
	fieldLabel:'Co fuente financiamiento',
	name:'co_fuente_financiamiento',
	value:''
});

this.nu_expediente = new Ext.form.TextField({
	fieldLabel:'Nu expediente',
	name:'nu_expediente',
	value:''
});

this.co_solicitud_anular = new Ext.form.NumberField({
	fieldLabel:'Co solicitud anular',
	name:'co_solicitud_anular',
	value:''
});

this.in_anular = new Ext.form.Checkbox({
	fieldLabel:'In anular',
	name:'in_anular',
	checked:true
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.co_compras,
                                                                                this.fecha_inicio,
                                                                                this.fecha_fin,
                                                                                this.co_ramo,
                                                                                this.monto,
                                                                                this.created_at,
                                                                                this.fecha_entrega,
                                                                                this.tiempo_garantia,
                                                                                this.co_tp_contrato,
                                                                                this.co_fuente_financiamiento,
                                                                                this.nu_expediente,
                                                                                this.co_solicitud_anular,
                                                                                this.in_anular,
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
                     ContabilidadFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ContabilidadFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ContabilidadFiltro.main.win.close();
                    ContabilidadLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ContabilidadLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ContabilidadFiltro.main.panelfiltro.getForm().reset();
    ContabilidadLista.main.store_lista.baseParams={}
    ContabilidadLista.main.store_lista.baseParams.paginar = 'si';
    ContabilidadLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ContabilidadFiltro.main.panelfiltro.getForm().getValues();
    ContabilidadLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ContabilidadLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ContabilidadLista.main.store_lista.baseParams.paginar = 'si';
        ContabilidadLista.main.store_lista.baseParams.BuscarBy = true;
        ContabilidadLista.main.store_lista.load();


}

};

Ext.onReady(ContabilidadFiltro.main.init,ContabilidadFiltro.main);
</script>