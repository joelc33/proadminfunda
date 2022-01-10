<script type="text/javascript">
Ext.ns("IngresoFinancieroLista");
IngresoFinancieroLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//<ClavePrimaria>
this.co_solicitud = new Ext.form.Hidden({
    name:'tb155_cuenta_bancaria_historico[co_solicitud]',
    value:this.OBJ.co_solicitud
});
//</ClavePrimaria>

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        IngresoFinancieroLista.main.mascara.show();
        this.msg = Ext.get('formularioIngresoFinanciero');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/editar',
         params:{
            co_solicitud: IngresoFinancieroLista.main.co_solicitud.getValue()
        },
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = IngresoFinancieroLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	IngresoFinancieroLista.main.mascara.show();
        this.msg = Ext.get('formularioIngresoFinanciero');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/editar/codigo/'+this.codigo,
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
	this.codigo  = IngresoFinancieroLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/eliminar',
            params:{
                id:IngresoFinancieroLista.main.gridPanel_.getSelectionModel().getSelected().get('id')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    IngresoFinancieroLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                IngresoFinancieroLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroIngresoFinanciero');
        IngresoFinancieroLista.main.mascara.show();
        IngresoFinancieroLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    //title:'Lista de Ingreso Financiero',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:400,
    tbar:[
        this.nuevo,'-',
        this.editar,'-',
        //this.eliminar,'-',
        this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Banco', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tb010_banco'},
    {header: 'N° Documento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_documento'},
    {header: 'Cuenta Bancaria', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'cuenta'},
    {header: 'Fecha', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_transaccion'},
    {header: 'N° Transaccion', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_transaccion'},
    {header: 'Monto', width:150,  menuDisabled:true, sortable: true, renderer: formatoNumero,  dataIndex: 'mo_transaccion'},
    {header: 'Saldo Nuevo', width:150,  menuDisabled:true, sortable: true, renderer: formatoNumero,  dataIndex: 'mo_saldo_nuevo'},
    {header: 'Saldo Anterior', width:150,  menuDisabled:true, sortable: true, renderer: formatoNumero,  dataIndex: 'mo_saldo_anterior'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){IngresoFinancieroLista.main.editar.enable();IngresoFinancieroLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

//this.gridPanel_.render("contenedorIngresoFinancieroLista");

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        IngresoFinancieroLista.main.winformPanel_.close();
    }
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Transcripcion de Movimientos',
    modal:true,
    constrain:true,
width:1100,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ],
    buttons:[
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();

this.store_lista.baseParams.co_solicitud = IngresoFinancieroLista.main.co_solicitud.getValue();
this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/IngresoFinanciero/storelista',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'id_tb011_cuenta_bancaria'},
    {name: 'mo_transaccion'},
    {name: 'fe_transaccion'},
    {name: 'mo_saldo_nuevo'},
    {name: 'de_observacion'},
    {name: 'id_tb010_banco'},
    {name: 'id_tb154_tipo_cuenta_movimiento'},
    {name: 'id_tb153_tipo_documento_cuenta'},
    {name: 'id_tb156_subtipo_documento'},
    {name: 'nu_documento'},
    {name: 'mo_saldo_anterior'},
    {name: 'nu_transaccion'},
    {name: 'cuenta',
        convert:function(v,r){
        return r.id_tb011_cuenta_bancaria+' - '+r.tx_descripcion;
        }
    }
    ]
    });
    return this.store;
}
};
Ext.onReady(IngresoFinancieroLista.main.init, IngresoFinancieroLista.main);
</script>
<div id="contenedorIngresoFinancieroLista"></div>
<div id="formularioIngresoFinanciero"></div>
<div id="filtroIngresoFinanciero"></div>
