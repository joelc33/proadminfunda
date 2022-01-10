<script type="text/javascript">
Ext.ns("AgregarSueldo");
AgregarSueldo.main = {
    init:function(){
        
            this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
            
            this.storeCO_NOMINA         = this.getStoreCO_TP_NOMINA();
            this.storeCO_CARGO          = this.getStoreCO_CARGO();
            this.storeCO_TIPO_CARGO      = this.getStoreCO_TIPO_CARGO();
            this.storeCO_TIPO_PAGO      = this.getStoreCO_TIPO_PAGO();
            this.storeCO_GRUPO_NOMINA   = this.getStoreCO_GRUPO_NOMINA();
            this.storeCO_TABULADOR   = this.getStoreCO_TABULADOR();
                         
            this.co_nom_trabajador = new Ext.form.Hidden({
                name:'co_nom_trabajador',
                value:this.OBJ.co_nom_trabajador
            });
            
            this.co_estructura_administrativa = new Ext.form.Hidden({
                name:'co_estructura_administrativa',
                value:this.OBJ.co_estructura_administrativa
            });
            
            this.co_nom_trabajador = new Ext.form.Hidden({
                name:'co_nom_trabajador',
                value:this.OBJ.co_nom_trabajador
            });
            
            this.co_clasif_personal = new Ext.form.Hidden({
                name:'co_clasif_personal',
                value:this.OBJ.co_clasif_personal
            });            
                                  
            this.co_tp_nomina = new Ext.form.ComboBox({
                    fieldLabel:'Nomina',
                    store: this.storeCO_NOMINA,
                    typeAhead: true,
                    valueField: 'co_tp_nomina',
                    displayField:'tx_tp_nomina',
                    hiddenName:'co_tp_nomina',
                    forceSelection:true,
                    resizable:true,
                    triggerAction: 'all',
                    selectOnFocus: true,
                    mode: 'local',
                    width:250,
                    allowBlank:false,
                    listeners:{
                        select: function(combo, rec, index){     
                            AgregarSueldo.main.co_clasif_personal.setValue(rec.data.co_clasif_personal);
                            AgregarSueldo.main.co_tabulador.clearValue();
                            AgregarSueldo.main.co_grupo_nomina.clearValue();
                            AgregarSueldo.main.mo_sueldo.setValue("");
                            AgregarSueldo.main.storeCO_TABULADOR.baseParams.co_clasif_personal=AgregarSueldo.main.co_clasif_personal.getValue();
                            AgregarSueldo.main.storeCO_TABULADOR.load();                            
                            AgregarSueldo.main.storeCO_CARGO.baseParams.co_estructura_administrativa=AgregarSueldo.main.co_estructura_administrativa.getValue();
                            AgregarSueldo.main.storeCO_CARGO.baseParams.co_clasif_personal=rec.data.co_clasif_personal;
                            AgregarSueldo.main.storeCO_CARGO.load();
                            AgregarSueldo.main.storeCO_GRUPO_NOMINA.baseParams.co_tp_nomina=this.getValue();
                            AgregarSueldo.main.storeCO_GRUPO_NOMINA.load();
                        }
                    }
            });
            
            this.storeCO_NOMINA.load({
                callback: function(){
                    AgregarSueldo.main.co_tp_nomina.setValue(AgregarSueldo.main.OBJ.co_tp_nomina);
                }
            });
            
            this.co_grupo_nomina = new Ext.form.ComboBox({
                    fieldLabel:'Grupo',
                    store: this.storeCO_GRUPO_NOMINA,
                    typeAhead: true,
                    valueField: 'co_grupo_nomina',
                    displayField:'tx_grupo_nomina',
                    hiddenName:'co_grupo_nomina',
                    forceSelection:true,
                    resizable:true,
                    triggerAction: 'all',
                    selectOnFocus: true,
                    mode: 'local',
                    width:250,
                    allowBlank:false
            });
            
            this.storeCO_GRUPO_NOMINA.load({
                params:{
                  co_tp_nomina: AgregarSueldo.main.OBJ.co_tp_nomina   
                },
                callback: function(){
                    AgregarSueldo.main.co_grupo_nomina.setValue(AgregarSueldo.main.OBJ.co_grupo_nomina);
                }
            });
            
            this.co_cargo = new Ext.form.ComboBox({
                    fieldLabel:'Cargo',
                    store: this.storeCO_CARGO,
                    typeAhead: true,
                    valueField: 'co_cargo_estructura',
                    displayField:'tx_cargo',
                    hiddenName:'co_cargo',
                    forceSelection:true,
                    resizable:true,
                    triggerAction: 'all',
                    selectOnFocus: true,
                    mode: 'local',
                    width:500,
                    allowBlank:false,
                    listeners:{
                        select: function(){
                           AgregarSueldo.main.mo_sueldo.setValue("");
                           if(AgregarSueldo.main.co_tipo_pago.getValue()==1)
                            AgregarSueldo.main.verificarSueldo();
                        }
                    }
            });
            
            this.storeCO_CARGO.load({
                params:{
                    co_estructura_administrativa: AgregarSueldo.main.OBJ.co_estructura_administrativa,
                    co_clasif_personal: AgregarSueldo.main.OBJ.co_clasif_personal
                },
                callback: function(){
                    AgregarSueldo.main.co_cargo.setValue(AgregarSueldo.main.OBJ.co_cargo_estructura);
                }
            });
            
            this.co_tipo_pago = new Ext.form.ComboBox({
                    fieldLabel:'Tipo de Pago',
                    store: this.storeCO_TIPO_PAGO,
                    typeAhead: true,
                    valueField: 'co_tipo_pago',
                    displayField:'tx_tipo_pago',
                    hiddenName:'co_tipo_pago',
                    forceSelection:true,
                    resizable:true,
                    triggerAction: 'all',
                    selectOnFocus: true,
                    mode: 'local',
                    width:200,
                    listeners:{
                        select: function(){
                           AgregarSueldo.main.mo_sueldo.setValue("");
                           AgregarSueldo.main.co_tabulador.clearValue();
                           if(AgregarSueldo.main.co_tipo_pago.getValue()==1){
                                AgregarSueldo.main.mo_sueldo.setReadOnly(true);
                            }else{
                                AgregarSueldo.main.mo_sueldo.setReadOnly(false);
                            }
                            AgregarSueldo.main.storeCO_TABULADOR.baseParams.co_clasif_personal=AgregarSueldo.main.co_clasif_personal.getValue();
                            AgregarSueldo.main.storeCO_TABULADOR.load();                            
                        }
                    }
            });
            
            this.storeCO_TIPO_PAGO.load({
                callback: function(){
                    AgregarSueldo.main.co_tipo_pago.setValue(AgregarSueldo.main.OBJ.co_tipo_pago);
                }
            });
            
this.co_tipo_pago.on('select',function(cmb,record,index){
if(cmb.getValue()==1){
AgregarSueldo.main.co_tabulador.show();
}else{ 
AgregarSueldo.main.co_tabulador.hide();    
}    
},this);     

     
            this.mo_sueldo = new Ext.form.NumberField({
                    fieldLabel:'Sueldo',
                    name:'mo_salario_base',
                    width:145,
                    allowBlank:false,
                    value:this.OBJ.mo_salario_base
            });
            
            this.nu_horas = new Ext.form.NumberField({
                    fieldLabel:'Horas',
                    name:'nu_horas',
                    width:145,
                    allowBlank:false,
                    value:this.OBJ.nu_horas
            });
            
            this.fe_ingreso = new Ext.form.DateField({
                    fieldLabel:'Fecha Asignación',
                    name:'fe_ingreso',
                    value:this.OBJ.fe_ingreso,
            //	allowBlank:false,
                    width:100
            });
            
            this.co_tp_cargo = new Ext.form.ComboBox({
                    fieldLabel:'Tipo de Cargo',
                    store: this.storeCO_TIPO_CARGO,
                    typeAhead: true,
                    valueField: 'co_tp_cargo',
                    displayField:'tx_tipo_cargo',
                    hiddenName:'co_tp_cargo',
                    forceSelection:true,
                    resizable:true,
                    triggerAction: 'all',
                    selectOnFocus: true,
                    mode: 'local',
                    width:250,
                    allowBlank:false
            });
            
            this.storeCO_TIPO_CARGO.load({
                callback: function(){
                    AgregarSueldo.main.co_tp_cargo.setValue(AgregarSueldo.main.OBJ.co_tp_cargo);
                }
            });
        
this.co_tabulador = new Ext.form.ComboBox({
        fieldLabel:'Tabulador',
        store: this.storeCO_TABULADOR,
        typeAhead: true,
        valueField: 'co_tabulador',
        displayField:'nu_codigo_tab',
        hiddenName:'co_tabulador',
        forceSelection:true,
        resizable:true,
        triggerAction: 'all',
        selectOnFocus: true,
        mode: 'local',
        width:250
});
this.co_tabulador.hide();
this.storeCO_TABULADOR.load({
    params:{
        co_clasif_personal: AgregarSueldo.main.OBJ.co_clasif_personal
    },    
    callback: function(){
        AgregarSueldo.main.co_tabulador.setValue(AgregarSueldo.main.OBJ.co_tabulador);
    }
});
this.co_tabulador.on('select',function(cmb,record,index){
AgregarSueldo.main.mo_sueldo.setValue(record.get('mo_sueldo'));   
},this);      
        
if(AgregarSueldo.main.OBJ.co_tipo_pago==1){
AgregarSueldo.main.co_tabulador.show();
}else{ 
AgregarSueldo.main.co_tabulador.hide();    
}  
               
            this.salir = new Ext.Button({
                text:'Salir',
                handler:function(){
                    AgregarSueldo.main.winformPanel_.close();
                }
            });
            
            this.estructura = new Ext.form.TextArea({
                    name:'estructura',
                    value:this.OBJ.tx_estructura,
                    width:400,
                    readOnly:true,
                    allowBlank:false,
                    style:'background:#c9c9c9;'
            });

            this.buscarEstructura = new Ext.Button({
                text:'Seleccionar Estructura',
            //    iconCls: 'icon-cancelar',
                handler:function(){
                    this.msg = Ext.get('buscarEstructura');
                    this.msg.load({
                     url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/CargoEstructura/buscar",
                     params:{paquete:'AgregarSueldo'},
                     scripts: true,
                     text: "Cargando.."
                    }); 
                }
            });

            this.fieldDatosEstructura = new Ext.form.FieldSet({ 
                    title: 'Estructura Administrativa',
                    width:700,
                    items:[{
                                    xtype: 'compositefield',
                                    fieldLabel: 'Descripción de Ubicación',
                                    items: [
                                        this.co_estructura_administrativa,
                                        this.estructura,
                                        this.buscarEstructura
                                    ]
                          }]
            });

            this.fieldDatos = new Ext.form.FieldSet({ 
                    title: 'Datos del Usuario',
                    width:700,
                    items:[this.co_tp_nomina,
                            this.co_grupo_nomina,
                            this.co_cargo,
                            this.co_tp_cargo,
                            this.nu_horas,
                            this.fe_ingreso,
                            this.co_tipo_pago,
                            this.co_tabulador,
                            this.mo_sueldo]
            });
            
            
            this.guardar = new Ext.Button({
                text:'Agregar',
                iconCls: 'icon-guardar',
                handler:function(){                    
                    //alert(AgregarSueldo.main.co_tp_cargo.getValue());
                    
                    if(!AgregarSueldo.main.formPanel_.getForm().isValid()){
                        Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
                        return false;
                    }
                    
                if(AgregarSueldo.main.co_tipo_pago.getValue()==1){
                    if(AgregarSueldo.main.co_tabulador.getValue()==''){
                    Ext.Msg.alert("Alerta","Debe ingresar el tabulador");
                    return false;
                }
                }        
                            
                    
                    var e = new TrabajadorEditar.main.Registro({     
                                co_nom_trabajador:AgregarSueldo.main.co_nom_trabajador.getValue(),                                
                                co_cargo_estructura:AgregarSueldo.main.co_cargo.getValue(),
                                co_grupo_nomina:AgregarSueldo.main.co_grupo_nomina.getValue(),
                                co_tp_nomina:AgregarSueldo.main.co_tp_nomina.getValue(),
                                co_tp_cargo:AgregarSueldo.main.co_tp_cargo.getValue(),
                                tx_tp_nomina:AgregarSueldo.main.co_tp_nomina.lastSelectionText,
                                fe_ingreso: AgregarSueldo.main.fe_ingreso.value,
                                tx_cargo:AgregarSueldo.main.co_cargo.lastSelectionText,
                                mo_salario_base:AgregarSueldo.main.mo_sueldo.getValue(),
                                nu_horas:AgregarSueldo.main.nu_horas.getValue(),
                                co_tipo_pago:AgregarSueldo.main.co_tipo_pago.getValue(),
                                tx_tipo_pago:AgregarSueldo.main.co_tipo_pago.lastSelectionText,
                                co_tabulador:AgregarSueldo.main.co_tabulador.getValue(),
                                co_estructura_administrativa:AgregarSueldo.main.co_estructura_administrativa.getValue(),
                                tx_estructura:AgregarSueldo.main.estructura.getValue()
                    });
                    
                    
                    var cant = TrabajadorEditar.main.store_lista.getCount();
                    if(AgregarSueldo.main.OBJ.co_cargo_estructura == null){
                        (cant == 0) ? 0 : TrabajadorEditar.main.store_lista.getCount() + 1;
                    }else{
                        var s = TrabajadorEditar.main.gridPanel.getSelectionModel().getSelections();
                        for(var i = 0, r; r = s[i]; i++){
                            TrabajadorEditar.main.store_lista.remove(r);
                        }                        
                        cant = AgregarSueldo.main.OBJ.rowIndex;
                    }
                    TrabajadorEditar.main.store_lista.insert(cant, e);
                    TrabajadorEditar.main.gridPanel.getView().refresh();
                    TrabajadorEditar.main.editar.disable();
                    AgregarSueldo.main.winformPanel_.close();
                    
                }
            });  
            
            this.formPanel_ = new Ext.form.FormPanel({
                frame:true,
                width:800,
                autoHeight:true,  
                autoScroll:true,
                fileUpload: true,
                bodyStyle:'padding:5px;',
                labelWidth:130,
                items:[
                        this.fieldDatosEstructura,
                        this.fieldDatos
                      ]
            });
            
            this.winformPanel_ = new Ext.Window({
                title:'Agregar Sueldo',
                modal:true,
                constrain:true,
                width:750,
                frame:true,
                closabled:true,
                autoHeight:true,
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
    },
    verificarSueldo(){
    Ext.Ajax.request({
        method:'GET',
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Trabajador/verificarSueldo',
        params:{
            co_cargo_estructura: AgregarSueldo.main.co_cargo.getValue()
        },
        success:function(result, request ) {
            obj = Ext.util.JSON.decode(result.responseText);
            if(obj.data){

                AgregarSueldo.main.mo_sueldo.setValue(obj.data.mo_sueldo);                       

            }
        }
    });
    },
    getStoreCO_TP_NOMINA(){
        this.store = new Ext.data.JsonStore({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkconomina',
            root:'data',
            fields:[
                    {name: 'co_tp_nomina'},
                    {name: 'tx_tp_nomina'},
                    {name: 'co_clasif_personal'}
                ]
        });
        return this.store;
    },
    getStoreCO_CARGO(){
        this.store = new Ext.data.JsonStore({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcocargo',
            root:'data',
            fields:[
                    {name: 'co_cargo_estructura'},
                    {name: 'tx_cargo'}
                ]
        });
        return this.store;
    },
    getStoreCO_TIPO_CARGO(){
        this.store = new Ext.data.JsonStore({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcotipocargo',
            root:'data',
            fields:[
                    {name: 'co_tp_cargo'},
                    {name: 'tx_tipo_cargo'}
                ]
        });
        return this.store;
    },
    getStoreCO_TIPO_PAGO(){
        this.store = new Ext.data.JsonStore({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcotipopago',
            root:'data',
            fields:[
                    {name: 'co_tipo_pago'},
                    {name: 'tx_tipo_pago'}
                ]
        });
        return this.store;
    },
    getStoreCO_GRUPO_NOMINA(){
        this.store = new Ext.data.JsonStore({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcogruponomina',
            root:'data',
            fields:[
                    {name: 'co_grupo_nomina'},
                    {name: 'tx_grupo_nomina'}
                ]
        });
        return this.store;
    },
    getStoreCO_TABULADOR(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcotabulador',
        root:'data',
        fields:[
                {name: 'co_tabulador'},
                {name: 'nu_codigo_tab'},
                {name: 'mo_sueldo'}
            ]
    });
    return this.store;
}    
};
Ext.onReady(AgregarSueldo.main.init, AgregarSueldo.main);
</script>
<div id="buscarEstructura"></div>