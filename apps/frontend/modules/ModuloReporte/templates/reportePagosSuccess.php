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

        this.storeCO_BANCO = this.getStoreCO_BANCO();
        
        this.tx_banco = new Ext.form.ComboBox({
	fieldLabel:'Banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'tx_banco',
        hiddenName:'co_banco',
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
        
        this.store_cuenta = this.getDataCuenta();
        
        this.cuenta = new Ext.form.ComboBox({
        fieldLabel : 'Cuenta',
        displayField:'tx_cuenta_bancaria',
        store: this.store_cuenta,
        typeAhead: true,
        valueField: 'co_cuenta_bancaria',
        hiddenName:'co_cuenta',
        name: 'co_cuenta',
        id: 'co_cuenta',
        triggerAction: 'all',
        emptyText:'Seleccione la Cuenta',
        selectOnFocus:true,
        mode:'local',
        width:400,
        resizable:true
        });
    
        this.tx_banco.on('beforeselect',function(cmb,record,index){
            documento.tesoreria.cuenta.clearValue();                    
            documento.tesoreria.store_cuenta.load({params:{co_banco:record.get('co_banco')}});
        },this);     
        
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [this.fe_inicio, this.fe_fin]
        });
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte de relación de Pagos Realizados.</p></b></font><FONT SIZE=2><p>1.Seleccione el rango de fecha</p></font>',
});

this.exportar = new Ext.Button({
    text:'Exportar',
    iconCls: 'icon-descargar',
    handler:function(){
        
            if(!documento.tesoreria.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }        
        
        
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/movimiento_banco_XLS.php?'+documento.tesoreria.formpanel.getForm().getValues(true));
    }
});


 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'icon-reporteVeh',
                title: 'Reporte de Pagos',
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
                },
                this.exportar]

	});


        this.formpanel.render('mainPrincipal');
     

 	},
        onImprimir : function() {
            if(!documento.tesoreria.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }        

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/RelacionPagos.php?'+documento.tesoreria.formpanel.getForm().getValues(true));

         },

         onLimpiar: function(){
            documento.tesoreria.formpanel.getForm().reset();
        },
        getDataCuenta: function(){
        var store =  new Ext.data.JsonStore({
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Tesoreria/cuenta',
                        root:'data',
                        fields: ['co_cuenta_bancaria','tx_cuenta_bancaria']
         });
        return store;
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
Ext.onReady(documento.tesoreria.init, documento.tesoreria);

</script>
<div id="mainPrincipal"></div>