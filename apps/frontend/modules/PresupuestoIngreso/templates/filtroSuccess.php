<script type="text/javascript">
Ext.ns("PresupuestoIngresoFiltro");
PresupuestoIngresoFiltro.main = {
init:function(){




this.nu_partida = new Ext.form.TextField({
	fieldLabel:'N° Partida',
	name:'nu_partida',
	value:'',
    width:400
});

this.tx_partida = new Ext.form.TextField({
	fieldLabel:'N° Partida',
	name:'tx_partida',
	value:'',
    width:400
});

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tx_descripcion',
	value:'',
    width:400
});

this.mo_inicial = new Ext.form.NumberField({
	fieldLabel:'Mo inicial',
name:'mo_inicial',
	value:''
});

this.mo_actualizado = new Ext.form.NumberField({
	fieldLabel:'Mo actualizado',
name:'mo_actualizado',
	value:''
});

this.nu_anio = new Ext.form.NumberField({
	fieldLabel:'Año',
    name:'nu_anio',
	value:'',
    width:100
});

this.mo_comprometido = new Ext.form.NumberField({
	fieldLabel:'Mo comprometido',
name:'mo_comprometido',
	value:''
});

this.mo_causado = new Ext.form.NumberField({
	fieldLabel:'Mo causado',
name:'mo_causado',
	value:''
});

this.mo_pagado = new Ext.form.NumberField({
	fieldLabel:'Mo pagado',
name:'mo_pagado',
	value:''
});

this.mo_disponible = new Ext.form.NumberField({
	fieldLabel:'Mo disponible',
name:'mo_disponible',
	value:''
});

this.nu_nivel = new Ext.form.NumberField({
	fieldLabel:'Nu nivel',
name:'nu_nivel',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
        activeTab:0,
        defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
        items:[{
            title:'Información general',
            items:[
                this.tx_partida,
                this.tx_descripcion,
                this.nu_anio
            ]
        }]
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
                     PresupuestoIngresoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    PresupuestoIngresoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    PresupuestoIngresoFiltro.main.win.close();
                    PresupuestoIngresoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    PresupuestoIngresoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    PresupuestoIngresoFiltro.main.panelfiltro.getForm().reset();
    PresupuestoIngresoLista.main.store_lista.baseParams={}
    PresupuestoIngresoLista.main.store_lista.baseParams.paginar = 'si';
    PresupuestoIngresoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = PresupuestoIngresoFiltro.main.panelfiltro.getForm().getValues();
    PresupuestoIngresoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("PresupuestoIngresoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        PresupuestoIngresoLista.main.store_lista.baseParams.paginar = 'si';
        PresupuestoIngresoLista.main.store_lista.baseParams.BuscarBy = true;
        PresupuestoIngresoLista.main.store_lista.load();


}

};

Ext.onReady(PresupuestoIngresoFiltro.main.init,PresupuestoIngresoFiltro.main);
</script>