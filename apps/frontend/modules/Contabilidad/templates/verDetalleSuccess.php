<script type="text/javascript">
Ext.ns("verDetalles");
verDetalles.main = {
init:function(){

this.datos  = '<p class="registro_detalle"><b>N° Factura: </b>'+ContabilidadEditar.main.detalle_factura.get('nu_factura')+'</p>';
this.datos += '<p class="registro_detalle"><b>Fecha Emisión: </b>'+ContabilidadEditar.main.detalle_factura.get('fe_emision')+'</p>';
this.datos +='<p class="registro_detalle"><b>Base Imponible: </b>'+ContabilidadEditar.main.detalle_factura.get('nu_base_imponible')+'</p>';
this.datos += '<p class="registro_detalle"><b>IVA ('+ContabilidadEditar.main.detalle_factura.get('co_iva_factura')+'%): </b>'+ContabilidadEditar.main.detalle_factura.get('nu_iva_factura')+'</p>';
this.datos +='<p class="registro_detalle"><b>Monto Total: </b>'+ContabilidadEditar.main.detalle_factura.get('nu_total')+'</p>';

this.fieldDatos= new Ext.form.FieldSet({
        title: 'Datos de la Factura',
        html: this.datos
});

this.datosRetencion  = '<p class="registro_detalle"><b>IVA ('+ContabilidadEditar.main.detalle_factura.get('co_iva_retencion')+'%): </b>'+ContabilidadEditar.main.detalle_factura.get('nu_iva_retencion')+'</p>';
this.datosRetencion += '<p class="registro_detalle"><b>Imp. Municipal: </b>'+ContabilidadEditar.main.detalle_factura.get('nu_imp_municipal')+'</p>';
this.datosRetencion +='<p class="registro_detalle"><b>ISLR: </b>'+ContabilidadEditar.main.detalle_factura.get('nu_islr')+'</p>';
this.datosRetencion +='<p class="registro_detalle"><b>Timbre Fiscal: </b>'+ContabilidadEditar.main.detalle_factura.get('nu_timbre')+'</p>';
this.datosRetencion +='<p class="registro_detalle"><b>Aporte Social: </b>'+ContabilidadEditar.main.detalle_factura.get('nu_aporte_social')+'</p>';
this.datosRetencion +='<p class="registro_detalle"><b>Total Retención: </b>'+ContabilidadEditar.main.detalle_factura.get('nu_total_retencion')+'</p>';

this.fieldDatosContrato= new Ext.form.FieldSet({
        title: 'Retención',
        html: this.datosRetencion
});

this.datosPagar  = '<p class="registro_detalle"><b>Total a Pagar: </b>'+ContabilidadEditar.main.detalle_factura.get('total_pagar')+'</p>';
this.datosPagar += '<p class="registro_detalle"><b>Concepto: </b>'+ContabilidadEditar.main.detalle_factura.get('tx_concepto')+'</p>';

this.fieldDatosPagar= new Ext.form.FieldSet({
        title: 'Monto a Pagar',
        html: this.datosPagar
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        verDetalles.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
   // frame:true,
    width:650,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.fieldDatos,
            this.fieldDatosContrato,
            this.fieldDatosPagar]
});

this.winformPanel_ = new Ext.Window({
    title:'Detalle de Factura',
    modal:true,
    constrain:true,
    width:650,
   // frame:true,
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
}
};
Ext.onReady(verDetalles.main.init, verDetalles.main);
</script>
<div id="formularioAgregar"></div>