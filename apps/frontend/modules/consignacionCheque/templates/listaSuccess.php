<script type="text/javascript">
Ext.ns("consignacionChequeLista");
consignacionChequeLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        consignacionChequeLista.main.mascara.show();
        this.msg = Ext.get('formularioconsignacionCheque');
        this.msg.load({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/consignacionCheque/editar',
            scripts: true,
            text: "Cargando..",
            params:{
                co_solicitud:consignacionChequeLista.main.OBJ.co_solicitud
            }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = consignacionChequeLista.main.gridPanel_.getSelectionModel().getSelected().get('co_consignacion_cheque');
	consignacionChequeLista.main.mascara.show();
        this.msg = Ext.get('formularioconsignacionCheque');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/consignacionCheque/editar/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Eliminar un registro
this.eliminar= new Ext.Button({
    text:'Eliminar',
    iconCls: 'icon-eliminar',
    handler:function(){
	this.codigo  = consignacionChequeLista.main.gridPanel_.getSelectionModel().getSelected().get('co_consignacion_cheque');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/consignacionCheque/eliminar',
            params:{
                co_consignacion_cheque:consignacionChequeLista.main.gridPanel_.getSelectionModel().getSelected().get('co_consignacion_cheque')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    consignacionChequeLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                consignacionChequeLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroconsignacionCheque');
        consignacionChequeLista.main.mascara.show();
        consignacionChequeLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/consignacionCheque/filtro',
             scripts: true,
             params:{
                co_solicitud:consignacionChequeLista.main.OBJ.co_solicitud
            }
        });
    }
});

this.editar.disable();
this.eliminar.disable();

function formatoNro(val){
	return paqueteComunJS.funcion.getNumeroFormateado(val);
}

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de consignacionCheque',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_consignacion_cheque',hidden:true, menuDisabled:true,dataIndex: 'co_consignacion_cheque'},
    {header: 'Banco', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_banco'},
    {header: 'Cuenta Bancaria', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_cuenta_bancaria'},
    {header: 'Chequera', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_chequera'},
    {header: 'Cheque', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_cheque'},
    {header: 'Titular', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nb_titular'},
    {header: 'Monto', width:200,  menuDisabled:true, sortable: true,  renderer: formatoNro, dataIndex: 'mo_cheque'},
    {header: 'Fecha', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_pago'},
    {header: 'Estado', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_estado_cheque'},
    {header: 'Observacion', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_observacion'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){consignacionChequeLista.main.editar.enable();consignacionChequeLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

//this.gridPanel_.render("contenedorconsignacionChequeLista");

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Consignacion Cheque',
    modal:true,
    constrain:true,
    width:1200,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ],
    /*buttons:[
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'*/
});
this.winformPanel_.show();

this.store_lista.baseParams.co_solicitud=consignacionChequeLista.main.OBJ.co_solicitud;
this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/consignacionCheque/storelista',
    root:'data',
    fields:[
    {name: 'co_consignacion_cheque'},
    {name: 'co_solicitud'},
    {name: 'co_banco'},
    {name: 'co_cuenta_bancaria'},
    {name: 'co_chequera'},
    {name: 'co_cheque'},
    {name: 'nb_titular'},
    {name: 'mo_cheque'},
    {name: 'fe_pago'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'tx_estado_cheque'},
    {name: 'tx_observacion'},
           ]
    });
    return this.store;
}
};
Ext.onReady(consignacionChequeLista.main.init, consignacionChequeLista.main);
</script>
<div id="contenedorconsignacionChequeLista"></div>
<div id="formularioconsignacionCheque"></div>
<div id="filtroconsignacionCheque"></div>
