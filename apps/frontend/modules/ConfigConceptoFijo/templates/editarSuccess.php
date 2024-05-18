<script type="text/javascript">
Ext.ns("ConfigConceptoFijoEditar");
ConfigConceptoFijoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//objeto store
this.store_lista = this.getLista();

//<Stores de fk>
this.storeCO_CONCEPTO_FORMULA = this.getStoreCO_CONCEPTO_FORMULA();

//<ClavePrimaria>
this.co_conceptos_fijos = new Ext.form.Hidden({
    name:'co_conceptos_fijos',
    value:this.OBJ.co_conceptos_fijos});
//</ClavePrimaria>

this.co_ficha = new Ext.form.Hidden({
	name:'tbrh086_conceptos_fijos[co_ficha]',
	value:this.OBJ.co_ficha
});

this.co_nom_trabajador = new Ext.form.NumberField({
	fieldLabel:'Co nom trabajador',
	name:'tbrh086_conceptos_fijos[co_nom_trabajador]',
	value:this.OBJ.co_nom_trabajador,
	allowBlank:false
});

this.nu_monto = new Ext.form.NumberField({
	fieldLabel:'Monto',
	name:'tbrh086_conceptos_fijos[nu_monto]',
	value:this.OBJ.nu_monto,
	allowBlank:false,
	width:100
});

this.nu_valor = new Ext.form.NumberField({
	fieldLabel:'Valor',
	name:'tbrh086_conceptos_fijos[nu_valor]',
	value:this.OBJ.nu_valor,
	allowBlank:false,
	width:100
});

this.mo_saldo = new Ext.form.NumberField({
	fieldLabel:'Saldo',
	name:'tbrh086_conceptos_fijos[mo_saldo]',
	value:this.OBJ.mo_saldo,
	allowBlank:false,
	width:100
});

this.fe_movimiento = new Ext.form.DateField({
	fieldLabel:'Fecha Mov.',
	name:'tbrh086_conceptos_fijos[fe_movimiento]',
	value:this.OBJ.fe_movimiento,
	allowBlank:false,
	width:100
});

this.fe_vencimiento = new Ext.form.DateField({
	fieldLabel:'Fecha Venc.',
	name:'tbrh086_conceptos_fijos[fe_vencimiento]',
	value:this.OBJ.fe_vencimiento,
	//allowBlank:false,
	width:100
});

this.co_tp_formula = new Ext.form.Hidden({
    name:'tbrh086_conceptos_fijos[co_tp_formula]',
    value:this.OBJ.co_tp_formula
});

this.tx_codigo_concepto = new Ext.form.Hidden({
    name:'tbrh086_conceptos_fijos[tx_codigo_concepto]',
    value:this.OBJ.tx_codigo_concepto
});

this.co_concepto_formula = new Ext.form.ComboBox({
	fieldLabel:'Concepto',
	store: this.storeCO_CONCEPTO_FORMULA,
	typeAhead: true,
	valueField: 'co_concepto_formula',
	displayField:'concepto_formula',
	hiddenName:'tbrh086_conceptos_fijos[co_concepto_formula]',
	//readOnly:(this.OBJ.co_concepto_formula!='')?true:false,
	//style:(this.main.OBJ.co_concepto_formula!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Concepto',
	selectOnFocus: true,
	mode: 'local',
	width:500,
	resizable:true,
	allowBlank:false,
    /*listeners:{
		select: function(){
			ConfigConceptoFijoEditar.main.store_lista.load({
				params: {
					co_concepto:this.getValue()
				}
			})
		}
  	},*/
    onSelect: function(record){
		ConfigConceptoFijoEditar.main.co_concepto_formula.setValue(record.data.co_concepto_formula);
		ConfigConceptoFijoEditar.main.co_tp_formula.setValue(record.data.co_concepto_formula);
		ConfigConceptoFijoEditar.main.tx_codigo_concepto.setValue(record.data.nu_concepto);
        ConfigConceptoFijoEditar.main.store_lista.load({
            params: {
                co_concepto:record.data.co_concepto_formula
            }
        });
		this.collapse();
	}
});
this.storeCO_CONCEPTO_FORMULA.load({
    params: {
        grupo:this.OBJ.co_grupo,
        subgrupo:this.OBJ.co_subgrupo
    }
});
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.co_concepto_formula,
	value:  this.OBJ.co_concepto_formula,
	objStore: this.storeCO_CONCEPTO_FORMULA
});

if(this.OBJ.co_concepto_formula){
    ConfigConceptoFijoEditar.main.store_lista.load({
		params: {
			co_concepto:this.OBJ.co_concepto_formula
		}
	});

}

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Nominas Asociadas al Concepto',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
    frame:true,
    height:150,
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'Tipo Nomina', width:250,  menuDisabled:true, sortable: true,  dataIndex: 'nomina'},
    {header: 'Sub-Grupo', width:250,  menuDisabled:true, sortable: true,  dataIndex: 'cod_grupo_nomina'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ConfigConceptoFijoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfigConceptoFijoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoFijo/guardar',
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
                 ConfigConceptoFijoLista.main.store_lista.load();
                 ConfigConceptoFijoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigConceptoFijoEditar.main.winformPanel_.close();
    }
});

this.gridNomina = new Ext.form.FieldSet({
        padding	: 0,
        border: false,
        items:[
           this.gridPanel_
       ]
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:700,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_conceptos_fijos,
                    this.co_ficha,
                    this.co_concepto_formula,
                    this.gridNomina,
                    this.nu_monto,
                    this.nu_valor,
                    this.mo_saldo,
                    this.fe_movimiento,
                    this.fe_vencimiento,
                    this.co_tp_formula,
                    this.tx_codigo_concepto
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Config Concepto Fijo',
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
//ConfigConceptoFijoLista.main.mascara.hide();
}
,getStoreCO_CONCEPTO_FORMULA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoFijo/storefkcoconceptoformula',
        root:'data',
        fields:[
            {name: 'co_concepto_formula'},
            {name: 'nu_concepto'},
            {name: 'tx_concepto'},
            {name: 'de_observacion'},
            {name: 'concepto_formula',
                convert:function(v,r){
                    return r.nu_concepto+' - '+r.tx_concepto+' ( '+r.de_observacion+' ) ';
                }
            }
        ]
    });
    return this.store;
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoFijo/storelistaNomina',
    root:'data',
    fields:[
    {name: 'co_concepto_tipo_nomina'},
    {name: 'co_concepto'},
    {name: 'co_tp_nomina'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'cod_grupo_nomina'},
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
};
Ext.onReady(ConfigConceptoFijoEditar.main.init, ConfigConceptoFijoEditar.main);
</script>
