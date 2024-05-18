<script type="text/javascript">

   Ext.ns("documento");

//----- Función que bloquea los dias en el calendario de la fecha fin dependiendo de la fecha de inicio --//
    Ext.apply(Ext.form.VTypes, {
        daterange : function(val, field) {
            var date = field.parseDate(val);

            if(!date){
                return false;
            }
            if (field.startDateField && (!this.dateRangeMax || (date.getTime() != this.dateRangeMax.getTime()))) {
                var start = Ext.getCmp(field.startDateField);
                start.setMaxValue(date);
                start.validate();
                this.dateRangeMax = date;
            }
            else if (field.endDateField && (!this.dateRangeMin || (date.getTime() != this.dateRangeMin.getTime()))) {
                var end = Ext.getCmp(field.endDateField);
                end.setMinValue(date);
                end.validate();
                this.dateRangeMin = date;
            }
            return true;
        }
    });

//-------------------------------------------------------------------------------------------//
  

   documento.presupuesto = {
 	init: function(){

        this.storeCO_APORTE = this.getStoreCO_APORTE();
       
        this.fe_inicio = new Ext.form.DateField({
		fieldLabel:'Fecha de inicio',
                id:'fe_inicio',
                name:'fe_inicio',
                format:'d-m-Y',
                vtype: 'daterange',
                allowBlank:false,
                style: {width:'10%'},
                endDateField: 'fe_fin',           
                allowBlank:false
    	});
            this.fe_fin = new Ext.form.DateField({
    		fieldLabel:'Fecha de fin',
                    id:'fe_fin',
                    name:'fe_fin',
                    format:'d-m-Y',
                    allowBlank:false,
                    style: {width:'10%'},
                    vtype: 'daterange',
                    startDateField: 'fe_inicio',
                    allowBlank:false
                    
    	});

        /*    this.tx_concepto = new Ext.form.ComboBox({
                fieldLabel:'Concepto',
                store: this.storeCO_APORTE,
                typeAhead: true,
                id: 'tx_concepto',
                name: 'tx_concepto',
                valueField: 'tx_movimiento',
                displayField:'tx_descripcion',
                hiddenName:'tx_concepto',
                forceSelection:true,
                resizable:true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width:400,
                resizable:true
        });

            this.storeCO_APORTE.load();*/

                     
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [
                    this.fe_inicio, 
                    this.fe_fin
                   // this.tx_concepto
                   // this.tipo, 
                    //this.tx_ejecutor
                ]
        });
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte de la Relación ODP por Partidas.</p></b></font><FONT SIZE=2><p>1.Seleccione los parametros de acuerdo a la busquedad requerida</p><p>2.Presione el Botón Consultar</p><p></font>',
});
 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'',
                title: ' Relación ODP por Partidas',
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

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/relacion_opd_partida_XLS.php?'+documento.presupuesto.formpanel.getForm().getValues(true));

         },
getStoreNU_ANIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/login/storefkAnioFiscal',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'co_anio_fiscal'},
            {name: 'tx_anio_fiscal'}
            ]
    });
    return this.store;
},
         onLimpiar: function(){
            documento.presupuesto.formpanel.getForm().reset();
        },getStoreCO_SECTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/storefkidtb080sector',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'nu_sector'},
            {name: 'de_sector'}
            ]
    });
    return this.store;
},getStoreCO_EJECUTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/storefkidtb082ejecutor',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'nu_ejecutor'},
            {name: 'de_ejecutor'}
            ]
    });
    return this.store;
},getStoreCO_PAC:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/storetb083proyectoac',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'nu_proyecto_ac'},
            {name: 'de_proyecto_ac'}
            ]
    });
    return this.store;
},getStoreCO_AE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/storetb084accionesp',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'nu_accion_especifica'},
            {name: 'de_accion_especifica'}
            ]
    });
    return this.store;
},getStoreCO_PART:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/storePartidas',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'nu_partida'},
            {name: 'de_partida'}
            ]
    });
    return this.store;
}
,getStoreCO_APORTE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/storeAportePatronal',
        root:'data',
        fields:[
             {name: 'tx_movimiento'},
             {name: 'tx_descripcion'}
            ]
    });
    return this.store;
},


 }

Ext.onReady(documento.presupuesto.init, documento.presupuesto);

</script>
<div id="mainPrincipal"></div>
