<script type="text/javascript">
Ext.ns("listaFactura");
listaFactura.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.co_factura = new Ext.form.Hidden({
    name:'co_factura',
    value:this.OBJ.co_factura
});


this.nu_factura = new Ext.form.TextField({
	fieldLabel:'N° de Factura',
	name:'nu_factura',
    value:this.OBJ.nu_factura,
	allowBlank:false,
	width:200
});

this.fe_emision = new Ext.form.DateField({
	fieldLabel:'Fecha Emision',
	name:'fe_emision',
	allowBlank:false,
	width:100,
    value:this.OBJ.fe_emision
});

this.tx_concepto = new Ext.form.TextArea({
	fieldLabel:'Descripcion del Pago',
	name:'tx_concepto',
	allowBlank:false,
	width:500,
    height:40,
    value:this.OBJ.tx_concepto
});

this.nu_control = new Ext.form.TextField({
	fieldLabel:'N° de control',
	name:'nu_control',
    allowBlank:false,
	width:200,
    value:this.OBJ.nu_control
});

this.campoNumeroFC = new Ext.form.CompositeField({
        fieldLabel: 'N° de Factura',
        items: [
             this.nu_factura,
             {
                   xtype: 'displayfield',
                   value: '&nbsp;&nbsp;&nbsp; N° de control:',
                   width: 100
             },
             this.nu_control
        ]
});


this.fieldDatos2 = new Ext.form.FieldSet({
    title: 'Datos de la Factura',
    items:[
        this.campoNumeroFC,
        this.fe_emision,
        this.tx_concepto,
        this.co_factura
    ]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){
        if(!listaFactura.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
              
        
        listaFactura.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ServicioBasicoFactura/guardarFactura',
            waitMsg: 'Enviando datos, por favor espere..',
            waitTitle:'Enviando',
            failure: function(form, action) {
                Ext.MessageBox.alert('Error en transacción', action.result.msg);
            },
            success: function(form, action) {
                 if(action.result.success){
                     Ext.MessageBox.show({
                         title: 'Mensaje',
                         msg: action.result.msg,
                         closable: false,
                         icon: Ext.MessageBox.INFO,
                         resizable: false,
             animEl: document.body,
                         buttons: Ext.MessageBox.OK
                     });
                 }
                 ServicioBasicoFacturaEditar.main.store_lista.load();
                 listaFactura.main.winformPanel_.close();
             }
        });
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        listaFactura.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
  //  frame:true,
    width:800,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
        this.fieldDatos2,
     //   this.gridPanel
    ]
});

this.winformPanel_ = new Ext.Window({
    title:'Modificar Factura',
    modal:true,
    constrain:true,
    width:810,
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
}
};
Ext.onReady(listaFactura.main.init, listaFactura.main);
</script>
<div id="formularioProducto"></div>
