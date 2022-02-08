<script type="text/javascript">
Ext.ns("ComprobanteAjuste");
ComprobanteAjuste.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.store_lista = this.getLista();

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud
});

this.Registro = Ext.data.Record.create([
         {name: 'id_partida', type: 'number'},
         {name: 'tx_cuenta', type: 'string'},
         {name: 'denominacion', type: 'string'},
         {name: 'fecha', type: 'string'},
         {name: 'monto', type:'number'},
         {name: 'descripcion', type:'string'},
]);

this.hiddenJsonCuenta  = new Ext.form.Hidden({
        name:'json_cuenta',
        value:''
});


this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ComprobanteAjuste.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        
        if(ComprobanteAjuste.main.store_lista.getCount()==0){
        Ext.Msg.alert("Alerta","Debe ingresar al menos una partida");
        return false;
        }   
                 
        
        var list_partida = paqueteComunJS.funcion.getJsonByObjStore({
                store:ComprobanteAjuste.main.gridPanel.getStore()
        });
        
        ComprobanteAjuste.main.hiddenJsonCuenta.setValue(list_partida);
        
        ComprobanteAjuste.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/guardarReintegro',
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
                
                ComprobanteAjuste.main.winformPanel_.close();
                
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ComprobanteAjuste.main.winformPanel_.close();
    }
});

function renderMonto(val, attr, record) {
     return paqueteComunJS.funcion.getNumeroFormateado(val);
}

this.agregar_ajuste = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {
        this.msg = Ext.get('formulario');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/agregarReintegro',
            scripts: true,
            text: "Cargando..",
            params:{
                co_solicitud: ComprobanteAjuste.main.co_solicitud.getValue(),
            }
        });
    }
});

this.botonEliminar = new Ext.Button({
    text:'Eliminar',
    iconCls: 'icon-eliminar',
    id:'eliminar',
    handler: function(boton){
        ComprobanteAjuste.main.eliminar();
    }
});

this.botonEliminar.disable();

this.gridPanel = new Ext.grid.GridPanel({
        title:'Lista de Partidas',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:500,
        width:950,
        tbar:[this.agregar_ajuste,'-',this.botonEliminar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_reintegro_presupuesto', hidden: true, width:320, menuDisabled:true,dataIndex: 'co_reintegro_presupuesto'},
            {header: 'id_partida', hidden: true, width:320, menuDisabled:true,dataIndex: 'id_partida'},
            {header: 'Partida', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cuenta'},
            {header: 'Descripcion Partida',width:460, menuDisabled:true,dataIndex: 'denominacion',renderer:textoLargo},
            {header: 'Monto',width:150, menuDisabled:true,dataIndex: 'monto',renderer:renderMonto},
            {header: 'Fecha',width:90, menuDisabled:true,dataIndex: 'fecha'},
            {header: 'Descripcion',width:260, menuDisabled:true,dataIndex: 'descripcion',renderer:textoLargo}
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
                ComprobanteAjuste.main.botonEliminar.enable();
       }
        }
});

this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
this.store_lista.load();

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1000,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.co_solicitud,
           this.hiddenJsonCuenta,
           this.gridPanel]
});

this.winformPanel_ = new Ext.Window({
    title:'Reintegro Presupuestario',
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
},getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ComprobanteAjuste/storelistaComprobanteAjusteContable',
    root:'data',
    fields:[ 
                {name: 'co_ajuste_contable'},
                {name: 'co_cuenta_contable'},
                {name: 'tx_cuenta'},
                {name: 'denominacion'},
                {name: 'tx_tipo_asiento'},
                {name: 'mo_debito'},
                {name: 'mo_credito'},
                {name: 'descripcion'},
                {name: 'fecha'}
           ]
    });
    return this.store;
},
eliminar:function(){
        var s = ComprobanteAjuste.main.gridPanel.getSelectionModel().getSelections();
        
        var co_ajuste_contable = ComprobanteAjuste.main.gridPanel.getSelectionModel().getSelected().get('co_ajuste_contable');
       
        if(co_ajuste_contable!=''){
          
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ComprobanteAjuste/eliminarCuenta',
            params:{
                co_ajuste_contable: co_ajuste_contable
            },
            success:function(result, request ) {
                Ext.utiles.msg('Mensaje', "La Cuenta se eliminó exitosamente");               
            }});
            
        }
       
        for(var i = 0, r; r = s[i]; i++){
              ComprobanteAjuste.main.store_lista.remove(r);
        }
}
};
Ext.onReady(ComprobanteAjuste.main.init, ComprobanteAjuste.main);
</script>
<div id="formulario"></div>