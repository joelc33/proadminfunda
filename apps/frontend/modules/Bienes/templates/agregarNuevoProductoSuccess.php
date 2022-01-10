<script type="text/javascript">
Ext.ns("listaProducto");
listaProducto.main = {
init:function(){


    this.storeLIST_RIF = this.getStoreLIST_RIF();
this.storeLIST_RIF2 = this.getStoreLIST_RIF2();
this.store_lista = this.getStoreCO_PRODUCTO();
this.storeLIST_MARCA = this.getStoreLIST_MARCA();
this.storeLIST_MODELO = this.getStoreLIST_MODELO();

this.storeLIST_UBICACION=this.getStoreLIST_UBICACION();
this.store_listaubi=this.getStoreLIST_UBICACION2();

this.store_LIST_USO=this.getStoreLIST_USO();

this.co_producto = new Ext.form.Hidden({
    name:'co_producto'
});


this.tx_codigo = new Ext.form.TextField({
	fieldLabel:'Código',
	name:'codigo',
	allowBlank:false,
	width:80
});
this.organigrama = new Ext.form.Hidden({
    name:'organigrama'});
this.list_ubicacion = new Ext.form.ComboBox({
    fieldLabel:'Ubicaciones',
    store: this.storeLIST_UBICACION,
    typeAhead: true,
    labelStyle: 'width:120px',
    valueField: 'co_organigrama',
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

this.tx_ubicacion = new Ext.form.TextField({
    fieldLabel:'Codigo',
    labelStyle: 'width:120px',
    name:'tx_ubicacion',
    allowBlank:true,
    width:250
});

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
    width:350,
    resizable:true,
    allowBlank:false,
    listeners:{
        'select': function(combo, rec, index){ 
            listaProducto.main.confirmarFormulario();
        }
        
    }});


this.tx_cia = new Ext.form.TextField({
    fieldLabel:'Codigo CIA',
    labelStyle: 'width:120px',
    name:'tx_cia',
    allowBlank:true,
    width:250
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
                            listaProducto.main.confirmarFormulario();
                    }
});
this.limpiar= new Ext.Button({
    text:'Limpiar',
    iconCls: 'icon-limpiar',
    handler:function(){
        listaProducto.main.store_listaubi.removeAll();
        listaProducto.main.store_LIST_USO.removeAll();
        listaProducto.main.list_uso.setValue('');
        listaProducto.main.storeLIST_UBICACION.load();
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
width:900,
    height:150,
    tbar:[
        this.agregarubi,'-',this.limpiar],
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


this.fieldDatosGrid2= new Ext.form.FieldSet({
    title:'Ubicación',
    items:[this.fieldDatosUbicacion,
          this.gridPanel2]
});

this.precio_unitario = new Ext.form.NumberField({
                fieldLabel : 'Precio',
                id : 'precio_unitario',
                name : 'precio_unitario',
                width: 350,
                minValue : 0,
                allowBlank : false,
                allowDecimals : true,
                decimalPrecision : 5,
                 decimalSeparator : '.',
                allowNegative : false,
                tooltip : '',
                allowBlank:false
                //readOnly:true,
                //style: 'background: #DDDDDD;'
               });
this.nu_cantidad = new Ext.form.NumberField({
                fieldLabel : 'Cantidad',
                id : 'nu_cantidad',
                name : 'nu_cantidad',
                width: 350,
                minValue : 1,
                allowBlank : false,
                allowDecimals : false,
                allowNegative : false,
                tooltip : '',
                allowBlank:false
                //readOnly:true,
                //style: 'background: #DDDDDD;'
               });

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Producto',
	name:'producto',
	allowBlank:false,
	width:510
});

this.tx_motivo = new Ext.form.TextField({
    fieldLabel:'Motivo Incorporación',
    name:'producto',
    allowBlank:false,
    width:850
});

this.tx_motivo.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                           // alert('funciona');
                            listaProducto.main.tx_motivo.setValue(listaProducto.main.tx_motivo.getValue().toUpperCase());
                            listaProducto.main.confirmarFormulario();  

                        }
                    }, this);
                        
    this.tx_motivo.on('blur',function(){
        //alert('funciona');
                        listaProducto.main.tx_motivo.setValue(listaProducto.main.tx_motivo.getValue().toUpperCase());
                        listaProducto.main.confirmarFormulario();  
                    }); 


this.tx_uso = new Ext.form.TextField({
    fieldLabel:'Uso',
    name:'uso',
    allowBlank:true,
    width:350
});


this.list_rif = new Ext.form.ComboBox({
    fieldLabel:'Rif Proveedor',
    store: this.storeLIST_RIF,
    typeAhead: true,
    valueField: 'co_proveedor',
    displayField:'nombre',
    hiddenName:'tb008_proveedor[co_proveedor]',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'...',
    selectOnFocus: true,
    mode: 'local',
    width:350,
    resizable:true,
    allowBlank:true,
      onSelect: function(record){
        listaProducto.main.proveedor.setValue(record.data.tx_razon_social);
        listaProducto.main.list_rif.setValue(record.data.co_proveedor);
        listaProducto.main.confirmarFormulario();  
        this.collapse();
  }
});
this.storeLIST_RIF.load();

/*this.list_rif2 = new Ext.form.ComboBox({
    fieldLabel:'CI/Rif Resp',
    store: this.storeLIST_RIF2,
    typeAhead: true,
    valueField: 'co_responsables',
    displayField:'nu_cedula',
    hiddenName:'tbbn010_responsables[co_responsables]',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'...',
    selectOnFocus: true,
    mode: 'local',
    width:350,
    resizable:true,
    allowBlank:true,
      onSelect: function(record){
        listaProducto.main.responsable.setValue(record.data.tx_nombres+' '+record.data.tx_apellidos);
        listaProducto.main.list_rif2.setValue(record.data.co_responsables);
        listaProducto.main.confirmarFormulario();  
    this.collapse();
  }
});
this.storeLIST_RIF2.load();*/



this.proveedor = new Ext.form.TextField({
    fieldLabel:'Proveedor',
    name:'tx_razon_social',
    allowBlank:true,
    readOnly:true,
    style:'background:#c9c9c9;',
    width:350
});

/*this.responsable = new Ext.form.TextField({
    fieldLabel:'Responsable',
    name:'tx_responsable',
    allowBlank:true,
    readOnly:true,
    style:'background:#c9c9c9;',
    width:350
});*/


this.fieldDatosProveedor= new Ext.Panel({
    width:1000,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5,border:false},
                    items:[{items:[this.list_rif]},
                          {items:[this.proveedor]}
                           ]}]
                   });

/*this.fieldDatosResponsable= new Ext.Panel({
    width:1000,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5,border:false},
                    items:[{items:[this.responsable]}
                           ]}]
                   });*/

this.formFiltroPrincipal = new Ext.form.FormPanel({
    title:'Buscar Productos',
    titleCollapse: true,
    autoWidth:true,
    border:true,
    padding:'10px',    
    items:[ this.tx_codigo,
            this.tx_descripcion],
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




this.cod_producto = new Ext.form.TextField({
	fieldLabel:'Código',
	name:'cod_producto',
	allowBlank:false,
	readOnly:true,
	style:'background:#c9c9c9;',
	width:80
});

this.tx_producto = new Ext.form.TextField({
	fieldLabel:'Producto',
	name:'tx_producto',
	allowBlank:false,
	readOnly:true,
	style:'background:#c9c9c9;',
	width:765
});




this.tx_observacion = new Ext.form.TextField({
	fieldLabel:'Especificaciones',
	name:'tx_observacion',
	allowBlank:false,
	width:850
});

this.tx_observacion.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                           // alert('funciona');
                            listaProducto.main.tx_observacion.setValue(listaProducto.main.tx_observacion.getValue().toUpperCase());
                            listaProducto.main.confirmarFormulario();  

                        }
                    }, this);
                        
    this.tx_observacion.on('blur',function(){
        //alert('funciona');
                        listaProducto.main.tx_observacion.setValue(listaProducto.main.tx_observacion.getValue().toUpperCase());
                        listaProducto.main.confirmarFormulario();  
                    }); 


this.nu_bienes = new Ext.form.TextField({
    fieldLabel:'Numero del bien',
    name:'nu_bienes',
    allowBlank:false,
    width:350
});
 /*this.nu_bienes.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                           // alert('funciona');
                           listaProducto.main.nu_bienes.setValue(listaProducto.main.nu_bienes.getValue().toUpperCase());  
                            listaProducto.main.verificarNuBien();

                        }
                    }, this);
                        
    this.nu_bienes.on('blur',function(){
        //alert('funciona');
        listaProducto.main.nu_bienes.setValue(listaProducto.main.nu_bienes.getValue().toUpperCase()); 
                          listaProducto.main.verificarNuBien();
                    });*/

     this.tx_motivo.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                           listaProducto.main.tx_motivo.setValue(listaProducto.main.tx_motivo.getValue().toUpperCase()); 
                           listaProducto.main.confirmarFormulario();

                        }
                    }, this);
                        
    this.tx_motivo.on('blur',function(){
                        listaProducto.main.tx_motivo.setValue(listaProducto.main.tx_motivo.getValue().toUpperCase()); 
                        listaProducto.main.confirmarFormulario();
                    });


     this.precio_unitario.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                           listaProducto.main.confirmarFormulario();

                        }
                    }, this);
                        
    this.precio_unitario.on('blur',function(){
                        listaProducto.main.confirmarFormulario();
                    });
    
   this.nu_cantidad.on('blur',function(){
                        listaProducto.main.confirmarFormulario();
                    });


/*this.tx_serial_bien = new Ext.form.TextField({
    fieldLabel:'Serial del bien',
    name:'tx_serial_bien',
    allowBlank:false,
    width:350
});

   this.tx_serial_bien.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                           // alert('funciona');
                           listaProducto.main.tx_serial_bien.setValue(listaProducto.main.tx_serial_bien.getValue().toUpperCase());  
                            listaProducto.main.verificarSerialBien();


                        }
                    }, this);
                        
    this.tx_serial_bien.on('blur',function(){
        //alert('funciona');
                             listaProducto.main.tx_serial_bien.setValue(listaProducto.main.tx_serial_bien.getValue().toUpperCase()); 
                          listaProducto.main.verificarSerialBien();
                    }); */

     /* this.tx_uso.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                           // alert('funciona');
                            listaProducto.main.tx_uso.setValue(listaProducto.main.tx_uso.getValue().toUpperCase());  

                        }
                    }, this);
                        
    this.tx_uso.on('blur',function(){
        //alert('funciona');
                        listaProducto.main.tx_uso.setValue(listaProducto.main.tx_uso.getValue().toUpperCase());  
                    }); */



this.fieldDatosBien= new Ext.Panel({
    width:1000,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.nu_bienes]}
                 //{items:[this.tx_serial_bien]}
                           ]}]
            
                   });

this.compositefield = new Ext.form.CompositeField({
fieldLabel: 'Producto',
width:1000,
items: [
           this.cod_producto,
           this.tx_producto
	]
});
this.list_marca = new Ext.form.ComboBox({
    fieldLabel:'Marca',
    store: this.storeLIST_MARCA,
    typeAhead: true,
    valueField: 'co_marca',
    displayField:'tx_marca',
    hiddenName:'tb0174_marca[co_marca]',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'...',
    selectOnFocus: true,
    mode: 'local',
    width:350,
    resizable:true,
    allowBlank:true,
     listeners: {
                   'select': function(combo, rec, index){ 
                    listaProducto.main.list_modelo.setValue('');                        
                    listaProducto.main.storeLIST_MODELO.load({
                        params:{
                            co_marca:rec.get('co_marca')
                        }
                    });                        
                        }
                    }  


});
this.storeLIST_MARCA.load();


this.list_modelo = new Ext.form.ComboBox({
    fieldLabel:'Modelo',
    store: this.storeLIST_MODELO,
    typeAhead: true,
    valueField: 'co_modelo',
    displayField:'tx_modelo',
    hiddenName:'tb0175_modelo[co_modelo]',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'...',
    selectOnFocus: true,
    mode: 'local',
    width:350,
    resizable:true,
    allowBlank:false,
    listeners:{
        'select': function(combo, rec, index){ 
            listaProducto.main.confirmarFormulario();
        }
        
    }
});


this.fieldDatosMarca= new Ext.Panel({
    width:1000,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.list_marca]},
                 {items:[this.list_modelo]}
                           ]}]
            
                   });


this.fieldDatosUso= new Ext.Panel({
    width:1000,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.precio_unitario]},
                {items:[this.nu_cantidad]}
                           ]}]
            
                   });

this.fieldDatos= new Ext.form.FieldSet({
    title: 'Datos del Producto Seleccionado',
    items:[this.compositefield,
           this.tx_observacion,
           this.tx_motivo,
           this.fieldDatosProveedor,
           //this.fieldDatosResponsable,
           this.fieldDatosUso,
           this.fieldDatosMarca,
           //this.fieldDatosBien
           ]
});

this.gridPanel = new Ext.grid.GridPanel({
        title:'Lista de Productos',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:190,  
        width:950,   
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_producto', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_producto'},    
            {header: 'Codigo',width:80, menuDisabled:true,dataIndex: 'cod_producto'},
            {header: 'Descripción',width:820, menuDisabled:true,dataIndex: 'tx_producto'},
                
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
            listaProducto.main.co_producto.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('co_producto'));
            listaProducto.main.cod_producto.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('cod_producto'));
            listaProducto.main.tx_producto.setValue(listaProducto.main.store_lista.getAt(rowIndex).get('tx_producto'));
        }},
        bbar: new Ext.PagingToolbar({
            pageSize: 5,
            store: this.store_lista,
            displayInfo: true,
            displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
            emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
        })
});


this.store_lista.load();

this.fieldDatosGrid= new Ext.form.FieldSet({
    items:[this.gridPanel]
});


this.guardar = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!listaProducto.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        } 
          Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/guardarBien',
            params:{
                co_solicitud: BienesRegistrar.main.co_solicitud.getValue(),
                tx_detalle:listaProducto.main.tx_observacion.getValue(),
                co_tipo_incorporacion:BienesRegistrar.main.co_tipo_incorporacion.getValue(),
                co_documento:BienesRegistrar.main.list_documento.getValue(),
                //co_ubicacion_ant:BienesRegistrar.main.organigrama.getValue(),
                co_ubicacion:listaProducto.main.organigrama.getValue(),
                co_producto: listaProducto.main.co_producto.getValue(),
                //id:listaProducto.main.list_ejecutor.getValue(),
                co_usuario:BienesRegistrar.main.co_usuario.getValue(),
                co_proveedor:listaProducto.main.list_rif.getValue(),
                //nu_bienes:listaProducto.main.nu_bienes.getValue(),
                co_modelo:listaProducto.main.list_modelo.getValue(),
                precio_unitario:listaProducto.main.precio_unitario.getValue(),
                nu_cantidad:listaProducto.main.nu_cantidad.getValue(),
                //co_uso:listaProducto.main.list_uso.getValue(),
                tx_motivo:listaProducto.main.tx_motivo.getValue(),
                //co_responsable:listaProducto.main.list_rif2.getValue(),
                //tx_serial:listaProducto.main.tx_serial_bien.getValue()
            },
            success:function(result, request ) {
                listaProducto.main.store_lista.load();
                Ext.utiles.msg('Mensaje', "El Bien se agrego exitosamente"); 
                listaProducto.main.tx_motivo.setValue('');
                listaProducto.main.tx_observacion.setValue('');
                listaProducto.main.precio_unitario.setValue('');              
            }});

          listaProducto.main.store_lista.load();
          BienesRegistrar.main.store_lista.load();
         listaProducto.main.gridPanel.getView().refresh();
         //listaProducto.main.getLista.load();
        
       

        listaProducto.main.cant_total = listaProducto.main.store_lista.getCount();

        listaProducto.main.cantidad_total.setValue("<span style='font-size:12px;'><b>Cantidad Total: </b>"+parseInt(listaProducto.main.cant_total)+"</b></span>");     
       
         
        var list_producto = paqueteComunJS.funcion.getJsonByObjStore({
                store:listaProducto.main.gridPanel.getStore()
        });

        listaProducto.main.co_producto.setValue("");
        listaProducto.main.cod_producto.setValue("");
        listaProducto.main.tx_producto.setValue("");
        listaProducto.main.tx_observacion.setValue(""); 
        listaProducto.main.nu_bienes.setValue("");
        //listaProducto.main.tx_serial_bien.setValue("");
        listaProducto.main.list_marca.setValue("");  
        listaProducto.main.list_modelo.setValue("");
        
        //listaProducto.main.store_lista.baseParams.lista_producto = list_producto;
        listaProducto.main.store_lista.load();
   
    }
});
this.guardar.disable();

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        listaProducto.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
  //  frame:true,
    width:1000,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
           this.fieldDatosGrid,
           this.fieldDatosGrid2,
           this.fieldDatos]
});

this.winformPanel_ = new Ext.Window({
    title:'Lista de Productos',
    modal:true,
    constrain:true,
    width:1050,
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

	listaProducto.main.store_lista.baseParams={}

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
            listaProducto.main.store_lista.baseParams={};
            listaProducto.main.store_lista.load();
	}

	},
	limpiarCamposByFormFiltro: function(){
	listaProducto.main.formFiltroPrincipal.getForm().reset();
	listaProducto.main.store_lista.baseParams={};
	listaProducto.main.store_lista.load();
        
},
confirmarFormulario: function(){
        if(listaProducto.main.co_producto.getValue() && listaProducto.main.list_modelo.getValue() && listaProducto.main.precio_unitario.getValue() && 
           listaProducto.main.organigrama.getValue()!='' && listaProducto.main.organigrama.getValue()){

            listaProducto.main.guardar.enable();
           }else{
            listaProducto.main.guardar.disable();
           }

               /* tx_detalle:listaProducto.main.tx_observacion.getValue(),
                co_producto: listaProducto.main.co_producto.getValue(),
                co_usuario:listaProducto.main.co_usuario.getValue(),
                co_modelo:listaProducto.main.list_modelo.getValue(),
                precio_unitario:listaProducto.main.precio_unitario.getValue(),
                tx_motivo:listaProducto.main.tx_motivo.getValue(),*/
}
,getStoreCO_PRODUCTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefkcoproductonuevo',
        root:'data',
        fields:[
            {name: 'co_producto'},
            {name: 'cod_producto'},
            {name: 'tx_producto'}
            ]
    });
    return this.store;
}
,verificarNuBien:function(){
      if(listaProducto.main.nu_bienes.getValue()==''){
                                    Ext.Msg.alert("Alerta","Debe indicar el número del bien");
                                    listaProducto.main.guardar.disable();
                                    return false;
                    }

                         Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/verificarNuBien',
            params:{
                nu_bienes: listaProducto.main.nu_bienes.getValue(),
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                //listaProducto.main.store_lista.load();
                if(obj.success==true){
                   Ext.utiles.msg('Mensaje', "El numero del bien existe,Pruebe con otro");
                     listaProducto.main.nu_bienes.setValue('');
                    listaProducto.main.guardar.disable();
                }
                /*else{
                   Ext.utiles.msg('Mensaje', "El numero del bien no existe, puede proceder");
                     if(listaProducto.main.tx_serial_bien.getValue()!=''){
                        listaProducto.main.guardar.enable();
                      }
                }*/
                             
            }
            }); 
 
}
/*,verificarSerialBien:function(){
      if(listaProducto.main.tx_serial_bien.getValue()==''){
                                    Ext.Msg.alert("Alerta","Debe indicar el serial del bien");
                                    listaProducto.main.guardar.disable();
                                    return false;
                    }

                         Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/verificarSerialBien',
            params:{
                tx_serial_bien: listaProducto.main.tx_serial_bien.getValue(),
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                //listaProducto.main.store_lista.load();
                if(obj.success==true){
                   Ext.utiles.msg('Mensaje', "El serial del Bien existe,Pruebe con otro");
                     listaProducto.main.tx_serial_bien.setValue('');
                     listaProducto.main.guardar.disable();
                }else{
                   Ext.utiles.msg('Mensaje', "El serial del bien no existe,puede proceder");
                    if(listaProducto.main.nu_bienes.getValue()!=''){
                        listaProducto.main.guardar.enable();
                      }
                   
                }
                             
            }
            }); 
 
}*/,getStoreLIST_MARCA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefklistmarca',
        root:'data',
        fields:[
            {name: 'co_marca'},
            {name: 'tx_marca'}
            
            ]
    });
    return this.store;
}
,getStoreLIST_MODELO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefklistmodelo',
        root:'data',
        fields:[
            {name: 'co_modelo'},
            {name: 'tx_modelo'}
            
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
},getStoreLIST_RIF:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefklistproveedor',
        root:'data',
        fields:[
            {name: 'co_proveedor'},
            {name: 'nombre'},
            {name: 'tx_rif'},
             {name: 'tx_razon_social'}
            
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
}
};
Ext.onReady(listaProducto.main.init, listaProducto.main);
</script>
