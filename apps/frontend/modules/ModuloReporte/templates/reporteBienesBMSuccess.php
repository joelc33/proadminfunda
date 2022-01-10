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


this.list_reporte = new Ext.form.ComboBox({
    fieldLabel:'Reporte',
    labelStyle: 'width:120px',
    store:new Ext.data.SimpleStore({
                        data : [[1, 'BM-1'],[2, 'BM-2'],[3, 'BM-3']],
                        fields : ['co_reporte', 'tx_reporte']
                                                       }),
    typeAhead: true,
    valueField: 'co_reporte',
    displayField:'tx_reporte',
    hiddenName:'reporte',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Reporte',
    selectOnFocus: true,
    mode: 'local',
    width:250,
    resizable:true,
    allowBlank:false
});

this.fieldDatosEstatus= new Ext.Panel({
    width:1000,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.list_reporte]}
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
                          this.fieldDatosEstatus,
                          this.organigrama,
                          this.fieldDatosGrid2
                    ]
        });
        
	this.Descripcion = new Ext.Panel({
		title: 'Descripcion',
		autoWidth:true,
		border:false,
		padding	: 10,
		html:'<FONT SIZE=2><p><b>Muestras los reportes BM-1, BM-2 y BM-3.</p></b></font><FONT SIZE=2><p>1.Seleccione los parametros de acuerdo a la busquedad requerida</p><p>2.Presione el Botón Consultar</p><p></font>',
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
                window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/bienBM'+documento.bienes.list_reporte.getValue()+'.php?'+documento.bienes.formpanel.getForm().getValues(true));
         
            

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
}

 }

Ext.onReady(documento.bienes.init, documento.bienes);

</script>
<div id="mainPrincipal"></div>
