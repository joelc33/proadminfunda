<script type="text/javascript">
Ext.ns("CrearPartidaEditar");
CrearPartidaEditar.main = {
init:function(){
 
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_PARTIDA             = this.getStoreCO_PARTIDA();
this.storeCO_APLICACION          = this.getStoreCO_APLICACION();

//<ClavePrimaria>
this.co_creacion_partida = new Ext.form.Hidden({
    name:'co_creacion_partida',
    value:this.OBJ.co_creacion_partida});

this.co_solicitud = new Ext.form.Hidden({
    name:'tb178_creacion_partida_ingreso[co_solicitud]',
    value:this.OBJ.co_solicitud
});
//</ClavePrimaria>

this.monto_partida = 0;

this.co_partida = new Ext.form.ComboBox({
	fieldLabel:'Partida',
	store: this.storeCO_PARTIDA,
	typeAhead: true,
	valueField: 'co_presupuesto_ingreso',
	displayField:'tx_descripcion',
	hiddenName:'tb178_creacion_partida_ingreso[co_partida]',
	forceSelection:true,
	resizable:true,
        forceAll:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	emptyText:'Seleccione...',
	allowBlank:false,
        listeners:{
            select: function(){
                CrearPartidaEditar.main.cargarDisponible();
            }
        }
    
});


this.storeCO_PARTIDA.load({
    callback: function(){
        CrearPartidaEditar.main.co_partida.setValue(CrearPartidaEditar.main.OBJ.co_partida);
    }
});

this.co_aplicacion = new Ext.form.ComboBox({
	fieldLabel:'Aplicacion',
	store: this.storeCO_APLICACION,
	typeAhead: true,
	valueField: 'co_aplicacion',
	displayField:'tx_aplicacion',
	hiddenName:'tb178_creacion_partida_ingreso[co_aplicacion]',
	//readOnly:(this.OBJ.co_ente_ejecutor!='')?true:false,
	//style:(this.main.OBJ.co_ente_ejecutor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	resizable:true,
	allowBlank:false
});
this.storeCO_APLICACION.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_aplicacion,
	value:  this.OBJ.co_aplicacion,
	objStore: this.storeCO_APLICACION
});




this.nu_monto_disponible = new Ext.form.TextField({
	fieldLabel:'Monto Disponible',
	name:'tb178_creacion_partida_ingreso[nu_monto_disponible]',
        readOnly:true,
	style:'background:#c9c9c9;',
	value:this.OBJ.nu_monto,
	allowBlank:false
});


this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tb178_creacion_partida_ingreso[tx_descripcion]',
	value:this.OBJ.tx_descripcion,
	allowBlank:false,
	width:700
});

this.tx_partida = new Ext.form.TextField({
	fieldLabel:'Partida',
	name:'tb178_creacion_partida_ingreso[tx_partida]',
	value:this.OBJ.tx_partida,
	allowBlank:false,
	width:100,
	readOnly:(this.OBJ.tx_partida!='')?true:false,
	style:(this.OBJ.tx_partida!='')?'background:#c9c9c9;':'',
        maskRe: /[0-9]/, 
});

this.nu_monto = new Ext.form.NumberField({
	fieldLabel:'Monto',
	name:'tb178_creacion_partida_ingreso[nu_monto]',
	value:this.OBJ.nu_monto,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!CrearPartidaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        CrearPartidaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartidaIngreso/guardar',
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
                 CrearPartidaLista.main.store_lista.load();
                 CrearPartidaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        CrearPartidaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:900,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_creacion_partida,
                    this.co_solicitud,
                    this.co_partida,
                    this.co_aplicacion,
                    this.tx_descripcion,
                    this.tx_partida
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Partida',
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
CrearPartidaLista.main.mascara.hide();
}
,getStoreCO_APLICACION: function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcoaplicacion',
        root:'data',
        fields:[
            {name: 'co_aplicacion'},
            {name: 'tx_aplicacion'}
        ]
    });
    return this.store;
    
},
cargarDisponible:function(){
    Ext.Ajax.request({
        method:'GET',
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/CrearPartidaIngreso/cargarDisponible',
        params:{
            co_partida: CrearPartidaEditar.main.co_partida.getValue()
        },
        success:function(result, request ) {
            obj = Ext.util.JSON.decode(result.responseText);
           
            if(CrearPartidaEditar.main.OBJ.tx_descripcion=='')            
                CrearPartidaEditar.main.tx_partida.setValue(obj.data.nu_cant_partida);
        }
    });
    
      var str = CrearPartidaEditar.main.co_partida.lastSelectionText;
      var res = str.split("-");
      CrearPartidaEditar.main.tx_descripcion.setValue(res[1].trim());

},
getStoreCO_PARTIDA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartidaIngreso/storefkcopartida',
        root:'data',
        fields:[
            {name: 'co_presupuesto_ingreso'},
            {name: 'tx_descripcion',
            convert:function(v,r){
            return r.nu_partida+' - '+r.tx_descripcion;
            }
            }
            ]
    });
    return this.store;
}
};
Ext.onReady(CrearPartidaEditar.main.init, CrearPartidaEditar.main);
</script>
