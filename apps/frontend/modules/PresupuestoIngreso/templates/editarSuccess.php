<script type="text/javascript">
Ext.ns("PresupuestoIngresoEditar");
PresupuestoIngresoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_presupuesto_ingreso = new Ext.form.Hidden({
    name:'co_presupuesto_ingreso',
    value:this.OBJ.co_presupuesto_ingreso});
//</ClavePrimaria>


this.nu_partida = new Ext.form.TextField({
	fieldLabel:'Nu partida',
	name:'tb064_presupuesto_ingreso[nu_partida]',
	value:this.OBJ.nu_partida,
	allowBlank:false,
	width:200
});

this.tx_partida = new Ext.form.TextField({
	fieldLabel:'Tx partida',
	name:'tb064_presupuesto_ingreso[tx_partida]',
	value:this.OBJ.tx_partida,
	allowBlank:false,
	width:200
});

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Tx descripcion',
	name:'tb064_presupuesto_ingreso[tx_descripcion]',
	value:this.OBJ.tx_descripcion,
	allowBlank:false,
	width:200
});

this.mo_inicial = new Ext.form.NumberField({
	fieldLabel:'Mo inicial',
	name:'tb064_presupuesto_ingreso[mo_inicial]',
	value:this.OBJ.mo_inicial,
	allowBlank:false
});

this.mo_actualizado = new Ext.form.NumberField({
	fieldLabel:'Mo actualizado',
	name:'tb064_presupuesto_ingreso[mo_actualizado]',
	value:this.OBJ.mo_actualizado,
	allowBlank:false
});

this.nu_anio = new Ext.form.NumberField({
	fieldLabel:'Nu anio',
	name:'tb064_presupuesto_ingreso[nu_anio]',
	value:this.OBJ.nu_anio,
	allowBlank:false
});

this.mo_comprometido = new Ext.form.NumberField({
	fieldLabel:'Mo comprometido',
	name:'tb064_presupuesto_ingreso[mo_comprometido]',
	value:this.OBJ.mo_comprometido,
	allowBlank:false
});

this.mo_causado = new Ext.form.NumberField({
	fieldLabel:'Mo causado',
	name:'tb064_presupuesto_ingreso[mo_causado]',
	value:this.OBJ.mo_causado,
	allowBlank:false
});

this.mo_pagado = new Ext.form.NumberField({
	fieldLabel:'Mo pagado',
	name:'tb064_presupuesto_ingreso[mo_pagado]',
	value:this.OBJ.mo_pagado,
	allowBlank:false
});

this.mo_disponible = new Ext.form.NumberField({
	fieldLabel:'Mo disponible',
	name:'tb064_presupuesto_ingreso[mo_disponible]',
	value:this.OBJ.mo_disponible,
	allowBlank:false
});

this.nu_nivel = new Ext.form.NumberField({
	fieldLabel:'Nu nivel',
	name:'tb064_presupuesto_ingreso[nu_nivel]',
	value:this.OBJ.nu_nivel,
	allowBlank:false
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PresupuestoIngresoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PresupuestoIngresoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoIngreso/guardar',
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
                 PresupuestoIngresoLista.main.store_lista.load();
                 PresupuestoIngresoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PresupuestoIngresoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_presupuesto_ingreso,
                    this.nu_partida,
                    this.tx_partida,
                    this.tx_descripcion,
                    this.mo_inicial,
                    this.mo_actualizado,
                    this.nu_anio,
                    this.mo_comprometido,
                    this.mo_causado,
                    this.mo_pagado,
                    this.mo_disponible,
                    this.nu_nivel,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: PresupuestoIngreso',
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
PresupuestoIngresoLista.main.mascara.hide();
}
};
Ext.onReady(PresupuestoIngresoEditar.main.init, PresupuestoIngresoEditar.main);
</script>
