<script type="text/javascript">
Ext.ns("agregarProducto");
agregarProducto.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.store_lista = this.getLista();
this.rowIndex;
this.mo_total = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b> Base Imponible: </b>0,00</b></span>"
});

this.gridPanel = new Ext.grid.EditorGridPanel({
        title:'Lista de Productos Requeridos (Doble click para agregar la cantidad)',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:500,  
        width:870,
     //   tbar:[this.agregar,'-',this.botonEliminar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_detalle_factura', hidden: true,width:80, menuDisabled:true, dataIndex:'co_detalle_factura'},
            {header: 'co_presupuesto', hidden: true,width:80, menuDisabled:true, dataIndex:'co_presupuesto'},
            {header: 'co_producto', hidden: true,width:80, menuDisabled:true, dataIndex:'co_producto'},
            {header: 'cantidad', hidden: true,width:80, menuDisabled:true, dataIndex:'cantidad'},
            {header: 'Producto',width:200, menuDisabled:true,dataIndex: 'tx_producto',renderer:textoLargo},                
            {header: 'Cant. Requerida',width:100, menuDisabled:true,dataIndex: 'cantidad',renderer:textoLargo},                
            {header: 'Cant. Factura', width:100, menuDisabled:true,dataIndex: 'cant_producto',editor: new Ext.form.NumberField({
		allowBlank: false,
		autoCreate: {tag: "input", type: "text", autocomplete: "off", maxlength: 400},
                listeners: {
                    change: function (cmb, record, index)
                    {
                      var cantidad = agregarProducto.main.gridPanel.getStore().getAt(agregarProducto.main.rowIndex).data.cantidad;
                      var monto = this.getValue()*agregarProducto.main.gridPanel.getStore().getAt(agregarProducto.main.rowIndex).data.precio_unitario;
                      agregarProducto.main.gridPanel.getStore().getAt(agregarProducto.main.rowIndex).data.mo_total = monto; 
                      
                      if(parseInt(this.getValue())>parseInt(cantidad)){                          
                          Ext.Msg.alert("Alerta","La cantidad ingresada es mayor a la cantidad requerida");
                          return false;
                      }
                      
                      var base_imponible = paqueteComunJS.funcion.getSumaColumnaGrid({
                            store:agregarProducto.main.store_lista,
                            campo:'mo_total'
                      });
                      
                      if(base_imponible>0){
                          agregarProducto.main.guardar.enable();
                      }else{
                          agregarProducto.main.guardar.disable();
                      }
                      
                      agregarProducto.main.mo_total.setValue("<span style='font-size:12px;'><b>Base Imponible: </b>"+paqueteComunJS.funcion.getNumeroFormateado(base_imponible)+"</b></span>");
                    }
                }   
            })},
            {header: 'Valor Unitario',width:200, menuDisabled:true,dataIndex: 'precio_unitario'},
            {header: 'Monto Total',width:200, menuDisabled:true,dataIndex: 'mo_total',editor: new Ext.form.NumberField({
		allowBlank: false,
		autoCreate: {tag: "input", type: "text", autocomplete: "off", maxlength: 400}             
            })},
            
        ],
        bbar: new Ext.ux.StatusBar({
            id: 'basic-statusbar_producto',
            autoScroll:true,
            defaults:{style:'color:black;font-size:30px;',autoWidth:true},
            items:[
              this.mo_total
            ]
        }),
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){           
            agregarProducto.main.rowIndex = rowIndex;
        }},           
        stripeRows: true,
        autoScroll:true,
        stateful: true
});

this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
this.store_lista.load();


this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        agregarProducto.main.winformPanel_.close();
    }
});

this.guardar = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-add',
    handler:function(){    
       
        listaProducto.main.json_producto = paqueteComunJS.funcion.getJsonByObjStore({
                store:agregarProducto.main.gridPanel.getStore()
        });
        
        var base_imponible = paqueteComunJS.funcion.getSumaColumnaGrid({
                            store:agregarProducto.main.store_lista,
                            campo:'mo_total'
        });
        
        var monto_exento =0;
        agregarProducto.main.store_lista.each(function(store){
               if(store.data.in_exento==true){      
                    monto_exento+=store.data.mo_total
               }
        });  
        
        listaProducto.main.nu_base_imponible.setValue(base_imponible);
        listaProducto.main.mo_exento.setValue(monto_exento);
        
        listaProducto.main.calcular();
        agregarProducto.main.winformPanel_.close();
       
    }
});

this.guardar.disable();

this.formPanel_ = new Ext.form.FormPanel({
  //  frame:true,
    width:900,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.gridPanel]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Producto',
    modal:true,
    constrain:true,
    width:910,
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
},getLista: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/storelistaProducto',
    root:'data',
    fields:[          
                {name: 'co_detalle_factura'},
                {name: 'co_factura'},
                {name: 'tx_producto'},
                {name: 'co_producto'},
                {name: 'cant_producto'},
                {name: 'precio_unitario'},                 
                {name: 'mo_total'},
                {name: 'cantidad'},
                {name: 'in_exento'},
                {name: 'co_presupuesto'},
                {name: 'co_detalle_requisicion'}
           ]
    });
    return this.store;      
}
};
Ext.onReady(agregarProducto.main.init, agregarProducto.main);
</script>
<div id="formularioProducto"></div>
