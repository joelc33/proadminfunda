<script type="text/javascript">
Ext.ns("NominaMovimientoFiltroSobregiro");
NominaMovimientoFiltroSobregiro.main = {
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
                     NominaMovimientoFiltroSobregiro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    NominaMovimientoFiltroSobregiro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    NominaMovimientoFiltroSobregiro.main.win.close();
                    SobregiroLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    SobregiroLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    NominaMovimientoFiltroSobregiro.main.panelfiltro.getForm().reset();
    SobregiroLista.main.store_lista.baseParams={}
    SobregiroLista.main.store_lista.baseParams.paginar = 'si';
    SobregiroLista.main.store_lista.baseParams.co_nomina = SobregiroLista.main.OBJ.id_tbrh013_nomina;
    SobregiroLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = NominaMovimientoFiltroSobregiro.main.panelfiltro.getForm().getValues();
    SobregiroLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("SobregiroLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        SobregiroLista.main.store_lista.baseParams.paginar = 'si';
        SobregiroLista.main.store_lista.baseParams.BuscarBy = true;
        SobregiroLista.main.store_lista.baseParams.co_nomina = SobregiroLista.main.OBJ.id_tbrh013_nomina;
        SobregiroLista.main.store_lista.load();


}

};

Ext.onReady(NominaMovimientoFiltroSobregiro.main.init,NominaMovimientoFiltroSobregiro.main);
</script>