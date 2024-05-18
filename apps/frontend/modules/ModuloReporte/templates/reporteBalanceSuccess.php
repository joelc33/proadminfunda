<script type="text/javascript">

   Ext.ns("documento");


   documento.contabilidad = {
 	init: function(){


        this.inicio = new Ext.form.NumberField({
           fieldLabel: 'Nivel Inicial',
           name: 'nivel_inicial',
           id: 'nivel_inicial',
           width:40,
           allowBlank:false
        });
        
        this.cant = new Ext.form.NumberField({
           fieldLabel: 'Cantidad Niveles',
           name: 'cant_nivel',
           id: 'cant_nivel',
           width:40,
           allowBlank:false
        });
        this.categoria = new Ext.form.ComboBox({
                        fieldLabel : 'Grupo de Cuentas',
                        displayField:'tx_cuenta',
                        typeAhead: true,
                        store:new Ext.data.SimpleStore({
                        data : [[1, 'ACTIVOS'],[2, 'PASIVOS'],[3, 'RECURSOS'],[4, 'EGRESOS'],[5, 'ESTADOS DE RESULTADO'],[6, 'PATRIMONIOS'],[7, 'CUENTA DE ORDEN']],
                        fields : ['co_cuenta', 'tx_cuenta']
                                                       }),
                        valueField: 'co_cuenta',
                        forceSelection:true,
                        hiddenName:'co_cuenta',
                        name: 'co_cuenta',
                        id: 'co_cuenta',
                        triggerAction: 'all',
                        selectOnFocus:true,
                        mode:'local',
                        width:200
                  });
        
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [this.inicio, this.cant, this.categoria]
        });
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte detallado de los balances de comprobación.</p></b></font><FONT SIZE=2><p>1.Seleccione el nivel inicial</p><p>2.Seleccione cantidad de niveles de verificación</p><p>3.Seleccione Rango de Partida</p><p>4.Presione el Botón Consultar</p><p></font>',
});
 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'icon-reporteVeh',
                title: 'Reporte de Balance de Comprobación',
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
            if(!documento.contabilidad.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de búsqueda requeridos");
                return false;
            }          

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/BalanceComprobacion.php?'+documento.contabilidad.formpanel.getForm().getValues(true));

         },

         onLimpiar: function(){
            documento.contabilidad.formpanel.getForm().reset();
        }

 }

Ext.onReady(documento.contabilidad.init, documento.contabilidad);

</script>
<div id="mainPrincipal"></div>
