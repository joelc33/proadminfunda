<script type="text/javascript">
Ext.ns("<?php echo $nu_cuenta  ?>");
<?php echo $nu_cuenta  ?>.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Crear Cuenta',
    iconCls: 'icon-nuevo',
    handler:function(){
        this.msg = Ext.get("formulario_<?php echo $nu_cuenta  ?>");
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaContable/editar',
         scripts: true,
         text: "Cargando..",
         params:{
             tx_prefijo: <?php echo $nu_cuenta  ?>.main.OBJ.nu_cuenta_contable,
             nivel: <?php echo $nu_cuenta  ?>.main.OBJ.nivel,
             paquete:'<?php echo $nu_cuenta  ?>',
             tx_cuenta: <?php echo $nu_cuenta  ?>.main.OBJ.tx_cuenta
         }
        });
    }
});

this.secundaria = new Ext.Button({
    text:'Ver Cuentas Asociadas',
    iconCls: 'icon-nuevo',
    disabled:true,
    handler:function(){
        this.msg = Ext.get("formulario_<?php echo $nu_cuenta  ?>");
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaContable/verCuenta',
         scripts: true,
         text: "Cargando..",
         params:{
             nu_cuenta_contable:<?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('tx_cuenta'),
             nivel: <?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('nu_nivel'),
             co_cuenta_contable: <?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('co_cuenta_contable'),
             tx_cuenta:<?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('tx_cuenta')
         }
        });
    }
});

this.asignar_cuenta_bancaria = new Ext.Button({
    text: 'Asignar Cuenta Bancaria',
    iconCls: 'icon-fin',
    disabled:true,
    handler: function () {  
    
        var tx_cuenta = <?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('tx_cuenta');         
    
	Ext.MessageBox.confirm('Confirmación', '¿Esta seguro que desea asignar a la cuenta contable <b>'+tx_cuenta+'</b>, la cuenta <b>'+CuentaContable.main.OBJ.tx_tipo_cuenta+'</b> Nro. <b>'+CuentaContable.main.OBJ.tx_cuenta_bancaria+'</b> del Banco <b>'+CuentaContable.main.OBJ.tx_banco+'</b> ?', function(boton){
	if(boton=="yes"){
            
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaContable/asignar',
            params:{
                co_cuenta_contable:<?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('co_cuenta_contable'),
                co_cuenta_bancaria: CuentaContable.main.OBJ.co_cuenta_bancaria,
                co_solicitud: CuentaContable.main.OBJ.co_solicitud
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    
                    <?php echo $nu_cuenta  ?>.main.store_lista.baseParams.tx_cuenta= <?php echo $nu_cuenta  ?>.main.OBJ.tx_cuenta;
                    <?php echo $nu_cuenta  ?>.main.store_lista.baseParams.nu_nivel= <?php echo $nu_cuenta  ?>.main.OBJ.nivel;
                    <?php echo $nu_cuenta  ?>.main.store_lista.load();
                        
                    <?php echo $nu_cuenta  ?>.main.secundaria.disable();  
                    <?php echo $nu_cuenta  ?>.main.asignar_cuenta_bancaria.disable();   
                        
                    Detalle.main.store_lista.baseParams.co_solicitud = Detalle.main.OBJ.co_solicitud;
                    Detalle.main.store_lista.load();
                    
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                BancoLista.main.mascara.hide();
            }});
            
	}});
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
    title:'Lista de Planes de Cuenta',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:420,
    tbar:[
        this.nuevo,'-',this.secundaria,'-',this.asignar_cuenta_bancaria
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_cuenta_contable',hidden:true, menuDisabled:true,dataIndex: 'co_cuenta_contable'},
    {header: 'Cuenta', width:250,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cuenta',renderer:renderInDisponible},
    {header: 'Denominación', width:500,  menuDisabled:true, sortable: true,  dataIndex: 'tx_descripcion',renderer:textoLargo},
    {header: 'Nivel', width:60,  menuDisabled:true, sortable: true,  dataIndex: 'nu_nivel'},
    {header: 'Tipo', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        
        var tipo = <?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('tx_tipo');
        var cant = <?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('cant');

        <?php echo $nu_cuenta  ?>.main.secundaria.enable();  
                        
        if(tipo=='S'){                
            <?php echo $nu_cuenta  ?>.main.asignar_cuenta_bancaria.enable();  
        }
        
        if(cant>0){                
            <?php echo $nu_cuenta  ?>.main.asignar_cuenta_bancaria.disable();  
        }
        

    },
    celldblclick:function(Grid, rowIndex, columnIndex,e ){
        this.msg = Ext.get("formulario_<?php echo $nu_cuenta  ?>");
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaContable/verCuenta',
         scripts: true,
         text: "Cargando..",
         params:{
             nu_cuenta_contable:<?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('tx_cuenta'),
             nivel: <?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('nu_nivel'),
             co_cuenta_contable: <?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('co_cuenta_contable'),
             tx_cuenta:<?php echo $nu_cuenta  ?>.main.gridPanel_.getSelectionModel().getSelected().get('tx_cuenta')
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

this.store_lista.baseParams.tx_cuenta= <?php echo $nu_cuenta  ?>.main.OBJ.tx_cuenta;
this.store_lista.baseParams.nu_nivel= <?php echo $nu_cuenta  ?>.main.OBJ.nivel;
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
    title:'Asignación de Cuenta Bancaria',
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
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CuentaContable/storelistacuenta',
    root:'data',
    fields:[
            {name: 'co_cuenta_contable'},
            {name: 'tx_cuenta'},
            {name: 'tx_descripcion'},
            {name: 'nu_nivel'},
            {name: 'tx_tipo'},
            {name: 'nu_cuenta_contable'},
            {name: 'cant'}
           ]
    });
    return this.store;
}
};
Ext.onReady(<?php echo $nu_cuenta  ?>.main.init, <?php echo $nu_cuenta  ?>.main);
</script>
<div id="formulario_<?php echo $nu_cuenta  ?>"></div>