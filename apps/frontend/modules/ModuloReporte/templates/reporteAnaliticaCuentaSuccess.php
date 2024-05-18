<script type="text/javascript">

   Ext.ns("documento");


   documento.contabilidad = {
 	init: function(){
        this.storeNU_ANIO = this.getStoreNU_ANIO();
        this.storeMES = this.getStoreMES();

        this.inicio = new Ext.form.NumberField({
           fieldLabel: 'Nivel Inicial',
           name: 'nivel_inicial',
           id: 'nivel_inicial',
           minValue:1,
           maxValue:9,
           width:40,
           allowBlank:false
        });
        
        this.cant = new Ext.form.NumberField({
           fieldLabel: 'Cantidad Niveles',
           name: 'cant_nivel',
           id: 'cant_nivel',
           minValue:1,
           maxValue:9,
           width:40,
           allowBlank:false
        });
        
        
        this.cuenta = new Ext.form.TextField({
           fieldLabel: ' Nº Cuenta Contable',
           name: 'cuenta',
           id: 'cuenta',
           minLength:3,
           maxLength:20,
           width:120,
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
                
                documento.contabilidad.mes.clearValue();
                documento.contabilidad.storeMES.removeAll();      
                documento.contabilidad.storeMES.baseParams.nu_anio = nu_anio;                
                documento.contabilidad.storeMES.load();
                
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
documento.contabilidad.in_periodo.setValue(false)
},this); 

this.nu_anio.on('select',function(cmb,record,index){
documento.contabilidad.in_periodo.setValue(false)
},this); 

this.in_periodo = new Ext.form.Checkbox({
	fieldLabel:'Al periodo',
	name:'in_periodo',
listeners: {
check: function() {

documento.contabilidad.mes.clearValue();
documento.contabilidad.nu_anio.clearValue();
    }
    }        
});        
        
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [this.inicio, this.cant,this.cuenta,
                    this.nu_anio,
                    this.mes,
                    this.in_periodo]
        });
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte detallado de una cuenta contable especifica.</p></b></font><FONT SIZE=2><p>1.Seleccione el nivel inicial (el minimo valor para nivel inicial es 5 y el maximo 9)</p><p>2.Seleccione cantidad de niveles de verificación (el minimo valor para cantidad de niveles de verificación es 5 y el maximo 9)</p><p>3.Indique la cuenta contable sin puntos</p><p>4.Presione el Botón Consultar</p><p></font>',
});

this.exportar = new Ext.Button({
    text:'Exportar',
    iconCls: 'icon-descargar',
    handler:function(){
        
        if(documento.contabilidad.in_periodo.getValue()==false){
        if(!documento.contabilidad.formpanel.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los paramentros de busqueda requeridos");
            return false;
        }
        }else{
        if(documento.contabilidad.inicio.getValue()==''){
            Ext.Msg.alert("Alerta","Debe ingresar el nivel inicial");
            return false;
        }    
        if(documento.contabilidad.cant.getValue()==''){
            Ext.Msg.alert("Alerta","Debe ingresar la cantidad de niveles");
            return false;
        }           
        
        if(documento.contabilidad.cuenta.getValue()==''){
            Ext.Msg.alert("Alerta","Debe ingresar la cuenta contable");
            return false;
        }                 
        }
        
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/AnaliticaCuentas_XLS.php?'+documento.contabilidad.formpanel.getForm().getValues(true));
    }
});
 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'icon-reporteVeh',
                title: 'Reporte Analitica de Cuentas Contables',
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
                },this.exportar]

	});


        this.formpanel.render('mainPrincipal');
     

 	},
        onImprimir : function() {
        if(documento.contabilidad.in_periodo.getValue()==false){
        if(!documento.contabilidad.formpanel.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los paramentros de busqueda requeridos");
            return false;
        }
        }else{
        if(documento.contabilidad.inicio.getValue()==''){
            Ext.Msg.alert("Alerta","Debe ingresar el nivel inicial");
            return false;
        }    
        if(documento.contabilidad.cant.getValue()==''){
            Ext.Msg.alert("Alerta","Debe ingresar la cantidad de niveles");
            return false;
        }           
        
        if(documento.contabilidad.cuenta.getValue()==''){
            Ext.Msg.alert("Alerta","Debe ingresar la cuenta contable");
            return false;
        }                 
        }

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/AnaliticaCuentas.php?'+documento.contabilidad.formpanel.getForm().getValues(true));

         },

         onLimpiar: function(){
            documento.contabilidad.formpanel.getForm().reset();
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
}                

 }

Ext.onReady(documento.contabilidad.init, documento.contabilidad);

</script>
<div id="mainPrincipal"></div>
