<script type="text/javascript">



Ext.ns("TrabajadorLista");
TrabajadorLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

this.co_solicitud = new Ext.form.Hidden({
    name:'co_solicitud',
    value:this.OBJ.co_solicitud
});

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        TrabajadorLista.main.mascara.show();
        this.msg = Ext.get('formularioTrabajador');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/editar',
         scripts: true,
         text: "Cargando..",
         params:{
             co_solicitud: TrabajadorLista.main.OBJ.co_solicitud
         }
        });
    }
});

//Editar un registro
//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
    this.codigo  = TrabajadorLista.main.gridPanel_.getSelectionModel().getSelected().get('co_ingreso_trabajador');
    TrabajadorLista.main.mascara.show();
        this.msg = Ext.get('formularioTrabajador');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/editar/codigo/'+this.codigo,
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
    this.codigo  = TrabajadorLista.main.gridPanel_.getSelectionModel().getSelected().get('co_trabajador');
    Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
    if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/eliminar',
            params:{
                co_ingreso_trabajador:TrabajadorLista.main.gridPanel_.getSelectionModel().getSelected().get('co_ingreso_trabajador')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
            TrabajadorLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                TrabajadorLista.main.mascara.hide();
            }});
    }});
    }
});

this.cargar= new Ext.Button({
    text:'Cargar',
    iconCls: 'icon-fin',
    handler:function(){
        
        if(!TrabajadorLista.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        TrabajadorLista.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/procesarNominaMasivo',
            waitMsg: 'Enviando datos, por favor espere..',
            waitTitle:'Enviando',
            failure: function(form, action) {
                Ext.MessageBox.alert('Error en transacción', action.result.msg);
                
//                PagoNominaEditar.main.nu_monto_nomina.setValue(action.result.monto);
//                PagoNominaEditar.main.nu_diferencia.setValue(action.result.diferencia);                
            },
            success: function(form, action) {
                 if(action.result.success){
                     Ext.MessageBox.show({
                         title: 'Mensaje Resultado',
                         msg: action.result.msg,
                         closable: false,
                         icon: Ext.MessageBox.INFO,
                         resizable: false,
                         animEl: document.body,
                         buttons: Ext.MessageBox.OK
                     });
                     
                
                    TrabajadorLista.main.store_lista.baseParams.co_solicitud = TrabajadorLista.main.OBJ.co_solicitud;
                    TrabajadorLista.main.store_lista.load();
                 }
                 
                
             }
        });

    }
});


//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroTrabajador');
        TrabajadorLista.main.mascara.show();
        TrabajadorLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/filtro',
             scripts: true
        });
    }
});

this.nuevo.enable();
this.editar.disable();
this.eliminar.disable();

this.fieldDocumento = new Ext.form.FieldSet({
	title: 'Archivo de Ingresos',
	items:[this.co_solicitud,{
                            xtype: 'fileuploadfield',
                            style:"padding-right:630px",
                            id: 'form-file',
                            emptyText: 'Seleccione un archivo',
                            fieldLabel: 'Archivo (xls)',
                            name: 'form-file',
                            buttonText: 'Buscar'
                    }]
});

this.formPanel_ = new Ext.form.FormPanel({
    fileUpload: true,
    frame:true,
    width:1000,
    autoHeight:true,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.fieldDocumento],
    buttons:[
        this.cargar
    ],
    buttonAlign:'center'
});

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Trabajador',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:450,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar
    ],
    columns: [
    new Ext.grid.RowNumberer(),
        {header: 'co_ingreso_trabajador',hidden:true, menuDisabled:true,dataIndex: 'co_ingreso_trabajador'},
        {header: 'co_trabajador',hidden:true, menuDisabled:true,dataIndex: 'co_trabajador'},
//        {header: 'Estatus', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_nomina'},
        {header: 'Cédula', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cedula'},
        {header: 'Nombre y Apellidos', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nb_primer_nombre'},
        {header: 'Banco', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'tx_banco'},
        {header: 'Cuenta', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cuenta_bancaria'},
        {header: 'Estado Civil', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_edo_civil'},
        {header: 'Fecha de Nacimiento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_nacimiento'},
        {header: 'Salario Base', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'mo_salario_base'},
        {header: 'Sexo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'co_sexo'},
        {header: 'Nactra', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_nactra'},
        {header: 'Nomina', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_grupo_nomina'},
        {header: 'Estructura', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_codigo_estructura'},
        {header: 'Fecha de Ingreso', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_ingreso'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,

    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){TrabajadorLista.main.editar.enable();TrabajadorLista.main.eliminar.enable();}}   
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        TrabajadorLista.main.winformPanel_.close();
    }
});

this.winformPanel_ = new Ext.Window({
    title:'Nomina',
    modal:true,
    constrain:true,
    width:1000,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formPanel_,
        this.gridPanel_
    ],
    buttons:[
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();

this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
this.store_lista.load();

},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storelista',
    root:'data',
    fields:[
                {name: 'co_ingreso_trabajador'},
                {name: 'co_trabajador'},
                {name: 'nu_cedula'},
                {name: 'nb_primer_nombre'},
                {name: 'nb_segundo_nombre'},
                {name: 'nb_primer_apellido'},
                {name: 'nb_segundo_apellido'},
                {name: 'co_documento'},
                {name: 'co_ente'},
                {name: 'co_edo_civil'},
                {name: 'fe_nacimiento'},
                {name: 'co_tp_motricida'},
                {name: 'nu_hijo'},
                {name: 'tx_direccion_domicilio'},
                {name: 'co_parroquia_domicilio'},
                {name: 'tx_ciudad_domicilio'},
                {name: 'tx_ciudad_nacimiento'},
                {name: 'co_parroquia_nacimiento'},
                {name: 'co_nacionalidad'},
                {name: 'nu_seguro_social'},
                {name: 'nu_rif'},
                {name: 'created_at'},
                {name: 'updated_at'},
                {name: 'co_nivel_educativo'},
                {name: 'nu_anio_aprobado_educativo'},
                {name: 'co_profesion'},
                {name: 'fe_graduacion'},
                {name: 'tx_correo_electronico'},
                {name: 'co_solicitud'},
                {name: 'in_nomina'},
                {name: 'tx_banco'},
                {name: 'mo_salario_base'},
                {name: 'co_sexo'},
                {name: 'tx_nactra'},
                {name: 'tx_grupo_nomina'},
                {name: 'nu_codigo_estructura'},
                {name: 'fe_ingreso'},
                {name: 'nu_cuenta_bancaria'}
           ]
    });

    return this.store;
}
};
Ext.onReady(TrabajadorLista.main.init, TrabajadorLista.main);
</script>
<div id="contenedorTrabajadorLista"></div>
<div id="formularioTrabajador"></div>
<div id="filtroTrabajador"></div>
