<script type="text/javascript">
    Ext.ns("validar");
        validar.main = {
            init: function () {
                        Ext.MessageBox.show({
                             title: 'Mensaje',
                             msg: "No cuenta con permisos suficientes para visualizar el reporte",
                             closable: false,
                             icon: Ext.MessageBox.INFO,
                             resizable: false,
                             animEl: document.body,
                             buttons: Ext.MessageBox.OK
                         });
            }
        };
    Ext.onReady(validar.main.init, validar.main);
</script>
