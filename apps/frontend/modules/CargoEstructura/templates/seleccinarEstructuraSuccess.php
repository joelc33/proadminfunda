<script type="text/javascript">
     //document.getElementById("div_negocio").innerHTML = '<p class="registro_detalle"><b>Negocio: </b><?php echo $negocio; ?></p>';
    <?php echo $paquete_modulo; ?>.main.estructura.setValue('<?php echo $estructura; ?>');
    <?php echo $paquete_modulo; ?>.main.co_estructura_administrativa.setValue('<?php echo $co_estructura_administrativa ?>');


    <?php echo $paquete_modulo; ?>.main.co_cargo.setValue("");
    <?php echo $paquete_modulo; ?>.main.co_tp_nomina.clearValue();
    <?php echo $paquete_modulo; ?>.main.mo_sueldo.setValue("");
    <?php echo $paquete_modulo; ?>.main.storeCO_CARGO.load({
        params:{
            co_estructura_administrativa: <?php echo $co_estructura_administrativa ?>
        }
    });

</script>
