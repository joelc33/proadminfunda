<script type="text/javascript">
Ext.ns("BienesDesincorporacion");
BienesDesincorporacion.main = {
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
    this.co_reporte = new Ext.form.Hidden({
    name:'co_reporte',
    value:this.OBJ.co_reporte});
//</ClavePrimaria>

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
    width:340,
    resizable:true,
    allowBlank:true,
    onSelect: function(record){
        BienesDesincorporacion.main.list_documento.setValue(record.data.co_documento);
            if( BienesDesincorporacion.main.co_tipo_movimiento.getValue() && BienesDesincorporacion.main.co_tipo_movimiento.getValue()!=''){
                BienesDesincorporacion.main.agregar.enable();
                     }else{
                        BienesDesincorporacion.main.agregar.disable();
                     }
                     
           
            this.collapse();
  }});
this.storeCO_DOCUMENTO.load({  params:{
        co_tipo_documento: 3
            }});


this.co_tipo_movimiento = new Ext.form.ComboBox({
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
            BienesDesincorporacion.main.co_tipo_movimiento.setValue(record.data.co_subtipo_movimiento_bienes);
            if( BienesDesincorporacion.main.list_documento.getValue() && BienesDesincorporacion.main.list_documento.getValue()!=''){
                BienesDesincorporacion.main.agregar.enable();
                     }else{
                        BienesDesincorporacion.main.agregar.disable();
                     }

           
            this.collapse();
  }
});
this.storeCO_TIPO_MOVIMIENTO.load({  params:{
        co_tipo_movimiento: 3
            }});

this.agregar = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {
        if(BienesDesincorporacion.main.list_documento.getValue()==null || BienesDesincorporacion.main.list_documento.getValue()==''){
            Ext.Msg.alert("Alerta","Debe ingresar el Tipo de Documento");
            return false;
           }
           if(BienesDesincorporacion.main.co_tipo_movimiento.getValue()==null || BienesDesincorporacion.main.co_tipo_movimiento.getValue()==''){
            Ext.Msg.alert("Alerta","Debe ingresar el Tipo de Traslado");
            return false;
           }
           this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/agregarBienesDesin',
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
                    BienesDesincorporacion.main.eliminar();
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
        height:350,  
        width:980,
        tbar:[
        this.agregar,'-',this.botonEliminar],
        columns: [
        new Ext.grid.RowNumberer(),
        {header: 'co_bienes', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_bienes'},
            {header: 'co_movimiento_bienes', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_movimiento_bienes'},
            {header: 'co_documento_bienes', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_documento_bienes'},
             {header: 'co_usuario', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_usuario'},
              {header: 'co_fisico', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_fisico'},
             {header: 'co_ejecutor', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_ejecutor'},
             {header: 'Numero',width:80, menuDisabled:true,sortable: true, dataIndex: 'nu_bienes'},
            {header: 'Serial',width:80, menuDisabled:true,sortable: true, dataIndex: 'tx_serial'},   
            {header: 'Descripción',width:200, menuDisabled:true,sortable: true, dataIndex: 'tx_detalle'},
            {header: 'Marca',width:100, menuDisabled:true,sortable: true, dataIndex: 'tx_marca'},
            {header: 'Modelo',width:100, menuDisabled:true,sortable: true, dataIndex: 'tx_modelo'},
            {header: 'Ubicacion',width:300, menuDisabled:true,sortable: true, dataIndex: 'tx_organigrama'},
            {header: 'Ubicacion Actual',width:300, menuDisabled:true,sortable: true, dataIndex: 'ubicacion_ant'},
            {header: 'Documento',width:100, menuDisabled:true,sortable: true, dataIndex: 'tx_documento'},
            {header: 'Tipo Desincorporación',width:200, menuDisabled:true,sortable: true, dataIndex: 'tx_subtipo_movimiento'},
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
            BienesDesincorporacion.main.botonEliminar.enable();
        }}   
});
 this.store_lista.load();
if(this.store_lista!=''){
//if(this.OBJ.co_bienes!=''){
    BienesDesincorporacion.main.store_lista.baseParams.co_solicitud=this.OBJ.co_solicitud;
    this.store_lista.load({
        callback: function(){
            BienesDesincorporacion.main.cant_total = BienesDesincorporacion.main.store_lista.getCount();
            BienesDesincorporacion.main.cantidad_total.setValue("<span style='font-size:12px;'><b>Cantidad Total: </b>"+parseInt(BienesDesincorporacion.main.cant_total)+"</b></span>");     
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
    width:1000,
    items:[{layout:'column',
          defaults:{layout:'form',columnWidth:.5},
                    items:[{items:[this.co_tipo_movimiento]},{items:[this.list_documento]}]}]
                   });




this.fieldDatosBienes= new Ext.form.FieldSet({
     title: 'Carga de Datos del Destino Final',
    items:[this.fieldDatosUnidad]

});

                        

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(BienesDesincorporacion.main.gridPanel.getStore().getCount()<=0){
            Ext.Msg.alert("Alerta","Debe ingresar algun bien");
            return false;
        }
        
        var list_bienes = paqueteComunJS.funcion.getJsonByObjStore({
                store:BienesDesincorporacion.main.gridPanel.getStore()
        });
        
        BienesDesincorporacion.main.hiddenJsonBienes.setValue(list_bienes);        

      BienesDesincorporacion.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/guardarDesincorporacion',
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
                
                 BienesDesincorporacion.main.winformPanel_.close();
             }
        });
   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        BienesDesincorporacion.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1014,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[         this.co_ente,
                    this.co_solicitud,
                    this.co_reporte,
                    this.co_usuario,
                    this.hiddenJsonBienes,
                    this.co_bienes,
                    this.fieldDatos,
                    this.fieldDatosBienes,
                    this.gridPanel
            ]
});


this.winformPanel_ = new Ext.Window({
    title:'Desincorporar Bienes',
    modal:true,
    constrain:true,
    width:1028,
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
        var s = BienesDesincorporacion.main.gridPanel.getSelectionModel().getSelections();
        
        var co_bienes = BienesDesincorporacion.main.gridPanel.getSelectionModel().getSelected().get('co_bienes');
       var co_movimiento_bienes = BienesDesincorporacion.main.gridPanel.getSelectionModel().getSelected().get('co_movimiento_bienes');
       var co_documento_bienes = BienesDesincorporacion.main.gridPanel.getSelectionModel().getSelected().get('co_documento_bienes');
        if(co_bienes!=''){
          
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/eliminarDesincorporacion',
            params:{
                co_bienes: co_bienes,
                co_movimiento_bienes: co_movimiento_bienes,
                co_solicitud: BienesDesincorporacion.main.OBJ.co_solicitud,
                co_documento_bienes: co_documento_bienes
                
            },
            success:function(result, request ) {
                BienesDesincorporacion.main.store_lista.load();
                obj = Ext.util.JSON.decode(result.responseText);
              if(obj.success==true){
                Ext.utiles.msg('Mensaje', "El bien se reestablecio sastifactoriamente");   
               }else{
                Ext.utiles.msg('Mensaje', obj.msg); 
               }            
            }});
           BienesDesincorporacion.main.cantidad_total.setValue("<span style='font-size:12px;'><b>Cantidad Total: </b>"+parseInt(BienesDesincorporacion.main.store_lista.getCount())+"</b></span>");   
        }
       
        for(var i = 0, r; r = s[i]; i++){
              BienesDesincorporacion.main.store_lista.remove(r);
        }
},getLista: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storelistabienesdesincorporacion',
    root:'data',
    params:{
        co_solicitud: BienesDesincorporacion.main.OBJ.co_solicitud
            },
    fields:[         
            {name: 'co_movimiento_bienes'},
            {name: 'co_usuario'},
            {name: 'co_bienes'},
            {name: 'nu_bienes'},
            {name: 'tx_serial'},
            {name: 'tx_marca'},
            {name: 'tx_modelo'},
            {name: 'tx_detalle'},
            {name: 'tx_organigrama'},
             {name: 'co_organigrama'},
            {name: 'co_ubicacion'},
            {name: 'ubicacion_ant'},
            {name: 'co_documento_bienes'},
            {name: 'tx_documento'},
            {name: 'tx_subtipo_movimiento'},

                
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
Ext.onReady(BienesDesincorporacion.main.init, BienesDesincorporacion.main);
</script>
<div id="formularioAgregar"></div>