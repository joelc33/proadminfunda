<script type="text/javascript">
Ext.ns("agregarDatosFactura");
agregarDatosFactura.main = {
init:function(){

    this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

    this.co_factura = new Ext.form.Hidden({	
            name:'co_factura',
            value: this.OBJ.co_factura
    });

    this.nu_factura = new Ext.form.TextField({
            fieldLabel:'N° Factura',
            name:'nu_factura',
            allowBlank:false,
            width:200,
            value: this.OBJ.nu_factura
    });

    this.fecha_emision = new Ext.form.DateField({
            fieldLabel:'Fecha Emisión',
            name:'fe_emision',
            allowBlank:false,
            format:'d-m-Y',
            width:100,
            value: this.OBJ.fecha_emision
    });
    
    this.nu_base_imponible = new Ext.form.TextField({
            fieldLabel:'Base Imponible',
            name:'nu_base_imponible',
            allowBlank:false,
            width:300,
            readOnly:true,
            style:'background:#c9c9c9;',
            value: paqueteComunJS.funcion.getNumeroFormateado(this.OBJ.nu_base_imponible)
    });
    
    this.nu_total_retencion = new Ext.form.TextField({
            fieldLabel:'Total Retención',
            name:'nu_total_retencion',
            allowBlank:false,
            width:300,
            readOnly:true,
            style:'background:#c9c9c9;',
            value: paqueteComunJS.funcion.getNumeroFormateado(this.OBJ.nu_total_retencion)
    });
    
    this.total_pagar = new Ext.form.TextField({
            fieldLabel:'Total a Pagar',
            name:'total_pagar',
            allowBlank:false,
            width:300,
            readOnly:true,
            style:'background:#c9c9c9;',
            value: paqueteComunJS.funcion.getNumeroFormateado(this.OBJ.total_pagar)
    });

    this.fieldDatosFactura= new Ext.form.FieldSet({
        title: 'Datos de la Factura',
        items:[ this.co_factura,
                this.nu_factura,
                this.fecha_emision,
                this.nu_base_imponible,
                this.nu_total_retencion,
                this.total_pagar]
    });

    this.guardar = new Ext.Button({
        text:'Agregar',
        iconCls: 'icon-guardar',
        handler:function(){       

        if(!agregarDatosFactura.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        agregarDatosFactura.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Contabilidad/guardarDatosFactura',
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
                    
                    ContabilidadEditar.main.store_lista.baseParams.co_solicitud = ContabilidadEditar.main.OBJ.co_solicitud;
                    ContabilidadEditar.main.store_lista.load({
                        callback: function(){
                            ContabilidadEditar.main.total_pagar = paqueteComunJS.funcion.getSumaColumnaGrid({
                                 store:ContabilidadEditar.main.store_lista,
                                 campo:'total_pagar'
                            });

                             ContabilidadEditar.main.monto_total.setValue("<span style='font-size:12px;'><b>Total a Pagar: </b>"+paqueteComunJS.funcion.getNumeroFormateado(ContabilidadEditar.main.total_pagar)+"</b></span>");     
                        }
                    });
                    
                    
                    agregarDatosFactura.main.winformPanel_.close();  
                }
           });

                
        }
    });



    this.salir = new Ext.Button({
        text:'Salir',
    //    iconCls: 'icon-cancelar',
        handler:function(){
            agregarDatosFactura.main.winformPanel_.close();
        }
    });

    this.formPanel_ = new Ext.form.FormPanel({
      //  frame:true,
        width:600,
        autoHeight:true,  
        autoScroll:true,
        bodyStyle:'padding:10px;',
        items:[this.fieldDatosFactura]
    });

    this.winformPanel_ = new Ext.Window({
        title:'Agregar Datos Factura',
        modal:true,
        constrain:true,
        width:610,
      //  frame:true,
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
}
};
Ext.onReady(agregarDatosFactura.main.init, agregarDatosFactura.main);
</script>
