<script type="text/javascript">

    Ext.ns("Detalle");

    Detalle.main = {

         init: function (){

            this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

            this.store_lista = this.getLista();

            this.formulario= new Ext.Button({
                 text:'Cargar Datos',
                 iconCls: 'icon-cambio',
                 handler:function(){
                     this.msg = Ext.get('agregarDatos');
                     this.msg.load({
                      url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/cargarDatos",
                      scripts: true,
                      text: "Cargando..",
                      params:{
                            co_solicitud:Detalle.main.OBJ.co_solicitud,
                            co_tipo_solicitud: Detalle.main.OBJ.co_tipo_solicitud,
                            co_proceso: Detalle.main.OBJ.co_proceso 
                      }
                     });
                 }
            });
             
            this.documento= new Ext.Button({
                text:'Agregar Doc.',
                iconCls: 'icon-capacitacion',
                handler: function(){
                    this.msg = Ext.get('agregarDatos');
                    this.msg.load({
                        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/agregarDocumento',
                        scripts: true,
                        params:{
                                co_solicitud:Detalle.main.OBJ.co_solicitud,
                                tipo:Detalle.main.OBJ.tx_tipo_solicitud,
                                estado:Detalle.main.OBJ.tx_estatus,
                                co_ruta:Detalle.main.OBJ.co_ruta
                        },
                        text: "Cargando.."
                    });
                }
            });
             
            this.foto= new Ext.Button({
                text:'Agregar Imagen',
                iconCls: 'icon-subirImagen',
                handler: function(){
                    this.msg = Ext.get('agregarDatos');
                    this.msg.load({
                        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/agregarImagen',
                        scripts: true,
                        params:{
                                co_solicitud:Detalle.main.OBJ.co_solicitud,
                                tipo:Detalle.main.OBJ.tx_tipo_solicitud,
                                estado:Detalle.main.OBJ.tx_estatus,
                                co_ruta:Detalle.main.OBJ.co_ruta
                        },
                        text: "Cargando.."
                    });
                }
            });
             
            function renderDatos(val, attr, record) {

                if(val!=''){
                    return '<a href="#" onclick="Detalle.main.getDatos()">Ver Datos</a>'        
                }

            }
            function renderDocumento(val, attr, record) {

                if(val!=''){
                    return '<a href="#" onclick="Detalle.main.getDocumento()">Ver Documento</a>'        
                }

            }

            function renderImagen(val, attr, record) {

                if(val!=''){
                    return '<a href="#" onclick="Detalle.main.getImagen()">Ver Imagen</a>'        
                }

            }
                 
            this.gridPanel_ = new Ext.grid.GridPanel({
                title:'Ruta del Tramite',
                iconCls: 'icon-libro',
                store: this.store_lista,
                loadMask:true,
              //  tbar:[this.formulario,'-',this.foto,'-',this.documento],
                height:300,
                columns: [
                new Ext.grid.RowNumberer(),
                    {header: 'co_ruta',hidden:true, menuDisabled:true,dataIndex: 'co_ruta'},
                    {header: 'Proceso', width:130,  menuDisabled:true, sortable: true,  dataIndex: 'tx_proceso',renderer:textoLargo},
                    {header: 'Estatus', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'tx_estatus'},
                    {header: 'Datos', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'in_reporte',renderer: renderDatos},
                    {header: 'Documento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_cargar_documento',renderer: renderDocumento},
                    {header: 'Imagen', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'in_cargar_imagen',renderer: renderImagen},
                ],
                stripeRows: true,
                autoScroll:true,
                stateful: true,
                listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
                        
                         Detalle.main.observacion.setValue('<p class="registro_detalle">'+Detalle.main.gridPanel_.getSelectionModel().getSelected().get('tx_observacion')+'</p>');
                         Detalle.main.fe_recepcion.setValue('<p class="registro_detalle">'+Detalle.main.gridPanel_.getSelectionModel().getSelected().get('fe_recepcion')+'</p>');

                }},
                bbar: new Ext.PagingToolbar({
                    pageSize: 10,
                    store: this.store_lista,
                    displayInfo: true,
                    displayMsg: '<span style="color:white">Registros: {0} - {1} de {2}</span>',
                    emptyMsg: "<span style=\"color:white\">No se encontraron registros</span>"
                })
            });
               
            this.gridPanel_.render("contenedorT31RutaLista");
            
            this.observacion = new Ext.form.DisplayField({
                        fieldLabel:'<b>Observación </b>',
                        value:'<p class="registro_detalle"><b></b></p>'
            });

            this.fe_recepcion = new Ext.form.DisplayField({
                        fieldLabel:'<b>Recepción </b>',
                        value:'<p class="registro_detalle"><b></b></p>'
            });                       
            
            this.fieldDatos = new Ext.form.FieldSet({
                    title: 'Detalle Ruta del Tramite',
                    items:[this.fe_recepcion,this.observacion]
            });

            this.panel = new Ext.Panel({
                title:'Detalle de la Ruta',
                items:[this.fieldDatos]
            });
            
            this.panel.render("detalleTramite")
               
            this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
            this.store_lista.load();

         },
        getLista: function(){
            this.store = new Ext.data.JsonStore({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/storelistaRutaAnular',
            root:'data',
            fields:[
                    {name: 'co_ruta'},
                    {name: 'tx_proceso'},
                    {name: 'tx_estatus'},
                    {name: 'in_cargar_dato'},
                    {name: 'in_cargar_documento'},
                    {name: 'in_cargar_imagen'},
                    {name: 'fe_recepcion'},
                    {name: 'tx_observacion'},
                    {name: 'in_cargar_imagen'},
                    {name: 'in_reporte'}
                ]
            });
            return this.store;
        },
        getDatos: function(){        
            window.open("http://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']; ?>/reporte/index/i/"+Detalle.main.gridPanel_.getSelectionModel().getSelected().get('co_ruta'));  
        },
        getImagen: function(){
                this.msg = Ext.get('formularioImagen');
                this.msg.load({
                 url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/imagen",
                 scripts: true,
                 text: "Cargando..",
                 params:{
                            co_ruta:Detalle.main.OBJ.co_ruta
                        }
                });  
        },
        getDocumento: function(){
                window.open("<?php echo $_SERVER['SCRIPT_NAME']; ?>/reporte/documento/i/"+Detalle.main.OBJ.co_ruta_encrip);
        }
    }
    Ext.onReady(Detalle.main.init,Detalle.main);
</script>
<div id="contenedorT31RutaLista"></div>
<div id="agregarDatos"></div>
<div id="detalleTramite"></div>
<div id="formularioImagen"></div>
