<script type="text/javascript">
Ext.BLANK_IMAGE_URL = "<?php echo image_path('default/s.gif'); ?>";
Ext.onReady(function(){
//Ventana para validar
function Validar(){
if (validarForm.form.isValid()) {
	validarForm.form.submit({
		waitTitle: "Validando",
		waitMsg : "Espere un momento por favor......",
		failure: function(form,action){
		    try{
			if(action.result.msg!=null)
			    Ext.utiles.msg('Error de Validaci&oacute;n', action.result.msg);
			else
			    throw Exception();
		    }catch(Exception){
			    Ext.utiles.msg('Error durante el proceso','Consulta al administrador del Sistema');
		    }
		},
		success: function(form,action) {
		    winValidar.hide();
		    //location.href='<?php echo $_SERVER["SCRIPT_NAME"] ?>/inicio';
			location.href='<?php echo $_SERVER["SCRIPT_NAME"] ?>/ejercicio';
		}
	});
}
}

var usuario = new Ext.form.TextField({
	fieldLabel:'Usuario',
	name: 'usuario',
	id:'usuario',
	allowBlank:false,
	maxLength:250
});
var password = new Ext.form.TextField({
	fieldLabel:'Contraseña',
	inputType:'password',
	name: 'password',
	id:'password',
	allowBlank:false,
	maxLength:20
});

var storeAnioFiscal = new Ext.data.JsonStore({
        url: Ext.fly("url_").dom.value+"/login/storefkAnioFiscal",
        root:'data',
        fields:[
                {name: 'co_anio_fiscal'},
                {name: 'tx_anio_fiscal'}
            ]
});

var anio_fiscal = new Ext.form.ComboBox({
            fieldLabel:'Año Fiscal',
            store: storeAnioFiscal,
            typeAhead: true,
            valueField: 'co_anio_fiscal',
            displayField:'tx_anio_fiscal',
            hiddenName:'co_anio_fiscal',
            forceSelection:true,
            resizable:true,
            triggerAction: 'all',
            emptyText:'...',
            selectOnFocus: true,
            mode: 'local',
            width:100,
            resizable:true,
            allowBlank:false
});
storeAnioFiscal.load();

this.Panel = new Ext.Panel ({
                baseCls : 'x-plain',
                html    : '<br><b><div style="text-align: center;">Gobierno Electrónico</div></b><br>',
                cls     : 'icon-autorizacion',
                region  : 'north',
                height  : 50
});


var validarForm = new Ext.form.FormPanel({
	baseCls: 'x-plain',
	labelWidth: 180,
	autoWidth:true,
	autoHeight:true,
	//frame:true,
	autoScroll:false,
	bodyStyle:'padding:10px;',
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/login/validar',
	items: [/*{
				xtype:'box',
				anchor:'',
				autoEl:{tag:'div', style:'margin:0px 0px 0px 70px', children:[{tag:'img',src:'<?php echo image_path('logo_sanfco_new.png'); ?>', height:100, width:220,}]}
                },*/
		//this.Panel,
		{xtype:'fieldset',title:'Usuario / Contraseña', autoWidth:true, labelWidth: 90, autoHeight:true, defaultType: 'textfield',
		items:[
			usuario,
			password
		],
		keys: [
			{key: [Ext.EventObject.ENTER], handler: function() {
				Validar();
			}
		   }
		]
	    }
	]
});

var winValidar;

winValidar = new Ext.Window({
	title:'Validaci&oacute;n de Usuario',
	layout:'fit',
	bodyStyle:'padding:5px;',
	width:450,
	autoHeight:true,
	modal:true,
	autoScroll: true,
	maximizable:false,
	closable:false,
	plain: true,
	buttonAlign:'center',
	items:[
	    //{xtype:'panel', baseCls:'x-plain', border:false, contentEl:'msgValidar', autoWidth: true, autoHeight:true},
	    validarForm
	],
	buttons: [{
	    text:'Entrar',
	    align:'center',
	    iconCls: 'icon-login',
	    handler: function (){
		            Validar();
	    }
	}]
});

setTimeout(function(){
	usuario.focus(true,true);
	},500);
	winValidar.show();
});
</script>
<input type="hidden" name="url_" id="url_" value="<?php echo $url ?>">
