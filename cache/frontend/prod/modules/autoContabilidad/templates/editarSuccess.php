<script type="text/javascript">
Ext.ns("ContabilidadEditar");
ContabilidadEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_contrato_compras = new Ext.form.Hidden({
    name:'co_contrato_compras',
    value:this.OBJ.co_contrato_compras});
//</ClavePrimaria>


this.co_compras = new Ext.form.NumberField({
	fieldLabel:'Co compras',
	name:'tb056_contrato_compras[co_compras]',
	value:this.OBJ.co_compras,
	allowBlank:false
});

this.fecha_inicio = new Ext.form.DateField({
	fieldLabel:'Fecha inicio',
	name:'tb056_contrato_compras[fecha_inicio]',
	value:this.OBJ.fecha_inicio,
	allowBlank:false,
	width:100
});

this.fecha_fin = new Ext.form.DateField({
	fieldLabel:'Fecha fin',
	name:'tb056_contrato_compras[fecha_fin]',
	value:this.OBJ.fecha_fin,
	allowBlank:false,
	width:100
});

this.co_ramo = new Ext.form.NumberField({
	fieldLabel:'Co ramo',
	name:'tb056_contrato_compras[co_ramo]',
	value:this.OBJ.co_ramo,
	allowBlank:false
});

this.monto = new Ext.form.NumberField({
	fieldLabel:'Monto',
	name:'tb056_contrato_compras[monto]',
	value:this.OBJ.monto,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tb056_contrato_compras[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.fecha_entrega = new Ext.form.DateField({
	fieldLabel:'Fecha entrega',
	name:'tb056_contrato_compras[fecha_entrega]',
	value:this.OBJ.fecha_entrega,
	allowBlank:false,
	width:100
});

this.tiempo_garantia = new Ext.form.TextField({
	fieldLabel:'Tiempo garantia',
	name:'tb056_contrato_compras[tiempo_garantia]',
	value:this.OBJ.tiempo_garantia,
	allowBlank:false,
	width:200
});

this.co_tp_contrato = new Ext.form.NumberField({
	fieldLabel:'Co tp contrato',
	name:'tb056_contrato_compras[co_tp_contrato]',
	value:this.OBJ.co_tp_contrato,
	allowBlank:false
});

this.co_fuente_financiamiento = new Ext.form.NumberField({
	fieldLabel:'Co fuente financiamiento',
	name:'tb056_contrato_compras[co_fuente_financiamiento]',
	value:this.OBJ.co_fuente_financiamiento,
	allowBlank:false
});

this.nu_expediente = new Ext.form.TextField({
	fieldLabel:'Nu expediente',
	name:'tb056_contrato_compras[nu_expediente]',
	value:this.OBJ.nu_expediente,
	allowBlank:false,
	width:200
});

this.co_solicitud_anular = new Ext.form.NumberField({
	fieldLabel:'Co solicitud anular',
	name:'tb056_contrato_compras[co_solicitud_anular]',
	value:this.OBJ.co_solicitud_anular,
	allowBlank:false
});

this.in_anular = new Ext.form.Checkbox({
	fieldLabel:'In anular',
	name:'tb056_contrato_compras[in_anular]',
	checked:(this.OBJ.in_anular=='0') ? true:false,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ContabilidadEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ContabilidadEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/guardar',
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
                 ContabilidadLista.main.store_lista.load();
                 ContabilidadEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ContabilidadEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_contrato_compras,
                    this.co_compras,
                    this.fecha_inicio,
                    this.fecha_fin,
                    this.co_ramo,
                    this.monto,
                    this.created_at,
                    this.fecha_entrega,
                    this.tiempo_garantia,
                    this.co_tp_contrato,
                    this.co_fuente_financiamiento,
                    this.nu_expediente,
                    this.co_solicitud_anular,
                    this.in_anular,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Contabilidad',
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
ContabilidadLista.main.mascara.hide();
}
};
Ext.onReady(ContabilidadEditar.main.init, ContabilidadEditar.main);
</script>
