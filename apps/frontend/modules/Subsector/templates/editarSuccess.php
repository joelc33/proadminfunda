<script type="text/javascript">
Ext.ns("SubsectorEditar");
SubsectorEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
//<Stores de fk>
this.storeID = this.getStoreID();
//<Stores de fk>

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.id_tb080_sector = new Ext.form.ComboBox({
	fieldLabel:'Sector',
	store: this.storeID,
	typeAhead: true,
	valueField: 'id',
	displayField:'sector',
	hiddenName:'tb081_sub_sector[id_tb080_sector]',
	//readOnly:(this.OBJ.id_tb080_sector!='')?true:false,
	//style:(this.main.OBJ.id_tb080_sector!='')?'background:#c9c9c9;':'',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	emptyText:'Seleccione Sector',
	selectOnFocus: true,
	mode: 'local',
	width:400,
	resizable:true,
	allowBlank:false
});
this.storeID.load();
	paqueteComunJS.funcion.seleccionarComboByCo({
	objCMB: this.id_tb080_sector,
	value:  this.OBJ.id_tb080_sector,
	objStore: this.storeID
});

this.nu_sub_sector = new Ext.form.TextField({
	fieldLabel:'Codigo',
	name:'tb081_sub_sector[nu_sub_sector]',
	value:this.OBJ.nu_sub_sector,
	allowBlank:false,
	width:200
});

this.de_sub_sector = new Ext.form.TextField({
	fieldLabel:'Descripcion',
	name:'tb081_sub_sector[de_sub_sector]',
	value:this.OBJ.de_sub_sector,
	allowBlank:false,
	width:400
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!SubsectorEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        SubsectorEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Subsector/guardar',
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
                 SubsectorLista.main.store_lista.load();
                 SubsectorEditar.main.winformPanel_.close();
             }
        });


    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        SubsectorEditar.main.winformPanel_.close();
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
                    this.id_tb080_sector,
                    this.nu_sub_sector,
                    this.de_sub_sector
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Subsector',
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
SubsectorLista.main.mascara.hide();
}
,getStoreID:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Subsector/storefkidtb080sector',
        root:'data',
        fields:[
            {name: 'id'},
            {name: 'nu_sector'},
            {name: 'de_sector'},
            {
                name: 'sector',
                convert: function(v, r) {
                    return r.nu_sector + ' - ' + r.de_sector;
                }
            }
            ]
    });
    return this.store;
}
};
Ext.onReady(SubsectorEditar.main.init, SubsectorEditar.main);
</script>
