<script type="text/javascript">
Ext.ns("BienesFiltro");
BienesFiltro.main = {
init:function(){

this.storeLIST_MARCA = this.getStoreLIST_MARCA();
this.storeLIST_MODELO = this.getStoreLIST_MODELO();
this.storeLIST_ESTATUS = this.getStoreLIST_ESTATUS();



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
    allowBlank:false
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
                    BienesFiltro.main.list_modelo.setValue('');                        
                    BienesFiltro.main.storeLIST_MODELO.load({
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
    allowBlank:false
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
this.tx_descripcion = new Ext.form.TextField({
    fieldLabel:'Detalle Bien',
    labelStyle: 'width:120px',
    name:'bien',
    allowBlank:false,
    width:750
});



    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       height:150,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                          this.tx_descripcion,
                          this.fieldDatosMarca,
                          this.fieldDatosEstatus
                                           ]
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

    this.win = new Ext.Window({
        title:'Parametros de busqueda',
        iconCls: 'icon-buscar',
        width:1000,
        autoHeight:true,
        constrain:true,
        closable:false,
        buttonAlign:'center',
        items:[
            this.panelfiltro
        ],
        buttons:[
            {
                text:'Filtrar',
                handler:function(){
                     BienesFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    BienesFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    BienesFiltro.main.win.close();
                    BienesLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    BienesLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    BienesFiltro.main.panelfiltro.getForm().reset();
    BienesLista.main.panelfiltro.getForm().reset();
    BienesLista.main.store_lista.baseParams={}
    BienesLista.main.store_lista.baseParams.paginar = 'si';
    BienesLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = BienesFiltro.main.panelfiltro.getForm().getValues();
    var campo2 = BienesLista.main.panelfiltro.getForm().getValues();
    BienesLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName2 in campo2){
        if(campo2[campName2]!=''){
            swfiltrar = true;
            eval("BienesLista.main.store_lista.baseParams."+campName2+" = '"+campo2[campName2]+"';");
        }
    }

    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("BienesLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        BienesLista.main.store_lista.baseParams.paginar = 'si';
        BienesLista.main.store_lista.baseParams.BuscarBy = true;
        BienesLista.main.store_lista.load();


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
}
};

Ext.onReady(BienesFiltro.main.init,BienesFiltro.main);
</script>
