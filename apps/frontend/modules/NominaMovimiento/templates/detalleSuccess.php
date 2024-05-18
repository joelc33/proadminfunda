<script type="text/javascript">
Ext.ns("NominaMovimientoEditar");
NominaMovimientoEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista_imprimible = this.getLista_imprimible();
//objeto store
this.store_lista_no_imprimible = this.getLista_no_imprimible();

//<ClavePrimaria>
this.id = new Ext.form.Hidden({
    name:'id',
    value:this.OBJ.id});
//</ClavePrimaria>


this.id_tbrh013_nomina = new Ext.form.Hidden({
	name:'tbrh061_nomina_movimiento[id_tbrh013_nomina]',
	value:this.OBJ.id_tbrh013_nomina
});

this.id_tbrh002_ficha = new Ext.form.Hidden({
	name:'tbrh061_nomina_movimiento[id_tbrh002_ficha]',
	value:this.OBJ.id_tbrh002_ficha
});

this.id_tbrh015_nom_trabajador = new Ext.form.Hidden({
	name:'tbrh061_nomina_movimiento[id_tbrh015_nom_trabajador]',
	value:this.OBJ.id_tbrh015_nom_trabajador
});

this.nu_documento = new Ext.form.TextField({
	fieldLabel:'N° Documento',
	name:'tbrh001_trabajador[nu_documento]',
	value:this.OBJ.nu_documento,
	allowBlank:false,
	width:300,
    readOnly:true,
	style:'background:#c9c9c9;'
});

this.nb_trabajador = new Ext.form.TextField({
	fieldLabel:'Nombre y Apellido',
	name:'tbrh001_trabajador[nb_primer_nombre]',
	value:this.OBJ.nb_trabajador,
	allowBlank:false,
	width:300,
    readOnly:true,
	style:'background:#c9c9c9;'
});

this.de_cargo = new Ext.form.TextField({
	fieldLabel:'Cargo',
	name:'tbrh001_trabajador[de_cargo]',
	value:this.OBJ.tx_cargo,
	allowBlank:false,
	width:300,
    readOnly:true,
	style:'background:#c9c9c9;'
});

this.fe_ingreso = new Ext.form.TextField({
	fieldLabel:'Fecha Ingreso',
	name:'tbrh001_trabajador[fe_ingreso]',
	value:this.OBJ.fe_ingreso,
	allowBlank:false,
	width:300,
    readOnly:true,
	style:'background:#c9c9c9;'
});

this.nu_sueldo = new Ext.form.TextField({
	fieldLabel:'Sueldo',
	name:'tbrh001_trabajador[nu_sueldo]',
	value:this.OBJ.mo_salario_base,
	allowBlank:false,
	width:300,
    readOnly:true,
	style:'background:#c9c9c9;'
});

this.de_estatus = new Ext.form.TextField({
	fieldLabel:'Estatus',
	name:'tbrh001_trabajador[de_estatus]',
	value:this.OBJ.tx_nom_situacion,
	allowBlank:false,
	width:300,
    readOnly:true,
	style:'background:#c9c9c9;'
});

this.fielDatos = new Ext.form.FieldSet({
    labelWidth: 160,
        border:false, 
        frame:false,  
        items:[                 
				this.id_tbrh013_nomina,
                this.id_tbrh002_ficha,
                this.id_tbrh015_nom_trabajador,
                this.nu_documento,
				this.nb_trabajador,
                this.de_cargo,
                this.fe_ingreso,
                this.nu_sueldo,
                this.de_estatus
              ]
});

this.panelImagen = new Ext.Panel({    
    border:true,
    html:'<img width=150 height=150 src = "'+NominaMovimientoEditar.main.OBJ.foto+'"> ',
    bodyStyle:'padding:5px;'
});

this.fielFoto = new Ext.form.FieldSet({
        border:false,   
        width:'100',
        height:'100',
        labelWidth: 1,
        items:[                 
               this.panelImagen
              ]
});

this.CompositeDatos = new Ext.form.CompositeField({  
    frame:false,
        items: [
            this.fielDatos,
            this.fielFoto
	]
});

this.fieldTrabajador = new Ext.form.FieldSet({
        title: 'Datos del Trabajador',    
        //labelWidth: 1,
        items:[                 
                this.CompositeDatos
              ]
});

this.agregar_imprimible = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-calculator_add',
    handler:function(){
        this.msg = Ext.get('formularioNominaMovimiento');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/nuevo',
            scripts: true,
            params:{
                id_tbrh013_nomina: NominaMovimientoEditar.main.id_tbrh013_nomina.getValue(),
                id_tbrh002_ficha: NominaMovimientoEditar.main.id_tbrh002_ficha.getValue(),
                id_tbrh015_nom_trabajador: NominaMovimientoEditar.main.id_tbrh015_nom_trabajador.getValue()
            }
        });
    }
});

this.editar_imprimible = new Ext.Button({
    text:'Editar',
    iconCls: 'icon-calculator_edit',
    handler:function(){
	this.codigo  = NominaMovimientoEditar.main.gridPanel_imprimible.getSelectionModel().getSelected().get('id');
	NominaMovimientoEditar.main.mascara.show();
        this.msg = Ext.get('formularioNominaMovimiento');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/editar/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

this.borrar_imprimible = new Ext.Button({
    text:'Borrar',
    iconCls: 'icon-calculator_delete',
    handler:function(){
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este concepto?', function(boton){
	if(boton=="yes"){

        this.codigo = NominaMovimientoEditar.main.gridPanel_imprimible.getSelectionModel().getSelected().get('id');

        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/eliminar',
            params:{
                id: this.codigo
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
                    NominaMovimientoEditar.main.store_lista_imprimible.load();
                    NominaMovimientoEditar.main.store_lista_no_imprimible.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                NominaMovimientoEditar.main.mascara.hide();
            }});
	}});
    }
});

this.editar_imprimible.disable();
this.borrar_imprimible.disable();

//Grid principal
this.gridPanel_imprimible = new Ext.grid.GridPanel({
    store: this.store_lista_imprimible,
    loadMask:true,
    border:false,
    height:270,
    tbar:[
        this.agregar_imprimible,'-',this.editar_imprimible,'-',this.borrar_imprimible
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Concepto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_concepto'},
    {header: 'Descripción', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'de_concepto'},
    {header: 'Referencia', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_valor'},
    {header: 'Monto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_monto'},
    {header: 'Unidad', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tbrh050_tp_unidad'},
    {header: 'Tipo', width:140,  menuDisabled:true, sortable: true,  dataIndex: 'id_tbrh020_tp_concepto'},
    ],
    listeners:{
        cellclick:function(Grid, rowIndex, columnIndex,e ){
            NominaMovimientoEditar.main.editar_imprimible.enable();
            NominaMovimientoEditar.main.borrar_imprimible.enable();
        }
    },
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista_imprimible,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.agregar_no_imprimible = new Ext.Button({
    text:'Agregar',
    iconCls: 'icon-calculator_add',
    handler:function(){
        this.msg = Ext.get('formularioNominaMovimiento');
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/nuevo',
            scripts: true,
            params:{
                id_tbrh013_nomina: NominaMovimientoEditar.main.id_tbrh013_nomina.getValue(),
                id_tbrh002_ficha: NominaMovimientoEditar.main.id_tbrh002_ficha.getValue()
            }
        });
    }
});

this.editar_no_imprimible = new Ext.Button({
    text:'Editar',
    iconCls: 'icon-calculator_edit',
    handler:function(){
	this.codigo  = NominaMovimientoEditar.main.gridPanel_no_imprimible.getSelectionModel().getSelected().get('id');
	NominaMovimientoEditar.main.mascara.show();
        this.msg = Ext.get('formularioNominaMovimiento');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/editar/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

this.borrar_no_imprimible = new Ext.Button({
    text:'Borrar',
    iconCls: 'icon-calculator_delete',
    handler:function(){
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este concepto?', function(boton){
	if(boton=="yes"){

        this.codigo = NominaMovimientoEditar.main.gridPanel_no_imprimible.getSelectionModel().getSelected().get('id');

        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/eliminar',
            params:{
                id: this.codigo
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
                    NominaMovimientoEditar.main.store_lista_imprimible.load();
                    NominaMovimientoEditar.main.store_lista_no_imprimible.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                NominaMovimientoEditar.main.mascara.hide();
            }});
	}});
    }
});

this.editar_no_imprimible.disable();
this.borrar_no_imprimible.disable();

//Grid principal
this.gridPanel_no_imprimible = new Ext.grid.GridPanel({
    store: this.store_lista_no_imprimible,
    loadMask:true,
    border:false,
    height:270,
    tbar:[
        this.agregar_no_imprimible,'-',this.editar_no_imprimible,'-',this.borrar_no_imprimible
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Concepto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_concepto'},
    {header: 'Descripción', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'de_concepto'},
    {header: 'Referencia', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_valor'},
    {header: 'Monto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_monto'},
    {header: 'Unidad', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'id_tbrh050_tp_unidad'},
    {header: 'Tipo', width:140,  menuDisabled:true, sortable: true,  dataIndex: 'id_tbrh020_tp_concepto'},
    ],
    listeners:{
        cellclick:function(Grid, rowIndex, columnIndex,e ){
            NominaMovimientoEditar.main.editar_no_imprimible.enable();
            NominaMovimientoEditar.main.borrar_no_imprimible.enable();
        }
    },
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista_no_imprimible,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.panel_concepto = new Ext.TabPanel({
    activeTab:0,
    border:true,
    enableTabScroll:true,
    deferredRender: true,
	autoWidth:true,
	height:300,
    items:[
		{
			title: 'Conceptos Imprimibles',
            autoScroll:true,
            border:false,
			items:[
                this.gridPanel_imprimible
            ]
		},
		{
			title: 'Conceptos no Imprimibles',
            autoScroll:true,
            border:false,
			items:[
                this.gridPanel_no_imprimible
            ]
		}
	]
});

this.mo_asignacion = new Ext.form.DisplayField({
 value:"<span style='color:blue;font-size:18px;text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;'><b>Asignaciones: </b>"+paqueteComunJS.funcion.getNumeroFormateado(0)+"</b></span>"
});

this.mo_deduccion = new Ext.form.DisplayField({
 value:"<span style='color:red;font-size:18px;text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;'><b>Deducciones: </b>"+paqueteComunJS.funcion.getNumeroFormateado(0)+"</b></span>"
});

this.mo_neto = new Ext.form.DisplayField({
 value:"<span style='color:black;font-size:18px;text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;'><b>Neto: </b>"+paqueteComunJS.funcion.getNumeroFormateado(0)+"</b></span>"
});

this.bbar_monto = new Ext.ux.StatusBar({
  autoScroll:true,
  defaults:{
    style:'color:black;font-size:30px;',
    autoWidth:true
  },
  items:[
    this.mo_asignacion,'|',
    this.mo_deduccion,'|',
    this.mo_neto
  ]
});

this.generar = new Ext.Button({
    text:'Generar',
    iconCls: 'icon-tiposol',
    handler:function(){

        Ext.MessageBox.confirm('Confirmación', '¿Realmente desea generar los conceptos?<br><b>Nota:</b> Generara nuevamente los montos de calculo.', function(boton){
            if(boton=="yes"){
                
                Ext.Ajax.request({
                    method:'POST',
                    url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/NominaMovimiento/procesarCalculo',
                    params:{
                        id_tbrh013_nomina: NominaMovimientoEditar.main.id_tbrh013_nomina.getValue(),
                        id_tbrh002_ficha: NominaMovimientoEditar.main.id_tbrh002_ficha.getValue(),
                        id_tbrh015_nom_trabajador: NominaMovimientoEditar.main.id_tbrh015_nom_trabajador.getValue()
                    },
                    success:function(result, request ) {

                        obj = Ext.util.JSON.decode(result.responseText);

                        Ext.MessageBox.show({
                            title: 'Mensaje',
                            msg: obj.msg,
                            closable: false,
                            icon: Ext.MessageBox.INFO,
                            resizable: false,
                            animEl: document.body,
                            buttons: Ext.MessageBox.OK
                        });

                        NominaMovimientoEditar.main.store_lista_imprimible.load();
                        NominaMovimientoEditar.main.store_lista_no_imprimible.load();
                    }
                });

            }
        })

    }
});

this.recibo = new Ext.Button({
    text:'Recibo de Pago',
    iconCls: 'icon-pdf',
    handler:function(){

    }
});

this.panelDatos2 = new Ext.Panel({
    autoHeight:true,
    border:false,
    bodyStyle:'padding:0px;',
	tbar:[
        this.generar,'-',this.recibo
    ],
    items:[
		this.panel_concepto
	]
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!NominaMovimientoEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        NominaMovimientoEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/guardar',
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
                 NominaMovimientoLista.main.store_lista.load();
                 NominaMovimientoEditar.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        NominaMovimientoEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:false,
    border:false,
    width:900,
	labelWidth: 10,
	autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:5px;',
    items:[
                    this.id,
                    this.fieldTrabajador,
                    this.panelDatos2
            ],
    tbar: this.bbar_monto
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Movimientos del Trabajador',
    modal:true,
    constrain:true,
width:914,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formPanel_
    ],
    /*buttons:[
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'*/
});
this.winformPanel_.show();
NominaMovimientoLista.main.mascara.hide();

NominaMovimientoEditar.main.store_lista_imprimible.baseParams.id_tbrh013_nomina = NominaMovimientoEditar.main.OBJ.id_tbrh013_nomina;
NominaMovimientoEditar.main.store_lista_imprimible.baseParams.id_tbrh002_ficha = NominaMovimientoEditar.main.OBJ.id_tbrh002_ficha;
NominaMovimientoEditar.main.store_lista_imprimible.baseParams.id_tbrh015_nom_trabajador = NominaMovimientoEditar.main.OBJ.id_tbrh015_nom_trabajador;

this.store_lista_imprimible.load({
    params:{
        id_tbrh013_nomina: NominaMovimientoEditar.main.OBJ.id_tbrh013_nomina,
        id_tbrh002_ficha: NominaMovimientoEditar.main.OBJ.id_tbrh002_ficha,
        id_tbrh015_nom_trabajador: NominaMovimientoEditar.main.OBJ.id_tbrh015_nom_trabajador
    }
});

this.store_lista_imprimible.on('load',function(){
    NominaMovimientoEditar.main.editar_imprimible.disable();
    NominaMovimientoEditar.main.borrar_imprimible.disable();
    NominaMovimientoEditar.main.getCalcular();
});

NominaMovimientoEditar.main.store_lista_no_imprimible.baseParams.id_tbrh013_nomina = NominaMovimientoEditar.main.OBJ.id_tbrh013_nomina;
NominaMovimientoEditar.main.store_lista_no_imprimible.baseParams.id_tbrh002_ficha = NominaMovimientoEditar.main.OBJ.id_tbrh002_ficha;
NominaMovimientoEditar.main.store_lista_no_imprimible.baseParams.id_tbrh015_nom_trabajador = NominaMovimientoEditar.main.OBJ.id_tbrh015_nom_trabajador;

this.store_lista_no_imprimible.load({
    params:{
        id_tbrh013_nomina: NominaMovimientoEditar.main.OBJ.id_tbrh013_nomina,
        id_tbrh002_ficha: NominaMovimientoEditar.main.OBJ.id_tbrh002_ficha,
        id_tbrh015_nom_trabajador: NominaMovimientoEditar.main.OBJ.id_tbrh015_nom_trabajador
    }
});

this.store_lista_no_imprimible.on('load',function(){
    NominaMovimientoEditar.main.editar_no_imprimible.disable();
    NominaMovimientoEditar.main.borrar_no_imprimible.disable();
    NominaMovimientoEditar.main.getCalcular();
});

},
getLista_imprimible: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/storelistaImprimible',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'id_tbrh013_nomina'},
    {name: 'id_tbrh014_concepto'},
    {name: 'id_tbrh020_tp_concepto'},
    {name: 'id_tbrh002_ficha'},
    {name: 'de_concepto'},
    {name: 'nu_valor'},
    {name: 'nu_monto'},
    {name: 'id_tbrh050_tp_unidad'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'in_imprime_detalle'},
    {name: 'in_descripcion_alternativa'},
    {name: 'in_valor_referencia'},
    {name: 'in_hoja_tiempo'},
    {name: 'in_prorratea'},
    {name: 'in_modifica_descripcion'},
    {name: 'in_monto_calculo'},
    {name: 'in_contractual'},
    {name: 'in_bonificable'},
    {name: 'in_monto_cero'},
    {name: 'id_tbrh030_moneda'},
    {name: 'nu_concepto'},
           ]
    });
    return this.store;
},
getLista_no_imprimible: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/storelistaNoImprimible',
    root:'data',
    fields:[
    {name: 'id'},
    {name: 'id_tbrh013_nomina'},
    {name: 'id_tbrh014_concepto'},
    {name: 'id_tbrh020_tp_concepto'},
    {name: 'id_tbrh002_ficha'},
    {name: 'de_concepto'},
    {name: 'nu_valor'},
    {name: 'nu_monto'},
    {name: 'id_tbrh050_tp_unidad'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'in_imprime_detalle'},
    {name: 'in_descripcion_alternativa'},
    {name: 'in_valor_referencia'},
    {name: 'in_hoja_tiempo'},
    {name: 'in_prorratea'},
    {name: 'in_modifica_descripcion'},
    {name: 'in_monto_calculo'},
    {name: 'in_contractual'},
    {name: 'in_bonificable'},
    {name: 'in_monto_cero'},
    {name: 'id_tbrh030_moneda'},
    {name: 'nu_concepto'},
           ]
    });
    return this.store;
},
getCalcular:function(){

    Ext.Ajax.request({
                method:'POST',
                url:'<?php echo $_SERVER["SCRIPT_NAME"]?>/NominaMovimiento/neto',
                params:{
                    id_tbrh013_nomina: NominaMovimientoEditar.main.id_tbrh013_nomina.getValue(),
                    id_tbrh002_ficha: NominaMovimientoEditar.main.id_tbrh002_ficha.getValue(),
                    id_tbrh015_nom_trabajador: NominaMovimientoEditar.main.id_tbrh015_nom_trabajador.getValue()
                },
                success:function(result, request ) {
                    obj = Ext.util.JSON.decode(result.responseText);
                    if(!obj.data){
                        
                        NominaMovimientoEditar.main.mo_asignacion.setValue("<span style='color:blue;font-size:18px;text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;'><b>Asignaciones: </b>"+paqueteComunJS.funcion.getNumeroFormateado(0)+"</b></span>");
                        NominaMovimientoEditar.main.mo_deduccion.setValue("<span style='color:red;font-size:18px;text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;'><b>Deducciones: </b>"+paqueteComunJS.funcion.getNumeroFormateado(0)+"</b></span>");
                        NominaMovimientoEditar.main.mo_neto.setValue("<span style='color:black;font-size:18px;text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;'><b>Neto: </b>"+paqueteComunJS.funcion.getNumeroFormateado(0)+"</b></span>");

                    }else{

                        NominaMovimientoEditar.main.mo_asignacion.setValue("<span style='color:blue;font-size:18px;text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;'><b>Asignaciones: </b>"+paqueteComunJS.funcion.getNumeroFormateado(obj.data.mo_asignacion)+"</b></span>");
                        NominaMovimientoEditar.main.mo_deduccion.setValue("<span style='color:red;font-size:18px;text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;'><b>Deducciones: </b>"+paqueteComunJS.funcion.getNumeroFormateado(obj.data.mo_deduccion)+"</b></span>");
                        NominaMovimientoEditar.main.mo_neto.setValue("<span style='color:black;font-size:18px;text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;'><b>Neto: </b>"+paqueteComunJS.funcion.getNumeroFormateado(obj.data.mo_neto)+"</b></span>");
                     
                    }
                }
        });

}
};
Ext.onReady(NominaMovimientoEditar.main.init, NominaMovimientoEditar.main);
</script>
<div id="formularioNominaMovimiento"></div>