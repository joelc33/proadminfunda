<script type="text/javascript">
Ext.ns("AgregarFamiliar");
AgregarFamiliar.main = {
    init:function(){
        
            this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
            
            this.storeCO_SEXO        = this.getStoreCO_SEXO();
            this.storeCO_PARENTESCO  = this.getStoreCO_PARENTESCO();
            
                        
            this.co_familiar_trabajador = new Ext.form.Hidden({
                name:'co_familiar_trabajador',
                value:this.OBJ.co_familiar_trabajador
            });
            
            this.co_trabajador = new Ext.form.Hidden({
                name:'co_trabajador',
                value:this.OBJ.co_trabajador
            });
            
            this.tx_identificacion = new Ext.form.NumberField({
                    fieldLabel:'Identificacion',
                    name:'tx_identificacion',
                    value:this.OBJ.tx_identificacion,
                    width:100
            });
            
            this.co_parentesco = new Ext.form.ComboBox({
                    fieldLabel:'Parentesco',
                    store: this.storeCO_PARENTESCO,
                    typeAhead: true,
                    valueField: 'co_parentesco',
                    displayField:'tx_parentesco',
                    hiddenName:'co_parentesco',
                    forceSelection:true,
                    resizable:true,
                    triggerAction: 'all',
                    selectOnFocus: true,
                    mode: 'local',
                    width:100
            });
            
            this.storeCO_PARENTESCO.load({
                callback: function(){
                    AgregarFamiliar.main.co_parentesco.setValue(AgregarFamiliar.main.OBJ.co_parentesco);
                }
            });
            
            this.co_sexo = new Ext.form.ComboBox({
                    fieldLabel:'Sexo',
                    store: this.storeCO_SEXO,
                    typeAhead: true,
                    valueField: 'co_sexo',
                    displayField:'tx_sexo',
                    hiddenName:'co_sexo',
                    forceSelection:true,
                    resizable:true,
                    triggerAction: 'all',
                    selectOnFocus: true,
                    mode: 'local',
                    width:100
            });
            
            this.storeCO_SEXO.load({
                callback: function(){
                    AgregarFamiliar.main.co_sexo.setValue(AgregarFamiliar.main.OBJ.co_sexo);
                }
            });
            
            
            this.nb_familiar = new Ext.form.TextField({
                    fieldLabel:'Nombre y Apellido',
                    name:'nb_familiar',
                    width:300,
                    value:this.OBJ.nb_familiar
            });
            
            this.fe_nacimiento = new Ext.form.DateField({
                    fieldLabel:'Fecha de Nacimiento',
                    name:'fe_nacimiento',
                    allowBlank:false,
                    format:'d-m-Y',
                    width:100,
                    value: this.OBJ.fe_nacimiento
            });
            
            this.guardar = new Ext.Button({
                text:'Agregar',
                iconCls: 'icon-guardar',
                handler:function(){                    
                    
                    var e = new TrabajadorEditar.main.RegistroFamiliar({ 
                                tx_identificacion: AgregarFamiliar.main.tx_identificacion.getValue(),
                                nb_familiar: AgregarFamiliar.main.nb_familiar.getValue(),
                                co_sexo: AgregarFamiliar.main.co_sexo.getValue(),
                                co_parentesco: AgregarFamiliar.main.co_parentesco.getValue(),
                                fe_nacimiento: AgregarFamiliar.main.fe_nacimiento.value,
                                tx_sexo:AgregarFamiliar.main.co_sexo.lastSelectionText,
                                tx_parentesco:AgregarFamiliar.main.co_parentesco.lastSelectionText,
                                co_trabajador: AgregarFamiliar.main.OBJ.co_trabajador,
                                co_familiar_trabajador: AgregarFamiliar.main.OBJ.co_familiar_trabajador
                    });                    
                    
                    var cant = TrabajadorEditar.main.store_lista_familia.getCount();
                    if(AgregarFamiliar.main.OBJ.tx_identificacion == null){
                        (cant == 0) ? 0 : TrabajadorEditar.main.store_lista_familia.getCount() + 1;
                    }else{
                        var s = TrabajadorEditar.main.gridPanelFamiliar.getSelectionModel().getSelections();
                        for(var i = 0, r; r = s[i]; i++){
                            TrabajadorEditar.main.store_lista_familia.remove(r);
                        }                        
                        cant = AgregarFamiliar.main.OBJ.rowIndex;
                    }
                    TrabajadorEditar.main.store_lista_familia.insert(cant, e);
                    TrabajadorEditar.main.gridPanelFamiliar.getView().refresh();
                        
                    TrabajadorEditar.main.botonEliminarFamiliar.disable();
                    TrabajadorEditar.main.editar_familiar.disable();
                    AgregarFamiliar.main.winformPanel_.close();
                }
            });        
        
            this.salir = new Ext.Button({
                text:'Salir',
                handler:function(){
                    AgregarFamiliar.main.winformPanel_.close();
                }
            });
            
            this.formPanel_ = new Ext.form.FormPanel({
                frame:true,
                width:800,
                autoHeight:true,  
                autoScroll:true,
                fileUpload: true,
                bodyStyle:'padding:5px;',
                items:[
                        this.tx_identificacion,
                        this.nb_familiar,
                        this.fe_nacimiento,
                        this.co_sexo,
                        this.co_parentesco
                      ]
            });
            
            this.winformPanel_ = new Ext.Window({
                title:'Agregar Familiar',
                modal:true,
                constrain:true,
                width:650,
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
    getStoreCO_PARENTESCO(){
        this.store = new Ext.data.JsonStore({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcoparentesco',
            root:'data',
            fields:[
                    {name: 'co_parentesco'},
                    {name: 'tx_parentesco'}
                ]
        });
        return this.store;
    },getStoreCO_SEXO:function(){
        this.store = new Ext.data.JsonStore({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcosexo',
            root:'data',
            fields:[
                {name: 'co_sexo'},
                {name: 'tx_sexo'}
                ]
        });
        return this.store;
    }
};
Ext.onReady(AgregarFamiliar.main.init, AgregarFamiliar.main);
</script>
