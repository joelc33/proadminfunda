<script type="text/javascript">
Ext.ns("listaInm");
listaInm.main = {
init:function(){


this.storeLIST_CLASIFICACION = this.getStoreLIST_CLASIFICACION();
this.storeLIST_TIPO = this.getStoreLIST_TIPO();
this.storeCO_MUNICIPIO= this.getStoreCO_MUNICIPIO();
this.storeCO_PARROQUIA= this.getStoreCO_PARROQUIA();
this.storeCO_MEDIDAS= this.getStoreCO_MEDIDAS();

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:InmRegistro.main.co_solicitud.getValue()
});

//-----------------------COSAS PARA LA DEXCRIPCION GENERAL------------------
this.tx_observacion = new Ext.form.TextField({
	fieldLabel:'Denominación',
	name:'tx_observacion',
	allowBlank:false,
	width:650
});
this.tx_observacion.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            listaInm.main.tx_observacion.setValue(listaInm.main.tx_observacion.getValue().toUpperCase());  

                        }
                    }, this);
                        
this.tx_observacion.on('blur',function(){
                             listaInm.main.tx_observacion.setValue(listaInm.main.tx_observacion.getValue().toUpperCase()); 
                    });

this.tx_descripcion = new Ext.form.TextField({
	fieldLabel:'Descripción',
	name:'tx_descripcion',
	allowBlank:false,
	width:650
});

this.tx_descripcion.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            listaInm.main.tx_descripcion.setValue(listaInm.main.tx_descripcion.getValue().toUpperCase());  

                        }
                    }, this);
                        
this.tx_descripcion.on('blur',function(){
                             listaInm.main.tx_descripcion.setValue(listaInm.main.tx_descripcion.getValue().toUpperCase()); 
                    });

this.tx_motivo = new Ext.form.TextField({
    fieldLabel:'Motivo Incorporación',
    name:'producto',
    allowBlank:false,
    width:650
});

this.tx_motivo.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                           // alert('funciona');
                            listaInm.main.tx_motivo.setValue(listaInm.main.tx_motivo.getValue().toUpperCase());
                            listaInm.main.confirmarFormulario();  

                        }
                    }, this);
                        
    this.tx_motivo.on('blur',function(){
        //alert('funciona');
        listaInm.main.tx_motivo.setValue(listaInm.main.tx_motivo.getValue().toUpperCase());
        listaInm.main.confirmarFormulario();  
                    }); 


this.tx_legal = new Ext.form.TextField({
	fieldLabel:'Estudio legal de la propiedad',
	name:'tx_descripcion',
	allowBlank:false,
	width:650
});

this.tx_legal.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            listaInm.main.tx_legal.setValue(listaInm.main.tx_legal.getValue().toUpperCase());  

                        }
                    }, this);
                        
this.tx_legal.on('blur',function(){
                             listaInm.main.tx_legal.setValue(listaInm.main.tx_legal.getValue().toUpperCase()); 
                    });

this.list_clasificacion = new Ext.form.ComboBox({
    fieldLabel:'Clasificación',
    store: this.storeLIST_CLASIFICACION,
    typeAhead: true,
    valueField: 'co_clasificacion_inmueble',
    displayField:'tx_clasificacion_inmueble',
    hiddenName:'tbbn012_clasificacion_inmueble[co_clasificacion_inmueble]',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Clasificación',
    selectOnFocus: true,
    mode: 'local',
    width:650,
    resizable:true,
    allowBlank:false,
      onSelect: function(record){
        listaInm.main.list_clasificacion.setValue(record.data.co_clasificacion_inmueble);
    this.collapse();
  }
});
this.storeLIST_CLASIFICACION.load();

this.list_tipo= new Ext.form.ComboBox({
    fieldLabel:'Tipo',
    store: this.storeLIST_TIPO,
    typeAhead: true,
    valueField: 'co_tipo_inmueble',
    displayField:'tx_tipo_inmueble',
    hiddenName:'tbbn014_tipo_inmueble[co_tipo_inmueble]',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Tipo',
    selectOnFocus: true,
    mode: 'local',
    width:650,
    resizable:true,
    allowBlank:false,
      onSelect: function(record){
        listaInm.main.list_tipo.setValue(record.data.co_tipo_inmueble);
    this.collapse();
  }
});
this.storeLIST_TIPO.load();

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
        listaInm.main.list_municipio.setValue(record.data.co_municipio);
        listaInm.main.list_parroquia.setValue('');
        listaInm.main.storeCO_PARROQUIA.load({
                        params:{
                            co_municipio:record.data.co_municipio
                        }
                    });  
    this.collapse();
  }
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
        listaInm.main.list_parroquia.setValue(record.data.co_parroquia);
        
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
                            listaInm.main.tx_avenida.setValue(listaInm.main.tx_avenida.getValue().toUpperCase());  

                        }
                    }, this);
                        
this.tx_avenida.on('blur',function(){
                             listaInm.main.tx_avenida.setValue(listaInm.main.tx_avenida.getValue().toUpperCase()); 
                    });

this.tx_calle = new Ext.form.TextField({
	fieldLabel:'Calle',
	name:'tx_calle',
	allowBlank:false,
	width:250
});


this.tx_calle.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            listaInm.main.tx_calle.setValue(listaInm.main.tx_calle.getValue().toUpperCase());  

                        }
                    }, this);
                        
this.tx_calle.on('blur',function(){
                             listaInm.main.tx_calle.setValue(listaInm.main.tx_calle.getValue().toUpperCase()); 
                    });

this.tx_punto_referencia = new Ext.form.TextField({
	fieldLabel:'Punto de Referencia',
	name:'tx_punto_referencia',
	allowBlank:false,
	width:650
});

this.tx_punto_referencia.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            listaInm.main.tx_punto_referencia.setValue(listaInm.main.tx_punto_referencia.getValue().toUpperCase());  

                        }
                    }, this);
                        
this.tx_punto_referencia.on('blur',function(){
                             listaInm.main.tx_punto_referencia.setValue(listaInm.main.tx_punto_referencia.getValue().toUpperCase()); 
                    });

this.tx_sector = new Ext.form.TextField({
	fieldLabel:'Sector',
	name:'tx_sector',
	allowBlank:false,
	width:650
});

this.tx_sector.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            listaInm.main.tx_sector.setValue(listaInm.main.tx_sector.getValue().toUpperCase());  

                        }
                    }, this);
                        
this.tx_sector.on('blur',function(){
                             listaInm.main.tx_sector.setValue(listaInm.main.tx_sector.getValue().toUpperCase()); 
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

//------------------------------------COSAS DE LINDEROS-----------------------------
this.tx_norte = new Ext.form.TextField({
	fieldLabel:'Norte',
	name:'tx_norte',
	allowBlank:false,
	width:650
});
this.tx_norte.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            listaInm.main.tx_norte.setValue(listaInm.main.tx_norte.getValue().toUpperCase());  

                        }
                    }, this);
                        
this.tx_norte.on('blur',function(){
                             listaInm.main.tx_norte.setValue(listaInm.main.tx_norte.getValue().toUpperCase()); 
                    });
this.tx_sur = new Ext.form.TextField({
	fieldLabel:'Sur',
	name:'tx_sur',
	allowBlank:false,
	width:650
});
this.tx_sur.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            listaInm.main.tx_sur.setValue(listaInm.main.tx_sur.getValue().toUpperCase());  

                        }
                    }, this);
                        
this.tx_sur.on('blur',function(){
                             listaInm.main.tx_sur.setValue(listaInm.main.tx_sur.getValue().toUpperCase()); 
                    });
this.tx_este = new Ext.form.TextField({
	fieldLabel:'Este',
	name:'tx_este',
	allowBlank:false,
	width:650
});

this.tx_este.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            listaInm.main.tx_este.setValue(listaInm.main.tx_este.getValue().toUpperCase());  

                        }
                    }, this);
                        
this.tx_este.on('blur',function(){
                             listaInm.main.tx_este.setValue(listaInm.main.tx_este.getValue().toUpperCase()); 
                    });

this.tx_oeste = new Ext.form.TextField({
	fieldLabel:'Oeste',
	name:'tx_oeste',
	allowBlank:false,
	width:650
});
this.tx_oeste.on('specialkey', function(f, event) {
                        if(event.getKey() == event.ENTER) {
                            listaInm.main.tx_oeste.setValue(listaInm.main.tx_oeste.getValue().toUpperCase());  

                        }
                    }, this);
                        
this.tx_oeste.on('blur',function(){
                             listaInm.main.tx_oeste.setValue(listaInm.main.tx_oeste.getValue().toUpperCase()); 
                    });
//------------------------------------COSAS DE AREA-----------------------------
this.list_medidas = new Ext.form.ComboBox({
    fieldLabel:'Medidas',
    store: this.storeCO_MEDIDAS,
    typeAhead: true,
    valueField: 'id',
    displayField:'de_unidad_medida',
    hiddenName:'tb089_unidad_medida[id]',
    forceSelection:true,
    resizable:true,
    triggerAction: 'all',
    emptyText:'Seleccione Medida',
    selectOnFocus: true,
    mode: 'local',
    width:250,
    resizable:true,
    allowBlank:false,
      onSelect: function(record){
        listaInm.main.list_medidas.setValue(record.data.id);
    this.collapse();
  }
});
this.storeCO_MEDIDAS.load();

this.tx_terreno = new Ext.form.NumberField({
	fieldLabel:'Area terreno',
	name:'tx_terreno',
    minValue : 0,
    allowDecimals : true,
    decimalPrecision : 5,
    decimalSeparator : '.',
    allowNegative : false,
	allowBlank:false,
	width:250
});

this.tx_construido = new Ext.form.NumberField({
	fieldLabel:'Area construido',
	name:'tx_construido',
    minValue : 0,
    allowDecimals : true,
    decimalPrecision : 5,
    decimalSeparator : '.',
    allowNegative : false,
	allowBlank:false,
	width:250
});

this.tx_cubierto = new Ext.form.NumberField({
	fieldLabel:'Area cubierta',
	name:'tx_cubierto',
    minValue : 0,
    allowDecimals : true,
    decimalPrecision : 5,
    decimalSeparator : '.',
    allowNegative : false,
	allowBlank:false,
	width:250
});

this.tx_oi = new Ext.form.NumberField({
	fieldLabel:'Area de otras instalaciones',
	name:'tx_oi',
    minValue : 0,
    allowDecimals : true,
    decimalPrecision : 5,
    decimalSeparator : '.',
    allowNegative : false,
	allowBlank:false,
	width:250
});
 
 
this.fieldDatosArea1= new Ext.Panel({
    width:800,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.tx_terreno]},
                 {items:[this.tx_construido]}
                           ]}]
            
                   });

this.fieldDatosArea2= new Ext.Panel({
    width:800,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.tx_cubierto]},
                 {items:[this.tx_oi]}
                           ]}]
            
                   });

//------------------------------------COSAS DE AVALUO----------------------------
this.mo_avaluo = new Ext.form.NumberField({
	fieldLabel:'Avaluo Actual',
	name:'mo_avaluo',
    minValue : 0,
    allowDecimals : true,
    decimalPrecision : 5,
    decimalSeparator : '.',
    allowNegative : false,
	allowBlank:false,
	width:250
});

this.mo_precio = new Ext.form.NumberField({
	fieldLabel:'Precio',
	name:'mo_precio',
    minValue : 0,
    allowDecimals : true,
    decimalPrecision : 5,
    decimalSeparator : '.',
    allowNegative : false,
	allowBlank:false,
	width:250
});

this.fieldDatosPrecio= new Ext.Panel({
    width:800,
    border:false,
    items:[{layout:'column',border:false,
          defaults:{layout:'form',columnWidth:.5, border:false},
          items:[{items:[this.mo_avaluo]},
                 {items:[this.mo_precio]}
                           ]}]
            
                   });








this.fieldDatosGeneral= new Ext.form.FieldSet({
    title: 'Datos generales',
    items:[this.tx_observacion,
            this.tx_descripcion,
            this.list_clasificacion,
            this.list_tipo,
            this.tx_legal,
            this.tx_motivo]
});



this.fieldDatosUbicacion= new Ext.form.FieldSet({
    title: 'Datos Ubicación',
    items:[this.fieldDatosParroquia,
           this.fieldDatosCalle,
           this.tx_sector,
           this.tx_punto_referencia]
});

this.fieldDatosLinderos= new Ext.form.FieldSet({
    title: 'Datos de linderos',
    items:[this.tx_norte,
            this.tx_sur,
            this.tx_este,
            this.tx_oeste]
});


this.fieldDatosAreas= new Ext.form.FieldSet({
    title: 'Datos del area total de la construcción',
    items:[this.list_medidas,
            this.fieldDatosArea1,
            this.fieldDatosArea2]
});

this.fieldDatosAvaluo= new Ext.form.FieldSet({
    title: 'Datos del avaluo y otros montos',
    items:[this.fieldDatosPrecio]
});


this.guardar = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-guardar',
    handler:function(){
        if(!listaInm.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        } 
        
          Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/agregarInmueble',
            params:{
                co_solicitud:InmRegistro.main.co_solicitud.getValue(),
                co_usuario:InmRegistro.main.co_usuario.getValue(),
                co_tipo_documento:InmRegistro.main.list_documento.getValue(),

                tx_observacion:listaInm.main.tx_observacion.getValue(),
                tx_descripcion:listaInm.main.tx_descripcion.getValue(),
                co_clasificacion:listaInm.main.list_clasificacion.getValue(),
                co_tipo:listaInm.main.list_tipo.getValue(),
                tx_legal:listaInm.main.tx_legal.getValue(),
                tx_motivo:listaInm.main.tx_motivo.getValue(),
                co_parroquia:listaInm.main.list_parroquia.getValue(),
                tx_avenida:listaInm.main.tx_avenida.getValue(),
                tx_calle:listaInm.main.tx_calle.getValue(),
                tx_sector:listaInm.main.tx_sector.getValue(),
                tx_punto_referencia:listaInm.main.tx_punto_referencia.getValue(),

                tx_norte:listaInm.main.tx_norte.getValue(),
                tx_sur:listaInm.main.tx_sur.getValue(),
                tx_este:listaInm.main.tx_este.getValue(),
                tx_oeste:listaInm.main.tx_oeste.getValue(),

                co_medida:listaInm.main.list_medidas.getValue(),
                tx_terreno:listaInm.main.tx_terreno.getValue(),
                tx_construido:listaInm.main.tx_construido.getValue(),
                tx_cubierto:listaInm.main.tx_cubierto.getValue(),
                tx_oi:listaInm.main.tx_oi.getValue(),

                nu_avaluo:listaInm.main.mo_avaluo.getValue(),
                nu_precio:listaInm.main.mo_precio.getValue(),



            },
            success:function(result, request ) {
                Ext.utiles.msg('Mensaje', "El Inmueble se agrego exitosamente"); 
                          InmRegistro.main.store_lista.load();
         InmRegistro.main.gridPanel.getView().refresh();
                listaInm.main.winformPanel_.close();      
            }});

        //------------GENERAL
        listaInm.main.tx_descripcion.setValue(""); 
        listaInm.main.tx_observacion.setValue(""); 
        listaInm.main.tx_legal.setValue(""); 

         //------------UBICACION
         listaInm.main.tx_descripcion.setValue(""); 
        listaInm.main.tx_observacion.setValue(""); 
        listaInm.main.tx_legal.setValue(""); 

        //
    }
});
//this.guardar.disable();

this.salir = new Ext.Button({
    text:'Salir',
    iconCls: 'icon-cancelar',
    handler:function(){
        listaInm.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
  //  frame:true,
    width:800,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.fieldDatosGeneral,
            this.fieldDatosUbicacion,
            this.fieldDatosLinderos,
            this.fieldDatosAreas,
            this.fieldDatosAvaluo]
});

this.winformPanel_ = new Ext.Window({
    title:'Lista de Bienes',
    modal:true,
    constrain:true,
    width:820,
    height:800,
    autoScroll:true,
  //  frame:true,
    closabled:true,
    items:[
        this.formPanel_
    ],
    buttons:[
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
},confirmarFormulario:function(){
        if(listaInm.main.list_clasificacion.getValue() && listaInm.main.list_tipo.getValue()){

            listaInm.main.guardar.enable();
           }else{
            listaInm.main.guardar.disable();
           }

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
},getStoreCO_MUNICIPIO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefklistmunicipio',
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
},getStoreCO_MEDIDAS:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Bienes/storefklistmedidas',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'de_unidad_medida'}
            
            ]
    });
    return this.store;
}
};
Ext.onReady(listaInm.main.init, listaInm.main);
</script>
