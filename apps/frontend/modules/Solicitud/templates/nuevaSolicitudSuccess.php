<script type="text/javascript">
Ext.ns("solicitudEditar");
solicitudEditar.main = {
init:function(){
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_PROCESO = this.getStoreCO_PROCESO();
//<Stores de fk>
this.storeCO_TIPO_SOLICITUD = this.getStoreCO_TIPO_SOLICITUD();

this.co_usuario = new Ext.form.Hidden({
    name:'co_usuario',
    value:this.OBJ.co_usuario
});

this.usuario = new Ext.form.TextField({
	fieldLabel:'Usuario',
	name:'solicitud[usuario]',
	value:this.OBJ.usuario,
	allowBlank:false,
	width:500,
        listeners:{
            change: function(){
                this.setValue(String(this.getValue()).toUpperCase());
            }
        }
});

/*
this.co_proceso = new Ext.form.ComboBox({
	fieldLabel:'Proceso',
	store: this.storeCO_PROCESO,
	typeAhead: true,
	valueField: 'co_proceso',
	displayField:'tx_proceso',
	hiddenName:'solicitud[co_proceso]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione...',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	resizable:true,
	allowBlank:false,
	listeners:{
            change: function(){
                solicitudEditar.main.storeCO_TIPO_SOLICITUD.removeAll();
                solicitudEditar.main.co_tipo_solicitud.setValue("");
               
                solicitudEditar.main.storeCO_TIPO_SOLICITUD.load({
                    params: {co_proceso:this.getValue()}
                });
                
            }
        }
});

this.storeCO_PROCESO.load();
*/

this.co_tipo_solicitud = new Ext.form.ComboBox({
	fieldLabel:'Tramite',
	store: this.storeCO_TIPO_SOLICITUD,
	typeAhead: true,
	valueField: 'co_tipo_solicitud',
	displayField:'tx_tipo_solicitud',
	hiddenName:'solicitud[co_tipo_solicitud]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione solicitud',
	selectOnFocus: true,
	mode: 'local',
	width:500,
	allowBlank:false
});

this.storeCO_TIPO_SOLICITUD.load();

this.observacion = new Ext.form.TextArea({
	fieldLabel:'Observacion',
	name:'solicitud[observacion]',
	value:this.OBJ.observacion,
	width:500
});

this.fe_solicitud = new Ext.form.DateField({
	fieldLabel:'Fecha Solicitud',
	name:'solicitud[fe_solicitud]',
	value:this.OBJ.fe_solicitud,
    minValue:this.OBJ.fe_ini,
	maxValue:this.OBJ.fe_fin,
    //allowBlank:false,
	width:100
});

//this.fielset1 = new Ext.form.FieldSet({
//    title:'Datos Personales Usuario',
//    width:670,
//    items:[
//        this.usuario,
//        <?php if($ejercicio == date("Y")){ }else{ ?>
//        this.fe_solicitud
//        <?php }  ?>
//    ]
//});

this.fielset1 = new Ext.form.FieldSet({
    title:'Datos Personales Usuario',
    width:670,
    items:[
        this.usuario,
        this.fe_solicitud
    ]
});

this.fielset2 = new Ext.form.FieldSet({
    title:'Datos de Solicitud',
    width:670,
    items:[
        //this.co_proceso,
        this.co_tipo_solicitud,  
        this.observacion
    ]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!solicitudEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        
            solicitudEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/guardar',
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
               //  window.open("http://<= $_SERVER['SERVER_NAME']; ?>/ventanilla/web/reportes/comprobante.php?codigo="+action.result.co_solicitud);
                 solicitudLista.main.store_lista.load({
                     callback: function(){
                          UsuarioLista.main.editar.disable();
                          UsuarioLista.main.cambiar_estado.disable();
                     }
                 });
                 solicitudEditar.main.winformPanel_.close();
                 }
                 
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
    //iconCls: 'icon-cancelar',
    handler:function(){
        solicitudEditar.main.winformPanel_.close();
    }
});

this.PanelSolicitud = new Ext.Panel({
    title: 'Datos de la Solicitud',
    width:700,
    bodyStyle:'padding:3px;',
    items:[
        this.co_usuario,
        this.fielset1,
        this.fielset2
    ]	    
});

this.TabPanel = new Ext.TabPanel({
    activeTab:0,
    items:[
        this.PanelSolicitud
    ]
});


this.formPanel_ = new Ext.form.FormPanel({
    //frame:true,
    width:700,
    height:300,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
        this.TabPanel
    ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario de Solicitudes Internas',
    modal:true,
    constrain:true,
    width:715,
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
//contribuyenteLista.main.mascara.hide();
}
,getStoreCO_PROCESO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/storefkcoproceso',
        root:'data',
        fields:[
                {name: 'co_proceso'},
                {name: 'tx_proceso'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_SOLICITUD:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Solicitud/storefkcotiposolicitud',
        root:'data',
        fields:[
                {name: 'co_tipo_solicitud'},
                {name: 'tx_tipo_solicitud'}
               ]
    });
    return this.store;
}
};
Ext.onReady(solicitudEditar.main.init, solicitudEditar.main);
</script>
<div id="requisito" ></div>
<div id="solvencia" ></div>
