<script type="text/javascript">
Ext.ns("agregarAjuste");
agregarAjuste.main = {
init:function(){
    
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.store_lista = this.getLista();
//this.store_lista_partida_desafectar = this.getListaDesafectar();
this.storeCO_PARTIDA  = this.getStoreCO_PARTIDA();
this.storeCO_PROYECTO = this.getStoreCO_PROYECTO();
this.storeCO_ACCION   = this.getStoreCO_ACCION();
this.storeCO_EJECUTOR = this.getStoreCO_EJECUTOR();

this.monto_partida = 0;

function formatoNro(val){
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}

this.gridPanel = new Ext.grid.GridPanel({
        title:'Partidas',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:200,
        width:970,        
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'Patida',width:700, menuDisabled:true,dataIndex: 'co_categoria',renderer:textoLargo},         
            {header: 'co_partida',hidden:true,width:500, menuDisabled:true,dataIndex: 'co_partida',renderer:textoLargo},         
            {header: 'Monto',width:200, menuDisabled:true,dataIndex: 'monto',renderer:formatoNro}
        ],
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
                agregarAjuste.main.guardar.enable();
        }},        
        stripeRows: true,
        autoScroll:true,
        stateful: true
});

this.fieldDesafectar= new Ext.form.FieldSet({
        title: 'Partida a Desafectar',
        items:[
            this.gridPanel
       ]
});

this.co_ejecutor = new Ext.form.ComboBox({
	fieldLabel:'Ente Ejecutor',
	store: this.storeCO_EJECUTOR,
	typeAhead: true,
	valueField: 'id',
        id:'co_ejecutor',
	displayField:'de_ejecutor',
	hiddenName:'co_ejecutor',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	allowBlank:false,
        listeners:{
            select: function(){
                agregarAjuste.main.storeCO_PROYECTO.load({
                    params:{co_ejecutor:this.getValue()},
                    callback: function(){
                        agregarAjuste.main.co_proyecto.setValue(agregarAjuste.main.OBJ.co_proyecto);
                    }
                });
            }
        }
});
this.storeCO_EJECUTOR.load();

this.co_proyecto = new Ext.form.ComboBox({
	fieldLabel:'Proyecto/Ac',
	store: this.storeCO_PROYECTO,
	typeAhead: true,
	valueField: 'id',
        id:'co_proyecto',
	displayField:'de_proyecto_ac',
	hiddenName:'co_proyecto',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	allowBlank:false
});


this.co_proyecto.on('select',function(cmb,record,index){
        agregarAjuste.main.co_accion.clearValue();
        agregarAjuste.main.storeCO_ACCION.load({params:{co_proyecto:record.get('id')}});
},this);

this.co_accion = new Ext.form.ComboBox({
	fieldLabel:'Accion Especifica',
	store: this.storeCO_ACCION,
	typeAhead: true,
	valueField: 'id',
        id:'co_accion',
	displayField:'accion_especifica',
	hiddenName:'co_accion',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	allowBlank:false,
        listeners:{
            select: function(){
                agregarAjuste.main.storeCO_PARTIDA.baseParams.co_accion = this.getValue();
                agregarAjuste.main.storeCO_PARTIDA.baseParams.co_clase_producto = agregarAjuste.main.OBJ.co_clase_producto;                
                agregarAjuste.main.storeCO_PARTIDA.load();
            }
        }
});

this.fieldDatosContrato= new Ext.form.FieldSet({
        title: 'Datos de la Compra',
        items: [this.co_ejecutor,
                this.co_proyecto,
                this.co_accion]
});

this.co_partida = new Ext.form.ComboBox({
	fieldLabel:'Partida',
	store: this.storeCO_PARTIDA,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_partida',
	hiddenName:'co_presupuesto',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:700,
	allowBlank:false,
        listeners:{
            select: function(){
                agregarAjuste.main.cargarDisponible();
            }
        }
});

this.mo_disponible = new Ext.form.TextField({
	fieldLabel:'Monto Disponible',
	name:'mo_disponible',
        readOnly:true,
	style:'background:#c9c9c9;',
	width:400
});

this.fieldAfectar= new Ext.form.FieldSet({
        title: 'Partida a Afectar',
        items:[
                this.co_ejecutor,
                this.co_proyecto,
                this.co_accion,
                this.co_partida,
                this.mo_disponible
       ]
});


this.store_lista.baseParams.co_odp = this.OBJ.co_orden_pago;
this.store_lista.baseParams.lista_detalle_compra =this.OBJ.lista_detalle_compra;
this.store_lista.load();

//this.store_lista_partida_desafectar.baseParams.co_odp= this.OBJ.co_orden_pago;
//this.store_lista_partida_desafectar.load();

this.guardar = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-nuevo',
    handler:function(){
         agregarAjuste.main.agregarPartida();
    }
});

this.guardar.disable();

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        agregarAjuste.main.winformPanel_.close();
    }
});



this.formPanel_ = new Ext.form.FormPanel({
    fileUpload: true,
    frame:true,
    width:1000,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.fieldDesafectar,
           this.fieldAfectar]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Partida',
    modal:true,
    constrain:true,
    width:1000,
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
//PagoNominaLista.main.mascara.hide();
},agregarPartida: function(){
        if(!agregarAjuste.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        } 
        
        var monto_ajuste  = agregarAjuste.main.gridPanel.getSelectionModel().getSelected().get('monto');
        var monto_partida = agregarAjuste.main.mo_disponible.getValue();
        
        
        if(parseFloat(agregarAjuste.main.monto_partida)< parseFloat(monto_ajuste)){
            Ext.Msg.alert("Alerta","El monto de la partida debe ser mayor o igual al monto de ajuste "+parseFloat(monto_partida)+" < "+parseFloat(monto_ajuste));
            return false;
        } 
       
        var e = new ComprobanteAjuste.main.Registro({  
            co_partida_comprobante_ajuste: '',
            co_partida_afectada:agregarAjuste.main.co_partida.getValue(),
            co_categoria_afectada:agregarAjuste.main.co_partida.lastSelectionText,
            co_partida_desafectada:agregarAjuste.main.gridPanel.getSelectionModel().getSelected().get('co_partida'),
            co_categoria_desafectada:agregarAjuste.main.gridPanel.getSelectionModel().getSelected().get('co_categoria'),
            co_detalle_compras:agregarAjuste.main.gridPanel.getSelectionModel().getSelected().get('co_detalle_compras'),
            monto:agregarAjuste.main.gridPanel.getSelectionModel().getSelected().get('monto')
        });
                
        var cant = ComprobanteAjuste.main.store_lista.getCount();
       
        (cant == 0) ? 0 : ComprobanteAjuste.main.store_lista.getCount() + 1;
        ComprobanteAjuste.main.store_lista.insert(cant, e);

        ComprobanteAjuste.main.gridPanel.getView().refresh();
        
        Ext.utiles.msg('Mensaje', "El registro se agregó exitosamente");
        
        agregarAjuste.main.winformPanel_.close();
},
cargarDisponible:function(){
    Ext.Ajax.request({
        method:'GET',
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Presupuesto/cargarDisponible',
        params:{
            co_partida: agregarAjuste.main.co_partida.getValue()
        },
        success:function(result, request ) {
            obj = Ext.util.JSON.decode(result.responseText);
            agregarAjuste.main.monto_partida = obj.data.mo_disponible;
            agregarAjuste.main.mo_disponible.setValue(paqueteComunJS.funcion.getNumeroFormateado(obj.data.mo_disponible));
        }
    });
},
getStoreCO_PARTIDA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcopartida',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'mo_disponible'},
            {name: 'de_partida',
            convert:function(v,r){
            return r.nu_partida+' - '+r.de_partida;
            }
            }
            ]
    });
    return this.store;
},
getStoreCO_PROYECTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoproyecto',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_proyecto_ac',
            convert:function(v,r){
            return r.nu_proyecto_ac+' - '+r.de_proyecto_ac;
            }
            }
            ]
    });
    return this.store;
},
getStoreCO_EJECUTOR:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/storefkcoejecutor',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_ejecutor',
            convert:function(v,r){
            return r.de_ejecutor;
            }
            }
            ]
    });
    return this.store;
},
getStoreCO_ACCION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcoaccion',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'accion_especifica',
            convert:function(v,r){
            return r.nu_accion_especifica+' - '+r.de_accion_especifica;
            }
            }
            ]
    });
    return this.store;
},getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ComprobanteAjuste/storelistaPartida',
    root:'data',
    fields:[ 
                {name :'co_partida'},
                {name: 'co_categoria',
                    convert:function(v,r){
                        return r.co_categoria+' - '+r.de_partida;
                    }
                },
                {name :'de_partida'},
                {name :'co_detalle_compras'},
                {name : 'monto'}
           ]
    });
    return this.store;
}
,getListaDesafectar: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ComprobanteAjuste/storelistaPartidaDesafectar',
    root:'data',
    fields:[ 
                {name :'co_partida'},
                {name: 'co_categoria'},
                {name :'de_partida'},
                {name : 'monto'}
           ]
    });
    return this.store;
}
};
Ext.onReady(agregarAjuste.main.init, agregarAjuste.main);
</script>
<div id="formulario"></div>