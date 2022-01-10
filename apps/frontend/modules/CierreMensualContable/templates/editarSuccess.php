<script type="text/javascript">
Ext.ns("DetalleCierreMensual");
DetalleCierreMensual.main = {
init:function(){

//objeto store
this.store_lista = this.getLista();

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.store_mes = this.getDataMes();


//<ClavePrimaria>
this.co_cierre_mensual = new Ext.form.Hidden({
    name:'co_cierre_mensual',
    value:this.OBJ.co_cierre_mensual
});

this.monto_debe = new Ext.form.Hidden({
    name:'mo_debe'
});

this.monto_haber = new Ext.form.Hidden({
    name:'mo_haber'
});
//</ClavePrimaria>

this.hiddenJsonMovimiento  = new Ext.form.Hidden({
        name:'json_movimiento',
        value:''
});

this.co_mes = new Ext.form.ComboBox({
    fieldLabel : 'Mes',
    displayField:'tx_mes',
    store: this.store_mes,
    typeAhead: true,
    valueField: 'co_mes',
    hiddenName:'co_mes',
    name: 'co_mes',
    id: 'co_mes',
    triggerAction: 'all',
    emptyText:'Seleccione...',
    selectOnFocus:true,
    mode:'local',
    width:100,
    resizable:true
});

this.store_mes.load();

function formatoNro(val){
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}

this.total_debito = new Ext.form.DisplayField({
    value:"<span style='font-size:12px;'><b>Total Debito: </b>0,00</b></span>"
});

this.total_credito = new Ext.form.DisplayField({
    value:"<span style='font-size:12px;'><b>Total Credito: </b>0,00</b></span>"
});

this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Detalle del Movimiento',
    store: this.store_lista,
    loadMask:true,
    height:380,
    width:889,
    border:false,
    columns: [
    new Ext.grid.RowNumberer(),        
        {header: 'co_cuenta_contable', hidden: true, dataIndex: 'co_cuenta_contable'},
        {header: 'Cuenta Contable', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cuenta'},
        {header: 'Monto Debito', width:250,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_debito'},
        {header: 'Monto Credito', width:250,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_credito'}
    ],
    bbar: new Ext.ux.StatusBar({
            id: 'basic-statusbar',
            autoScroll:true,
            defaults:{style:'color:black;font-size:30px;',autoWidth:true},
            items:[ this.total_debito,'-',
                    this.total_credito]
    }), 
});


this.ejercicio = new Ext.form.NumberField({
	fieldLabel:'Ejercicio',
	name:'ejercicio',
	value:this.OBJ.ejercicio,
	allowBlank:false,
        readOnly:true,
	width:100
});


this.guardar = new Ext.Button({
    text:'Procesar',
    iconCls: 'icon-guardar',
    handler:function(){

      Ext.MessageBox.confirm('Confirmación', '¿Realmente desea procesar el cierre mensual?', function(boton){
      if(boton=="yes"){
            if(!DetalleCierreMensual.main.formFiltroPrincipal.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
                return false;
            }
            
            var list_movimiento = paqueteComunJS.funcion.getJsonByObjStore({
                store:DetalleCierreMensual.main.gridPanel_.getStore()
            });
        
            DetalleCierreMensual.main.hiddenJsonMovimiento.setValue(list_movimiento);

            DetalleCierreMensual.main.formFiltroPrincipal.getForm().submit({
                method:'POST',
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierreMensualContable/guardar',
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
                     CierreMensualContable.main.store_lista.load();
                     DetalleCierreMensual.main.winformPanel_.close();
                 }
            });
        }});

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        DetalleCierreMensual.main.winformPanel_.close();
    }
});

this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Busqueda',
    iconCls: 'icon-solpendiente',
    collapsible: true,
    titleCollapse: true,
    autoWidth:true,
    border:false,
    labelWidth: 110,
    padding:'10px',
    items:[ this.co_cierre_mensual,
            this.monto_debe,
            this.monto_haber,
            this.co_mes,
            this.ejercicio,
            this.hiddenJsonMovimiento],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                DetalleCierreMensual.main.aplicarFiltroByFormulario();
            }
        }
    ]
});

this.winformPanel_ = new Ext.Window({
    title:'Cierre Presupuesto Ingreso',
    modal:true,
    constrain:true,
    width:900,
    frame:true,
    closabled:true,
    height:580,
    items:[
        this.formFiltroPrincipal,
        this.gridPanel_
    ],
    buttons:[
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
CierreMensualContable.main.mascara.hide();
},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = DetalleCierreMensual.main.formFiltroPrincipal.getForm().getValues();

        DetalleCierreMensual.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" DetalleCierreMensual.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    DetalleCierreMensual.main.store_lista.baseParams.BuscarBy = true;
	    DetalleCierreMensual.main.store_lista.load({
                callback: function(){
                    var mo_debito = paqueteComunJS.funcion.getSumaColumnaGrid({
                        store:DetalleCierreMensual.main.store_lista,
                        campo:'mo_debito'
                    });
                    
                    var mo_credito = paqueteComunJS.funcion.getSumaColumnaGrid({
                        store:DetalleCierreMensual.main.store_lista,
                        campo:'mo_credito'
                    });

                    DetalleCierreMensual.main.total_debito.setValue("<span style='font-size:12px;'><b>Total Debito: </b>"+paqueteComunJS.funcion.getNumeroFormateado(mo_debito)+"</b></span>");     
                    DetalleCierreMensual.main.total_credito.setValue("<span style='font-size:12px;'><b>Total Cedito: </b>"+paqueteComunJS.funcion.getNumeroFormateado(mo_credito)+"</b></span>");     

                    DetalleCierreMensual.main.monto_debe.setValue(mo_debito);
                    DetalleCierreMensual.main.monto_haber.setValue(mo_credito);
                }
            });
	}else{
	    Ext.MessageBox.show({
		       title: 'Notificación',
		       msg: 'Debe ingresar un parametro de busqueda',
		       buttons: Ext.MessageBox.OK,
		       icon: Ext.MessageBox.WARNING
	    });
	}

},
limpiarCamposByFormFiltro: function(){
	DetalleCierreMensual.main.formFiltroPrincipal.getForm().reset();
	DetalleCierreMensual.main.store_lista.baseParams={};
	DetalleCierreMensual.main.store_lista.load();
},
getDataMes: function(){
var store =  new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/CierrePresupuestoEgreso/storelistaMes',
                root:'data',
                fields: ['co_mes','tx_mes']
 });
return store;
}, 
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierreMensualContable/storelista',
    root:'data',
    fields:[
            {name: 'co_cuenta_contable'},
            {name: 'tx_cuenta'},
            {name: 'mo_debito'},
            {name: 'mo_credito'}
           ]
    });
    return this.store;
}
};
Ext.onReady(DetalleCierreMensual.main.init, DetalleCierreMensual.main);
</script>
