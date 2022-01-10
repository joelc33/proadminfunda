<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<title>.::ADMINISTRATIVO||<?php echo $sf_request->getAttribute('ejercicio'); ?>::.</title>
  <head>
	<?php include_http_metas() ?>
	<?php include_metas() ?>
	<?php include_title() ?>

<link rel="shortcut icon" href="<?php echo image_path('favicon.ico'); ?>" />

<?php echo use_stylesheet("app.css") ?>
<?php echo javascript_include_tag('app.js'); ?>
</head>
<div id="header" class="x-panel-header" style="margin:0px 0px 0px 0px; padding: 2px 2px 2px 10px;">
	<div style="float:left; width:500px; font-size:18px; line-height:22px; ">
		..::GOBEL ADMINISTRATIVO||<?php echo $sf_request->getAttribute('ejercicio'); ?>::..
	</div>
    <div id="usuarioConectado" style="float:right; padding:2px 20px 2px 20px; border:1px solid #AABBCC; background: #E8E8E8">
        <div style="float:left; margin-right: 20px; vertical-align: bottom; font-size: 11px; color:#444 ">
         <img src="../images/user.gif" align="bottom" style="margin-right: 5px;"/> <?php echo $sf_request->getAttribute('titulo'); ?> </div>
         <div id="btnSalir" style="float:left; margin-left: 20px">
        </div>
    </div>
</div>
<script type="text/javascript">
Ext.BLANK_IMAGE_URL = "<?php echo image_path('default/s.gif'); ?>";
Ext.Ajax.timeout = 120000; //2 minutes
Ext.override(Ext.data.Connection, { timeout : 240000 });
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

	    var arbol = new Ext.tree.TreePanel({
                    id:'im-tree',
                    loader: new Ext.tree.TreeLoader(),
                    rootVisible:false,
                    lines:true,
                    autoScroll:true,
                    border: false,
                    autoHeight:true,
                    animate:true,
                    useArrows: true,
                    animate:true,
                    animCollapse:true,
                    iconCls:'nav',
                    root: new Ext.tree.AsyncTreeNode({
                        text:'Inicio',
			 expanded: true,
                        children:[<?php echo $sf_request->getAttribute('menu'); ?>]

                    })
            });

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
        this.reloj = new Ext.Toolbar.TextItem('');
        /*correr reloj*/
        Ext.TaskMgr.start({run: function(){Ext.fly(reloj.getEl()).update('<span style="color:white;"><b>' + new Date().format('g:i:s A') + '</b></span>' );},interval: 1000});
        this.statusbar = new Ext.Toolbar({
	items:[
                this.reloj,
                '->',this.btnCambiarEjercicio
                ]
	});
        var viewport = new Ext.Viewport({
	layout: 'border',
	items: [
		    // create instance immediately
		    new Ext.BoxComponent({
		        region: 'north',
		        height: 33, // give north and south regions a height
		 	contentEl:'header'
		    }),{
		        region: 'west',
		        id: 'west-panel', // see Ext.getCmp() below
		        title: 'Menu del Sistema',
			iconCls: 'icon-navegacion',
		        split: true,
		        width: 240,
		        minSize: 175,
		        maxSize: 400,
			autoScroll:true,
		        collapsible: true,
			animCollapse: true,
		        margins: '0 0 0 0',
			bbar: this.statusbar,
		        items: [arbol]
		    },
			new Ext.Panel({
			region: 'center',
			deferredRender: false,
			border:false,
			autoScroll: true,
			items: [
				new Ext.Panel({
					id: 'tabPrincipal',
					border:true,
					title: 'Inicio',
                                        autoScroll:true,
					iconCls:'icon-inicio',
					contentEl:'centro'
				})
			]
			}),
            	    this.panel_detalle
           ]
         });
    });

        this.btnCambiarEjercicio = new Ext.Button({
                text: 'Cambiar Ejercicio',
                handler: cambiaEf,
                iconCls:'icon-calendar'
        });

	new Ext.Button({
                id:'btnSalir',
                text: 'Cerrar sesi&oacute;n',
                handler: logOut,
                iconCls:'icon-salir2',
                renderTo:'btnSalir'
        });

	function logOut(){
            Ext.MessageBox.confirm('Confirmar', 'Seguro que desea salir de la Aplicaci&oacute;n?', showResult);
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
        width:471,
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
        title:'Seleccione Ejercicio Fiscal',
        layout:'fit',
        iconCls: 'icon-cambio',
        width:485,
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
        buttonAlign:'center',
        items:[
                formPanel_cambioEf
        ],
        buttons: [
                this.guardar
        ]
        });

        this.ejercicio.show();
        }

        //Cierra la session cuando el usuario cierra el navegador
       window.onbeforeunload = function(){

                $.ajax({
                    type: "POST",
                    url: "<?php echo $_SERVER['SCRIPT_NAME']; ?>/login/cerrarNavegador",
                    dataType:"json",
                    data: {},
                    async : false,
                    success : function(){
                    }
                });

        }
</script>

<body>
                <div id="centro" align="center" style="padding-bottom: 1%;width:100%;height:600px;">
                 <img width="500" src="<?php echo image_path('gobel.png'); ?>" align="bottom"  style="margin-top: 150px;" /> 
                 <!--<img src="<?php echo image_path('gobelorig.jpg'); ?>"  width="300" style="position: absolute; top: 70%; right: 6px;" /> -->
        	</div>
                <div id="centro" align="center" style="padding-bottom: 1%">
                     
                </div>
		<div id="centro" class="x-hide-display"><?php echo $sf_content ?></div>
		<div id="props-panel" class="x-hide-display" style="width:200px;height:200px;overflow:hidden;"></div>
                <div id="muestra_contrib"></div>

</body>
</html>
