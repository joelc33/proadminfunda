<script type="text/javascript">
Ext.ns("PresupuestomodificacionEditar");
PresupuestomodificacionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.id_tb095_tipo_modificacion = new Ext.form.ComboBox({
	fieldLabel:'Id tb095 tipo modificacion',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb096_presupuesto_modificacion[id_tb095_tipo_modificacion]',
	//readOnly:(this.OBJ.id_tb095_tipo_modificacion!='')?true:false,
	//style:(this.main.OBJ.id_tb095_tipo_modificacion!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb095_tipo_modificacion',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb095_tipo_modificacion,
	value:  this.OBJ.id_tb095_tipo_modificacion,
	objStore: this.storeID
});

this.nu_modificacion = new Ext.form.TextField({
	fieldLabel:'Nu modificacion',
	name:'tb096_presupuesto_modificacion[nu_modificacion]',
	value:this.OBJ.nu_modificacion,
	allowBlank:false,
	width:200
});

this.fe_modificacion = new Ext.form.DateField({
	fieldLabel:'Fe modificacion',
	name:'tb096_presupuesto_modificacion[fe_modificacion]',
	value:this.OBJ.fe_modificacion,
	allowBlank:false,
	width:100
});

this.de_modificacion = new Ext.form.TextField({
	fieldLabel:'De modificacion',
	name:'tb096_presupuesto_modificacion[de_modificacion]',
	value:this.OBJ.de_modificacion,
	allowBlank:false,
	width:200
});

this.de_justificacion = new Ext.form.TextField({
	fieldLabel:'De justificacion',
	name:'tb096_presupuesto_modificacion[de_justificacion]',
	value:this.OBJ.de_justificacion,
	allowBlank:false,
	width:200
});

this.nu_oficio = new Ext.form.TextField({
	fieldLabel:'Nu oficio',
	name:'tb096_presupuesto_modificacion[nu_oficio]',
	value:this.OBJ.nu_oficio,
	allowBlank:false,
	width:200
});

this.fe_oficio = new Ext.form.DateField({
	fieldLabel:'Fe oficio',
	name:'tb096_presupuesto_modificacion[fe_oficio]',
	value:this.OBJ.fe_oficio,
	allowBlank:false,
	width:100
});

this.de_articulo_ley = new Ext.form.TextField({
	fieldLabel:'De articulo ley',
	name:'tb096_presupuesto_modificacion[de_articulo_ley]',
	value:this.OBJ.de_articulo_ley,
	allowBlank:false,
	width:200
});

this.mo_modificacion = new Ext.form.NumberField({
	fieldLabel:'Mo modificacion',
	name:'tb096_presupuesto_modificacion[mo_modificacion]',
	value:this.OBJ.mo_modificacion,
	allowBlank:false
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tb096_presupuesto_modificacion[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tb096_presupuesto_modificacion[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tb096_presupuesto_modificacion[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.id_tb082_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Id tb082 ejecutor',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'id',
	hiddenName:'tb096_presupuesto_modificacion[id_tb082_ejecutor]',
	//readOnly:(this.OBJ.id_tb082_ejecutor!='')?true:false,
	//style:(this.main.OBJ.id_tb082_ejecutor!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione id_tb082_ejecutor',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb082_ejecutor,
	value:  this.OBJ.id_tb082_ejecutor,
	objStore: this.storeID
});

this.id_tb013_anio_fiscal = new Ext.form.NumberField({
	fieldLabel:'Id tb013 anio fiscal',
	name:'tb096_presupuesto_modificacion[id_tb013_anio_fiscal]',
	value:this.OBJ.id_tb013_anio_fiscal,
	allowBlank:false
});

this.co_usuario = new Ext.form.NumberField({
	fieldLabel:'Co usuario',
	name:'tb096_presupuesto_modificacion[co_usuario]',
	value:this.OBJ.co_usuario,
	allowBlank:false
});

this.co_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co solicitud',
	name:'tb096_presupuesto_modificacion[co_solicitud]',
	value:this.OBJ.co_solicitud,
	allowBlank:false
});

this.co_tipo_solicitud = new Ext.form.NumberField({
	fieldLabel:'Co tipo solicitud',
	name:'tb096_presupuesto_modificacion[co_tipo_solicitud]',
	value:this.OBJ.co_tipo_solicitud,
	allowBlank:false
});

this.id_tb068_numero_fuente_financiamiento = new Ext.form.NumberField({
	fieldLabel:'Id tb068 numero fuente financiamiento',
	name:'tb096_presupuesto_modificacion[id_tb068_numero_fuente_financiamiento]',
	value:this.OBJ.id_tb068_numero_fuente_financiamiento,
	allowBlank:false
});

this.id_tb082_ejecutor_origen = new Ext.form.NumberField({
	fieldLabel:'Id tb082 ejecutor origen',
	name:'tb096_presupuesto_modificacion[id_tb082_ejecutor_origen]',
	value:this.OBJ.id_tb082_ejecutor_origen,
	allowBlank:false
});

this.id_tb082_ejecutor_destino = new Ext.form.NumberField({
	fieldLabel:'Id tb082 ejecutor destino',
	name:'tb096_presupuesto_modificacion[id_tb082_ejecutor_destino]',
	value:this.OBJ.id_tb082_ejecutor_destino,
	allowBlank:false
});

this.id_tb152_tipo_credito = new Ext.form.NumberField({
	fieldLabel:'Id tb152 tipo credito',
	name:'tb096_presupuesto_modificacion[id_tb152_tipo_credito]',
	value:this.OBJ.id_tb152_tipo_credito,
	allowBlank:false
});

this.in_procesado = new Ext.form.Checkbox({
	fieldLabel:'In procesado',
	name:'tb096_presupuesto_modificacion[in_procesado]',
	checked:(this.OBJ.in_procesado=='0') ? true:false,
	allowBlank:false
});

this.id_tb073_fuente_financiamiento = new Ext.form.NumberField({
	fieldLabel:'Id tb073 fuente financiamiento',
	name:'tb096_presupuesto_modificacion[id_tb073_fuente_financiamiento]',
	value:this.OBJ.id_tb073_fuente_financiamiento,
	allowBlank:false
});

this.co_solicitud_anular = new Ext.form.NumberField({
	fieldLabel:'Co solicitud anular',
	name:'tb096_presupuesto_modificacion[co_solicitud_anular]',
	value:this.OBJ.co_solicitud_anular,
	allowBlank:false
});

this.in_anular = new Ext.form.Checkbox({
	fieldLabel:'In anular',
	name:'tb096_presupuesto_modificacion[in_anular]',
	checked:(this.OBJ.in_anular=='0') ? true:false,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PresupuestomodificacionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PresupuestomodificacionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/guardar',
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
                 PresupuestomodificacionLista.main.store_lista.load();
                 PresupuestomodificacionEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PresupuestomodificacionEditar.main.winformPanel_.close();
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
                    this.id_tb095_tipo_modificacion,
                    this.nu_modificacion,
                    this.fe_modificacion,
                    this.de_modificacion,
                    this.de_justificacion,
                    this.nu_oficio,
                    this.fe_oficio,
                    this.de_articulo_ley,
                    this.mo_modificacion,
                    this.in_activo,
                    this.created_at,
                    this.updated_at,
                    this.id_tb082_ejecutor,
                    this.id_tb013_anio_fiscal,
                    this.co_usuario,
                    this.co_solicitud,
                    this.co_tipo_solicitud,
                    this.id_tb068_numero_fuente_financiamiento,
                    this.id_tb082_ejecutor_origen,
                    this.id_tb082_ejecutor_destino,
                    this.id_tb152_tipo_credito,
                    this.in_procesado,
                    this.id_tb073_fuente_financiamiento,
                    this.co_solicitud_anular,
                    this.in_anular,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Presupuestomodificacion',
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
PresupuestomodificacionLista.main.mascara.hide();
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/storefkidtb095tipomodificacion',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuestomodificacion/storefkidtb082ejecutor',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}
};
Ext.onReady(PresupuestomodificacionEditar.main.init, PresupuestomodificacionEditar.main);
</script>
