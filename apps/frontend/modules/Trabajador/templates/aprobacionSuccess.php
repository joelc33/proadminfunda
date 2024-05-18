<script type="text/javascript">
Ext.ns("AprobacionLista");
AprobacionLista.main = {
   
        co_ficha_trabajador:     [],  
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

this.hiddenJsonFichaTrabajador  = new Ext.form.Hidden({
        name:'json_co_ficha_trabajador',
        value:''
});

this.co_solicitud = new Ext.form.Hidden({
	name:'co_solicitud',
	value:this.OBJ.co_solicitud
});

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
                      record.push(sm.selections.items[i].data.co_ficha); 
                  }
              }
              AprobacionLista.main.co_ficha_trabajador = [];
              AprobacionLista.main.co_ficha_trabajador.push(record);
              console.log(record);
          }


       }
});

//objeto store
this.store_lista = this.getLista();

//Grid principal
this.gridPanel = new Ext.grid.GridPanel({
    title:'Lista de Ingreso',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    columns: [
        new Ext.grid.RowNumberer(),
        myCboxSelModel,      
        {header: 'co_egreso',hidden:true, menuDisabled:true,dataIndex: 'co_egreso'},
        {header: 'co_ficha',hidden:true, menuDisabled:true,dataIndex: 'co_ficha'},
        {header: 'Estatus', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'in_procesado'},
        {header: 'Cédula', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_cedula'},
        {header: 'Nombre y Apellido', width:400,  menuDisabled:true, sortable: true,  dataIndex: 'nb_primer_nombre'},
        {header: 'Fecha Ingreso', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_ingreso'},
//        {header: 'Nomina', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_tp_nomina'},
//        {header: 'Tipo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'tx_grupo_nomina'},
//        {header: 'Cargo', width:300,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cargo'},
        
    ],
    sm: myCboxSelModel,
    stripeRows: true,
    autoScroll:true,
    stateful: true
});


this.guardar = new Ext.Button({
    text:'Procesar',
    iconCls: 'icon-guardar',
    handler:function(){
              
            AprobacionLista.main.hiddenJsonFichaTrabajador.setValue( AprobacionLista.main.co_ficha_trabajador);

            AprobacionLista.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/guardarAprobacion',
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
                 
                 AprobacionLista.main.store_lista.baseParams.co_solicitud = AprobacionLista.main.OBJ.co_solicitud;
                 AprobacionLista.main.store_lista.load();
             }
        });

   
    }
});

this.formPanel_ = new Ext.form.FormPanel({
   // frame:true,
    width:1300,
    autoHeight:true,  
    autoScroll:true,
   // fileUpload: true,
  //  bodyStyle:'padding:5px;',
    items:[ this.hiddenJsonFichaTrabajador,
            this.co_solicitud,
            this.gridPanel]
});

this.winformPanel_ = new Ext.Window({
    title:'Agregar Trabajador',
    modal:true,
    constrain:true,
    width:1300,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
       this.formPanel_
    ],
    buttons:[
        this.guardar
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();

this.store_lista.baseParams.co_solicitud = this.OBJ.co_solicitud;
this.store_lista.load();

},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Trabajador/storelistaaprobacion',
    root:'data',
    fields:[
                {name: 'co_trabajador'},
                {name: 'co_ingreso_trabajador'},
                {name: 'co_ficha'},
                {name: 'nu_cedula'},
                {name: 'nb_primer_nombre'},
                {name: 'nb_segundo_nombre'},
                {name: 'nb_primer_apellido'},
                {name: 'nb_segundo_apellido'},
                {name: 'co_documento'},
                {name: 'fe_ingreso'},
                {name: 'tx_cargo'},
                {name: 'in_procesado'}
           ]
    });
    return this.store;
}
};
Ext.onReady(AprobacionLista.main.init, AprobacionLista.main);
</script>
<div id="contenedorAprobacionLista"></div>
<div id="formularioTrabajador"></div>
<div id="filtroTrabajador"></div>
