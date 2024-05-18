<script type="text/javascript">
Ext.ns("BancoConciliacionLista");
BancoConciliacionLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<Stores de fk>
this.storeCO_BANCO = this.getStoreCO_BANCO();
//<Stores de fk>
//<Stores de fk>
this.storeCO_CUENTA_BANCARIA = this.getStoreCO_CUENTA_BANCARIA();
//<Stores de fk>
//objeto store
this.store_lista = this.getLista();

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>

this.co_solicitud = new Ext.form.Hidden({
	name:'tb105_conciliacion[co_solicitud]',
	value:this.OBJ.co_solicitud,
	allowBlank:false
});

this.co_proceso = new Ext.form.Hidden({
	name:'tb105_conciliacion[co_proceso]',
	value:this.OBJ.co_proceso,
	allowBlank:false
});

this.co_tipo_solicitud = new Ext.form.Hidden({
	name:'tb105_conciliacion[co_tipo_solicitud]',
	value:this.OBJ.co_tipo_solicitud,
	allowBlank:false
});

this.id_tb010_banco = new Ext.form.ComboBox({
  id:'id_tb010_banco',
	fieldLabel:'Banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'tx_banco',
	hiddenName:'tb105_conciliacion[id_tb010_banco]',
	//readOnly:(this.OBJ.id_tb010_banco!='')?true:false,
	//style:(this.main.OBJ.id_tb010_banco!='')?'background:#c9c9c9;':'',
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
          BancoConciliacionLista.main.storeCO_CUENTA_BANCARIA.load({
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
                        BancoConciliacionLista.main.id_tb011_cuenta_bancaria.setValue(BancoConciliacionLista.main.OBJ.id_tb011_cuenta_bancaria);
                    }
                });
}

this.id_tb010_banco.on('beforeselect',function(cmb,record,index){
        	this.id_tb011_cuenta_bancaria.clearValue();
					this.storeCO_CUENTA_BANCARIA.removeAll();
},this);

this.id_tb011_cuenta_bancaria = new Ext.form.ComboBox({
  id:'id_tb011_cuenta_bancaria',
	fieldLabel:'Cuenta',
	store: this.storeCO_CUENTA_BANCARIA,
	typeAhead: true,
	valueField: 'co_cuenta_bancaria',
	displayField:'tx_cuenta_bancaria',
	hiddenName:'tb105_conciliacion[id_tb011_cuenta_bancaria]',
	//readOnly:(this.OBJ.id_tb011_cuenta_bancaria!='')?true:false,
	//style:(this.main.OBJ.id_tb011_cuenta_bancaria!='')?'background:#c9c9c9;':'',
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
/*this.storeCO_CUENTA_BANCARIA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb011_cuenta_bancaria,
	value:  this.OBJ.id_tb011_cuenta_bancaria,
	objStore: this.storeCO_CUENTA_BANCARIA
});*/

this.fe_desde = new Ext.form.DateField({
  id:'fe_desde',
	fieldLabel:'Fecha Desde',
	name:'tb105_conciliacion[fe_desde]',
	value:this.OBJ.fe_desde,
	allowBlank:false,
	width:100
});

this.fe_hasta = new Ext.form.DateField({
  id:'fe_hasta',
	fieldLabel:'Fecha Hasta',
	name:'tb105_conciliacion[fe_hasta]',
	value:this.OBJ.fe_hasta,
	allowBlank:false,
	width:100
});

this.compositefieldFecha = new Ext.form.CompositeField({
        fieldLabel: 'Fecha Desde',
//      msgTarget : 'side',
        anchor    : '-20',
        defaults: {
            flex: 1
        },
        items: [
             this.fe_desde,
             {
                   xtype: 'displayfield',
                   value: '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fecha Hasta:',
                   width: 180
             },
             this.fe_hasta
        ]
});

this.nb_archivo = new Ext.ux.form.FileUploadField({
	emptyText: 'Seleccione un Documento',
	fieldLabel: 'Archivo de Carga',
	name:'archivo',
	buttonText: '',
	value:this.OBJ.nb_archivo,
	buttonCfg: {
		iconCls: 'icon-subirImagen'
	},
	width:200,
	allowBlank:false
});

this.fieldset1 = new Ext.form.FieldSet({
	title: 'Datos de Cuenta',
	autoWidth:true,
        items:[
          this.id_tb010_banco,
          this.id_tb011_cuenta_bancaria,
          this.compositefieldFecha,
          this.nb_archivo
		]
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroBancoConciliacion');
        BancoConciliacionLista.main.mascara.show();
        BancoConciliacionLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/filtro',
             params:{
               id_tb105_conciliacion: BancoConciliacionLista.main.id.getValue(),
               id_tb010_banco: BancoConciliacionLista.main.id_tb010_banco.getValue(),
               id_tb011_cuenta_bancaria: BancoConciliacionLista.main.id_tb011_cuenta_bancaria.getValue(),
               fe_desde: Ext.util.Format.date( BancoConciliacionLista.main.fe_desde.getValue(), 'Y-m-d'),
               fe_hasta: Ext.util.Format.date( BancoConciliacionLista.main.fe_hasta.getValue(), 'Y-m-d')
             },
             scripts: true
        });
    }
});
 if(this.OBJ.id){
   this.filtro.enable();
   this.store_lista.baseParams.id_tb105_conciliacion = this.OBJ.id;
   this.store_lista.load({
     params:{
       id_tb105_conciliacion:this.OBJ.id
     },
     callback: function(){
         BancoConciliacionLista.main.getDeshabilitar();
     }
   });
   this.nu_conciliacion = new Ext.form.DisplayField({
    value:"<span style='color:black;font-size:15px;'><b>N° Conciliacion: </b> "+this.OBJ.nu_conciliacion+"</span>"
   });
}else{
  this.filtro.disable();
  this.nu_conciliacion = new Ext.form.DisplayField({
   value:"<span style='color:black;font-size:15px;'><b>N° Conciliacion: </b> Por Asignar</span>"
  });
}

//filtro
this.descargar = new Ext.Button({
    text:'Archivo de Carga',
    iconCls: 'icon-descargar',
    handler:function(){
      var url = '/archivos/conciliar_banco.xls';
      Ext.Ajax.request({
          url: url,
          method: 'GET',
          autoAbort: false,
          success: function(result) {
              if(result.status == 404) {
                  Ext.Msg.alert('Aviso', 'Archivo no encontrado...');
              } else if(result.status == 200) {
                  var win = window.open('', '_blank');
                  win.location = url;
                  win.focus();
              }
          },
          failure: function() {
              //failure here will automatically
              //log the user out as it should
          }
      });
    }
});

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de BancoConciliacion',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:350,
    width:790,
    tbar:[
        this.filtro,'-',this.descargar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Banco', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb010_banco'},
    {header: 'Cuenta', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb011_cuenta_bancaria'},
    {header: 'Fecha', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'fe_movimiento'},
    {header: 'Concepto', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'de_concepto'},
    {header: 'Cargo', width:100,  menuDisabled:true, sortable: true, renderer: formatoNumero,  dataIndex: 'mo_cargo'},
    {header: 'Abono', width:100,  menuDisabled:true, sortable: true, renderer: formatoNumero,  dataIndex: 'mo_abono'},
    {header: 'Saldo', width:100,  menuDisabled:true, sortable: true, renderer: formatoNumero,  dataIndex: 'mo_saldo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    bbar: new Ext.PagingToolbar({
        pageSize: 10,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        BancoConciliacionLista.main.winformPanel_.close();
    }
});

this.guardar = new Ext.Button({
    text:'Procesar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!BancoConciliacionLista.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        BancoConciliacionLista.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Conciliacion/guardarLote',
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
                 //BancoConciliacionLista.main.store_lista.load();
                 BancoConciliacionLista.main.store_lista.load({
                   params:{
                     id_tb105_conciliacion: action.result.codigo
                   }
                 });
                 BancoConciliacionLista.main.id.setValue(action.result.codigo);
                 BancoConciliacionLista.main.filtro.enable();
                 BancoConciliacionLista.main.nu_conciliacion.setValue("<span style='color:black;font-size:15px;'><b>N° Conciliacion: </b> "+action.result.numero+"</span>");
                 BancoConciliacionLista.main.getDeshabilitar();
                 //BancoConciliacionLista.main.winformPanel_.close();
                 Detalle.main.store_lista.load();
             }
        });


    }
});

this.tbar_modificacion = {
    xtype        : 'toolbar',
    layout       : 'hbox',
    items        : this.nu_conciliacion,
    height       : 25,
    layoutConfig : {
        align : 'left'
    }
};

this.formPanel_ = new Ext.form.FormPanel({
    frame:false,
    fileUpload: true,
    autoHeight:true,
    border: false,
    bodyStyle:'padding:0px;',
    items:[
                    this.id,
                    this.co_solicitud,
                    this.co_tipo_solicitud,
                    this.co_proceso,
                    this.fieldset1,
            ]
});

//this.gridPanel_.render("contenedorBancoConciliacionLista");
this.winformPanel_ = new Ext.Window({
    title:'Formulario: Conciliacion por Lotes',
    modal:true,
    constrain:true,
    width:814,
    frame:true,
    closabled:true,
    autoHeight:true,
    tbar: this.tbar_modificacion,
    bodyStyle:'padding:5px;',
    items:[
        this.formPanel_,
        this.gridPanel_
    ],
    buttons:[
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();

//this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/BancoConciliacion/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'id_tb010_banco'},
    {name: 'id_tb011_cuenta_bancaria'},
    {name: 'fe_movimiento'},
    {name: 'de_concepto'},
    {name: 'mo_cargo'},
    {name: 'mo_abono'},
    {name: 'mo_saldo'},
    {name: 'id_tb101_tipo_concilacion'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
           ]
    });
    return this.store;
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
},
getDeshabilitar:function(){

    Ext.get('id_tb010_banco').setStyle('background-color','#c9c9c9');
    BancoConciliacionLista.main.id_tb010_banco.setReadOnly(true);
    Ext.get('id_tb011_cuenta_bancaria').setStyle('background-color','#c9c9c9');
    BancoConciliacionLista.main.id_tb011_cuenta_bancaria.setReadOnly(true);
    Ext.get('fe_desde').setStyle('background-color','#c9c9c9');
    BancoConciliacionLista.main.fe_desde.setReadOnly(true);
    Ext.get('fe_hasta').setStyle('background-color','#c9c9c9');
    BancoConciliacionLista.main.fe_hasta.setReadOnly(true);

}
};
Ext.onReady(BancoConciliacionLista.main.init, BancoConciliacionLista.main);
</script>
<div id="contenedorBancoConciliacionLista"></div>
<div id="formularioBancoConciliacion"></div>
<div id="filtroBancoConciliacion"></div>
