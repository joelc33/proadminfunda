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
    name:'tbrh086_conceptos_fijos[id_tbrh014_concepto]',
    value:this.OBJ.id_tbrh014_concepto
});

this.tx_tp_concepto = new Ext.form.TextField({
	fieldLabel:'Tipo',
	name:'tbrh086_conceptos_fijos[tx_tp_concepto]',
	value:this.OBJ.tx_tp_concepto,
	allowBlank:false,
	readOnly:true,
	style:'background:#c9c9c9;',
	width:200
});

this.nu_concepto = new Ext.form.TextField({
	fieldLabel:'Codigo',
	name:'tbrh086_conceptos_fijos[nu_concepto]',
	value:this.OBJ.nu_concepto,
	allowBlank:false,
	readOnly:true,
	style:'background:#c9c9c9;',
	width:100
});

this.de_concepto = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tbrh086_conceptos_fijos[de_concepto]',
	value:this.OBJ.de_concepto,
	allowBlank:false,
	readOnly:true,
	style:'background:#c9c9c9;',
	width:550
});

this.nu_valor = new Ext.form.NumberField({
	fieldLabel:'Valor',
	name:'tbrh086_conceptos_fijos[nu_valor]',
	value:this.OBJ.nu_valor,
	allowBlank:false,
	width:200
});

this.nu_referencia = new Ext.form.NumberField({
	fieldLabel:'Referencia',
	name:'tbrh086_conceptos_fijos[nu_referencia]',
	value:this.OBJ.nu_referencia,
	allowBlank:false,
    readOnly:true,
	style:'background:#c9c9c9;',
	width:200
});

this.nu_monto = new Ext.form.NumberField({
	fieldLabel:'Monto',
	name:'tbrh086_conceptos_fijos[nu_monto]',
	value:this.OBJ.nu_monto,
	allowBlank:false,
	width:200
});

this.mo_saldo = new Ext.form.NumberField({
	fieldLabel:'Saldo',
	name:'tbrh086_conceptos_fijos[mo_saldo]',
	value:this.OBJ.mo_saldo,
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
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/guardarFijo',
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
                    this.nu_referencia,
                    this.nu_valor,
                    this.nu_monto,
                    this.mo_saldo
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Conceptos Fijos',
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
        //this.guardar,
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
