<script type="text/javascript">
Ext.ns("ResponsableFiltro");
ResponsableFiltro.main = {
init:function(){




this.tx_nombres = new Ext.form.TextField({
	fieldLabel:'Nombres',
	name:'tx_nombres',
    value:'',
	allowBlank:false,
	width:400
});

this.tx_apellidos = new Ext.form.TextField({
	fieldLabel:'Apellidos',
	name:'tx_apellidos',
    value:'',
	allowBlank:false,
	width:400
});

this.nu_cedula = new Ext.form.NumberField({
	fieldLabel:'Cedula',
	name:'nu_cedula',
    value:'',
	allowBlank:false,
	width:400,
    minValue : 0,
    allowDecimals : false,
    allowNegative : false,
    tooltip : ''
});


    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[this.nu_cedula,this.tx_nombres,this.tx_apellidos]
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
                     ResponsableFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ResponsableFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ResponsableFiltro.main.win.close();
                    ResponsableLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ResponsableLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ResponsableFiltro.main.panelfiltro.getForm().reset();
    ResponsableLista.main.store_lista.baseParams={}
    ResponsableLista.main.store_lista.baseParams.paginar = 'si';
    ResponsableLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ResponsableFiltro.main.panelfiltro.getForm().getValues();
    ResponsableLista.main.store_lista.baseParams={};

    var swfiltrar = false;
   
    for(campName in campo){
      
        if(campo[campName]!=''){
        
            swfiltrar = true;
            eval("ResponsableLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
         
        }
    }
 
        ResponsableLista.main.store_lista.baseParams.paginar = 'si';
        ResponsableLista.main.store_lista.baseParams.BuscarBy = true;
        ResponsableLista.main.store_lista.load();


}

};

Ext.onReady(ResponsableFiltro.main.init,ResponsableFiltro.main);
</script>
