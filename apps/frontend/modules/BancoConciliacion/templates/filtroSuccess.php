<script type="text/javascript">
Ext.ns("BancoConciliacionFiltro");
BancoConciliacionFiltro.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CUENTA_BANCARIA = this.getStoreCO_CUENTA_BANCARIA();
//<Stores de fk>
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>



this.id_tb010_banco = new Ext.form.ComboBox({
	fieldLabel:'Banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'tx_banco',
	hiddenName:'id_tb010_banco',
	//readOnly:(this.OBJ.id_tb010_banco!='')?true:false,
	//style:(this.main.OBJ.id_tb010_banco!='')?'background:#c9c9c9;':'',
	readOnly:true,
	style:'background-color:#c9c9c9;',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Banco',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false,
  listeners:{
      select: function(){
          BancoConciliacionFiltro.main.storeCO_CUENTA_BANCARIA.load({
              params: {
                banco:this.getValue()
              }
          })
      }
  }
});
this.storeCO_BANCO.load();

paqueteComunJS.funcion.seleccionarComboByCo({
objCMB: this.id_tb010_banco,
value:  this.OBJ.id_tb010_banco,
objStore: this.storeCO_BANCO
});

if(this.OBJ.id_tb010_banco){
  this.storeCO_CUENTA_BANCARIA.load({
                    params: {
                      banco:this.OBJ.id_tb010_banco
                    },
                    callback: function(){
                        BancoConciliacionFiltro.main.id_tb011_cuenta_bancaria.setValue(BancoConciliacionFiltro.main.OBJ.id_tb011_cuenta_bancaria);
                    }
                });
}

this.id_tb010_banco.on('beforeselect',function(cmb,record,index){
        	this.id_tb011_cuenta_bancaria.clearValue();
					this.storeCO_CUENTA_BANCARIA.removeAll();
},this);

this.id_tb011_cuenta_bancaria = new Ext.form.ComboBox({
	fieldLabel:'Cuenta',
	store: this.storeCO_CUENTA_BANCARIA,
	typeAhead: true,
	valueField: 'co_cuenta_bancaria',
	displayField:'tx_cuenta_bancaria',
	hiddenName:'id_tb011_cuenta_bancaria',
	//readOnly:(this.OBJ.id_tb011_cuenta_bancaria!='')?true:false,
	//style:(this.main.OBJ.id_tb011_cuenta_bancaria!='')?'background:#c9c9c9;':'',
	readOnly:true,
	style:'background-color:#c9c9c9;',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Cuenta',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
//this.storeCO_CUENTA_BANCARIA.load();

this.fe_movimiento = new Ext.form.DateField({
	fieldLabel:'Fecha de Movimiento',
	name:'fe_movimiento',
	minValue:this.OBJ.fe_desde,
	maxValue:this.OBJ.fe_hasta,
	width:100
});

this.de_concepto = new Ext.form.TextField({
	fieldLabel:'Concepto',
	name:'de_concepto',
	value:'',
	width:300
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                                            this.id_tb010_banco,
                                                                                this.id_tb011_cuenta_bancaria,
                                                                                this.fe_movimiento,
                                                                                this.de_concepto
                                           ]
               }
            ]
    });

    this.panelfiltro = new Ext.form.FormPanel({
        frame:true,
        autoWidth:true,
        border:false,
				labelWidth: 140,
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
                     BancoConciliacionFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    BancoConciliacionFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    BancoConciliacionFiltro.main.win.close();
                    BancoConciliacionLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    BancoConciliacionLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    BancoConciliacionFiltro.main.panelfiltro.getForm().reset();
    BancoConciliacionLista.main.store_lista.baseParams={}
    BancoConciliacionLista.main.store_lista.baseParams.paginar = 'si';
    BancoConciliacionLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = BancoConciliacionFiltro.main.panelfiltro.getForm().getValues();
    BancoConciliacionLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("BancoConciliacionLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        BancoConciliacionLista.main.store_lista.baseParams.paginar = 'si';
        BancoConciliacionLista.main.store_lista.baseParams.BuscarBy = true;
        BancoConciliacionLista.main.store_lista.load();


}
,getStoreCO_BANCO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/storefkidtb010banco',
        root:'data',
        fields:[
            {name: 'co_banco'},{name: 'tx_banco'}
            ]
    });
    return this.store;
}
,getStoreCO_CUENTA_BANCARIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/storefkidtb011cuentabancaria',
        root:'data',
        fields:[
            {name: 'co_cuenta_bancaria'},{name: 'tx_cuenta_bancaria'}
            ]
    });
    return this.store;
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/storefkidtb101tipoconcilacion',
        root:'data',
        fields:[
            {name: 'id'}
            ]
    });
    return this.store;
}

};

Ext.onReady(BancoConciliacionFiltro.main.init,BancoConciliacionFiltro.main);
</script>
