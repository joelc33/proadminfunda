<script type="text/javascript">
Ext.ns("<?php echo $nu_cuenta  ?>");
<?php echo $nu_cuenta  ?>.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo Cargo',
    iconCls: 'icon-nuevo',
    handler:function(){
        this.msg = Ext.get("formulario_<?php echo $nu_cuenta  ?>");
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/agregarCargo',
         scripts: true,
         text: "Cargando..",
         params:{
             nivel: <?php echo $nu_cuenta  ?>.main.OBJ.nivel,
             paquete:'<?php echo $nu_cuenta  ?>',
             co_cargo_estructura:<?php echo $nu_cuenta  ?>.main.OBJ.co_cargo_estructura,
             co_estructura_administrativa: <?php echo $nu_cuenta  ?>.main.OBJ.co_estructura_administrativa,
             tx_estructura_administrativa: ""+<?php echo $nu_cuenta  ?>.main.OBJ.tx_estructura_administrativa+""
         }
        });
    }
});

this.secundaria = new Ext.Button({
    text:'Ver Cargos Asociados',
    iconCls: 'icon-nuevo',
    disabled:true,
    handler:function(){
        this.msg = Ext.get("formulario_<?php echo $nu_cuenta  ?>");
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/CargosLista',
         scripts: true,
         text: "Cargando..",
         params:{
             co_estructura_administrativa:<?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('co_estructura_administrativa'),
             co_cargo_estructura:<?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('co_cargo_estructura'),
             nivel: <?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('nivel'),
             tx_estructura_administrativa: ""+<?php echo $nu_cuenta  ?>.main.OBJ.tx_estructura_administrativa+""
         }
        });
    }
});

function renderInDisponible(val, attr, record) { 
    if(parseInt(record.data.cant) > 0){
        return '<p style="color:red"><b>'+val+'</b></p>';     
     }else{
        return val;  
     }
} 


//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Cargos',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:420,
    tbar:[
        this.nuevo,'-',this.secundaria
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_estructura_administrativa',hidden:true, menuDisabled:true,dataIndex: 'co_estructura_administrativa'},
    {header: 'co_cargo_estructura',hidden:true, menuDisabled:true,dataIndex: 'co_cargo_estructura'},
    {header: 'Cargo', width:250,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cargo',renderer:renderInDisponible},
    {header: 'Nivel', width:60,  menuDisabled:true, sortable: true,  dataIndex: 'nivel'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        
        var cant = <?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('cant');

        <?php echo $nu_cuenta  ?>.main.secundaria.enable();  
        

    },
    celldblclick:function(Grid, rowIndex, columnIndex,e ){
        this.msg = Ext.get("formulario_<?php echo $nu_cuenta  ?>");
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/CargosLista',
         scripts: true,
         text: "Cargando..",
         params:{
             co_estructura_administrativa:<?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('co_estructura_administrativa'),
             co_cargo_estructura:<?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('co_cargo_estructura'),
             nivel: <?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('nivel')
         }
        });
    }},
    bbar: new Ext.PagingToolbar({
        pageSize: 15,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.store_lista.baseParams.co_estructura_administrativa= <?php echo $nu_cuenta  ?>.main.OBJ.co_estructura_administrativa;
this.store_lista.baseParams.nu_nivel= <?php echo $nu_cuenta  ?>.main.OBJ.nivel;
this.store_lista.baseParams.co_padre= <?php echo $nu_cuenta  ?>.main.OBJ.co_cargo_estructura;
this.store_lista.load();

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        <?php echo $nu_cuenta  ?>.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1100,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.gridPanel_]
});

this.winformPanel_ = new Ext.Window({
    title:'Asignación de Cargos a '+<?php echo $nu_cuenta  ?>.main.OBJ.tx_estructura_administrativa,
    modal:true,
    constrain:true,
    width:1100,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formPanel_
    ],
    buttons:[
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
//CuentaBancariaLista.main.mascara.hide();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/storelistaCargos',
    root:'data',
    fields:[
            {name: 'co_estructura_administrativa'},
            {name: 'co_cargo_estructura'},
            {name: 'tx_cargo'},
            {name: 'nivel'},
            {name: 'cant'}
           ]
    });
    return this.store;
}
};
Ext.onReady(<?php echo $nu_cuenta  ?>.main.init, <?php echo $nu_cuenta  ?>.main);
</script>
<div id="formulario_<?php echo $nu_cuenta  ?>"></div>