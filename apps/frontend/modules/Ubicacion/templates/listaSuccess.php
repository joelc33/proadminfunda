<script type="text/javascript">
Ext.ns("UbicacionLista");
UbicacionLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
this.storeLIST_UBICACION=this.getStoreLIST_UBICACION();
this.storeLIST_RIF2 = this.getStoreLIST_RIF2();
this.store_listaubi=this.getStoreLIST_UBICACION2();
this.storeCO_MUNICIPIO= this.getStoreCO_MUNICIPIO();
this.storeCO_PARROQUIA= this.getStoreCO_PARROQUIA();
this.storeEstatus=new Ext.data.SimpleStore({
                        data : [[true, 'ACTIVO'],[false, 'INACTIVO']],
                        fields : ['in_activo', 'tx_activo']
                                                       });
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});
this.organigrama = new Ext.form.Hidden({
    name:'organigrama'});
    this.co_organigrama = new Ext.form.Hidden({
    name:'co_organigrama'});

this.list_estatus= new Ext.form.ComboBox({
    fieldLabel:'Estatus',
    labelStyle: 'width:120px',
    store:this.storeEstatus,
    typeAhead: true,
    valueField: 'in_activo',
    displayField:'tx_activo',
    hiddenName:'Estatus',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Estatus',
    selectOnFocus: true,
    mode: 'local',
    width:250,
    resizable:true,
    allowBlank:false,
});
/*paqueteComunJS.funcion.seleccionarComboByCo({
                objCMB: this.list_estatus,
                value:  true,
                objStore:this.storeEstatus
            });*/

//------------------------------------COSAS DE DIRECCION-----------------------------
this.list_municipio= new Ext.form.ComboBox({
    fieldLabel:'Municipio',
    store: this.storeCO_MUNICIPIO,
    typeAhead: true,
    valueField: 'co_municipio',
    displayField:'nb_municipio',
    hiddenName:'tb017_municipio[co_municipio]',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Municipio',
    selectOnFocus: true,
    mode: 'local',
    width:250,
    resizable:true,
    allowBlank:false,
      onSelect: function(record){
        UbicacionLista.main.list_municipio.setValue(record.data.co_municipio);
        UbicacionLista.main.list_parroquia.setValue('');
        UbicacionLista.main.storeCO_PARROQUIA.load({
                        params:{
                            co_municipio:record.data.co_municipio
                        }
                    });  
    this.collapse();
  }
});
this.list_rif2 = new Ext.form.ComboBox({
    fieldLabel:'CI/Rif Resp',
    labelStyle: 'width:120px',
    store: this.storeLIST_RIF2,
    typeAhead: true,
    valueField: 'co_responsables',
    displayField:'nombre',
    hiddenName:'co_responsables',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'...',
    selectOnFocus: true,
    mode: 'local',
    width:250,
    resizable:true,
    allowBlank:true,
      onSelect: function(record){
        UbicacionLista.main.list_rif2.setValue(record.data.co_responsables);
        UbicacionLista.main.responsable.setValue(record.data.tx_nombres+' '+record.data.tx_apellidos);
    this.collapse();
  }
});
this.storeLIST_RIF2.load();

this.responsable = new Ext.form.TextField({
    fieldLabel:'Responsable',
    name:'tx_responsable',
    labelStyle: 'width:120px',
    allowBlank:true,
    readOnly:true,
    style:'background:#c9c9c9;',
    width:250,
});

this.storeCO_MUNICIPIO.load();

this.list_parroquia= new Ext.form.ComboBox({
    fieldLabel:'Parroquia',
    store: this.storeCO_PARROQUIA,
    typeAhead: true,
    valueField: 'co_parroquia',
    displayField:'tx_parroquia',
    hiddenName:'tbbn003_parroquia[co_parroquia]',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Parroquia',
    selectOnFocus: true,
    mode: 'local',
    width:250,
    resizable:true,
    allowBlank:false,
      onSelect: function(record){
        UbicacionLista.main.list_parroquia.setValue(record.data.co_parroquia);
        
    this.collapse();
  }
});
this.tx_avenida = new Ext.form.TextField({
	fieldLabel:'Avenida',
	name:'tx_avenida',
	allowBlank:false,
	width:250
});

this.tx_avenida.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            UbicacionLista.main.tx_avenida.setValue(UbicacionLista.main.tx_avenida.getValue().toUpperCase());  

                        }
                    }, this);
                        
this.tx_avenida.on('blur',function(){
                             UbicacionLista.main.tx_avenida.setValue(UbicacionLista.main.tx_avenida.getValue().toUpperCase()); 
                    });

this.tx_calle = new Ext.form.TextField({
	fieldLabel:'Calle',
	name:'tx_calle',
	allowBlank:false,
	width:250
});


this.tx_calle.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            UbicacionLista.main.tx_calle.setValue(UbicacionLista.main.tx_calle.getValue().toUpperCase());  

                        }
                    }, this);
                        
this.tx_calle.on('blur',function(){
                             UbicacionLista.main.tx_calle.setValue(UbicacionLista.main.tx_calle.getValue().toUpperCase()); 
                    });

this.tx_punto_referencia = new Ext.form.TextField({
	fieldLabel:'Punto de Referencia',
	name:'tx_punto_referencia',
	allowBlank:false,
	width:650
});

this.tx_punto_referencia.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            UbicacionLista.main.tx_punto_referencia.setValue(UbicacionLista.main.tx_punto_referencia.getValue().toUpperCase());  

                        }
                    }, this);
                        
this.tx_punto_referencia.on('blur',function(){
                             UbicacionLista.main.tx_punto_referencia.setValue(UbicacionLista.main.tx_punto_referencia.getValue().toUpperCase()); 
                    });

this.tx_sector = new Ext.form.TextField({
	fieldLabel:'Sector',
	name:'tx_sector',
	allowBlank:false,
	width:650
});

this.tx_sector.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            UbicacionLista.main.tx_sector.setValue(UbicacionLista.main.tx_sector.getValue().toUpperCase());  

                        }
                    }, this);
                        
this.tx_sector.on('blur',function(){
                             UbicacionLista.main.tx_sector.setValue(UbicacionLista.main.tx_sector.getValue().toUpperCase()); 
                    });

this.fieldDatosCalle= new Ext.Panel({
        width:800,
        border:false,
        items:[{layout:'column',border:false,
            defaults:{layout:'form',columnWidth:.5, border:false},
            items:[{items:[this.tx_avenida]},
                    {items:[this.tx_calle]}
                            ]}]
                
                    });


this.fieldDatosParroquia= new Ext.Panel({
    width:800,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.list_municipio]},
                 {items:[this.list_parroquia]}
                           ]}]
            
                   });




this.fieldDatosDireccion= new Ext.form.FieldSet({
    title: 'Dirección',
    items:[this.fieldDatosParroquia,
           this.fieldDatosCalle,
           this.tx_sector,
           this.tx_punto_referencia]
});


    this.tx_ubicacion = new Ext.form.TextField({
    fieldLabel:'Codigo',
    labelStyle: 'width:120px',
    name:'tx_ubicacion',
    allowBlank:true,
    width:250
});


this.tx_organigrama = new Ext.form.TextField({
    fieldLabel:'Ubicación',
    labelStyle: 'width:120px',
    name:'tx_organigrama',
    allowBlank:false,
    width:250
});
this.tx_organigrama2 = new Ext.form.TextField({
    fieldLabel:'Ubicación seleccionada',
    labelStyle: 'width:120px',
    name:'tx_organigrama2',
    allowBlank:false,
	readOnly:true,
	style:'background:#c9c9c9;',
    width:250
});

this.tx_organigrama.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                           // alert('funciona');
                           UbicacionLista.main.tx_organigrama.setValue(UbicacionLista.main.tx_organigrama.getValue().toUpperCase());

                        }
                    }, this);
                        
    this.tx_organigrama.on('blur',function(){
        //alert('funciona');
        UbicacionLista.main.tx_organigrama.setValue(UbicacionLista.main.tx_organigrama.getValue().toUpperCase());
                    }); 
this.tx_cia = new Ext.form.TextField({
    fieldLabel:'Codigo CIA',
    labelStyle: 'width:120px',
    name:'tx_cia',
    allowBlank:true,
    width:250
});


this.fieldDatosGeneral= new Ext.Panel({
    width:800,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.tx_organigrama]},
                 {items:[this.list_estatus]},
                 {items:[this.list_rif2]},
                 {items:[this.responsable]},

                           ]}]
            
                   });

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
    allowBlank:true
    });
    
this.storeLIST_UBICACION.load();
this.tx_ubicacion.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            if(UbicacionLista.main.tx_ubicacion.getValue() && UbicacionLista.main.tx_cia.getValue() ){
                            UbicacionLista.main.store_listaubi.load({
                            params:{
                                tx_ubicacion:UbicacionLista.main.tx_ubicacion.getValue(),
                                tx_cia:UbicacionLista.main.tx_cia.getValue()
                                },callback:function(records,operation,success){
                                    var f = '';
                                    var i= 1;
                                    this.each(function(record,index){
                                        if(i==1){
                                            f=record.data.co_organigrama;
                                            i--;
                                        }
                                       
                                    },this);
                                        UbicacionLista.main.organigrama.setValue(f);
                                        
                                }
                                
                            });
                            UbicacionLista.main.storeLIST_UBICACION.load({
                                params:{
                                    tx_ubicacion:UbicacionLista.main.tx_ubicacion.getValue(),
                                    tx_cia:UbicacionLista.main.tx_cia.getValue()
                                },

                            });
                            UbicacionLista.main.organigrama.setValue(UbicacionLista.main.list_ubicacion.getValue());
                            UbicacionLista.main.list_ubicacion.setValue('');
                            
                            }

                        }
                    }, this);
                        
    this.tx_ubicacion.on('blur',function(){
        if(UbicacionLista.main.tx_ubicacion.getValue() && UbicacionLista.main.tx_cia.getValue() ){
                            UbicacionLista.main.store_listaubi.load({
                            params:{
                                tx_ubicacion:UbicacionLista.main.tx_ubicacion.getValue(),
                                tx_cia:UbicacionLista.main.tx_cia.getValue()
                                },callback:function(records,operation,success){
                                    var f = '';
                                    var i= 1;
                                    this.each(function(record,index){
                                        if(i==1){
                                            f=record.data.co_organigrama;
                                            i--;
                                        }
                                       
                                    },this);
                                        UbicacionLista.main.organigrama.setValue(f);
                                }

                            });
                            UbicacionLista.main.storeLIST_UBICACION.load({
                                params:{
                                    tx_ubicacion:UbicacionLista.main.tx_ubicacion.getValue(),
                                    tx_cia:UbicacionLista.main.tx_cia.getValue()
                                },

                            });
                            UbicacionLista.main.organigrama.setValue(UbicacionLista.main.list_ubicacion.getValue());
                            UbicacionLista.main.list_ubicacion.setValue('');
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
                           
                           if(UbicacionLista.main.list_ubicacion.getValue()){
                            UbicacionLista.main.store_listaubi.load({
                          params:{
                                 co_organigrama:UbicacionLista.main.list_ubicacion.getValue()
                                },callback:function(records,operation,success){
                                    var f = '';
                                    var c = '';
                                    var d = '';
                                    var i= 1;
                                    this.each(function(record,index){
                                        if(i==1){
                                            f=record.data.cod_adm;
                                            c=record.data.cod_cia;
                                            d=record.data.tx_organigrama;
                                            i--;
                                        }
                                       
                                    },this);
                                        UbicacionLista.main.tx_ubicacion.setValue(f);
                                        UbicacionLista.main.tx_cia.setValue(c);
                                        //UbicacionLista.main.tx_organigrama2.setValue(d);

                                }

                            });
                            UbicacionLista.main.storeLIST_UBICACION.load({
                                params:{
                                 co_organigrama:UbicacionLista.main.list_ubicacion.getValue()
                                },

                            });
                            UbicacionLista.main.organigrama.setValue(UbicacionLista.main.list_ubicacion.getValue());
                            UbicacionLista.main.list_ubicacion.setValue('');
                            
                            }
                    }
});
this.limpiar= new Ext.Button({
    text:'Limpiar',
    iconCls: 'icon-limpiar',
    handler:function(){
        UbicacionLista.main.store_listaubi.removeAll();
        UbicacionLista.main.storeLIST_UBICACION.load();
        UbicacionLista.main.organigrama.setValue('');
        UbicacionLista.main.tx_ubicacion.setValue('');
        UbicacionLista.main.tx_cia.setValue('');

    }
});


this.gridPanel2 = new Ext.grid.GridPanel({
    title:'Lista de ubicacion',
    iconCls: 'icon-libro',
    store: this.store_listaubi,
    loadMask:true,
    border:true,   
//    frame:true,	
autoWidth:true,
    height:150,
    tbar:[
        this.agregarubi,'-',this.limpiar],
    columns: [
    new Ext.grid.RowNumberer(),
   {header: 'co_organigrama', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_organigrama'},    
   {header: 'co_responsables', hidden: true,width:80, menuDisabled:true,dataIndex: 'co_responsables'},    
   {header: 'tx_nombres', hidden: true,width:80, menuDisabled:true,dataIndex: 'tx_nombres'},    
   {header: 'tx_apellidos', hidden: true,width:80, menuDisabled:true,dataIndex: 'tx_apellidos'},    
            {header: 'Ubicación',width:800, menuDisabled:true,sortable: true,dataIndex: 'tx_organigrama'},
            {header: 'Nivel Jerargico',width:200, menuDisabled:true,sortable: true,dataIndex: 'nu_nivel'},
            {header: 'Codigo',width:100, menuDisabled:true,sortable: true,dataIndex: 'cod_adm'},
            {header: 'Codigo CIA',width:100, menuDisabled:true,sortable: true,dataIndex: 'cod_cia'},
            {header: 'Estatus',width:100, menuDisabled:true,sortable: true,dataIndex: 'in_activo'},
            {header: 'tx_punto_referencia',hidden: true,width:100, menuDisabled:true,sortable: true,dataIndex: 'tx_punto_referencia'},
            {header: 'tx_calle',width:100,hidden: true, menuDisabled:true,sortable: true,dataIndex: 'tx_calle'},
            {header: 'tx_avenida',width:100, hidden: true,menuDisabled:true,sortable: true,dataIndex: 'tx_avenida'},
            {header: 'tx_sector',width:100, hidden: true,menuDisabled:true,sortable: true,dataIndex: 'tx_sector'},
            {header: 'co_parroquia',width:100,hidden: true, menuDisabled:true,sortable: true,dataIndex: 'co_parroquia'},
            {header: 'co_municipio',width:100,hidden: true, menuDisabled:true,sortable: true,dataIndex: 'co_municipio'},
            {header: 'tx_direccion',width:300,menuDisabled:true,sortable: true,dataIndex: 'tx_direccion'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
        Ext.MessageBox.confirm('Confirmación', '¿Quieres seleccionar este registro para modificar o registrar en el?', function(boton){
	if(boton=="yes"){
        UbicacionLista.main.tx_organigrama.setValue(UbicacionLista.main.store_listaubi.getAt(rowIndex).get('tx_organigrama'));
        UbicacionLista.main.list_rif2.setValue(UbicacionLista.main.store_listaubi.getAt(rowIndex).get('co_responsable'));
        UbicacionLista.main.responsable.setValue(UbicacionLista.main.store_listaubi.getAt(rowIndex).get('tx_nombres')+' '+UbicacionLista.main.store_listaubi.getAt(rowIndex).get('tx_apellidos'));
        UbicacionLista.main.tx_organigrama2.setValue(UbicacionLista.main.store_listaubi.getAt(rowIndex).get('tx_organigrama'));
        UbicacionLista.main.co_organigrama.setValue(UbicacionLista.main.store_listaubi.getAt(rowIndex).get('co_organigrama'));
        UbicacionLista.main.tx_calle.setValue(UbicacionLista.main.store_listaubi.getAt(rowIndex).get('tx_calle'));
        UbicacionLista.main.tx_avenida.setValue(UbicacionLista.main.store_listaubi.getAt(rowIndex).get('tx_avenida'));
        UbicacionLista.main.tx_punto_referencia.setValue(UbicacionLista.main.store_listaubi.getAt(rowIndex).get('tx_punto_referencia'));
        UbicacionLista.main.tx_sector.setValue(UbicacionLista.main.store_listaubi.getAt(rowIndex).get('tx_sector'));
            UbicacionLista.main.list_estatus.setValue(UbicacionLista.main.store_listaubi.getAt(rowIndex).get('in_activo'));
            UbicacionLista.main.list_estatus.selectedIndex=UbicacionLista.main.store_listaubi.getAt(rowIndex).get('in_activo');

            if(UbicacionLista.main.store_listaubi.getAt(rowIndex).get('co_municipio')){
            UbicacionLista.main.list_municipio.setValue(UbicacionLista.main.store_listaubi.getAt(rowIndex).get('co_municipio'));
            UbicacionLista.main.list_municipio.selectedIndex=UbicacionLista.main.store_listaubi.getAt(rowIndex).get('co_municipio');
            UbicacionLista.main.storeCO_PARROQUIA.load({
                        params:{
                            co_municipio:UbicacionLista.main.store_listaubi.getAt(rowIndex).get('co_municipio')
                        },callback:function(){
                             UbicacionLista.main.list_parroquia.setValue(UbicacionLista.main.store_listaubi.getAt(rowIndex).get('co_parroquia'));
                             UbicacionLista.main.list_parroquia.selectedIndex=UbicacionLista.main.store_listaubi.getAt(rowIndex).get('co_parroquia');
                    }
            });  
      
            }else{
                UbicacionLista.main.list_municipio.setValue('');
                UbicacionLista.main.list_municipio.selectedIndex='';
                UbicacionLista.main.list_parroquia.setValue('');
                UbicacionLista.main.list_parroquia.selectedIndex='';
            }
        }
        });
    }
        },
});


this.fieldDatosGrid2= new Ext.form.FieldSet({
    title:'Ubicación',
    autoWidth:true,
    items:[this.fieldDatosUbicacion,
          this.gridPanel2]
});
this.fieldDatosTexto= new Ext.form.FieldSet({
    title:'Datos',
    autoWidth:true,
    items:[this.fieldDatosGeneral,this.fieldDatosDireccion,this.tx_organigrama2]
});
this.formPanel_ = new Ext.form.FormPanel({
  //  frame:true,
  autoWidth:true,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    title: 'Lista de ubicacion',
    items:[this.fieldDatosGrid2,this.fieldDatosTexto],
    buttonAlign:'center',
                buttons:[
                {
                    text:'Modificar',  // Generar la impresión en pdf
                    iconCls:'icon-guardar',
                    handler: this.guardar 
                },{
                    text:'Nuevo',  // Generar la impresión en pdf
                    iconCls:'icon-add',
                    handler: this.nuevo 
                },{
                    text:'Limpiar',  // Generar la impresión en pdf
                    iconCls:'icon-limpiar',
                    handler: this.clear 
                }]
});


this.panel = new Ext.Panel({
//	title: 'Lista de contribuyente',
	border:false,
	items: [this.formPanel_]
});




this.panel.render("contenedorUbicacionLista");

},guardar:function(){
        if(UbicacionLista.main.co_organigrama.getValue()=='' || UbicacionLista.main.co_organigrama.getValue()==null){
            Ext.Msg.alert("Alerta","Debe ingresar una ubicación");
            return false;
        }
        if(UbicacionLista.main.tx_organigrama.getValue()==''){
            Ext.Msg.alert("Alerta","Debe escribir una ubicación");
            return false;
        }
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea editar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ubicacion/guardar',
            params:{
                co_organigrama:	UbicacionLista.main.organigrama.getValue(),
                co_responsables:	UbicacionLista.main.list_rif2.getValue(),
                co_parroquia:	UbicacionLista.main.list_parroquia.getValue(),
                tx_sector:	UbicacionLista.main.tx_sector.getValue(),
                tx_avenida:	UbicacionLista.main.tx_avenida.getValue(),
                tx_calle:	UbicacionLista.main.tx_calle.getValue(),
                tx_punto_referencia:	UbicacionLista.main.tx_punto_referencia.getValue(),
                in_activo:	UbicacionLista.main.list_estatus.getValue(),
                tx_organigrama:UbicacionLista.main.tx_organigrama.getValue()

            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
                    
                    Ext.Msg.alert("Notificación",obj.msg);
                    UbicacionLista.main.store_listaubi.removeAll();
                UbicacionLista.main.storeLIST_UBICACION.load();
                UbicacionLista.main.organigrama.setValue('');
                UbicacionLista.main.tx_organigrama.setValue('');
                UbicacionLista.main.tx_ubicacion.setValue('');
                UbicacionLista.main.list_rif2.setValue(''),
                UbicacionLista.main.responsable.setValue(''),
                UbicacionLista.main.tx_cia.setValue('');
                UbicacionLista.main.co_organigrama.setValue(null);
                UbicacionLista.main.tx_calle.setValue('');
                UbicacionLista.main.tx_avenida.setValue('');
                UbicacionLista.main.tx_punto_referencia.setValue('');
                UbicacionLista.main.tx_sector.setValue('');
                    UbicacionLista.main.list_estatus.setValue(false);
                    UbicacionLista.main.list_estatus.selectedIndex=false;
                UbicacionLista.main.list_municipio.setValue('');
                UbicacionLista.main.list_municipio.selectedIndex='';
                UbicacionLista.main.list_parroquia.setValue('');
                UbicacionLista.main.list_parroquia.selectedIndex='';
                UbicacionLista.main.tx_organigrama2.setValue('');
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                UbicacionLista.main.mascara.hide();

            }});
	}});

    
},nuevo:function(){
    if(!UbicacionLista.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        } 
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea ingresar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ubicacion/nuevo',
            params:{
                co_organigrama:	UbicacionLista.main.co_organigrama.getValue(),
                co_parroquia:	UbicacionLista.main.list_parroquia.getValue(),
                co_responsables:	UbicacionLista.main.list_rif2.getValue(),
                tx_sector:	UbicacionLista.main.tx_sector.getValue(),
                tx_avenida:	UbicacionLista.main.tx_avenida.getValue(),
                tx_calle:	UbicacionLista.main.tx_calle.getValue(),
                tx_punto_referencia:	UbicacionLista.main.tx_punto_referencia.getValue(),
                in_activo:	UbicacionLista.main.list_estatus.getValue(),
                tx_organigrama:UbicacionLista.main.tx_organigrama.getValue()

            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
                    
                    Ext.Msg.alert("Notificación",obj.msg);
                    UbicacionLista.main.store_listaubi.removeAll();
                UbicacionLista.main.storeLIST_UBICACION.load();
                UbicacionLista.main.list_rif2.setValue(''),
                UbicacionLista.main.responsable.setValue(''),
                UbicacionLista.main.organigrama.setValue('');
                UbicacionLista.main.tx_organigrama.setValue('');
                UbicacionLista.main.tx_ubicacion.setValue('');
                UbicacionLista.main.tx_cia.setValue('');
                UbicacionLista.main.co_organigrama.setValue(null);
                UbicacionLista.main.tx_calle.setValue('');
                UbicacionLista.main.tx_avenida.setValue('');
                UbicacionLista.main.tx_punto_referencia.setValue('');
                UbicacionLista.main.tx_sector.setValue('');
                    UbicacionLista.main.list_estatus.setValue(false);
                    UbicacionLista.main.list_estatus.selectedIndex=false;
                UbicacionLista.main.list_municipio.setValue('');
                UbicacionLista.main.list_municipio.selectedIndex='';
                UbicacionLista.main.list_parroquia.setValue('');
                UbicacionLista.main.list_parroquia.selectedIndex='';
                UbicacionLista.main.tx_organigrama2.setValue('');
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                UbicacionLista.main.mascara.hide();

            }});
	}});

    
},clear:function(){
    UbicacionLista.main.tx_organigrama.setValue('');
        UbicacionLista.main.co_organigrama.setValue(null);
        UbicacionLista.main.tx_calle.setValue('');
        UbicacionLista.main.tx_avenida.setValue('');
        UbicacionLista.main.tx_punto_referencia.setValue('');
        UbicacionLista.main.tx_sector.setValue('');
            UbicacionLista.main.list_estatus.setValue(false);
            UbicacionLista.main.list_estatus.selectedIndex=false;
 
      
                UbicacionLista.main.list_municipio.setValue('');
                UbicacionLista.main.list_municipio.selectedIndex='';
                UbicacionLista.main.list_parroquia.setValue('');
                UbicacionLista.main.list_parroquia.selectedIndex='';
                UbicacionLista.main.tx_organigrama2.setValue('');
                
        UbicacionLista.main.list_rif2.setValue('');
        UbicacionLista.main.responsable.setValue('');
    
},getStoreLIST_UBICACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ubicacion/storefklistubicacion',
        root:'data',
        fields:[
            {name: 'co_organigrama'},
            {name: 'co_responsable'},
            {name: 'tx_nombres'},
            {name: 'tx_apellidos'},
            {name: 'tx_organigrama'},
            {name: 'co_padre'},
            {name: 'nu_nivel'},
            {name: 'tx_punto_referencia'},
            {name: 'tx_sector'},
            {name: 'tx_avenida'},
            {name: 'tx_calle'},
            {name: 'co_parroquia'},
            {name: 'cod_adm'},
            {name: 'in_activo'},
            {name: 'cod_cia'}
            
            ]
    });
    return this.store;
},getStoreLIST_UBICACION2:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ubicacion/storefkubicacion2',
        root:'data',
        fields:[
            {name: 'co_organigrama'},
            {name: 'co_responsable'},
            {name: 'tx_nombres'},
            {name: 'tx_apellidos'},
            {name: 'tx_organigrama'},
            {name: 'co_padre'},
            {name: 'nu_nivel'},
            {name: 'tx_punto_referencia'},
            {name: 'tx_sector'},
            {name: 'tx_avenida'},
            {name: 'tx_calle'},
            {name: 'co_parroquia'},
            {name: 'co_municipio'},
            {name: 'in_activo'},
            {name: 'cod_adm'},
            {name: 'cod_cia'},
            {name: 'co_municipio'},
            {name: 'tx_direccion'}
            
            ]
    });
    return this.store;
},getStoreCO_MUNICIPIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ubicacion/storefklistmunicipio',
        root:'data',
        fields:[
            {name: 'co_municipio'},
            {name: 'nb_municipio'}
            
            ]
    });
    return this.store;
},getStoreCO_PARROQUIA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefklistparroquia',
        root:'data',
        fields:[
            {name: 'co_parroquia'},
            {name: 'tx_parroquia'}
            
            ]
    });
    return this.store;
},getStoreLIST_RIF2:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Ubicacion/storefklistresponsables',
        root:'data',
        fields:[
            {name: 'co_responsables'},
            {name: 'nombre'},
            {name: 'nu_cedula'},
             {name: 'tx_nombres'},
             {name: 'tx_apellidos'},
            
            ]
    });
    return this.store;
}

};
Ext.onReady(UbicacionLista.main.init, UbicacionLista.main);
</script>
<div id="contenedorUbicacionLista"></div>
<div id="formularioUbicacion"></div>
<div id="filtroUbicacion"></div>
