<script type="text/javascript">
Ext.ns("CatalogoPartidaEditar");
CatalogoPartidaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeCO_ANIO_FISCAL = this.getStoreCO_ANIO_FISCAL();
//<Stores de fk>
//<Stores de fk>
this.storeNU_PA = this.getStoreNU_PA();
//<Stores de fk>
//<Stores de fk>
this.storeNU_GE = this.getStoreNU_GE();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id
});
//</ClavePrimaria>

this.id_tb013_anio_fiscal = new Ext.form.ComboBox({
	fieldLabel:'Ejercicio Fiscal',
	store: this.storeCO_ANIO_FISCAL,
	typeAhead: true,
	valueField: 'co_anio_fiscal',
	displayField:'co_anio_fiscal',
	hiddenName:'tb091_partida[id_tb013_anio_fiscal]',
	//readOnly:(this.OBJ.id_tb013_anio_fiscal!='')?true:false,
	//style:(this.main.OBJ.id_tb013_anio_fiscal!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Ejercicio',
	selectOnFocus: true,
	mode: 'local',
	width:200,
	resizable:true,
	allowBlank:false
});
this.storeCO_ANIO_FISCAL.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb013_anio_fiscal,
	value:  this.OBJ.id_tb013_anio_fiscal,
	objStore: this.storeCO_ANIO_FISCAL
});

this.nu_pa = new Ext.form.ComboBox({
	fieldLabel:'Partida',
	store: this.storeNU_PA,
	typeAhead: true,
	valueField: 'nu_pa',
	displayField:'descripcion',
	hiddenName:'tb091_partida[nu_pa]',
	//readOnly:(this.OBJ.id_tb013_anio_fiscal!='')?true:false,
	//style:(this.main.OBJ.id_tb013_anio_fiscal!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Partida',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeNU_PA.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.nu_pa,
	value:  this.OBJ.nu_pa,
	objStore: this.storeNU_PA
});

this.nu_ge = new Ext.form.ComboBox({
	fieldLabel:'Generica',
	store: this.storeNU_GE,
	typeAhead: true,
	valueField: 'nu_ge',
	displayField:'descripcion',
	hiddenName:'tb091_partida[nu_ge]',
	//readOnly:(this.OBJ.id_tb013_anio_fiscal!='')?true:false,
	//style:(this.main.OBJ.id_tb013_anio_fiscal!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Generica',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeNU_GE.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.nu_ge,
	value:  this.OBJ.nu_ge,
	objStore: this.storeNU_GE
});

this.de_partida = new Ext.form.TextField({
	fieldLabel:'Denominacion',
	name:'tb091_partida[de_partida]',
	value:this.OBJ.de_partida,
	allowBlank:false,
	width:400
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!CatalogoPartidaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        CatalogoPartidaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CatalogoPartida/guardar',
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
                 }
                 CatalogoPartidaLista.main.store_lista.load();
                 CatalogoPartidaEditar.main.winformPanel_.close();
             }
        });


    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        CatalogoPartidaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:600,
autoHeight:true,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.id,
                    this.id_tb013_anio_fiscal,
                    this.nu_pa,
                    this.nu_ge,
                    this.de_partida,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Creacion de Partida General',
    modal:true,
    constrain:true,
width:614,
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
//CatalogoPartidaLista.main.mascara.hide();
},
getStoreCO_ANIO_FISCAL:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CatalogoPartida/storefkidtb013aniofiscal',
        root:'data',
        fields:[
            {name: 'co_anio_fiscal'}
            ]
    });
    return this.store;
},
getStoreNU_PA:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CatalogoPartida/storefknupa',
        root:'data',
        fields:[
            {name: 'nu_pa'},
            {name: 'de_partida'},
            {name: 'descripcion',
              convert:function(v,r){
                return r.nu_pa+' - '+r.de_partida;
              }
            }
            ]
    });
    return this.store;
},
getStoreNU_GE:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/CatalogoPartida/storefknuge',
        root:'data',
        fields:[
            {name: 'nu_pa'},
            {name: 'nu_ge'},
            {name: 'descripcion',
              convert:function(v,r){
                return r.nu_pa+'.'+r.nu_ge+' - '+r.de_partida;
              }
            }
            ]
    });
    return this.store;
}
};
Ext.onReady(CatalogoPartidaEditar.main.init, CatalogoPartidaEditar.main);
</script>
