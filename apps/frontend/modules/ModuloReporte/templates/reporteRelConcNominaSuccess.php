<script type="text/javascript">

   Ext.ns("documento");
   documento.tesoreria = {
 	init: function(){       
        this.mes = new Ext.form.ComboBox({
                        fieldLabel : 'Mes',
                        displayField:'tx_mes',
                        typeAhead: true,
                        store:new Ext.data.SimpleStore({
                        data : [[1, 'ENERO'],[2, 'FEBRERO'],[3, 'MARZO'],[4, 'ABRIL'],[5, 'MAYO'],[6, 'JUNIO'],[7, 'JULIO'],[8, 'AGOSTO'],[9, 'SEPTIMBRE'],[10, 'OCTUBRE'],[11, 'NOVIEMBRE'],[12, 'DICIEMBRE']],
                        fields : ['co_mes', 'tx_mes']}),
                        valueField: 'co_mes',
                        forceSelection:true,
                        hiddenName:'co_mes',
                        name: 'co_mes',
                        id: 'co_mes',
                        triggerAction: 'all',
                        selectOnFocus:true,
                        mode:'local',
                        width:200,           
                        allowBlank:false
                  });
        
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [this.mes]
        });
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte relación detallada de los Conceptos de la Nomina.</p></b></font><FONT SIZE=2><p>1.Seleccione el mes de la relación </p><p>2.Presione el Botón Consultar</p></font>',
});
 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'icon-reporteVeh',
                title: 'Reporte de Relacion de Conceptos Nomina',
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

            if(!documento.tesoreria.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }
            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/RelConcNomina.php?mes='+Ext.get('co_mes').getValue());

         },

         onLimpiar: function(){
            documento.tesoreria.formpanel.getForm().reset();
        }

 }

Ext.onReady(documento.tesoreria.init, documento.tesoreria);

</script>
<div id="mainPrincipal"></div>
