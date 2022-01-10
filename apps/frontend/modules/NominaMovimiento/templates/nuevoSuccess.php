<script type="text/javascript">
Ext.ns("NominaMovimientoEditarConcepto");
NominaMovimientoEditarConcepto.main = {

arreglo_concepto: [],

init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//<ClavePrimaria>
this.id_tbrh013_nomina = new Ext.form.Hidden({
    name:'id_tbrh013_nomina',
    value:this.OBJ.id_tbrh013_nomina
});
//</ClavePrimaria>

this.id_tbrh002_ficha = new Ext.form.Hidden({
    name:'id_tbrh002_ficha',
    value:this.OBJ.id_tbrh002_ficha
});

this.id_tbrh015_nom_trabajador = new Ext.form.Hidden({
    name:'id_tbrh015_nom_trabajador',
    value:this.OBJ.id_tbrh015_nom_trabajador
});

this.hiddenJsonConcepto = new Ext.form.Hidden({
        name:'json_concepto',
        value:''
});

var myCboxSelModel = new Ext.grid.CheckboxSelectionModel({
    // override private method to allow toggling of selection on or off for multiple rows.
    handleMouseDown : function(g, rowIndex, e){
        var view = this.grid.getView();
        var isSelected = this.isSelected(rowIndex);
        if(isSelected) {  
            this.deselectRow(rowIndex);
        }else if(!isSelected || this.getCount() > 1) {
            this.selectRow(rowIndex, true);
            view.focusRow(rowIndex);
        }else{
            this.deselectRow(rowIndex);
        }
    },
    singleSelect: false,
    listeners: {
        selectionchange: function(sm, rowIndex, rec) {

        var length = sm.selections.length, record = [];
        if(length>0){
            
            for(var i = 0; i<length;i++){

                //record.push( { id: sm.selections.items[i].data.id, nu_valor: sm.selections.items[i].data.nu_valor } );
                record.push( {id: sm.selections.items[i].data.id, nu_valor: sm.selections.items[i].data.nu_valor });
            
            }
            
        }
            delete NominaMovimientoEditarConcepto.main.arreglo_concepto.splice(0,NominaMovimientoEditarConcepto.main.arreglo_concepto.length);
            NominaMovimientoEditarConcepto.main.arreglo_concepto.push(JSON.stringify(record));
            console.log(record);
            //alert(record);
                
        }
    }
});

//Grid principal
this.gridPanel_ = new Ext.grid.EditorGridPanel({
    store: this.store_lista,
    sm: myCboxSelModel,
    loadMask:true,
    border:false,
    height:440,
    columns: [
    new Ext.grid.RowNumberer(),
    myCboxSelModel,
    {header: 'id',hidden:true, menuDisabled:true,dataIndex: 'id'},
    {header: 'Tipo de Concepto', width:130,  menuDisabled:true, sortable: true,  dataIndex: 'id_tbrh020_tp_concepto'},
    {header: 'Cod. Concepto', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_concepto'},
    {header: 'Descripción', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'de_concepto'},
    {header: 'Unidad', width:130,  menuDisabled:true, sortable: true,  dataIndex: 'id_tbrh050_tp_unidad'},
    {header: 'Referencia', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'nu_valor', 
        editor: new Ext.form.NumberField({
            allowBlank: false,
            allowNegative: false,
            style: 'text-align:left'
        })
    },
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    bbar: new Ext.PagingToolbar({
        pageSize: 200,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.guardar = new Ext.Button({
    text:'Procesar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!NominaMovimientoEditarConcepto.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }

        NominaMovimientoEditarConcepto.main.hiddenJsonConcepto.setValue(NominaMovimientoEditarConcepto.main.arreglo_concepto);

        NominaMovimientoEditarConcepto.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/guardarNuevo',
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
                 NominaMovimientoEditar.main.store_lista_imprimible.load();
				 NominaMovimientoEditar.main.store_lista_no_imprimible.load();
                 NominaMovimientoEditarConcepto.main.winformPanel_.close();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        NominaMovimientoEditarConcepto.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:false,
    border:false,
    width:900,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:0px;',
    items:[

                    this.id_tbrh013_nomina,
                    this.id_tbrh002_ficha,
                    this.id_tbrh015_nom_trabajador,
                    this.gridPanel_,
                    this.hiddenJsonConcepto
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Concepto (Doble click para editar la columna de referencia, luego presionar la columna de check para agregar el Concepto!)',
    modal:true,
    constrain:true,
    width:914,
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
NominaMovimientoEditar.main.mascara.hide();

NominaMovimientoEditarConcepto.main.store_lista.baseParams.id_tbrh013_nomina = NominaMovimientoEditarConcepto.main.OBJ.id_tbrh013_nomina;
NominaMovimientoEditarConcepto.main.store_lista.baseParams.id_tbrh002_ficha = NominaMovimientoEditarConcepto.main.OBJ.id_tbrh002_ficha;
NominaMovimientoEditarConcepto.main.store_lista.baseParams.id_tbrh015_nom_trabajador = NominaMovimientoEditarConcepto.main.OBJ.id_tbrh015_nom_trabajador;

this.store_lista.load({
    params:{
        id_tbrh013_nomina: NominaMovimientoEditarConcepto.main.OBJ.id_tbrh013_nomina,
        id_tbrh002_ficha: NominaMovimientoEditarConcepto.main.OBJ.id_tbrh002_ficha,
        id_tbrh015_nom_trabajador: NominaMovimientoEditarConcepto.main.OBJ.id_tbrh015_nom_trabajador
    }
});
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/storelistaAgregar',
    root:'data',
    fields:[
    {name: 'id', type: 'number'},
    {name: 'id_tbrh013_nomina', type: 'string'},
    {name: 'id_tbrh014_concepto', type: 'string'},
    {name: 'id_tbrh020_tp_concepto', type: 'string'},
    {name: 'id_tbrh002_ficha', type: 'number'},
    {name: 'id_tbrh015_nom_trabajador', type: 'number'},
    {name: 'de_concepto', type: 'string'},
    {name: 'nu_valor', type: 'number'},
    {name: 'nu_monto', type: 'number'},
    {name: 'id_tbrh050_tp_unidad', type: 'string'},
    {name: 'nu_concepto', type: 'string'},
           ]
    });
    return this.store;
}
};
Ext.onReady(NominaMovimientoEditarConcepto.main.init, NominaMovimientoEditarConcepto.main);
</script>
