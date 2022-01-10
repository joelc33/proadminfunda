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
        this.storeNU_ANIO = this.getStoreNU_ANIO();
        this.storeMES = this.getStoreMES();


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
	allowBlank : false,
        listeners:{
            select: function(){
                
                var nu_anio = this.getValue();
                
                documento.presupuesto.mes.clearValue();
                documento.presupuesto.storeMES.removeAll();      
                documento.presupuesto.storeMES.baseParams.nu_anio = nu_anio;                
                documento.presupuesto.storeMES.load();
                
            }
        }        
        });
        
     
        this.storeNU_ANIO.load();   
        
        this.mes = new Ext.form.ComboBox({
                        fieldLabel : 'Mes',
                        displayField:'tx_mes',
                        typeAhead: true,
                        store: this.storeMES,
                        valueField: 'co_mes',
                        forceSelection:true,
                        hiddenName:'co_mes',
                        name: 'co_mes',
                        id: 'co_mes',
                        triggerAction: 'all',
                        selectOnFocus:true,
                        mode:'local',
                        allowBlank : false,
                        width:200
                  });
                  
this.mes.on('select',function(cmb,record,index){
documento.presupuesto.in_periodo.setValue(false)
},this); 

this.nu_anio.on('select',function(cmb,record,index){
documento.presupuesto.in_periodo.setValue(false)
},this); 

this.in_periodo = new Ext.form.Checkbox({
	fieldLabel:'Al periodo',
	name:'in_periodo',
listeners: {
check: function() {

documento.presupuesto.mes.clearValue();
documento.presupuesto.nu_anio.clearValue();
    }
    }        
});
      
                  
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [
                   // this.fe_inicio, 
                   // this.fe_fin,
                    this.nu_anio,
                    this.mes,
                    this.in_periodo,
                    
                ]
        });
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte de Anexos de Contabilidad.</p></b></font><FONT SIZE=2><p>1.Seleccione los parametros de acuerdo a la busquedad requerida</p><p>2.Presione el Botón Consultar</p><p></font>',
});
 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'',
                title: 'Reporte de Anexos Contables',
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
        
        if(documento.presupuesto.in_periodo.getValue()==false){
        if(!documento.presupuesto.formpanel.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los paramentros de busqueda requeridos");
            return false;
        }
        }        

           window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/AnexosContabilidad.php?'+documento.presupuesto.formpanel.getForm().getValues(true));

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
getStoreMES:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/storefkMes',
        root:'data',
        fields:[
            {name: 'co_mes'},
            {name: 'tx_mes'}
            ]
    });
    return this.store;
},
         onLimpiar: function(){
            documento.presupuesto.formpanel.getForm().reset();
        }
 }

Ext.onReady(documento.presupuesto.init, documento.presupuesto);

</script>
<div id="mainPrincipal"></div>
