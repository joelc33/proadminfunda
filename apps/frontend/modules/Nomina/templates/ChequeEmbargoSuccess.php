<script type="text/javascript">
Ext.ns("DetalleCierrePresupuestoEgreso");
DetalleCierrePresupuestoEgreso.main = {
init:function(){
this.hiddenJsonembargos = new Ext.form.Hidden({
            name : 'hiddenJsonembargos'

   });
  
//objeto store
this.store_lista = this.getLista();

this.co_nomina = new Ext.form.Hidden({
        name : 'co_nomina',
        value: '<?php echo $co_nomina; ?>'

});
   
function formatoNro(val){
    
        if(val==null){
            val = 0;
        }
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}

this.editar = new Ext.Button({
    text:'Imprimir Cheques',
    iconCls: 'icon-save',
    handler:function(){
      Ext.MessageBox.confirm('Confirmación', '¿Realmente desea procesar los Cheques?', function(boton){
      if(boton=="yes"){
                   
        if(!DetalleCierrePresupuestoEgreso.main.formFiltroPrincipal.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }          
          
        if(DetalleCierrePresupuestoEgreso.main.store_lista.getCount()==0){
        Ext.Msg.alert("Alerta","No Hay Embargo en las Nominas Seleccionadas");
        return false;
        }          
          
        var list = paqueteComunJS.funcion.getJsonByObjStore({
        store:DetalleCierrePresupuestoEgreso.main.gridPanel_.getStore()
        });
        DetalleCierrePresupuestoEgreso.main.hiddenJsonembargos.setValue(list);
            DetalleCierrePresupuestoEgreso.main.formFiltroPrincipal.getForm().submit({
                method:'POST',
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/guardarCheque',
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
                    
             DetalleCierrePresupuestoEgreso.main.store_lista.baseParams.co_nomina = DetalleCierrePresupuestoEgreso.main.co_nomina.getValue();
	     DetalleCierrePresupuestoEgreso.main.store_lista.load();
                 }
            });
        }});

   
    }
});

this.imprimir = new Ext.Button({
    text:'Formatos Cheques',
    iconCls: 'icon-pdf',
    handler:function(){
    window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/rrhhFormatoChequeNomina.php?codigo='+DetalleCierrePresupuestoEgreso.main.co_nomina.getValue());  
    }
});

//this.editar.disable();
function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 


this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Detalle Embargante',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:440,
    border:false,
    tbar:[
        this.imprimir
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Cedula', width:120,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cedula'},
    {header: 'Nombre y Apellido', width:350,  menuDisabled:true, sortable: true,  dataIndex: 'nb_trabajador'},
    {header: 'Monto', width:120,  menuDisabled:true, sortable: true,  dataIndex: 'mo_pago',renderer:renderMonto},
    {header: 'Nro Cheque', width:120,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cheque'}
    ],
   listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){DetalleCierrePresupuestoEgreso.main.editar.enable();}},
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })    
});
this.store_lista.baseParams.co_nomina = DetalleCierrePresupuestoEgreso.main.co_nomina.getValue();
this.store_lista.load();

this.nu_cheque_inicial = new Ext.form.NumberField({
	fieldLabel:'Cheque Inicial',
	name:'nu_cheque_inicial',
        allowBlank:false,
	width:100
});

this.nu_clave = new Ext.form.TextField({
	fieldLabel:'Palabra Clave',
	name:'nu_clave',
        allowBlank:false,
	width:100
});


this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        DetalleCierrePresupuestoEgreso.main.winformPanel_.close();
    }
});

this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Nomina Embargo',
    iconCls: 'icon-solpendiente',
    collapsible: true,
    titleCollapse: true,
    autoWidth:true,
    border:false,
    labelWidth: 110,
    padding:'10px',
    items:[ this.hiddenJsonembargos, 
            this.co_nomina,
            this.nu_cheque_inicial,
            this.nu_clave
          ],
            buttonAlign:'center',
            buttons:[
            this.editar
    ]
});

this.winformPanel_ = new Ext.Window({
    title:'Cheques de Embargos',
    modal:true,
    constrain:true,
    width:800,
    frame:true,
    closabled:true,
    height:630,
    items:[
        this.formFiltroPrincipal,
        this.gridPanel_
    ],
    buttons:[
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = DetalleCierrePresupuestoEgreso.main.formFiltroPrincipal.getForm().getValues();

        DetalleCierrePresupuestoEgreso.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" DetalleCierrePresupuestoEgreso.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    DetalleCierrePresupuestoEgreso.main.store_lista.baseParams.co_nomina = DetalleCierrePresupuestoEgreso.main.co_nomina.getValue();
	    DetalleCierrePresupuestoEgreso.main.store_lista.load();
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
	DetalleCierrePresupuestoEgreso.main.formFiltroPrincipal.getForm().reset();
	DetalleCierrePresupuestoEgreso.main.store_lista.baseParams={};
        DetalleCierrePresupuestoEgreso.main.store_lista.baseParams.co_nomina = DetalleCierrePresupuestoEgreso.main.co_nomina.getValue();
	DetalleCierrePresupuestoEgreso.main.store_lista.load();
}, 
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Nomina/storelistaEmbargante',
    root:'data',
    fields:[
            {name: 'id'},
            {name: 'nu_cedula'},
            {name: 'nb_trabajador'},
            {name: 'mo_pago'},
            {name: 'nu_cheque'}
           ]
    });
    return this.store;
}
};
Ext.onReady(DetalleCierrePresupuestoEgreso.main.init, DetalleCierrePresupuestoEgreso.main);
</script>
<div id="formularioPresupuestoEgreso"></div>
