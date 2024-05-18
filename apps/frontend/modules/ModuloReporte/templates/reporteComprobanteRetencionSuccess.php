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

this.co_estructura_administrativa = new Ext.form.Hidden({
    name:'co_estructura_administrativa'
});
        
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
        
        this.nu_cedula = new Ext.form.TextField({
		fieldLabel:'Cedula',
                id:'nu_cedula',
                name:'nu_cedula'
                
	});  
        this.estructura = new Ext.form.TextArea({
        name:'estructura',
        width:400,
        readOnly:true,
        style:'background:#c9c9c9;'
});
    
        this.buscarEstructura = new Ext.Button({
            text:'Seleccionar Estructura',
        //    iconCls: 'icon-cancelar',
            handler:function(){
                this.msg = Ext.get('buscarEstructura');
                this.msg.load({
                 url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/buscar",
                 params:{paquete:'documento'},
                 scripts: true,
                 text: "Cargando.."
                }); 
            }
        });    
        
        this.fieldDatosEstructura = new Ext.form.FieldSet({ 
                title: 'Estructura Administrativa',
                width:660,
                items:[{
                                xtype: 'compositefield',
                                fieldLabel: 'Descripción de Ubicación',
                                items: [
                                    this.co_estructura_administrativa,
                                    this.estructura,
                                    this.buscarEstructura
                                ]
                      }]
        });        
        
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [this.fe_inicio, this.fe_fin,this.nu_cedula,this.fieldDatosEstructura]
        });
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte de retenciones de impuesto sobre la renta.</p></b></font><FONT SIZE=2><p>1.Seleccione el rango de fecha</p><p>2.Presione el Botón Consultar</p><p></font>',
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
 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'icon-reporteVeh',
                title: 'Reporte de Retención de Impuesto sobre la Renta',
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
            if(!documento.contabilidad.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }     
            if(documento.contabilidad.nu_cedula.getValue()==''){
            if(documento.contabilidad.co_estructura_administrativa.getValue()==''){    
                Ext.Msg.alert("Alerta","Debe ingresar la estructura administrativa o una cedula");
                return false;
            }
            }   
            
            if(documento.contabilidad.co_estructura_administrativa.getValue()==''){
            if(documento.contabilidad.nu_cedula.getValue()==''){    
                Ext.Msg.alert("Alerta","Debe ingresar la estructura administrativa o una cedula");
                return false;
            }
            }            

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/rrhhComprobanteRetencion.php?'+documento.contabilidad.formpanel.getForm().getValues(true));

         },

         onLimpiar: function(){
            documento.contabilidad.formpanel.getForm().reset();
        }
 }
Ext.onReady(documento.contabilidad.init, documento.contabilidad);

</script>
<div id="mainPrincipal"></div>
<div id="buscarEstructura"></div>
