<script type="text/javascript">
Ext.ns("TrabajadorEditar");
TrabajadorEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.OBJ2 = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data2 ?>'});
console.log(this.OBJ2.soli);
this.rowIndex;
this.storeCO_DOCUMENTO               = this.getStoreCO_DOCUMENTO();
this.storeCO_DOCUMENTO_ENTREVISTADOR = this.getStoreCO_DOCUMENTO();
this.storeCO_SEXO                    = this.getStoreCO_SEXO();
this.storeCO_EDO_CIVIL               = this.getStoreCO_EDO_CIVIL();
this.storeCO_GRUPO_NOMINA            = this.getStoreCO_GRUPO_NOMINA();

this.storeCO_ESTADO                 = this.getStoreCO_ESTADO();
this.storeCO_MUNICIPIO              = this.getStoreCO_MUNICIPIO();
this.storeCO_PARROQUIA              = this.getStoreCO_PARROQUIA();
this.storeCO_BANCO                  = this.getStoreCO_BANCO();
this.storeCO_GRUPO_SANGUINEO        = this.getStoreCO_GRUPO_SANGUINEO();
this.storeCO_DESTREZA               = this.getStoreCO_DESTREZA();
this.storeCO_TIPO_VIVIENDA          = this.getStoreCO_TIPO_VIVIENDA();
this.storeCO_GRADO_INSTRUCCION      = this.getStoreCO_GRADO_INSTRUCCION();
this.storeCO_PROFESION              = this.getStoreCO_PROFESION();

this.storeCO_SITUACION             = this.getStoreCO_SITUACION();

this.store_lista           = this.getLista();
this.store_lista_familia   = this.getLista_familiar();
this.store_lista_profesion = this.getLista_profesion();

console.log(this.store_lista);

//<ClavePrimaria>
this.co_trabajador = new Ext.form.Hidden({
    name:'co_trabajador',
    value:this.OBJ.co_trabajador
});

this.co_ficha = new Ext.form.Hidden({
    name:'co_fichas',
    value:this.OBJ.co_ficha
});

this.co_nom_trabajador = new Ext.form.Hidden({
    name:'co_nom_trabajador',
    value:this.OBJ.co_nom_trabajador
});

this.co_ingreso_de_trabajador = new Ext.form.Hidden({
    name:'co_ingreso_de_trabajador',
    value:this.OBJ.co_ingreso_de_trabajador
});

this.co_ingreso_trabajador = new Ext.form.Hidden({
    name:'co_ingreso_trabajador',
    value:this.OBJ.co_ingreso_trabajador
});

this.soli = new Ext.form.Hidden({
    name:'soli',
    value:this.OBJ2.soli
});

this.hiddenJsonSueldo  = new Ext.form.Hidden({
        name:'json_sueldo',
        value:''
});

this.hiddenJsonFamiliar  = new Ext.form.Hidden({
        name:'json_familiar',
        value:''
});

this.hiddenJsonProfesion  = new Ext.form.Hidden({
        name:'json_profesion',
        value:''
});

this.co_solicitud = new Ext.form.Hidden({
	name:'tbrh001_trabajador[co_solicitud]',
	value:this.OBJ.co_solicitud
});


this.Registro = Ext.data.Record.create([
         {name: 'co_nom_trabajador'},
         {name: 'co_cargo_estructura'},
         {name: 'co_tp_nomina'},
         {name: 'fe_ingreso'},
         {name: 'tx_cargo'},
         {name: 'co_tp_cargo'},
         {name: 'mo_salario_base'},
         {name: 'co_grupo_nomina'},
         {name: 'nu_horas'},
         {name: 'co_tipo_pago'},
         {name: 'tx_tipo_pago'},
         {name: 'co_tabulador'},
         {name: 'co_estructura_administrativa'},
         {name: 'tx_estructura'}
]);

this.RegistroFamiliar = Ext.data.Record.create([
        {name: 'tx_identificacion'},
        {name: 'nb_familiar'},
        {name: 'co_sexo'},
        {name: 'co_parentesco'},
        {name: 'fe_nacimiento'},
        {name: 'tx_sexo'},
        {name: 'tx_parentesco'},
        {name: 'co_trabajador'},
        {name: 'co_familiar_trabajador'}
]);


this.RegistroProfesion = Ext.data.Record.create([
        {name: 'fe_egreso'},
        {name: 'co_profesion'},
        {name: 'co_universidad'},
        {name: 'tx_universidad'},
        {name: 'tx_profesion'},
        {name: 'tx_titulo_obtenido'},
        {name: 'co_trabajador'},
        {name: 'co_profesion_trabajador'}
]);

this.nu_cedula = new Ext.form.NumberField({
	fieldLabel:'Nu cedula',
	name:'tbrh001_trabajador[nu_cedula]',
	value:this.OBJ.nu_cedula,
        width:145,
	allowBlank:false
});

this.nb_primer_nombre = new Ext.form.TextField({
	fieldLabel:'Primer Nombre',
	name:'tbrh001_trabajador[nb_primer_nombre]',
	value:this.OBJ.nb_primer_nombre,
	allowBlank:false,
	width:200
});

this.nb_segundo_nombre = new Ext.form.TextField({
	fieldLabel:'Segundo Nombre',
	name:'tbrh001_trabajador[nb_segundo_nombre]',
	value:this.OBJ.nb_segundo_nombre,
	width:200
});

this.nb_primer_apellido = new Ext.form.TextField({
	fieldLabel:'Primer Apellido',
	name:'tbrh001_trabajador[nb_primer_apellido]',
	value:this.OBJ.nb_primer_apellido,
	allowBlank:false,
	width:200
});

this.nb_segundo_apellido = new Ext.form.TextField({
	fieldLabel:'Segundo Apellido',
	name:'tbrh001_trabajador[nb_segundo_apellido]',
	value:this.OBJ.nb_segundo_apellido,
	width:200
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
	allowBlank:false
});

this.storeCO_DOCUMENTO.load({
    callback: function(){   
        TrabajadorEditar.main.co_documento.setValue(TrabajadorEditar.main.OBJ.co_documento);
    }
});

this.co_documento.on("blur",function(){
    if(TrabajadorEditar.main.nu_cedula.getValue()!=''){
        TrabajadorEditar.main.verificarTrabajador();
    }
});

this.nu_cedula.on("blur",function(){
        TrabajadorEditar.main.verificarTrabajador();
});

//this.nu_cedula = new Ext.form.NumberField({
//	fieldLabel:'Nu cedula',
//	name:'tbrh001_trabajador[nu_cedula]',
//	value:this.OBJ.nu_cedula,
//        width:145,
//	allowBlank:false
//});

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
//	allowBlank:false
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
//	allowBlank:false
});

//alert(TrabajadorEditar.main.OBJ.co_edo_civil);
this.storeCO_EDO_CIVIL.load({
    callback: function(){
        TrabajadorEditar.main.co_edo_civil.setValue(TrabajadorEditar.main.OBJ.co_edo_civil);
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
	allowBlank:false
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
//	allowBlank:false,
        listeners:{
            select: function(){
                TrabajadorEditar.main.storeCO_MUNICIPIO.baseParams.co_estado=this.getValue();
                TrabajadorEditar.main.storeCO_MUNICIPIO.load();
            }
        }
});
this.storeCO_ESTADO.load({
    callback: function(){
        TrabajadorEditar.main.co_estado.setValue(TrabajadorEditar.main.OBJ.co_estado);
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
//	allowBlank:false,
        listeners:{
            select: function(){
                TrabajadorEditar.main.storeCO_PARROQUIA.baseParams.co_municipio=this.getValue();
                TrabajadorEditar.main.storeCO_PARROQUIA.load();
            }
        }
});

if(TrabajadorEditar.main.OBJ.co_estado!=''){
    this.storeCO_MUNICIPIO.load({
        params:{
            co_estado:TrabajadorEditar.main.OBJ.co_estado
        },
        callback:function(){
            TrabajadorEditar.main.co_municipio.setValue(TrabajadorEditar.main.OBJ.co_municipio);
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
//	allowBlank:false
});

if(TrabajadorEditar.main.OBJ.co_municipio!=''){
    this.storeCO_PARROQUIA.load({
        params:{
            co_municipio:TrabajadorEditar.main.OBJ.co_municipio
        },
        callback:function(){
            TrabajadorEditar.main.co_parroquia.setValue(TrabajadorEditar.main.OBJ.co_parroquia_domicilio);
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
//	allowBlank:false
});
this.storeCO_BANCO.load({
    callback: function(){
        TrabajadorEditar.main.co_banco.setValue(TrabajadorEditar.main.OBJ.co_banco);
    }
});

this.fe_nacimiento = new Ext.form.DateField({
	fieldLabel:'Fecha',
	name:'tbrh001_trabajador[fe_nacimiento]',
	value:this.OBJ.fe_nacimiento,
//	allowBlank:false,
	width:100
});

this.fe_ingreso = new Ext.form.DateField({
	fieldLabel:'Fecha de Ingreso',
	name:'tbrh001_trabajador[fe_ingreso]',
	value:this.OBJ.fe_ingreso,
	allowBlank:false,
	width:100
});

this.co_tp_motricida = new Ext.form.TextField({
	fieldLabel:'Co tp motricida',
	name:'tbrh001_trabajador[co_tp_motricida]',
//	value:this.OBJ.co_tp_motricida,
	allowBlank:false,
	width:200
});

this.nu_hijo = new Ext.form.NumberField({
	fieldLabel:'Nu hijo',
	name:'tbrh001_trabajador[nu_hijo]',
	value:this.OBJ.nu_hijo,
	allowBlank:false
});

this.tx_direccion_domicilio = new Ext.form.TextField({
	fieldLabel:'Dirección',
	name:'tbrh001_trabajador[tx_direccion_domicilio]',
	value:this.OBJ.tx_direccion_domicilio,
//	allowBlank:false,
	width:500
});

this.co_parroquia_domicilio = new Ext.form.NumberField({
	fieldLabel:'Co parroquia domicilio',
	name:'tbrh001_trabajador[co_parroquia_domicilio]',
	value:this.OBJ.co_parroquia_domicilio,
//	allowBlank:false
});

this.tx_ciudad_domicilio = new Ext.form.TextField({
	fieldLabel:'Tx ciudad domicilio',
	name:'tbrh001_trabajador[tx_ciudad_domicilio]',
	value:this.OBJ.tx_ciudad_domicilio,
//	allowBlank:false,
	width:200
});

this.tx_ciudad_nacimiento = new Ext.form.TextField({
	fieldLabel:'Lugar de Nacimiento',
	name:'tbrh001_trabajador[tx_ciudad_nacimiento]',
	value:this.OBJ.tx_ciudad_nacimiento,
//	allowBlank:false,
	width:550
});

this.co_parroquia_nacimiento = new Ext.form.NumberField({
	fieldLabel:'Co parroquia nacimiento',
	name:'tbrh001_trabajador[co_parroquia_nacimiento]',
	value:this.OBJ.co_parroquia_nacimiento,
//	allowBlank:false
});

this.co_nacionalidad = new Ext.form.NumberField({
	fieldLabel:'Co nacionalidad',
	name:'tbrh001_trabajador[co_nacionalidad]',
	value:this.OBJ.co_nacionalidad,
//	allowBlank:false
});

this.nu_seguro_social = new Ext.form.NumberField({
	fieldLabel:'Seguro Social',
	name:'tbrh001_trabajador[nu_seguro_social]',
	value:this.OBJ.nu_seguro_social,
//	allowBlank:false,
	width:100
});

this.nu_rif = new Ext.form.TextField({
	fieldLabel:'RIF',
	name:'tbrh001_trabajador[nu_rif]',
	value:this.OBJ.nu_rif,
//	allowBlank:false,
	width:100
});

this.created_at = new Ext.form.DateField({
	fieldLabel:'Created at',
	name:'tbrh001_trabajador[created_at]',
	value:this.OBJ.created_at,
	allowBlank:false
});

this.updated_at = new Ext.form.DateField({
	fieldLabel:'Updated at',
	name:'tbrh001_trabajador[updated_at]',
	value:this.OBJ.updated_at,
	allowBlank:false
});

this.co_nivel_educativo = new Ext.form.NumberField({
	fieldLabel:'Co nivel educativo',
	name:'tbrh001_trabajador[co_nivel_educativo]',
	value:this.OBJ.co_nivel_educativo,
	allowBlank:false
});

this.nu_anio_aprobado_educativo = new Ext.form.NumberField({
	fieldLabel:'Nu anio aprobado educativo',
	name:'tbrh001_trabajador[nu_anio_aprobado_educativo]',
	value:this.OBJ.nu_anio_aprobado_educativo,
	allowBlank:false
});

this.co_profesion = new Ext.form.NumberField({
	fieldLabel:'Co profesion',
	name:'tbrh001_trabajador[co_profesion]',
	value:this.OBJ.co_profesion,
	allowBlank:false
});

this.fe_graduacion = new Ext.form.DateField({
	fieldLabel:'Fecha de Graduación',
	name:'tbrh001_trabajador[fe_graduacion]',
	value:this.OBJ.fe_graduacion,
	//allowBlank:false,
	width:100
});

this.tx_correo_electronico = new Ext.form.TextField({
	fieldLabel:'Tx correo electronico',
	name:'tbrh001_trabajador[tx_correo_electronico]',
	value:this.OBJ.tx_correo_electronico,
	allowBlank:false,
	width:200
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
	width:50
});

this.storeCO_DOCUMENTO_ENTREVISTADOR.load({
    callback: function(){
        TrabajadorEditar.main.co_documento_entrevistador.setValue(TrabajadorEditar.main.OBJ.co_documento_entrevistador);
    }
});

this.nu_cedula_entrevistador = new Ext.form.NumberField({
	fieldLabel:'Cédula',
	name:'tbrh001_trabajador[nu_cedula_entrevistador]',
	value:this.OBJ.nu_cedula_entrevistador,
        width:145
});


this.nb_entrevistador = new Ext.form.TextField({
	fieldLabel:'Nombre y Apellido',
	name:'tbrh001_trabajador[nb_entrevistador]',
	value:this.OBJ.nb_entrevistador,
	//allowBlank:false,
	width:400
});

this.tx_observacion = new Ext.form.TextArea({
	fieldLabel:'Observación',
	name:'tbrh001_trabajador[tx_observacion]',
	value:this.OBJ.tx_observacion,
//	allowBlank:false,
	width:500
});

this.nu_telefono_contacto = new Ext.form.TextField({
	fieldLabel:'Teléfono Principal',
	name:'tbrh001_trabajador[nu_telefono_contacto]',
	value:this.OBJ.nu_telefono_contacto,
	//allowBlank:false,
	width:100
});

this.nu_telefono_secundario = new Ext.form.TextField({
	fieldLabel:'Teléfono Secundario',
	name:'tbrh001_trabajador[nu_telefono_secundario]',
	value:this.OBJ.nu_telefono_secundario,
	//allowBlank:false,
	width:100
});

this.tx_correo_electronico = new Ext.form.TextField({
	fieldLabel:'E-Mail',
	name:'tbrh001_trabajador[tx_correo_electronico]',
	value:this.OBJ.tx_correo_electronico,
	//allowBlank:false,
	width:400
});


this.tx_cuenta_bancaria = new Ext.form.TextField({
	fieldLabel:'Cuenta Bancaria',
	name:'tbrh001_trabajador[nu_cuenta_bancaria]',
	value:this.OBJ.nu_cuenta_bancaria,
	width:200,
        //maskRe: /[0-9]/,
	maxLength:20
        
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
	width:50
});
this.storeCO_GRUPO_SANGUINEO.load({
    callback: function(){
        TrabajadorEditar.main.co_grupo_sanguineo.setValue(TrabajadorEditar.main.OBJ.co_grupo_sanguineo);
    }
});

this.nu_estatura = new Ext.form.NumberField({
	fieldLabel:'Estatura (mtrs)',
	name:'tbrh001_trabajador[nu_estatura]',
	value:this.OBJ.nu_estatura,
        width:50
});

this.nu_peso = new Ext.form.NumberField({
	fieldLabel:'Peso (Kg)',
	name:'tbrh001_trabajador[nu_peso]',
	value:this.OBJ.nu_peso,
        width:50
});

this.nu_grado_licencia = new Ext.form.NumberField({
	fieldLabel:'Grado Licencia',
	name:'tbrh001_trabajador[nu_grado_licencia]',
	value:this.OBJ.nu_grado_licencia,
        width:50
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
    width:50
});

//mio
this.situacion = new Ext.form.ComboBox({
	fieldLabel:'Situacion',
	store: this.storeCO_SITUACION,
	typeAhead: true,
	valueField: 'co_nom_situacion',
	displayField:'tx_nom_situacion',
	hiddenName:'tbrh001_trabajador[co_estatus]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:300,
//	allowBlank:false
});
this.storeCO_SITUACION.load({
    callback: function(){
        TrabajadorEditar.main.situacion.setValue(TrabajadorEditar.main.OBJ.co_estatus);
    }
});
//fin mio

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
    width:50
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
	width:100
});
this.storeCO_DESTREZA.load({
    callback: function(){
        TrabajadorEditar.main.co_destreza.setValue(TrabajadorEditar.main.OBJ.co_destreza);
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
	width:100
});
this.storeCO_TIPO_VIVIENDA.load({
    callback: function(){
        TrabajadorEditar.main.co_tipo_vivienda.setValue(TrabajadorEditar.main.OBJ.co_tipo_vivienda);
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
	width:300
});
this.storeCO_GRADO_INSTRUCCION.load({
    callback: function(){
        TrabajadorEditar.main.co_grado_instruccion.setValue(TrabajadorEditar.main.OBJ.co_nivel_educativo);
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
	width:500
});
this.storeCO_PROFESION.load({
    callback: function(){
        TrabajadorEditar.main.co_profesion.setValue(TrabajadorEditar.main.OBJ.co_profesion);
    }
});

this.agregar = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {

        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/agregarSueldo',
            scripts: true,
            text: "Cargando..",
            params:{
                co_trabajador: TrabajadorEditar.main.OBJ.co_trabajador
            }
        });
    }
});

//Editar un registro
this.editar = new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.msg = Ext.get('formularioAgregar');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/agregarSueldo2',
         params:{
            co_nom_trabajador:TrabajadorEditar.main.gridPanel.getSelectionModel().getSelected().get('co_nom_trabajador'),
            co_clasif_personal:TrabajadorEditar.main.gridPanel.getSelectionModel().getSelected().get('co_clasif_personal'),
            co_tp_nomina:TrabajadorEditar.main.gridPanel.getSelectionModel().getSelected().get('co_tp_nomina'),   
            co_tp_cargo:TrabajadorEditar.main.gridPanel.getSelectionModel().getSelected().get('co_tp_cargo'), 
            co_grupo_nomina: TrabajadorEditar.main.gridPanel.getSelectionModel().getSelected().get('co_grupo_nomina'),
            fe_ingreso:TrabajadorEditar.main.gridPanel.getSelectionModel().getSelected().get('fe_ingreso'),                    
            co_cargo_estructura:TrabajadorEditar.main.gridPanel.getSelectionModel().getSelected().get('co_cargo_estructura'),
            mo_salario_base:TrabajadorEditar.main.gridPanel.getSelectionModel().getSelected().get('mo_salario_base'),
            co_tipo_pago:TrabajadorEditar.main.gridPanel.getSelectionModel().getSelected().get('co_tipo_pago'),
            nu_horas:TrabajadorEditar.main.gridPanel.getSelectionModel().getSelected().get('nu_horas'),
            co_tabulador:TrabajadorEditar.main.gridPanel.getSelectionModel().getSelected().get('co_tabulador'),
            co_estructura_administrativa: TrabajadorEditar.main.gridPanel.getSelectionModel().getSelected().get('co_estructura_administrativa'),
            tx_estructura: TrabajadorEditar.main.gridPanel.getSelectionModel().getSelected().get('tx_estructura'),
            co_ficha: TrabajadorEditar.main.gridPanel.getSelectionModel().getSelected().get('co_ficha'),
            co_estatus: TrabajadorEditar.main.gridPanel.getSelectionModel().getSelected().get('co_estatus'),
            in_cestaticket: TrabajadorEditar.main.gridPanel.getSelectionModel().getSelected().get('in_cestaticket'),
            rowIndex: TrabajadorEditar.main.rowIndex
         },
         scripts: true,
         text: "Cargando.."
        });
    }
});

this.editar.disable();


function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

function renderEstatus(val, attr, record) { 
     if(val == true)
        return 'Activo';   
     else
        return 'Inactivo';
     
} 


this.gridPanel = new Ext.grid.GridPanel({
       // title:'Lista',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:150,  
        width:1010,
        tbar:[this.agregar,'-',this.editar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_estructura_administrativa', hidden: true, dataIndex: 'co_estructura_administrativa'},
            {header: 'co_clasif_personal', hidden: true, dataIndex: 'co_clasif_personal'},
            {header: 'co_estatus', hidden: true, dataIndex: 'co_estatus'},
            {header: 'in_cesticket', hidden: true, dataIndex: 'in_cestaticket'},
            {header: 'tx_estructura', hidden: true, dataIndex: 'tx_estructura'},
            {header: 'co_nom_trabajador', hidden: true, dataIndex: 'co_sueldo_trabajador'},
            {header: 'co_tp_cargo', hidden: true, dataIndex: 'co_tp_cargo'},
            {header: 'co_tabulador', hidden: true, dataIndex: 'co_tabulador'},
            {header: 'co_tp_nomina', hidden: true,dataIndex: 'co_tp_nomina'},
            {header: 'co_cargo', hidden: true,dataIndex: 'co_cargo_estructura'},
            {header: 'co_tipo_pago', hidden: true,dataIndex: 'co_tipo_pago'},
            {header: 'Nomina_estructura', width:180, menuDisabled:true,dataIndex: 'tx_tp_nomina'},
            {header: 'Cargo', wtx_estructuraidth:200, menuDisabled:true,dataIndex: 'tx_cargo',renderer:textoLargo},
            {header: 'Horas', width:80, menuDisabled:true,dataIndex: 'nu_horas'},
            {header: 'Fecha Asigación', width:100, menuDisabled:true,dataIndex: 'fe_ingreso'},            
            {header: 'Sueldo',width:150, menuDisabled:true,dataIndex: 'mo_salario_base',renderer:renderMonto},
            {header: 'Tipo de Pago',width:100, menuDisabled:true,dataIndex: 'tx_tipo_pago'},
            {header: 'Estatus',width:100, menuDisabled:true,dataIndex: 'in_activo',renderer:renderEstatus}
        ],
        listeners:{
            cellclick:function(Grid, rowIndex, columnIndex,e ){
                TrabajadorEditar.main.editar.enable();
                TrabajadorEditar.main.rowIndex = rowIndex;
                //TrabajadorEditar.main.eliminar.enable();
            }
        },

});

this.cantidad_hijos = new Ext.form.TextField({
	fieldLabel:'Cantidad de Hijos',
	name:'tbrh001_trabajador[nu_hijos]',
	value:this.OBJ.nu_hijo,
	width:200,
        //maskRe: /[0-9]/,
	maxLength:20
        
});



this.fieldHijos = new Ext.form.FieldSet({
        title: 'Datos Cantidad de Hijos',
        items:[                 
                
                this.cantidad_hijos
              ]
});

this.agregar_familiar = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {

        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/agregarFamiliar',
            scripts: true,
            text: "Cargando..",
            params:{
                co_documento: TrabajadorEditar.main.OBJ.co_trabajador
            }
        });
    }
});

this.botonEliminarFamiliar = new Ext.Button({
                text:'Eliminar',
                iconCls: 'icon-eliminar',
                handler: function(){
                    TrabajadorEditar.main.eliminar();
                }
});

this.botonEliminarFamiliar.disable();

//Editar un registro
this.editar_familiar = new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.msg = Ext.get('formularioAgregar');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/agregarFamiliar',
         params:{
            co_familiar_trabajador:TrabajadorEditar.main.gridPanelFamiliar.getSelectionModel().getSelected().get('co_familiar_trabajador'),                                
            co_trabajador:TrabajadorEditar.main.gridPanelFamiliar.getSelectionModel().getSelected().get('co_trabajador'),
            co_sexo:TrabajadorEditar.main.gridPanelFamiliar.getSelectionModel().getSelected().get('co_sexo'),
            co_parentesco:TrabajadorEditar.main.gridPanelFamiliar.getSelectionModel().getSelected().get('co_parentesco'),            
            fe_nacimiento:TrabajadorEditar.main.gridPanelFamiliar.getSelectionModel().getSelected().get('fe_nacimiento'),
            nb_familiar:TrabajadorEditar.main.gridPanelFamiliar.getSelectionModel().getSelected().get('nb_familiar'),
            tx_identificacion:TrabajadorEditar.main.gridPanelFamiliar.getSelectionModel().getSelected().get('tx_identificacion'),
            rowIndex: TrabajadorEditar.main.rowIndex
         },
         scripts: true,
         text: "Cargando.."
        });
    }
});



this.store_lista.baseParams.co_trabajador = this.OBJ.co_trabajador;
this.store_lista.load();


this.editar_familiar.disable();

this.gridPanelFamiliar = new Ext.grid.GridPanel({
       // title:'Lista',
        iconCls: 'icon-libro',
        store: this.store_lista_familia,
        loadMask:true,
        height:500,  
        width:710,
        tbar:[this.agregar_familiar,'-',this.editar_familiar,'-',this.botonEliminarFamiliar],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_familar', hidden: true, dataIndex: 'co_familiar_trabajador'},
            {header: 'co_parentesco', hidden: true,dataIndex: 'co_parentesco'},
            {header: 'co_sexo', hidden: true,dataIndex: 'co_sexo'},
            {header: 'Fecha de Nacimiento', width:130, menuDisabled:true,dataIndex: 'fe_nacimiento'},
            {header: 'Identificacion',width:130, menuDisabled:true,dataIndex: 'tx_identificacion'},
            {header: 'Nombre y Apellido',width:180, menuDisabled:true,dataIndex: 'nb_familiar'},
            {header: 'Parentesco',width:100, menuDisabled:true,dataIndex: 'tx_parentesco'},
            {header: 'Sexo',width:100, menuDisabled:true,dataIndex: 'tx_sexo'},
        ],
        listeners:{
            cellclick:function(Grid, rowIndex, columnIndex,e ){
                TrabajadorEditar.main.editar_familiar.enable();
                
                if(TrabajadorEditar.main.gridPanelFamiliar.getSelectionModel().getSelected().get('co_familiar_trabajador')!='')
                  TrabajadorEditar.main.botonEliminarFamiliar.enable();
                else
                  TrabajadorEditar.main.botonEliminarFamiliar.disable();
                
                TrabajadorEditar.main.rowIndex = rowIndex;
            }
        },

});


this.store_lista_familia.baseParams.co_trabajador = this.OBJ.co_trabajador;
this.store_lista_familia.load();



this.agregar_profesion = new Ext.Button({
    text: 'Agregar',
    iconCls: 'icon-nuevo',
    handler: function () {

        this.msg = Ext.get('formularioAgregar');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/agregarProfesion',
            scripts: true,
            text: "Cargando..",
            params:{
                co_documento: TrabajadorEditar.main.OBJ.co_trabajador
            }
        });
    }
});

this.botonEliminarProfesion = new Ext.Button({
                text:'Eliminar',
                iconCls: 'icon-eliminar',
                handler: function(){
                    TrabajadorEditar.main.eliminarProfesion();
                }
});

this.botonEliminarProfesion.disable();

//Editar un registro
this.editar_profesion = new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.msg = Ext.get('formularioAgregar');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/agregarProfesion',
         params:{
            co_profesion_trabajador:TrabajadorEditar.main.gridPanelProfesion.getSelectionModel().getSelected().get('co_profesion_trabajador'),                                
            co_trabajador:TrabajadorEditar.main.gridPanelProfesion.getSelectionModel().getSelected().get('co_trabajador'),
            co_profesion:TrabajadorEditar.main.gridPanelProfesion.getSelectionModel().getSelected().get('co_profesion'),
            co_universidad:TrabajadorEditar.main.gridPanelProfesion.getSelectionModel().getSelected().get('co_universidad'),            
            fe_egreso:TrabajadorEditar.main.gridPanelProfesion.getSelectionModel().getSelected().get('fe_egreso'),
            tx_titulo_obtenido:TrabajadorEditar.main.gridPanelProfesion.getSelectionModel().getSelected().get('tx_titulo_obtenido'),
            rowIndex: TrabajadorEditar.main.rowIndex
         },
         scripts: true,
         text: "Cargando.."
        });
    }
});

this.editar_profesion.disable();


this.gridPanelProfesion = new Ext.grid.GridPanel({
       // title:'Lista',
        iconCls: 'icon-libro',
        store: this.store_lista_profesion,
        loadMask:true,
        height:500,  
        width:810,
        tbar:[this.agregar_profesion,'-',this.editar_profesion,'-',this.botonEliminarProfesion],
        columns: [
        new Ext.grid.RowNumberer(),
            {header: 'co_profesion_trabajador', hidden: true, dataIndex: 'co_familiar_trabajador'},
            {header: 'co_universidad', hidden: true,dataIndex: 'co_universidad'},
            {header: 'co_profesion', hidden: true,dataIndex: 'co_profesion'},
            {header: 'Universidad', width:220, menuDisabled:true,dataIndex: 'tx_universidad',renderer:textoLargo},
            {header: 'Profesión',width:220, menuDisabled:true,dataIndex: 'tx_profesion',renderer:textoLargo},
            {header: 'Titulo Obtenido',width:220, menuDisabled:true,dataIndex: 'tx_titulo_obtenido',renderer:textoLargo},
            {header: 'Fecha de Egreso',width:100, menuDisabled:true,dataIndex: 'fe_egreso'}
        ],
        listeners:{
            cellclick:function(Grid, rowIndex, columnIndex,e ){
                TrabajadorEditar.main.editar_profesion.enable();
                
                if(TrabajadorEditar.main.gridPanelProfesion.getSelectionModel().getSelected().get('co_profesion_trabajador')!='')
                  TrabajadorEditar.main.botonEliminarProfesion.enable();
                else
                  TrabajadorEditar.main.botonEliminarProfesion.disable();
                
                TrabajadorEditar.main.rowIndex = rowIndex;
            }
        },

});


this.store_lista_profesion.baseParams.co_trabajador = this.OBJ.co_trabajador;
this.store_lista_profesion.load();


this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){
        
        

        if(!TrabajadorEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        
        var list_sueldo = paqueteComunJS.funcion.getJsonByObjStore({
                store:TrabajadorEditar.main.gridPanel.getStore()
        });

        console.log(list_sueldo);
//        
        var list_familiar = paqueteComunJS.funcion.getJsonByObjStore({
                store:TrabajadorEditar.main.gridPanelFamiliar.getStore()
        });
        
        var list_profesion = paqueteComunJS.funcion.getJsonByObjStore({
                store:TrabajadorEditar.main.gridPanelProfesion.getStore()
        });
        
        TrabajadorEditar.main.hiddenJsonFamiliar.setValue(list_familiar);  
        TrabajadorEditar.main.hiddenJsonSueldo.setValue(list_sueldo);      
        TrabajadorEditar.main.hiddenJsonProfesion.setValue(list_profesion);         
        
        TrabajadorEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/guardar2',
            waitMsg: 'Enviando datos, por favor espere..',
            waitTitle:'Enviando',
            failure: function(form, action) {
                Ext.MessageBox.alert('Error en transacción', action.result.msg);
                TrabajadorLista.main.store_lista.load();
                 TrabajadorEditar.main.winformPanel_.close();
            },
            success: function(form, action) {
                console.log("paso aqui2");
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
                 TrabajadorLista.main.store_lista.load();
                 TrabajadorEditar.main.winformPanel_.close();
             }
             
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        TrabajadorEditar.main.winformPanel_.close();
    }
});

this.fieldDireccion = new Ext.form.FieldSet({
        title: 'Dirección Habitación',
        items:[                 
               /* this.co_estado,
                this.co_municipio,
                this.co_parroquia,*/
                this.tx_direccion_domicilio
              ]
});

this.fielDatos = new Ext.form.FieldSet({
        border:false,   
        items:[     
                this.hiddenJsonFamiliar,
                this.hiddenJsonProfesion,
                this.identificacion,
                this.nb_primer_nombre,
                this.nb_segundo_nombre,
                this.nb_primer_apellido,
                this.nb_segundo_apellido,
                this.co_edo_civil,
                this.nu_telefono_contacto
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
    html:'<img width=150 height=150 src = "'+TrabajadorEditar.main.OBJ.foto+'"> ',
    bodyStyle:'padding:5px;'
});

this.fielFoto = new Ext.form.FieldSet({
        border:false,   
        width:'300',
        height:'100%',
        labelWidth: 1,
        items:[                 
               this.panelImagen,
               {
                            xtype: 'fileuploadfield',
                            style:"padding-right:80px",
                            id: 'form-file',
                            emptyText: 'Imagen de Trabajador',
                            name: 'form-file',
                            buttonText: 'Buscar'            
               }
              ]
});


//Estatus//
//mio
if(this.OBJ.in_cestaticket == 'false'){
    this.cest = false;
}else if(this.OBJ.in_cestaticket == 'true'){
  this.cest = true;
}


this.cestaticket =  new Ext.form.ComboBox({
    fieldLabel:'Cestaticket',
    typeAhead: true,
    triggerAction: 'all',
    lazyRender:true,
    mode: 'local',
    value: this.cest,
    hiddenName:'tbrh001_trabajador[in_cestaticket]',
    store: new Ext.data.ArrayStore({
        id: 0,
        fields: [
            'in_cestaticket',
            'tx_cestaticket'
        ],
        data: [[true,'true'],[false,'false']]
    }),
    valueField: 'in_cestaticket',
    displayField: 'tx_cestaticket',
//    allowBlank:false,
    width:100
});
//fin mio
//mio
this.meses_reconocidos = new Ext.form.TextField({
	fieldLabel:'Meses Reconocidos',
	name:'tbrh001_trabajador[nu_mes_reconocido]',
	value:this.OBJ.nu_mes_reconocido,
	width:200,
    maskRe: /[0-9]/,
	maxLength:20
        
});
//fin mio

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

//this.fieldContacto = new Ext.form.FieldSet({
//        title: 'Datos Contacto',
//        items:[                 
//                this.nu_telefono_contacto,
//                this.nu_telefono_secundario,
//                this.tx_correo_electronico
//              ]
//});

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
               // this.co_profesion,
                this.fe_graduacion
              ]
});

this.fieldFeIngreso = new Ext.form.FieldSet({
        title: 'Fecha de Ingreso del Trabajador',
        items:[                 
                this.fe_ingreso     
              ]
});

this.fieldEstatus = new Ext.form.FieldSet({
    items:[ 
    this.meses_reconocidos
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
                        title: 'Datos Entrevista',
                        items:[this.fieldEntrevista,
                              // this.fieldContacto
                              ]
                },
                {
                        title: 'Profesión',
                        items:[this.gridPanelProfesion]
                },
                {
                        title: 'Cargo/Sueldo',
                        items:[this.fieldFeIngreso,
                               this.gridPanel]
                },
                {
                        title: 'Carga Familiar',
                        items:[this.fieldHijos,
                            this.gridPanelFamiliar]
                },
                {
                        title: 'Cuenta Bancaria',
                        items:[this.fieldBanco]
                },
                {
                        title: 'Micelánea',
                        items:[this.fieldMicelanea]
                },
                {
                        title: 'Estatus',
                        items:[this.fieldEstatus]
                }
        ]
});




this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1050,
    autoHeight:true,  
    autoScroll:true,
    fileUpload: true,
    bodyStyle:'padding:5px;',
    items:[
            this.co_trabajador,
            this.co_ingreso_trabajador,
            this.co_ficha,
            this.co_ingreso_de_trabajador,
            this.soli,
            this.co_nom_trabajador,
            this.hiddenJsonSueldo,
            this.co_solicitud,
            this.tabuladores
          ]
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        TrabajadorEditar.main.winformPanel_.close();
    }
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Editar Trabajador [NOVEDAD]',
    modal:true,
    constrain:true,
    width:1050,
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
TrabajadorLista.main.mascara.hide();
},
verificarTrabajador:function(){
    Ext.Ajax.request({
        method:'GET',
        url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Trabajador/verificarTrabajador',
        params:{
            co_documento: TrabajadorEditar.main.co_documento.getValue(),
            nu_cedula: TrabajadorEditar.main.nu_cedula.getValue()
        },
        success:function(result, request ) {
            obj = Ext.util.JSON.decode(result.responseText);
            if(obj.data){

//                TrabajadorEditar.main.co_trabajador.setValue(obj.data.co_trabajador);                       
//                TrabajadorEditar.main.nb_primer_nombre.setValue(obj.data.nb_primer_nombre);
//                TrabajadorEditar.main.nb_segundo_nombre.setValue(obj.data.nb_segundo_nombre);
//                TrabajadorEditar.main.nb_primer_apellido.setValue(obj.data.nb_primer_apellido);
//                TrabajadorEditar.main.nb_segundo_apellido.setValue(obj.data.nb_segundo_apellido);

                Ext.Msg.show({
                    title : 'ALERTA',
                    msg : 'El trabajador '+obj.data.nb_primer_nombre+' '+obj.data.nb_primer_apellido+' Cédula '+TrabajadorEditar.main.nu_cedula.getValue()+', ya se encuentra registrado en el sistema',
                    width : 400,
                    height : 800,
                    closable : false,
                    buttons : Ext.Msg.OK,
                    icon : Ext.Msg.INFO
                });

                TrabajadorEditar.main.co_documento.setValue('');
                TrabajadorEditar.main.nu_cedula.setValue('');

            }
        }
    });
},
eliminar:function(){
        var s = TrabajadorEditar.main.gridPanelFamiliar.getSelectionModel().getSelections();
        
        var co_familiar_trabajador = TrabajadorEditar.main.gridPanelFamiliar.getSelectionModel().getSelected().get('co_familiar_trabajador');
       
        if(co_familiar_trabajador!=''){
            
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/eliminarFamiliar',
            params:{
                co_familiar_trabajador: co_familiar_trabajador
            },
            success:function(result, request ) {
             
            }});
            
        }
        
        for(var i = 0, r; r = s[i]; i++){
                    TrabajadorEditar.main.store_lista_familia.remove(r);
        }
        
        TrabajadorEditar.main.botonEliminarFamiliar.disable();
        TrabajadorEditar.main.editar_familiar.disable();
        
       
       
        
},
eliminarProfesion:function(){
        var s = TrabajadorEditar.main.gridPanelProfesion.getSelectionModel().getSelections();
        
        var co_profesion_trabajador = TrabajadorEditar.main.gridPanelProfesion.getSelectionModel().getSelected().get('co_profesion_trabajador');
       
        if(co_profesion_trabajador!=''){
            
            Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/eliminarProfesion',
            params:{
                co_profesion_trabajador: co_profesion_trabajador
            },
            success:function(result, request ) {
             
            }});
            
        }
        
        for(var i = 0, r; r = s[i]; i++){
                    TrabajadorEditar.main.store_lista_profesion.remove(r);
        }
        
        TrabajadorEditar.main.botonEliminarProfesion.disable();
        TrabajadorEditar.main.editar_profesion.disable();
        
       
       
        
}
,getLista_profesion: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storelistaprofesion',
    root:'data',
    fields:[
                {name: 'co_profesion_trabajador'},
                {name: 'co_trabajador'},
                {name: 'co_profesion'},
                {name: 'fe_egreso'},
                {name: 'co_universidad'},
                {name: 'tx_profesion'},
                {name: 'tx_universidad'},
                {name: 'tx_titulo_obtenido'}
           ]
    });
    return this.store;      
},getStoreCO_GRUPO_NOMINA: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storelistafamiliar',
    root:'data',
    fields:[
                {name: 'co_grupo_nomina'},
                {name: 'tx_grupo_nomina'}
           ]
    });
    return this.store;  
}
,getLista_familiar: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storelistafamiliar',
    root:'data',
    fields:[
                {name: 'co_familiar_trabajador'},
                {name: 'co_parentesco'},
                {name: 'fe_nacimiento'},
                {name: 'tx_identificacion'},
                {name: 'nb_familiar'},
                {name: 'tx_parentesco'},
                {name: 'tx_sexo'},
                {name: 'co_sexo'},
                {name: 'co_trabajador'}
           ]
    });
    return this.store;      
}
,getLista: function(){

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
                {name: 'co_estructura_administrativa'},
                {name: 'co_ficha'},
                {name: 'co_estatus'},
                {name: 'in_cestaticket'}
           ]
    });
    return this.store;      
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
},getStoreCO_SITUACION(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/Storefksituacion',
        root:'data',
        fields:[
                {name: 'co_nom_situacion'},
                {name: 'tx_nom_situacion'}
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
}
};
Ext.onReady(TrabajadorEditar.main.init, TrabajadorEditar.main);
</script>
<div id="formularioAgregar"></div>