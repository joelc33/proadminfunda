<script type="text/javascript">
Ext.ns("fondoPago");
fondoPago.main = {
    
co_factura_retencion: [],
    
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.storeCO_CLASE_RETENCION = this.getStoreCO_CLASE_RETENCION();
this.storeCO_TIPO_RETENCION = this.getStoreCO_TIPO_RETENCION();
 this.store_banco = this.getDataBanco();
 this.store_cuenta = this.getDataCuenta();
 this.storeR = fondoPago.main.fgetR();

this.co_proveedor = new Ext.form.Hidden({
    name:'co_proveedor',
    value:this.OBJ.co_proveedor
});

this.banco = new Ext.form.ComboBox({
    fieldLabel : 'Banco',
    displayField:'tx_banco',
    store: this.store_banco,
    typeAhead: true,
    valueField: 'co_banco',
    hiddenName:'Pagos[co_banco]',
    name: 'co_banco',
    id: 'co_banco',
    triggerAction: 'all',
    emptyText:'Seleccione el Banco',
    selectOnFocus:true,
    width:450,
    resizable:true
});

this.cuenta = new Ext.form.ComboBox({
    fieldLabel : 'Cuenta',
    displayField:'tx_cuenta_bancaria',
    store: this.store_cuenta,
    typeAhead: true,
    valueField: 'co_cuenta_bancaria',
    hiddenName:'Pagos[co_cuenta]',
    name: 'co_cuenta',
    id: 'co_cuenta',
    triggerAction: 'all',
    emptyText:'Seleccione la Cuenta',
    selectOnFocus:true,
    mode:'local',
    width:450,
    resizable:true
});

this.monto_pago = new Ext.form.NumberField({
	fieldLabel:'Monto a Pagar',
	name:'monto_pago',
    id:'monto_pago',
	allowBlank:false,
	width:220
});

this.monto_disponible = new Ext.form.TextField({
	fieldLabel:'Monto a Pagar',
	name:'monto_disponible',
    id:'monto_disponible',
	readOnly:true,
	style:'background:#c9c9c9;',
	width:320
});


//this.co_clase_retencion = new Ext.form.ComboBox({
//	fieldLabel:'Clase de Retencion',
//	store: this.storeCO_CLASE_RETENCION,
//	typeAhead: true,
//	valueField: 'co_clase_retencion',
//	displayField:'tx_clase_retencion',
//	hiddenName:'co_clase_retencion',
//	forceSelection:true,
//	resizable:true,
//	triggerAction: 'all',
//	emptyText:'...',
//	selectOnFocus: true,
//	mode: 'local',
//	width:450,
//	allowBlank:false
//});
//this.storeCO_CLASE_RETENCION.load();

//this.co_clase_retencion.on('select',function(cmb,record,index){
//var list_tipo_retencion = paqueteComunJS.funcion.getJsonByObjStore({
//        store:fondoEditar.main.gridPanel.getStore()
//});    
//        fondoPago.main.co_tipo_retencion.clearValue();
//        fondoPago.main.storeCO_TIPO_RETENCION.load({
//            params:{
//                co_clase_retencion:record.get('co_clase_retencion'),
//                json_tipo_retencion:list_tipo_retencion,
//                co_proveedor:fondoPago.main.co_proveedor.getValue()
//            }
//        });
//},this);

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
var list_tipo_retencion = paqueteComunJS.funcion.getJsonByObjStore({
        store:fondoEditar.main.gridPanel.getStore()
});    
fondoPago.main.storeCO_TIPO_RETENCION.load({
    params:{
        json_tipo_retencion:list_tipo_retencion,
        co_proveedor:fondoPago.main.co_proveedor.getValue()
    }
});
this.co_tipo_retencion.on('select',function(cmb,record,index){

         var tipo_retencion = fondoPago.main.co_tipo_retencion.getValue();
        
//        if(tipo_retencion!=4 & tipo_retencion!= 92 & tipo_retencion!= 88){
//
//            Ext.get('monto_disponible').setStyle('background-color','#ffffff');
//            fondoPago.main.monto_disponible.setReadOnly(false);
//
//        }else{

            Ext.get('monto_disponible').setStyle('background-color','#c9c9c9');
            fondoPago.main.monto_disponible.setReadOnly(true);
                if(fondoPago.main.fecha_fin.getValue()!='' && fondoPago.main.fecha_inicio.getValue()!=''){
                    fondoPago.main.calcularDisponibilidad();
                }
//        }

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

this.fecha_inicio.on("select",function(){
    if(fondoPago.main.fecha_fin.getValue()!='' && fondoPago.main.fecha_inicio.getValue()!=''){
        fondoPago.main.calcularDisponibilidad();
    }
});

this.fecha_fin.on("select",function(){
    if(fondoPago.main.fecha_fin.getValue()!='' && fondoPago.main.fecha_inicio.getValue()!=''){
        fondoPago.main.calcularDisponibilidad();
    }
});

var myCboxSelModel = new Ext.grid.CheckboxSelectionModel({
  // override private method to allow toggling of selection on or off for multiple rows.
  handleMouseDown : function(g, rowIndex, e){
    var view = this.grid.getView();
    var isSelected = this.isSelected(rowIndex);
    if(isSelected) {  
      this.deselectRow(rowIndex);
    } 
    else if(!isSelected || this.getCount() > 1) {
      this.selectRow(rowIndex, true);
      view.focusRow(rowIndex);
    }else{
 this.deselectRow(rowIndex);
        }
  },
  singleSelect: false,
  listeners: {
         selectionchange: function(sm, rowIndex, rec) {
var length = sm.selections.length
, mo_retencion = 0,record = [];
        if(length>0){
          
        for(var i = 0; i<length;i++){
           mo_retencion += parseFloat(sm.selections.items[i].data.mo_retencion);                          
            record.push(sm.selections.items[i].data.co_factura_retencion);        
            }
            
}
fondoPago.main.monto_disponible.setValue(mo_retencion);
fondoPago.main.co_factura_retencion.push(record);
       console.log(record);
            
    }
            

 }
});
this.gridPagosP = new  Ext.grid.GridPanel({
    width:550,
    height:320,
    store:this.storeR,
    tbar:[
    ],
    sm: myCboxSelModel,
    columns:[
        new Ext.grid.RowNumberer(),
        myCboxSelModel,
        {header: 'co_factura_retencion', width:60 , sortable: true, hidden:true,groupable: false,  dataIndex: 'co_factura_retencion'},
        {header: 'N° solicitud', width: 100,hideable: false,groupable: false, sortable: true,  dataIndex: 'co_solicitud'},
        {header: 'N° orden de pago', width: 100,hideable: false,groupable: false, sortable: true,  dataIndex: 'tx_serial'},
        {header: 'Fecha Pago', width:100 , sortable: true,groupable: false,  dataIndex: 'fe_pago'},
        {header: 'Monto Retención', width:150 , sortable: true,groupable: false,  dataIndex: 'mo_retencion'}

      
    ],
    view: new Ext.grid.GroupingView({
        //groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "Pagos" : "Pago"]})',
        forceFit: true,
        showGroupName: false,
        enableNoGroups: false,
        enableGroupingMenu: false,
        hideGroupedColumn: true
    }),
    stripeRows: true,
    autoScroll:true,
    stateful: true
});

this.fieldDatos= new Ext.form.FieldSet({
    title: 'Datos del Pago',
    items:[
           this.banco,
           this.cuenta,
           this.co_tipo_retencion,
           // this.monto_pago,
           this.fecha_inicio,
           this.fecha_fin,
           this.monto_disponible,
           this.gridPagosP
//           this.tx_observacion
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
        
        if(fondoPago.main.monto_disponible.getValue()<=0){
            Ext.Msg.alert("Alerta","El monto a pagar debe ser mayor a 0");
            return false;
        }        
        
        var e = new fondoEditar.main.Registro({                     
                    co_detalle_fondo: '',
                    co_tipo_retencion:fondoPago.main.co_tipo_retencion.getValue(),
                    tx_tipo_retencion:fondoPago.main.co_tipo_retencion.lastSelectionText,
                    monto: fondoPago.main.monto_disponible.getValue(),
                    tx_observacion: fondoPago.main.tx_observacion.getValue(),
                    fe_desde: fondoPago.main.fecha_inicio.value,
                    fe_hasta: fondoPago.main.fecha_fin.value,
                    co_factura_retencion: fondoPago.main.co_factura_retencion,
                    banco: fondoPago.main.banco.getValue(),
                    cuenta: fondoPago.main.cuenta.getValue()
        });

        var cant = fondoEditar.main.store_lista.getCount();
        (cant == 0) ? 0 : fondoEditar.main.store_lista.getCount() + 1;
        fondoEditar.main.store_lista.insert(cant, e);

        fondoEditar.main.gridPanel.getView().refresh();
        fondoPago.main.co_tipo_retencion.clearValue();
        fondoPago.main.banco.clearValue();
        fondoPago.main.cuenta.clearValue();
        fondoPago.main.monto_pago.setValue('');
        fondoPago.main.monto_disponible.setValue('');
        fondoPago.main.tx_observacion.setValue('');
        fondoPago.main.fecha_inicio.setValue('');
        fondoPago.main.fecha_fin.setValue('');
        fondoPago.main.storeR.removeAll();
        var list_tipo_retencion = paqueteComunJS.funcion.getJsonByObjStore({
                store:fondoEditar.main.gridPanel.getStore()
        });    
        fondoPago.main.storeCO_TIPO_RETENCION.load({
            params:{
                json_tipo_retencion:list_tipo_retencion,
                co_proveedor:fondoPago.main.co_proveedor.getValue()
            }
        });        
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
this.addEvents();
},
calcularDisponibilidad: function(){
    
    
fondoPago.main.storeR.baseParams.fe_desde = fondoPago.main.fecha_inicio.value;
fondoPago.main.storeR.baseParams.fe_hasta = fondoPago.main.fecha_fin.value;
fondoPago.main.storeR.baseParams.co_proveedor = fondoPago.main.co_proveedor.getValue();
fondoPago.main.storeR.baseParams.co_tipo_retencion = fondoPago.main.co_tipo_retencion.getValue();

    fondoPago.main.storeR.load();
    
//      Ext.Ajax.request({
//                method:'GET',
//                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/FondoTercero/calcularDisponibilidad',
//                params:{
//                    fe_desde: fondoPago.main.fecha_inicio.value,
//                    fe_hasta: fondoPago.main.fecha_fin.value,
//                    co_proveedor: fondoPago.main.co_proveedor.getValue(),
//                    co_tipo_retencion: fondoPago.main.co_tipo_retencion.getValue()                    
//                },
//                success:function(result, request ) {
//                    obj = Ext.util.JSON.decode(result.responseText);
//                    if(!obj.data){
//                        fondoPago.main.monto_disponible.setValue("");
//                    }else{
//                        fondoPago.main.monto_disponible.setValue(fondoPago.main.round(obj.data.total));
//                    }
//                }
//        });
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
},
getDataBanco: function(){
var store =  new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Tesoreria/banco',
                root:'data',
                fields: ['co_banco','tx_banco']
 });
return store;
},
getDataCuenta: function(){
var store =  new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Tesoreria/cuenta',
                root:'data',
                fields: ['co_cuenta_bancaria','tx_cuenta_bancaria']
 });
return store;
},
addEvents: function(){

fondoPago.main.banco.on('beforeselect',function(cmb,record,index){
        fondoPago.main.cuenta.clearValue();
        fondoPago.main.store_cuenta.load({
            params:{
                co_banco:record.get('co_banco')
            },
        callback : function(records, operation, success) {
                if (records.length > 0) {
            }else{
                Ext.Msg.alert("Alerta","La banco seleccionado no tiene cuentas Asociadas");   
            }
    }
        });
},this);
},
fgetR: function(){
    this.Store = new Ext.data.GroupingStore({
            proxy: new Ext.data.HttpProxy({
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/FondoTercero/calcularDisponibilidad',
                method: 'POST'
            }),
            reader: new Ext.data.JsonReader({
                root: 'data',
                totalProperty: 'total'
            },
            [
                {name: 'tx_serial'},
                {name: 'co_factura_retencion'},
                {name: 'mo_retencion'},
                {name: 'fe_pago'},
                {name: 'co_solicitud'}
            ]),
            sortInfo:{
                field: 'fe_pago',
                direction: "ASC"
            }

    });
    return this.Store;
},
};
Ext.onReady(fondoPago.main.init, fondoPago.main);
</script>
