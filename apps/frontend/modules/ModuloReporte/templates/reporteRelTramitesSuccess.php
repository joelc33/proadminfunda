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

   documento.tramite = {
 	init: function(){

        
        this.fe_inicio = new Ext.form.DateField({
		fieldLabel:'Fecha de inicio',
                id:'fe_inicio',
                name:'fe_inicio',
                format:'d-m-Y',
                vtype: 'daterange',
                typeAhead: true,     
                style: {width:'10%'},
                endDateField: 'fe_fin', 
                forceSelection:true,                
                selectOnFocus:true,                
                allowBlank:false
	});
        this.fe_fin = new Ext.form.DateField({
		fieldLabel:'Fecha de fin',
                id:'fe_fin',
                name:'fe_fin',
                format:'d-m-Y',
                style: {width:'10%'},
                vtype: 'daterange',
                startDateField: 'fe_inicio',
                allowBlank:false
                
	});
        
        this.nu_codigo = new Ext.form.TextField({
           fieldLabel: 'Código Proveedor',
           name: 'nu_codigo',
           id: 'nu_codigo',
           width:40,
           allowBlank:true
        });        

        this.storeCO_BANCO = this.getStoreCO_BANCO();
        
        this.tx_banco = new Ext.form.ComboBox({
	fieldLabel:'Banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'tx_banco',
        id:'co_banco',
        name:'co_banco',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,           
        allowBlank:false
        });
        this.storeCO_BANCO.load();  
        
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [this.fe_inicio, this.fe_fin, this.nu_codigo]
        });
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte de relación de trámites generados.</p></b></font><FONT SIZE=2><p>1.Seleccione el rango de fecha</p><p>2.Indique Proveedor a consultar</p><p>3.Presione el Botón Consultar</p><p></font>',
});
 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'icon-reporteVeh',
                title: 'Reporte de Relación de Trámites',
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
            if(!documento.tramite.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de búsqueda requeridos");
                return false;
            }        

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/RelTramites.php?fe_inicio='+Ext.get('fe_inicio').getValue()+'&fe_fin='+Ext.get('fe_fin').getValue()+'&nu_codigo='+Ext.get('nu_codigo').getValue());

         },

         onLimpiar: function(){
            documento.tramite.formpanel.getForm().reset();
        },getStoreCO_BANCO:function(){
            this.store = new Ext.data.JsonStore({
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoLibro/storefkidtb010banco',
                root:'data',
                fields:[
                    {name: 'co_banco'},
                    {name: 'tx_banco'}
                    ]
            });
            return this.store;
        }
 }
Ext.onReady(documento.tramite.init, documento.tramite);

</script>
<div id="mainPrincipal"></div>
