<script type="text/javascript">
Ext.ns("NominaMovimientoEditarConcepto");
NominaMovimientoEditarConcepto.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id
});
//</ClavePrimaria>

this.id_tbrh014_concepto = new Ext.form.Hidden({
    name:'tbrh061_nomina_movimiento[id_tbrh014_concepto]',
    value:this.OBJ.id_tbrh014_concepto
});

this.tx_tp_concepto = new Ext.form.TextField({
	fieldLabel:'Tipo',
	name:'tbrh020_tp_concepto[tx_tp_concepto]',
	value:this.OBJ.tx_tp_concepto,
	allowBlank:false,
	readOnly:true,
	style:'background:#c9c9c9;',
	width:200
});

this.nu_concepto = new Ext.form.TextField({
	fieldLabel:'Codigo',
	name:'tbrh014_concepto[nu_concepto]',
	value:this.OBJ.nu_concepto,
	allowBlank:false,
	readOnly:true,
	style:'background:#c9c9c9;',
	width:100
});

this.de_concepto = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tbrh061_nomina_movimiento[de_concepto]',
	value:this.OBJ.de_concepto,
	allowBlank:false,
	readOnly:(this.OBJ.in_descripcion_alternativa!='')?false:true,
	style:(this.OBJ.in_descripcion_alternativa!='')?'':'background:#c9c9c9;',
	width:550
});

this.nu_valor = new Ext.form.NumberField({
	fieldLabel:'Referencia',
	name:'tbrh061_nomina_movimiento[nu_valor]',
	value:this.OBJ.nu_valor,
	allowBlank:false,
	width:200
});

this.nu_monto = new Ext.form.NumberField({
	fieldLabel:'Monto',
	name:'tbrh061_nomina_movimiento[nu_monto]',
	value:this.OBJ.nu_monto,
	allowBlank:false,
	width:200
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!NominaMovimientoEditarConcepto.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        NominaMovimientoEditarConcepto.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/guardar',
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
                 NominaMovimientoEditar.main.store_lista_imprimible.load();
				 NominaMovimientoEditar.main.store_lista_no_imprimible.load();
                 NominaMovimientoEditarConcepto.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        NominaMovimientoEditarConcepto.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:700,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
                    this.id_tbrh014_concepto,
					this.tx_tp_concepto,
					this.nu_concepto,
                    this.de_concepto,
                    this.nu_valor,
                    this.nu_monto
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Concepto',
    modal:true,
    constrain:true,
width:714,
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
NominaMovimientoEditar.main.mascara.hide();
}
};
Ext.onReady(NominaMovimientoEditarConcepto.main.init, NominaMovimientoEditarConcepto.main);
</script>
