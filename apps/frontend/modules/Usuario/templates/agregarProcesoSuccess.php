<script type="text/javascript">
Ext.ns("agregarInstituto");
agregarInstituto.main = {
init:function(){

        if(<?php echo $respuesta ?>==1){
             
             Ext.MessageBox.show({
                 title: 'Mensaje',
                 msg: '<?php echo $mensaje; ?>',
                 closable: false,
                 icon: Ext.MessageBox.INFO,
                 resizable: false,
                 animEl: document.body,
                 buttons: Ext.MessageBox.OK
             });
             
             listaProceso.main.store_lista.removeAll();
             listaProceso.main.storeCO_PROCESO.removeAll();
             
             listaProceso.main.mascara.hide();
             listaProceso.main.store_lista.baseParams.co_usuario = '<?php echo $co_usuario ?>';
             listaProceso.main.store_lista.load();
             listaProceso.main.storeCO_PROCESO.baseParams.co_usuario = '<?php echo $co_usuario ?>';
             listaProceso.main.storeCO_PROCESO.load();
             listaProceso.main.co_proceso.setValue("");
             listaProceso.main.in_principal.setValue("");
       
        }else{          
             Ext.MessageBox.alert('Error en transacción', '<?php echo $mensaje; ?>');
              listaProceso.main.mascara.hide();
        }
         
           
}};
Ext.onReady(agregarInstituto.main.init, agregarInstituto.main);
</script>
