<script type="text/javascript">
Ext.ns("listaProducto");
listaProducto.main = {
init:function(){

this.storeLIST_UBICACION_FILTRO=this.getStoreLIST_UBICACION_FILTRO();
this.store_listaubi_filtro=this.getStoreLIST_UBICACION_FILTRO2();

this.storeLIST_UBICACION=this.getStoreLIST_UBICACION();
this.store_listaubi=this.getStoreLIST_UBICACION2();
this.store_LIST_USO=this.getStoreLIST_USO();
this.storeLIST_RIF2 = this.getStoreLIST_RIF2();

this.store_lista = this.getStoreCO_BIENES();

this.co_bienes = new Ext.form.Hidden({
    name:'co_bienes'
});

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:BienesDesincorporacion.main.co_solicitud.getValue()
});


this.tx_codigo = new Ext.form.TextField({
	fieldLabel:'Numero Bien',
	name:'numero',
	allowBlank:true,
	width:270
});


this.tx_serial = new Ext.form.TextField({
    fieldLabel:'Serial Bien',
    name:'serial',
    allowBlank:false,
    width:270
});

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Detalle Bien',
	name:'bien',
	allowBlank:true,
	width:670
});
//--------------------------------------------GRID DE UBICAION PARA FILTRAR-------------------------------
this.organigramaf = new Ext.form.Hidden({
    name:'organigramaf'});
this.list_ubicacion_filtro = new Ext.form.ComboBox({
    fieldLabel:'Ubicaciones',
    store: this.storeLIST_UBICACION_FILTRO,
    typeAhead: true,
    labelStyle: 'width:120px',
    valueField: 'co_organigrama',
    //displayField:'tx_organigrama',
    displayField:'descripcion',
    hiddenName:'co_organigrama',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Ubicacion',
    selectOnFocus: true,
    mode: 'local',
    width:250,
    resizable:true,
    allowBlank:true
    });
this.storeLIST_UBICACION_FILTRO.load();

this.tx_ubicacion2 = new Ext.form.TextField({
    fieldLabel:'Codigo',
    labelStyle: 'width:120px',
    name:'tx_ubicacion',
    allowBlank:true,
    width:200
});

this.tx_cia2= new Ext.form.TextField({
    fieldLabel:'Codigo CIA',
    labelStyle: 'width:120px',
    name:'tx_cia',
    allowBlank:true,
    width:200
});
this.tx_ubicacion2.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            if(listaProducto.main.tx_ubicacion2.getValue() && listaProducto.main.tx_cia2.getValue() ){
                            listaProducto.main.store_listaubi_filtro.load({
                            params:{
                                tx_ubicacion:listaProducto.main.tx_ubicacion2.getValue(),
                                tx_cia:listaProducto.main.tx_cia2.getValue()
                                },callback:function(records,operation,success){
                                    var f = '';
                                    var i= 1;
                                    this.each(function(record,index){
                                        if(i==1){
                                            f=record.data.co_organigrama;
                                            i--;
                                        }
                                       
                                    },this);
                                    listaProducto.main.organigramaf.setValue(f);
                                }

                            });
                            listaProducto.main.storeLIST_UBICACION_FILTRO.load({
                                params:{
                                    tx_ubicacion:listaProducto.main.tx_ubicacion2.getValue(),
                                    tx_cia:listaProducto.main.tx_cia2.getValue()
                                },

                            });
                            listaProducto.main.organigramaf.setValue(listaProducto.main.list_ubicacion_filtro.getValue());
                            listaProducto.main.list_ubicacion_filtro.setValue('');
                            
                            }

                        }
                    }, this);
                        
    this.tx_ubicacion2.on('blur',function(){
        if(listaProducto.main.tx_ubicacion2.getValue() && listaProducto.main.tx_cia2.getValue() ){
                            listaProducto.main.store_listaubi_filtro.load({
                            params:{
                                tx_ubicacion:listaProducto.main.tx_ubicacion2.getValue(),
                                tx_cia:listaProducto.main.tx_cia2.getValue()
                                },callback:function(records,operation,success){
                                    var f = '';
                                    var i= 1;
                                    this.each(function(record,index){
                                        if(i==1){
                                            f=record.data.co_organigrama;
                                            i--;
                                        }
                                       
                                    },this);
                                    listaProducto.main.organigramaf.setValue(f);
                                }

                            });
                            listaProducto.main.storeLIST_UBICACION_FILTRO.load({
                                params:{
                                    tx_ubicacion:listaProducto.main.tx_ubicacion2.getValue(),
                                    tx_cia:listaProducto.main.tx_cia2.getValue()
                                },

                            });
                            listaProducto.main.organigramaf.setValue(listaProducto.main.list_ubicacion_filtro.getValue());
                            listaProducto.main.list_ubicacion_filtro.setValue('');
                            }
                    });


this.fieldDatosUbicacionF= new Ext.Panel({
    width:1000,
    border:false,
    buttonAlign:'center',
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.4, border:false},
          
          items:[{items:[this.tx_cia2]},{items:[this.tx_ubicacion2]},{items:[this.list_ubicacion_filtro]}],
         
          }
          
          
          ]
        
            
                   });

                   this.agregarubif= new Ext.Button({
    text:'Agregar ubicación',
    iconCls: 'icon-add',
    handler:function(){
                           
                           if(listaProducto.main.list_ubicacion_filtro.getValue()){
                            listaProducto.main.store_listaubi_filtro.load({
                          params:{
                                 co_organigrama:listaProducto.main.list_ubicacion_filtro.getValue()
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
                                        listaProducto.main.tx_ubicacion2.setValue(f);
                                        listaProducto.main.tx_cia2.setValue(c);
                                }

                            });
                            listaProducto.main.storeLIST_UBICACION_FILTRO.load({
                                params:{
                                 co_organigrama:listaProducto.main.list_ubicacion_filtro.getValue()
                                },

                            });
                            listaProducto.main.organigramaf.setValue(listaProducto.main.list_ubicacion_filtro.getValue());
                            listaProducto.main.list_ubicacion_filtro.setValue('');

                            
                            }
                            listaProducto.main.confirmarFormulario();
                            if( listaProducto.main.co_bienes.getValue()){
                                listaProducto.main.guardar.enable();
                            }else{
                                listaProducto.main.guardar.disable();
                            }
                                    }
});
this.limpiarf= new Ext.Button({
    text:'Limpiar',
    iconCls: 'icon-limpiar',
    handler:function(){
        listaProducto.main.store_listaubi_filtro.removeAll();
        listaProducto.main.storeLIST_UBICACION_FILTRO.load();
        listaProducto.main.organigramaf.setValue('');
        listaProducto.main.tx_ubicacion2.setValue('');
        listaProducto.main.tx_cia2.setValue('');

    }
});

this.gridPanelF = new Ext.grid.GridPanel({
    title:'Lista de ubicacion',
    iconCls: 'icon-libro',
    store: this.store_listaubi_filtro,
    loadMask:true,
    border:true,   
//    frame:true,
width:750,
    height:150,
    tbar:[
        this.agregarubif,'-',this.limpiarf],
    columns: [
    new Ext.grid.RowNumberer(),
   {header: 'co_organigrama', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_organigrama'},    
            {header: 'Ubicación',width:450, menuDisabled:true,sortable: true,dataIndex: 'tx_organigrama'},
            {header: 'Nivel Jerargico',width:80, menuDisabled:true,sortable: true,dataIndex: 'nu_nivel'},
            {header: 'Codigo',width:80, menuDisabled:true,sortable: true,dataIndex: 'cod_adm'},
            {header: 'Codigo CIA',width:80, menuDisabled:true,sortable: true,dataIndex: 'cod_cia'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true
});


this.fieldDatosGridF= new Ext.form.FieldSet({
    title:'Ubicación',
    items:[this.fieldDatosUbicacionF,
          this.gridPanelF]
});
//---------------------------------------------FIN GRID DE UBICACION PARA FILTRO----------------
//---------------------------------------------INICIO GRID DE UBICACION FUTURA--------------
this.organigrama = new Ext.form.Hidden({
    name:'organigrama'});
this.list_ubicacion = new Ext.form.ComboBox({
    fieldLabel:'Ubicaciones',
    store: this.storeLIST_UBICACION,
    typeAhead: true,
    labelStyle: 'width:120px',
    valueField: 'co_organigrama',
    //displayField:'tx_organigrama',
    displayField:'descripcion',
    hiddenName:'co_organigrama',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Ubicacion',
    selectOnFocus: true,
    mode: 'local',
    width:250,
    resizable:true,
    allowBlank:true,
    listeners: {
                   'select': function(combo, rec, index){ 
                    listaProducto.main.list_uso.setValue('');                        
                    listaProducto.main.store_LIST_USO.load({
                        params:{
                            co_ubicacion:rec.get('co_organigrama')
                        }
                    });                        
                        }
                    }  
    });
this.storeLIST_UBICACION.load();

this.list_uso = new Ext.form.ComboBox({
    fieldLabel:'Función',
    store: this.store_LIST_USO,
    typeAhead: true,
    valueField: 'co_uso',
    displayField:'tx_uso',
    hiddenName:'co_uso',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Uso',
    selectOnFocus: true,
    mode: 'local',
    width:250,
    resizable:true,
    allowBlank:false,
    listeners:{
        'select': function(combo, rec, index){ 
            if(listaProducto.main.co_bienes){
                                listaProducto.main.guardar.enable();
                            }else{
                                listaProducto.main.guardar.disable();
                            }
        }
        
    }});


this.tx_ubicacion = new Ext.form.TextField({
    fieldLabel:'Codigo',
    labelStyle: 'width:120px',
    name:'tx_ubicacion',
    allowBlank:true,
    width:200
});


this.tx_cia = new Ext.form.TextField({
    fieldLabel:'Codigo CIA',
    labelStyle: 'width:120px',
    name:'tx_cia',
    allowBlank:true,
    width:200
});

this.tx_ubicacion.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            if(listaProducto.main.tx_ubicacion.getValue() && listaProducto.main.tx_cia.getValue() ){
                            listaProducto.main.store_listaubi.load({
                            params:{
                                tx_ubicacion:listaProducto.main.tx_ubicacion.getValue(),
                                tx_cia:listaProducto.main.tx_cia.getValue()
                                },callback:function(records,operation,success){
                                    var f = '';
                                    var i= 1;
                                    this.each(function(record,index){
                                        if(i==1){
                                            f=record.data.co_organigrama;
                                            i--;
                                        }
                                       
                                    },this);
                                        listaProducto.main.organigrama.setValue(f);
                                        listaProducto.main.list_uso.setValue(''); 
                                        listaProducto.main.store_LIST_USO.load({
                                            params:{
                                                co_ubicacion:f
                                            }
                                        });  
                                        
                                }

                            });
                            listaProducto.main.storeLIST_UBICACION.load({
                                params:{
                                    tx_ubicacion:listaProducto.main.tx_ubicacion.getValue(),
                                    tx_cia:listaProducto.main.tx_cia.getValue()
                                },

                            });
                            listaProducto.main.organigrama.setValue(listaProducto.main.list_ubicacion.getValue());
                            listaProducto.main.list_ubicacion.setValue('');
                            
                            }
                        }
                    }, this);
                        
    this.tx_ubicacion.on('blur',function(){
        if(listaProducto.main.tx_ubicacion.getValue() && listaProducto.main.tx_cia.getValue() ){
                            listaProducto.main.store_listaubi.load({
                            params:{
                                tx_ubicacion:listaProducto.main.tx_ubicacion.getValue(),
                                tx_cia:listaProducto.main.tx_cia.getValue()
                                },callback:function(records,operation,success){
                                    var f = '';
                                    var i= 1;
                                    this.each(function(record,index){
                                        if(i==1){
                                            f=record.data.co_organigrama;
                                            i--;
                                        }
                                       
                                    },this);
                                        listaProducto.main.organigrama.setValue(f);
                                        listaProducto.main.list_uso.setValue(''); 
                                        listaProducto.main.store_LIST_USO.load({
                                            params:{
                                                co_ubicacion:f
                                            }
                                        });  
                                        
                                }

                            });
                            listaProducto.main.storeLIST_UBICACION.load({
                                params:{
                                    tx_ubicacion:listaProducto.main.tx_ubicacion.getValue(),
                                    tx_cia:listaProducto.main.tx_cia.getValue()
                                },

                            });
                            listaProducto.main.organigrama.setValue(listaProducto.main.list_ubicacion.getValue());
                            listaProducto.main.list_ubicacion.setValue('');
                            }
                    });


this.fieldDatosUbicacion= new Ext.Panel({
    width:1000,
    border:false,
    buttonAlign:'center',
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.4, border:false},
          
          items:[{items:[this.tx_cia]},{items:[this.tx_ubicacion]},{items:[this.list_ubicacion]}],
         
          }
          
          
          ]
        
            
                   });

                   this.agregarubi= new Ext.Button({
    text:'Agregar ubicación',
    iconCls: 'icon-add',
    handler:function(){
                           
                           if(listaProducto.main.list_ubicacion.getValue()){
                            listaProducto.main.store_listaubi.load({
                          params:{
                                 co_organigrama:listaProducto.main.list_ubicacion.getValue()
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
                                    
                                        listaProducto.main.tx_ubicacion.setValue(f);
                                        listaProducto.main.tx_cia.setValue(c);
                                }

                            });
                            listaProducto.main.storeLIST_UBICACION.load({
                                params:{
                                 co_organigrama:listaProducto.main.list_ubicacion.getValue()
                                },

                            });
                            listaProducto.main.list_uso.setValue(''); 
                            listaProducto.main.store_LIST_USO.load({
                                            params:{
                                                co_ubicacion:listaProducto.main.list_ubicacion.getValue()
                                            }
                                        });                 
                            listaProducto.main.organigrama.setValue(listaProducto.main.list_ubicacion.getValue());
                            listaProducto.main.list_ubicacion.setValue('');

                            
                            }
                            //listaProducto.main.confirmarFormulario();
                           
                    }
});
this.limpiar= new Ext.Button({
    text:'Limpiar',
    iconCls: 'icon-limpiar',
    handler:function(){
        listaProducto.main.store_listaubi.removeAll();
        listaProducto.main.storeLIST_UBICACION.load();
        listaProducto.main.store_LIST_USO.removeAll();
        listaProducto.main.list_uso.setValue('');
        listaProducto.main.organigrama.setValue('');
        listaProducto.main.tx_ubicacion.setValue('');
        listaProducto.main.tx_cia.setValue('');
        listaProducto.main.guardar.disable();

    }
});

this.gridPanel2 = new Ext.grid.GridPanel({
    title:'Lista de ubicacion',
    iconCls: 'icon-libro',
    store: this.store_listaubi,
    loadMask:true,
    border:true,   
//    frame:true,
width:750,
    height:150,
    tbar:[
        this.agregarubi,'-',this.limpiar],
    columns: [
    new Ext.grid.RowNumberer(),
   {header: 'co_organigrama', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_organigrama'},    
            {header: 'Ubicación',width:450, menuDisabled:true,sortable: true,dataIndex: 'tx_organigrama'},
            {header: 'Nivel Jerargico',width:80, menuDisabled:true,sortable: true,dataIndex: 'nu_nivel'},
            {header: 'Codigo',width:80, menuDisabled:true,sortable: true,dataIndex: 'cod_adm'},
            {header: 'Codigo CIA',width:80, menuDisabled:true,sortable: true,dataIndex: 'cod_cia'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true
});


this.fieldDatosGrid2= new Ext.form.FieldSet({
    title:'Ubicación a desincorporar',
    items:[this.fieldDatosUbicacion,
          this.gridPanel2]
});



this.list_rif2 = new Ext.form.ComboBox({
    fieldLabel:'CI/Rif Resp',
    store: this.storeLIST_RIF2,
    typeAhead: true,
    valueField: 'co_responsables',
    displayField:'nu_cedula',
    hiddenName:'tbbn010_responsables[co_responsables]',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Responsable',
    selectOnFocus: true,
    mode: 'local',
    width:250,
    resizable:true,
    allowBlank:false,
      onSelect: function(record){
        listaProducto.main.responsable.setValue(record.data.tx_nombres+' '+record.data.tx_apellidos);
        listaProducto.main.list_rif2.setValue(record.data.co_responsables);
        listaProducto.main.confirmarFormulario();  
    this.collapse();
  }
});
this.storeLIST_RIF2.load();




this.responsable = new Ext.form.TextField({
    fieldLabel:'Responsable',
    name:'tx_responsable',
    allowBlank:true,
    readOnly:true,
    style:'background:#c9c9c9;',
    width:250
});

this.fieldDatosResponsable= new Ext.Panel({
    width:800,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5,border:false},
                    items:[{items:[this.list_rif2]},
                          {items:[this.responsable]}
                           ]}]
                   });

this.fieldDatosFiltro= new Ext.Panel({
    width:800,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.tx_codigo]}
                           ]}]
            
                   });

this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Buscar Bienes',
    titleCollapse: true,
    autoWidth:true,
    border:true,
    padding:'10px',    
    items:[ this.fieldDatosFiltro,
            this.tx_descripcion,
            this.fieldDatosGridF,
            this.organigramaf,
            this.co_solicitud],
    keys: [{
		key:[Ext.EventObject.ENTER],
		handler: function() {
			listaProducto.main.aplicarFiltroByFormulario();
		}}
    ],
    buttonAlign:'center',
    buttons:[
        {
            text:'Consultar',
            iconCls:'icon-buscar',
            handler:function(){
                listaProducto.main.aplicarFiltroByFormulario();
            }
        },
        {
            text:'Limpiar',
            iconCls:'icon-limpiar',
            handler:function(){
                listaProducto.main.limpiarCamposByFormFiltro();
            }
        }
    ]
});


this.tx_observacion = new Ext.form.TextField({
	fieldLabel:'Especificaciones',
	name:'tx_observacion',
    style:'background:#c9c9c9;',
    readOnly:true,
	allowBlank:false,
	width:650
});

this.tx_motivo = new Ext.form.TextField({
    fieldLabel:'Motivo Desincorporación',
    name:'producto',
    allowBlank:false,
    width:650
});

     this.tx_motivo.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                           listaProducto.main.tx_motivo.setValue(listaProducto.main.tx_motivo.getValue().toUpperCase());  

                        }
                    }, this);
                        
    this.tx_motivo.on('blur',function(){
                        listaProducto.main.tx_motivo.setValue(listaProducto.main.tx_motivo.getValue().toUpperCase()); 
             if( listaProducto.main.organigrama.getValue()!=''){
                listaProducto.main.guardar.enable();
             }else{
                listaProducto.main.guardar.disable();
             }                        
                    });
this.nu_bienes = new Ext.form.TextField({
    fieldLabel:'Numero del bien',
    name:'nu_bienes',
    allowBlank:false,
    style:'background:#c9c9c9;',
    readOnly:true,
    width:250
});
this.tx_serial_bien = new Ext.form.TextField({
    fieldLabel:'Serial del bien',
    name:'tx_serial_bien',
    style:'background:#c9c9c9;',
    readOnly:true,
    allowBlank:false,
    width:250
});

this.ubicacion = new Ext.form.TextField({
    fieldLabel:'Ubicación',
    name:'ubicacion',
    allowBlank:false,
    style:'background:#c9c9c9;',
    readOnly:true,
    width:250
});

this.co_ubicacion = new Ext.form.Hidden({
    name:'co_ubicacion'});
    
this.precio = new Ext.form.Hidden({
    name:'precio'});

this.fieldDatosBien= new Ext.Panel({
    width:800,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.nu_bienes]},
                 {items:[this.ubicacion]}
                           ]}]
            
                   });

this.fieldDatosUso= new Ext.Panel({
    width:800,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.list_uso]}
                           ]}]
            
                   });


this.tx_marca = new Ext.form.TextField({
   fieldLabel:'Marca',
    name:'tx_marca',
    style:'background:#c9c9c9;',
    readOnly:true,
    allowBlank:false,
    width:250


});


this.tx_modelo = new Ext.form.TextField({
  fieldLabel:'Modelo',
    name:'tx_modelo',
    style:'background:#c9c9c9;',
    readOnly:true,
    allowBlank:false,
    width:250
});


this.fieldDatosMarca= new Ext.Panel({
    width:800,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.tx_marca]},
                 {items:[this.tx_modelo]}
                           ]}]
            
                   });


this.fieldDatos= new Ext.form.FieldSet({
    title: 'Datos del Producto Seleccionado',
    items:[this.tx_observacion,
            this.tx_motivo,
           this.fieldDatosMarca,
           this.fieldDatosBien,
           //this.fieldDatosResponsable,
           //this.fieldDatosUso
           ]
});

this.gridPanel = new Ext.grid.GridPanel({
        title:'Lista de Bienes',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:190,  
        width:750,   
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_bienes', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_bienes'}, 
            {header: 'co_ubicacion', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_organigrama'},    
            {header: 'precio', hidden: true,width:80, menuDisabled:true,dataIndex: 'nu_monto'},  
            {header: 'Numero',width:80, menuDisabled:true,dataIndex: 'nu_bienes'},
            //{header: 'Serial',width:80, menuDisabled:true,dataIndex: 'tx_serial'},
            {header: 'Marca',width:80, menuDisabled:true,dataIndex: 'tx_marca'},
            {header: 'Modelo',width:80, menuDisabled:true,dataIndex: 'tx_modelo'},
            {header: 'Detalle',width:600, menuDisabled:true,dataIndex: 'tx_detalle'},
            {header: 'Ubicación',width:200, menuDisabled:true,dataIndex: 'tx_organigrama'},
              

            
                
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
            listaProducto.main.tx_observacion.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('tx_detalle'));
            listaProducto.main.tx_marca.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('tx_marca'));
            listaProducto.main.tx_modelo.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('tx_modelo'));
            listaProducto.main.nu_bienes.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('nu_bienes'));
            listaProducto.main.tx_serial_bien.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('tx_serial'));
            listaProducto.main.ubicacion.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('tx_organigrama'));
             listaProducto.main.co_bienes.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('co_bienes'));
             listaProducto.main.co_ubicacion.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('co_organigrama'));
             listaProducto.main.precio.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('nu_monto'));
             if( listaProducto.main.organigrama.getValue()){
                listaProducto.main.guardar.enable();
             }else{
                listaProducto.main.guardar.disable();
             }
            
        }},
        bbar: new Ext.PagingToolbar({
            pageSize: 20,
            store: this.store_lista,
            //params:co_solicitud:BienesDesincorporacion.main.co_solicitud.getValue(),
            displayInfo: true,
            displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
            emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
        })
});


/*this.store_lista.load({
         params:{
                co_solicitud:BienesDesincorporacion.main.co_solicitud.getValue()
            }});*/

this.fieldDatosGrid= new Ext.form.FieldSet({
    items:[this.gridPanel]
});


this.guardar = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-guardar',
    handler:function(){
        
        if(listaProducto.main.tx_motivo.getValue()=='' || listaProducto.main.tx_motivo.getValue()==null){
            Ext.Msg.alert("Alerta","Debe ingresar el motivo");
            return false;
        } 
        
//        if(listaProducto.main.organigrama.getValue()=='' || listaProducto.main.organigrama.getValue()==null){
//            Ext.Msg.alert("Alerta","Debe agragar la ubicacion a desincorporar");
//            return false;
//        }        
        
        if(listaProducto.main.co_bienes.getValue()=='' || listaProducto.main.co_bienes.getValue()==null){
            Ext.Msg.alert("Alerta","Debe seleccionar un bien de la lista de bienes");
            return false;
        }        
        /*if(listaProducto.main.list_uso.getValue()=='' || listaProducto.main.list_uso.getValue()==null){
            Ext.Msg.alert("Alerta","Debe ingresar la función");
            return false;
        }

        if(listaProducto.main.list_rif2.getValue()=='' || listaProducto.main.list_rif2.getValue()==null){
            Ext.Msg.alert("Alerta","Debe ingresar el responsable");
            return false;
        }*/
          Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/condenarBien',
            params:{
                co_bienes:listaProducto.main.co_bienes.getValue(),
                co_ubicacion:listaProducto.main.co_ubicacion.getValue(),
                co_traslado:listaProducto.main.organigrama.getValue(),
                //co_responsable:listaProducto.main.list_rif2.getValue(),
                co_solicitud:BienesDesincorporacion.main.co_solicitud.getValue(),
                precio_unitario:listaProducto.main.precio.getValue(),
                co_usuario:BienesDesincorporacion.main.co_usuario.getValue(),
                co_tipo_documento:BienesDesincorporacion.main.list_documento.getValue(),
                co_tipo_movimiento:BienesDesincorporacion.main.co_tipo_movimiento.getValue(),
                tx_motivo:listaProducto.main.tx_motivo.getValue(),
                //co_uso:listaProducto.main.list_uso.getValue(),
            },
            success:function(result, request ) {
                BienesDesincorporacion.main.store_lista.load();
                Ext.utiles.msg('Mensaje', "El Bien se agrego exitosamente"); 
                listaProducto.main.guardar.disable();         
            }});

          BienesDesincorporacion.main.store_lista.load();
         BienesDesincorporacion.main.gridPanel.getView().refresh();
         listaProducto.main.store_lista.load();
         listaProducto.main.gridPanel.getView().refresh();
         //BienesDesincorporacion.main.getLista.load();
        
       

        BienesDesincorporacion.main.cant_total = BienesDesincorporacion.main.store_lista.getCount();

        BienesDesincorporacion.main.cantidad_total.setValue("<span style='font-size:12px;'><b>Cantidad Total: </b>"+parseInt(BienesDesincorporacion.main.cant_total)+"</b></span>");     
       
         
        var list_producto = paqueteComunJS.funcion.getJsonByObjStore({
                store:BienesDesincorporacion.main.gridPanel.getStore()
        });

        listaProducto.main.tx_observacion.setValue(""); 
        listaProducto.main.nu_bienes.setValue("");
        listaProducto.main.tx_serial_bien.setValue("");
        listaProducto.main.list_marca.setValue("");  
        listaProducto.main.list_modelo.setValue("");
   
    }
});
//this.guardar.disable();

this.salir = new Ext.Button({
    text:'Salir',
    iconCls: 'icon-cancelar',
    handler:function(){
        listaProducto.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
  //  frame:true,
    width:814,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
           this.fieldDatosGrid,
           this.fieldDatosGrid2,
           this.fieldDatos]
});

this.winformPanel_ = new Ext.Window({
    title:'Lista de Bienes',
    modal:true,
    constrain:true,
    width:850,
    height:800,
    autoScroll:true,
  //  frame:true,
    closabled:true,
    items:[
        this.formFiltroPrincipal,
        this.formPanel_
    ],
    buttons:[
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
},
aplicarFiltroByFormulario: function(){
	//Capturamos los campos con su value para posteriormente verificar cual
	//esta lleno y trabajar en base a ese.
	var campo = listaProducto.main.formFiltroPrincipal.getForm().getValues();

	listaProducto.main.store_lista.baseParams={co_solicitud:BienesDesincorporacion.main.co_solicitud.getValue()}

	var swfiltrar = false;
	for(campName in campo){
	    if(campo[campName]!=''){
		swfiltrar = true;
		eval("listaProducto.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
	    }
	}
	if(swfiltrar==true){
	    listaProducto.main.store_lista.baseParams.BuscarBy = true;
	    listaProducto.main.store_lista.load();
	}else{
	    listaProducto.main.formFiltroPrincipal.getForm().reset();
            listaProducto.main.store_lista.baseParams={co_solicitud:BienesDesincorporacion.main.co_solicitud.getValue()};
            listaProducto.main.store_lista.load();
	}

	},
	limpiarCamposByFormFiltro: function(){
	listaProducto.main.formFiltroPrincipal.getForm().reset();
	listaProducto.main.store_lista.baseParams={co_solicitud:BienesDesincorporacion.main.co_solicitud.getValue()};
	listaProducto.main.store_lista.load();
        
}
,getStoreCO_BIENES:function(){
    var c = BienesDesincorporacion.main.co_solicitud.getValue();
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefkcobienes',
         baseParams:{
                co_solicitud:BienesDesincorporacion.main.co_solicitud.getValue()
            },
        root:'data',
        fields:[
            {name: 'co_bienes'},
            {name: 'nu_bienes'},
            {name: 'tx_serial'},
            {name: 'tx_detalle'},
            {name: 'tx_marca'},
            {name: 'tx_modelo'},
            {name: 'tx_organigrama'},
            {name: 'co_organigrama'},
            {name: 'nu_monto'},
            ]
    });
    return this.store;
},getStoreLIST_UBICACION_FILTRO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefklistubicacion',
        root:'data',
        fields:[
            {name: 'co_organigrama'},
            {name: 'tx_organigrama'},
            {name: 'co_padre'},
            {name: 'nu_nivel'},
            {name: 'tx_punto_referencia'},
            {name: 'cod_adm'},
            {name: 'cod_cia'},
            {
                name: 'descripcion',
                convert: function(v, r) {
                        return r.cod_adm + ' - ' + r.tx_organigrama;
                }
            }
            ]
    });
    return this.store;
},getStoreLIST_UBICACION_FILTRO2:function(){
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
            {name: 'cod_cia'},
            {
                name: 'descripcion',
                convert: function(v, r) {
                        return r.cod_adm + ' - ' + r.tx_organigrama;
                }
            }
        ]
    });
    return this.store;
},getStoreLIST_UBICACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefklistubicacion',
        root:'data',
        fields:[
            {name: 'co_organigrama'},
            {name: 'tx_organigrama'},
            {name: 'co_padre'},
            {name: 'nu_nivel'},
            {name: 'tx_punto_referencia'},
            {name: 'cod_adm'},
            {name: 'cod_cia'},
            {
                name: 'descripcion',
                convert: function(v, r) {
                        return r.cod_adm + ' - ' + r.tx_organigrama;
                }
            }
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
},getStoreLIST_RIF2:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefklistresponsables',
        root:'data',
        fields:[
            {name: 'co_responsables'},
            {name: 'nu_cedula'},
             {name: 'tx_nombres'},
             {name: 'tx_apellidos'},
            
            ]
    });
    return this.store;
},getStoreLIST_USO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefklistuso',
        root:'data',
        fields:[
            {name: 'co_uso'},
            {name: 'tx_uso'}
            
            ]
    });
    return this.store;
}
};
Ext.onReady(listaProducto.main.init, listaProducto.main);
</script>
