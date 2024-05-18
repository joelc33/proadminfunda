<script type="text/javascript">
Ext.ns("NovedadTrabajadorEditar");
NovedadTrabajadorEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<Stores de fk>
this.storeCO_TP_NOMINA = this.getStoreCO_TP_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_GRUPO_NOMINA = this.getStoreCO_GRUPO_NOMINA();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CONCEPTO = this.getStoreCO_CONCEPTO();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>

this.co_solicitud = new Ext.form.Hidden({
    name:'tbrh095_trabajador_novedad[co_solicitud]',
    value:this.OBJ.co_solicitud
});

this.nu_cedula = new Ext.form.NumberField({
	fieldLabel:'Cedula',
	name:'tbrh095_trabajador_novedad[nu_cedula]',
	value:this.OBJ.nu_cedula,
	allowBlank:false,
	width:100
});

this.nu_cedula.on("blur",function(){
    NovedadTrabajadorEditar.main.buscar();
});

this.nb_trabajador = new Ext.form.TextField({
	fieldLabel:'Nombre / Apellido',
	name:'tbrh095_trabajador_novedad[nb_trabajador]',
	value:this.OBJ.nb_trabajador,
	allowBlank:false,
	width:400,
	readOnly:true,
	style:'background:#c9c9c9;',
});

/*this.nu_concepto = new Ext.form.TextField({
	fieldLabel:'N° Concepto',
	name:'tbrh095_trabajador_novedad[nu_concepto]',
	value:this.OBJ.nu_concepto,
	allowBlank:false,
	width:100
});*/

this.nu_concepto = new Ext.form.Hidden({
    name:'tbrh095_trabajador_novedad[nu_concepto]',
    value:this.OBJ.nu_concepto
});

this.co_concepto = new Ext.form.ComboBox({
	fieldLabel:'Concepto',
	store: this.storeCO_CONCEPTO,
	typeAhead: true,
	valueField: 'co_concepto',
	displayField:'concepto',
	hiddenName:'tbrh095_trabajador_novedad[co_concepto]',
	//readOnly:(this.OBJ.co_concepto!='')?true:false,
	//style:(this.main.OBJ.co_concepto!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Concepto',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false,
    onSelect: function(record){
        NovedadTrabajadorEditar.main.nu_concepto.setValue(record.data.nu_concepto);
        NovedadTrabajadorEditar.main.co_concepto.setValue(record.data.co_concepto);
        this.collapse();
    }
});
this.storeCO_CONCEPTO.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_concepto,
	value:  this.OBJ.co_concepto,
	objStore: this.storeCO_CONCEPTO
});

this.nu_valor = new Ext.form.NumberField({
	fieldLabel:'Valor',
	name:'tbrh095_trabajador_novedad[nu_valor]',
	value:this.OBJ.nu_valor,
	allowBlank:false,
	width:100
});

this.fe_novedad = new Ext.form.DateField({
	fieldLabel:'Fecha Novedad',
	name:'tbrh095_trabajador_novedad[fe_novedad]',
	value:this.OBJ.fe_novedad,
	allowBlank:false,
	width:100
});

this.fe_ejecucion = new Ext.form.DateField({
	fieldLabel:'Fecha Ejecucion',
	name:'tbrh095_trabajador_novedad[fe_ejecucion]',
	value:this.OBJ.fe_ejecucion,
	//allowBlank:false,
	width:100
});

this.nu_nomina = new Ext.form.Hidden({
    name:'tbrh095_trabajador_novedad[nu_nomina]',
    value:this.OBJ.nu_nomina
});

this.tx_grupo_nomina = new Ext.form.Hidden({
    name:'tbrh095_trabajador_novedad[tx_grupo_nomina]',
    value:this.OBJ.tx_grupo_nomina
});

this.co_ficha = new Ext.form.Hidden({
    name:'tbrh095_trabajador_novedad[co_ficha]',
    value:this.OBJ.co_ficha
});

this.co_tp_nomina = new Ext.form.ComboBox({
	fieldLabel:'Tipo de nomina',
	store: this.storeCO_TP_NOMINA,
	typeAhead: true,
	valueField: 'co_tp_nomina',
	displayField:'nomina',
	hiddenName:'tbrh095_trabajador_novedad[co_tp_nomina]',
	//readOnly:(this.OBJ.co_tp_nomina!='')?true:false,
	//style:(this.main.OBJ.co_tp_nomina!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Tipo',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false,
    /*listeners:{
		select: function(){
			NovedadTrabajadorEditar.main.co_grupo_nomina.clearValue();
			NovedadTrabajadorEditar.main.storeCO_GRUPO_NOMINA.load({
				params: {
					tipo:this.getValue()
				}
			})
		}
	},*/
    onSelect: function(record){
		NovedadTrabajadorEditar.main.co_grupo_nomina.clearValue();
        NovedadTrabajadorEditar.main.nu_nomina.setValue(record.data.nu_nomina);
        NovedadTrabajadorEditar.main.co_tp_nomina.setValue(record.data.co_tp_nomina);
		NovedadTrabajadorEditar.main.storeCO_GRUPO_NOMINA.load({
			params: {
				tipo:record.data.co_tp_nomina,
                ficha:NovedadTrabajadorEditar.main.co_ficha.getValue()
			}
		});
        this.collapse();
    }
});
this.storeCO_TP_NOMINA.load({
    params: {
        tipo:NovedadTrabajadorEditar.main.OBJ.co_tp_nomina,
        co_ficha:NovedadTrabajadorEditar.main.co_ficha.getValue()
    }
});
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_tp_nomina,
	value:  this.OBJ.co_tp_nomina,
	objStore: this.storeCO_TP_NOMINA
});

this.co_grupo_nomina = new Ext.form.ComboBox({
	fieldLabel:'Grupo de nomina',
	store: this.storeCO_GRUPO_NOMINA,
	typeAhead: true,
	valueField: 'co_grupo_nomina',
	displayField:'cod_grupo_nomina',
	hiddenName:'tbrh095_trabajador_novedad[co_grupo_nomina]',
	//readOnly:(this.OBJ.co_grupo_nomina!='')?true:false,
	//style:(this.main.OBJ.co_grupo_nomina!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Grupo',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false,
    onSelect: function(record){
        NovedadTrabajadorEditar.main.tx_grupo_nomina.setValue(record.data.cod_grupo_nomina);
        NovedadTrabajadorEditar.main.co_grupo_nomina.setValue(record.data.co_grupo_nomina);
        this.collapse();
    }
});
/*this.storeCO_GRUPO_NOMINA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_grupo_nomina,
	value:  this.OBJ.co_grupo_nomina,
	objStore: this.storeCO_GRUPO_NOMINA
});*/

if(this.OBJ.co_tp_nomina){
  	this.storeCO_GRUPO_NOMINA.load({
		params: {
			tipo:this.OBJ.co_tp_nomina,
            ficha:NovedadTrabajadorEditar.main.co_ficha.getValue()
		},
		callback: function(){
			NovedadTrabajadorEditar.main.co_grupo_nomina.setValue(NovedadTrabajadorEditar.main.OBJ.co_grupo_nomina);
		}
	});

}

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!NovedadTrabajadorEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        NovedadTrabajadorEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NovedadTrabajador/guardar',
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
                 NovedadTrabajadorLista.main.store_lista.load();
                 NovedadTrabajadorEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        NovedadTrabajadorEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
	labelWidth: 110,
    items:[

                    this.id,
                    this.co_solicitud,
                    this.nu_cedula,
                    this.nb_trabajador,
                    this.co_tp_nomina,
                    this.co_grupo_nomina,
                    this.nu_nomina,
                    this.tx_grupo_nomina,
                    this.co_ficha,
                    this.nu_concepto,
                    this.co_concepto,
                    this.nu_valor,
                    this.fe_novedad,
                    this.fe_ejecucion,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Novedad Trabajador',
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
NovedadTrabajadorLista.main.mascara.hide();
}
,getStoreCO_TP_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NovedadTrabajador/storefkcotpnomina',
        root:'data',
        fields:[
            {name: 'co_tp_nomina'},
			{name: 'nu_nomina'},
            {
				name: 'nomina',
				convert: function(v, r) {
						return r.nu_nomina + ' - ' + r.tx_tp_nomina;
				}
		    }
            ]
    });
    return this.store;
}
,getStoreCO_GRUPO_NOMINA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NovedadTrabajador/storefkcogruponomina',
        root:'data',
        fields:[
            {name: 'co_grupo_nomina'},
            {name: 'cod_grupo_nomina'},
            {
				name: 'grupo',
				convert: function(v, r) {
						return r.cod_grupo_nomina + ' - ' + r.tx_grupo_nomina;
				}
		    }
            ]
    });
    return this.store;
}
,getStoreCO_CONCEPTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NovedadTrabajador/storefkcoconcepto',
        root:'data',
        fields:[
            {name: 'co_concepto'},
            {name: 'nu_concepto'},
            {name: 'tx_concepto'},
            {
				name: 'concepto',
				convert: function(v, r) {
						return r.nu_concepto + ' - ' + r.tx_concepto;
				}
		    }
            ]
    });
    return this.store;
},
buscar:function(){
            Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/NovedadTrabajador/buscar',
                params:{
                    nu_cedula: NovedadTrabajadorEditar.main.nu_cedula.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        NovedadTrabajadorEditar.main.nb_trabajador.setValue("");
                        NovedadTrabajadorEditar.main.co_ficha.setValue("");
                        NovedadTrabajadorEditar.main.storeCO_CONCEPTO.removeAll();

                            Ext.Msg.show({
                            title : 'ALERTA',
                            msg : 'El trabajador no se encuentra registrado',
                            width : 400,
                            height : 800,
                            closable : false,
                            buttons : Ext.Msg.OK,
                            icon : Ext.Msg.INFO
                        });

                    }else{

                        NovedadTrabajadorEditar.main.nb_trabajador.setValue(obj.data.nb_trabajador);
                        NovedadTrabajadorEditar.main.co_ficha.setValue(obj.data.co_ficha);
                        NovedadTrabajadorEditar.main.storeCO_TP_NOMINA.load({
                            params: {
                                co_ficha:obj.data.co_ficha
                            }
                        });
                    }
                }
            });
}
};
Ext.onReady(NovedadTrabajadorEditar.main.init, NovedadTrabajadorEditar.main);
</script>
