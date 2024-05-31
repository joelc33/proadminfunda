<script type="text/javascript">
Ext.ns("RequisicionEditar");
RequisicionEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_TIPO_SOLICITUD = this.getStoreCO_TIPO_SOLICITUD();


this.cant_total='';
 
//<ClavePrimaria>
this.co_requisicion = new Ext.form.Hidden({
    name:'co_requisicion',
    value:this.OBJ.co_requisicion});

this.co_ente = new Ext.form.Hidden({
    name:'tb039_requisiciones[co_ente]',
    value:this.OBJ.co_ente});

this.co_tipo_solicitud = new Ext.form.Hidden({
    name:'tb039_requisiciones[co_tipo_solicitud]',
    value:this.OBJ.co_tipo_solicitud});

this.co_solicitud = new Ext.form.Hidden({
    name:'tb039_requisiciones[co_solicitud]',
    value:this.OBJ.co_solicitud});

this.fe_registro = new Ext.form.Hidden({
    name:'tb039_requisiciones[fe_registro]',
    value:this.OBJ.fe_registro
});
//</ClavePrimaria>

this.store_lista   = this.getLista();

this.Registro = Ext.data.Record.create([
                     {name: 'co_detalle_requisicion', type:'number'},
                     {name: 'co_producto', type:'number'},
                     {name: 'cod_producto', type: 'string'},
                     {name: 'tx_producto', type: 'string'},
                     {name: 'nu_cantidad', type:'number'},
                     {name: 'tx_observacion', type: 'string'},
                     {name: 'tx_unidad_producto', type: 'string'},
                     {name: 'co_unidad_producto', type: 'number'}
                ]);

this.hiddenJsonProducto  = new Ext.form.Hidden({
        name:'json_producto',
        value:''
});


this.agregar = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/agregarProducto',
            scripts: true,
            text: "Cargando.."
        });
    }
});

this.botonEliminar = new Ext.Button({
                text:'Eliminar',
                iconCls: 'icon-eliminar',
                id:'eliminar',
                handler: function(boton){
                    RequisicionEditar.main.eliminar();
                }
});

this.botonEliminar.disable();

this.cantidad_total = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Cantidad Total: </b>0</b></span>"
});

this.gridPanel = new Ext.grid.GridPanel({
        title:'Lista de Materiales / Bienes / Servicios',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:200,  
        width:810,
        tbar:[this.agregar,'-',this.botonEliminar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_detalle_requisicion', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_detalle_requisicion'},    
            {header: 'co_producto', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_producto'},                
            {header: 'Codigo', width:80, menuDisabled:true,dataIndex: 'cod_producto'},
            {header: 'Descripción',width:520, menuDisabled:true,dataIndex: 'tx_producto'},
            {header: 'Unidad',width:80, menuDisabled:true,dataIndex: 'tx_unidad_producto'},
            {header: 'Cantidad',width:80, menuDisabled:true,dataIndex: 'nu_cantidad'}
        ],
        bbar: new Ext.ux.StatusBar({
            id: 'basic-statusbar',
            autoScroll:true,
            defaults:{style:'color:black;font-size:30px;',autoWidth:true},
            items:[
             this.cantidad_total
            ]
        }),
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
            RequisicionEditar.main.botonEliminar.enable();
        }}   
});

if(this.OBJ.co_requisicion!=''){

    RequisicionEditar.main.store_lista.baseParams.co_requisicion=this.OBJ.co_requisicion;
    this.store_lista.load({
        callback: function(){
            RequisicionEditar.main.cant_total = paqueteComunJS.funcion.getSumaColumnaGrid({
                 store:RequisicionEditar.main.store_lista,
                 campo:'nu_cantidad'
            });
            
            RequisicionEditar.main.cantidad_total.setValue("<span style='font-size:12px;'><b>Cantidad Total: </b>"+parseInt(RequisicionEditar.main.cant_total)+"</b></span>");     
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

this.tx_concepto = new Ext.form.TextField({
	fieldLabel:'Concepto',
	name:'tb039_requisiciones[tx_concepto]',
	value:this.OBJ.tx_concepto,
	allowBlank:false,
	width:680
});

this.nu_requisicion = new Ext.form.NumberField({
    fieldLabel:'Nro Requisición',
    name:'tb039_requisiciones[nu_requisicion]',
    value:this.OBJ.nu_requisicion,
    allowBlank:false,
    width:100
});

this.tx_observacion = new Ext.form.TextArea({
	fieldLabel:'Observaciones',
	name:'tb039_requisiciones[tx_observacion]',
	value:this.OBJ.tx_observacion,
	width:680
});

this.fieldDatosRequisicion= new Ext.form.FieldSet({
    items:[this.tx_concepto,
           this.tx_observacion]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!RequisicionEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        
        var list_producto = paqueteComunJS.funcion.getJsonByObjStore({
                store:RequisicionEditar.main.gridPanel.getStore()
        });
        
        RequisicionEditar.main.hiddenJsonProducto.setValue(list_producto);        
        
        RequisicionEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/guardar',
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
                
                 RequisicionEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        RequisicionEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:850,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[         this.co_ente,
                    this.co_solicitud,
                    this.fe_registro,
                    this.co_tipo_solicitud,
                    this.hiddenJsonProducto,
                    this.co_requisicion,
                    this.fieldDatos,
                    this.fieldDatosRequisicion,
                    this.gridPanel
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Requisicion',
    modal:true,
    constrain:true,
    width:850,
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
        var s = RequisicionEditar.main.gridPanel.getSelectionModel().getSelections();
        
        var co_detalle_requisicion = RequisicionEditar.main.gridPanel.getSelectionModel().getSelected().get('co_detalle_requisicion');
       
        if(co_detalle_requisicion!=''){
          
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/eliminarMaterial',
            params:{
                co_detalle_requisicion: co_detalle_requisicion,
                co_solicitud: RequisicionEditar.main.OBJ.co_solicitud
            },
            success:function(result, request ) {
               //RequisicionEditar.main.store_lista.load();
                Ext.utiles.msg('Mensaje', "El producto se eliminó exitosamente");               
            }});
            
        }
       
        for(var i = 0, r; r = s[i]; i++){
              RequisicionEditar.main.store_lista.remove(r);
        }
},getLista: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/storelistamateriales',
    root:'data',
    fields:[
                {name: 'co_detalle_requisicion'},
                {name: 'co_producto'},
                {name: 'cod_producto'},
                {name: 'tx_producto',
                    convert:function(v,r){
                    return r.tx_producto+' - '+r.tx_observacion;
                    }
                },
                {name: 'nu_cantidad'},
                {name: 'co_requisicion'},
                {name: 'co_unidad_producto'},
                {name: 'tx_unidad_producto'}
                
           ]
    });
    return this.store;      
}
,getStoreCO_TIPO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Requisicion/storefkcotiposolicitud',
        root:'data',
        fields:[
            {name: 'cod_tipo_solicitud'},
            {name: 'co_tipo_solicitud'},
            {name: 'tx_tipo_solicitud'}
            ]
    });
    return this.store;
}
};
Ext.onReady(RequisicionEditar.main.init, RequisicionEditar.main);
</script>
<div id="formularioAgregar"></div>