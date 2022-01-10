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

   documento.contabilidad = {
 	init: function(){

        
        this.fe_inicio = new Ext.form.DateField({
		fieldLabel:'Fecha de inicio',
                id:'fe_inicio',
                name:'fe_inicio',
                format:'d-m-Y',
                vtype: 'daterange',
                //allowBlank:false,
                style: {width:'10%'},
                endDateField: 'fe_fin',           
                allowBlank:false
	});
        this.fe_fin = new Ext.form.DateField({
		fieldLabel:'Fecha de fin',
                id:'fe_fin',
                name:'fe_fin',
                format:'d-m-Y',
                //allowBlank:false,
                style: {width:'10%'},
                vtype: 'daterange',
                startDateField: 'fe_inicio',
                allowBlank:false
                
	});
        this.storeCO_CONCEPTO = this.getStoreCO_CONCEPTO();
        this.concepto_proveedor = new Ext.form.ComboBox({
	fieldLabel:'Concepto',
	store: this.storeCO_CONCEPTO,
	typeAhead: true,
        id: 'concepto_proveedor',
        name: 'concepto_proveedor',
	valueField: 'codigo_proveedor',
	displayField:'desc_concepto',
	hiddenName:'codigo_proveedor',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Todos',
	selectOnFocus: true,
	mode: 'local',
	width:300,
        });    
        this.storeCO_CONCEPTO.load();    
        
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [this.fe_inicio, this.fe_fin,this.concepto_proveedor]
        });
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte de retenciones de proveedor.</p></b></font><FONT SIZE=2><p>1.Seleccione el rango de fecha</p><p>2.Presione el Botón Consultar</p><p></font>',
});

this.exportar = new Ext.Button({
    text:'Exportar',
    iconCls: 'icon-descargar',
    handler:function(){
        
            if(!documento.contabilidad.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }        
        
        
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/Reporte_retenciones_proveedor_XSL.php?'+documento.contabilidad.formpanel.getForm().getValues(true));
    }
});

this.exportar_patria = new Ext.Button({
    text:'Exportar Plataforma Patria',
    iconCls: 'icon-descargar',
    handler:function(){
        
            if(!documento.contabilidad.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }        
        
        
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/Reporte_retenciones_proveedor_XSL_patria.php?'+documento.contabilidad.formpanel.getForm().getValues(true));
    }
});
 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'icon-reporteVeh',
                title: 'Reporte de Retención por Proveedor',
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
                    text:'Consultar Patria',  // Generar la impresión en pdf
                    iconCls:'icon-buscar',
                    handler: this.onImprimirPatria 
                },                
                {
               	    text:'Limpiar',  // Limpiar campos del formulario
                    iconCls:'icon-limpiar',
                    handler: this.onLimpiar
                },this.exportar,this.exportar_patria]

	});


        this.formpanel.render('mainPrincipal');
     

 	},
        onImprimir : function() {

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/Reporte_retenciones_proveedor.php?'+documento.contabilidad.formpanel.getForm().getValues(true));

         },
        onImprimirPatria : function() {

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/Reporte_retenciones_proveedor_patria.php?'+documento.contabilidad.formpanel.getForm().getValues(true));

         },                 

         onLimpiar: function(){
            documento.contabilidad.formpanel.getForm().reset();
        },getStoreCO_CONCEPTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/storeconceptoproveedor',
        root:'data',
        fields:[
            {name: 'codigo_proveedor'},
            {
            name: 'desc_concepto',
            convert: function(v, r) {
                    return r.codigo_proveedor + ' - ' + r.desc_concepto;
            }
            }
            ]
    });
    return this.store;
}
 }
Ext.onReady(documento.contabilidad.init, documento.contabilidad);

</script>
<div id="mainPrincipal"></div>
