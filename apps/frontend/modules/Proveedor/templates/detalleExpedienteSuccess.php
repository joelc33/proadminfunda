<script type="text/javascript">
Ext.ns('datos');
datos.main = {
init: function(){

        this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
        
        this.store_lista = this.getLista();
        this.storeCO_TIPO_TRAMITE = this.getStoreCO_TIPO_TRAMITE();

        this.datos = '<p class="registro_detalle"><b>Rif: </b>'+this.OBJ.tx_documento+'-'+this.OBJ.tx_rif+'</p>';
        this.datos +='<p class="registro_detalle"><b>Nit: </b>'+this.OBJ.tx_nit+'</p>';
        this.datos +='<p class="registro_detalle"><b>Razón Social: </b>'+this.OBJ.tx_razon_social+'</p>';
        this.datos +='<p class="registro_detalle"><b>Siglas: </b>'+this.OBJ.tx_siglas+'</p>';
        this.datos +='<p class="registro_detalle"><b>Clasificacion: </b>'+this.OBJ.tx_clasificacion+'</p>';
        this.datos += '<p class="registro_detalle"><b>Email: </b>'+this.OBJ.tx_email+'</p>';
        this.datos +='<p class="registro_detalle"><b>Web: </b>'+this.OBJ.tx_sitio_web+'</p>';
        this.datos +='<p class="registro_detalle"><b>Fecha de Registro: </b>'+this.OBJ.fe_registro+'</p>';
        //this.datos +='<p class="registro_detalle"><b>Fecha de Vencimiento: </b>'+this.OBJ.fe_vencimiento+'</p>';

        this.fieldDatos = new Ext.form.FieldSet({
                title: 'Proveedor',
                html: this.datos
        });

        this.datos2 = '<p class="registro_detalle"><b>Estado: </b>'+this.OBJ.nb_estado+'</p>';
        this.datos2 +='<p class="registro_detalle"><b>Municipio: </b>'+this.OBJ.nb_municipio+'</p>';
        this.datos2 +='<p class="registro_detalle"><b>Dirección: </b>'+this.OBJ.tx_direccion+'</p>';

        this.fieldDatos1 = new Ext.form.FieldSet({
                title: 'Direccion',
                html: this.datos2
        });

        this.datos3 = '<p class="registro_detalle"><b>Cédula: </b>'+this.OBJ.nb_representante_legal+'</p>';
        this.datos3 +='<p class="registro_detalle"><b>Nombre y Apellido: </b>'+this.OBJ.nu_cedula_representante+'</p>';
        this.datos3 +='<p class="registro_detalle"><b>Telefono Movil: </b>'+this.OBJ.tx_num_celular+'</p>';

        this.fieldDatos2 = new Ext.form.FieldSet({
                title: 'Representante Legal',
                html: this.datos3
        });

        this.formpanel = new Ext.form.FormPanel({
                bodyStyle: 'padding:10px',
                autoWidth:true,
                autoHeight:true,
                border:false,
                items:[
                        this.fieldDatos,this.fieldDatos1,this.fieldDatos2
                        ]
        });
        
        this.co_solicitud = new Ext.form.TextField({
                fieldLabel:'N° Solicitud',
                name:'co_solicitud',
                maskRe: /[0-9]/,
                value:'',
                width:100
        });
        
        this.co_tipo_solicitud = new Ext.form.ComboBox({
                fieldLabel:'Tipo Solicitud',
                store: this.storeCO_TIPO_TRAMITE,
                typeAhead: true,
                valueField: 'co_tipo_solicitud',
                displayField:'tx_tipo_solicitud',
                hiddenName:'co_tipo_solicitud',
                //readOnly:(this.OBJ.co_documento!='')?true:false,
                //style:(this.main.OBJ.co_documento!='')?'background:#c9c9c9;':'',
                forceSelection:true,
                resizable:true,
                triggerAction: 'all',
                emptyText:'...',
                selectOnFocus: true,
                mode: 'local',
                width:300,
                resizable:true,
                allowBlank:false
        });

        this.storeCO_TIPO_TRAMITE.load();
        
        this.fecha_inicio = new Ext.form.DateField({
                fieldLabel:'Fecha Desde',
                name:'fecha_inicio',
                allowBlank:false,
                width:100
        });
        
        this.fecha_fin = new Ext.form.DateField({
                fieldLabel:'Fecha Hasta',
                name:'fecha_fin',
                allowBlank:false,
                width:100
        });
        
        this.formFiltroPrincipal = new Ext.form.FormPanel({
            title:'Filtro Expediente',
            iconCls: 'icon-solpendiente',
            collapsible: true,
            titleCollapse: true,
            autoWidth:true,
            border:false,
            labelWidth: 110,
            padding:'10px',
            items   : [
                this.co_solicitud,
                this.co_tipo_solicitud,
                this.fecha_inicio,
                this.fecha_fin
            ],
            keys: [{
                        key:[Ext.EventObject.ENTER],
                        handler: function() {
                                 datos.main.aplicarFiltroByFormulario();
                        }}
            ],
            buttonAlign:'center',
            buttons:[
                {
                    text:'Consultar',
                    iconCls:'icon-buscar',
                    handler:function(){
                        datos.main.aplicarFiltroByFormulario();
                    }
                },
                {
                    text:'Limpiar',
                    iconCls:'icon-limpiar',
                    handler:function(){
                        datos.main.limpiarCamposByFormFiltro();
                    }
                }
            ]
        });
        
        
     
        function renderDocumento(val, attr, record) {

            if(val!=''){
                return '<a href="#" onclick="datos.main.getDatos()">Ver</a>'        
            }

        }
             
        this.gridPanel_ = new Ext.grid.GridPanel({
            title:'Expedientes',
            iconCls: 'icon-libro',
            store: this.store_lista,
            loadMask:true,
            height:340,
            columns: [
            new Ext.grid.RowNumberer(),
                {header: 'N° Solicitud', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud'},
                {header: 'Fecha', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'fe_solicitud'},
                {header: 'Tipo de Solicitud', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tipo_solicitud',renderer:textoLargo},
                {header: '', width:50,  menuDisabled:true, sortable: true,  dataIndex: 'co_solicitud',renderer: renderDocumento}
             ],
            stripeRows: true,
            autoScroll:true,
            stateful: true,
            listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){

            }},
            bbar: new Ext.PagingToolbar({
                pageSize: 15,
                store: this.store_lista,
                displayInfo: true,
                displayMsg: '<span style="color:white">Registros: {0} - {1} de {2}</span>',
                emptyMsg: "<span style=\"color:white\">No se encontraron registros</span>"
            })
        });

      

        this.store_lista.baseParams.co_proveedor = this.OBJ.co_proveedor;
        this.store_lista.load();

        this.panel = new Ext.Panel({
                border:false,
                items: [this.formFiltroPrincipal,this.gridPanel_]
        });
        

	this.tabuladores = new Ext.TabPanel({
		resizeTabs:true, // turn on tab resizing
		minTabWidth: 115,
		tabWidth:150,border:false,
		enableTabScroll:true,
		autoWidth:true,
		autoHeight:250,
		activeTab: 0,
		defaults: {autoScroll:true},
		items:[
			{
				title: 'Datos del Proveedor',
				items:[this.formpanel]
			},
                        {
				title: 'Expediente',
				items:[this.panel]
			}
	        
                        
                        
		]
	});

        this.tabuladores.render('detalle');    

 	},
        aplicarFiltroByFormulario: function(){
            //Capturamos los campos con su value para posteriormente verificar cual
            //esta lleno y trabajar en base a ese.
            var campo = datos.main.formFiltroPrincipal.getForm().getValues();

            datos.main.store_lista.baseParams={}

            var swfiltrar = false;
            for(campName in campo){
                if(campo[campName]!=''){
                    swfiltrar = true;
                    eval(" datos.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
                }
            }
            
            datos.main.store_lista.baseParams.co_proveedor = datos.main.OBJ.co_proveedor;
            if(swfiltrar==true){
                datos.main.store_lista.baseParams.BuscarBy = true;
               // datos.main.store_lista.baseParams.in_ventanilla = 'true';
                datos.main.store_lista.load();
            }else{
                Ext.MessageBox.show({
                           title: 'Notificación',
                           msg: 'Debe ingresar un parametro de busqueda',
                           buttons: Ext.MessageBox.OK,
                           icon: Ext.MessageBox.WARNING
                });
            }

	},
	limpiarCamposByFormFiltro: function(){
            datos.main.formFiltroPrincipal.getForm().reset();
            datos.main.store_lista.baseParams={}
            datos.main.store_lista.baseParams.co_proveedor = datos.main.OBJ.co_proveedor;
            datos.main.store_lista.load();
        }   
        ,getStoreCO_TIPO_TRAMITE:function(){
            this.store = new Ext.data.JsonStore({
                url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/storefkcotipotramite',
                root:'data',
                fields:[
                    {name: 'co_tipo_solicitud'},
                    {name: 'tx_tipo_solicitud'}
                    ]
            });
            return this.store;
        },
        getLista: function(){
            this.store = new Ext.data.JsonStore({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Proveedor/storelistaExpediente',
            root:'data',
            fields:[
                    {name: 'co_proveedor'},
                    {name: 'co_solicitud'},
                    {name: 'fe_solicitud'},
                    {name: 'tx_tipo_solicitud'}
                ]
            });
            return this.store;
        },
        getDatos: function(){        
            window.open("http://<?php echo $_SERVER['SERVER_NAME']; ?>/proadmin/web/reportes/Expediente.php?co_solicitud="+datos.main.gridPanel_.getSelectionModel().getSelected().get('co_solicitud'));  
        }
}
Ext.onReady(datos.main.init, datos.main);
</script>
<div id="contenedor"></div>