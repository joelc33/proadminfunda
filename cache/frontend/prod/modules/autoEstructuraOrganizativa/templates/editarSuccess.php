<script type="text/javascript">
Ext.ns("EstructuraOrganizativaEditar");
EstructuraOrganizativaEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_estructura_administrativa = new Ext.form.Hidden({
    name:'co_estructura_administrativa',
    value:this.OBJ.co_estructura_administrativa});
//</ClavePrimaria>


this.co_padre = new Ext.form.NumberField({
	fieldLabel:'Co padre',
	name:'tbrh005_estructura_administrativa[co_padre]',
	value:this.OBJ.co_padre,
	allowBlank:false
});

this.tx_nom_estructura_administrativa = new Ext.form.TextField({
	fieldLabel:'Tx nom estructura administrativa',
	name:'tbrh005_estructura_administrativa[tx_nom_estructura_administrativa]',
	value:this.OBJ.tx_nom_estructura_administrativa,
	allowBlank:false,
	width:200
});

this.nu_centro_costo = new Ext.form.TextField({
	fieldLabel:'Nu centro costo',
	name:'tbrh005_estructura_administrativa[nu_centro_costo]',
	value:this.OBJ.nu_centro_costo,
	allowBlank:false,
	width:200
});

this.co_ente = new Ext.form.NumberField({
	fieldLabel:'Co ente',
	name:'tbrh005_estructura_administrativa[co_ente]',
	value:this.OBJ.co_ente,
	allowBlank:false
});

this.co_nivel_jerarquico = new Ext.form.NumberField({
	fieldLabel:'Co nivel jerarquico',
	name:'tbrh005_estructura_administrativa[co_nivel_jerarquico]',
	value:this.OBJ.co_nivel_jerarquico,
	allowBlank:false
});

this.in_activo = new Ext.form.Checkbox({
	fieldLabel:'In activo',
	name:'tbrh005_estructura_administrativa[in_activo]',
	checked:(this.OBJ.in_activo=='0') ? true:false,
	allowBlank:false
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tbrh005_estructura_administrativa[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tbrh005_estructura_administrativa[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.co_dependencia = new Ext.form.NumberField({
	fieldLabel:'Co dependencia',
	name:'tbrh005_estructura_administrativa[co_dependencia]',
	value:this.OBJ.co_dependencia,
	allowBlank:false
});

this.co_enteorgano = new Ext.form.NumberField({
	fieldLabel:'Co enteorgano',
	name:'tbrh005_estructura_administrativa[co_enteorgano]',
	value:this.OBJ.co_enteorgano,
	allowBlank:false
});

this.nu_codigo = new Ext.form.TextField({
	fieldLabel:'Nu codigo',
	name:'tbrh005_estructura_administrativa[nu_codigo]',
	value:this.OBJ.nu_codigo,
	allowBlank:false,
	width:200
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!EstructuraOrganizativaEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        EstructuraOrganizativaEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/guardar',
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
                 EstructuraOrganizativaLista.main.store_lista.load();
                 EstructuraOrganizativaEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        EstructuraOrganizativaEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:400,
autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                    this.co_estructura_administrativa,
                    this.co_padre,
                    this.tx_nom_estructura_administrativa,
                    this.nu_centro_costo,
                    this.co_ente,
                    this.co_nivel_jerarquico,
                    this.in_activo,
                    this.created_at,
                    this.updated_at,
                    this.co_dependencia,
                    this.co_enteorgano,
                    this.nu_codigo,
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: EstructuraOrganizativa',
    modal:true,
    constrain:true,
width:400,
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
EstructuraOrganizativaLista.main.mascara.hide();
}
};
Ext.onReady(EstructuraOrganizativaEditar.main.init, EstructuraOrganizativaEditar.main);
</script>
