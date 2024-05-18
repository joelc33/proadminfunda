<script type="text/javascript">
Ext.ns("BienesLista");
BienesLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){


this.storeLIST_UBICACION=this.getStoreLIST_UBICACION();
this.store_listaubi=this.getStoreLIST_UBICACION2();


//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
//this.store_lista = this.getLista();
this.store_lista = this.getStoreCO_BIENES();
//Agregar un registro

this.organigrama = new Ext.form.Hidden({
    name:'organigrama'});

this.list_ubicacion = new Ext.form.ComboBox({
    fieldLabel:'Ubicaciones',
    store: this.storeLIST_UBICACION,
    typeAhead: true,
    labelStyle: 'width:120px',
    valueField: 'co_organigrama',
    displayField:'tx_organigrama',
    hiddenName:'co_organigrama',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Ubicacion',
    selectOnFocus: true,
    mode: 'local',
    width:250,
    resizable:true,
    allowBlank:true,});
this.storeLIST_UBICACION.load();

this.tx_ubicacion = new Ext.form.TextField({
    fieldLabel:'Codigo',
    labelStyle: 'width:120px',
    name:'tx_ubicacion',
    allowBlank:true,
    width:250
});

this.tx_cia = new Ext.form.TextField({
    fieldLabel:'Codigo CIA',
    labelStyle: 'width:120px',
    name:'tx_cia',
    allowBlank:true,
    width:250
});

this.tx_codigo = new Ext.form.TextField({
    fieldLabel:'Numero Bien',
    labelStyle: 'width:120px',
    name:'numero',
    allowBlank:true,
    width:250
});

this.tx_ubicacion.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            if(BienesLista.main.tx_ubicacion.getValue() && BienesLista.main.tx_cia.getValue() ){
                            BienesLista.main.store_listaubi.load({
                            params:{
                                tx_ubicacion:BienesLista.main.tx_ubicacion.getValue(),
                                tx_cia:BienesLista.main.tx_cia.getValue()
                                },

                            });
                            BienesLista.main.storeLIST_UBICACION.load({
                                params:{
                                    tx_ubicacion:BienesLista.main.tx_ubicacion.getValue(),
                                    tx_cia:BienesLista.main.tx_cia.getValue()
                                },

                            });
                            BienesLista.main.organigrama.setValue(BienesLista.main.list_ubicacion.getValue());
                            BienesLista.main.list_ubicacion.setValue('');

                            
                            }

                        }
                    }, this);
                        
    this.tx_ubicacion.on('blur',function(){
        if(BienesLista.main.tx_ubicacion.getValue() && BienesLista.main.tx_cia.getValue() ){
                            BienesLista.main.store_listaubi.load({
                          params:{
                            tx_ubicacion:BienesLista.main.tx_ubicacion.getValue(),
                                tx_cia:BienesLista.main.tx_cia.getValue()
                                },

                            });
                            BienesLista.main.storeLIST_UBICACION.load({
                                params:{
                                    tx_ubicacion:BienesLista.main.tx_ubicacion.getValue(),
                                    tx_cia:BienesLista.main.tx_cia.getValue()
                                },

                            });
                            BienesLista.main.organigrama.setValue(BienesLista.main.list_ubicacion.getValue());
                            BienesLista.main.list_ubicacion.setValue('');

                            
                            }
                    });


this.fieldDatosUbicacion= new Ext.Panel({
    width:1500,
    border:false,
    buttonAlign:'center',
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.4, border:false},
          
          items:[{items:[this.tx_cia]},{items:[this.tx_ubicacion]},{items:[this.list_ubicacion]},{items:[this.tx_codigo]}],
         
          }
          
          
          ]
        
            
                   });

                   this.gridPanel2 = new Ext.grid.GridPanel({
    title:'Lista de ubicacion',
    iconCls: 'icon-libro',
    store: this.store_listaubi,
    loadMask:true,
    border:true,   
//    frame:true,
width:900,
    height:150,
    columns: [
    new Ext.grid.RowNumberer(),
   {header: 'co_organigrama', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_organigrama'},    
            {header: 'Ubicación',width:500, menuDisabled:true,sortable: true,dataIndex: 'tx_organigrama'},
            {header: 'Nivel Jerargico',width:80, menuDisabled:true,sortable: true,dataIndex: 'nu_nivel'},
            {header: 'Codigo',width:80, menuDisabled:true,sortable: true,dataIndex: 'cod_adm'},
            {header: 'Codigo CIA',width:80, menuDisabled:true,sortable: true,dataIndex: 'cod_cia'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true
});


this.fieldDatosGrid= new Ext.form.FieldSet({
    items:[this.gridPanel2]
});

this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       height:250,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[this.organigrama,
                         this.fieldDatosUbicacion,
                          this.fieldDatosGrid]
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
        BienesLista.main.mascara.show();
        BienesLista.main.filtro.setDisabled(true);
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
//  this.codigo  = BienesLista.main.gridPanel_.getSelectionModel().getSelected().get('id');
//  BienesLista.main.mascara.show();
        this.msg = Ext.get('formularioMovimientos');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/movimientos',
            params:{
             codigo: BienesLista.main.gridPanel_.getSelectionModel().getSelected().get('co_bienes')
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
                           
                           if(BienesLista.main.list_ubicacion.getValue()){
                            BienesLista.main.store_listaubi.load({
                          params:{
                                 co_organigrama:BienesLista.main.list_ubicacion.getValue()
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
                                        BienesLista.main.tx_ubicacion.setValue(f);
                                        BienesLista.main.tx_cia.setValue(c);
                                }

                            });
                            BienesLista.main.storeLIST_UBICACION.load({
                                params:{
                                 co_organigrama:BienesLista.main.list_ubicacion.getValue()
                                },

                            });
                            BienesLista.main.organigrama.setValue(BienesLista.main.list_ubicacion.getValue());
                            BienesLista.main.list_ubicacion.setValue('');

                            
                            }

                            



                    }
});
this.limpiar= new Ext.Button({
    text:'Limpiar',
    iconCls: 'icon-limpiar',
    handler:function(){
        BienesLista.main.store_listaubi.removeAll();
        BienesLista.main.storeLIST_UBICACION.load();
        BienesLista.main.limpiarCamposByFormFiltro();
    }
});

this.buscar= new Ext.Button({
    text:'Buscar',
    iconCls: 'icon-buscar',
    handler:function(){
        BienesLista.main.aplicarFiltroByFormulario();
    }
});


function renderIncorporado(val, attr, record) {    
    
        
    if(record.data.activo=="ACTIVO")
    {
        return val     
        
    }else
    {
      if(record.data.incorporado=="DESINCORPORADO"){
       return '<p style="color:#8A0000">'+val+'</p>'  
      }else{
        return '<p style="color:red">'+val+'</p>' 

       }

    }


    
            
  
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
        this.filtro,'-',this.movimientos,'-',this.agregar,'-',this.limpiar,'-',this.buscar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
   {header: 'co_bienes', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_bienes'},    
            {header: 'Numero',width:80, menuDisabled:true,sortable: true,dataIndex: 'nu_bienes',renderer: renderIncorporado},
            {header: 'Marca',width:80, menuDisabled:true,sortable: true,dataIndex: 'tx_marca',renderer: renderIncorporado},
            {header: 'Modelo',width:80, menuDisabled:true,sortable: true,dataIndex: 'tx_modelo',renderer: renderIncorporado},
            {header: 'Detalle',width:300, menuDisabled:true,sortable: true,dataIndex: 'tx_detalle',renderer: renderIncorporado},
            {header: 'Ubicacion',width:200, menuDisabled:true,sortable: true,dataIndex: 'tx_organigrama',renderer: renderIncorporado},
            {header: 'Numero Factura',width:100, menuDisabled:true,sortable: true,dataIndex: 'nu_factura',renderer: renderIncorporado},
            {header: 'Orden de Pago',width:100, menuDisabled:true,sortable: true,dataIndex: 'tx_odp',renderer: renderIncorporado},

            {header: 'Producto',width:300, menuDisabled:true,sortable: true,dataIndex: 'tx_producto',renderer: renderIncorporado},
            {header: 'Estatus',width:100, menuDisabled:true,sortable: true,dataIndex: 'activo',renderer: renderIncorporado},
            {header: 'Incorporado',width:120, menuDisabled:true,sortable: true,dataIndex: 'incorporado',renderer: renderIncorporado},
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
                                                      url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/detallebienes',
                                                      scripts: true,
                                                      params: {
                                                        codigo:BienesLista.main.gridPanel_.getSelectionModel().getSelected().get('co_bienes')
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

this.panel.render("contenedorBienesLista");
//this.gridPanel_.render("contenedorBienesLista");

this.store_lista.load();
this.store_lista.on('beforeload',function(){
panel_detalle.collapse();
});
},getStoreCO_BIENES:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefkcobieneslista',
        root:'data',
        fields:[
            {name: 'co_bienes'},
            {name: 'nu_bienes'},
            {name: 'tx_serial'},
            {name: 'tx_detalle'},
            {name: 'tx_marca'},
            {name: 'tx_modelo'},
            {name: 'tx_organigrama'},
            {name: 'nu_factura'},
            {name: 'tx_producto'},
            {name: 'tx_odp'},
            {name: 'activo'},
            {name: 'incorporado'}
            ]
    });
    return this.store;
},getStoreLIST_UBICACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefklistubicacion',
        root:'data',
        fields:[
            {name: 'co_organigrama'},
            {name: 'tx_organigrama',
            convert:function(v,r){
                return r.cod_adm+' - '+r.tx_organigrama;
            }
            },
//            {name: 'tx_organigrama'},
            {name: 'co_padre'},
            {name: 'nu_nivel'},
            {name: 'tx_punto_referencia'},
            {name: 'cod_adm'},
            {name: 'cod_cia'}
            
            ]
    });
    return this.store;
},getStoreLIST_UBICACION2:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefkubicacion2',
        root:'data',
        fields:[
            {name: 'co_organigrama'},
            {name: 'tx_organigrama'},
            {name: 'co_padre'},
            {name: 'nu_nivel'},
            {name: 'tx_punto_referencia'},
            {name: 'cod_adm'},
            {name: 'cod_cia'}
            
            ]
    });
    return this.store;
},limpiarCamposByFormFiltro: function(){
    BienesLista.main.panelfiltro.getForm().reset();
    BienesLista.main.store_lista.baseParams={}
    BienesLista.main.store_lista.baseParams.paginar = 'si';
    BienesLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = BienesLista.main.panelfiltro.getForm().getValues();
    BienesLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("BienesLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        BienesLista.main.store_lista.baseParams.paginar = 'si';
        BienesLista.main.store_lista.baseParams.BuscarBy = true;
        BienesLista.main.store_lista.load();


}
};
Ext.onReady(BienesLista.main.init, BienesLista.main);
</script>
<div id="contenedorBienesLista"></div>
<div id="formularioMovimientos"></div>
<div id="filtroBienes"></div>
