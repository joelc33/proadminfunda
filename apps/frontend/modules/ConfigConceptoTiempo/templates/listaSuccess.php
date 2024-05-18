<script type="text/javascript">
Ext.ns("ConfigConceptoTiempoLista");
ConfigConceptoTiempoLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        ConfigConceptoTiempoLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigConceptoTiempo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoTiempo/editar',
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
	this.codigo  = ConfigConceptoTiempoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concepto_tiempo');
	ConfigConceptoTiempoLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigConceptoTiempo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoTiempo/editar/codigo/'+this.codigo,
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
	this.codigo  = ConfigConceptoTiempoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concepto_tiempo');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoTiempo/eliminar',
            params:{
                co_concepto_tiempo:ConfigConceptoTiempoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_concepto_tiempo')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConfigConceptoTiempoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConfigConceptoTiempoLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroConfigConceptoTiempo');
        ConfigConceptoTiempoLista.main.mascara.show();
        ConfigConceptoTiempoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoTiempo/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de ConfigConceptoTiempo',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_concepto_tiempo',hidden:true, menuDisabled:true,dataIndex: 'co_concepto_tiempo'},
    {header: 'Tipo Nomina', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nomina'},
    {header: 'Grupo Nomina', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'cod_grupo_nomina'},
    {header: 'Concepto', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'concepto'},
    //{header: 'Cant. Meses', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_mes_ini'},
    {header: 'Rango (Meses)', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'rango'},
    {header: 'Valor / Monto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_valor'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){ConfigConceptoTiempoLista.main.editar.enable();ConfigConceptoTiempoLista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedorConfigConceptoTiempoLista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoTiempo/storelista',
    root:'data',
    fields:[
    {name: 'co_concepto_tiempo'},
    {name: 'co_tp_nomina'},
    {name: 'co_grupo_nomina'},
    {name: 'nu_mes_ini'},
    {name: 'nu_mes_fin'},
    {name: 'nu_concepto'},
    {name: 'co_concepto'},
    {name: 'nu_valor'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'cod_grupo_nomina'},
    {
        name: 'nomina',
        convert: function(v, r) {
                return r.nu_nomina + ' - ' + r.tx_tp_nomina;
        }
    },
    {
        name: 'concepto',
        convert: function(v, r) {
                return r.nu_concepto + ' - ' + r.tx_concepto;
        }
    },
    {
        name: 'rango',
        convert: function(v, r) {
                return r.nu_mes_ini + ' - ' + r.nu_mes_fin;
        }
    }
    ]
    });
    return this.store;
}
};
Ext.onReady(ConfigConceptoTiempoLista.main.init, ConfigConceptoTiempoLista.main);
</script>
<div id="contenedorConfigConceptoTiempoLista"></div>
<div id="formularioConfigConceptoTiempo"></div>
<div id="filtroConfigConceptoTiempo"></div>
