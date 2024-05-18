<script type="text/javascript">
Ext.ns("GenerarNomina");
GenerarNomina.main = {
init:function(){

//objeto store
this.store_lista = this.getLista();

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});


//<ClavePrimaria>
this.co_cierre_egreso = new Ext.form.Hidden({
    name:'co_cierre_egreso'
});
//</ClavePrimaria>

this.hiddenJsonMovimiento  = new Ext.form.Hidden({
        name:'json_movimiento',
        value:''
});

//this.fe_desde = new Ext.form.DateField({
//	fieldLabel:'Fecha Desde',
//	name:'fe_desde',
//	value:this.OBJ.fe_desde,
//	maxValue:this.OBJ.fe_hasta,
//	width:100
//});
//
//this.fe_hasta = new Ext.form.DateField({
//	fieldLabel:'Fecha Hasta',
//	name:'fe_hasta',
//	value:this.OBJ.fe_hasta,
//        minValue:this.OBJ.fe_desde,
//	width:100
//});

//this.tx_organismo = new Ext.form.TextField({
//	fieldLabel:'Organismo',
//	name:'tx_organismo',
//	value:this.OBJ.tx_organismo,
//	allowBlank:false,
//	width:600
//});

function formatoNro(val){
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}

this.co_tipo = new Ext.form.ComboBox({
    fieldLabel : 'Tipo de Nomina',
    displayField:'tx_tipo',
    store:new Ext.data.SimpleStore({
    data : [[1, 'OBREROS'],[2, 'PENSIONADOS']],
    fields : ['co_tipo', 'tx_tipo']
         }),
    typeAhead: true,
    valueField: 'co_tipo',
    hiddenName:'co_tipo',
    name: 'co_tipo',
    id: 'co_tipo',
    triggerAction: 'all',
    emptyText:'Seleccione...',
    selectOnFocus:true,
    mode:'local',
    width:200,
    resizable:true
});


this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Detalle de la Nomina',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
    height:400,  
    //width:750,  
    columns: [
    new Ext.grid.RowNumberer(),   
        {header: 'Cedula', width:250,  menuDisabled:true, sortable: true, dataIndex: 'cedula'},
        {header: 'nombre', width:250,  menuDisabled:true, sortable: true, dataIndex: 'nombre'},
        {header: 'asignaciones', width:250,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'asignaciones'},
        {header: 'deducciones', width:250,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'deducciones'},
        {header: 'monto a pagar', width:250,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'monto_pago'}
   ],
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


this.ejercicio = new Ext.form.NumberField({
	fieldLabel:'Ejercicio',
	name:'ejercicio',
	value:this.OBJ.ejercicio,
	allowBlank:false,
        readOnly:true,
	width:100
});


this.guardar = new Ext.Button({
    text:'Pocesar',
    iconCls: 'icon-guardar',
    handler:function(){

      Ext.MessageBox.confirm('Confirmación', '¿Realmente desea procesar el cierre?', function(boton){
      if(boton=="yes"){
            if(!GenerarNomina.main.formFiltroPrincipal.getForm().isValid()){
                Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
                return false;
            }
            
            var list_movimiento = paqueteComunJS.funcion.getJsonByObjStore({
                store:GenerarNomina.main.gridPanel_.getStore()
            });
        
            GenerarNomina.main.hiddenJsonMovimiento.setValue(list_movimiento);

            GenerarNomina.main.formFiltroPrincipal.getForm().submit({
                method:'POST',
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CierrePresupuestoEgreso/guardar',
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
                     CierrePresupuestoEgreso.main.store_lista.load();
                     GenerarNomina.main.winformPanel_.close();
                 }
            });
        }});

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        GenerarNomina.main.winformPanel_.close();
    }
});

this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Generar Nomina',
    iconCls: 'icon-solpendiente',
    collapsible: true,
    titleCollapse: true,
    autoWidth:true,
    border:true,
    labelWidth: 110,
    padding:'10px',
    items:[this.co_cierre_egreso,
            //this.fe_desde,
            //this.fe_hasta,
            this.co_tipo,
            //this.ejercicio,
            this.hiddenJsonMovimiento,
            ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Calcular',
            iconCls:'icon-calculator_link',
            handler:function(){
                GenerarNomina.main.aplicarFiltroByFormulario();
            }
        }
    ]
});

this.formFiltroPrincipal.render("formulario");
this.gridPanel_.render("grid");
},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = GenerarNomina.main.formFiltroPrincipal.getForm().getValues();

        GenerarNomina.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" GenerarNomina.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    GenerarNomina.main.store_lista.baseParams.BuscarBy = true;
           // GenerarNomina.main.store_lista.baseParams.in_ventanilla = 'true';
	    GenerarNomina.main.store_lista.load();
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
	GenerarNomina.main.formFiltroPrincipal.getForm().reset();
	GenerarNomina.main.store_lista.baseParams={};
	GenerarNomina.main.store_lista.load();
}, 
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/PagoNomina/storelistagenerar',
    root:'data',
    fields:[
            {name: 'cedula'},
            {name: 'nombre'},
            {name: 'asignaciones'},
            {name: 'deducciones'},
            {name: 'monto_pago'}
           ]
    });
    return this.store;
}
};
Ext.onReady(GenerarNomina.main.init, GenerarNomina.main);
</script>
<div id="formulario"></div>
<div id="grid"></div>