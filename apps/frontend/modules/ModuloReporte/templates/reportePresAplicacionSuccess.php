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

    this.fe_inicio = new Ext.form.DateField({
        fieldLabel:'Fecha de Corte',
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
      
    this.tipo_planilla = new Ext.form.FieldSet({
        title: 'Seleccione Parametros',
        items: [
            this.fe_inicio,
            //this.fe_fin
        ]
    });
        
    this.Descripcion = new Ext.Panel({
        title: 'Descripcion',
        autoWidth:true,
        border:false,
        padding	: 10,
        html:'<FONT SIZE=2><p><b>Muestra un reporte de la ejecución presupuestaria por Aplicación.</p></b></font><FONT SIZE=2><p>1.Seleccione los parametros de acuerdo a la busquedad requerida</p><p>2.Presione el Botón Consultar</p><p></font>',
    });

 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'',
                title: 'Reporte de Presupuesto por Aplicación',
                url: '',
                defaults:{style: 'margin-bottom:10px'},
		items:[
                
                        this.tipo_planilla,this.Descripcion

                ],
                buttonAlign:'center',
                buttons:[
                {
                    text:'Resumen',  // Generar la impresión en pdf
                    iconCls:'icon-buscar',
                    handler: this.onImprimir 
                },
                {
                    text:'Detallado',  // Generar la impresión en pdf
                    iconCls:'icon-reporteest',
                    handler: this.onImprimirDetalle
                },
                {
                    text:'Exportar Resumen',  // Generar la impresión en pdf
                    iconCls:'icon-descargar',
                    handler: this.onExportar 
                }, 
                {
                    text:'Exportar Detallado',  // Generar la impresión en pdf
                    iconCls:'icon-descargar',
                    handler: this.onExportarDetallado 
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

        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/presupuestoAplicacion.php?'+documento.presupuesto.formpanel.getForm().getValues(true));

    },
    onImprimirDetalle : function() {
        
        if(!documento.presupuesto.formpanel.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los paramentros de busqueda requeridos");
            return false;
        }

        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/presupuestoAplicacionDetalle.php?'+documento.presupuesto.formpanel.getForm().getValues(true));

    }, 
    onExportar : function() {
        
        if(!documento.presupuesto.formpanel.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los paramentros de busqueda requeridos");
            return false;
        }

        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/presupuestoAplicacion_XLS.php?'+documento.presupuesto.formpanel.getForm().getValues(true));

    },
    onExportarDetallado : function() {
        
        if(!documento.presupuesto.formpanel.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los paramentros de busqueda requeridos");
            return false;
        }

        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/presupuestoAplicacionDetalle_XLS.php?'+documento.presupuesto.formpanel.getForm().getValues(true));

    }
}
Ext.onReady(documento.presupuesto.init, documento.presupuesto);
</script>
<div id="mainPrincipal"></div>
