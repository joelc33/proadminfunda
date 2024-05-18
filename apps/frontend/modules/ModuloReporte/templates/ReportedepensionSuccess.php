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

   documento.Reportedepension = {
    init: function(){

    
        this.fe_inicio = new Ext.form.DateField({
        fieldLabel:'Fecha de inicio',
                id:'fe_inicio',
                name:'fe_inicio',
                format:'Y-m-d',
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
                format:'Y-m-d',
                //allowBlank:false,
                style: {width:'10%'},
                vtype: 'daterange',
                startDateField: 'fe_inicio',
                allowBlank:false
                
    });

            this.storeGRUPO_NOMINA = this.getStoreGRUPO_NOMINA();

        this.storeGRUPO_NOMINA.load(); 

        this.grupoNomina = new Ext.form.ComboBox({
            fieldLabel:'Grupo de Nomina',
            store: this.storeGRUPO_NOMINA,
            typeAhead: true,
            valueField: 'co_grupo_nomina',
            displayField:'tx_grupo_nomina',
            hiddenName:'co_grupo_nomina',
            //readOnly:(this.OBJ.co_documento!='')?true:false,
            //style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
            forceSelection:true,
            resizable:true,
            triggerAction: 'all',
            emptyText:'',
            selectOnFocus: true,
            mode: 'local',
            id: 'dep',
            width:100,
            resizable:true,
            allowBlank:false
        });



        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Ingrese Parametros',
                items: [
                    this.fe_inicio,
                    this.fe_fin,
                    this.grupoNomina
                  
                   
                    
                    
                ]
        });
        
    this.Descripcion = new Ext.Panel({
        title: 'Descripcion',
        autoWidth:true,
        border:false,
        padding : 10,
        html:'<FONT SIZE=2><p><b>Genera los Recibos de Pagos de los Pensionados.</p></b></font><FONT SIZE=2><p>1. Ingrese el Rango de Fecha</p> <p>2. Procione el Botón Consultar</p></font>',
});

this.exportar = new Ext.Button({
    text:'Exportar',
    iconCls: 'icon-descargar',
    handler:function(){
        /*
            if(!documento.recibodepago.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }        */
        
        
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/recibodepagopensionados.php?user='+<?php echo $data; ?>+"&"+documento.Reportedepension.formpanel.getForm().getValues(true));
    }
});
    this.formpanel = new Ext.form.FormPanel({
        bodyStyle: 'padding:10px',
        autoWidth:true,
        autoHeight:true,
                id: 'forma',
                iconCls:'icon-reporteVeh',
                title: 'Recibo de Pago de Pensionados',
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
                },this.exportar ]

    });


        this.formpanel.render('mainPrincipal');
     

    },
        onImprimir : function() {
   /*
            if(!documento.recibodepago.formpanel.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar correctamente los parametros de busqueda requeridos");
                return false;
            }*/
         window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/recibodepagopensionados.php?user='+<?php echo $data; ?>+"&"+documento.Reportedepension.formpanel.getForm().getValues(true));

         },

         onLimpiar: function(){
            documento.Reportedepension.formpanel.getForm().reset();
        },
        getStoreGRUPO_NOMINA:function(){
            this.store = new Ext.data.JsonStore({

                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/Gruponomina',
                root:'data',
                fields:[
                    {name: 'co_grupo_nomina'},
                    {name: 'tx_grupo_nomina'},
                    
                    {name: 'co_tp_nomina',
                        convert:function(v,r){
                            return r.tx_grupo_nomina;
                        }
                    }
                    ] 
                });
            return this.store;
        }
        
 }
Ext.onReady(documento.Reportedepension.init, documento.Reportedepension);

</script>
<div id="mainPrincipal"></div>