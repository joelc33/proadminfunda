<script type="text/javascript">
Ext.ns("ViaticoEditar");
ViaticoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.storeCO_PARTIDA= this.getStoreCO_PARTIDA();
this.fila;
this.total_pagar;

this.co_compra = new Ext.form.Hidden({
    name:'co_compra',
    value:this.OBJ.co_compra
});

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud
});

this.mo_total = new Ext.form.Hidden({
    name:'mo_total',
    value:this.OBJ.mo_total
});
//</ClavePrimaria>


//<ClavePrimaria>
this.co_persona = new Ext.form.Hidden({
    name:'co_persona',
    value:this.OBJ.co_persona});
//</ClavePrimaria>

this.store_lista = this.getLista();


this.Registro = Ext.data.Record.create([
         {name: 'co_detalle_viatico',type: 'number'},
         {name: 'co_item_viatico', type: 'number'},
         {name: 'tx_item_viatico', type: 'string'},
         {name: 'tx_observacion', type:'string'},
         {name: 'mo_dia',type: 'number'},
         {name: 'cant_dia',type: 'number'},
         {name: 'mo_total',type: 'number'}
]);

this.hiddenJsonDetalle  = new Ext.form.Hidden({
        name:'json_detalle',
        value:''
});


this.datos  = '<p class="registro_detalle"><b>Cédula: </b>'+this.OBJ.nu_cedula+'</p>';
this.datos += '<p class="registro_detalle"><b>Nombre y Apellido: </b>'+this.OBJ.nb_persona+'</p>';
this.datos +='<p class="registro_detalle"><b>Cargo: </b>'+this.OBJ.tx_cargo+'</p>';
this.datos +='<p class="registro_detalle"><b>Teléfono: </b>'+this.OBJ.nu_celular+'</p>';

this.co_partida = new Ext.form.ComboBox({
	fieldLabel:'Partida',
	store: this.storeCO_PARTIDA,
	typeAhead: true,
	valueField: 'id',
	displayField:'de_partida',
	hiddenName:'co_partida',
	forceSelection:true,
	resizable:true,
        forceAll:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:800,
	allowBlank:false
});

this.storeCO_PARTIDA.load({
    callback: function(){
        ViaticoEditar.main.co_partida.setValue(ViaticoEditar.main.OBJ.co_partida);
    }
});


this.fieldDatosSolicitante= new Ext.form.FieldSet({
        title: 'Datos del Solicitante',
        width:970,
        html:this.datos        
});


this.datosSolicitud  = '<p class="registro_detalle"><b>Tipo de Viatico: </b>'+this.OBJ.tx_tipo_viatico+'</p>';
this.datosSolicitud += '<p class="registro_detalle"><b>Motivo: </b>'+this.OBJ.tx_evento+'</p>';
this.datosSolicitud +='<p class="registro_detalle"><b>Dirección: </b>'+this.OBJ.tx_direccion+'</p>';
this.datosSolicitud +='<p class="registro_detalle"><b>Salida: &nbsp;&nbsp;&nbsp;&nbsp;</b>'+this.OBJ.fe_desde+'<b> &nbsp;&nbsp;&nbsp;&nbsp;Origen: </b>'+this.OBJ.tx_origen+'</p>';
this.datosSolicitud +='<p class="registro_detalle"><b>Retorno: </b>'+this.OBJ.fe_hasta+'<b> &nbsp;&nbsp;&nbsp;&nbsp;Destino: </b>'+this.OBJ.tx_destino+'</p>';

this.fieldDatosSolicitud= new Ext.form.FieldSet({
        title: 'Datos de la Solicitud',
        width:970,
        html:this.datosSolicitud
});

this.fieldDatosPartida = new Ext.form.FieldSet({
        title: 'Partida presupuestaria a comprometer',
        width:970,
        items:[this.co_partida]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!ViaticoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        
        var list = paqueteComunJS.funcion.getJsonByObjStore({
                store:ViaticoEditar.main.gridPanel.getStore()
        });
        
        ViaticoEditar.main.hiddenJsonDetalle.setValue(list);
        ViaticoEditar.main.mo_total.setValue(ViaticoEditar.main.total_pagar);
        
        ViaticoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/guardarViatico',
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
              //   ViaticoLista.main.store_lista.load();
                 ViaticoEditar.main.winformPanel_.close();
             }
        });

   
    }
});




this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ViaticoEditar.main.winformPanel_.close();
    }
});

this.agregar = new Ext.Button({
    text: 'Agregar Monto',
    iconCls: 'icon-nuevo',
    handler: function () {
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/agregar',
            scripts: true,
            text: "Cargando.."
        });
    }
});

this.botonEliminar = new Ext.Button({
                text:'Eliminar',
                iconCls: 'icon-eliminar',
                handler: function(){
                    ViaticoEditar.main.eliminar();
                }
});

this.botonEliminar.disable();

this.monto_total = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Monto Total: </b>0,00</b></span>"
});

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

this.gridPanel = new Ext.grid.GridPanel({
        title:'Detalle del Viatico (Doble click para modificar el monto por día)',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:200,  
        width:970,
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_detalle_viatico', hidden: true,width:80, menuDisabled:true, dataIndex:'co_detalle_viatico'},
            {header: 'co_item_viatico', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_item_viatico'},    
            {header: 'Descripción',width:300, menuDisabled:true,dataIndex: 'tx_item_viatico',renderer:textoLargo},                
            {header: 'Observación', width:300, menuDisabled:true,dataIndex: 'tx_observacion',renderer:textoLargo},
//            {header: 'Monto por Día', width:180, sortable: true,  menuDisabled:true,dataIndex: 'mo_dia',renderer:renderMonto,
//             editor: new Ext.form.TextField({
//		allowBlank: false,
//		autoCreate: {tag: "input", type: "text", autocomplete: "off", maxlength: 200},
//            })},
            {header: 'Cant. UT', width:70, menuDisabled:true,dataIndex: 'cant_ut'},
            {header: 'Cant. Días', width:70, menuDisabled:true,dataIndex: 'cant_dia'},
            {header: 'Monto Total', width:180, menuDisabled:true,dataIndex: 'mo_total',renderer: renderMonto}
        ],
        bbar: new Ext.ux.StatusBar({
            id: 'basic-statusbar',
            autoScroll:true,
            defaults:{style:'color:black;font-size:30px;',autoWidth:true},
            items:[
             this.monto_total
            ]
        }),         
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){           
             ViaticoEditar.main.botonEliminar.enable();
             ViaticoEditar.main.fila = rowIndex;
        }}   
});
//this.gridPanel.on('afteredit', this.afterEdit, this );

this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
this.store_lista.load({
    callback: function(){
        ViaticoEditar.main.total_pagar = paqueteComunJS.funcion.getSumaColumnaGrid({
                     store:ViaticoEditar.main.store_lista,
                     campo:'mo_total'
        });

        ViaticoEditar.main.monto_total.setValue("<span style='font-size:12px;'><b>Total a Pagar: </b>"+paqueteComunJS.funcion.getNumeroFormateado(ViaticoEditar.main.total_pagar)+"</b></span>");     

    }
});

this.formPanel_ = new Ext.form.FormPanel({
    width:1000,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
                    this.co_compra,
                    this.co_solicitud,
                    this.mo_total,
                    this.hiddenJsonDetalle,
                    this.fieldDatosSolicitante,
                    this.fieldDatosSolicitud,
                    this.fieldDatosPartida,
                    this.gridPanel
          ]
});





this.winformPanel_ = new Ext.Window({
    title:'Compra Viaticos',
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
},
afterEdit : function(e){

       var row = ViaticoEditar.main.fila;
       
       var monto_dia = ViaticoEditar.main.store_lista.getAt(row).get('mo_dia');
       var cant_dia = ViaticoEditar.main.store_lista.getAt(row).get('cant_dia');
   
       var monto_total = monto_dia*cant_dia;
       
       var e = new ViaticoEditar.main.Registro({                     
                    co_detalle_viatico:ViaticoEditar.main.store_lista.getAt(row).get('co_detalle_viatico'),
                    co_item_viatico: ViaticoEditar.main.store_lista.getAt(row).get('co_item_viatico'),
                    tx_item_viatico:ViaticoEditar.main.store_lista.getAt(row).get('tx_item_viatico'),
                    tx_observacion:ViaticoEditar.main.store_lista.getAt(row).get('tx_observacion'),
                    mo_dia: ViaticoEditar.main.store_lista.getAt(row).get('mo_dia'),
                    cant_dia:ViaticoEditar.main.store_lista.getAt(row).get('cant_dia'),
                    mo_total:monto_total 
                    
       });
       
       var r = ViaticoEditar.main.store_lista.getAt(row);
       ViaticoEditar.main.store_lista.remove(r);       
     
       ViaticoEditar.main.store_lista.insert(row, e);
       ViaticoEditar.main.gridPanel.getView().refresh();
       
       ViaticoEditar.main.total_pagar = paqueteComunJS.funcion.getSumaColumnaGrid({
                     store:ViaticoEditar.main.store_lista,
                     campo:'mo_total'
       });

       ViaticoEditar.main.monto_total.setValue("<span style='font-size:12px;'><b>Total a Pagar: </b>"+paqueteComunJS.funcion.getNumeroFormateado(ViaticoEditar.main.total_pagar)+"</b></span>");     

       

},
onSuccess: function(response,options){
	this.gridPanel.el.unmask();
	this.gridPanel.getStore().load();
        this.gridPanel.getView().refresh();
//        cajaEditar.main.botonReporte.disable();
//        Detalle.main.store_lista.load();
},
getLista: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/storelistaDetalle',
    root:'data',
    fields:[
                {name: 'co_detalle_viatico'},
                {name: 'co_item_viatico'},
                {name: 'tx_item_viatico'},
                {name: 'tx_observacion'},
                {name: 'cant_dia'},
                {name: 'cant_ut'},
                {name: 'mo_dia'},
                {name: 'mo_total'}
           ]
    });
    return this.store;      
},
getStoreCO_PARTIDA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Compras/storefkcopartidaViatico',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_partida',
            convert:function(v,r){
            return r.nu_partida+' - '+r.de_partida;
            }
            }
            ]
    });
    return this.store;
},
eliminar:function(){
        var s = ViaticoEditar.main.gridPanel.getSelectionModel().getSelections();
        
        var co_detalle_viatico = ViaticoEditar.main.gridPanel.getSelectionModel().getSelected().get('co_detalle_viatico');
       
        if(co_detalle_viatico!=''){
            
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Viatico/eliminar',
            params:{
                co_detalle_viatico: co_detalle_viatico
            },
            success:function(result, request ) {
               
            }});
            
        }
       
        for(var i = 0, r; r = s[i]; i++){
              ViaticoEditar.main.store_lista.remove(r);
        }
        
}
};
Ext.onReady(ViaticoEditar.main.init, ViaticoEditar.main);
</script>
<div id="formularioAgregar"></div>

