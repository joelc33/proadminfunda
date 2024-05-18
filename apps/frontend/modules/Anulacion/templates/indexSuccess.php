<script type="text/javascript">
Ext.ns("AnularProceso");
    AnularProceso.main = {
    init:function(){
            this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
            this.storeCO_PROCESO = this.getStoreCO_PROCESO();
            
            this.co_anulacion = new Ext.form.Hidden({
                name:'co_anulacion',
                value:this.OBJ.co_anulacion});
            
            this.co_solicitud = new Ext.form.Hidden({
                name:'co_solicitud',
                value:this.OBJ.co_solicitud
            });
            
            this.co_solicitud_anular = new Ext.form.NumberField({
                    fieldLabel:'Solicitud',
                    name:'co_solicitud_anular',
                    value:this.OBJ.co_solicitud_anular,
                    readOnly:(this.OBJ.co_solicitud_anular!=null)?true:false,
                    style:(this.OBJ.co_solicitud_anular!=null)?'background:#c9c9c9;':'',
                    allowBlank:false
            });
            
            this.co_solicitud_anular.on("blur",function(){
                if(AnularProceso.main.co_solicitud_anular.getValue()!=''){
                     AnularProceso.main.buscarSolicitud();
                }
            });
                      
            this.tipo_solicitud = new Ext.form.TextField({
                    fieldLabel:'Tipo de Solicitud',
                    name:'tx_tipo_solicitud',
                    value:this.OBJ.tx_tipo_solicitud,
                    readOnly:true,
                    width:500,
                    style:'background:#c9c9c9;',
            });
            
            this.tx_observacion = new Ext.form.TextArea({
                    fieldLabel:'Motivo',
                    name:'tx_observacion',
                    readOnly:(this.OBJ.tx_observacion!=null)?true:false,
                    style:(this.OBJ.tx_observacion!=null)?'background:#c9c9c9;':'',
                    value:this.OBJ.tx_observacion,                    
                    width:500
            });
            
            this.co_proceso = new Ext.form.ComboBox({
                    fieldLabel:'Proceso',
                    store: this.storeCO_PROCESO,
                    typeAhead: true,
                    valueField: 'co_ruta',
                    displayField:'tx_proceso',
                    hiddenName:'co_proceso',
                    forceSelection:true,
                    resizable:true,
                    triggerAction: 'all',
                    emptyText:'Seleccione...',
                    selectOnFocus: true,
                    mode: 'local',
                    width:400,
                    resizable:true,
                    allowBlank:false,
                    readOnly:(this.OBJ.co_proceso!=null)?true:false,
                    style:(this.OBJ.co_proceso!=null)?'background:#c9c9c9;':'',
            });            
    
            
            
            this.formPanel_ = new Ext.form.FormPanel({
                frame:true,
                width:900,
                autoHeight:true,  
                autoScroll:true,
                bodyStyle:'padding:10px;',
                items:[
                    this.co_anulacion,
                    this.co_solicitud,
                    this.co_solicitud_anular,
                    this.tipo_solicitud,
                    this.tx_observacion,
                    this.co_proceso
                ]
            });
            
            this.guardar = new Ext.Button({
                text:'Guardar',
                iconCls: 'icon-guardar',
                handler:function(){

                    if(!AnularProceso.main.formPanel_.getForm().isValid()){
                        Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
                        return false;
                    }
                    AnularProceso.main.formPanel_.getForm().submit({
                        method:'POST',
                        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Anulacion/guardar',
                        waitMsg: 'Enviando datos, por favor espere..',
                        waitTitle:'Enviando',
                        failure: function(form, action) {
                            Ext.MessageBox.alert('Error en transacción', action.result.msg);              
                        },
                        success: function(form, action) {
                             if(action.result.success){
                                 Ext.MessageBox.show({
                                     title: 'Mensaje',
                                     msg: action.result.msg,
                                     closable: false,
                                     icon: Ext.MessageBox.INFO,
                                     resizable: false,
                                     animEl: document.body,
                                     buttons: Ext.MessageBox.OK
                                 });
                                 
                                AnularProceso.main.winformPanel_.close();
                             }
                         }
                    });


                }
            });
            
            if(this.OBJ.co_proceso != null){
            
                this.guardar.disable();
                this.storeCO_PROCESO.baseParams.co_solicitud = this.OBJ.co_solicitud_anular;
                this.storeCO_PROCESO.load();
                paqueteComunJS.funcion.seleccionarComboByCo({
                        objCMB: this.co_proceso,
                        value:  this.OBJ.co_proceso,
                        objStore: this.storeCO_PROCESO
                });
            }

            this.salir = new Ext.Button({
                text:'Salir',
            //    iconCls: 'icon-cancelar',
                handler:function(){
                    AnularProceso.main.winformPanel_.close();
                }
            });
            
            this.winformPanel_ = new Ext.Window({
                title:'Anular Proceso',
                modal:true,
                constrain:true,
                width:700,
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
    buscarSolicitud: function(){
         Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Anulacion/verificarSolicitud',
                params:{
                    co_solicitud: AnularProceso.main.co_solicitud_anular.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        
                        AnularProceso.main.tipo_solicitud.setValue("");

                        Ext.Msg.show({
                            title : 'ALERTA',
                            msg : 'La solicitud no se encuentra registrada',
                            width : 400,
                            height : 800,
                            closable : false,
                            buttons : Ext.Msg.OK,
                            icon : Ext.Msg.INFO
                        });

                    }else{

                        AnularProceso.main.tipo_solicitud.setValue(obj.data.tx_tipo_solicitud);
                       
                        AnularProceso.main.storeCO_PROCESO.baseParams.co_solicitud = obj.data.co_solicitud;
                        AnularProceso.main.storeCO_PROCESO.load();
                    }
                }
         });
    },
    getStoreCO_PROCESO: function(){
        this.store = new Ext.data.JsonStore({
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Anulacion/storefkcoproceso',
            root:'data',
            fields:[
                {name: 'co_ruta'},
                {name: 'tx_proceso'}
            ]
        });
        return this.store;
    }
};
Ext.onReady(AnularProceso.main.init, AnularProceso.main);
</script>