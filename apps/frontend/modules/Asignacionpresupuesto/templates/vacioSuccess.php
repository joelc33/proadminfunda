
<script type="text/javascript">
Ext.ns('AsignacionpresupuestoLista');
AsignacionpresupuestoLista.main = {
	init: function(){
    //Mascara general del modulo
    this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

    this.agregar = new Ext.Button({
        text:'Importar',
        iconCls: 'icon-nuevo',
        width:80,
        handler:function(){
            AsignacionpresupuestoLista.main.mascara.show();
            this.msg = Ext.get('formularioAsignacionpresupuestoListaDetalle');
            this.msg.load({
             url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/Poa/importar",
             scripts: true,
             text: "Cargando.."
            });
        }
    });

	this.tabuladores = new Ext.Panel({
		title:'Estatus: Presupuesto',
		autoWidth:true,
		border:false,
		padding	: 10,
		html: '<center><p><b>Ejercicio:</b> <?php echo $sf_request->getAttribute('ejercicio'); ?> </p>'+
		'<p><i><b>Aviso: Se debe importar del POA la Formulacion presupuestaria para ejecutar.</b> </i></p>',
    buttons:[
          this.agregar
    ],
    buttonAlign:'center'
	});

	this.tabuladores.render('formularioAsignacionpresupuestoLista');

	}
}
Ext.onReady(AsignacionpresupuestoLista.main.init, AsignacionpresupuestoLista.main);
</script>
<div id="formularioAsignacionpresupuestoLista"></div>
<div id="formularioAsignacionpresupuestoListaDetalle"></div>
