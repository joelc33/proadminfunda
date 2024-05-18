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
    
   documento.presupuesto = {
 	init: function(){

        this.storeCO_SECTOR = this.getStoreCO_SECTOR();
        this.storeNU_ANIO = this.getStoreNU_ANIO();
        this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();
        this.storeCO_PAC = this.getStoreCO_PAC();
        this.storeCO_AE = this.getStoreCO_AE();
        this.storeCO_PART = this.getStoreCO_PART();
        
        
        this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});


        this.fe_inicio = new Ext.form.DateField({
		fieldLabel:'Fecha de inicio',
                id:'fe_inicio',
                name:'fe_inicio',
                format:'d-m-Y',
                vtype: 'daterange',
                style: {width:'10%'},
                endDateField: 'fe_fin'
                
	});
        this.fe_fin = new Ext.form.DateField({
		fieldLabel:'Fecha de fin',
                id:'fe_fin',
                name:'fe_fin',
                format:'d-m-Y',
                style: {width:'10%'},
                vtype: 'daterange',
                startDateField: 'fe_inicio'
                
	});
        
        this.nu_anio = new Ext.form.Hidden({
            name:'co_anio_fiscal',
            id:'nu_anio',
            value:this.OBJ.co_anio_fiscal
        });


        this.periodo = new Ext.form.ComboBox({
                        fieldLabel : 'Periodo',
                        displayField:'tx_periodo',
                        typeAhead: true,
                        store:new Ext.data.SimpleStore({
                        data : [[1, 'PRIMER TRIMESTRE'],[2, 'SEGUNDO TRIMESTRE'],[3, 'TERCER TRIMESTRE'],[4, 'CUARTO TRIMESTRE']],
                        fields : ['co_periodo', 'tx_periodo']
                                                       }),
                        valueField: 'co_periodo',
                        forceSelection:true,
                        hiddenName:'co_periodo',
                        name: 'co_periodo',
                        id: 'co_periodo',
                        triggerAction: 'all',
                        selectOnFocus:true,
                        mode:'local',
                        width:200
        });
                  
//        this.nu_anio = new Ext.form.ComboBox({
//	fieldLabel:'Año Fiscal',
//	store: this.storeNU_ANIO,
//	typeAhead: true,
//        id: 'co_anio_fiscal',
//        name: 'co_anio_fiscal',
//	valueField: 'co_anio_fiscal',
//	displayField:'tx_anio_fiscal',
//	hiddenName:'co_anio_fiscal',
//	forceSelection:true,
//	resizable:true,
//	triggerAction: 'all',
//	selectOnFocus: true,
//	mode: 'local',
//	width:100,
//	resizable:true
//        });
//        
//     
//        this.storeNU_ANIO.load();                  
                  
        this.tx_sector = new Ext.form.ComboBox({
	fieldLabel:'Sector',
	store: this.storeCO_SECTOR,
	typeAhead: true,
        id: 'sector',
        name: 'nu_sector',
	valueField: 'id',
	displayField:'de_sector',
	hiddenName:'nu_sector',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true
        });
        
     
        this.storeCO_SECTOR.load();
        
        this.tx_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Ejecutor',
        id: 'ejecutor',
        name:'nu_ejecutor',    
	displayField:'de_ejecutor',
	hiddenName:'nu_ejecutor', 
	valueField: 'id',        
	store: this.storeCO_EJECUTOR,
	typeAhead: true,
        forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true
        });   
        
        this.tx_ejecutor.on('beforeselect',function(cmb,record,index){
            documento.presupuesto.tx_pac.clearValue();                    
            documento.presupuesto.storeCO_PAC.load({params:{co_ejecutor:record.get('id')}});
        },this); 
        
        
        this.storeCO_EJECUTOR.load();        
      
        this.tx_pac = new Ext.form.ComboBox({  
	fieldLabel:'Proyecto/Acción Centralizada',
	store: this.storeCO_PAC,
	typeAhead: true,
	valueField: 'id',
        id: 'proyecto_ac',        
	displayField:'de_proyecto_ac',
	hiddenName:'nu_proyecto_ac',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true
        }); 
        
        this.tx_ae = new Ext.form.ComboBox({
	fieldLabel:'Acción Especifica',
	store: this.storeCO_AE,
	typeAhead: true,
	valueField: 'id',
        id: 'accion_especifica',         
	displayField:'de_accion_especifica',
	hiddenName:'nu_accion_especifica',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true
        }); 
        
        this.tx_pac.on('beforeselect',function(cmb,record,index){
            documento.presupuesto.tx_ae.clearValue();                    
            documento.presupuesto.storeCO_AE.load({params:{co_ae:record.get('id')}});
        },this); 
        
        this.storeCO_PAC.load();         
    
        this.tx_partidas = new Ext.form.ComboBox({
	fieldLabel:'Partidas',
	store: this.storeCO_PART,
	typeAhead: true,
	valueField: 'id',
        id: 'partida',          
	displayField:'nu_partida',
	hiddenName:'de_partida',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true
        });    
        
        this.tx_ae.on('beforeselect',function(cmb,record,index){
            documento.presupuesto.tx_partidas.clearValue();                    
            documento.presupuesto.storeCO_PART.load({params:{co_partida:record.get('id')}});
        },this); 
        
        this.storeCO_AE.load();  
      
      
        this.tipo = new Ext.form.ComboBox({
                  fieldLabel : 'Tipo',
                  displayField:'tx_tipo',
                  typeAhead: true,
                  store:new Ext.data.SimpleStore({
                  data : [[1, 'RESUMEN POR SECTOR'],[2, 'DETALLADO POR PARTIDA']],
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
                items: [this.fe_inicio, this.fe_fin,
                        this.nu_anio]
        });
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte de la ejecución presupuestaria por Sectores.</p></b></font><FONT SIZE=2><p>1.Seleccione los parametros de acuerdo a la busquedad requerida</p><p>2.Presione el Botón Consultar</p><p></font>',
});
 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'',
                title: 'Reporte de Presupuesto por Sectores',
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
                    text:'Exportar Excel',  // Generar la impresión en pdf
                    iconCls:'icon-libro',
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
        onExportar : function() {
            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/reporte_ambito_xls.php?'+documento.presupuesto.formpanel.getForm().getValues(true));
        },        
        onImprimir : function() {
        
        if(!documento.presupuesto.formpanel.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los paramentros de busqueda requeridos");
            return false;
        }

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/presupuestoAmbito.php?'+documento.presupuesto.formpanel.getForm().getValues(true));

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
},getStoreNU_ANIO:function(){
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

 }

Ext.onReady(documento.presupuesto.init, documento.presupuesto);

</script>
<div id="mainPrincipal"></div>
