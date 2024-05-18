<script type="text/javascript">

   Ext.ns("documento");


   documento.HistoricoDeCargo = {
    init: function(){

       
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
    width:200
        });




        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Ingrese Parametros',
                items: [
                    this.numero_cedula,
                  
                   
                    
                    
                ]
        });
        
    this.Descripcion = new Ext.Panel({
        title: 'Descripcion',
        autoWidth:true,
        border:false,
        padding : 10,
        html:'<FONT SIZE=2><p><b>Muestra un Reporte del Historico de Cargos del Trabajador.</p></b></font><FONT SIZE=2><p>1. Ingrese el Numero de Cedula del Trabajador</p> <p>2. Procione el Botón Consultar</p></font>',
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
        
        
        window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/historicodecargo.php?'+documento.HistoricoDeCargo.formpanel.getForm().getValues(true));
    }
});
    this.formpanel = new Ext.form.FormPanel({
        bodyStyle: 'padding:10px',
        autoWidth:true,
        autoHeight:true,
                id: 'forma',
                iconCls:'icon-reporteVeh',
                title: 'Historico de Cargo',
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
         window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/historicodecargo.php?'+documento.HistoricoDeCargo.formpanel.getForm().getValues(true));

         },

         onLimpiar: function(){
            documento.HistoricoDeCargo.formpanel.getForm().reset();
        }
      
 }
Ext.onReady(documento.HistoricoDeCargo.init, documento.HistoricoDeCargo);

</script>
<div id="mainPrincipal"></div>
