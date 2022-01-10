<script type="text/javascript">
Ext.ns("InmLista");
InmLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){

this.storeLIST_CLASIFICACION = this.getStoreLIST_CLASIFICACION();
this.storeLIST_TIPO = this.getStoreLIST_TIPO();

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
//this.store_lista = this.getLista();
this.store_lista = this.getStoreCO_BIENES();
//Agregar un registro

this.tx_descripcion = new Ext.form.TextField({
    fieldLabel:'Denominación',
    labelStyle: 'width:120px',
    name:'bien',
    allowBlank:true,
    width:600
});

this.tx_detalle = new Ext.form.TextField({
    fieldLabel:'Detalle',
    labelStyle: 'width:120px',
    name:'denominacion',
    allowBlank:true,
    width:600
});

this.tx_codigo = new Ext.form.TextField({
    fieldLabel:'Numero Bien',
    labelStyle: 'width:120px',
    name:'numero',
    allowBlank:true,
    width:600
});


this.list_clasificacion = new Ext.form.ComboBox({
    fieldLabel:'Clasificacion',
     labelStyle: 'width:120px',
    store: this.storeLIST_CLASIFICACION,
    typeAhead: true,
    valueField: 'co_clasificacion_inmueble',
    displayField:'tx_clasificacion_inmueble',
    hiddenName:'co_clasificacion_inmueble',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Clasificacion',
    selectOnFocus: true,
    mode: 'local',
    width:600,
    resizable:true,
    allowBlank:true


});
this.storeLIST_CLASIFICACION.load();

this.list_tipo = new Ext.form.ComboBox({
    fieldLabel:'Tipo',
     labelStyle: 'width:120px',
    store: this.storeLIST_TIPO,
    typeAhead: true,
    valueField: 'co_tipo_inmueble',
    displayField:'tx_tipo_inmueble',
    hiddenName:'co_tipo_inmueble',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Tipo',
    selectOnFocus: true,
    mode: 'local',
    width:600,
    resizable:true,
    allowBlank:true


});
this.storeLIST_TIPO.load();



this.fieldDatosTipo= new Ext.Panel({
    width:1000,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.list_clasificacion]},
                 {items:[this.list_tipo]}
                           ]}]
            
                   });

this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       height:250,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[this.tx_descripcion,
                            this.tx_detalle,
                            this.list_clasificacion,
                            this.list_tipo,
                            this.tx_codigo  ]
               }
            ]
    });

    this.panelfiltro = new Ext.form.FormPanel({
        frame:true,
        autoWidth:true,
        border:false,
        items:[
            this.tabpanelfiltro
        ]
    });
//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroBienes');
        InmLista.main.mascara.show();
        InmLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/filtro',
             scripts: true
        });
    }
});


this.movimientos= new Ext.Button({
    text:'Lista Movimientos',
    iconCls: 'icon-reporteest',
    handler:function(){
//  this.codigo  = InmLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
//  InmLista.main.mascara.show();
        this.msg = Ext.get('formularioMovimientos');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/movimientos',
            params:{
             codigo: InmLista.main.gridPanel_.getSelectionModel().getSelected().get('co_bienes')
         },
         scripts: true,
         text: "Cargando.."
        });
    }
});

this.agregar= new Ext.Button({
    text:'Agregar ubicación',
    iconCls: 'icon-add',
    handler:function(){
                           
                           if(InmLista.main.list_ubicacion.getValue()){
                            InmLista.main.store_listaubi.load({
                          params:{
                                 co_organigrama:InmLista.main.list_ubicacion.getValue()
                                },callback:function(records,operation,success){
                                    var f = '';
                                    var c = '';
                                    var i= 1;
                                    this.each(function(record,index){
                                        if(i==1){
                                            f=record.data.cod_adm;
                                            c=record.data.cod_cia;
                                            i--;
                                        }
                                       
                                    },this);
                                        InmLista.main.tx_ubicacion.setValue(f);
                                        InmLista.main.tx_cia.setValue(c);
                                }

                            });
                            InmLista.main.storeLIST_UBICACION.load({
                                params:{
                                 co_organigrama:InmLista.main.list_ubicacion.getValue()
                                },

                            });
                            InmLista.main.organigrama.setValue(InmLista.main.list_ubicacion.getValue());
                            InmLista.main.list_ubicacion.setValue('');

                            
                            }

                            



                    }
});
this.limpiar= new Ext.Button({
    text:'Limpiar',
    iconCls: 'icon-limpiar',
    handler:function(){
        InmLista.main.limpiarCamposByFormFiltro();
    }
});

this.buscar= new Ext.Button({
    text:'Buscar',
    iconCls: 'icon-buscar',
    handler:function(){
        InmLista.main.aplicarFiltroByFormulario();
    }
});


function renderIncorporado(val, attr, record) {    

    return val 
  
}
//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Bienes',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.buscar,'-',this.limpiar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
   {header: 'co_bienes', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_bienes'},    
            {header: 'Numero',width:80, menuDisabled:true,sortable: true,dataIndex: 'nu_bienes',renderer: renderIncorporado},
            {header: 'Denominacion',width:300, menuDisabled:true,sortable: true,dataIndex: 'tx_detalle',renderer: renderIncorporado},
            {header: 'Detalle',width:300, menuDisabled:true,sortable: true,dataIndex: 'desc_inm',renderer: renderIncorporado},
            {header: 'Tipo',width:100, menuDisabled:true,sortable: true,dataIndex: 'tx_tipo_inmueble',renderer: renderIncorporado},
            {header: 'Clasificación',width:300, menuDisabled:true,sortable: true,dataIndex: 'tx_clasificacion_inmueble',renderer: renderIncorporado},
            {header: 'Direccion',width:500, menuDisabled:true,sortable: true,dataIndex: 'tx_direccion',renderer: renderIncorporado},


    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    }),
  	sm: new Ext.grid.RowSelectionModel({
  		singleSelect: true,
  		/*AQUI ES DONDE ESTA EL LISTENER*/
  			listeners: {
  			rowselect: function(sm, row, rec) {
                                              var msg = Ext.get('detalle');
                                              msg.load({
                                                      url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/detalleinm',
                                                      scripts: true,
                                                      params: {
                                                        codigo:InmLista.main.gridPanel_.getSelectionModel().getSelected().get('co_bienes')
                                                      },
                                                      text: 'Cargando...'
                                              });
  				if(panel_detalle.collapsed == true)
  				{
  				panel_detalle.toggleCollapse();
  				}
  			}
  		}
  	})
});
this.panel = new Ext.Panel({
//	title: 'Lista de contribuyente',
	border:false,
	items: [this.panelfiltro,this.gridPanel_]
});

this.panel.render("contenedorInmLista");
//this.gridPanel_.render("contenedorInmLista");

this.store_lista.load();
this.store_lista.on('beforeload',function(){
panel_detalle.collapse();
});
},getStoreCO_BIENES:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefkcoinmueblelista',
        root:'data',
        fields:[
            {name: 'co_bienes'},
            {name: 'nu_bienes'},
            {name: 'tx_detalle'},
            {name: 'tx_direccion'},
            {name: 'desc_inm'},
            {name: 'tx_clasificacion_inmueble'},
            {name: 'tx_tipo_inmueble'},
            ]
    });
    return this.store;
},getStoreLIST_CLASIFICACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefklistclasificacion',
        root:'data',
        fields:[
            {name: 'co_clasificacion_inmueble'},
            {name: 'tx_clasificacion_inmueble'}
            
            ]
    });
    return this.store;
},getStoreLIST_TIPO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefklisttipo',
        root:'data',
        fields:[
            {name: 'co_tipo_inmueble'},
            {name: 'tx_tipo_inmueble'}
            
            ]
    });
    return this.store;
},limpiarCamposByFormFiltro: function(){
    InmLista.main.panelfiltro.getForm().reset();
    InmLista.main.store_lista.baseParams={}
    InmLista.main.store_lista.baseParams.paginar = 'si';
    InmLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = InmLista.main.panelfiltro.getForm().getValues();
    InmLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("InmLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        InmLista.main.store_lista.baseParams.paginar = 'si';
        InmLista.main.store_lista.baseParams.BuscarBy = true;
        InmLista.main.store_lista.load();


}
};
Ext.onReady(InmLista.main.init, InmLista.main);
</script>
<div id="contenedorInmLista"></div>
<div id="formularioMovimientos"></div>
<div id="filtroBienes"></div>
