<script type="text/javascript">
Ext.ns("agregarAjuste");
agregarAjuste.main = {
init:function(){
    
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

function formatoNro(val){
	return '<p align="right">'+paqueteComunJS.funcion.getNumeroFormateado(val)+'</p>';
}

this.id_partida = new Ext.form.Hidden({
    name:'id_partida'
});

this.monto = new Ext.form.NumberField({
	fieldLabel:'Monto',
	name:'monto',
        allowBlank:false,
	width:150
});


this.cuenta = new Ext.form.TextField({
	fieldLabel:'Cuenta',
	name:'cuenta',     
        readOnly:true,
        allowBlank:false,
	width:200
});

this.denominacion = new Ext.form.TextField({
	fieldLabel:'Denominacion',
	name:'denominacion',     
        readOnly:true,
        allowBlank:false,
	width:550
});

this.agregar = new Ext.Button({
    text:'Buscar',
    iconCls: 'icon-nuevo',
    handler:function(){
        this.msg = Ext.get('formulario');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Presupuesto/BuscarPartida',
            scripts: true,
            text: "Cargando..",
        });
    }
});

this.compositefieldCuenta = new Ext.form.CompositeField({
fieldLabel: 'Partida',
width:900,
items: [
	this.cuenta,
	this.denominacion,
        this.agregar
	]
});

this.fecha = new Ext.form.DateField({
	fieldLabel:'Fecha',
	name:'fecha',
        //readOnly:true,
        allowBlank:false,
	width:100
});

this.descripcion = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'descripcion',     
        allowBlank:false,
	width:755
});

this.fieldAfectar= new Ext.form.FieldSet({
        title: 'Datos del Reintegro',
        items:[ this.monto,
                this.fecha,
                this.descripcion,
                this.compositefieldCuenta
       ]
});

this.guardar = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-nuevo',
    handler:function(){
         agregarAjuste.main.agregarCuenta();
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        agregarAjuste.main.winformPanel_.close();
    }
});



this.formPanel_ = new Ext.form.FormPanel({
    fileUpload: true,
    frame:true,
    width:1000,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.fieldAfectar]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Partida',
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
},agregarCuenta: function(){
        if(!agregarAjuste.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        } 
       

       var monto =   agregarAjuste.main.monto.getValue();
        var e = new ComprobanteAjuste.main.Registro({  
            id_partida: agregarAjuste.main.id_partida.getValue(),
            tx_cuenta:agregarAjuste.main.cuenta.getValue(),
            denominacion:agregarAjuste.main.denominacion.getValue(),
            descripcion:agregarAjuste.main.descripcion.getValue(),
            fecha:agregarAjuste.main.fecha.getValue().format('Y-m-d'),
            monto:monto
        });
                
        var cant = ComprobanteAjuste.main.store_lista.getCount();
       
        (cant == 0) ? 0 : ComprobanteAjuste.main.store_lista.getCount() + 1;
        ComprobanteAjuste.main.store_lista.insert(cant, e);

        ComprobanteAjuste.main.gridPanel.getView().refresh();
        
        Ext.utiles.msg('Mensaje', "El registro se agregó exitosamente");
        
        agregarAjuste.main.winformPanel_.close();
}
};
Ext.onReady(agregarAjuste.main.init, agregarAjuste.main);
</script>
<div id="formulario"></div>