<script type="text/javascript">
Ext.ns("NominaPeriodoLista");
NominaPeriodoLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
arreglo_nomina: [],
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Editar un registro
this.editar= new Ext.Button({
    text:'Calcular',
    iconCls: 'icon-calculator_new',
    handler:function(){
	this.codigo  = NominaPeriodoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nomina');
	NominaPeriodoLista.main.mascara.show();
        this.msg = Ext.get('formularioNominaPeriodo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/calculo/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.resumen_tipo= new Ext.Button({
    text:'Resumen por Tipo',
    iconCls: 'icon-reporteest',
    handler:function(){
	this.codigo  = NominaPeriodoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nomina');
	NominaPeriodoLista.main.mascara.show();
        this.msg = Ext.get('formularioNominaPeriodo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/resumenTipo/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

this.resumen_concepto= new Ext.Button({
    text:'Resumen por Concepto',
    iconCls: 'icon-reporteest',
    handler:function(){
	this.codigo  = NominaPeriodoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nomina');
	NominaPeriodoLista.main.mascara.show();
        this.msg = Ext.get('formularioNominaPeriodo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/resumenConcepto/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

this.movimientos= new Ext.Button({
    text:'Calculo de Trabajadores',
    iconCls: 'icon-reporteest',
    handler:function(){
	this.codigo  = NominaPeriodoLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nomina');
	NominaPeriodoLista.main.mascara.show();
        this.msg = Ext.get('formularioNominaPeriodo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/empleadoMovimiento/codigo/'+this.codigo,
         scripts: true,
         text: "Cargando.."
        });
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroNominaPeriodo');
        NominaPeriodoLista.main.mascara.show();
        NominaPeriodoLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/filtro',
             scripts: true
        });
    }
});

//Editar un registro
this.cerrar= new Ext.Button({
    text:'Cerrar Nomina',
    iconCls: 'icon-cerrar',
    handler:function(){

        NominaPeriodoLista.main.hiddenJsonNomina.setValue(NominaPeriodoLista.main.arreglo_nomina);

        Ext.MessageBox.confirm('Confirmación', '¿Realmente desea cerrar las nominas?', function(boton){
            if(boton=="yes"){
                Ext.Ajax.request({
                    method:'POST',
                    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/cerrar',
                    params:{
                        arreglo:NominaPeriodoLista.main.hiddenJsonNomina.getValue()
                    },
                    success:function(result, request ) {
                        obj = Ext.util.JSON.decode(result.responseText);
                        if(obj.success==true){
                            NominaPeriodoLista.main.store_lista.load();
                            Ext.Msg.alert("Notificación",obj.msg);
                        }else{
                            Ext.Msg.alert("Notificación",obj.msg);
                        }
                        NominaPeriodoLista.main.mascara.hide();
                    }});
            }
        });

    }
});

//Editar un registro
this.abrir= new Ext.Button({
    text:'Abrir Nomina',
    iconCls: 'icon-abrir',
    handler:function(){

        NominaPeriodoLista.main.hiddenJsonNomina.setValue(NominaPeriodoLista.main.arreglo_nomina);

        Ext.MessageBox.confirm('Confirmación', '¿Realmente desea abrir las nominas?', function(boton){
            if(boton=="yes"){
                Ext.Ajax.request({
                    method:'POST',
                    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/abrir',
                    params:{
                        arreglo:NominaPeriodoLista.main.hiddenJsonNomina.getValue()
                    },
                    success:function(result, request ) {
                        obj = Ext.util.JSON.decode(result.responseText);
                        if(obj.success==true){
                            NominaPeriodoLista.main.store_lista.load();
                            Ext.Msg.alert("Notificación",obj.msg);
                        }else{
                            Ext.Msg.alert("Notificación",obj.msg);
                        }
                        NominaPeriodoLista.main.mascara.hide();
                    }});
            }
        });

    }
});

this.abrir.disable();
this.cerrar.disable();
this.editar.disable();

this.hiddenJsonNomina = new Ext.form.Hidden({
        name:'json_nomina',
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

            NominaPeriodoLista.main.abrir.enable();
            NominaPeriodoLista.main.cerrar.enable();

        var length = sm.selections.length, record = [];
        if(length>0){
            
            for(var i = 0; i<length;i++){

                //record.push( { id: sm.selections.items[i].data.id, nu_valor: sm.selections.items[i].data.nu_valor } );
                record.push( {co_nomina: sm.selections.items[i].data.co_nomina });
            
            }
            
        }
            delete NominaPeriodoLista.main.arreglo_nomina.splice(0,NominaPeriodoLista.main.arreglo_nomina.length);
            NominaPeriodoLista.main.arreglo_nomina.push(JSON.stringify(record));
            console.log(record);
            //alert(record);
                
        }
    }
});

//Grid principal
//this.gridPanel_ = new Ext.grid.GridPanel({
this.gridPanel_ = new Ext.grid.EditorGridPanel({
    //title:'Lista de NominaPeriodo',
    //iconCls: 'icon-libro',
    sm: myCboxSelModel,
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:450,
    tbar:[
        this.filtro,'-',this.resumen_tipo,'-',this.resumen_concepto,'-',this.movimientos,'-',this.cerrar,'-',this.abrir
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    myCboxSelModel,
    {header: 'co_nomina',hidden:true, menuDisabled:true,dataIndex: 'co_nomina'},
    {header: 'Nomina', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nomina'},
    {header: 'Sub-Grupo', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'cod_grupo_nomina'},
    {header: 'Frecuencia de Pago', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'co_nom_frecuencia_pago'},
    {header: 'N°', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_nomina'},
    {header: 'Inicio', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_inicio'},
    {header: 'Cierre', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_fin'},
    {header: 'Fecha de Pago', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_pago'},
    {header: 'Estatus', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'id_tbrh060_nomina_estatus'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{
        cellclick:function(Grid, rowIndex, columnIndex,e ){
            //NominaPeriodoLista.main.cerrar.enable();
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

//this.gridPanel_.render("contenedorNominaPeriodoLista");

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Nomina Periodo',
    modal:true,
    constrain:true,
    width:1114,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ]
});
this.winformPanel_.show();

this.store_lista.baseParams.co_solicitud=NominaPeriodoLista.main.OBJ.co_solicitud;
this.store_lista.load();
this.store_lista.on('load',function(){
    NominaPeriodoLista.main.abrir.disable();
    NominaPeriodoLista.main.cerrar.disable();
});
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/storelista',
    root:'data',
    fields:[
    {name: 'co_nomina'},
    {name: 'co_solicitud'},
    {name: 'co_tp_nomina'},
    {name: 'co_nom_frecuencia_pago'},
    {name: 'nu_nomina'},
    {name: 'de_nomina'},
    {name: 'de_observacion'},
    {name: 'fe_inicio'},
    {name: 'fe_fin'},
    {name: 'fe_pago'},
    {name: 'in_activo'},
    {name: 'created_at'},
    {name: 'updated_at'},
    {name: 'in_procesado'},
    {name: 'id_tbrh060_nomina_estatus'},
    {name: 'cod_grupo_nomina'},
    {
        name: 'nomina',
        convert: function(v, r) {
                return r.cod_nomina + ' - ' + r.co_tp_nomina;
        }
    }
           ]
    });
    return this.store;
}
};
Ext.onReady(NominaPeriodoLista.main.init, NominaPeriodoLista.main);
</script>
<div id="contenedorNominaPeriodoLista"></div>
<div id="formularioNominaPeriodo"></div>
<div id="filtroNominaPeriodo"></div>
