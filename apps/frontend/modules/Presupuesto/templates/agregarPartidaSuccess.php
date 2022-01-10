<script type="text/javascript">
Ext.ns("cambiarPartida");
cambiarPartida.main = {
init:function(){

this.storeCO_PARTIDA  = this.getStoreCO_PARTIDA();
this.storeCO_PROYECTO = this.getStoreCO_PROYECTO();
this.storeCO_ACCION   = this.getStoreCO_ACCION();
this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
   
this.co_detalle_compra  = new Ext.form.Hidden({
        name:'co_detalle_compra',
        value:this.OBJ.co_detalle_compra
});

this.co_compras  = new Ext.form.Hidden({
        name:'co_compras',
        value:this.OBJ.co_compras
});

this.monto  = new Ext.form.Hidden({
        name:'monto'
});

/*this.de_ejecutor = new Ext.form.TextField({
	fieldLabel:'Ente Ejecutor',
	name:'de_ejecutor',
        readOnly:true,
        value:this.OBJ.de_ejecutor,
	style:'background:#c9c9c9;',
	width:700
});*/
    
this.co_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Ente Ejecutor',
	store: this.storeCO_EJECUTOR,
	typeAhead: true,
	valueField: 'id',
        id:'co_ejecutor',
	displayField:'ejecutor',
	hiddenName:'co_ejecutor',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	allowBlank:false,
        listeners:{
            select: function(){
                cambiarPartida.main.storeCO_PROYECTO.load({
                    params:{co_ejecutor:this.getValue()},
                    callback: function(){
                        cambiarPartida.main.co_proyecto.setValue(cambiarPartida.main.OBJ.co_proyecto);
                    }
                });
            }
        }
});
this.storeCO_EJECUTOR.load();

this.co_proyecto = new Ext.form.ComboBox({
	fieldLabel:'Proyecto/Ac',
	store: this.storeCO_PROYECTO,
	typeAhead: true,
	valueField: 'id',
        id:'co_proyecto',
	displayField:'de_proyecto_ac',
	hiddenName:'co_proyecto',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	allowBlank:false
});


this.co_proyecto.on('select',function(cmb,record,index){
        cambiarPartida.main.co_accion.clearValue();
        cambiarPartida.main.storeCO_ACCION.load({params:{co_proyecto:record.get('id')}});
},this);

this.co_accion = new Ext.form.ComboBox({
	fieldLabel:'Accion Especifica',
	store: this.storeCO_ACCION,
	typeAhead: true,
	valueField: 'id',
        id:'co_accion',
	displayField:'accion_especifica',
	hiddenName:'co_accion',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	allowBlank:false,
        listeners:{
            select: function(){
                cambiarPartida.main.storeCO_PARTIDA.baseParams.co_accion = this.getValue();
                cambiarPartida.main.storeCO_PARTIDA.baseParams.co_clase_producto = cambiarPartida.main.OBJ.co_clase_producto;                
                cambiarPartida.main.storeCO_PARTIDA.load();
            }
        }
});

this.fieldDatosContrato= new Ext.form.FieldSet({
        title: 'Datos de la Compra',
        items: [this.co_ejecutor,
                this.co_proyecto,
                this.co_accion]
});

this.co_partida = new Ext.form.ComboBox({
	fieldLabel:'Partida',
	store: this.storeCO_PARTIDA,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_partida',
	hiddenName:'co_presupuesto',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	allowBlank:false,
        listeners:{
            select: function(){
                cambiarPartida.main.cargarDisponible();
            }
        }
});

this.mo_disponible = new Ext.form.TextField({
	fieldLabel:'Monto Disponible',
	name:'mo_disponible',
        readOnly:true,
	style:'background:#c9c9c9;',
	width:400
});



this.fieldDatosPartida= new Ext.form.FieldSet({
        title: 'Datos de la Partida',
        items:[this.co_detalle_compra,
               this.co_compras,
               this.monto,
               this.co_partida,
               this.mo_disponible]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!cambiarPartida.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        cambiarPartida.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/guardarCambio',
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
                
                ContabilidadEditar.main.store_lista.baseParams.co_compra=ContabilidadEditar.main.OBJ.co_compras;
                ContabilidadEditar.main.store_lista.load({
                    callback: function(){
                        ContabilidadEditar.main.total_pagar = paqueteComunJS.funcion.getSumaColumnaGrid({
                             store:ContabilidadEditar.main.store_lista,
                             campo:'monto'
                 });
                 
                ContabilidadEditar.main.comprometer.disable();
                ContabilidadEditar.main.descomprometer.disable();
                ContabilidadEditar.main.cambiar_partida.disable();
            
                ContabilidadEditar.main.monto_total.setValue("<span style='font-size:12px;'><b>Total a Pagar: </b>"+paqueteComunJS.funcion.getNumeroFormateado(ContabilidadEditar.main.total_pagar)+"</b></span>");     
        }
    });
        
                 cambiarPartida.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        cambiarPartida.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:900,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.fieldDatosContrato,
           this.fieldDatosPartida]
});

this.winformPanel_ = new Ext.Window({
    title:'Cambio de Partida',
    modal:true,
    constrain:true,
    width:900,
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
ContabilidadEditar.main.mascara.hide();
},
cargarDisponible:function(){
    Ext.Ajax.request({
        method:'GET',
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Presupuesto/cargarDisponible',
        params:{
            co_partida: cambiarPartida.main.co_partida.getValue()
        },
        success:function(result, request ) {
            obj = Ext.util.JSON.decode(result.responseText);
            cambiarPartida.main.mo_disponible.setValue(paqueteComunJS.funcion.getNumeroFormateado(obj.data.mo_disponible));
            cambiarPartida.main.monto.setValue(obj.data.mo_disponible);
        }
    });
},
getStoreCO_PARTIDA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcopartida',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'mo_disponible'},
            {name: 'de_partida',
            convert:function(v,r){
            return r.nu_partida+' - '+r.de_partida;
            }
            }
            ]
    });
    return this.store;
},
getStoreCO_PROYECTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoproyecto',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_proyecto_ac',
            convert:function(v,r){
            return r.nu_proyecto_ac+' - '+r.de_proyecto_ac;
            }
            }
            ]
    });
    return this.store;
},
getStoreCO_EJECUTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcoejecutor',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_ejecutor'},
            {name: 'ejecutor',
                convert:function(v,r){
                    return r.nu_ejecutor+' - '+r.de_ejecutor;
                }
            }
            ]
    });
    return this.store;
},
getStoreCO_ACCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoaccion',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'accion_especifica',
            convert:function(v,r){
            return r.nu_accion_especifica+' - '+r.de_accion_especifica;
            }
            }
            ]
    });
    return this.store;
}
};
Ext.onReady(cambiarPartida.main.init, cambiarPartida.main);
</script>
