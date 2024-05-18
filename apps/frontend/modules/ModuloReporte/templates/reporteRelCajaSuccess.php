<script type="text/javascript">

   Ext.ns("documento");



   documento.tesoreria = {
 	init: function(){
       


        this.trimestre = new Ext.form.ComboBox({
                        fieldLabel : 'Trimestres',
                        displayField:'tx_tipo',
                        typeAhead: true,
                        store:new Ext.data.SimpleStore({
                        data :[[1,'1er Trimestre'], [2,'2do Trimestre'], [3,'3er Trimestre'], [4,'4to Trimestre']],
                        fields : ['co_tipo', 'tx_tipo']}),
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
                  
                  
this.storeTX_ANIO_FISCAL = this.getStoreTX_ANIO_FISCAL();

this.storeTX_ANIO_FISCAL.load(); 


        this.Aejecutor = new Ext.form.ComboBox({
                        fieldLabel:'Año Ejecutor',
                        store: this.storeTX_ANIO_FISCAL,
                        typeAhead: true,
                        valueField: 'tx_anio_fiscal',
                        displayField:'Aejecutor',
                        hiddenName:'tx_anio_fiscal',
                        //readOnly:(this.OBJ.co_documento!='')?true:false,
                        //style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
                        forceSelection:true,
                        resizable:true,
                        triggerAction: 'all',
                        emptyText:'',
                        selectOnFocus: true,
                        mode: 'local',
                        id: 'dep',
                        width:200,
                        resizable:true,
                        allowBlank:false
                        });
    

        
     

                  this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [
                        this.trimestre,
                        this.Aejecutor
                   
                  
                   
                    
                    
                ]
        });
        

	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte de arqueo de pagos reslizados por trimestre.</p></b></font><FONT SIZE=2><p>1.Seleccione el trimestre</p><p>2.Presione el Botón Consultar</p><p></font>',
});
 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'icon-reporteVeh',
                title: 'Reporte de Arqueo de Caja',
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



            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/arqueoCaja.php?'+documento.tesoreria.formpanel.getForm().getValues(true));

         },

         onLimpiar: function(){
            documento.tesoreria.formpanel.getForm().reset();
        },
        getStoreTX_ANIO_FISCAL:function(){
            this.store = new Ext.data.JsonStore({

                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/Anioreportecaja',
                root:'data',
                fields:[
                   
                    {name: 'tx_anio_fiscal' },
                    {name: 'Aejecutor',
                        convert:function(v,r){
                            return r.tx_anio_fiscal;
                        }
                    }
                    ] 
                });
            return this.store;
        }
        
 }
Ext.onReady(documento.tesoreria.init, documento.tesoreria);

</script>
<div id="mainPrincipal"></div>
