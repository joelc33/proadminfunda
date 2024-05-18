<script type="text/javascript">

   Ext.ns("documento");

   documento.presupuesto = {
 	init: function(){

        this.storeCO_NOMOLD = this.getStoreCO_NOMOLD();
        this.storeCO_NOMNEW = this.getStoreCO_NOMNEW();

        this.tx_NOMOLD = new Ext.form.ComboBox({
	fieldLabel:'NOMINA OLD',
	store: this.storeCO_NOMOLD,
	typeAhead: true,
        id: 'co_solicitud_old',
        name: 'co_solicitud_old',
	valueField: 'co_solicitud',
	displayField:'de_nomina',
	hiddenName:'co_solicitud_old',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Todos',
	selectOnFocus: true,
	mode: 'local',
	width:500,
	resizable:true
        });
        
        this.storeCO_NOMOLD.load();  
        
        this.tx_NOMNEW = new Ext.form.ComboBox({
	fieldLabel:'NOMINA NEW',
	store: this.storeCO_NOMNEW,
	typeAhead: true,
        id: 'co_solicitud_new',
        name: 'co_solicitud_new',
	valueField: 'co_solicitud',
	displayField:'de_nomina',
	hiddenName:'co_solicitud_new',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Todos',
	selectOnFocus: true,
	mode: 'local',
	width:500,
	resizable:true
        });
        
        this.storeCO_NOMNEW.load();  
        
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [ this.tx_NOMOLD, this.tx_NOMNEW ]
        });     
     
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte de Máximo y Mínimos.</p></b></font><FONT SIZE=2><p>1.Seleccione los parametros de acuerdo a la busquedad requerida</p><p>2.Presione el Botón Consultar</p><p></font>',
});
 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'',
                title: 'Reporte de Máximo y Mínimos',
                url: '',
                defaults:{style: 'margin-bottom:10px'},
		items:[
                
                        this.tipo_planilla,this.Descripcion

                ],
                buttonAlign:'center',
                buttons:[
                {
                    text:'Consultar',  // Generar la impresión en pdf
                    iconCls:'icon-buscar',
                    handler: this.onImprimir 
                },
                {
               	    text:'Limpiar',  // Limpiar campos del formulario
                    iconCls:'icon-limpiar',
                    handler: this.onLimpiar
                }]

	});


        this.formpanel.render('mainPrincipal');
     

 	},        
        onImprimir : function() {
        
        if(!documento.presupuesto.formpanel.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los paramentros de busqueda requeridos");
            return false;
        }

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/min_max.php?'+documento.presupuesto.formpanel.getForm().getValues(true));

         },

         onLimpiar: function(){
            documento.presupuesto.formpanel.getForm().reset();
        },getStoreCO_NOMOLD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/storeNOMOLD',
        root:'data',
        fields:[
            {name: 'co_solicitud'},
            {name: 'de_nomina',
              convert:function(v,r){
                return r.co_solicitud+' - '+r.de_nomina;
              }
            }
            ]
    });
    return this.store;
},getStoreCO_NOMNEW:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/storeNOMOLD',
        root:'data',
        fields:[
            {name: 'co_solicitud'},
            {name: 'de_nomina',
              convert:function(v,r){
                return r.co_solicitud+' - '+r.de_nomina;
              }
            }
            ]
    });
    return this.store;
}
 }

Ext.onReady(documento.presupuesto.init, documento.presupuesto);

</script>
<div id="mainPrincipal"></div>
