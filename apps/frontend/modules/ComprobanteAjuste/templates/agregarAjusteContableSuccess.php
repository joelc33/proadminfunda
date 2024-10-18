<script type="text/javascript">
Ext.ns("agregarAjuste");
agregarAjuste.main = {
init:function(){
    
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.store_tipo_asiento = this.getDataTipoAsiento();
function formatoNro(val){
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}

this.co_cuenta_contable = new Ext.form.Hidden({
    name:'co_cuenta_contable'
});

this.monto = new Ext.form.NumberField({
	fieldLabel:'Monto',
	name:'monto',
        allowBlank:false,
	width:150
});

this.tipo_asiento = new Ext.form.ComboBox({
    fieldLabel : 'Tipo Asiento',
    displayField:'tx_tipo_asiento',
    store: this.store_tipo_asiento,
    typeAhead: true,
    valueField: 'co_tipo_asiento',
    hiddenName:'tipo_asiento',
    name: 'tipo_asiento',
    triggerAction: 'all',
    emptyText:'Tipo de Asiento',
    selectOnFocus:true,
    allowBlank:false,
    width:150,
    resizable:true
});


this.cuenta = new Ext.form.TextField({
	fieldLabel:'Cuenta',
	name:'cuenta',     
        readOnly:true,
        allowBlank:false,
	width:200
});

this.denominacion = new Ext.form.TextField({
	fieldLabel:'Denominacion',
	name:'denominacion',     
        readOnly:true,
        allowBlank:false,
	width:550
});

this.agregar = new Ext.Button({
    text:'Buscar',
    iconCls: 'icon-nuevo',
    handler:function(){
        this.msg = Ext.get('formulario');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ComprobanteAjuste/BuscarCuenta',
            scripts: true,
            text: "Cargando..",
        });
    }
});

this.compositefieldCuenta = new Ext.form.CompositeField({
fieldLabel: 'Cuenta Contable',
width:900,
items: [
	this.cuenta,
	this.denominacion,
        this.agregar
	]
});

this.fecha = new Ext.form.DateField({
	fieldLabel:'Fecha',
	name:'fecha',
        //readOnly:true,
	maxValue:new Date,
        allowBlank:false,
	width:100
});

this.descripcion = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'descripcion',     
        allowBlank:false,
	width:755
});

this.fieldAfectar= new Ext.form.FieldSet({
        title: 'Datos de Comprobante',
        items:[ 
        
                this.fecha,
                this.descripcion,
                this.tipo_asiento,
                this.monto,
                this.compositefieldCuenta
       ]
});

this.guardar = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-nuevo',
    handler:function(){
         agregarAjuste.main.agregarCuenta();
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        agregarAjuste.main.winformPanel_.close();
    }
});



this.formPanel_ = new Ext.form.FormPanel({
    fileUpload: true,
    frame:true,
    width:1000,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.fieldAfectar]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Cuenta',
    modal:true,
    constrain:true,
    width:1000,
    frame:true,
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
//PagoNominaLista.main.mascara.hide();
},agregarCuenta: function(){
        if(!agregarAjuste.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        } 
       
       if(agregarAjuste.main.tipo_asiento.getValue()==9){
       var mo_debito =   agregarAjuste.main.monto.getValue();
       var mo_credito = 0;
       }else{
       var mo_debito =  0;
       var mo_credito =  agregarAjuste.main.monto.getValue();           
      }
      var co_cuenta_contable = agregarAjuste.main.co_cuenta_contable.getValue();
    var reg = ComprobanteAjuste.main.store_lista.find('co_cuenta_contable', co_cuenta_contable, 0, true, false);

    if (reg >= 0) {
        
        Ext.utiles.msg('Mensaje', "La cuenta contable ya se encuentra agregada");
    }else{
        
       
        var e = new ComprobanteAjuste.main.Registro({  
            co_cuenta_contable: agregarAjuste.main.co_cuenta_contable.getValue(),
            tx_cuenta:agregarAjuste.main.cuenta.getValue(),
            co_tipo_asiento:agregarAjuste.main.tipo_asiento.getValue(),
            tx_tipo_asiento:agregarAjuste.main.tipo_asiento.lastSelectionText,
            denominacion:agregarAjuste.main.denominacion.getValue(),
            descripcion:agregarAjuste.main.descripcion.getValue(),
            fecha:agregarAjuste.main.fecha.getValue().format('Y-m-d'),
            mo_debito:mo_debito,
            mo_credito:mo_credito
        });
                
    
                
        var cant = ComprobanteAjuste.main.store_lista.getCount();
       
        (cant == 0) ? 0 : ComprobanteAjuste.main.store_lista.getCount() + 1;
        ComprobanteAjuste.main.store_lista.insert(cant, e);

        ComprobanteAjuste.main.gridPanel.getView().refresh();
        agregarAjuste.main.tipo_asiento.clearValue();
        agregarAjuste.main.cuenta.setValue('');
        agregarAjuste.main.denominacion.setValue('');
        
        Ext.utiles.msg('Mensaje', "El registro se agregó exitosamente");        

    }
//        agregarAjuste.main.winformPanel_.close();
},
getDataTipoAsiento: function(){
var store =  new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/ComprobanteAjuste/storefktipoasiento',
                root:'data',
                fields: ['co_tipo_asiento','tx_tipo_asiento']
 });
return store;
}
};
Ext.onReady(agregarAjuste.main.init, agregarAjuste.main);
</script>
<div id="formulario"></div>