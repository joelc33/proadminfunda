<script type="text/javascript">
Ext.ns("agregarAjuste");
agregarAjuste.main = {
init:function(){
    
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.store_lista = this.getLista();

function formatoNro(val){
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}

this.co_cuenta_contable = new Ext.form.Hidden({
    name:'co_cuenta_contable'
});

this.ejercicio = new Ext.form.NumberField({
	fieldLabel:'Ejercicio',
	name:'ejercicio',
	value:this.OBJ.ejercicio,
	allowBlank:false,
        readOnly:true,
	width:100
});

this.fecha = new Ext.form.DateField({
	fieldLabel:'Fecha',
	name:'fecha',
        readOnly:true,
        value:this.OBJ.fecha,
        minValue:this.OBJ.fecha,
	maxValue:this.OBJ.fecha,
        allowBlank:false,
	width:100
});

this.descripcion = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'descripcion',     
        allowBlank:false,
	width:755
});

this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Detalle del Movimiento',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:400,
    border:false,
    tbar:[
    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'co_cuenta_contable', hidden:true, width:250,  menuDisabled:true, sortable: true, dataIndex: 'co_cuenta_contable'},
        {header: 'Cuenta Contable', width:100,  menuDisabled:true, sortable: true, dataIndex: 'nu_cuenta_contable'},
        {header: 'Descripción', width:500,  menuDisabled:true, sortable: true, dataIndex: 'tx_descripcion'},
        {header: 'Monto Debito', width:150,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_debe'},
        {header: 'Monto Credito', width:150,  menuDisabled:true, sortable: true, renderer: formatoNro, dataIndex: 'mo_haber'}
   ],
   listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){}},
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    bbar: new Ext.PagingToolbar({
        pageSize: 100000,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })    
});


this.guardar = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-nuevo',
    handler:function(){
         agregarAjuste.main.agregarCuenta();
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        agregarAjuste.main.winformPanel_.close();
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
    items:[
            this.ejercicio,
            this.fecha,
            this.descripcion
        ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                agregarAjuste.main.aplicarFiltroByFormulario();
            }
        }
    ]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Cuenta',
    modal:true,
    constrain:true,
    width:1000,
    frame:true,
    closabled:true,
    autoHeight:true,
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
//PagoNominaLista.main.mascara.hide();
},agregarCuenta: function(){

    this.monto_debe = paqueteComunJS.funcion.getSumaColumnaGrid({
        store:agregarAjuste.main.store_lista,
        campo:'mo_debe'
        }); 

    this.monto_haber = paqueteComunJS.funcion.getSumaColumnaGrid({
        store:agregarAjuste.main.store_lista,
        campo:'mo_haber'
        });             

        if(parseFloat(this.monto_debe)<parseFloat(this.monto_haber)){
            Ext.Msg.alert("Alerta","Debe ingresar hay Diferencia entre debitos y creditos, Verifique las fechas en color rojo");
            return false;
        }     

        if(parseFloat(this.monto_debe)>parseFloat(this.monto_haber)){
            Ext.Msg.alert("Alerta","Hay Diferencias entre debitos y creditos, Verifique las fechas en color rojo");
            return false;
        } 
        
        if(!agregarAjuste.main.formFiltroPrincipal.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }        
       
       var count=agregarAjuste.main.store_lista.getCount();
        ComprobanteAjuste.main.store_lista.removeAll();
        for(var j = 0; j <= count-1; j++){

        var e = new ComprobanteAjuste.main.Registro({  
            co_cuenta_contable: agregarAjuste.main.store_lista.getAt(j).get('co_cuenta_contable'),
            tx_cuenta:agregarAjuste.main.store_lista.getAt(j).get('nu_cuenta_contable'),
            denominacion:agregarAjuste.main.store_lista.getAt(j).get('tx_descripcion'),
            descripcion:agregarAjuste.main.descripcion.getValue(),
            fecha:agregarAjuste.main.fecha.getValue().format('Y-m-d'),
            mo_debito:agregarAjuste.main.store_lista.getAt(j).get('mo_debe'),
            mo_credito:agregarAjuste.main.store_lista.getAt(j).get('mo_haber')
        });
        
        
        var cant = ComprobanteAjuste.main.store_lista.getCount();
       
        (cant == 0) ? 0 : ComprobanteAjuste.main.store_lista.getCount() + 1;
        ComprobanteAjuste.main.store_lista.insert(cant, e);

        ComprobanteAjuste.main.gridPanel.getView().refresh();        

        }
                
        
        Ext.utiles.msg('Mensaje', "Las cuantas se agregaron exitosamente");
        
        agregarAjuste.main.winformPanel_.close();
},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
        
        if(agregarAjuste.main.OBJ.mes!=12){
	    Ext.MessageBox.show({
		       title: 'Notificación',
		       msg: 'Debe cerrar primero diciembre para poder consultar',
		       buttons: Ext.MessageBox.OK,
		       icon: Ext.MessageBox.WARNING
	    });            
            return false
        }
        
        if(agregarAjuste.main.OBJ.co_comprobante_contable!=null){
	    Ext.MessageBox.show({
		       title: 'Notificación',
		       msg: 'El cierre fiscal contable ya fue realizado y aprobado',
		       buttons: Ext.MessageBox.OK,
		       icon: Ext.MessageBox.WARNING
	    });            
            return false
        }        
        
        
	var campo = agregarAjuste.main.formFiltroPrincipal.getForm().getValues();

        agregarAjuste.main.store_lista.baseParams={}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval(" agregarAjuste.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    agregarAjuste.main.store_lista.baseParams.BuscarBy = true;
           // DetalleCierrePresupuestoEgreso.main.store_lista.baseParams.in_ventanilla = 'true';
	    agregarAjuste.main.store_lista.load();
	}else{
	    Ext.MessageBox.show({
		       title: 'Notificación',
		       msg: 'Debe ingresar un parametro de busqueda',
		       buttons: Ext.MessageBox.OK,
		       icon: Ext.MessageBox.WARNING
	    });
	}

	},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ComprobanteAjuste/storelistacierre',
    root:'data',
    fields:[
            {name: 'co_cuenta_contable'},
            {name: 'tx_descripcion'},
            {name: 'nu_cuenta_contable'},
            {name: 'mo_debe'},
            {name: 'mo_haber'}
           ]
    });
    return this.store;
}
};
Ext.onReady(agregarAjuste.main.init, agregarAjuste.main);
</script>
<div id="formulario"></div>