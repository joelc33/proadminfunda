<script type="text/javascript">
Ext.ns("ContabilidadEditar");
ContabilidadEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
 
this.detalle_factura = '';
this.monto_total = 0;

ContabilidadEditar.main.co_factura;
ContabilidadEditar.main.nu_factura;
ContabilidadEditar.main.fe_emision;
ContabilidadEditar.main.nu_base_imponible;
ContabilidadEditar.main.nu_total_retencion;
ContabilidadEditar.main.total_pagar;

this.co_compra = new Ext.form.Hidden({
    name:'co_compra',
    value:this.OBJ.co_compras
});

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud
});


this.co_documento = new Ext.form.Hidden({
    name:'co_documento',
    value:this.OBJ.co_documento
});

this.co_ramo = new Ext.form.Hidden({
    name:'co_ramo',
    value:this.OBJ.co_ramo
});
//</ClavePrimaria>

this.store_lista = this.getLista();


this.Registro = Ext.data.Record.create([
         {name: 'nu_factura', type: 'number'},
         {name: 'fe_emision', type: 'string'},
         {name: 'nu_base_imponible', type:'number'},
         {name: 'co_iva_factura', type:'number'},
         {name: 'nu_iva_factura', type: 'number'},                 
         {name: 'nu_total', type:'number'},
         {name: 'co_iva_retencion', type: 'number'},
         {name: 'nu_iva_retencion', type: 'number'},
         {name: 'nu_total_retencion', type:'number'},
         {name: 'total_pagar', type:'number'},   
         {name: 'nu_total_pagar', type:'number'},
         {name: 'tx_concepto', type:'number'},
         {name: 'json_detalle_retencion', type:'string'}
]);

this.hiddenJsonFactura  = new Ext.form.Hidden({
        name:'json_factura',
        value:''
});


this.agregar = new Ext.Button({
    text: 'Agregar Datos de Factura',
    iconCls: 'icon-nuevo',
    handler: function () {
        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/agregarDatosFactura',
            scripts: true,
            text: "Cargando..",
            params:{
                co_factura: ContabilidadEditar.main.co_factura,
                nu_factura: ContabilidadEditar.main.nu_factura,
                fe_emision: ContabilidadEditar.main.fe_emision,
                nu_base_imponible: ContabilidadEditar.main.nu_base_imponible,
                nu_total_retencion: ContabilidadEditar.main.nu_total_retencion,
                total_pagar: ContabilidadEditar.main.total_pagar
            }
        });
    }
});

this.agregar.disable();

this.monto_total = new Ext.form.DisplayField({
 value:"<span style='font-size:12px;'><b>Total a Pagar: </b>0,00</b></span>"
});

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

this.gridPanel = new Ext.grid.GridPanel({
        title:'Lista de Facturas',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:200,  
        width:810,
        tbar:[this.agregar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_factura', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_factura'},    
            {header: 'N° Factura',width:100, menuDisabled:true,dataIndex: 'nu_factura'},                
            {header: 'Fecha Emisión', width:100, menuDisabled:true,dataIndex: 'fe_emision'},
            {header: 'Base Imponible',width:180, menuDisabled:true,dataIndex: 'nu_base_imponible',renderer:renderMonto},
            {header: 'Total Retenciones',width:180, menuDisabled:true,dataIndex: 'nu_total_retencion',renderer:renderMonto},
            {header: 'Total Factura',width:180, menuDisabled:true,dataIndex: 'total_pagar',renderer:renderMonto}
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
            ContabilidadEditar.main.agregar.enable();
            ContabilidadEditar.main.co_factura           =  ContabilidadEditar.main.store_lista.getAt(rowIndex).get('co_factura');
            ContabilidadEditar.main.nu_factura           =  ContabilidadEditar.main.store_lista.getAt(rowIndex).get('nu_factura');
            ContabilidadEditar.main.fe_emision           =  ContabilidadEditar.main.store_lista.getAt(rowIndex).get('fe_emision');
            ContabilidadEditar.main.nu_base_imponible    =  ContabilidadEditar.main.store_lista.getAt(rowIndex).get('nu_base_imponible');
            ContabilidadEditar.main.nu_total_retencion   =  ContabilidadEditar.main.store_lista.getAt(rowIndex).get('nu_total_retencion');
            ContabilidadEditar.main.total_pagar          =  ContabilidadEditar.main.store_lista.getAt(rowIndex).get('total_pagar');
        }}   
});

if(this.OBJ.co_solicitud!=''){

    ContabilidadEditar.main.store_lista.baseParams.co_solicitud=this.OBJ.co_solicitud;
    this.store_lista.load({
        callback: function(){
            ContabilidadEditar.main.total_pagar = paqueteComunJS.funcion.getSumaColumnaGrid({
                 store:ContabilidadEditar.main.store_lista,
                 campo:'total_pagar'
            });
            
             ContabilidadEditar.main.monto_total.setValue("<span style='font-size:12px;'><b>Total a Pagar: </b>"+paqueteComunJS.funcion.getNumeroFormateado(ContabilidadEditar.main.total_pagar)+"</b></span>");     
        }
    });

}

this.datos  = '<p class="registro_detalle"><b>RIF: </b>'+this.OBJ.tipo+'-'+this.OBJ.tx_rif+'</p>';
this.datos += '<p class="registro_detalle"><b>Razón Social: </b>'+this.OBJ.tx_razon_social+'</p>';
this.datos +='<p class="registro_detalle"><b>Dirección: </b>'+this.OBJ.tx_direccion+'</p>';

this.fieldDatos= new Ext.form.FieldSet({
        title: 'Datos del Proveedor',
        html: this.datos
});
            

this.datosContrato  = '<p class="registro_detalle"><b>Fecha de Inicio: </b>'+this.OBJ.fe_inicio+'</p>';
this.datosContrato += '<p class="registro_detalle"><b>Fecha Fin: </b>'+this.OBJ.fe_fin+'</p>';
this.datosContrato +='<p class="registro_detalle"><b>Tipo de Contrato: </b>'+this.OBJ.tx_ramo+'</p>';
this.datosContrato +='<p class="registro_detalle"><b>Monto previsto: </b>'+paqueteComunJS.funcion.getNumeroFormateado(this.OBJ.monto)+'</p>';

this.fieldDatosContrato= new Ext.form.FieldSet({
        title: 'Datos del Contrato',
        html: this.datosContrato
});

this.tx_concepto = new Ext.form.TextField({
	fieldLabel:'Concepto',
	name:'tb039_requisiciones[tx_concepto]',
	value:this.OBJ.tx_concepto,
	allowBlank:false,
	width:680
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

        if(!ContabilidadEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        
        
        if(parseFloat(ContabilidadEditar.main.total_pagar)>=parseFloat(ContabilidadEditar.main.OBJ.monto)){
            Ext.Msg.alert("Alerta","El total de la factura debe ser menor o igual al monto previsto.");
            return false;
        }
        
        var list_factura = paqueteComunJS.funcion.getJsonByObjStore({
                store:ContabilidadEditar.main.gridPanel.getStore()
        });
        
        ContabilidadEditar.main.hiddenJsonFactura.setValue(list_factura);        
        
        ContabilidadEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/guardar',
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
                 
              
                Detalle.main.store_lista.load();
                
                 ContabilidadEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ContabilidadEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:850,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[         this.co_compra,
                    this.co_documento,
                    this.co_ramo,
                    this.co_solicitud,
                    this.hiddenJsonFactura,
                    this.fieldDatos,
                    this.fieldDatosContrato,
                    this.gridPanel
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Contabilidad',
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
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
},
eliminar:function(){
        var s = ContabilidadEditar.main.gridPanel.getSelectionModel().getSelections();
        
        var co_factura = ContabilidadEditar.main.gridPanel.getSelectionModel().getSelected().get('co_factura');
       
        if(co_factura!=''){
            
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/eliminarFactura',
            params:{
                co_factura: co_factura,
                co_solicitud: ContabilidadEditar.main.OBJ.co_solicitud
            },
            success:function(result, request ) {
               ContabilidadEditar.main.store_lista.load();
            }});
            
        }
       
        for(var i = 0, r; r = s[i]; i++){
              ContabilidadEditar.main.store_lista.remove(r);
        }
        
},getLista: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/storelista',
    root:'data',
    fields:[
                {name :'co_factura'},
                {name :'nu_factura'},
                {name :'fe_emision'},
                {name :'nu_base_imponible'},
                {name :'co_iva_factura'},
                {name :'nu_iva_factura'},
                {name :'nu_total'},
                {name :'co_iva_retencion'},
                {name :'nu_iva_retencion'},
                {name :'nu_total_pagar'},
                {name :'nu_total_retencion'},
                {name :'total_pagar'},
                {name :'tx_concepto'},
                {name :'co_compra'},
                {name :'co_solicitud'}
           ]
    });
    return this.store;      
}
};
Ext.onReady(ContabilidadEditar.main.init, ContabilidadEditar.main);
</script>
<div id="formularioAgregar"></div>