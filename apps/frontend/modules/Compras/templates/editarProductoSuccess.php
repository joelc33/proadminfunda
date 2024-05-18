<script type="text/javascript">
Ext.ns("listaProducto");
listaProducto.main = {
init:function(){

            this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

            this.co_detalle_requisicion = new Ext.form.Hidden({
                name:'co_producto',
                value:this.OBJ.co_detalle_requisicion
            });

            this.co_detalle_compras = new Ext.form.Hidden({
                name:'co_detalle_compras',
                value:this.OBJ.co_detalle_compras
            });

            this.co_producto = new Ext.form.Hidden({
                name:'co_producto',
                value:this.OBJ.co_producto
            });

            this.cod_producto = new Ext.form.TextField({
            	fieldLabel:'Código',
            	name:'cod_producto',
            	allowBlank:false,
            	width:80,
                readOnly:true,
                style:'background:#c9c9c9;',
                value:this.OBJ.cod_producto
            });

            this.tx_producto = new Ext.form.TextArea({
                fieldLabel:'Producto',
                name:'tx_producto',
                allowBlank:false,
                width:600,
                value:this.OBJ.tx_producto,
                readOnly:true,
                style:'background:#c9c9c9;',
                allowBlank:false,
            });

            this.nu_cantidad = new Ext.form.NumberField({
                fieldLabel:'Cantidad',
                name:'nu_cantidad',
                value:  this.OBJ.nu_cantidad,        
//                readOnly:true,
//                style:'background:#c9c9c9;',
            });
            
            this.nu_cantidad.on("blur",function(){
                listaProducto.main.calcularMonto();
            });            

            this.precio_unitario = new Ext.form.NumberField({
                fieldLabel:'Precio Unitario',
                name:'precio_unitario',
                value:  this.OBJ.precio_unitario,        
               // readOnly:(this.OBJ.co_factura!='')?true:false,
               // style:(this.OBJ.co_factura!='')?'background:#c9c9c9;':'',
               // allowBlank:false,
            });

            this.precio_unitario.on("blur",function(){
                listaProducto.main.calcularMonto();
            });

            this.monto = new Ext.form.NumberField({
                fieldLabel:'Monto Total',
                name:'monto',
                value:  this.OBJ.monto,        
                readOnly:true,
                style:'background:#c9c9c9;',
            });


            this.fieldDatos= new Ext.form.FieldSet({
                title: 'Datos del Producto',
                items:[
                        this.co_detalle_requisicion,
                        this.co_detalle_compras,
                        this.co_producto,
                        this.cod_producto,
                        this.tx_producto,
                        this.precio_unitario,
                        this.nu_cantidad,
                        this.monto
                   ]
            });


            this.formPanel_ = new Ext.form.FormPanel({
              //  frame:true,
                width:800,
                autoHeight:true,  
                autoScroll:true,
                bodyStyle:'padding:10px;',
                items:[this.fieldDatos]
            });

            this.guardar = new Ext.Button({
                text:'Guardar',
                iconCls: 'icon-guardar',
                handler:function(){

                    if(listaProducto.main.monto.getValue()>ComprasEditar.main.gridPanel.getSelectionModel().getSelected().get('monto')){
                        Ext.Msg.alert("Alerta","El monto total del producto no puede ser mayor al monto anterior");
                        return false;
                    }


                    listaProducto.main.formPanel_.getForm().submit({
                        method:'POST',
                        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/guardarProducto',
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
                            ComprasEditar.main.store_lista.baseParams.co_compras=ComprasEditar.main.OBJ.co_compras;
                            ComprasEditar.main.store_lista.load({
                                callback: function(){
                                   ComprasEditar.main.getTotal();
                                }
                            });
                            listaProducto.main.winformPanel_.close();
                         }
                    });
               
                }
            });

            this.salir = new Ext.Button({
                text:'Salir',
            //    iconCls: 'icon-cancelar',
                handler:function(){
                    listaProducto.main.winformPanel_.close();
                }
            });

            this.winformPanel_ = new Ext.Window({
                title:'Editar',
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
},
calcularMonto:function(){

    var total = parseFloat(listaProducto.main.precio_unitario.getValue())*parseFloat(listaProducto.main.nu_cantidad.getValue());
    listaProducto.main.monto.setValue(total);

}   
};
Ext.onReady(listaProducto.main.init, listaProducto.main);
</script>
