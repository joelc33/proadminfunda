<script type="text/javascript">
Ext.ns("listaProceso");
listaProceso.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
    
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();
this.storeCO_PROCESO = this.getStoreCO_PROCESO();
this.storeCO_PROCESO.baseParams.co_usuario = '<?php echo $co_usuario ?>';

this.co_usuario = new Ext.form.Hidden({
    name:'co_usuario',
    value:'<?php echo $co_usuario ?>'
});
//</ClavePrimaria>


this.co_proceso = new Ext.form.ComboBox({
	fieldLabel:'Proceso',
	store: this.storeCO_PROCESO,
	typeAhead: true,
	valueField: 'co_proceso',
	displayField:'tx_proceso',
	hiddenName:'co_proceso',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false
});

this.storeCO_PROCESO.load();

this.agregar = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-nuevo',
    width:80,
    handler:function(){
        listaProceso.main.mascara.show();
        this.msg = Ext.get('formularioinstituto');
        this.msg.load({
         url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/agregarProceso",
         scripts: true,
         text: "Cargando..",
         params:{co_usuario:listaProceso.main.co_usuario.getValue(),
                 co_proceso:listaProceso.main.co_proceso.getValue(),
                 in_principal: listaProceso.main.in_principal.getValue()
                }
        });
    }
});

//Eliminar
this.eliminar = new Ext.Button({
    text:'Eliminar',
    iconCls: 'icon-eliminar',
    handler:function(){
    
        Ext.Ajax.request({
            method:'POST',
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/eliminarProceso',
            params:{
                co_usuario_proceso: listaProceso.main.gridPanel_.getSelectionModel().getSelected().get('co_usuario_proceso')
            },
            success:function(result, request ){
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    listaProceso.main.store_lista.load();                   
                }
            }
        });
    }
});

this.principal = new Ext.Button({
    text:'Principal',
    iconCls: 'icon-nuevo',
    width:80,
    handler:function(){
        /*listaProceso.main.mascara.show();
        this.msg = Ext.get('formularioinstituto');
        this.msg.load({
         url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/usuario/principalInstituto",
         scripts: true,
         text: "Cargando..",
         params:{
                     co_usuario:listaProceso.main.gridPanel_.getSelectionModel().getSelected().get('co_usuario'),
                     co_usuario_instituto:listaProceso.main.gridPanel_.getSelectionModel().getSelected().get('co_usuario_instituto'),
                     co_instituto:listaProceso.main.gridPanel_.getSelectionModel().getSelected().get('co_instituto')
                }
        });*/

        Ext.Ajax.request({
            method:'POST',
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/principalProceso',
            params:{
                co_usuario_proceso: listaProceso.main.gridPanel_.getSelectionModel().getSelected().get('co_usuario_proceso')
            },
            success:function(result, request ){
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    listaProceso.main.store_lista.load();                   
                }
            }
        });
    }
});



this.in_principal = new Ext.form.Checkbox({
	fieldLabel:'Principal',
	name:'in_pricipal'
});



this.panel2 = new Ext.form.FormPanel({
  title:'Lista de Procesos',
  bodyStyle:'padding:10px;',
  items:[this.co_usuario,
        this.co_proceso,
        this.in_principal
	],
  buttons:[
        this.agregar
  ],
  buttonAlign:'center'
});

this.principal.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Proceso',
    tbar:[this.principal,'-',this.eliminar],
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
    autoScroll:true,
    height:450,
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'co_usuario_proceso',hidden:true, menuDisabled:true,dataIndex: 'co_usuario_proceso'},
        {header: 'Proceso', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_proceso'},
        {header: 'Principal', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_principal'}
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
              listaProceso.main.co_usuario.setValue(listaProceso.main.gridPanel_.getSelectionModel().getSelected().get('co_usuario'));
              listaProceso.main.principal.enable();
              listaProceso.main.eliminar.enable();
    }}
});
this.panel2.render("contenedorInstituto");
this.gridPanel_.render("contenedorlistaProceso");

//Cargar el grid
this.store_lista.baseParams.paginar = 'si';
this.store_lista.baseParams.co_usuario = '<?php echo $co_usuario ?>';
this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/storelistaProceso',
    root:'data',
    fields:[
            {name: 'co_usuario_proceso'},
            {name: 'tx_proceso'},
            {name: 'in_principal'}
           ]
    });
    return this.store;
},getStoreCO_PROCESO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/storefkcoproceso',
        root:'data',
        fields:[
                {name: 'co_proceso'},
                {name: 'tx_proceso'}
            ]
    });
    return this.store;
}
};
Ext.onReady(listaProceso.main.init, listaProceso.main);
</script>
<div id="contenedorInstituto"></div>
<div id="contenedorlistaProceso"></div>
<div id="formularioinstituto"></div>