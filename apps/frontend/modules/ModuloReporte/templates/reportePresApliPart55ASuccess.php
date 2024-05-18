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

        this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();
        this.storeNU_ANIO = this.getStoreNU_ANIO();  
        this.storeCO_APLICACION = this.getStoreCO_APLICACION();


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

        
        this.tx_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Ejecutor',
	store: this.storeCO_EJECUTOR,
	typeAhead: true,
        id: 'ejecutor',
        name: 'nu_ejecutor',
	valueField: 'id',
	displayField:'ejecutor',
	hiddenName:'co_ejecutor',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
        });   
        
        
        this.storeCO_EJECUTOR.load();        
        
//        this.tx_ejecutor.on('beforeselect',function(cmb,record,index){
//            documento.presupuesto.id_tb139_aplicacion.clearValue();                    
//            documento.presupuesto.storeCO_APLICACION.load({params:{co_ejecutor:record.get('id')}});
//        },this); 
        
        this.id_tb139_aplicacion = new Ext.form.ComboBox({
	fieldLabel:'Aplicacion',
	store: this.storeCO_APLICACION,
	typeAhead: true,
        name: 'co_aplicacion',
	valueField: 'co_aplicacion',
	displayField:'aplicacion',
	hiddenName:'co_aplicacion',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
        });
        this.storeCO_APLICACION.load();
                  
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
                items: [this.fe_inicio, this.fe_fin,
                        this.nu_anio,this.tx_ejecutor, this.id_tb139_aplicacion]
        });     
     
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte de la ejecución presupuestaria por Aplicación y Partidas.</p></b></font><FONT SIZE=2><p>1.Seleccione los parametros de acuerdo a la busquedad requerida</p><p>2.Presione el Botón Consultar</p><p></font>',
});
 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'',
                title: 'Reporte de Presupuesto por Aplicación y Partidas',
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
        
        if(!documento.presupuesto.formpanel.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los paramentros de busqueda requeridos");
            return false;
        }

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/presupuestoPartidasAplicacion.php?'+documento.presupuesto.formpanel.getForm().getValues(true));

         },

         onLimpiar: function(){
            documento.presupuesto.formpanel.getForm().reset();
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
    },getStoreCO_APLICACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/storefkidtb139aplicacion',
        root:'data',
        fields:[
            {name: 'co_aplicacion'},
            {
				name: 'aplicacion',
				convert: function(v, r) {
						return r.tx_tip_aplicacion + ' - ' + r.tx_aplicacion;
				}
		    }
            ]
    });
    return this.store;
}
    
,getStoreCO_SECTOR:function(){
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
},getStoreCO_EJECUTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Asignacionpresupuesto/storefkidtb082ejecutor',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'nu_ejecutor'},
            {name: 'de_ejecutor'},
            {name: 'ejecutor',
                convert:function(v,r){
                    return r.nu_ejecutor+' - '+r.de_ejecutor;
                }
            }
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
