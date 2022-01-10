<script type="text/javascript">

    Ext.ns("Detalle");

    Detalle.main = {

         init: function (){

            this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

            this.store_lista = this.getLista();


            this.formulario= new Ext.Button({
                 text:'Responder Revisión',
                 iconCls: 'icon-volver',
                 handler:function(){
                     this.msg = Ext.get('agregarDatos');
                     this.msg.load({
                      url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/Revision/responderRevision",
                      scripts: true,
                      text: "Cargando..",
                      params:{
                          co_revision:Detalle.main.OBJ.co_revision
                      }
                     });
                 }
             });
                 
            this.gridPanel_ = new Ext.grid.GridPanel({
                title:'Ruta del Tramite',
                iconCls: 'icon-libro',
                store: this.store_lista,
                loadMask:true,
                tbar:[this.formulario],
                height:300,
                columns: [
                new Ext.grid.RowNumberer(),
                    {header: 'co_ruta',hidden:true, menuDisabled:true,dataIndex: 'co_ruta'},
                    {header: 'Proceso', width:130,  menuDisabled:true, sortable: true,  dataIndex: 'tx_proceso'},
                    {header: 'Estatus', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'tx_estatus'},
                ],
                stripeRows: true,
                autoScroll:true,
                stateful: true,
                listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){

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
               
            this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
            this.store_lista.load();

         },
        getLista: function(){
            this.store = new Ext.data.JsonStore({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/storelistaRuta',
            root:'data',
            fields:[
                    {name: 'co_ruta'},
                    {name: 'tx_proceso'},
                    {name: 'tx_estatus'}
                ]
            });
            return this.store;
        }
    }

    Ext.onReady(Detalle.main.init,Detalle.main);

</script>
<div id="contenedorT31RutaLista"></div>
<div id="agregarDatos"></div>
