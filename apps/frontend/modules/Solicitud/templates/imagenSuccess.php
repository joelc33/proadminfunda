<script type="text/javascript">
Ext.ns("Imagen");
Imagen.main = {
init:function(){

this.formPanel_ = new Ext.Panel({
    frame:true,
    width:700,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    html:'<img width="600" height="485" src="<?php echo $tx_ruta; ?>">'
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        Imagen.main.winformPanel_.close();
    }
});

this.winformPanel_ = new Ext.Window({
    title:'Imagen',
    modal:true,
    constrain:true,
    width:700,
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
}
};
Ext.onReady(Imagen.main.init, Imagen.main);
</script>
