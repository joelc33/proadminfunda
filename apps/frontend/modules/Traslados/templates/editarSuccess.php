<script type="text/javascript">
Ext.ns("TrasladosEditar");
TrasladosEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.storeCO_CARGO_ESTRUCTURA = this.getStoreCO_CARGO_ESTRUCTURA();
//<ClavePrimaria>
this.storeCO_NOMINA         = this.getStoreCO_TP_NOMINA();
this.storeCO_CARGO          = this.getStoreCO_CARGO();
this.storeCO_TIPO_CARGO      = this.getStoreCO_TIPO_CARGO();
this.storeCO_TIPO_PAGO      = this.getStoreCO_TIPO_PAGO();
this.storeCO_GRUPO_NOMINA   = this.getStoreCO_GRUPO_NOMINA();
this.storeCO_TABULADOR   = this.getStoreCO_TABULADOR();

this.co_estructura_administrativa = new Ext.form.Hidden({
    name:'co_estructura_administrativa'
});

this.co_ficha = new Ext.form.Hidden({
    name:'co_ficha'
});

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud
});

this.tx_tp_nomina = new Ext.form.Hidden({
    name:'tx_tp_nomina'
});

this.tx_grupo_nomina = new Ext.form.Hidden({
    name:'tx_grupo_nomina'
});

this.tx_cargo_estructura = new Ext.form.Hidden({
    name:'tx_cargo_estructura'
});

this.tx_tipo_cargo = new Ext.form.Hidden({
    name:'tx_tipo_cargo'
});

this.co_clasif_personal = new Ext.form.Hidden({
    name:'co_clasif_personal'
});

this.cedula_trabajador = new Ext.form.NumberField({
        fieldLabel:'Cedula',
        name:'cedula_trabajador',
        width:145,
        allowBlank:false
});

this.cedula_trabajador.on("blur",function(){
    TrasladosEditar.main.verificarTrabajador();
});

this.nombre_trabajador = new Ext.form.TextField({
        fieldLabel:'Trabajador',
	name:'nombre_trabajador',
        readOnly:true,
	style:'background:#c9c9c9;',
	allowBlank:false,
	width:350
});

this.co_cargo_estructura = new Ext.form.ComboBox({
        fieldLabel:'Cargo Estructura',
        store: this.storeCO_CARGO_ESTRUCTURA,
        typeAhead: true,
        valueField: 'co_nom_trabajador',
        displayField:'tx_nom_estructura_administrativa',
        hiddenName:'co_nom_trabajador',
        forceSelection:true,
        resizable:true,
        triggerAction: 'all',
        selectOnFocus: true,
        mode: 'local',
        allowBlank:false,
        width:350
});

this.co_cargo_estructura.on('select',function(cmb,record,index){
TrasladosEditar.main.nomina.setValue(record.get('tx_tp_nomina'));   
TrasladosEditar.main.grupo_nomina.setValue(record.get('tx_grupo_nomina'));
TrasladosEditar.main.tipo_cargo.setValue(record.get('tx_tipo_cargo'));
},this);

this.nomina = new Ext.form.TextField({
        fieldLabel:'Nomina',
	name:'nomina',
        readOnly:true,
	style:'background:#c9c9c9;',
	allowBlank:false,
	width:145
});

this.grupo_nomina = new Ext.form.TextField({
        fieldLabel:'Grupo Nomina',
	name:'grupo_nomina',
        readOnly:true,
	style:'background:#c9c9c9;',
	allowBlank:false,
	width:145
});

this.tipo_cargo = new Ext.form.TextField({
        fieldLabel:'Tipo de Cargo',
	name:'tipo_cargo',
        readOnly:true,
	style:'background:#c9c9c9;',
	allowBlank:false,
	width:145
});

this.estructura = new Ext.form.TextArea({
        name:'estructura',
        width:400,
        readOnly:true,
        allowBlank:false,
        style:'background:#c9c9c9;'
});
            
this.buscarEstructura = new Ext.Button({
    text:'Seleccionar Estructura',
//    iconCls: 'icon-cancelar',
    handler:function(){
        this.msg = Ext.get('buscarEstructura');
        this.msg.load({
         url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/CargoEstructura/buscar",
         params:{paquete:'TrasladosEditar'},
         scripts: true,
         text: "Cargando.."
        }); 
    }
});
            
            
this.fieldDatosEstructura = new Ext.form.FieldSet({ 
        title: 'Estructura Administrativa',
        width:660,
        items:[{
                        xtype: 'compositefield',
                        fieldLabel: 'Descripción de Ubicación',
                        items: [
                            this.co_ficha,
                            this.co_solicitud,
                            this.tx_tp_nomina,
                            this.tx_grupo_nomina,
                            this.tx_cargo_estructura,
                            this.tx_tipo_cargo,
                            this.co_estructura_administrativa,
                            this.estructura,
                            this.buscarEstructura
                        ]
              }]
});

this.co_tp_nomina = new Ext.form.ComboBox({
        fieldLabel:'Nomina',
        store: this.storeCO_NOMINA,
        typeAhead: true,
        valueField: 'co_tp_nomina',
        displayField:'tx_tp_nomina',
        hiddenName:'co_tp_nomina',
        forceSelection:true,
        resizable:true,
        triggerAction: 'all',
        selectOnFocus: true,
        mode: 'local',
        width:250,
        allowBlank:false,
        listeners:{
            select: function(combo, rec, index){
                TrasladosEditar.main.co_clasif_personal.setValue(rec.data.co_clasif_personal);
                TrasladosEditar.main.co_tabulador.clearValue();
                TrasladosEditar.main.co_grupo_nomina.clearValue();
                TrasladosEditar.main.mo_sueldo.setValue("");
                TrasladosEditar.main.storeCO_TABULADOR.baseParams.co_clasif_personal=TrasladosEditar.main.co_clasif_personal.getValue();
                TrasladosEditar.main.storeCO_TABULADOR.load();                            
                TrasladosEditar.main.storeCO_CARGO.baseParams.co_estructura_administrativa=TrasladosEditar.main.co_estructura_administrativa.getValue();
                TrasladosEditar.main.storeCO_CARGO.baseParams.co_clasif_personal=rec.data.co_clasif_personal;
                TrasladosEditar.main.storeCO_CARGO.load();                
                TrasladosEditar.main.storeCO_GRUPO_NOMINA.baseParams.co_tp_nomina=this.getValue();
                TrasladosEditar.main.storeCO_GRUPO_NOMINA.load();
            }
        }
});

this.storeCO_NOMINA.load();

this.co_tp_nomina.on('select',function(cmb,record,index){
TrasladosEditar.main.tx_tp_nomina.setValue(record.get('tx_tp_nomina'));   
},this);

this.co_grupo_nomina = new Ext.form.ComboBox({
        fieldLabel:'Grupo',
        store: this.storeCO_GRUPO_NOMINA,
        typeAhead: true,
        valueField: 'co_grupo_nomina',
        displayField:'tx_grupo_nomina',
        hiddenName:'co_grupo_nomina',
        forceSelection:true,
        resizable:true,
        triggerAction: 'all',
        selectOnFocus: true,
        mode: 'local',
        width:250,
        allowBlank:false
});

this.storeCO_GRUPO_NOMINA.load({
    params:{
      co_tp_nomina: TrasladosEditar.main.OBJ.co_tp_nomina   
    }
});

this.co_grupo_nomina.on('select',function(cmb,record,index){
TrasladosEditar.main.tx_grupo_nomina.setValue(record.get('tx_grupo_nomina'));   
},this);

this.co_cargo = new Ext.form.ComboBox({
        fieldLabel:'Cargo',
        store: this.storeCO_CARGO,
        typeAhead: true,
        valueField: 'co_cargo_estructura',
        displayField:'tx_cargo',
        hiddenName:'co_cargo_estructura',
        forceSelection:true,
        resizable:true,
        triggerAction: 'all',
        selectOnFocus: true,
        mode: 'local',
        width:500,
        allowBlank:false,
        listeners:{
            select: function(){
               TrasladosEditar.main.mo_sueldo.setValue("");
               if(TrasladosEditar.main.co_tipo_pago.getValue()==1)
                TrasladosEditar.main.verificarSueldo();
            }
        }
});

this.storeCO_CARGO.load();

this.co_cargo.on('select',function(cmb,record,index){
TrasladosEditar.main.tx_cargo_estructura.setValue(record.get('tx_cargo'));   
},this);

this.co_tipo_pago = new Ext.form.ComboBox({
        fieldLabel:'Tipo de Pago',
        store: this.storeCO_TIPO_PAGO,
        typeAhead: true,
        valueField: 'co_tipo_pago',
        displayField:'tx_tipo_pago',
        hiddenName:'co_tipo_pago',
        forceSelection:true,
        resizable:true,
        triggerAction: 'all',
        selectOnFocus: true,
        mode: 'local',
        width:200,
        listeners:{
            select: function(){
               TrasladosEditar.main.mo_sueldo.setValue("");
               TrasladosEditar.main.co_tabulador.clearValue();
               if(TrasladosEditar.main.co_tipo_pago.getValue()==1){
                    TrasladosEditar.main.mo_sueldo.setReadOnly(true);
                }else{
                    TrasladosEditar.main.mo_sueldo.setReadOnly(false);
                }
            }
        }
});

this.storeCO_TIPO_PAGO.load();


this.mo_sueldo = new Ext.form.NumberField({
        fieldLabel:'Sueldo',
        name:'mo_salario_base',
        width:145,
        allowBlank:false
});

this.nu_horas = new Ext.form.NumberField({
        fieldLabel:'Horas',
        name:'nu_horas',
        width:145,
        allowBlank:false
});

this.fe_traslado = new Ext.form.DateField({
        fieldLabel:'Fecha Traslado',
        name:'fe_traslado',
	allowBlank:false,
        width:100
});

this.co_tp_cargo = new Ext.form.ComboBox({
        fieldLabel:'Tipo de Cargo',
        store: this.storeCO_TIPO_CARGO,
        typeAhead: true,
        valueField: 'co_tp_cargo',
        displayField:'tx_tipo_cargo',
        hiddenName:'co_tp_cargo',
        forceSelection:true,
        resizable:true,
        triggerAction: 'all',
        selectOnFocus: true,
        mode: 'local',
        width:250,
        allowBlank:false
});

this.storeCO_TIPO_CARGO.load();

this.co_tp_cargo.on('select',function(cmb,record,index){
TrasladosEditar.main.tx_tipo_cargo.setValue(record.get('tx_tipo_cargo'));   
},this);
        
this.co_tipo_pago.on('select',function(cmb,record,index){
if(cmb.getValue()==1){
TrasladosEditar.main.co_tabulador.show();
}else{ 
TrasladosEditar.main.co_tabulador.hide();    
}    
},this);        

this.co_tabulador = new Ext.form.ComboBox({
        fieldLabel:'Tabulador',
        store: this.storeCO_TABULADOR,
        typeAhead: true,
        valueField: 'co_tabulador',
        displayField:'nu_codigo_tab',
        hiddenName:'co_tabulador',
        forceSelection:true,
        resizable:true,
        triggerAction: 'all',
        selectOnFocus: true,
        mode: 'local',
        width:250
});
this.co_tabulador.hide();
this.storeCO_TABULADOR.load();
this.co_tabulador.on('select',function(cmb,record,index){
TrasladosEditar.main.mo_sueldo.setValue(record.get('mo_sueldo'));   
},this);
       
this.fieldDatos = new Ext.form.FieldSet({ 
        title: 'Datos del Cargo y Nomina',
        width:700,
        items:[this.co_tp_nomina,
                this.co_grupo_nomina,
                this.co_cargo,
                this.co_tp_cargo,
                this.nu_horas,
                this.fe_traslado,
                this.co_tipo_pago,
                this.co_tabulador,
                this.mo_sueldo]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!TrasladosEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        
        if(TrasladosEditar.main.co_tipo_pago.getValue()==1){
            if(TrasladosEditar.main.co_tabulador.getValue()==''){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        }        
        
        TrasladosEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Traslados/guardar',
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
                 TrasladosLista.main.store_lista.load();
                 TrasladosEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        TrasladosEditar.main.winformPanel_.close();
    }
});


this.fieldUbicacion= new Ext.form.FieldSet({ 
        title: 'Ubicacion Trabajdor',
        width:700,
        items:[
        this.cedula_trabajador,
        this.nombre_trabajador,
        this.co_cargo_estructura,
        this.nomina,
        this.grupo_nomina,
        this.tipo_cargo
        ]
});

this.fieldNuevaUbicacion= new Ext.form.FieldSet({ 
        title: 'Nueva Ubicacion Trabajdor',
        width:700,
        items:[
        this.fieldDatosEstructura,
        this.fieldDatos
        ]
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:750,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
                    this.fieldUbicacion,this.fieldNuevaUbicacion
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Nuevo Traslado',
    modal:true,
    constrain:true,
   width:750,
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
TrasladosLista.main.mascara.hide();
}
,getStoreCO_CARGO_ESTRUCTURA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Traslados/storefkcocargoestructura',
        root:'data',
        fields:[
            {name: 'co_nom_trabajador'},
            {name: 'tx_tp_nomina'},
            {name: 'tx_grupo_nomina'},
            {name: 'tx_tipo_cargo'},
            {name: 'tx_nom_estructura_administrativa',
              convert:function(v,r){
                return r.tx_nom_estructura_administrativa+' - '+r.tx_cargo;
              }
            }
            ]
    });
    return this.store;
},
verificarTrabajador:function(){
    Ext.Ajax.request({
        method:'GET',
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Traslados/verificarTrabajador',
        params:{
            nu_cedula: TrasladosEditar.main.cedula_trabajador.getValue()
        },
        success:function(result, request ) {
            obj = Ext.util.JSON.decode(result.responseText);
            if(obj.data){

        TrasladosEditar.main.nombre_trabajador.setValue(obj.data.nb_primer_nombre+' '+obj.data.nb_segundo_nombre+' '+obj.data.nb_primer_apellido+' '+obj.data.nb_segundo_apellido);      
                TrasladosEditar.main.co_ficha.setValue(obj.data.co_ficha);
                TrasladosEditar.main.storeCO_CARGO_ESTRUCTURA.baseParams.co_ficha=obj.data.co_ficha;
                TrasladosEditar.main.storeCO_CARGO_ESTRUCTURA.load();
            }else{
                
                TrasladosEditar.main.co_ficha.setValue('');
                TrasladosEditar.main.nomina.setValue('');
                TrasladosEditar.main.grupo_nomina.setValue('');
                TrasladosEditar.main.tipo_cargo.setValue('');     
                TrasladosEditar.main.nombre_trabajador.setValue('');
                TrasladosEditar.main.storeCO_CARGO_ESTRUCTURA.removeAll();
                TrasladosEditar.main.co_cargo_estructura.clearValue();

                Ext.Msg.show({
                    title : 'ALERTA',
                    msg : 'El Numero de cedula no se encuentra registrado como trabajador, Verifique',
                    width : 400,
                    height : 800,
                    closable : false,
                    buttons : Ext.Msg.OK,
                    icon : Ext.Msg.INFO
                });                
        }
        }
    });
},
verificarSueldo(){
Ext.Ajax.request({
    method:'GET',
    url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Trabajador/verificarSueldo',
    params:{
        co_cargo_estructura: TrasladosEditar.main.co_cargo.getValue()
    },
    success:function(result, request ) {
        obj = Ext.util.JSON.decode(result.responseText);
        if(obj.data){

            TrasladosEditar.main.mo_sueldo.setValue(obj.data.mo_sueldo);                       

        }
    }
});
},
getStoreCO_TP_NOMINA(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkconomina',
        root:'data',
        fields:[
                {name: 'co_tp_nomina'},
                {name: 'tx_tp_nomina'},
                {name: 'co_clasif_personal'}
            ]
    });
    return this.store;
},
getStoreCO_CARGO(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcocargo',
        root:'data',
        fields:[
                {name: 'co_cargo_estructura'},
                {name: 'tx_cargo'}
            ]
    });
    return this.store;
},
getStoreCO_TIPO_CARGO(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcotipocargo',
        root:'data',
        fields:[
                {name: 'co_tp_cargo'},
                {name: 'tx_tipo_cargo'}
            ]
    });
    return this.store;
},
getStoreCO_TIPO_PAGO(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcotipopago',
        root:'data',
        fields:[
                {name: 'co_tipo_pago'},
                {name: 'tx_tipo_pago'}
            ]
    });
    return this.store;
},
getStoreCO_GRUPO_NOMINA(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcogruponomina',
        root:'data',
        fields:[
                {name: 'co_grupo_nomina'},
                {name: 'tx_grupo_nomina'}
            ]
    });
    return this.store;
},
getStoreCO_TABULADOR(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcotabulador',
        root:'data',
        fields:[
                {name: 'co_tabulador'},
                {name: 'nu_codigo_tab'},
                {name: 'mo_sueldo'}
            ]
    });
    return this.store;
}

};
Ext.onReady(TrasladosEditar.main.init, TrasladosEditar.main);
</script>
<div id="buscarEstructura"></div>