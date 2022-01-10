<script type="text/javascript">
Ext.ns("NominaMovimientoFiltro");
NominaMovimientoFiltro.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.nu_cedula = new Ext.form.NumberField({
	fieldLabel:'Cedula',
	name:'nu_cedula',
    width:100,
	value:''
});

this.nb_trabajador = new Ext.form.TextField({
	fieldLabel:'Nombre',
	name:'nb_trabajador',
    width:300,
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                    this.nu_cedula,
                    this.nb_trabajador,
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
                     NominaMovimientoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    NominaMovimientoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    NominaMovimientoFiltro.main.win.close();
                    NominaMovimientoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    NominaMovimientoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    NominaMovimientoFiltro.main.panelfiltro.getForm().reset();
    NominaMovimientoLista.main.store_lista.baseParams={}
    NominaMovimientoLista.main.store_lista.baseParams.paginar = 'si';
    NominaMovimientoLista.main.store_lista.baseParams.co_nomina = NominaMovimientoLista.main.OBJ.id_tbrh013_nomina;
    NominaMovimientoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = NominaMovimientoFiltro.main.panelfiltro.getForm().getValues();
    NominaMovimientoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("NominaMovimientoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        NominaMovimientoLista.main.store_lista.baseParams.paginar = 'si';
        NominaMovimientoLista.main.store_lista.baseParams.BuscarBy = true;
        NominaMovimientoLista.main.store_lista.baseParams.co_nomina = NominaMovimientoLista.main.OBJ.id_tbrh013_nomina;
        NominaMovimientoLista.main.store_lista.load();


}

};

Ext.onReady(NominaMovimientoFiltro.main.init,NominaMovimientoFiltro.main);
</script>