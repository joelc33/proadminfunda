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

   documento.recibodepago = {
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


         this.numero_cedula = new Ext.form.TextField({
    fieldLabel:'N° de Cedula',
    name:'ci',
        maskRe: /[0-9]/,
    value:'',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'',
    selectOnFocus: true,
    mode: 'local',
    id: 'ced',
    width:400
        });


this.storeNU_CODIGO = this.getStoreNU_CODIGO();

this.storeNU_CODIGO.load(); 

this.dependencia = new Ext.form.ComboBox({
    fieldLabel:'Dependencia',
    store: this.storeNU_CODIGO,
    typeAhead: true,
    valueField: 'nu_codigo',
    displayField:'dependecia',
    hiddenName:'nu_codigo',
    //readOnly:(this.OBJ.co_documento!='')?true:false,
    //style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'',
    selectOnFocus: true,
    mode: 'local',
    id: 'dep',
    width:400,
    resizable:true,
    allowBlank:false
});

this.tipobusqueda = new Ext.form.ComboBox({
                        fieldLabel : 'Tipo de Busqueda',
                        displayField:'tx_tipo',
                        typeAhead: true,
                        store:new Ext.data.SimpleStore({
                        data : [[1,'Individual'],[2,'Masivo']],
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


                     
//--------------------------------------------------FUNCION QUE HABILITA Y DESHABILITA LOS CAMPOS DE CEDULA Y DEPENDENCIA-----------------------------------------------------\\
        documento.recibodepago.tipobusqueda.on('select',function(){

            var prueba = documento.recibodepago.tipobusqueda.getValue()
            if (prueba == 1) {
                documento.recibodepago.dependencia.setReadOnly(true);
                documento.recibodepago.numero_cedula.setReadOnly(false);
                documento.recibodepago.dependencia.setValue();
            } else if (prueba == 2) {
                documento.recibodepago.numero_cedula.setValue();
                documento.recibodepago.numero_cedula.setReadOnly(true);
                documento.recibodepago.dependencia.setReadOnly(false);
            }
        });
    



        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [
                    this.fe_inicio, 
                    this.fe_fin,
                    this.tipobusqueda, 
                    this.numero_cedula,
                    this.dependencia
                   
                    
                    
                ]
        });
        
    this.Descripcion = new Ext.Panel({
        title: 'Descripcion',
        autoWidth:true,
        border:false,
        padding : 10,
        html:'<FONT SIZE=2><p><b>Muestra un Reporte del Recibo de Pago del Trabajdor.</p></b></font><FONT SIZE=2><p>1.Seleccione el Rango de Fecha</p><p>2.Seleccione el Tipo de Busqueda que Desea Realizar</p><p>3.Ingrese el Numero de Cedula del trabajador o Seleccione la Dependencia a Consultar</p><p>4.Presione el Botón Consultar</p><p></font>',
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
        
        
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/recibodepagotrabajador.php?'+documento.recibodepago.formpanel.getForm().getValues(true));
    }
});
    this.formpanel = new Ext.form.FormPanel({
        bodyStyle: 'padding:10px',
        autoWidth:true,
        autoHeight:true,
                id: 'forma',
                iconCls:'icon-reporteVeh',
                title: 'Reporte de Recibo de Pago ',
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
         window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/recibodepagotrabajador.php?'+documento.recibodepago.formpanel.getForm().getValues(true));

         },

         onLimpiar: function(){
            documento.recibodepago.formpanel.getForm().reset();
        },
        getStoreNU_CODIGO:function(){
            this.store = new Ext.data.JsonStore({

                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/rrhhDependencia',
                root:'data',
                fields:[
                    {name: 'nu_codigo'},
                    {name: 'tx_dependecia' },
                    {name: 'dependecia',
                        convert:function(v,r){
                            return r.nu_codigo+' - '+r.tx_dependecia;
                        }
                    }
                    ] 
                });
            return this.store;
        }
 }
Ext.onReady(documento.recibodepago.init, documento.recibodepago);

</script>
<div id="mainPrincipal"></div>
