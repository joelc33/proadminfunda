<script type="text/javascript">
Ext.ns("PartidapresupuestoEditar");
PartidapresupuestoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CLASIFICACION_ECONOMICA = this.getStoreCO_CLASIFICACION_ECONOMICA();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.id_tb084_accion_especifica = new Ext.form.ComboBox({
	fieldLabel:'Id tb084 accion especifica',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb085_presupuesto[id_tb084_accion_especifica]',
	//readOnly:(this.OBJ.id_tb084_accion_especifica!='')?true:false,
	//style:(this.main.OBJ.id_tb084_accion_especifica!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb084_accion_especifica',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb084_accion_especifica,
	value:  this.OBJ.id_tb084_accion_especifica,
	objStore: this.storeID
});

this.nu_partida = new Ext.form.TextField({
	fieldLabel:'Nu partida',
	name:'tb085_presupuesto[nu_partida]',
	value:this.OBJ.nu_partida,
	allowBlank:false,
	width:200
});

this.de_partida = new Ext.form.TextField({
	fieldLabel:'De partida',
	name:'tb085_presupuesto[de_partida]',
	value:this.OBJ.de_partida,
	allowBlank:false,
	width:200
});

this.mo_inicial = new Ext.form.NumberField({
	fieldLabel:'Mo inicial',
	name:'tb085_presupuesto[mo_inicial]',
	value:this.OBJ.mo_inicial,
	allowBlank:false
});

this.mo_actualizado = new Ext.form.NumberField({
	fieldLabel:'Mo actualizado',
	name:'tb085_presupuesto[mo_actualizado]',
	value:this.OBJ.mo_actualizado,
	allowBlank:false
});

this.mo_precomprometido = new Ext.form.NumberField({
	fieldLabel:'Mo precomprometido',
	name:'tb085_presupuesto[mo_precomprometido]',
	value:this.OBJ.mo_precomprometido,
	allowBlank:false
});

this.mo_comprometido = new Ext.form.NumberField({
	fieldLabel:'Mo comprometido',
	name:'tb085_presupuesto[mo_comprometido]',
	value:this.OBJ.mo_comprometido,
	allowBlank:false
});

this.mo_causado = new Ext.form.NumberField({
	fieldLabel:'Mo causado',
	name:'tb085_presupuesto[mo_causado]',
	value:this.OBJ.mo_causado,
	allowBlank:false
});

this.mo_pagado = new Ext.form.NumberField({
	fieldLabel:'Mo pagado',
	name:'tb085_presupuesto[mo_pagado]',
	value:this.OBJ.mo_pagado,
	allowBlank:false
});

this.mo_disponible = new Ext.form.NumberField({
	fieldLabel:'Mo disponible',
	name:'tb085_presupuesto[mo_disponible]',
	value:this.OBJ.mo_disponible,
	allowBlank:false
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tb085_presupuesto[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tb085_presupuesto[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tb085_presupuesto[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.in_movimiento = new Ext.form.Checkbox({
	fieldLabel:'In movimiento',
	name:'tb085_presupuesto[in_movimiento]',
	checked:(this.OBJ.in_movimiento=='0') ? true:false,
	allowBlank:false
});

this.nu_pa = new Ext.form.TextField({
	fieldLabel:'Nu pa',
	name:'tb085_presupuesto[nu_pa]',
	value:this.OBJ.nu_pa,
	allowBlank:false,
	width:200
});

this.nu_ge = new Ext.form.TextField({
	fieldLabel:'Nu ge',
	name:'tb085_presupuesto[nu_ge]',
	value:this.OBJ.nu_ge,
	allowBlank:false,
	width:200
});

this.nu_es = new Ext.form.TextField({
	fieldLabel:'Nu es',
	name:'tb085_presupuesto[nu_es]',
	value:this.OBJ.nu_es,
	allowBlank:false,
	width:200
});

this.nu_se = new Ext.form.TextField({
	fieldLabel:'Nu se',
	name:'tb085_presupuesto[nu_se]',
	value:this.OBJ.nu_se,
	allowBlank:false,
	width:200
});

this.nu_sse = new Ext.form.TextField({
	fieldLabel:'Nu sse',
	name:'tb085_presupuesto[nu_sse]',
	value:this.OBJ.nu_sse,
	allowBlank:false,
	width:200
});

this.co_partida = new Ext.form.TextField({
	fieldLabel:'Co partida',
	name:'tb085_presupuesto[co_partida]',
	value:this.OBJ.co_partida,
	allowBlank:false,
	width:200
});

this.nu_nivel = new Ext.form.NumberField({
	fieldLabel:'Nu nivel',
	name:'tb085_presupuesto[nu_nivel]',
	value:this.OBJ.nu_nivel,
	allowBlank:false
});

this.nu_fi = new Ext.form.TextField({
	fieldLabel:'Nu fi',
	name:'tb085_presupuesto[nu_fi]',
	value:this.OBJ.nu_fi,
	allowBlank:false,
	width:200
});

this.co_categoria = new Ext.form.TextField({
	fieldLabel:'Co categoria',
	name:'tb085_presupuesto[co_categoria]',
	value:this.OBJ.co_categoria,
	allowBlank:false,
	width:200
});

this.nu_aplicacion = new Ext.form.TextField({
	fieldLabel:'Nu aplicacion',
	name:'tb085_presupuesto[nu_aplicacion]',
	value:this.OBJ.nu_aplicacion,
	allowBlank:false,
	width:200
});

this.tp_ingreso = new Ext.form.TextField({
	fieldLabel:'Tp ingreso',
	name:'tb085_presupuesto[tp_ingreso]',
	value:this.OBJ.tp_ingreso,
	allowBlank:false,
	width:200
});

this.co_cuenta_contable = new Ext.form.NumberField({
	fieldLabel:'Co cuenta contable',
	name:'tb085_presupuesto[co_cuenta_contable]',
	value:this.OBJ.co_cuenta_contable,
	allowBlank:false
});

this.tip_apl = new Ext.form.TextField({
	fieldLabel:'Tip apl',
	name:'tb085_presupuesto[tip_apl]',
	value:this.OBJ.tip_apl,
	allowBlank:false,
	width:200
});

this.in_gen_cheque = new Ext.form.Checkbox({
	fieldLabel:'In gen cheque',
	name:'tb085_presupuesto[in_gen_cheque]',
	checked:(this.OBJ.in_gen_cheque=='0') ? true:false,
	allowBlank:false
});

this.tip_gasto = new Ext.form.TextField({
	fieldLabel:'Tip gasto',
	name:'tb085_presupuesto[tip_gasto]',
	value:this.OBJ.tip_gasto,
	allowBlank:false,
	width:200
});

this.tip_ing = new Ext.form.TextField({
	fieldLabel:'Tip ing',
	name:'tb085_presupuesto[tip_ing]',
	value:this.OBJ.tip_ing,
	allowBlank:false,
	width:200
});

this.cod_amb = new Ext.form.TextField({
	fieldLabel:'Cod amb',
	name:'tb085_presupuesto[cod_amb]',
	value:this.OBJ.cod_amb,
	allowBlank:false,
	width:200
});

this.co_ente = new Ext.form.NumberField({
	fieldLabel:'Co ente',
	name:'tb085_presupuesto[co_ente]',
	value:this.OBJ.co_ente,
	allowBlank:false
});

this.nu_anio = new Ext.form.NumberField({
	fieldLabel:'Nu anio',
	name:'tb085_presupuesto[nu_anio]',
	value:this.OBJ.nu_anio,
	allowBlank:false
});

this.mo_disponible_act = new Ext.form.NumberField({
	fieldLabel:'Mo disponible act',
	name:'tb085_presupuesto[mo_disponible_act]',
	value:this.OBJ.mo_disponible_act,
	allowBlank:false
});

this.mo_aumento = new Ext.form.NumberField({
	fieldLabel:'Mo aumento',
	name:'tb085_presupuesto[mo_aumento]',
	value:this.OBJ.mo_aumento,
	allowBlank:false
});

this.mo_disminucion = new Ext.form.NumberField({
	fieldLabel:'Mo disminucion',
	name:'tb085_presupuesto[mo_disminucion]',
	value:this.OBJ.mo_disminucion,
	allowBlank:false
});

this.mo_admon = new Ext.form.NumberField({
	fieldLabel:'Mo admon',
	name:'tb085_presupuesto[mo_admon]',
	value:this.OBJ.mo_admon,
	allowBlank:false
});

this.mo_actualizado_ant = new Ext.form.NumberField({
	fieldLabel:'Mo actualizado ant',
	name:'tb085_presupuesto[mo_actualizado_ant]',
	value:this.OBJ.mo_actualizado_ant,
	allowBlank:false
});

this.comprometido_dia = new Ext.form.NumberField({
	fieldLabel:'Comprometido dia',
	name:'tb085_presupuesto[comprometido_dia]',
	value:this.OBJ.comprometido_dia,
	allowBlank:false
});

this.causado_dia = new Ext.form.NumberField({
	fieldLabel:'Causado dia',
	name:'tb085_presupuesto[causado_dia]',
	value:this.OBJ.causado_dia,
	allowBlank:false
});

this.pagado_dia = new Ext.form.NumberField({
	fieldLabel:'Pagado dia',
	name:'tb085_presupuesto[pagado_dia]',
	value:this.OBJ.pagado_dia,
	allowBlank:false
});

this.disponible = new Ext.form.NumberField({
	fieldLabel:'Disponible',
	name:'tb085_presupuesto[disponible]',
	value:this.OBJ.disponible,
	allowBlank:false
});

this.cod_ente = new Ext.form.TextField({
	fieldLabel:'Cod ente',
	name:'tb085_presupuesto[cod_ente]',
	value:this.OBJ.cod_ente,
	allowBlank:false,
	width:200
});

this.nu_sector = new Ext.form.TextField({
	fieldLabel:'Nu sector',
	name:'tb085_presupuesto[nu_sector]',
	value:this.OBJ.nu_sector,
	allowBlank:false,
	width:200
});

this.id_tb139_aplicacion = new Ext.form.NumberField({
	fieldLabel:'Id tb139 aplicacion',
	name:'tb085_presupuesto[id_tb139_aplicacion]',
	value:this.OBJ.id_tb139_aplicacion,
	allowBlank:false
});

this.mo_admon_ant = new Ext.form.NumberField({
	fieldLabel:'Mo admon ant',
	name:'tb085_presupuesto[mo_admon_ant]',
	value:this.OBJ.mo_admon_ant,
	allowBlank:false
});

this.mo_modificado_admon = new Ext.form.NumberField({
	fieldLabel:'Mo modificado admon',
	name:'tb085_presupuesto[mo_modificado_admon]',
	value:this.OBJ.mo_modificado_admon,
	allowBlank:false
});

this.co_clasificacion_economica = new Ext.form.ComboBox({
	fieldLabel:'Co clasificacion economica',
	store: this.storeCO_CLASIFICACION_ECONOMICA,
	typeAhead: true,
	valueField: 'co_clasificacion_economica',
	displayField:'co_clasificacion_economica',
	hiddenName:'tb085_presupuesto[co_clasificacion_economica]',
	//readOnly:(this.OBJ.co_clasificacion_economica!='')?true:false,
	//style:(this.main.OBJ.co_clasificacion_economica!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione co_clasificacion_economica',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_CLASIFICACION_ECONOMICA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_clasificacion_economica,
	value:  this.OBJ.co_clasificacion_economica,
	objStore: this.storeCO_CLASIFICACION_ECONOMICA
});

this.co_area_estrategica = new Ext.form.NumberField({
	fieldLabel:'Co area estrategica',
	name:'tb085_presupuesto[co_area_estrategica]',
	value:this.OBJ.co_area_estrategica,
	allowBlank:false
});

this.mo_inicial_soberano = new Ext.form.NumberField({
	fieldLabel:'Mo inicial soberano',
	name:'tb085_presupuesto[mo_inicial_soberano]',
	value:this.OBJ.mo_inicial_soberano,
	allowBlank:false
});

this.mo_actualizado_soberano = new Ext.form.NumberField({
	fieldLabel:'Mo actualizado soberano',
	name:'tb085_presupuesto[mo_actualizado_soberano]',
	value:this.OBJ.mo_actualizado_soberano,
	allowBlank:false
});

this.mo_comprometido_soberano = new Ext.form.NumberField({
	fieldLabel:'Mo comprometido soberano',
	name:'tb085_presupuesto[mo_comprometido_soberano]',
	value:this.OBJ.mo_comprometido_soberano,
	allowBlank:false
});

this.mo_causado_soberano = new Ext.form.NumberField({
	fieldLabel:'Mo causado soberano',
	name:'tb085_presupuesto[mo_causado_soberano]',
	value:this.OBJ.mo_causado_soberano,
	allowBlank:false
});

this.mo_pagado_soberano = new Ext.form.NumberField({
	fieldLabel:'Mo pagado soberano',
	name:'tb085_presupuesto[mo_pagado_soberano]',
	value:this.OBJ.mo_pagado_soberano,
	allowBlank:false
});

this.mo_disponible_soberano = new Ext.form.NumberField({
	fieldLabel:'Mo disponible soberano',
	name:'tb085_presupuesto[mo_disponible_soberano]',
	value:this.OBJ.mo_disponible_soberano,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PartidapresupuestoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PartidapresupuestoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/guardar',
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
                 PartidapresupuestoLista.main.store_lista.load();
                 PartidapresupuestoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PartidapresupuestoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
                    this.id_tb084_accion_especifica,
                    this.nu_partida,
                    this.de_partida,
                    this.mo_inicial,
                    this.mo_actualizado,
                    this.mo_precomprometido,
                    this.mo_comprometido,
                    this.mo_causado,
                    this.mo_pagado,
                    this.mo_disponible,
                    this.in_activo,
                    this.created_at,
                    this.updated_at,
                    this.in_movimiento,
                    this.nu_pa,
                    this.nu_ge,
                    this.nu_es,
                    this.nu_se,
                    this.nu_sse,
                    this.co_partida,
                    this.nu_nivel,
                    this.nu_fi,
                    this.co_categoria,
                    this.nu_aplicacion,
                    this.tp_ingreso,
                    this.co_cuenta_contable,
                    this.tip_apl,
                    this.in_gen_cheque,
                    this.tip_gasto,
                    this.tip_ing,
                    this.cod_amb,
                    this.co_ente,
                    this.nu_anio,
                    this.mo_disponible_act,
                    this.mo_aumento,
                    this.mo_disminucion,
                    this.mo_admon,
                    this.mo_actualizado_ant,
                    this.comprometido_dia,
                    this.causado_dia,
                    this.pagado_dia,
                    this.disponible,
                    this.cod_ente,
                    this.nu_sector,
                    this.id_tb139_aplicacion,
                    this.mo_admon_ant,
                    this.mo_modificado_admon,
                    this.co_clasificacion_economica,
                    this.co_area_estrategica,
                    this.mo_inicial_soberano,
                    this.mo_actualizado_soberano,
                    this.mo_comprometido_soberano,
                    this.mo_causado_soberano,
                    this.mo_pagado_soberano,
                    this.mo_disponible_soberano,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Partidapresupuesto',
    modal:true,
    constrain:true,
width:400,
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
PartidapresupuestoLista.main.mascara.hide();
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storefkidtb084accionespecifica',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreCO_CLASIFICACION_ECONOMICA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partidapresupuesto/storefkcoclasificacioneconomica',
        root:'data',
        fields:[
            {name: 'co_clasificacion_economica'}
            ]
    });
    return this.store;
}
};
Ext.onReady(PartidapresupuestoEditar.main.init, PartidapresupuestoEditar.main);
</script>
