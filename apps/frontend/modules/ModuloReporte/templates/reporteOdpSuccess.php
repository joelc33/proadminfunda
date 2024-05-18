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
   documento.tesoreria = {
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
       

        this.tipoOrden = new Ext.form.ComboBox({
                        fieldLabel : 'Estado',
                        displayField:'tx_tipo',
                        typeAhead: true,
                        store:new Ext.data.SimpleStore({
                        data : [[1, 'APROBADAS'],[2, 'ANULADAS']],
                        fields : ['co_tipo', 'tx_tipo']
                                                       }),
                        valueField: 'co_tipo',
                        forceSelection:true,
                        hiddenName:'co_tipo',
                        name: 'co_tipo',
                        id: 'co_tipo',
                        triggerAction: 'all',
                        selectOnFocus:true,
                        mode:'local',
                        width:200
                  });
        
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [this.fe_inicio, this.fe_fin]
        });
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte relación detallada de OP.</p></b></font><FONT SIZE=2><p>1.Indique el rango de fechas</p><p>2.Indique el código del proveedor</p><p>3.Seleccione el tipo de orden</p><p>4.Indique el nro. de documento</p><p>5.Presione el Botón Consultar , valor por defecto "TODOS"</p></font>',
});
 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'icon-reporteVeh',
                title: 'Reporte Relación Ordenes de Pago',
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

            if(!documento.tesoreria.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }
            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/RelacionOdp.php?fe_fin='+Ext.get('fe_fin').getValue()+'&fe_inicio='+Ext.get('fe_inicio').getValue());

         },

         onLimpiar: function(){
            documento.tesoreria.formpanel.getForm().reset();
        }

 }

Ext.onReady(documento.tesoreria.init, documento.tesoreria);

</script>
<div id="mainPrincipal"></div>
