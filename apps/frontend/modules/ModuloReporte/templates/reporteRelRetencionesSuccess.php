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
        
        this.razon = new Ext.form.NumberField({
           fieldLabel: 'Razón Social Proveedor',
           name: 'razon_prov',
           id: 'razon_prov',
           width:100
        });
        this.proveedor = new Ext.form.TextField({
           fieldLabel: 'Código Proveedor',
           name: 'cod_prov',
           id: 'cod_prov',
           width:100
        });
        this.ordenPago = new Ext.form.NumberField({
           fieldLabel: 'Código Orden de Pago',
           name: 'cod_op',
           id: 'cod_op',
           width:100
        });
        this.documento = new Ext.form.NumberField({
           fieldLabel: 'Código Documento',
           name: 'cod_doc',
           id: 'cod_doc',
           width:100
        });
        this.tipoOrden = new Ext.form.ComboBox({
                        fieldLabel : 'Tipo de Orden',
                        displayField:'tx_tipo',
                        typeAhead: true,
                        store:new Ext.data.SimpleStore({
                        data : [[1, 'DIRECTAS Y PERMANENTES'],[2, 'TODOS']],
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

        this.storeCO_RETENCION = this.getStoreCO_RETENCION();

        this.co_tipo_retencion = new Ext.form.ComboBox({
            fieldLabel:'Retencion',
            store: this.storeCO_RETENCION,
            typeAhead: true,
            valueField: 'co_tipo_retencion',
            displayField:'tx_tipo_retencion',
            name:'retencion',
            forceSelection:true,
            resizable:true,
            triggerAction: 'all',
            emptyText:'Seleccione Retencion...',
            selectOnFocus: true,
            mode: 'local',
            width:400,
            resizable:true,           
            //allowBlank:false
        });

        this.storeCO_RETENCION.load(); 
        
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [
                    this.fe_inicio, 
                    this.fe_fin, 
                    this.proveedor, 
                    this.documento, 
                    this.tipoOrden,
                    //this.co_tipo_retencion
                ]
        });
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte relación detallada de OP por Proveedor.</p></b></font><FONT SIZE=2><p>1.Indique el rango de fechas</p><p>2.Indique el código del proveedor</p><p>3.Seleccione el tipo de orden</p><p>4.Indique el nro. de documento</p><p>5.Presione el Botón Consultar , valor por defecto "TODOS"</p></font>',
        });
 	
        this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'icon-reporteVeh',
                title: 'Relación de Retenciones',
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
                    text:'Imprimir Retenciones IVA',  // Generar la impresión en pdf
                    iconCls:'icon-pdf',
                    handler: this.onImprimirIVA
                },
                {
                    text:'Exportar Retenciones IVA',  // Generar la impresión en pdf
                    iconCls:'icon-libro',
                    handler: this.onExportarIVA
                },
                {
                    text:'Imprimr Retenciones ISLR',  // Generar la impresión en pdf
                    iconCls:'icon-pdf',
                    handler: this.onImprimirISLR
                },
                {
                    text:'Exportar Retenciones ISLR',  // Generar la impresión en pdf
                    iconCls:'icon-libro',
                    handler: this.onExportarISLR
                },
                {

                    text:'Exportar Retenciones Nomina',  // Generar la impresión en pdf
                    iconCls:'icon-libro',
                    handler: this.onExportarReporteNomina
                },
                {    text:'Imprimr Retenciones Timbre Fiscal',  // Generar la impresión en pdf
                    iconCls:'icon-pdf',
                    handler: this.onImprimirTF
                },
                {
                    text:'Imprimr Retenciones RESP. SOCIAL',  // Generar la impresión en pdf
                    iconCls:'icon-pdf',
                    handler: this.onImprimirRS
                },
                {
                    text:'Imprimr Retenciones Fiel Cump.',  // Generar la impresión en pdf
                    iconCls:'icon-pdf',
                    handler: this.onImprimirFC
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
            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/RelRetenciones.php?fe_fin='+Ext.get('fe_fin').getValue()+'&fe_inicio='+Ext.get('fe_inicio').getValue()+'&nu_codigo='+Ext.get('cod_prov').getValue());

         },

        onImprimirIVA : function() {

            if(!documento.tesoreria.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }
            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/retencionIVA_PDF.php?fe_fin='+Ext.get('fe_fin').getValue()+'&fe_inicio='+Ext.get('fe_inicio').getValue()+'&nu_codigo='+Ext.get('cod_prov').getValue());

        },

        onExportarIVA : function() {

        if(!documento.tesoreria.formpanel.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
            return false;
        }
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/retencionIVA_XSL.php?fe_fin='+Ext.get('fe_fin').getValue()+'&fe_inicio='+Ext.get('fe_inicio').getValue()+'&nu_codigo='+Ext.get('cod_prov').getValue());

        },

        onImprimirISLR : function() {

        if(!documento.tesoreria.formpanel.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
            return false;
        }
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/retencionISLR_PDF.php?fe_fin='+Ext.get('fe_fin').getValue()+'&fe_inicio='+Ext.get('fe_inicio').getValue()+'&nu_codigo='+Ext.get('cod_prov').getValue());

        },

        onExportarReporteNomina : function() {

            if(!documento.tesoreria.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }
            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/retencionNomina.php?fe_fin='+Ext.get('fe_fin').getValue()+'&fe_inicio='+Ext.get('fe_inicio').getValue()+'&nu_codigo='+Ext.get('cod_prov').getValue());

        },
                
        onExportarISLR : function() {

        if(!documento.tesoreria.formpanel.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
            return false;
        }
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/retencionISLR_XSL.php?fe_fin='+Ext.get('fe_fin').getValue()+'&fe_inicio='+Ext.get('fe_inicio').getValue()+'&nu_codigo='+Ext.get('cod_prov').getValue());

        },

        onImprimirTF : function() {

            if(!documento.tesoreria.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }
            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/retencionTF_PDF.php?fe_fin='+Ext.get('fe_fin').getValue()+'&fe_inicio='+Ext.get('fe_inicio').getValue()+'&nu_codigo='+Ext.get('cod_prov').getValue());

        },

        onImprimirRS : function() {

            if(!documento.tesoreria.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }
            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/retencionRS_PDF.php?fe_fin='+Ext.get('fe_fin').getValue()+'&fe_inicio='+Ext.get('fe_inicio').getValue()+'&nu_codigo='+Ext.get('cod_prov').getValue());

        },
                
        onImprimirFC : function() {

            if(!documento.tesoreria.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }
            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/retencionFC_PDF.php?fe_fin='+Ext.get('fe_fin').getValue()+'&fe_inicio='+Ext.get('fe_inicio').getValue()+'&nu_codigo='+Ext.get('cod_prov').getValue());

        },                

         onLimpiar: function(){
            documento.tesoreria.formpanel.getForm().reset();
        },

        getStoreCO_RETENCION:function(){
            this.store = new Ext.data.JsonStore({
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/retencion',
                root:'data',
                fields:[
                    {name: 'co_tipo_retencion'},
                    {name: 'tx_tipo_retencion'}
                    ]
            });
            return this.store;
        }

 }

Ext.onReady(documento.tesoreria.init, documento.tesoreria);

</script>
<div id="mainPrincipal"></div>
