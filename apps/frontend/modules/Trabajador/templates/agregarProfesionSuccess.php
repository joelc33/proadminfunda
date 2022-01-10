<script type="text/javascript">
Ext.ns("AgregarProfesion");
AgregarProfesion.main = {
    init:function(){
        
            this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
            
            this.storeCO_PROFESION        = this.getStoreCO_PROFESION();
            this.storeCO_UNIVERSIDAD      = this.getStoreCO_UNIVERSIDAD();
            
                        
            this.co_profesion_trabajador = new Ext.form.Hidden({
                name:'co_profesion_trabajador',
                value:this.OBJ.co_profesion_trabajador
            });
            
            this.co_trabajador = new Ext.form.Hidden({
                name:'co_trabajador',
                value:this.OBJ.co_trabajador
            });
            
                       
            this.co_universidad = new Ext.form.ComboBox({
                    fieldLabel:'Universidad',
                    store: this.storeCO_UNIVERSIDAD,
                    typeAhead: true,
                    valueField: 'co_universidad',
                    displayField:'tx_universidad',
                    hiddenName:'co_universidad',
                    forceSelection:true,
                    resizable:true,
                    triggerAction: 'all',
                    selectOnFocus: true,
                    mode: 'local',
                    width:400
            });
            
            this.storeCO_UNIVERSIDAD.load({
                callback: function(){
                    AgregarProfesion.main.co_universidad.setValue(AgregarProfesion.main.OBJ.co_universidad);
                }
            });
            
            this.co_profesion = new Ext.form.ComboBox({
                    fieldLabel:'Profesión',
                    store: this.storeCO_PROFESION,
                    typeAhead: true,
                    valueField: 'co_profesion',
                    displayField:'tx_profesion',
                    hiddenName:'co_profesion',
                    forceSelection:true,
                    resizable:true,
                    triggerAction: 'all',
                    selectOnFocus: true,
                    mode: 'local',
                    width:400
            });
            
            this.storeCO_PROFESION.load({
                callback: function(){
                    AgregarProfesion.main.co_profesion.setValue(AgregarProfesion.main.OBJ.co_profesion);
                }
            });
            
            
            this.tx_titulo_obtenido = new Ext.form.TextField({
                    fieldLabel:'Titulo',
                    name:'tx_titulo_obtenido',
                    width:400,
                    value:this.OBJ.tx_titulo_obtenido
            });
            
            this.fe_egreso = new Ext.form.DateField({
                    fieldLabel:'Fecha de Egreso',
                    name:'fe_egreso',
                    allowBlank:false,
                    format:'d-m-Y',
                    width:100,
                    value: this.OBJ.fe_egreso
            });
            
            this.guardar = new Ext.Button({
                text:'Agregar',
                iconCls: 'icon-guardar',
                handler:function(){                    
                    
                    var e = new TrabajadorEditar.main.RegistroProfesion({ 
                                fe_egreso:AgregarProfesion.main.fe_egreso.value,
                                co_profesion:AgregarProfesion.main.co_profesion.getValue(),
                                co_universidad:AgregarProfesion.main.co_universidad.getValue(),
                                tx_universidad:AgregarProfesion.main.co_universidad.lastSelectionText,
                                tx_profesion:AgregarProfesion.main.co_profesion.lastSelectionText,
                                tx_titulo_obtenido:AgregarProfesion.main.tx_titulo_obtenido.getValue(),
                                co_trabajador:AgregarProfesion.main.co_trabajador.getValue(),
                                co_profesion_trabajador:AgregarProfesion.main.co_profesion_trabajador.getValue()
                    });                    
                    
                    var cant = TrabajadorEditar.main.store_lista_profesion.getCount();
                    if(AgregarProfesion.main.OBJ.tx_titulo_obtenido == null){
                        (cant == 0) ? 0 : TrabajadorEditar.main.store_lista_profesion.getCount() + 1;
                    }else{
                        var s = TrabajadorEditar.main.gridPanelProfesion.getSelectionModel().getSelections();
                        for(var i = 0, r; r = s[i]; i++){
                            TrabajadorEditar.main.store_lista_profesion.remove(r);
                        }                        
                        cant = AgregarProfesion.main.OBJ.rowIndex;
                    }
                    TrabajadorEditar.main.store_lista_profesion.insert(cant, e);
                    TrabajadorEditar.main.gridPanelProfesion.getView().refresh();
                        
                    TrabajadorEditar.main.botonEliminarProfesion.disable();
                    TrabajadorEditar.main.editar_profesion.disable();
                    AgregarProfesion.main.winformPanel_.close();
                }
            });        
        
            this.salir = new Ext.Button({
                text:'Salir',
                handler:function(){
                    AgregarProfesion.main.winformPanel_.close();
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
                        this.co_universidad,
                        this.co_profesion,
                        this.tx_titulo_obtenido,
                        this.fe_egreso
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
    getStoreCO_PROFESION(){
        this.store = new Ext.data.JsonStore({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcoprofesion',
            root:'data',
            fields:[
                    {name: 'co_profesion'},
                    {name: 'tx_profesion'}
                ]
        });
        return this.store;
    },getStoreCO_UNIVERSIDAD:function(){
        this.store = new Ext.data.JsonStore({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcouniversidad',
            root:'data',
            fields:[
                {name: 'co_universidad'},
                {name: 'tx_universidad'}
                ]
        });
        return this.store;
    }
};
Ext.onReady(AgregarProfesion.main.init, AgregarProfesion.main);
</script>
