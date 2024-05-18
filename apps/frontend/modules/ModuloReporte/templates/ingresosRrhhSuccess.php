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

   documento.rrhh = {
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
    this.tipoOrden = new Ext.form.ComboBox({
                        fieldLabel : 'Tipo de Ingreso',
                        displayField:'tx_tipo',
                        typeAhead: true,
                        store:new Ext.data.SimpleStore({
                        data : [[1, 'Fecha de Tramite'],[2, 'Fecha de Ingreso']],
                        fields : ['co_tipo', 'tx_tipo']}),
                        valueField: 'co_tipo',
                        forceSelection:true,
                        hiddenName:'co_tipo',
                        name: 'co_tipo',
                        id: 'co_tipo',
                        triggerAction: 'all',
                        selectOnFocus:true,
                        mode:'local',
                        allowBlank:false,
                        width:200
                  });    
       
    
        
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [this.fe_inicio, this.fe_fin, this.tipoOrden]
        });
        
    this.Descripcion = new Ext.Panel({
        title: 'Descripcion',
        autoWidth:true,
        border:false,
        padding : 10,
        html:'<FONT SIZE=2><p><b>Muestra un reporte de ingresos por lapsos de tiempos.</p></b></font><FONT SIZE=2><p>1.Seleccione el rango de fecha</p><p>2.Seleccione tipo de ingreso</p><p>3.Presione el Botón Consultar</p></font>',
        });

this.exportar = new Ext.Button({
    text:'Exportar',
    iconCls: 'icon-descargar',
    handler:function(){
        
            if(!documento.rrhh.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }        
        
        
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/ingresoRrhh_XLS.php?'+documento.rrhh.formpanel.getForm().getValues(true));
    }
});

    this.formpanel = new Ext.form.FormPanel({
        bodyStyle: 'padding:10px',
        autoWidth:true,
        autoHeight:true,
                id: 'forma',
                iconCls:'icon-reporteVeh',
                title: 'Reporte de Ingresos',
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
            if(!documento.rrhh.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/ingresosRrhh.php?'+documento.rrhh.formpanel.getForm().getValues(true));

         },

         onLimpiar: function(){
            documento.rrhh.formpanel.getForm().reset();
        }
 }
Ext.onReady(documento.rrhh.init, documento.rrhh);

</script>
<div id="mainPrincipal"></div>
