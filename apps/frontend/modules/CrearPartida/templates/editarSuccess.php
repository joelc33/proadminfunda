<script type="text/javascript">
Ext.ns("CrearPartidaEditar");
CrearPartidaEditar.main = {
init:function(){
 
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storecofuentefinanciamiento = this.getStorecofuentefinanciamiento();
this.storeCO_NUMERO_FUENTE       = this.getStoreCO_NUMERO_FUENTE();
this.storecoenteejecutor         = this.getStorecoenteejecutor();
this.storecoproyecto             = this.getStorecoproyecto();
this.storecoaccionespecifica     = this.getStorecoaccionespecifica();
this.storeCO_USUARIO             = this.getStoreCO_USUARIO();
this.storeCO_ESTATUS_RUTA        = this.getStoreCO_ESTATUS_RUTA();
this.storeCO_USUARIO             = this.getStoreCO_USUARIO();
this.storeCO_PARTIDA             = this.getStoreCO_PARTIDA();
this.storeCO_APLICACION          = this.getStoreCO_APLICACION();
this.storeCO_TIPO_INGRESO        = this.getStoreCO_TIPO_INGRESO();
this.storeCO_AMBITO              = this.getStoreCO_AMBITO();
this.storeTIPO_GASTO          = this.getStoreTIPO_GASTO();
this.storeCLASIFICACION_ECONOMICA          = this.getStoreCLASIFICACION_ECONOMICA();
this.storeAREA_ESTRATEGICA          = this.getStoreAREA_ESTRATEGICA();

//<ClavePrimaria>
this.co_creacion_partida = new Ext.form.Hidden({
    name:'co_creacion_partida',
    value:this.OBJ.co_creacion_partida});

this.co_solicitud = new Ext.form.Hidden({
    name:'tb067_creacion_partida[co_solicitud]',
    value:this.OBJ.co_solicitud
});
//</ClavePrimaria>

this.monto_partida = 0;

this.co_fuente_financiamiento = new Ext.form.ComboBox({
	fieldLabel:'Fuente',
	store: this.storecofuentefinanciamiento,
	typeAhead: true,
	valueField: 'co_fuente_financiamiento',
	displayField:'tx_fuente_financiamiento',
	hiddenName:'tb067_creacion_partida[co_fuente_financiamiento]',
	//readOnly:(this.OBJ.co_fuente_financiamiento!='')?true:false,
	//style:(this.main.OBJ.co_fuente_financiamiento!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storecofuentefinanciamiento.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_fuente_financiamiento,
	value:  this.OBJ.co_fuente_financiamiento,
	objStore: this.storecofuentefinanciamiento
});

this.co_fuente_financiamiento.on('select',function(cmb,record,index){
        CrearPartidaEditar.main.co_numero_fuente.clearValue();
        CrearPartidaEditar.main.storeCO_NUMERO_FUENTE.removeAll();
        CrearPartidaEditar.main.storeCO_NUMERO_FUENTE.load({
            params:{co_fuente_financiamiento:record.get('co_fuente_financiamiento')
        }});
},this);

this.co_numero_fuente = new Ext.form.ComboBox({
	fieldLabel:'Nro.',
	store: this.storeCO_NUMERO_FUENTE,
	typeAhead: true,
	valueField: 'co_numero_fuente',
	displayField:'tx_numero_fuente',
	hiddenName:'tb067_creacion_partida[co_numero_fuente]',
	//readOnly:(this.OBJ.co_numero_fuente!='')?true:false,
	//style:(this.main.OBJ.co_numero_fuente!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});

if(this.OBJ.co_fuente_financiamiento!=''){
        CrearPartidaEditar.main.storeCO_NUMERO_FUENTE.load({
            params:{co_fuente_financiamiento:CrearPartidaEditar.main.OBJ.co_fuente_financiamiento},
            callback: function(){
                CrearPartidaEditar.main.co_numero_fuente.setValue(CrearPartidaEditar.main.OBJ.co_numero_fuente);
            }
        });
}


this.co_ente_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Ente Ejecutor',
	store: this.storecoenteejecutor,
	typeAhead: true,
	valueField: 'id',
	displayField:'ejecutor',
	hiddenName:'tb067_creacion_partida[co_ente_ejecutor]',
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
this.storecoenteejecutor.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_ente_ejecutor,
	value:  this.OBJ.co_ente_ejecutor,
	objStore: this.storecoenteejecutor
});


this.co_ente_ejecutor.on('select',function(cmb,record,index){
        CrearPartidaEditar.main.co_proyecto.clearValue();
        CrearPartidaEditar.main.storecoproyecto.removeAll();
        CrearPartidaEditar.main.co_accion_especifica.clearValue();
        CrearPartidaEditar.main.storecoaccionespecifica.removeAll();
        CrearPartidaEditar.main.co_partida.clearValue();
        CrearPartidaEditar.main.storeCO_PARTIDA.removeAll();
        CrearPartidaEditar.main.storecoproyecto.load({
            params:{co_ejecutor:record.get('id')
        }});
},this);


if(this.OBJ.co_ente_ejecutor!=''){
        CrearPartidaEditar.main.storecoproyecto.load({
            params:{co_ejecutor:CrearPartidaEditar.main.OBJ.co_ente_ejecutor},
            callback: function(){
                CrearPartidaEditar.main.co_proyecto.setValue(CrearPartidaEditar.main.OBJ.co_proyecto);
            }
        });
}

this.co_proyecto = new Ext.form.ComboBox({
	fieldLabel:'Proyecto/AC',
	store: this.storecoproyecto,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_proyecto_ac',
	hiddenName:'tb067_creacion_partida[co_proyecto]',
	//readOnly:(this.OBJ.co_proyecto!='')?true:false,
	//style:(this.main.OBJ.co_proyecto!='')?'background:#c9c9c9;':'',
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

this.co_proyecto.on('select',function(cmb,record,index){
        CrearPartidaEditar.main.co_accion_especifica.clearValue();
        CrearPartidaEditar.main.storecoaccionespecifica.removeAll();
        CrearPartidaEditar.main.co_partida.clearValue();
        CrearPartidaEditar.main.storeCO_PARTIDA.removeAll();
        CrearPartidaEditar.main.storecoaccionespecifica.load({
            params:{co_proyecto:record.get('id')
        }});
},this);


if(this.OBJ.co_proyecto!=''){
        CrearPartidaEditar.main.storecoaccionespecifica.load({
            params:{co_proyecto:CrearPartidaEditar.main.OBJ.co_proyecto},
            callback: function(){
                CrearPartidaEditar.main.co_accion_especifica.setValue(CrearPartidaEditar.main.OBJ.co_accion_especifica);
            }
        });
}

this.co_accion_especifica = new Ext.form.ComboBox({
	fieldLabel:'Acción Especifica',
	store: this.storecoaccionespecifica,
	typeAhead: true,
	valueField: 'id',
	displayField:'accion_especifica',
	hiddenName:'tb067_creacion_partida[co_accion_especifica]',	
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

this.co_accion_especifica.on('select',function(cmb,record,index){
        CrearPartidaEditar.main.co_partida.clearValue();
        CrearPartidaEditar.main.storeCO_PARTIDA.removeAll();
        CrearPartidaEditar.main.storeCO_PARTIDA.load({
            params:{co_accion:record.get('id')
        }});
},this);


if(this.OBJ.co_accion_especifica!=''){
        CrearPartidaEditar.main.storeCO_PARTIDA.load({
            params:{co_accion:CrearPartidaEditar.main.OBJ.co_accion_especifica},
            callback: function(){
                CrearPartidaEditar.main.co_partida.setValue(CrearPartidaEditar.main.OBJ.co_partida);
                CrearPartidaEditar.main.cargarDisponible();
            }
        });
}

this.co_partida = new Ext.form.ComboBox({
	fieldLabel:'Partida',
	store: this.storeCO_PARTIDA,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_partida',
	hiddenName:'tb067_creacion_partida[co_partida]',
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

this.co_aplicacion = new Ext.form.ComboBox({
	fieldLabel:'Aplicacion',
	store: this.storeCO_APLICACION,
	typeAhead: true,
	valueField: 'co_aplicacion',
	displayField:'tx_aplicacion',
	hiddenName:'tb067_creacion_partida[co_aplicacion]',
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


this.co_tipo_ingreso = new Ext.form.ComboBox({
	fieldLabel:'Fuente de Ingreso',
	store: this.storeCO_TIPO_INGRESO,
	typeAhead: true,
	valueField: 'co_tipo_ingreso',
	displayField:'tx_descripcion',
	hiddenName:'tb067_creacion_partida[co_tipo_ingreso]',
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
this.storeCO_TIPO_INGRESO.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tipo_ingreso,
	value:  this.OBJ.co_tipo_ingreso,
	objStore: this.storeCO_TIPO_INGRESO
});


this.co_ambito = new Ext.form.ComboBox({
	fieldLabel:'Ambito',
	store: this.storeCO_AMBITO,
	typeAhead: true,
	valueField: 'co_ambito',
	displayField:'tx_ambito',
	hiddenName:'tb067_creacion_partida[co_ambito]',
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
this.storeCO_AMBITO.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_ambito,
	value:  this.OBJ.co_ambito,
	objStore: this.storeCO_AMBITO
});

this.tipo_gasto = new Ext.form.ComboBox({
	fieldLabel:'Tipo de Gasto',
	store: this.storeTIPO_GASTO,
	typeAhead: true,
	valueField: 'tx_siglas',
	displayField:'tx_descripcion',
	hiddenName:'tb067_creacion_partida[co_tipo_gasto]',
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
this.storeTIPO_GASTO.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.tipo_gasto,
	value:  this.OBJ.tipo_gasto,
	objStore: this.storeTIPO_GASTO
});

this.co_clasificacion_economica = new Ext.form.ComboBox({
	fieldLabel:'Clasificacion Economica',
	store: this.storeCLASIFICACION_ECONOMICA,
	typeAhead: true,
	valueField: 'co_clasificacion_economica',
	displayField:'tx_descripcion',
	hiddenName:'tb067_creacion_partida[co_clasificacion_economica]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:700,
        allowBlank:false
});
this.storeCLASIFICACION_ECONOMICA.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_clasificacion_economica,
	value:  this.OBJ.co_clasificacion_economica,
	objStore: this.storeCLASIFICACION_ECONOMICA
});

this.co_area_estrategica = new Ext.form.ComboBox({
	fieldLabel:'Area Estrategica',
	store: this.storeAREA_ESTRATEGICA,
	typeAhead: true,
	valueField: 'co_area_estrategica',
	displayField:'tx_descripcion',
	hiddenName:'tb067_creacion_partida[co_area_estrategica]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:700,
        allowBlank:false
});
this.storeAREA_ESTRATEGICA.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_area_estrategica,
	value:  this.OBJ.co_area_estrategica,
	objStore: this.storeAREA_ESTRATEGICA
});

this.nu_monto_disponible = new Ext.form.TextField({
	fieldLabel:'Monto Disponible',
	name:'tb067_creacion_partida[nu_monto_disponible]',
        readOnly:true,
	style:'background:#c9c9c9;',
	value:this.OBJ.nu_monto,
	allowBlank:false
});


this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tb067_creacion_partida[tx_descripcion]',
	value:this.OBJ.tx_descripcion,
	allowBlank:false,
	width:700
});

this.tx_partida = new Ext.form.TextField({
	fieldLabel:'Partida',
	name:'tb067_creacion_partida[tx_partida]',
	value:this.OBJ.tx_partida,
	allowBlank:false,
	width:200,
	readOnly:(this.OBJ.tx_partida!='')?true:false,
	style:(this.OBJ.tx_partida!='')?'background:#c9c9c9;':'',
        //maskRe: /[0-9]/, 
});

this.nu_monto = new Ext.form.NumberField({
	fieldLabel:'Monto',
	name:'tb067_creacion_partida[nu_monto]',
	value:this.OBJ.nu_monto,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

//        alert(CrearPartidaEditar.main.monto_partida); 
//        alert(CrearPartidaEditar.main.nu_monto.getValue());
//        if(parseFloat(CrearPartidaEditar.main.monto_partida) < parseFloat(CrearPartidaEditar.main.nu_monto.getValue())){
//             Ext.MessageBox.alert('Error en transacción', "El monto ingresado no puede ser mayor al monto disponible");
//             return false;
//        }

        if(!CrearPartidaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        CrearPartidaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/guardar',
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
                    this.co_fuente_financiamiento,
                    this.co_numero_fuente,
                    this.co_ente_ejecutor,
                    this.co_proyecto,
                    this.co_accion_especifica,
                    this.co_partida,
                    this.co_aplicacion,
                    this.co_tipo_ingreso,
                    this.co_ambito,
                    this.tipo_gasto,
                    this.co_clasificacion_economica,
                    this.co_area_estrategica,
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
},getStoreCO_AMBITO: function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcoambito',
        root:'data',
        fields:[
            {name: 'co_ambito'},
            {name: 'tx_ambito'}
        ]
    });
    return this.store;
}
,getStoreTIPO_GASTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkTipoGasto',
        root:'data',
        fields:[
            {name: 'tx_siglas'},
            {name: 'tx_descripcion'}
        ]
    });
    return this.store;
}
,getStoreCLASIFICACION_ECONOMICA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkClasificacionEconomica',
        root:'data',
        fields:[
            {name: 'co_clasificacion_economica'},
            {name: 'tx_descripcion'}
        ]
    });
    return this.store;
}
,getStoreAREA_ESTRATEGICA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkAreaEstrategica',
        root:'data',
        fields:[
            {name: 'co_area_estrategica'},
            {name: 'tx_descripcion'}
        ]
    });
    return this.store;
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
    
},getStoreCO_TIPO_INGRESO: function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcotipoingreso',
        root:'data',
        fields:[
            {name: 'co_tipo_ingreso'} ,
            {name: 'tx_tip_ingreso'},
            {name: 'tx_descripcion',
                convert:function(v,r){
                    return r.tx_tip_ingreso+' - '+r.tx_descripcion;
                }
            }
        ]
    });
    return this.store;
}
,getStorecofuentefinanciamiento:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcofuentefinanciamiento',
        root:'data',
        fields:[
            {name: 'co_fuente_financiamiento'},
            {name: 'tx_fuente_financiamiento'}
            ]
    });
    return this.store;
},
cargarDisponible:function(){
    Ext.Ajax.request({
        method:'GET',
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/CrearPartida/cargarDisponible',
        params:{
            co_partida: CrearPartidaEditar.main.co_partida.getValue(),
            co_numero_fuente:CrearPartidaEditar.main.co_numero_fuente.getValue(),
            co_fuente_financiamiento: CrearPartidaEditar.main.co_fuente_financiamiento.getValue(),
            co_accion_especifica: CrearPartidaEditar.main.co_accion_especifica.getValue()
        },
        success:function(result, request ) {
            obj = Ext.util.JSON.decode(result.responseText);
           
            if(CrearPartidaEditar.main.OBJ.tx_partida=='')            
                CrearPartidaEditar.main.tx_partida.setValue(obj.data.nu_cant_partida);
        }
    });
    
      var str = CrearPartidaEditar.main.co_partida.lastSelectionText;
      var res = str.split("-");
      CrearPartidaEditar.main.tx_descripcion.setValue(res[1].trim());

}
,getStoreCO_NUMERO_FUENTE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkconumerofuente',
        root:'data',
        fields:[
            {name: 'co_numero_fuente'},
            {name: 'tx_numero_fuente'}
            ]
    });
    return this.store;
}
,getStorecoenteejecutor:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcoenteejecutor',
        root:'data',
        fields:[
            {name: 'id'},
            {
                name: 'de_ejecutor',
                convert:function(v,r){
                    return r.de_ejecutor;
                }
            },
            {
                name: 'ejecutor',
                convert:function(v,r){
                    return r.nu_ejecutor+' - '+r.de_ejecutor;
                }
            }
            ]
    });
    return this.store;
}
,getStorecoproyecto:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcoproyecto',
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
}
,getStorecoaccionespecifica:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcoaccionespecifica',
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
,getStoreCO_USUARIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcousuario',
        root:'data',
        fields:[
            {name: 'co_usuario'}
            ]
    });
    return this.store;
}
,getStoreCO_ESTATUS_RUTA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcoestatus',
        root:'data',
        fields:[
            {name: 'co_estatus_ruta'}
            ]
    });
    return this.store;
}
,getStoreCO_USUARIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcousuariocambio',
        root:'data',
        fields:[
            {name: 'co_usuario'}
            ]
    });
    return this.store;
},
getStoreCO_PARTIDA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CrearPartida/storefkcopartida',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_partida',
            convert:function(v,r){
            return r.nu_partida+' - '+r.de_partida;
            }
            }
            ]
    });
    return this.store;
}
};
Ext.onReady(CrearPartidaEditar.main.init, CrearPartidaEditar.main);
</script>
