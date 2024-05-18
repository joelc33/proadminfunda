<script type="text/javascript">
Ext.ns("PresupuestoMasivoEditar");
PresupuestoMasivoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.nu_ejercicio = new Ext.form.NumberField({
	fieldLabel:'Nu ejercicio',
	name:'tb195_importar_presupuesto[nu_ejercicio]',
	value:this.OBJ.nu_ejercicio,
	allowBlank:false
});

this.nu_ejecutor = new Ext.form.TextField({
	fieldLabel:'Nu ejecutor',
	name:'tb195_importar_presupuesto[nu_ejecutor]',
	value:this.OBJ.nu_ejecutor,
	allowBlank:false,
	width:200
});

this.de_ejecutor = new Ext.form.TextField({
	fieldLabel:'De ejecutor',
	name:'tb195_importar_presupuesto[de_ejecutor]',
	value:this.OBJ.de_ejecutor,
	allowBlank:false,
	width:200
});

this.nu_sector = new Ext.form.TextField({
	fieldLabel:'Nu sector',
	name:'tb195_importar_presupuesto[nu_sector]',
	value:this.OBJ.nu_sector,
	allowBlank:false,
	width:200
});

this.co_ac_pr = new Ext.form.TextField({
	fieldLabel:'Co ac pr',
	name:'tb195_importar_presupuesto[co_ac_pr]',
	value:this.OBJ.co_ac_pr,
	allowBlank:false,
	width:200
});

this.nu_proyecto_ac = new Ext.form.TextField({
	fieldLabel:'Nu proyecto ac',
	name:'tb195_importar_presupuesto[nu_proyecto_ac]',
	value:this.OBJ.nu_proyecto_ac,
	allowBlank:false,
	width:200
});

this.de_proyecto_ac = new Ext.form.TextField({
	fieldLabel:'De proyecto ac',
	name:'tb195_importar_presupuesto[de_proyecto_ac]',
	value:this.OBJ.de_proyecto_ac,
	allowBlank:false,
	width:200
});

this.nu_accion_especifica = new Ext.form.TextField({
	fieldLabel:'Nu accion especifica',
	name:'tb195_importar_presupuesto[nu_accion_especifica]',
	value:this.OBJ.nu_accion_especifica,
	allowBlank:false,
	width:200
});

this.de_accion_especifica = new Ext.form.TextField({
	fieldLabel:'De accion especifica',
	name:'tb195_importar_presupuesto[de_accion_especifica]',
	value:this.OBJ.de_accion_especifica,
	allowBlank:false,
	width:200
});

this.nu_partida = new Ext.form.TextField({
	fieldLabel:'Nu partida',
	name:'tb195_importar_presupuesto[nu_partida]',
	value:this.OBJ.nu_partida,
	allowBlank:false,
	width:200
});

this.nu_desagregado = new Ext.form.TextField({
	fieldLabel:'Nu desagregado',
	name:'tb195_importar_presupuesto[nu_desagregado]',
	value:this.OBJ.nu_desagregado,
	allowBlank:false,
	width:200
});

this.nu_fi = new Ext.form.TextField({
	fieldLabel:'Nu fi',
	name:'tb195_importar_presupuesto[nu_fi]',
	value:this.OBJ.nu_fi,
	allowBlank:false,
	width:200
});

this.de_partida = new Ext.form.TextField({
	fieldLabel:'De partida',
	name:'tb195_importar_presupuesto[de_partida]',
	value:this.OBJ.de_partida,
	allowBlank:false,
	width:200
});

this.mo_inicial = new Ext.form.NumberField({
	fieldLabel:'Mo inicial',
	name:'tb195_importar_presupuesto[mo_inicial]',
	value:this.OBJ.mo_inicial,
	allowBlank:false
});

this.co_categoria = new Ext.form.TextField({
	fieldLabel:'Co categoria',
	name:'tb195_importar_presupuesto[co_categoria]',
	value:this.OBJ.co_categoria,
	allowBlank:false,
	width:200
});

this.nu_pa = new Ext.form.TextField({
	fieldLabel:'Nu pa',
	name:'tb195_importar_presupuesto[nu_pa]',
	value:this.OBJ.nu_pa,
	allowBlank:false,
	width:200
});

this.nu_aplicacion = new Ext.form.TextField({
	fieldLabel:'Nu aplicacion',
	name:'tb195_importar_presupuesto[nu_aplicacion]',
	value:this.OBJ.nu_aplicacion,
	allowBlank:false,
	width:200
});

this.nu_area_estrategica = new Ext.form.TextField({
	fieldLabel:'Nu area estrategica',
	name:'tb195_importar_presupuesto[nu_area_estrategica]',
	value:this.OBJ.nu_area_estrategica,
	allowBlank:false,
	width:200
});

this.nu_amb = new Ext.form.TextField({
	fieldLabel:'Nu amb',
	name:'tb195_importar_presupuesto[nu_amb]',
	value:this.OBJ.nu_amb,
	allowBlank:false,
	width:200
});

this.tip_gasto = new Ext.form.TextField({
	fieldLabel:'Tip gasto',
	name:'tb195_importar_presupuesto[tip_gasto]',
	value:this.OBJ.tip_gasto,
	allowBlank:false,
	width:200
});

this.nu_clasificacion_economica = new Ext.form.TextField({
	fieldLabel:'Nu clasificacion economica',
	name:'tb195_importar_presupuesto[nu_clasificacion_economica]',
	value:this.OBJ.nu_clasificacion_economica,
	allowBlank:false,
	width:200
});

this.tipo_ordenador = new Ext.form.TextField({
	fieldLabel:'Tipo ordenador',
	name:'tb195_importar_presupuesto[tipo_ordenador]',
	value:this.OBJ.tipo_ordenador,
	allowBlank:false,
	width:200
});

this.tp_ingreso = new Ext.form.TextField({
	fieldLabel:'Tp ingreso',
	name:'tb195_importar_presupuesto[tp_ingreso]',
	value:this.OBJ.tp_ingreso,
	allowBlank:false,
	width:200
});

this.nu_ff = new Ext.form.TextField({
	fieldLabel:'Nu ff',
	name:'tb195_importar_presupuesto[nu_ff]',
	value:this.OBJ.nu_ff,
	allowBlank:false,
	width:200
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PresupuestoMasivoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PresupuestoMasivoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PresupuestoMasivo/guardar',
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
                 PresupuestoMasivoLista.main.store_lista.load();
                 PresupuestoMasivoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PresupuestoMasivoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.nu_ejercicio,
                    this.nu_ejecutor,
                    this.de_ejecutor,
                    this.nu_sector,
                    this.co_ac_pr,
                    this.nu_proyecto_ac,
                    this.de_proyecto_ac,
                    this.nu_accion_especifica,
                    this.de_accion_especifica,
                    this.nu_partida,
                    this.nu_desagregado,
                    this.nu_fi,
                    this.de_partida,
                    this.mo_inicial,
                    this.co_categoria,
                    this.nu_pa,
                    this.nu_aplicacion,
                    this.nu_area_estrategica,
                    this.nu_amb,
                    this.tip_gasto,
                    this.nu_clasificacion_economica,
                    this.tipo_ordenador,
                    this.tp_ingreso,
                    this.nu_ff,
                    this.id,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: PresupuestoMasivo',
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
PresupuestoMasivoLista.main.mascara.hide();
}
};
Ext.onReady(PresupuestoMasivoEditar.main.init, PresupuestoMasivoEditar.main);
</script>
