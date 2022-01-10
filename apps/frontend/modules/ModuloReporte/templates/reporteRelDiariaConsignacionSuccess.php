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
this.storeCO_TIPO_SOLICITUD = this.getStoreCO_TIPO_SOLICITUD();
        
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
        
        this.tipoDocumento = new Ext.form.ComboBox({
                fieldLabel : 'Tipo de Documento',
                displayField:'tipo_solicitud',
                typeAhead: true,
                store: this.storeCO_TIPO_SOLICITUD,
                valueField: 'co_tipo_solicitud',
                forceSelection:true,
                hiddenName:'co_tipo',
                name: 'co_tipo',
                id: 'co_tipo',
                triggerAction: 'all',
                selectOnFocus:true,
                mode:'local',
                width:400
          });
    this.storeCO_TIPO_SOLICITUD.load();
        this.proveedor = new Ext.form.TextField({
           fieldLabel: 'Código Proveedor',
           name: 'cod_prov',
           id: 'cod_prov',
           width:100
        });
        
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [this.fe_inicio, this.fe_fin, this.tipoDocumento, this.proveedor]
        });
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte de relación diaria de consignaciones.</p></b></font><FONT SIZE=2><p>1.Seleccione el rango de fecha</p><p>2.Seleccione el banco a consultar</p><p>3.Presione el Botón Consultar</p><p></font>',
});
 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'icon-reporteVeh',
                title: 'Reporte de Relación de Diaria de Consignaciones',
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
                    text:'Exportar',  // Generar la impresión en pdf
                    iconCls:'icon-descargar',
                    handler: this.onExportar 
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

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/RelDiariaConsignacion.php?'+documento.contabilidad.formpanel.getForm().getValues(true));

         },

         onExportar : function() {

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/RelDiariaConsignacion_XLS.php?'+documento.contabilidad.formpanel.getForm().getValues(true));

        },

         onLimpiar: function(){
            documento.contabilidad.formpanel.getForm().reset();
        },getStoreCO_TIPO_SOLICITUD:function(){
            this.store = new Ext.data.JsonStore({
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/storefkcotiposolicitud',
                root:'data',
                fields:[
                    {name: 'co_tipo_solicitud'},
                    {name: 'tx_tipo_solicitud'},
                    {name: 'tipo_solicitud',
                        convert:function(v,r){
                            return r.tx_tipo_solicitud.toUpperCase();
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