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

//<Stores de fk>
this.storeCO_TIPO_SOLICITUD = this.getStoreCO_TIPO_SOLICITUD();
//<Stores de fk>
this.storeNU_ANIO = this.getStoreNU_ANIO();
//<Stores de fk>
this.storeCO_RUTA = this.getStoreCO_RUTA();
//<Stores de fk> 

this.co_solicitud = new Ext.form.NumberField({
	fieldLabel:'Solicitud',
	name:'co_solicitud',
    width:100,
	allowBlank:true
});

this.co_tipo_solicitud = new Ext.form.ComboBox({
	fieldLabel:'Tramite',
	store: this.storeCO_TIPO_SOLICITUD,
	typeAhead: true,
	valueField: 'co_tipo_solicitud',
	displayField:'tipo_solicitud',
	hiddenName:'co_tipo_solicitud',
	//readOnly:(this.OBJ.co_tipo_solicitud!='')?true:false,
	//style:(this.main.OBJ.co_tipo_solicitud!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false,
	listeners:{
		select: function(){
			documento.tesoreria.co_ruta.clearValue();
			documento.tesoreria.storeCO_RUTA.load({
				params: {
					tipo_solicitud:this.getValue()
				}
			})
		}
  	}
});
this.storeCO_TIPO_SOLICITUD.load();

this.co_ruta = new Ext.form.ComboBox({
	fieldLabel:'Ruta',
	store: this.storeCO_RUTA,
	typeAhead: true,
	valueField: 'co_proceso',
	displayField:'proceso',
	hiddenName:'co_proceso',
	//readOnly:(this.OBJ.co_proceso!='')?true:false,
	//style:(this.main.OBJ.co_proceso!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false
});

this.nu_anio = new Ext.form.ComboBox({
    fieldLabel:'Año Fiscal',
    store: this.storeNU_ANIO,
    typeAhead: true,
    id: 'co_anio_fiscal',
    name: 'co_anio_fiscal',
    valueField: 'co_anio_fiscal',
    displayField:'tx_anio_fiscal',
    hiddenName:'co_anio_fiscal',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    selectOnFocus: true,
    mode: 'local',
    width:100,
    resizable:true
});

this.storeNU_ANIO.load();
        
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [
                    this.co_solicitud,
                    this.co_tipo_solicitud,
                    this.co_ruta,
                    this.nu_anio
                    ]
        });
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Proceso para regenerar documenos.</p></b></font><FONT SIZE=2><p>1.Seleccione el Tramite.</p><p>2.Seleccione el Proceso.</p><p>3.Seleccione el Ejercicio Fiscal.</p><p>4.Presione el Botón Generar.</p><p></font>',
});
 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'icon-reporteVeh',
                title: 'Regenerar Documentos',
                url: '',
                defaults:{style: 'margin-bottom:10px'},
		items:[
                
                        this.tipo_planilla,this.Descripcion

                ],
                buttonAlign:'center',
                buttons:[
                {
                    text:'Generar Individual',  // Generar la impresión en pdf
                    iconCls:'icon-pdf',
                    handler: this.onImprimir 
                },
                {
                    text:'Generar Masivo',  // Generar la impresión en pdf
                    iconCls:'icon-pdf',
                    handler: this.onImprimirMasivo
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

            if(documento.tesoreria.co_solicitud.getValue() == 0){
                Ext.Msg.alert("Alerta","Debe colocar un Numero de Solicitud.");
                return false;
            }

            if(!documento.tesoreria.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/GenerarPDF.php?'+documento.tesoreria.formpanel.getForm().getValues(true));

         },
         onImprimirMasivo : function() {
   
        if(!documento.tesoreria.formpanel.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
            return false;
        }
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/GenerarPDFMasivo.php?'+documento.tesoreria.formpanel.getForm().getValues(true));

        },

         onLimpiar: function(){
            documento.tesoreria.formpanel.getForm().reset();
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
        },getStoreCO_RUTA:function(){
            this.store = new Ext.data.JsonStore({
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/storefkcoruta',
                root:'data',
                fields:[
                    {name: 'co_proceso'},
                    {name: 'tx_proceso'},
                    {name: 'proceso',
                        convert:function(v,r){
                            return r.tx_proceso.toUpperCase();
                        }
                    }
                    ]
            });
            return this.store;
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
        }
 }
Ext.onReady(documento.tesoreria.init, documento.tesoreria);

</script>
<div id="mainPrincipal"></div>
