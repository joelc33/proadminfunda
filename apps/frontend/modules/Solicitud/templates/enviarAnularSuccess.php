<script type="text/javascript">
Ext.ns("enviarEntidades");
enviarEntidades.main= {
init:function(){

        Ext.MessageBox.show({
            title: 'Mensaje',
            msg: "La solicitud se anuló exitosamente",
            closable: false,
            icon: Ext.MessageBox.INFO,
            resizable: false,
            animEl: document.body,
            buttons: Ext.MessageBox.OK
        });
        
        solicitudLista.main.store_lista.load('load',function(){
            solicitudLista.main.estado.disable();
            solicitudLista.main.anular.disable();
        });
        
        if(panel_detalle.collapsed == false)
         {
             panel_detalle.toggleCollapse();
         } 
}
};
Ext.onReady(enviarEntidades.main.init, enviarEntidades.main);
</script>
