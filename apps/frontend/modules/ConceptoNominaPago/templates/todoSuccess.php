<script type="text/javascript">
Ext.ns("ConceptoNominaPagoFiltro");
ConceptoNominaPagoFiltro.main = {
init:function(){




this.nu_concepto = new Ext.form.TextField({
	fieldLabel:'Nu concepto',
	name:'nu_concepto',
	value:''
});

this.tx_concepto = new Ext.form.TextField({
	fieldLabel:'Tx concepto',
	name:'tx_concepto',
	value:''
});

this.co_tipo_concepto = new Ext.form.NumberField({
	fieldLabel:'Co tipo concepto',
	name:'co_tipo_concepto',
	value:''
});

this.co_tipo_unidad = new Ext.form.NumberField({
	fieldLabel:'Co tipo unidad',
	name:'co_tipo_unidad',
	value:''
});

this.nu_cuenta_contable = new Ext.form.TextField({
	fieldLabel:'Nu cuenta contable',
	name:'nu_cuenta_contable',
	value:''
});

this.nu_cuenta_presupuesto = new Ext.form.TextField({
	fieldLabel:'Nu cuenta presupuesto',
	name:'nu_cuenta_presupuesto',
	value:''
});

this.nu_valor = new Ext.form.NumberField({
	fieldLabel:'Nu valor',
name:'nu_valor',
	value:''
});

this.in_imprime_detalle = new Ext.form.Checkbox({
	fieldLabel:'In imprime detalle',
	name:'in_imprime_detalle',
	checked:true
});

this.in_descripcion_alternativa = new Ext.form.Checkbox({
	fieldLabel:'In descripcion alternativa',
	name:'in_descripcion_alternativa',
	checked:true
});

this.in_valor_referencia = new Ext.form.Checkbox({
	fieldLabel:'In valor referencia',
	name:'in_valor_referencia',
	checked:true
});

this.in_hoja_tiempo = new Ext.form.Checkbox({
	fieldLabel:'In hoja tiempo',
	name:'in_hoja_tiempo',
	checked:true
});

this.in_prorratea = new Ext.form.Checkbox({
	fieldLabel:'In prorratea',
	name:'in_prorratea',
	checked:true
});

this.in_modifica_descripcion = new Ext.form.Checkbox({
	fieldLabel:'In modifica descripcion',
	name:'in_modifica_descripcion',
	checked:true
});

this.in_monto_calculo = new Ext.form.Checkbox({
	fieldLabel:'In monto calculo',
	name:'in_monto_calculo',
	checked:true
});

this.in_contractual = new Ext.form.Checkbox({
	fieldLabel:'In contractual',
	name:'in_contractual',
	checked:true
});

this.in_bonificable = new Ext.form.Checkbox({
	fieldLabel:'In bonificable',
	name:'in_bonificable',
	checked:true
});

this.in_monto_cero = new Ext.form.Checkbox({
	fieldLabel:'In monto cero',
	name:'in_monto_cero',
	checked:true
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'in_activo',
	checked:true
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'created_at'
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'updated_at'
});

this.de_formula = new Ext.form.TextField({
	fieldLabel:'De formula',
	name:'de_formula',
	value:''
});

this.co_moneda = new Ext.form.NumberField({
	fieldLabel:'Co moneda',
	name:'co_moneda',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.nu_concepto,
                                                                                this.tx_concepto,
                                                                                this.co_tipo_concepto,
                                                                                this.co_tipo_unidad,
                                                                                this.nu_cuenta_contable,
                                                                                this.nu_cuenta_presupuesto,
                                                                                this.nu_valor,
                                                                                this.in_imprime_detalle,
                                                                                this.in_descripcion_alternativa,
                                                                                this.in_valor_referencia,
                                                                                this.in_hoja_tiempo,
                                                                                this.in_prorratea,
                                                                                this.in_modifica_descripcion,
                                                                                this.in_monto_calculo,
                                                                                this.in_contractual,
                                                                                this.in_bonificable,
                                                                                this.in_monto_cero,
                                                                                this.in_activo,
                                                                                this.created_at,
                                                                                this.updated_at,
                                                                                this.de_formula,
                                                                                this.co_moneda,
                                           ]
               }
            ]
    });

    this.panelfiltro = new Ext.form.FormPanel({
        frame:true,
        autoWidth:true,
        border:false,
        items:[
            this.tabpanelfiltro
        ]
    });

    this.win = new Ext.Window({
        title:'Parametros de busqueda',
        iconCls: 'icon-buscar',
        width:600,
        autoHeight:true,
        constrain:true,
        closable:false,
        buttonAlign:'center',
        items:[
            this.panelfiltro
        ],
        buttons:[
            {
                text:'Filtrar',
                handler:function(){
                     ConceptoNominaPagoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    ConceptoNominaPagoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    ConceptoNominaPagoFiltro.main.win.close();
                    ConceptoNominaPagoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    ConceptoNominaPagoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    ConceptoNominaPagoFiltro.main.panelfiltro.getForm().reset();
    ConceptoNominaPagoLista.main.store_lista.baseParams={}
    ConceptoNominaPagoLista.main.store_lista.baseParams.paginar = 'si';
    ConceptoNominaPagoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = ConceptoNominaPagoFiltro.main.panelfiltro.getForm().getValues();
    ConceptoNominaPagoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("ConceptoNominaPagoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        ConceptoNominaPagoLista.main.store_lista.baseParams.paginar = 'si';
        ConceptoNominaPagoLista.main.store_lista.baseParams.BuscarBy = true;
        ConceptoNominaPagoLista.main.store_lista.load();


}

};

Ext.onReady(ConceptoNominaPagoFiltro.main.init,ConceptoNominaPagoFiltro.main);
</script>