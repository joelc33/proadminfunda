<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title>PROADMIN</title>
  <head>
	<?php include_http_metas() ?>
	<?php include_metas() ?>
	<?php include_title() ?>
      
<!-- <link rel="shortcut icon" href="<?php echo image_path('favicon.ico'); ?>" /> -->


<link rel="stylesheet" type="text/css" href="/proadmin/web/js/ext-3.2.1/resources/css/ext-all.css" />
<!--<link rel="stylesheet" type="text/css" href="/tbpm/web/js/ext-3.2.1/resources/css/DarkGrayTheme/css/xtheme-darkgray.css"/>-->

<?php use_stylesheet("iconos.css") ?>


<!-- Start Page Loading
<div id="loader-wrapper">
  <div id="loader"></div>
</div>
<!-- End Page Loading -->

<?php echo javascript_include_tag('app.js'); ?>

<?php echo javascript_include_tag('http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js'); ?>
<?php echo javascript_include_tag('highcharts.js'); ?>
<?php echo javascript_include_tag('highcharts-3d.js'); ?>
<?php echo javascript_include_tag('exporting.js'); ?>

<?php echo javascript_include_tag('funciones_comunes/paqueteComun.js'); ?>
<?php echo javascript_include_tag('datos_contribuyente.js'); ?>



</head>
<div id="header">
  <div style="background-color:white; padding-left:0px; padding-right:0px; padding-bottom:0px;">
      <img height="58" width="100%" src="<?php echo image_path('cintillo.png'); ?>">
      <img src="<?php echo image_path('admbmp.png'); ?>"  height="58" style="position: absolute; top: 0%; left: 6px;" />
  </div>
</div>
<script type="text/javascript">
Ext.BLANK_IMAGE_URL = "<?php echo image_path('default/s.gif'); ?>";
        this.panel_detalle =  new Ext.Panel({
                region: 'east', // a center region is ALWAYS required for border layout
                title: 'Detalles',
                id: 'detalle_registro',
                collapsible: true,
                collapseMode: 'mini',
                collapsed:true,
                split: true,
                autoScroll: true,
                titleCollapse: true,
                deferredRender: false,
                width:502,
                script:true,
		iconCls: 'icon-reporteest',
                items:[
			new Ext.Panel({
				id: 'detalle'
			})
                ]
	});

Ext.onReady(function(){



        Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
	// Start a simple clock task that updates a div once per second
	this.updateClock = function(){
		Ext.getCmp('clock').setText(new Date().format('g:i:s A'));
	}
	//Configuration object for the task
	this.task = {
		run: this.updateClock, //the function to run
	   	interval: 1000 //every second
	}
	//creates a new manager
	this.runner = new Ext.util.TaskRunner();
	this.runner.start(this.task); //start runing the task every one second
	this.clock = new Ext.Toolbar.TextItem({id:'clock',text: '00:00:00 AM'});
        this.statusbar = new Ext.Toolbar({
	items:['Sesion Iniciada','->',this.clock]
	});
        var viewport = new Ext.Viewport({
	layout: 'border',
	items: [
		    // create instance immediately
		    new Ext.BoxComponent({
		        region: 'north',
		        height: 53, // give north and south regions a height
		 	contentEl:'header'
		    }),
			new Ext.Panel({
			region: 'center',
                        deferredRender: false,
                        margins: '0 0 0 5',
			border:true,
			autoScroll: true,
                        tbar:[{
                             xtype: 'tbtext', text: '<span style="color:blue;"><b>EJERCICIO FISCAL: <?php echo $sf_request->getAttribute('ejercicio'); ?></b></span>'},'-',
                             <?php echo $sf_request->getAttribute('menu'); ?>
                        ],
			items: [
				new Ext.Panel({
                                        title:' ',
					id: 'tabPrincipal',
					border:false,
                                        autoScroll:true,
                                        contentEl:'centro',
                                        layout:'fit',
                                        padding: 5,
		                        //autoLoad: {url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bandeja', scripts: true, scope: this}
				})
			]
			}),
                        this.panel_detalle,
                        {
                                region: 'south',
                                split:true,
                                layout:'fit',
                                maxSize: 10,
                                border:false,
                                bbar : [
                                        {xtype: 'tbtext', height: 20, text: '<span style="color:red;"><b>ADMINISTRACIÓN</b></span>'},
                                        '->','-',
                                        this.btnCambiarEjercicio,'-',
                                        {
                                                xtype: 'displayfield',
                                                value: '&nbsp;&nbsp;<b>Usuario:<b>',
                                                width: 100
                                        },
                                        {
                                                xtype: 'displayfield',
                                                value: '<?php echo $sf_request->getAttribute('titulo'); ?>',
                                                width: 100
                                        },'-',
                                        this.CerrarSesion
                                ]
                        }
           ]
         });
    });

this.CerrarSesion = new Ext.Button({
        id:'btnSalir',
        text: 'Cerrar sesi&oacute;n',
        handler: logOut,
        iconCls:'icon-salir2'
});

this.btnCambiarEjercicio = new Ext.Button({
        text: 'Cambiar Periodo',
        handler: cambiaEf,
        iconCls:'icon-arrow_switch'
});

function cambiaEf(){

        this.storeCO_EJERCICIO = new Ext.data.JsonStore({
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ejercicio/storelista',
                root:'data',
                fields:[
                        {name: 'co_anio_fiscal'},{name: 'tx_anio_fiscal'},{name: 'fe_apertura'},{name: 'fe_cierre'}
                ],
                listeners : {
                        exception : function(proxy, response, operation) {
                        Ext.Msg.alert("Aviso", 'Error al obtener respuesta del servidor intente de nuevo!');
                        }
                }
        });

this.id_tab_ejercicio = new Ext.form.ComboBox({
        fieldLabel:'Periodo',
        store: this.storeCO_EJERCICIO,
        typeAhead: true,
        valueField: 'co_anio_fiscal',
        displayField:'co_anio_fiscal',
        hiddenName:'ejercicio',
        forceSelection:true,
        resizable:true,
        triggerAction: 'all',
        emptyText:'Ejercicio Fiscal...',
        itemSelector: 'div.search-item',
                tpl: new Ext.XTemplate('<tpl for=".">'+
        '<div class="search-item">'+
        '<div style="margin: 4px;" class="x-boundlist-item">'+
        '<div><b>EJERCICIO FISCAL: {tx_anio_fiscal}</b></div>'+
        '<div style="font-size: xx-small; color: grey;">({fe_apertura}) hasta ({fe_cierre})</div>'+
        '</div>'+
        '</div>'+
        '</tpl>'),
        selectOnFocus: true,
        mode: 'local',
        width:200,
        resizable:true,
        allowBlank:false
});

this.storeCO_EJERCICIO.load();
        paqueteComunJS.funcion.seleccionarComboByCo({
        objCMB: this.id_tab_ejercicio,
        value: <?php echo $sf_request->getAttribute('ejercicio'); ?>,
        objStore: this.storeCO_EJERCICIO
});

this.fielset1 = new Ext.form.FieldSet({
        title:'Año en Ejercicio',
        autoWidth:true,
        labelWidth: 130,
        items:[
                this.id_tab_ejercicio
        ]
});

var formPanel_cambioEf = new Ext.form.FormPanel({
        width:421,
        labelWidth: 130,
        border:false,
        autoHeight:true,
        autoScroll:true,
        bodyStyle:'padding:10px;',
        items:[
                this.fielset1,
                {html : "<p><br><b>Seleccione la opcion a realizar y presione Aceptar:</b></p>",border : false}
        ]
});

        this.guardar = new Ext.Button({
                text:'Aceptar',
                iconCls: 'icon-fin',
                align:'center',
                handler:function(){

                if(!formPanel_cambioEf.getForm().isValid()){
                        Ext.MessageBox.show({
                                title: 'Alerta',
                                msg: "Debe ingresar los campos en rojo",
                                closable: false,
                                icon: Ext.MessageBox.INFO,
                                resizable: false,
                                animEl: document.body,
                                buttons: Ext.MessageBox.OK
                        });
                        return false;
                }

                formPanel_cambioEf.getForm().submit({
                        method:'POST',
                        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ejercicio/guardar',
                        waitMsg: 'Seleccionando Periodo, por favor espere..',
                        waitTitle:'Enviando',
                        failure: function(form, action) {
                                var errores = '';
                                for(datos in action.result.msg){
                                errores += action.result.msg[datos] + '<br>';
                                }
                                Ext.MessageBox.alert('Error en transacción', errores);
                        },
                        success: function(form, action) {
                                if(action.result.success){
                                        Ext.MessageBox.show({title: 'Cargando Ejercicio', msg: '<br>Por favor  Espere...',width:300,closable:false,icon:Ext.MessageBox.INFO});
                                        location.href=action.result.url;
                                }
                        }
                });

        }
});

this.ejercicio = new Ext.Window({
        title:'Seleccione Periodo Fiscal',
        layout:'fit',
        iconCls: 'icon-arrow_switch',
        width:435,
        autoHeight:true,
        modal:true,
        frame:true,
        autoScroll: true,
        maximizable:false,
        closable:true,
        draggable: false,
        resizable: false,
        constrain:true,
        plain: true,
        buttonAlign:'right',
        items:[
                formPanel_cambioEf
        ],
        buttons: [
                this.guardar
        ]
});

        this.ejercicio.show();
}



	function logOut(){
            Ext.MessageBox.confirm('Confirmar', 'Seguro que desea salir del Sistema?', showResult);
        }

	function showResult(btn){
            if(btn=="yes"){
                Ext.MessageBox.show({title: 'Cerrando sesi&oacute;n', msg: '<br>Por favor  Espere...',width:300,closable:false,icon:Ext.MessageBox.INFO});
                location.href='<?php echo $_SERVER['SCRIPT_NAME']; ?>/login/limpiar';
            }
	}

        function doJSON(stringData) {
            try {
                    stringData = stringData.split('\r').join('\\r');
                    stringData = stringData.split('\n').join('\\n');
                    var jsonData = Ext.util.JSON.decode(stringData);
                    return jsonData;
            }
            catch (err) {
                    //Ext.MessageBox.alert('ERROR', 'No es posible interpretar los datos recibidos.<br>Vuelva a intentarlo' + stringData);
                    //Variables de la excepcion serian, err.message, err.description
                    Ext.MessageBox.alert('ERROR', 'No es posible interpretar los datos recibidos.<br>Vuelva a intentarlo. '+err.description);
            }
       }

       $(function () {
  
            $(".cyan").backstretch([
            "<?php echo image_path('fondo_protrib.png'); ?>"
              ], {duration: 3000, fade: 750});

        });

</script>


<body>
                <div id="centro" align="center" style="padding-bottom: 1%;width:100%;height:500px;">
                <!-- <img width="500" src="<?php echo image_path('admbpm.png'); ?>" align="bottom"  style="margin-top: 150px;" /> -->
                <img src="<?= image_path('logo_sanfco_new.png'); ?>"  width="300" style="position: absolute; top: 60%; right: 6px;" />
        	</div>
                <div id="centro" align="center" style="padding-bottom: 1%">

                </div>
		<div id="centro" class="x-hide-display"><?php echo $sf_content ?></div>
		<div id="props-panel" class="x-hide-display" style="width:200px;height:200px;overflow:hidden;"></div>
                <div id="muestra_contrib"></div>

</body>
</html>
