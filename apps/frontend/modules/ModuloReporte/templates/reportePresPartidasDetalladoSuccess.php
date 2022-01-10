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
        this.storeCO_APLICACION = this.getStoreCO_APLICACION();
        this.storeCO_DECRETO = this.getStoreCO_DECRETO();
        
        this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

        this.co_ejecutor = new Ext.form.ComboBox({
                fieldLabel:'Ente Ejecutor',
                store: this.storeCO_EJECUTOR,
                typeAhead: true,
                valueField: 'id',
                id:'co_ejecutor',
                displayField:'ejecutor',
                hiddenName:'co_ejecutor',
                forceSelection:true,
                resizable:true,
                triggerAction: 'all',
                selectOnFocus: true,
                mode: 'local',
                width:900,
                listeners: {
                    getSelectedIndex: function() {             
                        var v = this.getValue();
                        var r = this.findRecord(this.valueField || this.displayField, v);
                        return(this.storeCO_EJECUTOR.indexOf(r));
                     },
                select: function(){
                    documento.presupuesto.storeCO_DECRETO.load({
                        params:{
                            co_ejecutor:this.getValue()
                        }
                    });

                    documento.presupuesto.storeCO_APLICACION.load({
                        params:{
                            co_ejecutor:this.getValue()
                        }
                    });             
                }             
                }
        });
        this.storeCO_EJECUTOR.load();
        
        this.co_aplicacion = new Ext.form.ComboBox({
                fieldLabel:'Aplicacion',
                store: this.storeCO_APLICACION,
                typeAhead: true,
                valueField: 'co_aplicacion',
                displayField:'aplicacion',
                id:'tip_apl',
                hiddenName:'tip_apl',
                forceSelection:true,
                resizable:true,
                triggerAction: 'all',
                emptyText:'Seleccione Aplicacion',
                selectOnFocus: true,
                mode: 'local',
                width:700,
                allowBlank:false,
                listeners:{
                select: function(){
                    documento.presupuesto.storeCO_DECRETO.load({
                        params:{
                            aplicacion:this.getValue(),
                            co_ejecutor: documento.presupuesto.co_ejecutor.getValue()
                        }
                    });
                }
            }
        });

        this.co_decreto = new Ext.form.ComboBox({
                fieldLabel:'Decreto',
                store: this.storeCO_DECRETO,
                typeAhead: true,
                valueField: 'nu_fi',
                displayField:'nu_fi',
                hiddenName:'nu_fi',
                id:'nu_fi',
                //readOnly:(this.OBJ.co_proveedor!='')?true:false,
                //style:(this.OBJ.co_proveedor!='')?'background:#c9c9c9;':'',
                forceSelection:true,
                resizable:true,
                triggerAction: 'all',
                emptyText:'Seleccione Decreto',
                selectOnFocus: true,
                mode: 'local',
                width:700,
                allowBlank:false
        });
      
       
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

        
        
     
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [this.co_ejecutor,
                        this.co_aplicacion,
                        this.co_decreto,
                        this.fe_inicio, 
                        this.fe_fin,
                        this.nu_anio]
        });     
     
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte de la ejecución presupuestaria por Area Estrátegica y Ambitos.</p></b></font><FONT SIZE=2><p>1.Seleccione los parametros de acuerdo a la busquedad requerida</p><p>2.Presione el Botón Consultar</p><p></font>',
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
//                {
//                    text:'Consultar',  // Generar la impresión en pdf
//                    iconCls:'icon-buscar',
//                    handler: this.onImprimir 
//                }, 
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
            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/reporte_partidas_detallado_xls.php?'+documento.presupuesto.formpanel.getForm().getValues(true));
        },         
        onImprimir : function() {
        
        if(!documento.presupuesto.formpanel.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los paramentros de busqueda requeridos");
            return false;
        }

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/presupuestoPartidasDetallado.php?'+documento.presupuesto.formpanel.getForm().getValues(true));

         },

         onLimpiar: function(){
            documento.presupuesto.formpanel.getForm().reset();
        },
        getStoreCO_EJECUTOR:function(){
            this.store = new Ext.data.JsonStore({
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoejecutor',
                root:'data',
                fields:[
                    {name: 'id'},
                    {name: 'de_ejecutor'},
                    {name: 'ejecutor',
                        convert:function(v,r){
                            return r.nu_ejecutor+' - '+r.de_ejecutor;
                        }
                    }
                    ]
            });
            return this.store;
        }
        ,getStoreCO_APLICACION:function(){
            this.store = new Ext.data.JsonStore({
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storefkcoaplicacion',
                root:'data',
                fields:[
                    {name: 'co_aplicacion'},
                    {name: 'nu_anio_fiscal'},
                    {name: 'tx_tip_aplicacion'},
                    {name: 'tx_aplicacion'},
                    {name: 'tx_genera_cheque'},
                    {name: 'tx_tip_gasto'},
                    {name: 'aplicacion',
                        convert:function(v,r){
                            return r.tx_tip_aplicacion+' - '+r.tx_aplicacion;
                        }
                    }
                    ]
            });
            return this.store;
        }
        ,getStoreCO_DECRETO:function(){
            this.store = new Ext.data.JsonStore({
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storefkcodecreto',
                root:'data',
                fields:[
                    {name: 'nu_fi'},
                    ]
            });
            return this.store;
        }

 }

Ext.onReady(documento.presupuesto.init, documento.presupuesto);

</script>
<div id="mainPrincipal"></div>
