<script type="text/javascript">
Ext.ns("TrabajadorEgresoEditar");

  
TrabajadorEgresoEditar.main = {
        co_nom_trabajador:     [],  
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.rowIndex;
this.storeCO_DOCUMENTO = this.getStoreCO_DOCUMENTO();
//this.storeCO_DOCUMENTO_ENTREVISTADOR = this.getStoreCO_DOCUMENTO();
this.storeCO_SEXO      = this.getStoreCO_SEXO();
this.storeCO_EDO_CIVIL = this.getStoreCO_EDO_CIVIL();

this.storeCO_NOM_SITUACION = this.getStoreCO_NOM_SITUACION();
this.storeCO_NOMINA = this.getStoreCO_NOMINA();
this.storeCO_CARGO  = this.getStoreCO_CARGO();
this.store_lista    = this.getLista();

this.hiddenJsonNomTrabajador  = new Ext.form.Hidden({
        name:'json_co_nom_trabajador',
        value:''
});

//<ClavePrimaria>
this.co_trabajador = new Ext.form.Hidden({
    name:'egreso[co_trabajador]',
    value:this.OBJ.co_trabajador
});

this.co_egreso = new Ext.form.Hidden({
    name:'egreso[co_egreso]',
    value:this.OBJ.co_egreso
});


this.co_solicitud = new Ext.form.Hidden({
	name:'egreso[co_solicitud]',
	value:this.OBJ.co_solicitud
});


this.nu_cedula = new Ext.form.NumberField({
	fieldLabel:'Nu cedula',
	name:'egreso[nu_cedula]',
	value:this.OBJ.nu_cedula,
        width:145,
	allowBlank:false
});

this.nb_primer_nombre = new Ext.form.TextField({
	fieldLabel:'Primer Nombre',
	name:'egreso[nb_primer_nombre]',
	value:this.OBJ.nb_primer_nombre,
        readOnly:true,
        style:'background:#c9c9c9;',
	width:200
});

this.nb_segundo_nombre = new Ext.form.TextField({
	fieldLabel:'Segundo Nombre',
	name:'egreso[nb_segundo_nombre]',
	value:this.OBJ.nb_segundo_nombre,
        readOnly:true,
        style:'background:#c9c9c9;',
	width:200
});

this.nb_primer_apellido = new Ext.form.TextField({
	fieldLabel:'Primer Apellido',
	name:'egreso[nb_primer_apellido]',
	value:this.OBJ.nb_primer_apellido,
        readOnly:true,
        style:'background:#c9c9c9;',
	width:200
});

this.nb_segundo_apellido = new Ext.form.TextField({
	fieldLabel:'Segundo Apellido',
	name:'egreso[nb_segundo_apellido]',
	value:this.OBJ.nb_segundo_apellido,
        readOnly:true,
        style:'background:#c9c9c9;',
	width:200
});


this.co_documento = new Ext.form.ComboBox({
	fieldLabel:'Co documento',
	store: this.storeCO_DOCUMENTO,
	typeAhead: true,
	valueField: 'co_documento',
	displayField:'inicial',
	hiddenName:'egreso[co_documento]',
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
        TrabajadorEgresoEditar.main.co_documento.setValue(TrabajadorEgresoEditar.main.OBJ.co_documento);
    }
});

this.nu_cedula = new Ext.form.NumberField({
	fieldLabel:'Nu cedula',
	name:'egreso[nu_cedula]',
	value:this.OBJ.nu_cedula,
        width:145,
	allowBlank:false
});

this.co_documento.on("blur",function(){
    if(TrabajadorEgresoEditar.main.tx_nu_cedula.getValue()!=''){
        TrabajadorEgresoEditar.main.verificarTrabajador();
    }
});

this.nu_cedula.on("blur",function(){
        TrabajadorEgresoEditar.main.verificarTrabajador();
});

//alert(TrabajadorEgresoEditar.main.OBJ.co_edo_civil);
this.storeCO_EDO_CIVIL.load({
    callback: function(){
        TrabajadorEgresoEditar.main.co_edo_civil.setValue(TrabajadorEgresoEditar.main.OBJ.co_edo_civil);
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



this.fielDatos = new Ext.form.FieldSet({
        border:false,   
        items:[     
                this.identificacion,
                this.nb_primer_nombre,
                this.nb_segundo_nombre,
                this.nb_primer_apellido,
                this.nb_segundo_apellido
              ]
});


this.panelImagen = new Ext.Panel({    
    border:true,
    id:'myId',
    html:'<img width=150 height=150 src = "'+TrabajadorEgresoEditar.main.OBJ.foto+'"> ',
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


this.fe_egreso = new Ext.form.DateField({
	fieldLabel:'Fecha Egreso',
	name:'egreso[fe_egreso]',
	value:this.OBJ.fe_egreso,
	width:100,
	allowBlank:false
});

this.fe_movimiento = new Ext.form.DateField({
	fieldLabel:'Fecha Movimiento',
	name:'egreso[fe_movimiento]',
	value:this.OBJ.fe_movimiento,
	width:100,
	allowBlank:false
});

this.tx_motivo = new Ext.form.TextField({
	fieldLabel:'Observación',
	name:'egreso[tx_motivo]',
	value:this.OBJ.tx_motivo,
	width:500,
	allowBlank:false
});

this.co_tp_nomina = new Ext.form.ComboBox({
	fieldLabel:'Nomina',
	store: this.storeCO_NOMINA,
	typeAhead: true,
	valueField: 'co_tp_nomina',
	displayField:'tx_tp_nomina',
	hiddenName:'egreso[co_tp_nomina]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:250,
	listeners:{
            select: function(){
                TrabajadorEgresoEditar.main.storeCO_CARGO.load({
                    params: {co_tp_nomina:this.getValue(),
                             co_trabajador: TrabajadorEgresoEditar.main.co_trabajador.getValue()},
                    callback: function(){
                        TrabajadorEgresoEditar.main.co_tp_cargo.setValue("");
                    }
                })
            }
        },
	allowBlank:false
});

if(this.OBJ.co_tp_nomina!=''){
    TrabajadorEgresoEditar.main.storeCO_NOMINA.baseParams.co_trabajador = this.OBJ.co_trabajador;
    TrabajadorEgresoEditar.main.storeCO_NOMINA.baseParams.co_tp_nomina = this.OBJ.co_tp_nomina;
    TrabajadorEgresoEditar.main.storeCO_NOMINA.load({
        callback:function(){
            TrabajadorEgresoEditar.main.co_tp_nomina.setValue(TrabajadorEgresoEditar.main.OBJ.co_tp_nomina);
        }
    });
}

this.co_tp_cargo = new Ext.form.ComboBox({
	fieldLabel:'Cargo',
	store: this.storeCO_CARGO,
	typeAhead: true,
	valueField: 'co_cargo',
	displayField:'tx_cargo',
	hiddenName:'egreso[co_cargo]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:250,
	allowBlank:false
});

this.co_nom_situacion = new Ext.form.ComboBox({
	fieldLabel:'Situación',
	store: this.storeCO_NOM_SITUACION,
	typeAhead: true,
	valueField: 'co_nom_situacion',
	displayField:'tx_nom_situacion',
	hiddenName:'egreso[co_nom_situacion]',
	forceSelection:true,
	resizable:true,
	triggerAction: 'all',
	selectOnFocus: true,
	mode: 'local',
	width:300,
	allowBlank:false
});

this.storeCO_NOM_SITUACION.load();

if(this.OBJ.co_cargo!=''){
    TrabajadorEgresoEditar.main.storeCO_CARGO.load({
        params: {co_tp_nomina:  TrabajadorEgresoEditar.main.OBJ.co_tp_nomina,
                 co_trabajador: TrabajadorEgresoEditar.main.co_trabajador.getValue()},
        callback: function(){
            TrabajadorEgresoEditar.main.co_tp_cargo.setValue(TrabajadorEgresoEditar.main.OBJ.co_cargo);
        }
    });
}

function renderMonto(val, attr, record) { 
     return paqueteComunJS.funcion.getNumeroFormateado(val);     
} 

function renderEstatus(val, attr, record) { 
     if(val == true)
        return 'Activo';   
     else
        return 'Inactivo';
     
} 

var myCboxSelModel = new Ext.grid.CheckboxSelectionModel({
  // override private method to allow toggling of selection on or off for multiple rows.
        handleMouseDown : function(g, rowIndex, e){
                var view = this.gridPanel.getView();
                var isSelected = this.isSelected(rowIndex);
                if(isSelected) {  
                  this.deselectRow(rowIndex);
                } 
                else if(!isSelected || this.getCount() > 1) {
                  this.selectRow(rowIndex, true);
                  view.focusRow(rowIndex);
                }else{
                    this.deselectRow(rowIndex);
                }
        },
        singleSelect: false,
        listeners: {
              selectionchange: function(sm, rowIndex, rec) {
              var length = sm.selections.length
              , record = [];
              if(length>0){           
                 for(var i = 0; i<length;i++){
                      record.push(sm.selections.items[i].data.co_nom_trabajador); 
                  }
              }
              TrabajadorEgresoEditar.main.co_nom_trabajador = [];
              TrabajadorEgresoEditar.main.co_nom_trabajador.push(record);
              console.log(record);
          }


       }
});

 

this.gridPanel = new Ext.grid.GridPanel({
        title:'Cargos',
        iconCls: 'icon-libro',
        store: this.store_lista,
        loadMask:true,
        height:150,  
        width:9010,
        border:true,
        columns: [
            myCboxSelModel,
            {header: 'co_estructura_administrativa', hidden: true, dataIndex: 'co_estructura_administrativa'},
            {header: 'tx_estructura', hidden: true, dataIndex: 'tx_estructura'},
            {header: 'co_nom_trabajador', hidden: true, dataIndex: 'co_nom_trabajador'},
            {header: 'co_tp_nomina', hidden: true,dataIndex: 'co_tp_nomina'},
            {header: 'co_cargo', hidden: true,dataIndex: 'co_cargo_estructura'},
            {header: 'co_tipo_pago', hidden: true,dataIndex: 'co_tipo_pago'},
            {header: 'Tipo', width:80, menuDisabled:true,dataIndex: 'tx_grupo_nomina'},
            {header: 'Nomina', width:160, menuDisabled:true,dataIndex: 'tx_tp_nomina'},
            {header: 'Cargo', wtx_estructuraidth:200, menuDisabled:true,dataIndex: 'tx_cargo',renderer:textoLargo},
            {header: 'Horas', width:80, menuDisabled:true,dataIndex: 'nu_horas'},
            {header: 'Fecha Asigación', width:100, menuDisabled:true,dataIndex: 'fe_ingreso'},            
            {header: 'Sueldo',width:100, menuDisabled:true,dataIndex: 'mo_salario_base',renderer:renderMonto},
            {header: 'Tipo de Pago',width:100, menuDisabled:true,dataIndex: 'tx_tipo_pago'},
            {header: 'Estatus',width:100, menuDisabled:true,dataIndex: 'in_activo',renderer:renderEstatus}
        ],
        sm: myCboxSelModel,
        listeners:{
            cellclick:function(Grid, rowIndex, columnIndex,e ){
//                TrabajadorEditar.main.editar.enable();
//                TrabajadorEditar.main.rowIndex = rowIndex;
                //TrabajadorEditar.main.eliminar.enable();
            }
        },

});

if(this.OBJ.co_trabajador!=''){
    this.store_lista.baseParams.co_trabajador = this.OBJ.co_trabajador;
    this.store_lista.load();
}

this.fieldCargo = new Ext.form.FieldSet({
        title: 'Cargos Asociados',    
        labelWidth: 120,
        items:[ 
               this.gridPanel
              ]
});

this.fieldEgreso = new Ext.form.FieldSet({
        title: 'Datos del Egreso',    
        labelWidth: 120,
        items:[ 
               this.co_nom_situacion,
               this.fe_egreso,
               this.fe_movimiento,
               this.tx_motivo
              ]
});

this.in_soporte = new Ext.form.Checkbox({
	fieldLabel:'Soporte motivo egreso',
	name:'egreso[in_soporte]',
	checked:this.OBJ.in_soporte
});

this.in_cedula = new Ext.form.Checkbox({
	fieldLabel:'Copia de Cédula',
	name:'egreso[in_cedula]',
	checked:this.OBJ.in_cedula
});

this.in_declaracion = new Ext.form.Checkbox({
	fieldLabel:'Declaración Jurada de la Contraloría General de la República',
	name:'egreso[in_declaracion]',
	checked:this.OBJ.in_declaracion
});

this.fieldDeclaracion = new Ext.form.FieldSet({
        title: 'Requisitos',    
        labelWidth: 420,
        items:[                 
                this.in_soporte,
                this.in_cedula,
                this.in_declaracion
              ]
});

this.tabuladores = new Ext.Panel({
        title: 'Trabajador',
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
           this.fieldTrabajador,
           this.fieldCargo,
           this.fieldEgreso,
           this.fieldDeclaracion
        ]
});




this.formPanel_ = new Ext.form.FormPanel({
   // frame:true,
    width:850,
    autoHeight:true,  
    autoScroll:true,
   // fileUpload: true,
  //  bodyStyle:'padding:5px;',
    items:[ this.hiddenJsonNomTrabajador,
            this.co_egreso,
            this.co_trabajador,
            this.co_solicitud,
            this.tabuladores
          ]
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        TrabajadorEgresoEditar.main.winformPanel_.close();
    }
});


this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!TrabajadorEgresoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        
        TrabajadorEgresoEditar.main.hiddenJsonNomTrabajador.setValue( TrabajadorEgresoEditar.main.co_nom_trabajador);
               
        TrabajadorEgresoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Egreso/guardar',
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
                 
                 EgresoLista.main.store_lista.baseParams.co_solicitud = action.result.co_solicitud;
                 EgresoLista.main.store_lista.load();
                 TrabajadorEgresoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Trabajador',
    modal:true,
    constrain:true,
    width:850,
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
EgresoLista.main.mascara.hide();

},
verificarTrabajador:function(){
            Ext.Ajax.request({
                method:'GET',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/Egreso/verificarTrabajador',
                params:{
                    co_documento: TrabajadorEgresoEditar.main.co_documento.getValue(),
                    nu_cedula: TrabajadorEgresoEditar.main.nu_cedula.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        TrabajadorEgresoEditar.main.co_trabajador.setValue("");                       
                        TrabajadorEgresoEditar.main.nb_primer_nombre.setValue("");
                        TrabajadorEgresoEditar.main.nb_segundo_nombre.setValue("");
			TrabajadorEgresoEditar.main.nb_primer_apellido.setValue("");
                        TrabajadorEgresoEditar.main.nb_segundo_apellido.setValue("");

                            Ext.Msg.show({
                            title : 'ALERTA',
                            msg : 'El trabajador no se encuentra registrado o esta inactivo',
                            width : 400,
                            height : 800,
                            closable : false,
                            buttons : Ext.Msg.OK,
                            icon : Ext.Msg.INFO
                        });

                    }else{

                        TrabajadorEgresoEditar.main.co_trabajador.setValue(obj.data.co_trabajador);                       
                        TrabajadorEgresoEditar.main.nb_primer_nombre.setValue(obj.data.nb_primer_nombre);
                        TrabajadorEgresoEditar.main.nb_segundo_nombre.setValue(obj.data.nb_segundo_nombre);
			TrabajadorEgresoEditar.main.nb_primer_apellido.setValue(obj.data.nb_primer_apellido);
                        TrabajadorEgresoEditar.main.nb_segundo_apellido.setValue(obj.data.nb_segundo_apellido);
                        Ext.get('myId').update('<img src="'+obj.data.foto+'" width="150" height="150">'); 
                        
                        TrabajadorEgresoEditar.main.storeCO_NOMINA.baseParams.co_trabajador = obj.data.co_trabajador;
                        TrabajadorEgresoEditar.main.storeCO_NOMINA.load();
                        
                        TrabajadorEgresoEditar.main.store_lista.baseParams.co_trabajador = obj.data.co_trabajador;
                        TrabajadorEgresoEditar.main.store_lista.load();
                        
                    }
                }
 });
},getLista: function(){

    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storelistaSueldo',
    root:'data',
    fields:[
                {name: 'co_nom_trabajador'},
                {name: 'co_tp_nomina'},
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
                {name: 'co_grupo_nomina'},
                {name: 'tx_grupo_nomina'},
                {name: 'tx_estructura'},
                {name: 'co_estructura_administrativa'}
           ]
    });
    return this.store;      
},getStoreCO_NOM_SITUACION: function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Egreso/storefkconomsituacion',
        root:'data',
        fields:[
                    {name: 'co_nom_situacion'},
                    {name: 'tx_nom_situacion'}
               ]
    });
    return this.store;
},
getStoreCO_CARGO: function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Egreso/storefkcocargo',
        root:'data',
        fields:[
                    {name: 'co_cargo'},
                    {name: 'tx_cargo'}
               ]
    });
    return this.store;
},
getStoreCO_NOMINA: function(){
    this.store = new Ext.data.JsonStore({
        url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Egreso/storefkconomina',
        root:'data',
        fields:[
                    {name: 'co_tp_nomina'},
                    {name: 'tx_tp_nomina'}
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
Ext.onReady(TrabajadorEgresoEditar.main.init, TrabajadorEgresoEditar.main);
</script>
<div id="formularioAgregar"></div>