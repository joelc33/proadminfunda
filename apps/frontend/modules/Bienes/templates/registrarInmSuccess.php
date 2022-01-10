<script type="text/javascript">
Ext.ns("InmRegistro");
InmRegistro.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>

this.storeCO_TIPO_MOVIMIENTO= this.getStoreCO_TIPO_MOVIMIENTO();
this.storeCO_DOCUMENTO= this.getStoreCO_DOCUMENTO();


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
//</ClavePrimaria>

this.co_reporte = new Ext.form.Hidden({
    name:'co_reporte',
    value:this.OBJ.co_reporte});
    
this.store_lista   = this.getLista();

this.Registro = Ext.data.Record.create([
            {name: 'co_movimiento_bienes'},
            {name: 'co_usuario'},
            {name: 'co_bienes'},
            {name: 'nu_bienes'},
            {name: 'tx_serial'},
            {name: 'tx_marca'},
            {name: 'tx_modelo'},
            {name: 'tx_ente'},
            {name: 'de_ejecutor'},
            {name: 'tx_detalle'},
            {name: 'n_ejecutor'},
            {name: 'n_fisico'},
            {name: 'co_ejecutor'},
            {name: 'co_fisico'},
             {name: 'tx_motivo_desincorporacion'},
            {name: 'tx_tipo_desincorporacion'}
                ]);

this.hiddenJsonBienes  = new Ext.form.Hidden({
        name:'json_bienes',
        value:''
});
this.list_documento = new Ext.form.ComboBox({
    fieldLabel:'Tipo Documento',
    store: this.storeCO_DOCUMENTO,
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
    width:350,
    resizable:true,
    allowBlank:true,
    onSelect: function(record){
        InmRegistro.main.list_documento.setValue(record.data.co_documento);
            if( InmRegistro.main.list_documento.getValue() && InmRegistro.main.list_documento.getValue()!=''){
                InmRegistro.main.agregar.enable();
                     }else{
                        InmRegistro.main.agregar.disable();
                     }
                     
           
            this.collapse();
  }});
this.storeCO_DOCUMENTO.load({  params:{
        co_tipo_documento: 1
            }});


/*this.co_tipo_movimiento = new Ext.form.ComboBox({
    fieldLabel:'Tipo de Traslado',
    store: this.storeCO_TIPO_MOVIMIENTO,
    typeAhead: true,
    valueField: 'co_subtipo_movimiento_bienes',
    displayField:'tx_subtipo_movimiento',
    hiddenName:'tbbn004_subtipo_movimiento[co_subtipo_movimiento_bienes]',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione el tipo de traslado',
    selectOnFocus: true,
    mode: 'local',
    width:350,
    resizable:true,
    allowBlank:true,
          onSelect: function(record){
            InmRegistro.main.co_tipo_movimiento.setValue(record.data.co_subtipo_movimiento_bienes);
            if( InmRegistro.main.list_documento.getValue() && InmRegistro.main.list_documento.getValue()!=''){
                InmRegistro.main.agregar.enable();
                     }else{
                        InmRegistro.main.agregar.disable();
                     }

           
            this.collapse();
  }
});*/
/*this.storeCO_TIPO_MOVIMIENTO.load({  params:{
        co_tipo_movimiento: 3
            }});*/

this.agregar = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {
        if(InmRegistro.main.list_documento.getValue()==null || InmRegistro.main.list_documento.getValue()==''){
            Ext.Msg.alert("Alerta","Debe ingresar el Tipo de Documento");
            return false;
           }
           /*if(InmRegistro.main.co_tipo_movimiento.getValue()==null || InmRegistro.main.co_tipo_movimiento.getValue()==''){
            Ext.Msg.alert("Alerta","Debe ingresar el Tipo de Traslado");
            return false;
           }*/
           this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/agregarInm',
            scripts: true,
            text: "Cargando.."
        });
        
    }
});
this.agregar.disable();

this.botonEliminar = new Ext.Button({
                text:'Eliminar',
                iconCls: 'icon-eliminar',
                id:'eliminar',
                handler: function(boton){
                    InmRegistro.main.eliminar();
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
        height:200,  
        width:1000,
        tbar:[
        this.agregar,'-',this.botonEliminar],
        columns: [
        new Ext.grid.RowNumberer(),
        {header: 'co_bienes', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_bienes'},
        {header: 'co_movimiento_bienes', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_movimiento_bienes'},
            {header: 'co_documento_bienes', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_documento_bienes'},
             {header: 'co_usuario', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_usuario'},
             {header: 'Numero',width:80, menuDisabled:true,sortable: true, dataIndex: 'nu_bienes'},
            {header: 'Denominación',width:200, menuDisabled:true,sortable: true, dataIndex: 'tx_detalle'},
            {header: 'Descripción',width:200, menuDisabled:true,sortable: true, dataIndex: 'desc_inm'},
            {header: 'Documento',width:100, menuDisabled:true,sortable: true, dataIndex: 'tx_documento'},
            {header: 'Dirección',width:200, menuDisabled:true,sortable: true, dataIndex: 'tx_direccion'},
            {header: 'Linderos',width:200, menuDisabled:true,sortable: true, dataIndex: 'tx_lindero_inmueble'},
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
            InmRegistro.main.botonEliminar.enable();
        }}   
});
 this.store_lista.load();
if(this.store_lista!=''){
//if(this.OBJ.co_bienes!=''){
    InmRegistro.main.store_lista.baseParams.co_solicitud=this.OBJ.co_solicitud;
    this.store_lista.load({
        callback: function(){
            InmRegistro.main.cant_total = InmRegistro.main.store_lista.getCount();
            InmRegistro.main.cantidad_total.setValue("<span style='font-size:12px;'><b>Cantidad Total: </b>"+parseInt(InmRegistro.main.cant_total)+"</b></span>");     
        }
    });

}


this.datos  = '<p class="registro_detalle"><b>Solicitante: </b>'+this.OBJ.nb_solicitante+'</p>';
this.datos += '<p class="registro_detalle"><b>Entidad: </b>'+this.OBJ.tx_entidad+'</p>';
this.datos +='<p class="registro_detalle"><b>Fecha: </b>'+this.OBJ.fe_registro+'</p>';

this.fieldDatos= new Ext.form.FieldSet({
        title: 'Datos del Solicitante',
        html: this.datos
});



this.fieldDatosUnidad= new Ext.Panel({
    width:1050,
    items:[{layout:'column',
          defaults:{layout:'form',columnWidth:.5},
                    items:[{items:[this.list_documento]}]}]
                   });




this.fieldDatosBienes= new Ext.form.FieldSet({
     title: 'Carga de Datos',
    items:[this.fieldDatosUnidad]

});

                        

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(InmRegistro.main.gridPanel.getStore().getCount()<=0){
            Ext.Msg.alert("Alerta","Debe ingresar algun bien");
            return false;
        }
        
        var list_bienes = paqueteComunJS.funcion.getJsonByObjStore({
                store:InmRegistro.main.gridPanel.getStore()
        });
        
        InmRegistro.main.hiddenJsonBienes.setValue(list_bienes);        

      InmRegistro.main.formPanel_.getForm().submit({
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
                
                 InmRegistro.main.winformPanel_.close();
             }
        });
   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        InmRegistro.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1050,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[         this.co_ente,
                    this.co_solicitud,
                    this.hiddenJsonBienes,
                    this.co_reporte,
                    this.co_usuario,
                    this.co_bienes,
                    this.fieldDatos,
                    this.fieldDatosBienes,
                    this.gridPanel
            ]
});


this.winformPanel_ = new Ext.Window({
    title:'Registrar Inmuebles',
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
        var s = InmRegistro.main.gridPanel.getSelectionModel().getSelections();
        
        var co_bienes = InmRegistro.main.gridPanel.getSelectionModel().getSelected().get('co_bienes');
       var co_movimiento_bienes = InmRegistro.main.gridPanel.getSelectionModel().getSelected().get('co_movimiento_bienes');
       var co_documento_bienes = InmRegistro.main.gridPanel.getSelectionModel().getSelected().get('co_documento_bienes');
        if(co_bienes!=''){
          
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/eliminar',
            params:{
                co_bienes: co_bienes,
                co_movimiento_bienes: co_movimiento_bienes,
                co_solicitud: InmRegistro.main.OBJ.co_solicitud,
                co_documento_bienes: co_documento_bienes
                
            },
            success:function(result, request ) {
                InmRegistro.main.store_lista.load();
                obj = Ext.util.JSON.decode(result.responseText);
              if(obj.success==true){
                Ext.utiles.msg('Mensaje', "El bien se reestablecio sastifactoriamente");   
               }else{
                Ext.utiles.msg('Mensaje', obj.msg); 
               }            
            }});
           InmRegistro.main.cantidad_total.setValue("<span style='font-size:12px;'><b>Cantidad Total: </b>"+parseInt(InmRegistro.main.store_lista.getCount())+"</b></span>");   
        }
       
        for(var i = 0, r; r = s[i]; i++){
              InmRegistro.main.store_lista.remove(r);
        }
},getLista: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storelistaInmuebles',
    root:'data',
    params:{
        co_solicitud: InmRegistro.main.OBJ.co_solicitud
            },
    fields:[         
            {name: 'co_movimiento_bienes'},
            {name: 'co_usuario'},
            {name: 'co_bienes'},
            {name: 'nu_bienes'},
            {name: 'tx_detalle'},
            {name: 'tx_direccion'},
            {name: 'tx_lindero_inmueble'},
            {name: 'desc_inm'},
            {name: 'co_documento_bienes'},
            {name: 'tx_documento'},

                
           ]
    });
    return this.store;      
},getStoreCO_TIPO_MOVIMIENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefkcotipomovimiento',
        root:'data',
        fields:[
            {name: 'co_subtipo_movimiento_bienes'},
            {name: 'tx_subtipo_movimiento'}
            ]
    });
    return this.store;
},getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefkcodocumento',
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
Ext.onReady(InmRegistro.main.init, InmRegistro.main);
</script>
<div id="formularioAgregar"></div>