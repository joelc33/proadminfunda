<script type="text/javascript">
Ext.ns("BienesRegistrar");
BienesRegistrar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>



this.storeCO_TIPO_INCORPORACION = this.getStoreCO_TIPO_INCORPORACION();
this.storeCO_DOCUMENTO_INCORPORACION = this.getStoreCO_DOCUMENTO_INCORPORACION();

this.cant_total='';
 
//<ClavePrimaria>
this.co_bienes = new Ext.form.Hidden({
    name:'co_bienes',
    value:this.OBJ.co_bienes});
this.co_usuario= new Ext.form.Hidden({
    name:'co_usuario',
    value:this.OBJ.co_usuario});

this.co_ente = new Ext.form.Hidden({
    name:'co_ente',
    value:this.OBJ.co_ente});

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud});

    this.co_reporte = new Ext.form.Hidden({
    name:'co_reporte',
    value:this.OBJ.co_reporte});
//</ClavePrimaria>

this.store_lista   = this.getLista();

this.Registro = Ext.data.Record.create([
                     {name: 'co_usuario', type:'number'},
                     {name: 'co_ejecutor', type:'number'},
                     {name: 'co_bienes', type:'number'},
                     {name: 'co_fisico', type:'number'},                
                     {name: 'nu_bienes', type: 'string'},
                     {name: 'tx_serial', type: 'string'},
                     {name: 'tx_modelo', type: 'string'},
                     {name: 'tx_marca', type: 'string'},
                     {name: 'tx_razon_social', type: 'string'},
                     {name: 'tx_ente', type: 'string'},
                     {name: 'tx_producto', type: 'string'},
                     {name: 'tx_subtipo_movimiento', type: 'string'},
                     {name: 'de_ejecutor', type:'string'},
                     {name: 'tx_detalle', type: 'string'}
                ]);

this.hiddenJsonBienes  = new Ext.form.Hidden({
        name:'json_bienes',
        value:''
});


this.list_documento = new Ext.form.ComboBox({
    fieldLabel:'Documento',
    store: this.storeCO_DOCUMENTO_INCORPORACION,
    typeAhead: true,
    valueField: 'co_documento',
    displayField:'desc_documento',
    hiddenName:'co_documento',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Documento',
    selectOnFocus: true,
    mode: 'local',
    width:400,
    resizable:true,
    allowBlank:true,
    onSelect: function(record){
            BienesRegistrar.main.list_documento.setValue(record.data.co_documento);
            if( BienesRegistrar.main.co_tipo_incorporacion.getValue() && BienesRegistrar.main.co_tipo_incorporacion.getValue()!=''){
                        BienesRegistrar.main.agregar.enable();
                     }else{
                        BienesRegistrar.main.agregar.disable();
                     }
                     
           
            this.collapse();
  }});
this.storeCO_DOCUMENTO_INCORPORACION.load();





this.agregar = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {
           if(BienesRegistrar.main.co_tipo_incorporacion.getRawValue()==''){
            Ext.Msg.alert("Alerta","Debe ingresar el Tipo de Incorporacion");
            return false;
           }


         if(BienesRegistrar.main.co_tipo_incorporacion.getValue()==4){
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/agregarProductoCompra',
            scripts: true,
            text: "Cargando.."
        });
       }else{
           

             this.msg = Ext.get('formularioAgregar');
             this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/agregarNuevoProducto',
            scripts: true,
            text: "Cargando.."
        });
        }
    }
});
this.agregar.disable();

this.botonEliminar = new Ext.Button({
                text:'Eliminar',
                iconCls: 'icon-eliminar',
                id:'eliminar',
                handler: function(boton){
                    BienesRegistrar.main.eliminar();
                }
});

this.botonEliminar.disable();






this.cantidad_total = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Cantidad Total: </b>0</b></span>"
});

this.gridPanel = new Ext.grid.GridPanel({
        title:'Lista de Bienes',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:400,  
        width:1050,
        tbar:[
        this.agregar,'-',this.botonEliminar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_bienes', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_bienes'},
            {header: 'co_documento', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_documento_bienes'},
            {header: 'co_movimiento', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_movimiento_bienes'},
             {header: 'co_usuario', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_usuario'},   
               {header: 'Numero',width:100, menuDisabled:true,sortable: true, dataIndex: 'nu_bienes'},                
            {header: 'Descripción',width:250, menuDisabled:true,sortable: true, dataIndex: 'tx_detalle'},
            {header: 'Marca',width:100, menuDisabled:true,sortable: true, dataIndex: 'tx_marca'},
               {header: 'Modelo',width:100, menuDisabled:true,sortable: true, dataIndex: 'tx_modelo'},  
            {header: 'Producto',width:250, menuDisabled:true,sortable: true, dataIndex: 'tx_producto'},
             {header: 'Precio',width:100, menuDisabled:true,sortable: true, dataIndex: 'nu_monto'},
            {header: 'Tipo Incorporación',width:200, menuDisabled:true,sortable: true, dataIndex: 'tx_subtipo_movimiento'},
            {header: 'Documento',width:100, menuDisabled:true,sortable: true, dataIndex: 'tx_documento'},
            {header: 'Ubicacion',width:300, menuDisabled:true,sortable: true, dataIndex: 'tx_organigrama'},
            {header: 'Proveedor',width:300, menuDisabled:true,sortable: true, dataIndex: 'tx_razon_social'}
        ],
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    }),
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
            BienesRegistrar.main.botonEliminar.enable();
        }}   
});
 this.store_lista.load();
if(this.store_lista!=''){
//if(this.OBJ.co_bienes!=''){
    BienesRegistrar.main.store_lista.baseParams.co_solicitud=this.OBJ.co_solicitud;
    this.store_lista.load({
        callback: function(){
            BienesRegistrar.main.cant_total = BienesRegistrar.main.store_lista.getCount();
            BienesRegistrar.main.cantidad_total.setValue("<span style='font-size:12px;'><b>Cantidad Total: </b>"+parseInt(BienesRegistrar.main.cant_total)+"</b></span>");     
        }
    });

}

this.datos  ='<table class="registro_detalle"><tr><td><b>Solicitante: </b>'+this.OBJ.nb_solicitante+'</td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>';
this.datos  +='<td><b>Entidad: </b>'+this.OBJ.tx_entidad+'</td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>';
this.datos  +='<td><b>Fecha: </b>'+this.OBJ.fe_registro+'</td><td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td></tr>';

/*this.datos  = '<p class="registro_detalle"><b>Solicitante: </b>'+this.OBJ.nb_solicitante+'</p>';
this.datos += '<p class="registro_detalle"><b>Entidad: </b>'+this.OBJ.tx_entidad+'</p>';
this.datos +='<p class="registro_detalle"><b>Fecha: </b>'+this.OBJ.fe_registro+'</p>';*/

this.fieldDatos= new Ext.form.FieldSet({
        title: 'Datos del Solicitante',
        height:60,
        html: this.datos
});

this.co_tipo_incorporacion = new Ext.form.ComboBox({
    fieldLabel:'Tipo de Incorporacion',
    store: this.storeCO_TIPO_INCORPORACION,
    typeAhead: true,
    valueField: 'co_subtipo_movimiento_bienes',
    displayField:'tx_subtipo_movimiento',
    hiddenName:'tbbn004_subtipo_movimiento[co_subtipo_movimiento_bienes]',
    //readOnly:(this.OBJ.co_tipo_cuenta!='')?true:false,
    //style:(this.main.OBJ.co_tipo_cuenta!='')?'background:#c9c9c9;':'',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'...',
    selectOnFocus: true,
    mode: 'local',
    width:400,
    resizable:true,
    allowBlank:true,
          onSelect: function(record){
            BienesRegistrar.main.co_tipo_incorporacion.setValue(record.data.co_subtipo_movimiento_bienes);
            if( BienesRegistrar.main.list_documento.getValue() && BienesRegistrar.main.list_documento.getValue()!=''){
                        BienesRegistrar.main.agregar.enable();
                     }else{
                        BienesRegistrar.main.agregar.disable();
                     }

           
            this.collapse();
  }
});
this.storeCO_TIPO_INCORPORACION.load();


this.fieldDatosTpBien= new Ext.Panel({
    width:1050,
    items:[{layout:'column',
          defaults:{layout:'form',columnWidth:.5},
                    items:[{items:[this.co_tipo_incorporacion]},{items:[this.list_documento]}
                           ]}]
                   });

this.fieldDatosBienes= new Ext.form.FieldSet({
     title: 'Carga de Datos',
    items:[
           this.fieldDatosTpBien]

});

                        

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(BienesRegistrar.main.gridPanel.getStore().getCount()<=0){
            Ext.Msg.alert("Alerta","Debe ingresar algun bien");
            return false;
        }
        
        var list_bienes = paqueteComunJS.funcion.getJsonByObjStore({
                store:BienesRegistrar.main.gridPanel.getStore()
        });
        
        BienesRegistrar.main.hiddenJsonBienes.setValue(list_bienes);        

      BienesRegistrar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/guardar',
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
                
                 BienesRegistrar.main.winformPanel_.close();
             }
        });
   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        BienesRegistrar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1100,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[         this.co_ente,
                    this.co_solicitud,
                    this.co_reporte,
                    this.hiddenJsonBienes,
                    this.co_bienes,
                    this.fieldDatos,      
                    this.fieldDatosBienes,
                    this.gridPanel,
                    this.co_usuario
            ]
});


this.winformPanel_ = new Ext.Window({
    title:'Incorporar Bienes',
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
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
},
eliminar:function(){
        var s = BienesRegistrar.main.gridPanel.getSelectionModel().getSelections();
        
        var co_bienes = BienesRegistrar.main.gridPanel.getSelectionModel().getSelected().get('co_bienes');
        var co_solicitud=BienesRegistrar.main.OBJ.co_solicitud;
        var co_movimiento=BienesRegistrar.main.gridPanel.getSelectionModel().getSelected().get('co_movimiento_bienes');
        var co_documento=BienesRegistrar.main.gridPanel.getSelectionModel().getSelected().get('co_documento_bienes');

        if(co_bienes!=''){
          
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/eliminar',
            params:{
                co_bienes: co_bienes,
                co_solicitud: BienesRegistrar.main.OBJ.co_solicitud,
                co_movimiento: co_movimiento,
                co_documento:co_documento

            },
            success:function(result, request ) {
                BienesRegistrar.main.store_lista.load();
                 obj = Ext.util.JSON.decode(result.responseText);
                   if(obj.success==true){
                Ext.utiles.msg('Mensaje', "El producto se eliminó exitosamente");   
               }else{
                Ext.utiles.msg('Mensaje', obj.msg); 
               }                 
            }});
           BienesRegistrar.main.cantidad_total.setValue("<span style='font-size:12px;'><b>Cantidad Total: </b>"+parseInt(BienesRegistrar.main.store_lista.getCount())+"</b></span>");   
        }
       
        for(var i = 0, r; r = s[i]; i++){
              BienesRegistrar.main.store_lista.remove(r);
        }
},getLista: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storelistabienes',
    root:'data',
    params:{
        co_solicitud: BienesRegistrar.main.OBJ.co_solicitud
            },
    fields:[         
            {name: 'co_bienes'},
            {name: 'co_documento_bienes'},
            {name: 'co_movimiento_bienes'},
            {name: 'co_usuario'},
            {name: 'nu_bienes'},
            {name: 'tx_serial'},
            {name: 'tx_modelo'},
            {name: 'tx_marca'},
            {name: 'tx_razon_social'},
            {name: 'tx_subtipo_movimiento'},
            {name: 'tx_documento'},
            {name: 'tx_organigrama'},
            {name: 'tx_producto'},
            {name: 'nu_monto'},
            {name: 'tx_detalle'}
                
           ]
    });
    return this.store;      
}
,getStoreCO_TIPO_INCORPORACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefkcotipoincorporacion',
        root:'data',
        fields:[
            {name: 'co_subtipo_movimiento_bienes'},
            {name: 'tx_subtipo_movimiento'}
            ]
    });
    return this.store;
},getStoreCO_DOCUMENTO_INCORPORACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefkcodocumentoincorporacion',
        root:'data',
        fields:[
            {name: 'co_documento'},
            {name: 'desc_documento'},
            {name: 'tx_documento'},
            ]
    });
    return this.store;
}
};
Ext.onReady(BienesRegistrar.main.init, BienesRegistrar.main);
</script>
<div id="formularioAgregar"></div>