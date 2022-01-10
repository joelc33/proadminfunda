<script type="text/javascript">
Ext.ns("PrestacionSocialEditarDetalle");
PrestacionSocialEditarDetalle.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.storeCO_CLASE = this.getStoreCO_CLASE();

this.storeCO_PRODUCTO = this.getStoreCO_PRODUCTO();

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud
});

this.co_unidad_producto = new Ext.form.Hidden({
    name:'co_unidad_producto',
    value:this.OBJ.co_unidad_producto
});

this.co_clase = new Ext.form.ComboBox({
	//fieldLabel:'Situacion Trabajador',
	fieldLabel:'Tipo',
	store: this.storeCO_CLASE,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_clase_producto',
	hiddenName:'co_clase',
	//readOnly:(this.OBJ.co_clase!='')?true:false,
	//style:(this.main.OBJ.co_clase!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	//emptyText:'Seleccione Situacion Trabajador...',
	emptyText:'Seleccione Tipo...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false,
    onSelect: function(record){
		PrestacionSocialEditarDetalle.main.co_producto.clearValue();
        PrestacionSocialEditarDetalle.main.co_clase.setValue(record.data.id);
		PrestacionSocialEditarDetalle.main.storeCO_PRODUCTO.load({
			params: {
				co_clase:record.data.id
			}
		});
        this.collapse();
    }
});
this.storeCO_CLASE.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_clase,
	value:  this.OBJ.co_clase,
	objStore: this.storeCO_CLASE
});

this.co_producto = new Ext.form.ComboBox({
	//fieldLabel:'Situacion Trabajador',
	fieldLabel:'Concepto',
	store: this.storeCO_PRODUCTO,
	typeAhead: true,
	valueField: 'co_producto',
	displayField:'producto',
	hiddenName:'co_producto',
	//readOnly:(this.OBJ.co_producto!='')?true:false,
	//style:(this.main.OBJ.co_producto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	//emptyText:'Seleccione Situacion Trabajador...',
	emptyText:'Seleccione Concepto...',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false,
    onSelect: function(record){
        PrestacionSocialEditarDetalle.main.co_producto.setValue(record.data.co_producto);
        PrestacionSocialEditarDetalle.main.co_unidad_producto.setValue(record.data.co_unidad_producto);
        this.collapse();
    }
});

/*this.storeCO_PRODUCTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_producto,
	value:  this.OBJ.co_producto,
	objStore: this.storeCO_PRODUCTO
});*/

this.mo_pago = new Ext.form.NumberField({
	fieldLabel:'Monto a Pagar',
	name:'mo_pago',
	value:this.OBJ.mo_pago,
	allowBlank:false,
	width:200
});

this.mo_asignacion = new Ext.form.Hidden({
    name:'mo_asignacion',
    value:this.OBJ.mo_asignacion
});

this.mo_deduccion = new Ext.form.Hidden({
    name:'mo_deduccion',
    value:this.OBJ.mo_deduccion
});

this.guardar = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-guardar',
    handler:function(){
        
        if(!PrestacionSocialEditarDetalle.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }

        var list_retencion = paqueteComunJS.funcion.getJsonByObjStore({
            store:PrestacionSocialEditar.main.gridPanel_detalle.getStore()
        });

        if(PrestacionSocialEditarDetalle.main.co_unidad_producto.getValue()==639){
            PrestacionSocialEditarDetalle.main.mo_asignacion.setValue(PrestacionSocialEditarDetalle.main.mo_pago.getValue());
            PrestacionSocialEditarDetalle.main.mo_deduccion.setValue(0);
        }else{
            PrestacionSocialEditarDetalle.main.mo_deduccion.setValue(PrestacionSocialEditarDetalle.main.mo_pago.getValue());
            PrestacionSocialEditarDetalle.main.mo_asignacion.setValue(0);
        }
        
        var e = new PrestacionSocialEditar.main.Registro({    
            co_unidad_producto: PrestacionSocialEditarDetalle.main.co_unidad_producto.getValue(),  
            co_clase: PrestacionSocialEditarDetalle.main.co_clase.getValue(), 
            tx_producto: PrestacionSocialEditarDetalle.main.co_producto.lastSelectionText,
            co_producto: PrestacionSocialEditarDetalle.main.co_producto.getValue(),
            mo_pago:PrestacionSocialEditarDetalle.main.mo_pago.getValue(),
            mo_asignacion:PrestacionSocialEditarDetalle.main.mo_asignacion.getValue(),
            mo_deduccion:PrestacionSocialEditarDetalle.main.mo_deduccion.getValue(),
        });

        var cant = PrestacionSocialEditar.main.store_lista.getCount();
         
        (cant == 0) ? 0 : PrestacionSocialEditar.main.store_lista.getCount() + 1;
      
    
        PrestacionSocialEditar.main.store_lista.insert(cant, e);
        PrestacionSocialEditar.main.gridPanel_detalle.getView().refresh();
        
        Ext.utiles.msg('Mensaje', "El detalle de pago se agregó exitosamente");

        PrestacionSocialEditar.main.calcular(); 
        
        PrestacionSocialEditarDetalle.main.winformPanel_.close(); 
       
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PrestacionSocialEditarDetalle.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
  //  frame:true,
    width:600,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
        this.co_unidad_producto,
        this.co_clase,
        this.co_producto,
        this.mo_pago,
        this.mo_asignacion,
        this.mo_deduccion
    ]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Detalle de Pago',
    modal:true,
    constrain:true,
    width:614,
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
getStoreCO_CLASE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/storefkcoclase',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_clase_producto'},
            ]
    });
    return this.store;
},
getStoreCO_PRODUCTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PrestacionSocial/storefkcoproducto',
        root:'data',
        fields:[
            {name: 'co_producto'},
            {name: 'tx_producto'},
            {name: 'co_unidad_producto'},
            {name: 'producto',
                convert:function(v,r){
                    return r.cod_producto+' - '+r.tx_producto;
                }
            }
            ]
    });
    return this.store;
}
};
Ext.onReady(PrestacionSocialEditarDetalle.main.init, PrestacionSocialEditarDetalle.main);
</script>
<div id="formularioProducto"></div>
