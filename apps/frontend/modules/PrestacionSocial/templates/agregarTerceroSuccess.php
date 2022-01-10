<script type="text/javascript">
Ext.ns("PrestacionSocialEditarDetalle");
PrestacionSocialEditarDetalle.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud
});

this.nu_cedula = new Ext.form.NumberField({
	fieldLabel:'Cédula',
	name:'nu_cedula',
	allowBlank:false,
	width:200
});

this.nombre = new Ext.form.TextField({
	fieldLabel:'Nombre y Apellido',
	name:'nombre',
	allowBlank:false,
	width:200
});

this.nu_cuenta = new Ext.form.TextField({
	fieldLabel:'Cuenta Bancaria',
	name:'nu_cuenta',
        maxLength:20,
        minLength:20,
        //minValue:20,
        maxValue:99999999999999999999999999,
	width:200
});

this.porcentaje = new Ext.form.NumberField({
	fieldLabel:'Porcentaje',
	name:'nombre',
        minValue:1,
        maxValue:100,        
	allowBlank:false,
	width:200
});

this.mo_pagar = new Ext.form.NumberField({
	fieldLabel:'Monto a Pagar',
	name:'mo_pagar',
	value:this.OBJ.mo_pagar,
	allowBlank:false,
	width:200
});

this.mo_asignacion = new Ext.form.Hidden({
    name:'mo_asignacion',
    value:this.OBJ.mo_asignacion
});

this.mo_deduccion = new Ext.form.Hidden({
    name:'mo_deduccion',
    value:this.OBJ.mo_deduccion
});

this.guardar = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-guardar',
    handler:function(){
        
        if(!PrestacionSocialEditarDetalle.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }

        
        var e = new PrestacionSocialEditar.main.RegistroTerceros({    
            nu_cedula: PrestacionSocialEditarDetalle.main.nu_cedula.getValue(),  
            nombre: PrestacionSocialEditarDetalle.main.nombre.getValue(), 
            nu_cuenta: PrestacionSocialEditarDetalle.main.nu_cuenta.getValue(),
            porcentaje:PrestacionSocialEditarDetalle.main.porcentaje.getValue(),
            mo_pagar:PrestacionSocialEditarDetalle.main.mo_pagar.getValue(),
        });

        var cant = PrestacionSocialEditar.main.store_lista_tercero.getCount();
         
        (cant == 0) ? 0 : PrestacionSocialEditar.main.store_lista_tercero.getCount() + 1;
      
    
        PrestacionSocialEditar.main.store_lista_tercero.insert(cant, e);
        PrestacionSocialEditar.main.gridPanel_terceros.getView().refresh();
        
        Ext.utiles.msg('Mensaje', "El detalle de tercero se agregó exitosamente");

        PrestacionSocialEditar.main.calcular(); 
        
        PrestacionSocialEditarDetalle.main.winformPanel_.close(); 
       
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        PrestacionSocialEditarDetalle.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
  //  frame:true,
    width:400,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
        this.nu_cedula,
        this.nombre,
        this.nu_cuenta,
        this.porcentaje,
        this.mo_pagar,
        this.mo_asignacion,
        this.mo_deduccion
    ]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Detalle de Tercero',
    modal:true,
    constrain:true,
    width:414,
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
Ext.onReady(PrestacionSocialEditarDetalle.main.init, PrestacionSocialEditarDetalle.main);
</script>
<div id="formularioProducto"></div>
