<script type="text/javascript">
Ext.ns("ConfigConceptoFijoLista");
ConfigConceptoFijoLista.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
this.storeCO_DOCUMENTO_ENTREVISTADOR = this.getStoreCO_DOCUMENTO();
this.storeCO_SEXO      = this.getStoreCO_SEXO();
this.storeCO_EDO_CIVIL = this.getStoreCO_EDO_CIVIL();

this.storeCO_ESTADO                 = this.getStoreCO_ESTADO();
this.storeCO_MUNICIPIO              = this.getStoreCO_MUNICIPIO();
this.storeCO_PARROQUIA              = this.getStoreCO_PARROQUIA();
this.storeCO_BANCO                  = this.getStoreCO_BANCO();
this.storeCO_GRUPO_SANGUINEO        = this.getStoreCO_GRUPO_SANGUINEO();
this.storeCO_DESTREZA               = this.getStoreCO_DESTREZA();
this.storeCO_TIPO_VIVIENDA          = this.getStoreCO_TIPO_VIVIENDA();
this.storeCO_GRADO_INSTRUCCION      = this.getStoreCO_GRADO_INSTRUCCION();
this.storeCO_PROFESION              = this.getStoreCO_PROFESION();
//<ClavePrimaria>
this.co_trabajador = new Ext.form.Hidden({
    name:'co_trabajador',
    value:this.OBJ.co_trabajador
});

this.co_solicitud = new Ext.form.Hidden({
	name:'tbrh001_trabajador[co_solicitud]',
	value:this.OBJ.co_solicitud
});

this.co_grupo = new Ext.form.Hidden({
    name:'co_grupo',
    value:this.OBJ.co_grupo
});

this.co_subgrupo = new Ext.form.Hidden({
    name:'co_subgrupo',
    value:this.OBJ.co_subgrupo
});

//</ClavePrimaria>


this.nu_cedula = new Ext.form.NumberField({
	fieldLabel:'Nu cedula',
	name:'tbrh001_trabajador[nu_cedula]',
	value:this.OBJ.nu_cedula,
        width:145,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.nb_primer_nombre = new Ext.form.TextField({
	fieldLabel:'Primer Nombre',
	name:'tbrh001_trabajador[nb_primer_nombre]',
	value:this.OBJ.nb_primer_nombre,
	allowBlank:false,
	width:200,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.nb_segundo_nombre = new Ext.form.TextField({
	fieldLabel:'Segundo Nombre',
	name:'tbrh001_trabajador[nb_segundo_nombre]',
	value:this.OBJ.nb_segundo_nombre,
	width:200,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.nb_primer_apellido = new Ext.form.TextField({
	fieldLabel:'Primer Apellido',
	name:'tbrh001_trabajador[nb_primer_apellido]',
	value:this.OBJ.nb_primer_apellido,
	allowBlank:false,
	width:200,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.nb_segundo_apellido = new Ext.form.TextField({
	fieldLabel:'Segundo Apellido',
	name:'tbrh001_trabajador[nb_segundo_apellido]',
	value:this.OBJ.nb_segundo_apellido,
	width:200,
        readOnly:true,
	style:'background:#c9c9c9;'
});


this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'tbrh001_trabajador[co_documento]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:50,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.storeCO_DOCUMENTO.load({
    callback: function(){   
        ConfigConceptoFijoLista.main.co_documento.setValue(ConfigConceptoFijoLista.main.OBJ.co_documento);
    }
});

this.nu_cedula = new Ext.form.NumberField({
	fieldLabel:'Nu cedula',
	name:'tbrh001_trabajador[nu_cedula]',
	value:this.OBJ.nu_cedula,
        width:145,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.co_sexo = new Ext.form.ComboBox({
	fieldLabel:'Sexo',
	store: this.storeCO_SEXO,
	typeAhead: true,
	valueField: 'co_sexo',
	displayField:'tx_sexo',
	hiddenName:'tbrh001_trabajador[co_sexo]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:100,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;'
});
this.storeCO_SEXO.load();

this.co_edo_civil = new Ext.form.ComboBox({
	fieldLabel:'Estado Civil',
	store: this.storeCO_EDO_CIVIL,
	typeAhead: true,
	valueField: 'co_edo_civil',
	displayField:'tx_edo_civil',
	hiddenName:'tbrh001_trabajador[co_edo_civil]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:100,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;'
});

//alert(ConfigConceptoFijoLista.main.OBJ.co_edo_civil);
this.storeCO_EDO_CIVIL.load({
    callback: function(){
        ConfigConceptoFijoLista.main.co_edo_civil.setValue(ConfigConceptoFijoLista.main.OBJ.co_edo_civil);
    }
});


this.identificacion = new Ext.form.CompositeField({
fieldLabel: 'Identificación',
width:230,
items: [
	this.co_documento,
	this.nu_cedula
	]
});

this.co_ente = new Ext.form.NumberField({
	fieldLabel:'Co ente',
	name:'tbrh001_trabajador[co_ente]',
	value:this.OBJ.co_ente,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.co_estado = new Ext.form.ComboBox({
	fieldLabel:'Estado',
	store: this.storeCO_ESTADO,
	typeAhead: true,
	valueField: 'co_estado',
	displayField:'nb_estado',
	hiddenName:'tbrh001_trabajador[co_estado]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:300,
        readOnly:true,
	style:'background:#c9c9c9;',
	allowBlank:false,
        listeners:{
            select: function(){
                ConfigConceptoFijoLista.main.storeCO_MUNICIPIO.baseParams.co_estado=this.getValue();
                ConfigConceptoFijoLista.main.storeCO_MUNICIPIO.load();
            }
        }
});
this.storeCO_ESTADO.load({
    callback: function(){
        ConfigConceptoFijoLista.main.co_estado.setValue(ConfigConceptoFijoLista.main.OBJ.co_estado);
    }
});

this.co_municipio = new Ext.form.ComboBox({
	fieldLabel:'Municipio',
	store: this.storeCO_MUNICIPIO,
	typeAhead: true,
	valueField: 'co_municipio',
	displayField:'nb_municipio',
	hiddenName:'tbrh001_trabajador[co_municipio]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:300,
        readOnly:true,
	style:'background:#c9c9c9;',
	allowBlank:false,
        listeners:{
            select: function(){
                ConfigConceptoFijoLista.main.storeCO_PARROQUIA.baseParams.co_municipio=this.getValue();
                ConfigConceptoFijoLista.main.storeCO_PARROQUIA.load();
            }
        }
});

if(ConfigConceptoFijoLista.main.OBJ.co_estado!=''){
    this.storeCO_MUNICIPIO.load({
        params:{
            co_estado:ConfigConceptoFijoLista.main.OBJ.co_estado
        },
        callback:function(){
            ConfigConceptoFijoLista.main.co_municipio.setValue(ConfigConceptoFijoLista.main.OBJ.co_municipio);
        }
    });
}

this.co_parroquia = new Ext.form.ComboBox({
	fieldLabel:'Parroquia',
	store: this.storeCO_PARROQUIA,
	typeAhead: true,
	valueField: 'co_parroquia',
	displayField:'tx_parroquia',
	hiddenName:'tbrh001_trabajador[co_parroquia_domicilio]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:300,
        readOnly:true,
	style:'background:#c9c9c9;',
	allowBlank:false
});

if(ConfigConceptoFijoLista.main.OBJ.co_municipio!=''){
    this.storeCO_PARROQUIA.load({
        params:{
            co_municipio:ConfigConceptoFijoLista.main.OBJ.co_municipio
        },
        callback:function(){
            ConfigConceptoFijoLista.main.co_parroquia.setValue(ConfigConceptoFijoLista.main.OBJ.co_parroquia_domicilio);
        }
    });
}

this.co_banco = new Ext.form.ComboBox({
	fieldLabel:'Banco',
	store: this.storeCO_BANCO,
	typeAhead: true,
	valueField: 'co_banco',
	displayField:'tx_banco',
	hiddenName:'tbrh001_trabajador[co_banco]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:300,
        readOnly:true,
	style:'background:#c9c9c9;',
//	allowBlank:false
});
this.storeCO_BANCO.load({
    callback: function(){
        ConfigConceptoFijoLista.main.co_banco.setValue(ConfigConceptoFijoLista.main.OBJ.co_banco);
    }
});

this.fe_nacimiento = new Ext.form.DateField({
	fieldLabel:'Fecha',
	name:'tbrh001_trabajador[fe_nacimiento]',
	value:this.OBJ.fe_nacimiento,
	allowBlank:false,
	width:100,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.co_tp_motricida = new Ext.form.TextField({
	fieldLabel:'Co tp motricida',
	name:'tbrh001_trabajador[co_tp_motricida]',
	value:this.OBJ.co_tp_motricida,
	allowBlank:false,
	width:200,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.nu_hijo = new Ext.form.NumberField({
	fieldLabel:'Nu hijo',
	name:'tbrh001_trabajador[nu_hijo]',
	value:this.OBJ.nu_hijo,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.tx_direccion_domicilio = new Ext.form.TextField({
	fieldLabel:'Dirección',
	name:'tbrh001_trabajador[tx_direccion_domicilio]',
	value:this.OBJ.tx_direccion_domicilio,
	allowBlank:false,
	width:500,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.co_parroquia_domicilio = new Ext.form.NumberField({
	fieldLabel:'Co parroquia domicilio',
	name:'tbrh001_trabajador[co_parroquia_domicilio]',
	value:this.OBJ.co_parroquia_domicilio,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.tx_ciudad_domicilio = new Ext.form.TextField({
	fieldLabel:'Tx ciudad domicilio',
	name:'tbrh001_trabajador[tx_ciudad_domicilio]',
	value:this.OBJ.tx_ciudad_domicilio,
	allowBlank:false,
	width:200,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.tx_ciudad_nacimiento = new Ext.form.TextField({
	fieldLabel:'Lugar de Nacimiento',
	name:'tbrh001_trabajador[tx_ciudad_nacimiento]',
	value:this.OBJ.tx_ciudad_nacimiento,
	allowBlank:false,
	width:550,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.co_parroquia_nacimiento = new Ext.form.NumberField({
	fieldLabel:'Co parroquia nacimiento',
	name:'tbrh001_trabajador[co_parroquia_nacimiento]',
	value:this.OBJ.co_parroquia_nacimiento,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.co_nacionalidad = new Ext.form.NumberField({
	fieldLabel:'Co nacionalidad',
	name:'tbrh001_trabajador[co_nacionalidad]',
	value:this.OBJ.co_nacionalidad,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.nu_seguro_social = new Ext.form.NumberField({
	fieldLabel:'Seguro Social',
	name:'tbrh001_trabajador[nu_seguro_social]',
	value:this.OBJ.nu_seguro_social,
//	allowBlank:false,
	width:100,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.nu_rif = new Ext.form.TextField({
	fieldLabel:'RIF',
	name:'tbrh001_trabajador[nu_rif]',
	value:this.OBJ.nu_rif,
//	allowBlank:false,
	width:100,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tbrh001_trabajador[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tbrh001_trabajador[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.co_nivel_educativo = new Ext.form.NumberField({
	fieldLabel:'Co nivel educativo',
	name:'tbrh001_trabajador[co_nivel_educativo]',
	value:this.OBJ.co_nivel_educativo,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.nu_anio_aprobado_educativo = new Ext.form.NumberField({
	fieldLabel:'Nu anio aprobado educativo',
	name:'tbrh001_trabajador[nu_anio_aprobado_educativo]',
	value:this.OBJ.nu_anio_aprobado_educativo,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.co_profesion = new Ext.form.NumberField({
	fieldLabel:'Co profesion',
	name:'tbrh001_trabajador[co_profesion]',
	value:this.OBJ.co_profesion,
	allowBlank:false,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.fe_graduacion = new Ext.form.DateField({
	fieldLabel:'Fecha de Graduación',
	name:'tbrh001_trabajador[fe_graduacion]',
	value:this.OBJ.fe_graduacion,
	allowBlank:false,
	width:100,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.tx_correo_electronico = new Ext.form.TextField({
	fieldLabel:'Tx correo electronico',
	name:'tbrh001_trabajador[tx_correo_electronico]',
	value:this.OBJ.tx_correo_electronico,
	allowBlank:false,
	width:200,
        readOnly:true,
	style:'background:#c9c9c9;'
});



//////////ENTREVISTA///////////

this.co_documento_entrevistador = new Ext.form.ComboBox({
	fieldLabel:'Identificación',
	store: this.storeCO_DOCUMENTO_ENTREVISTADOR,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'tbrh001_trabajador[co_documento_entrevistador]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:50,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.storeCO_DOCUMENTO_ENTREVISTADOR.load({
    callback: function(){
        ConfigConceptoFijoLista.main.co_documento_entrevistador.setValue(ConfigConceptoFijoLista.main.OBJ.co_documento_entrevistador);
    }
});

this.nu_cedula_entrevistador = new Ext.form.NumberField({
	fieldLabel:'Cédula',
	name:'tbrh001_trabajador[nu_cedula_entrevistador]',
	value:this.OBJ.nu_cedula,
        width:145,
        readOnly:true,
	style:'background:#c9c9c9;'
});


//this.identificacion_entrevistador = new Ext.form.CompositeField({
//fieldLabel: 'Identificación',
//width:230,
//id:'identificacion',
//items: [
//            this.co_documento_entrevistador,
//            this.nu_cedula_entrevistador
//	]
//});

this.nb_entrevistador = new Ext.form.TextField({
	fieldLabel:'Nombre y Apellido',
	name:'tbrh001_trabajador[nb_entrevistador]',
	value:this.OBJ.nb_primer_nombre,
	//allowBlank:false,
	width:400,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.tx_observacion = new Ext.form.TextArea({
	fieldLabel:'Observación',
	name:'tbrh001_trabajador[tx_observacion]',
	value:this.OBJ.tx_observacion,
//	allowBlank:false,
	width:500,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.nu_telefono_contacto = new Ext.form.TextField({
	fieldLabel:'Teléfono Principal',
	name:'tbrh001_trabajador[nu_telefono_contacto]',
	value:this.OBJ.nu_telefono_contacto,
	allowBlank:false,
	width:100,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.nu_telefono_secundario = new Ext.form.TextField({
	fieldLabel:'Teléfono Secundario',
	name:'tbrh001_trabajador[nu_telefono_secundario]',
	value:this.OBJ.nu_telefono_secundario,
	//allowBlank:false,
	width:100,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.tx_correo_electronico = new Ext.form.TextField({
	fieldLabel:'E-Mail',
	name:'tbrh001_trabajador[tx_correo_electronico]',
	value:this.OBJ.tx_correo_electronico,
	//allowBlank:false,
	width:400,
        readOnly:true,
	style:'background:#c9c9c9;'
});


this.tx_cuenta_bancaria = new Ext.form.TextField({
	fieldLabel:'Cuenta Bancaria',
	name:'tbrh001_trabajador[nu_cuenta_bancaria]',
	value:this.OBJ.nu_cuenta_bancaria,
	width:400,
        readOnly:true,
	style:'background:#c9c9c9;'
});

//MISELANEA//
this.co_grupo_sanguineo = new Ext.form.ComboBox({
	fieldLabel:'Grupo Sanguineo',
	store: this.storeCO_GRUPO_SANGUINEO,
	typeAhead: true,
	valueField: 'co_grupo',
	displayField:'tx_grupo',
	hiddenName:'tbrh001_trabajador[co_grupo_sanguineo]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:50,
        readOnly:true,
	style:'background:#c9c9c9;'
});
this.storeCO_GRUPO_SANGUINEO.load({
    callback: function(){
        ConfigConceptoFijoLista.main.co_grupo_sanguineo.setValue(ConfigConceptoFijoLista.main.OBJ.co_grupo_sanguineo);
    }
});

this.nu_estatura = new Ext.form.NumberField({
	fieldLabel:'Estatura (mtrs)',
	name:'tbrh001_trabajador[nu_estatura]',
	value:this.OBJ.nu_estatura,
        width:50,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.nu_peso = new Ext.form.NumberField({
	fieldLabel:'Peso (Kg)',
	name:'tbrh001_trabajador[nu_peso]',
	value:this.OBJ.nu_peso,
        width:50,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.nu_grado_licencia = new Ext.form.NumberField({
	fieldLabel:'Grado Licencia',
	name:'tbrh001_trabajador[nu_grado_licencia]',
	value:this.OBJ.nu_grado_licencia,
        width:50,
        readOnly:true,
	style:'background:#c9c9c9;'
});

this.in_lente =  new Ext.form.ComboBox({
    fieldLabel:'Usa Lentes',
    typeAhead: true,
    triggerAction: 'all',
    lazyRender:true,
    mode: 'local',
    value:this.OBJ.in_lente,
    hiddenName:'tbrh001_trabajador[in_lente]',
    store: new Ext.data.ArrayStore({
        id: 0,
        fields: [
            'in_lente',
            'tx_descripcion'
        ],
        data: [['1','SI'],['0','NO']]
    }),
    valueField: 'in_lente',
    displayField: 'tx_descripcion',
//    allowBlank:false,
    width:50,
    readOnly:true,
    style:'background:#c9c9c9;'
});

this.in_vehiculo =  new Ext.form.ComboBox({
    fieldLabel:'Posee Vehiculo',
    typeAhead: true,
    triggerAction: 'all',
    lazyRender:true,
    mode: 'local',
    value:this.OBJ.in_vehiculo,
    hiddenName:'tbrh001_trabajador[in_vehiculo]',
    store: new Ext.data.ArrayStore({
        id: 0,
        fields: [
            'in_vehiculo',
            'tx_descripcion'
        ],
        data: [['1','SI'],['0','NO']]
    }),
    valueField: 'in_vehiculo',
    displayField: 'tx_descripcion',
//    allowBlank:false,
    width:50,
    readOnly:true,
    style:'background:#c9c9c9;'
});

this.co_destreza = new Ext.form.ComboBox({
	fieldLabel:'Destreza',
	store: this.storeCO_DESTREZA,
	typeAhead: true,
	valueField: 'co_destreza',
	displayField:'tx_destreza',
	hiddenName:'tbrh001_trabajador[co_destreza]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:100,
        readOnly:true,
	style:'background:#c9c9c9;'
});
this.storeCO_DESTREZA.load({
    callback: function(){
        ConfigConceptoFijoLista.main.co_destreza.setValue(ConfigConceptoFijoLista.main.OBJ.co_destreza);
    }
});

this.co_tipo_vivienda = new Ext.form.ComboBox({
	fieldLabel:'Tipo Vivienda',
	store: this.storeCO_TIPO_VIVIENDA,
	typeAhead: true,
	valueField: 'co_tipo_vivienda',
	displayField:'tx_tipo_vivienda',
	hiddenName:'tbrh001_trabajador[co_tipo_vivienda]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:100,
        readOnly:true,
	style:'background:#c9c9c9;'
});
this.storeCO_TIPO_VIVIENDA.load({
    callback: function(){
        ConfigConceptoFijoLista.main.co_tipo_vivienda.setValue(ConfigConceptoFijoLista.main.OBJ.co_tipo_vivienda);
    }
});


this.co_grado_instruccion = new Ext.form.ComboBox({
	fieldLabel:'Grado Instrucción',
	store: this.storeCO_GRADO_INSTRUCCION,
	typeAhead: true,
	valueField: 'co_nom_grado_instruccion',
	displayField:'tx_nom_grado_instruccion',
	hiddenName:'tbrh001_trabajador[co_nivel_educativo]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:300,
        readOnly:true,
	style:'background:#c9c9c9;'
});
this.storeCO_GRADO_INSTRUCCION.load({
    callback: function(){
        ConfigConceptoFijoLista.main.co_grado_instruccion.setValue(ConfigConceptoFijoLista.main.OBJ.co_nivel_educativo);
    }
});

this.co_profesion = new Ext.form.ComboBox({
	fieldLabel:'Profesion',
	store: this.storeCO_PROFESION,
	typeAhead: true,
	valueField: 'co_profesion',
	displayField:'tx_profesion',
	hiddenName:'tbrh001_trabajador[co_profesion]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:500,
        readOnly:true,
	style:'background:#c9c9c9;'
});
this.storeCO_PROFESION.load({
    callback: function(){
        ConfigConceptoFijoLista.main.co_profesion.setValue(ConfigConceptoFijoLista.main.OBJ.co_profesion);
    }
});

this.guardar = new Ext.Button({
    text:'Procesar',
    iconCls: 'icon-fin',
    handler:function(){

        if(!ConfigConceptoFijoLista.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        ConfigConceptoFijoLista.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/procesar',
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

                 ConfigConceptoFijoLista.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigConceptoFijoLista.main.winformPanel_.close();
    }
});

this.fieldDireccion = new Ext.form.FieldSet({
        title: 'Dirección Habitación',
        items:[                 
                this.co_estado,
                this.co_municipio,
                this.co_parroquia,
                this.tx_direccion_domicilio
              ]
});

this.fielDatos = new Ext.form.FieldSet({
        border:false,   
        items:[                 
                this.identificacion,
                this.nb_primer_nombre,
                this.nb_segundo_nombre,
                this.nb_primer_apellido,
                this.nb_segundo_apellido,
                this.co_edo_civil,
//                this.fe_nacimiento
              ]
});


this.fieldNacimiento = new Ext.form.FieldSet({
        title: 'Datos Nacimiento',
        items:[                 
                this.fe_nacimiento,
                this.tx_ciudad_nacimiento        
              ]
});



this.panelImagen = new Ext.Panel({    
    border:true,
    html:'<img width=150 height=150 src = "'+ConfigConceptoFijoLista.main.OBJ.foto+'"> ',
    bodyStyle:'padding:5px;'
});

this.fielFoto = new Ext.form.FieldSet({
        border:false,   
        width:'300',
        height:'100%',
        labelWidth: 1,
        items:[                 
               this.panelImagen
              ]
});





this.CompositeDatos = new Ext.form.CompositeField({  
        items: [
            this.fielDatos,
            this.fielFoto
	]
});

this.fieldTrabajador = new Ext.form.FieldSet({
        title: 'Datos del Trabajador',    
        labelWidth: 1,
        items:[                 
                this.CompositeDatos
             //   this.tx_ciudad_nacimiento
              ]
});

this.fieldEntrevista = new Ext.form.FieldSet({
        title: 'Datos del Entrevistador',
        items:[                 
    //            this.identificacion_entrevistador,
                this.co_documento_entrevistador,
                this.nu_cedula_entrevistador,
                this.nb_entrevistador,
                this.tx_observacion
              ]
});

this.fieldContacto = new Ext.form.FieldSet({
        title: 'Datos Contacto',
        items:[                 
                this.nu_telefono_contacto,
                this.nu_telefono_secundario,
                this.tx_correo_electronico
              ]
});

this.fieldBanco = new Ext.form.FieldSet({
        title: 'Datos Cuenta Bancaria',
        items:[                 
                this.co_banco,
                this.tx_cuenta_bancaria
              ]
});

this.fieldMicelanea = new Ext.form.FieldSet({
        //title: '',
        items:[                 
                this.nu_rif,
                this.nu_seguro_social,
                this.co_grupo_sanguineo,
                this.nu_estatura,
                this.nu_peso,
                this.in_lente,
                this.in_vehiculo,
                this.nu_grado_licencia,
                this.co_destreza,
                this.co_tipo_vivienda,
                this.co_grado_instruccion,
                this.co_profesion,
                this.fe_graduacion
              ]
});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        //ConfigConceptoFijoLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigConceptoFijo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoFijo/editar',
         scripts: true,
         text: "Cargando..",
         params:{
                ficha:ConfigConceptoFijoLista.main.OBJ.co_ficha,
                grupo:ConfigConceptoFijoLista.main.co_grupo.getValue(),
                subgrupo:ConfigConceptoFijoLista.main.co_subgrupo.getValue()
            }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = ConfigConceptoFijoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_conceptos_fijos');
	//ConfigConceptoFijoLista.main.mascara.show();
        this.msg = Ext.get('formularioConfigConceptoFijo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoFijo/editar/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Eliminar un registro
this.eliminar= new Ext.Button({
    text:'Eliminar',
    iconCls: 'icon-eliminar',
    handler:function(){
	this.codigo  = ConfigConceptoFijoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_conceptos_fijos');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoFijo/eliminar',
            params:{
                co_conceptos_fijos:ConfigConceptoFijoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_conceptos_fijos')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    ConfigConceptoFijoLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                ConfigConceptoFijoLista.main.mascara.hide();
            }});
	}});
    }
});

this.editar.disable();
this.eliminar.disable();

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

function renderEstatus(val, attr, record) { 
     if(val == true)
        return 'Activo';   
     else
        return 'Inactivo';
     
} 

//objeto store
this.store_lista_sueldo = this.getListaSueldo();

this.gridPanelSueldo = new Ext.grid.GridPanel({
        title:'Lista de Cargos',
        store: this.store_lista_sueldo,
        loadMask:true,
        frame:true,
        border: true,
        bodyStyle: 'margin: 0px; padding: 0px 0px 0px 0px;',
        height:510,
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_estructura_administrativa', hidden: true, dataIndex: 'co_estructura_administrativa'},
            {header: 'co_clasif_personal', hidden: true, dataIndex: 'co_clasif_personal'},
            {header: 'tx_estructura', hidden: true, dataIndex: 'tx_estructura'},
            {header: 'co_nom_trabajador', hidden: true, dataIndex: 'co_sueldo_trabajador'},
            {header: 'co_tp_cargo', hidden: true, dataIndex: 'co_tp_cargo'},
            {header: 'co_tabulador', hidden: true, dataIndex: 'co_tabulador'},
            {header: 'co_tp_nomina', hidden: true,dataIndex: 'co_tp_nomina'},
            {header: 'co_cargo', hidden: true,dataIndex: 'co_cargo_estructura'},
            {header: 'co_tipo_pago', hidden: true,dataIndex: 'co_tipo_pago'},
            {header: 'Nomina Estructura', width:140, menuDisabled:true,dataIndex: 'tx_tp_nomina'},
            {header: 'Grupo Nomina', width:140, menuDisabled:true,dataIndex: 'tx_grupo_nomina'},
            {header: 'Cargo', wtx_estructuraidth:200, menuDisabled:true,dataIndex: 'tx_cargo',renderer:textoLargo},
            {header: 'Horas', width:80, menuDisabled:true,dataIndex: 'nu_horas'},
            {header: 'Fecha Asigación', width:100, menuDisabled:true,dataIndex: 'fe_ingreso'},            
            {header: 'Sueldo',width:150, menuDisabled:true,dataIndex: 'mo_salario_base',renderer:renderMonto},
            {header: 'Tipo de Pago',width:100, menuDisabled:true,dataIndex: 'tx_tipo_pago'},
            {header: 'Estatus',width:100, menuDisabled:true,dataIndex: 'in_activo',renderer:renderEstatus}
        ],
        stripeRows: true,
        autoScroll:true,
        stateful: true,
        bbar: new Ext.PagingToolbar({
            pageSize: 20,
            store: this.store_lista_sueldo,
            displayInfo: true,
            displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
            emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
        })
});

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Conceptos',
    //iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
    frame:true,
    border: true,
    bodyStyle: 'margin: 0px; padding: 0px 0px 0px 0px;',
    height:510,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_conceptos_fijos',hidden:true, menuDisabled:true,dataIndex: 'co_conceptos_fijos'},
    {header: 'Monto', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'nu_monto'},
    {header: 'Valor', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'nu_valor'},
    {header: 'Saldo', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'mo_saldo'},
    {header: 'Fecha Mov.', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'fe_movimiento'},
    {header: 'Fecha Venc.', width:80,  menuDisabled:true, sortable: true,  dataIndex: 'fe_vencimiento'},
    {header: 'Codigo', width:60,  menuDisabled:true, sortable: true,  dataIndex: 'nu_concepto'},
    {header: 'Descripcion', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_concepto'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{
        cellclick:function(Grid, rowIndex, columnIndex,e ){
            ConfigConceptoFijoLista.main.editar.enable();
            ConfigConceptoFijoLista.main.eliminar.enable();
        }
    },
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.fieldConceptoFijo = new Ext.form.FieldSet({
        border: true,
        frame:false,
        bodyStyle: 'margin: 0px; padding: -10px -10px -10px -10px;',
        items:[                 
            //this.gridPanel_
              ]
});


this.tabuladores = new Ext.TabPanel({
        resizeTabs:true, // turn on tab resizing
        minTabWidth: 115,
        tabWidth:100,
        border:true,
        enableTabScroll:true,
        autoWidth:true,
        deferredRender:false,
        height:550,
        autoScroll:true,
        activeTab: 0,
        bodyStyle:'padding:5px;',
        defaults: {autoScroll:true},
        items:[
                {
                        title: 'Datos Básicos',
                        items:[this.fieldTrabajador,
                               this.fieldDireccion,
                               this.fieldNacimiento]
                },
                {
                        title: 'Cargo / Sueldo',
                        border: true,
                        frame:false,
                        bodyStyle: 'margin: 0px; padding: -10px -10px -10px -10px;',
                        height:460,
                        items:[this.gridPanelSueldo]
                },
                {
                        title: 'Conceptos Fijos',
                        border: true,
                        frame:false,
                        bodyStyle: 'margin: 0px; padding: -10px -10px -10px -10px;',
                        height:460,
                        items:[this.gridPanel_]
                }
        ]
});




this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:750,
    autoHeight:true,  
    autoScroll:true,
    fileUpload: true,
    bodyStyle:'padding:5px;',
    items:[
            this.co_trabajador,
            this.co_solicitud,
            this.tabuladores
          ]
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        ConfigConceptoFijoLista.main.winformPanel_.close();
    }
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Trabajador',
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
        //this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();

ConfigConceptoFijoLista.main.store_lista_sueldo.baseParams.co_trabajador = ConfigConceptoFijoLista.main.OBJ.co_trabajador;
ConfigConceptoFijoLista.main.store_lista.baseParams.co_ficha = ConfigConceptoFijoLista.main.OBJ.co_ficha;

this.store_lista_sueldo.load({
    params:{
        co_trabajador: ConfigConceptoFijoLista.main.OBJ.co_trabajador
    }
});

this.store_lista.load({
    params:{
        co_ficha: ConfigConceptoFijoLista.main.OBJ.co_ficha
    }
});

this.store_lista.on('load',function(){
    ConfigConceptoFijoLista.main.getDatos();
});

//TrabajadorLista.main.mascara.hide();
},getStoreCO_PROFESION(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcoprofesion',
        root:'data',
        fields:[
                {name: 'co_profesion'},
                {name: 'tx_profesion'}
            ]
    });
    return this.store;
}
,getStoreCO_GRADO_INSTRUCCION(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcogradoinstrucccion',
        root:'data',
        fields:[
                {name: 'co_nom_grado_instruccion'},
                {name: 'tx_nom_grado_instruccion'}
            ]
    });
    return this.store;
}
,getStoreCO_DESTREZA(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcodestreza',
        root:'data',
        fields:[
                {name: 'co_destreza'},
                {name: 'tx_destreza'}
            ]
    });
    return this.store;
}
,getStoreCO_TIPO_VIVIENDA(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcotipovivienda',
        root:'data',
        fields:[
                {name: 'co_tipo_vivienda'},
                {name: 'tx_tipo_vivienda'}
            ]
    });
    return this.store;
},getStoreCO_GRUPO_SANGUINEO(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcogruposanguineo',
        root:'data',
        fields:[
                {name: 'co_grupo'},
                {name: 'tx_grupo'}
            ]
    });
    return this.store;
}
,getStoreCO_BANCO(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcobanco',
        root:'data',
        fields:[
                {name: 'co_banco'},
                {name: 'tx_banco'}
            ]
    });
    return this.store;
},
getStoreCO_PARROQUIA(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcoparroquia',
        root:'data',
        fields:[
                {name: 'co_parroquia'},
                {name: 'tx_parroquia'}
            ]
    });
    return this.store;
},getStoreCO_MUNICIPIO(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcomunicipio',
        root:'data',
        fields:[
                {name: 'co_municipio'},
                {name: 'nb_municipio'}
            ]
    });
    return this.store;
}
,getStoreCO_ESTADO(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcoestado',
        root:'data',
        fields:[
                {name: 'co_estado'},
                {name: 'nb_estado'}
            ]
    });
    return this.store;
}
,getStoreCO_DOCUMENTO:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcodocumento',
        root:'data',
        fields:[
            {name: 'co_documento'},
            {name: 'inicial'}
            ]
    });
    return this.store;
}
,getStoreCO_SEXO:function(){
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
,getStoreCO_EDO_CIVIL:function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storefkcoedocivil',
        root:'data',
        fields:[
            {name: 'co_edo_civil'},
            {name: 'tx_edo_civil'}
            ]
    });
    return this.store;
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/ConfigConceptoFijo/storelista',
    root:'data',
    fields:[
    {name: 'co_conceptos_fijos'},
    {name: 'co_nom_trabajador'},
    {name: 'nu_monto'},
    {name: 'nu_valor'},
    {name: 'mo_saldo'},
    {name: 'fe_movimiento'},
    {name: 'fe_vencimiento'},
    {name: 'co_embargo'},
    {name: 'co_tp_formula'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'tx_codigo_concepto'},
    {name: 'co_concepto_formula'},
    {name: 'co_ficha'},
    {name: 'nu_concepto'},
    {name: 'tx_concepto'},
           ]
    });
    return this.store;
},
getListaSueldo: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storelistaSueldo',
    root:'data',
    fields:[
                {name: 'co_nom_trabajador'},
                {name: 'co_tp_nomina'},
                {name: 'co_tp_cargo'},
                {name: 'mo_salario_base'},
                {name: 'co_tipo_pago'},
                {name: 'tx_tipo_pago'},                
                {name: 'nu_horas'},
                {name: 'fe_ingreso'},
                {name: 'fe_finiquito'},
                {name: 'co_cargo_estructura'},
                {name: 'tx_tp_nomina'},
                {name: 'in_activo'},
                {name: 'tx_cargo'},
                {name: 'co_tabulador'},
                {name: 'co_clasif_personal'},
                {name: 'co_grupo_nomina'},
                {name: 'tx_grupo_nomina'},
                {name: 'tx_estructura'},
                {name: 'co_estructura_administrativa'}
           ]
    });
    return this.store;
},
getDatos:function(){

    Ext.Ajax.request({
                method:'POST',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Trabajador/datoNomina',
                params:{
                    co_trabajador: ConfigConceptoFijoLista.main.OBJ.co_trabajador
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);

                    if(!obj.data){
                        
                        ConfigConceptoFijoLista.main.co_grupo.setValue(null);
                        ConfigConceptoFijoLista.main.co_subgrupo.setValue(null);

                    }else{

                        ConfigConceptoFijoLista.main.co_grupo.setValue(obj.data.grupo);
                        ConfigConceptoFijoLista.main.co_subgrupo.setValue(obj.data.subgrupo);
                     
                    }
                }
        });

}
};
Ext.onReady(ConfigConceptoFijoLista.main.init, ConfigConceptoFijoLista.main);
</script>
