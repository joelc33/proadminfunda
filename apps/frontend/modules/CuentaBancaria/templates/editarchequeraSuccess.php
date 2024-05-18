<script type="text/javascript">
Ext.ns("ChequeraEditar");
ChequeraEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_ANO = this.getStoreCO_ANO();
//<ClavePrimaria>
this.co_chequera = new Ext.form.Hidden({
    name:'co_chequera',
    value:this.OBJ.co_chequera});

this.co_cuenta_bancaria = new Ext.form.Hidden({
    name:'tb079_chequera[co_cuenta_bancaria]',
    value:this.OBJ.co_cuenta_bancaria});



this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Descripción',
	name:'tb079_chequera[tx_descripcion]',
	value:this.OBJ.tx_descripcion,
        width:600,
	allowBlank:false,
        listeners: {
        change: function(field, newValue, oldValue) {
        field.setValue(newValue.toUpperCase());
    }
} 
});

this.nro_chequera = new Ext.form.NumberField({
	fieldLabel:'Nro',
	name:'tb079_chequera[nro_chequera]',
	value:this.OBJ.nro_chequera,
        width:50,
	allowBlank:false
});


this.anio_chequera = new Ext.form.ComboBox({
	fieldLabel:'Año',
	store: this.storeCO_ANO,
	typeAhead: true,
	valueField: 'tx_anio',
	displayField:'tx_anio',
	hiddenName:'tb079_chequera[anio_chequera]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:80,
	allowBlank:false
});
ChequeraEditar.main.anio_chequera.setValue(this.OBJ.anio_chequera);
this.compositefieldChequera = new Ext.form.CompositeField({
fieldLabel: 'Nro / Año',
width:185,
items: [
	this.nro_chequera,
	this.anio_chequera,
	]
});

this.serie = new Ext.form.TextField({
	fieldLabel:'Serie',
	name:'tb079_chequera[serie]',
	value:this.OBJ.serie,
        width:50,
	allowBlank:false
});

this.PanelChequera = new Ext.Panel({
   items:[
       {
           layout:'column',
           defaults:{layout:'form'},
           items:[
               {   columnWidth:.50,
                   items:[this.compositefieldChequera]
               },
               {
                   columnWidth:.50,
                   items:[this.serie]
               }
           ]
       }
   ]
});

this.fe_chequera = new Ext.form.DateField({
	fieldLabel:'Fecha Chequera',
	name:'tb079_chequera[fe_chequera]',
	value:this.OBJ.fe_chequera,
	allowBlank:false,
	width:100
});

this.nro_inicial = new Ext.form.TextField({
	fieldLabel:'Nro. Inicial',
	name:'tb079_chequera[nro_inicial]',
	value:this.OBJ.nro_inicial,
        minLength: 1,
        minLengthText: 'La longitud mínima para este campo es {0}',   
        maskRe: /([0-9]+)$/,
        width:80,
	allowBlank:false
});

this.nro_final = new Ext.form.TextField({
	fieldLabel:'Nro. Final',
	name:'tb079_chequera[nro_final]',
	value:this.OBJ.nro_final, 
        minLength: 1,
        minLengthText: 'La longitud mínima para este campo es {0}',         
        maskRe: /([0-9]+)$/,
        width:80,
	allowBlank:false
});

this.PanelNro = new Ext.Panel({
   items:[
       {
           layout:'column',
           defaults:{layout:'form'},
           items:[
               {   columnWidth:.50,
                   items:[this.nro_inicial]
               },
               {
                   columnWidth:.50,
                   items:[this.nro_final]
               }
           ]
       }
   ]
});

this.fieldChequera= new Ext.form.FieldSet({
        title: 'Datos de la Chequera',
        items:[
          this.tx_descripcion,
          this.PanelChequera,
          this.PanelNro,
          this.fe_chequera
       ]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ChequeraEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ChequeraEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaBancaria/guardarChequera',
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
                 ChequeraLista.main.store_lista.load();
                 ChequeraLista.main.editar.disable();
                 ChequeraLista.main.cheque.disable();
                 ChequeraEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ChequeraEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:800,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

            this.co_cuenta_bancaria,
            this.co_chequera,
            this.fieldChequera
                    
                    
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Chequera',
    modal:true,
    constrain:true,
    width:800,
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
ChequeraLista.main.mascara.hide();
}
,getStoreCO_ANO:function(){
var currentTime = new Date();
var now = currentTime.getFullYear();
var years = [];
y = 2015
while (y<=now){
     years.push([y]);
     y++;
}

this.store = new Ext.data.SimpleStore
({
      fields : ['tx_anio'],
      data : years
});
    return this.store;
}
};
Ext.onReady(ChequeraEditar.main.init, ChequeraEditar.main);
</script>
