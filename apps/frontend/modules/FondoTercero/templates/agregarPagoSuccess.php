<script type="text/javascript">
Ext.ns("fondoPago");
fondoPago.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.storeCO_CLASE_RETENCION = this.getStoreCO_CLASE_RETENCION();
this.storeCO_TIPO_RETENCION = this.getStoreCO_TIPO_RETENCION();

this.co_proveedor = new Ext.form.Hidden({
    name:'co_proveedor',
    value:this.OBJ.co_proveedor
});

this.monto_pago = new Ext.form.NumberField({
	fieldLabel:'Monto a Pagar',
	name:'monto_pago',
    id:'monto_pago',
	allowBlank:false,
	width:220
});

this.monto_disponible = new Ext.form.TextField({
	fieldLabel:'Monto Disponible',
	name:'monto_disponible',
    id:'monto_disponible',
	readOnly:true,
	style:'background:#c9c9c9;',
	width:320
});


this.co_clase_retencion = new Ext.form.ComboBox({
	fieldLabel:'Clase de Retencion',
	store: this.storeCO_CLASE_RETENCION,
	typeAhead: true,
	valueField: 'co_clase_retencion',
	displayField:'tx_clase_retencion',
	hiddenName:'co_clase_retencion',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'...',
	selectOnFocus: true,
	mode: 'local',
	width:450,
	allowBlank:false
});
this.storeCO_CLASE_RETENCION.load();

this.co_clase_retencion.on('select',function(cmb,record,index){
var list_tipo_retencion = paqueteComunJS.funcion.getJsonByObjStore({
        store:fondoEditar.main.gridPanel.getStore()
});    
        fondoPago.main.co_tipo_retencion.clearValue();
        fondoPago.main.storeCO_TIPO_RETENCION.load({
            params:{
                co_clase_retencion:record.get('co_clase_retencion'),
                json_tipo_retencion:list_tipo_retencion,
                co_proveedor:fondoPago.main.co_proveedor.getValue()
            }
        });
},this);

this.co_tipo_retencion = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Retención',
	store: this.storeCO_TIPO_RETENCION,
	typeAhead: true,
	valueField: 'co_tipo_retencion',
	displayField:'tx_tipo_retencion',
	hiddenName:'co_tipo_retencion',
	forceSelection:true,
	resizable:true,
        forceAll:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:450,
	allowBlank:false
    
});

this.co_tipo_retencion.on('select',function(cmb,record,index){

         var tipo_retencion = fondoPago.main.co_tipo_retencion.getValue();
        
        if(tipo_retencion!=4 & tipo_retencion!= 92 & tipo_retencion!= 88){

            Ext.get('monto_disponible').setStyle('background-color','#ffffff');
            fondoPago.main.monto_disponible.setReadOnly(false);

        }else{

            Ext.get('monto_disponible').setStyle('background-color','#c9c9c9');
            fondoPago.main.monto_disponible.setReadOnly(true);
            fondoPago.main.calcularDisponibilidad();
        }

},this);

this.tx_observacion = new Ext.form.TextArea({
	fieldLabel:'Observacion',
	name:'tx_observacion',
	width:450
});

this.fecha_inicio = new Ext.form.DateField({
	fieldLabel:'Fecha Inicio',
	name:'fecha_inicio',
	allowBlank:false,
	width:100,
//    minValue:this.OBJ.fe_ini,
//	maxValue:this.OBJ.fe_fin,
});

this.fecha_fin = new Ext.form.DateField({
	fieldLabel:'Fecha Fin',
	name:'fecha_fin',
	allowBlank:false,
	width:100,
//    minValue:this.OBJ.fe_ini,
//	maxValue:this.OBJ.fe_fin,
});

this.fecha_inicio.on("blur",function(){
    if(fondoPago.main.fecha_fin.getValue()!='' && fondoPago.main.fecha_inicio.getValue()!=''){
        fondoPago.main.calcularDisponibilidad();
    }
});

this.fecha_fin.on("blur",function(){
    if(fondoPago.main.fecha_fin.getValue()!='' && fondoPago.main.fecha_inicio.getValue()!=''){
        fondoPago.main.calcularDisponibilidad();
    }
});

this.fieldDatos= new Ext.form.FieldSet({
    title: 'Datos del Pago',
    items:[
           this.co_clase_retencion,
           this.co_tipo_retencion,
           // this.monto_pago,
           this.fecha_inicio,
           this.fecha_fin,
           this.monto_disponible,
           this.tx_observacion
       ]
});


this.guardar = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!fondoPago.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        
        var e = new fondoEditar.main.Registro({                     
                    co_detalle_fondo: '',
                    co_tipo_retencion:fondoPago.main.co_tipo_retencion.getValue(),
                    tx_tipo_retencion:fondoPago.main.co_tipo_retencion.lastSelectionText,
                    monto: fondoPago.main.monto_disponible.getValue(),
                    tx_observacion: fondoPago.main.tx_observacion.getValue(),
                    fe_desde: fondoPago.main.fecha_inicio.value,
                    fe_hasta: fondoPago.main.fecha_fin.value
        });

        var cant = fondoEditar.main.store_lista.getCount();
        (cant == 0) ? 0 : fondoEditar.main.store_lista.getCount() + 1;
        fondoEditar.main.store_lista.insert(cant, e);

        fondoEditar.main.gridPanel.getView().refresh();
        fondoPago.main.co_tipo_retencion.clearValue();
        fondoPago.main.co_clase_retencion.clearValue();
        fondoPago.main.monto_pago.setValue('');
        fondoPago.main.monto_disponible.setValue('');
        fondoPago.main.tx_observacion.setValue('');
        fondoPago.main.fecha_inicio.setValue('');
        fondoPago.main.fecha_fin.setValue('');
        fondoEditar.main.co_documento.setReadOnly(true);
        fondoEditar.main.tx_razon_social.setReadOnly(true);
        fondoEditar.main.tx_direccion.setReadOnly(true);        
        fondoEditar.main.tx_rif.setReadOnly(true);
        fondoEditar.main.getTotal();
        Ext.utiles.msg('Mensaje', "El Pago se agrego exitosamente");
   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        fondoPago.main.winformPanel_.close();
    }
});


this.formPanel_ = new Ext.form.FormPanel({
  //  frame:true,
    width:600,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
           this.fieldDatos]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Pago',
    modal:true,
    constrain:true,
    width:610,
  //  frame:true,
    closabled:true,
    autoHeight:true,
    items:[
    this.formPanel_        
    ],
    buttons:[
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
},
calcularDisponibilidad: function(){
      Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/FondoTercero/calcularDisponibilidad',
                params:{
                    fe_desde: fondoPago.main.fecha_inicio.value,
                    fe_hasta: fondoPago.main.fecha_fin.value,
                    co_tipo_retencion: fondoPago.main.co_tipo_retencion.getValue()                    
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        fondoPago.main.monto_disponible.setValue("");
                    }else{
                        fondoPago.main.monto_disponible.setValue(fondoPago.main.round(obj.data.total));
                    }
                }
        });
},
round: function(num, decimales = 2) {
    var signo = (num >= 0 ? 1 : -1);
    num = num * signo;
    if (decimales === 0) //con 0 decimales
        return signo * Math.round(num);
    // round(x * 10 ^ decimales)
    num = num.toString().split('e');
    num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
    // x * 10 ^ (-decimales)
    num = num.toString().split('e');
    return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
}
,getStoreCO_CLASE_RETENCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoTercero/storefkcoclaseretencion',
        root:'data',
        fields:[
            {name: 'co_clase_retencion'},
            {name: 'tx_clase_retencion'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_RETENCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/FondoTercero/storefkcotiporetencion',
        root:'data',
        fields:[
            {name: 'co_tipo_retencion'},
            {name: 'tx_tipo_retencion'}
            ]
    });
    return this.store;
}
};
Ext.onReady(fondoPago.main.init, fondoPago.main);
</script>
