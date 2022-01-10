<script type="text/javascript">
Ext.ns("RequisicionEditar");
RequisicionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_SERVICIO = this.getStoreCO_SERVICIO();

 
//<ClavePrimaria>
this.co_requisicion = new Ext.form.Hidden({
    name:'co_requisicion',
    value:this.OBJ.co_requisicion});

this.co_ente = new Ext.form.Hidden({
    name:'tb039_requisiciones[co_ente]',
    value:this.OBJ.co_ente});

this.co_tipo_solicitud = new Ext.form.Hidden({
    name:'tb039_requisiciones[co_tipo_solicitud]',
    value:this.OBJ.co_tipo_solicitud});

this.co_solicitud = new Ext.form.Hidden({
    name:'tb039_requisiciones[co_solicitud]',
    value:this.OBJ.co_solicitud});
//</ClavePrimaria>

this.datos  = '<p class="registro_detalle"><b>Solicitante: </b>'+this.OBJ.nb_solicitante+'</p>';
this.datos += '<p class="registro_detalle"><b>Entidad: </b>'+this.OBJ.tx_entidad+'</p>';
this.datos +='<p class="registro_detalle"><b>Fecha: </b>'+this.OBJ.fe_registro+'</p>';

this.fieldDatos= new Ext.form.FieldSet({
        title: 'Datos del Solicitante',
        html: this.datos
});

this.co_servicio = new Ext.form.ComboBox({
	fieldLabel:'Servicio',
	store: this.storeCO_SERVICIO,
	typeAhead: true,
	valueField: 'co_servicio',
	displayField:'tx_servicio',
	hiddenName:'tb039_requisiciones[co_servicio]',
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

this.storeCO_SERVICIO.load();
paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_servicio,
	value:  this.OBJ.co_servicio,
	objStore: this.storeCO_SERVICIO
});

this.tx_concepto = new Ext.form.TextField({
	fieldLabel:'Concepto',
	name:'tb039_requisiciones[tx_concepto]',
	value:this.OBJ.tx_concepto,
	allowBlank:false,
	width:680
});

this.tx_observacion = new Ext.form.TextArea({
	fieldLabel:'Observaciones',
	name:'tb039_requisiciones[tx_observacion]',
	value:this.OBJ.tx_observacion,
	width:680
});

this.fieldDatosRequisicion= new Ext.form.FieldSet({
    title: 'Datos de la Requisición del Servicio',
    items:[this.co_servicio,
           this.tx_concepto,
           this.tx_observacion]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!RequisicionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        
        RequisicionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/guardar',
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
                
                 RequisicionEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        RequisicionEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:850,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[         this.co_ente,
                    this.co_solicitud,
                    this.co_tipo_solicitud,
                    this.co_requisicion,
                    this.fieldDatos,
                    this.fieldDatosRequisicion
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Requisicion',
    modal:true,
    constrain:true,
    width:850,
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
}
,getStoreCO_SERVICIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/storefkcoservicio',
        root:'data',
        fields:[
            {name: 'co_servicio'},
            {name: 'tx_servicio'}
            ]
    });
    return this.store;
}
};
Ext.onReady(RequisicionEditar.main.init, RequisicionEditar.main);
</script>
<div id="formularioAgregar"></div>