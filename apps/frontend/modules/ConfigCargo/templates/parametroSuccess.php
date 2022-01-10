<script type="text/javascript">
Ext.ns("ConfigCargoEditar");
ConfigCargoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});


this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigCargoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:700,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[


            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Parametros',
    modal:true,
    constrain:true,
width:714,
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
ConfigCargoLista.main.mascara.hide();
}
};
Ext.onReady(ConfigCargoEditar.main.init, ConfigCargoEditar.main);
</script>
