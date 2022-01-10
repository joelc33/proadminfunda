<script type="text/javascript">

   Ext.ns("documento");

//----- Función que bloquea los dias en el calendario de la fecha fin dependiendo de la fecha de inicio --//
    Ext.apply(Ext.form.VTypes, {
        daterange : function(val, field) {
            var date = field.parseDate(val);

            if(!date){
                return false;
            }
            if (field.startDateField && (!this.dateRangeMax || (date.getTime() != this.dateRangeMax.getTime()))) {
                var start = Ext.getCmp(field.startDateField);
                start.setMaxValue(date);
                start.validate();
                this.dateRangeMax = date;
            }
            else if (field.endDateField && (!this.dateRangeMin || (date.getTime() != this.dateRangeMin.getTime()))) {
                var end = Ext.getCmp(field.endDateField);
                end.setMinValue(date);
                end.validate();
                this.dateRangeMin = date;
            }
            return true;
        }
    });

//-------------------------------------------------------------------------------------------//
  

   documento.bienes = {
 	init: function(){

        this.storeLIST_UBICACION=this.getStoreLIST_UBICACION();
this.store_listaubi=this.getStoreLIST_UBICACION2();
this.storeLIST_MARCA = this.getStoreLIST_MARCA();
this.storeLIST_MODELO = this.getStoreLIST_MODELO();
this.storeLIST_ESTATUS = this.getStoreLIST_ESTATUS();
this.storeLIST_DESINCORPORACION = this.getStoreLIST_DESINCORPORACION();
this.storeLIST_INCORPORACION = this.getStoreLIST_INCORPORACION();

this.storeCO_TIPO_MOVIMIENTO= this.getStoreCO_TIPO_MOVIMIENTO();
this.storeCO_DOCUMENTO= this.getStoreCO_DOCUMENTO();

        this.fe_inicio = new Ext.form.DateField({
		fieldLabel:'Fecha de inicio',
                id:'fe_inicio',
                name:'fe_inicio',
                format:'d-m-Y',
                vtype: 'daterange',
                    width:250,
                     labelStyle: 'width:120px',
                allowBlank:false,
                endDateField: 'fe_fin',           
                allowBlank:false
	});
        this.fe_fin = new Ext.form.DateField({
		fieldLabel:'Fecha de fin',
                id:'fe_fin',
                name:'fe_fin',
                format:'d-m-Y',
                allowBlank:false,
                vtype: 'daterange',
                    width:250,
                     labelStyle: 'width:120px',
                startDateField: 'fe_inicio',
                allowBlank:false
                
	});


this.list_estatus = new Ext.form.ComboBox({
    fieldLabel:'Estatus',
    labelStyle: 'width:120px',
    store:new Ext.data.SimpleStore({
                        data : [[true, 'ACTIVO'],[false, 'INACTIVO']],
                        fields : ['in_estatus', 'tx_estatus']
                                                       }),
    typeAhead: true,
    valueField: 'in_estatus',
    displayField:'tx_estatus',
    hiddenName:'estatus',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Estatus',
    selectOnFocus: true,
    mode: 'local',
    width:250,
    resizable:true,
    allowBlank:false
});

this.list_incorporado = new Ext.form.ComboBox({
    fieldLabel:'Incorpado',
    labelStyle: 'width:120px',
    store:new Ext.data.SimpleStore({
                        data : [[true, 'INCORPORADO'],[false, 'DESINCORPORADO']],
                        fields : ['in_incor', 'tx_incor']
                                                       }),
    typeAhead: true,
    valueField: 'in_incor',
    displayField:'tx_incor',
    hiddenName:'incorporado',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Estatus',
    selectOnFocus: true,
    mode: 'local',
    width:250,
    resizable:true,
    allowBlank:false,
    listeners: {
                   'select': function(combo, rec, index){ 
                      // alert('ds');
                    documento.bienes.co_tipo_movimiento.setValue('');
                    documento.bienes.list_documento.setValue('');
                    if(rec.get('in_incor')){
                        documento.bienes.storeCO_TIPO_MOVIMIENTO.load({  params:{
                            co_tipo_movimiento: 1
                        }});
                        documento.bienes.storeCO_DOCUMENTO.load({  params:{
                            co_tipo_documento: 1
                        }});
                    }else{
                        documento.bienes.storeCO_TIPO_MOVIMIENTO.load({  params:{
                            co_tipo_movimiento: 3
                        }});
                        documento.bienes.storeCO_DOCUMENTO.load({  params:{
                            co_tipo_documento: 3
                        }});
                    }
                                         
                        }
                    }  
});

this.fieldDatosEstatus= new Ext.Panel({
    width:1000,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.list_estatus]},
                {items:[this.list_incorporado]}
                           ]}]
            
                   });

//this.storeID_EJECUTOR.load();
this.list_documento = new Ext.form.ComboBox({
    fieldLabel:'Tipo Documento',
    store: this.storeCO_DOCUMENTO,
    typeAhead: true,
    labelStyle: 'width:120px',
    valueField: 'co_documento',
    displayField:'desc_documento',
    hiddenName:'co_documento',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Documento',
    selectOnFocus: true,
    mode: 'local',
    width:350,
    resizable:true,
    allowBlank:true
  });
//this.list_documento.hide();

this.co_tipo_movimiento = new Ext.form.ComboBox({
    fieldLabel:'Tipo de Movimiento',
    store: this.storeCO_TIPO_MOVIMIENTO,
    typeAhead: true,
    labelStyle: 'width:120px',
    valueField: 'co_subtipo_movimiento_bienes',
    displayField:'tx_subtipo_movimiento',
    hiddenName:'co_subtipo_movimiento_bienes',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione el tipo de movimiento',
    selectOnFocus: true,
    mode: 'local',
    width:350,
    resizable:true,
    allowBlank:false
});

this.fieldDatosMov= new Ext.Panel({
    width:1000,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.co_tipo_movimiento]},
                {items:[this.list_documento]}
                           ]}]
            
                   });
//this.co_tipo_movimiento.hide();

this.list_marca = new Ext.form.ComboBox({
    fieldLabel:'Marca',
     labelStyle: 'width:120px',
    store: this.storeLIST_MARCA,
    typeAhead: true,
    valueField: 'co_marca',
    displayField:'tx_marca',
    hiddenName:'co_marca',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Marca',
    selectOnFocus: true,
    mode: 'local',
    width:250,
    resizable:true,
    allowBlank:true,
     listeners: {
                   'select': function(combo, rec, index){ 
                   documento.bienes.list_modelo.setValue('');                        
                    documento.bienes.storeLIST_MODELO.load({
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
     labelStyle: 'width:120px',
    store: this.storeLIST_MODELO,
    typeAhead: true,
    valueField: 'co_modelo',
    displayField:'tx_modelo',
    hiddenName:'co_modelo',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Modelo',
    selectOnFocus: true,
    mode: 'local',
    width:250,
    resizable:true,
    allowBlank:true
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
this.tx_codigo = new Ext.form.TextField({
    fieldLabel:'Numero Bien',
    labelStyle: 'width:120px',
    name:'numero',
    allowBlank:true,
    width:250
});


this.tx_serial = new Ext.form.TextField({
    fieldLabel:'Serial Bien',
    labelStyle: 'width:120px',
    name:'serial',
    allowBlank:true,
    width:250
});

this.tx_descripcion = new Ext.form.TextField({
    fieldLabel:'Detalle Bien',
    labelStyle: 'width:120px',
    name:'bien',
    allowBlank:true,
    width:750
});

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
    allowBlank:true
    });
this.storeLIST_UBICACION.load();


this.tx_ubicacion = new Ext.form.TextField({
    fieldLabel:'Codigo',
    labelStyle: 'width:120px',
    name:'tx_ubicacion',
    allowBlank:false,
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
                            if(documento.bienes.tx_ubicacion.getValue() && documento.bienes.tx_cia.getValue() ){
                            documento.bienes.store_listaubi.load({
                            params:{
                                tx_ubicacion:documento.bienes.tx_ubicacion.getValue(),
                                tx_cia:documento.bienes.tx_cia.getValue()
                                },callback:function(records,operation,success){
                                    var f = '';
                                    var i= 1;
                                    this.each(function(record,index){
                                        if(i==1){
                                            f=record.data.co_organigrama;
                                            i--;
                                        }
                                       
                                    },this);
                                        documento.bienes.organigrama.setValue(f);
                                        
                                }

                            });
                            documento.bienes.storeLIST_UBICACION.load({
                                params:{
                                    tx_ubicacion:documento.bienes.tx_ubicacion.getValue(),
                                    tx_cia:documento.bienes.tx_cia.getValue()
                                },

                            });
                            documento.bienes.organigrama.setValue(documento.bienes.list_ubicacion.getValue());
                            documento.bienes.list_ubicacion.setValue('');
                            
                            }
                        }
                    }, this);
                        
    this.tx_ubicacion.on('blur',function(){
        if(documento.bienes.tx_ubicacion.getValue() && documento.bienes.tx_cia.getValue() ){
                            documento.bienes.store_listaubi.load({
                            params:{
                                tx_ubicacion:documento.bienes.tx_ubicacion.getValue(),
                                tx_cia:documento.bienes.tx_cia.getValue()
                                },callback:function(records,operation,success){
                                    var f = '';
                                    var i= 1;
                                    this.each(function(record,index){
                                        if(i==1){
                                            f=record.data.co_organigrama;
                                            i--;
                                        }
                                       
                                    },this);
                                        documento.bienes.organigrama.setValue(f);
                                        
                                }

                            });
                            documento.bienes.storeLIST_UBICACION.load({
                                params:{
                                    tx_ubicacion:documento.bienes.tx_ubicacion.getValue(),
                                    tx_cia:documento.bienes.tx_cia.getValue()
                                },

                            });
                            documento.bienes.organigrama.setValue(documento.bienes.list_ubicacion.getValue());
                            documento.bienes.list_ubicacion.setValue('');
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
                           //alert(documento.bienes.list_ubicacion.getValue());
                           if(documento.bienes.list_ubicacion.getValue()){
                            documento.bienes.store_listaubi.load({
                          params:{
                                 co_organigrama:documento.bienes.list_ubicacion.getValue()
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
                                    
                                        documento.bienes.tx_ubicacion.setValue(f);
                                        documento.bienes.tx_cia.setValue(c);
                                }

                            });
                            documento.bienes.storeLIST_UBICACION.load({
                                params:{
                                 co_organigrama:documento.bienes.list_ubicacion.getValue()
                                },

                            });             
                            documento.bienes.organigrama.setValue(documento.bienes.list_ubicacion.getValue());
                            documento.bienes.list_ubicacion.setValue('');

                            
                            }
                            //documento.bienes.confirmarFormulario();
                           
                    }
});
this.limpiar= new Ext.Button({
    text:'Limpiar',
    iconCls: 'icon-limpiar',
    handler:function(){
        documento.bienes.store_listaubi.removeAll();
        documento.bienes.storeLIST_UBICACION.load();
        documento.bienes.organigrama.setValue('');
        documento.bienes.tx_ubicacion.setValue('');
        documento.bienes.tx_cia.setValue('');

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
            {header: 'Ubicación',width:450, menuDisabled:true,sortable: true,dataIndex: 'tx_organigrama'},
            {header: 'Nivel Jerargico',width:100, menuDisabled:true,sortable: true,dataIndex: 'nu_nivel'},
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

this.fieldDatosFiltro= new Ext.Panel({
    border:false,
     width:1000,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.tx_codigo]}
                           ]}]
            
                   });
this.fieldFechaFiltro= new Ext.Panel({
    border:false,
     width:1000,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.fe_inicio]},
                 {items:[this.fe_fin]}
                           ]}]
            
                   });
                  
        this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [this.fieldFechaFiltro,
                        this.fieldDatosGrid2,
                        this.organigrama,
                        this.tx_descripcion,
                          this.fieldDatosMarca,
                          this.fieldDatosFiltro,
                          this.fieldDatosEstatus,
                          this.fieldDatosMov
                    ]
        });
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestra un reporte detallado de los bienes incorporados y desincorporados.</p></b></font><FONT SIZE=2><p>1.Seleccione los parametros de acuerdo a la busquedad requerida</p><p>2.Presione el Botón Consultar</p><p></font>',
});
 	this.formpanel = new Ext.form.FormPanel({
		bodyStyle: 'padding:10px',
		autoWidth:true,
		autoHeight:true,
                id: 'forma',
                iconCls:'',
                title: 'Reporte de Bienes',
                url: '',
                defaults:{style: 'margin-bottom:10px'},
		items:[
                
                        this.tipo_planilla,this.Descripcion

                ],
                buttonAlign:'center',
                buttons:[
                {
                    text:'Consultar',  // Generar la impresión en pdf
                    iconCls:'icon-buscar',
                    handler: this.onImprimir 
                },
                {
               	    text:'Limpiar',  // Limpiar campos del formulario
                    iconCls:'icon-limpiar',
                    handler: this.onLimpiar
                }]

	});


        this.formpanel.render('mainPrincipal');
     

 	},        
        onImprimir : function() {
        
        if(!documento.bienes.formpanel.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar correctamente los paramentros de busqueda requeridos");
            return false;
        }

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/bienGeneral.php?'+documento.bienes.formpanel.getForm().getValues(true));

         },getStoreLIST_MARCA:function(){
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
}
,getStoreLIST_ESTATUS:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefklistestatus',
        root:'data',
        fields:[
            {name: 'in_estatus'},
            {name: 'tx_estatus'}
            
            ]
    });
    return this.store;
},getStoreLIST_DESINCORPORACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefklistdesincorporacion',
        root:'data',
        fields:[
            {name: 'co_tipo_desincorporacion'},
            {name: 'tx_tipo_desincorporacion'}
            
            ]
    });
    return this.store;
},getStoreLIST_INCORPORACION:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefklistincorporacion',
        root:'data',
        fields:[
            {name: 'co_tipo_incorporacion'},
            {name: 'tx_tipo_incorporacion'}
            
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
},getStoreCO_TIPO_MOVIMIENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefkcotipomovimiento',
        root:'data',
        fields:[
            {name: 'co_subtipo_movimiento_bienes'},
            {name: 'tx_subtipo_movimiento'}
            ]
    });
    return this.store;
},getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'},
            {name: 'desc_documento'},
            {name: 'tx_documento'},
            ]
    });
    return this.store;
}

 }

Ext.onReady(documento.bienes.init, documento.bienes);

</script>
<div id="mainPrincipal"></div>
