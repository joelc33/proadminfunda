<script type="text/javascript">
Ext.ns("enviarEntidades");
enviarEntidades.main= {
init:function(){

    this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
    
    if(this.OBJ.in_estatus == this.OBJ.in_carga_datos){
        Ext.MessageBox.show({
            title: 'Mensaje',
            msg: "La solicitud se envio exitosamente",
            closable: false,
            icon: Ext.MessageBox.INFO,
            resizable: false,
            animEl: document.body,
            buttons: Ext.MessageBox.OK
        });
        
        solicitudLista.main.store_lista.load('load',function(){
            solicitudLista.main.estado.disable();
        });
        
        if(panel_detalle.collapsed == false)
         {
             panel_detalle.toggleCollapse();
         } 
     }else{
          Ext.MessageBox.alert('Error en transacción', "No es posible enviar la solicitud, ya que se debe cargar los datos ");
     }
}
};
Ext.onReady(enviarEntidades.main.init, enviarEntidades.main);
</script>
