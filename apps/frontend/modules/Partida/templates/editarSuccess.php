<script type="text/javascript">
Ext.ns("PartidaEditar");
PartidaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_ANIO_FISCAL = this.getStoreCO_ANIO_FISCAL();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.co_partida = new Ext.form.TextField({
	fieldLabel:'Codigo',
	name:'tb091_partida[co_partida]',
	value:this.OBJ.co_partida,
	allowBlank:false,
	width:200
});

this.nu_partida = new Ext.form.TextField({
	fieldLabel:'Numero',
	name:'tb091_partida[nu_partida]',
	value:this.OBJ.nu_partida,
	allowBlank:false,
	width:200
});

this.de_partida = new Ext.form.TextField({
	fieldLabel:'Denominacion',
	name:'tb091_partida[de_partida]',
	value:this.OBJ.de_partida,
	allowBlank:false,
	width:450
});

this.id_tb013_anio_fiscal = new Ext.form.ComboBox({
	fieldLabel:'Ejercicio Fiscal',
	store: this.storeCO_ANIO_FISCAL,
	typeAhead: true,
	valueField: 'co_anio_fiscal',
	displayField:'co_anio_fiscal',
	hiddenName:'tb091_partida[id_tb013_anio_fiscal]',
	//readOnly:(this.OBJ.id_tb013_anio_fiscal!='')?true:false,
	//style:(this.main.OBJ.id_tb013_anio_fiscal!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Ejercicio Fiscal',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ANIO_FISCAL.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb013_anio_fiscal,
	value:  this.OBJ.id_tb013_anio_fiscal,
	objStore: this.storeCO_ANIO_FISCAL
});

this.in_movimiento = new Ext.form.Checkbox({
	fieldLabel:'Movimiento',
	name:'tb091_partida[in_movimiento]',
	checked:this.OBJ.in_movimiento,
	allowBlank:false
});

this.nu_nivel = new Ext.form.NumberField({
	fieldLabel:'Nivel',
	name:'tb091_partida[nu_nivel]',
	value:this.OBJ.nu_nivel,
	allowBlank:false,
	width:100
});

this.nu_pa = new Ext.form.TextField({
	fieldLabel:'PA',
	name:'tb091_partida[nu_pa]',
	value:this.OBJ.nu_pa,
	allowBlank:false,
	width:100
});

this.nu_ge = new Ext.form.TextField({
	fieldLabel:'GE',
	name:'tb091_partida[nu_ge]',
	value:this.OBJ.nu_ge,
	allowBlank:false,
	width:100
});

this.nu_es = new Ext.form.TextField({
	fieldLabel:'ES',
	name:'tb091_partida[nu_es]',
	value:this.OBJ.nu_es,
	//allowBlank:false,
	width:100
});

this.nu_se = new Ext.form.TextField({
	fieldLabel:'SE',
	name:'tb091_partida[nu_se]',
	value:this.OBJ.nu_se,
	//allowBlank:false,
	width:100
});

this.nu_sse = new Ext.form.TextField({
	fieldLabel:'SSE',
	name:'tb091_partida[nu_sse]',
	value:this.OBJ.nu_sse,
	//allowBlank:false,
	width:100
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!PartidaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        PartidaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partida/guardar',
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
                 PartidaLista.main.store_lista.load();
                 PartidaEditar.main.winformPanel_.close();
             }
        });


    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PartidaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
autoHeight:true,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
                    this.co_partida,
                    this.nu_partida,
                    this.de_partida,
                    this.id_tb013_anio_fiscal,
                    this.in_movimiento,
                    this.nu_nivel,
                    this.nu_pa,
                    this.nu_ge,
                    this.nu_es,
                    this.nu_se,
                    this.nu_sse,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Partida',
    modal:true,
    constrain:true,
width:614,
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
PartidaLista.main.mascara.hide();
}
,getStoreCO_ANIO_FISCAL:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Partida/storefkidtb013aniofiscal',
        root:'data',
        fields:[
            {name: 'co_anio_fiscal'}
            ]
    });
    return this.store;
}
};
Ext.onReady(PartidaEditar.main.init, PartidaEditar.main);
</script>
