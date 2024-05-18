<script type="text/javascript">
Ext.ns("SobregiroLista");
SobregiroLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
arreglo_sobregiro: [],
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        SobregiroLista.main.mascara.show();
        this.msg = Ext.get('formularioNominaPeriodo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/editar',
         scripts: true,
         text: "Cargando..",
         params:{
            co_solicitud:SobregiroLista.main.OBJ.co_solicitud
            }
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Detalles',
    iconCls: 'icon-calculator_error',
    handler:function(){
	SobregiroLista.main.mascara.show();
        this.msg = Ext.get('formularioNominaPeriodo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/detalleSobregiro',
         scripts: true,
         text: "Cargando..",
         params:{
            id_tbrh013_nomina:SobregiroLista.main.gridPanel_.getSelectionModel().getSelected().get('id_tbrh013_nomina'),
            id_tbrh002_ficha:SobregiroLista.main.gridPanel_.getSelectionModel().getSelected().get('id_tbrh002_ficha'),
            id_tbrh015_nom_trabajador:SobregiroLista.main.gridPanel_.getSelectionModel().getSelected().get('id_tbrh015_nom_trabajador')
         },
        });
    }
});

//Eliminar un registro
this.eliminar= new Ext.Button({
    text:'Eliminar',
    iconCls: 'icon-eliminar',
    handler:function(){
	this.codigo  = SobregiroLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nomina');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaPeriodo/eliminar',
            params:{
                co_nomina:SobregiroLista.main.gridPanel_.getSelectionModel().getSelected().get('co_nomina')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    SobregiroLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                SobregiroLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroNominaPeriodo');
        SobregiroLista.main.mascara.show();
        SobregiroLista.main.filtro.setDisabled(true);
        this.msg.load({
            url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/filtroSobregiro',
            scripts: true,
            text: "Cargando..",
            params:{
                id_tbrh013_nomina:SobregiroLista.main.OBJ.id_tbrh013_nomina
            }
        });
    }
});

//Editar un registro
this.sobregiro= new Ext.Button({
    text:'Sobregiros',
    iconCls: 'icon-reporteest',
    handler:function(){
	SobregiroLista.main.mascara.show();
        this.msg = Ext.get('formularioNominaPeriodo');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/sobregiroLista',
         scripts: true,
         text: "Cargando..",
         params:{
            id_tbrh013_nomina:SobregiroLista.main.OBJ.id_tbrh013_nomina
         },
        });
    }
});

this.editar.disable();
this.eliminar.disable();

function formatoNroColor(val){
	return "<span style='color:red;'>"+paqueteComunJS.funcion.getNumeroFormateado(val)+'</span>';
}

this.hiddenJsonSobregiro = new Ext.form.Hidden({
        name:'json_sobregiro',
        value:''
});

//Editar un registro
this.recalcular = new Ext.Button({
    text:'Calcular Conceptos',
    iconCls: 'icon-calculator_link',
    handler:function(){

        SobregiroLista.main.hiddenJsonSobregiro.setValue(SobregiroLista.main.arreglo_sobregiro);

        Ext.MessageBox.confirm('Confirmación', '¿Realmente desea Calcular los Conceptos?', function(boton){
            if(boton=="yes"){
                Ext.Ajax.request({
                    method:'POST',
                    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/recalcularConcepto',
                    params:{
                        arreglo:SobregiroLista.main.hiddenJsonSobregiro.getValue()
                    },
                    success:function(result, request ) {
                        obj = Ext.util.JSON.decode(result.responseText);
                        if(obj.success==true){
                            SobregiroLista.main.store_lista.load();
                            NominaMovimientoLista.main.store_lista.load();
                            Ext.Msg.alert("Notificación",obj.msg);
                        }else{
                            Ext.Msg.alert("Notificación",obj.msg);
                        }
                        SobregiroLista.main.mascara.hide();
                    }});
            }
        });

    }
});

this.recalcular.disable();

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

            SobregiroLista.main.recalcular.enable();

        var length = sm.selections.length, record = [];
        if(length>0){
            
            for(var i = 0; i<length;i++){

                //record.push( { id: sm.selections.items[i].data.id, nu_valor: sm.selections.items[i].data.nu_valor } );
                record.push({
                    id_tbrh013_nomina: sm.selections.items[i].data.id_tbrh013_nomina,
                    id_tbrh002_ficha: sm.selections.items[i].data.id_tbrh002_ficha,
                    id_tbrh015_nom_trabajador: sm.selections.items[i].data.id_tbrh015_nom_trabajador 
                });
            
            }
            
        }
            delete SobregiroLista.main.arreglo_sobregiro.splice(0,SobregiroLista.main.arreglo_sobregiro.length);
            SobregiroLista.main.arreglo_sobregiro.push(JSON.stringify(record));
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
    height:520,
    tbar:[
        this.recalcular,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    myCboxSelModel,
    {header: 'id_tbrh013_nomina',hidden:true, menuDisabled:true,dataIndex: 'id_tbrh013_nomina'},
    {header: 'id_tbrh002_ficha',hidden:true, menuDisabled:true,dataIndex: 'id_tbrh002_ficha'},
    {header: 'id_tbrh015_nom_trabajador',hidden:true, menuDisabled:true,dataIndex: 'id_tbrh015_nom_trabajador'},
    {header: 'N° Documento', width:120,  menuDisabled:true, sortable: true,  dataIndex: 'documento'},
    {header: 'Nombre y Apellido', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'nombre'},
    {header: 'Cargo', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_cargo'},
    {header: 'N° Contrato', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'nu_ficha'},
    {header: 'Estatus', width:200,  menuDisabled:true, sortable: true,  dataIndex: 'tx_nom_situacion'},
    //{header: 'Monto', width:180,  menuDisabled:true, sortable: true, renderer: formatoNroColor, dataIndex: 'mo_pago'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{
        cellclick:function(Grid, rowIndex, columnIndex,e ){
            SobregiroLista.main.editar.enable();
            SobregiroLista.main.eliminar.enable();
        }
    },
    bbar: new Ext.PagingToolbar({
        pageSize: 200,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

//this.gridPanel_.render("contenedorSobregiroLista");

this.winformPanel_ = new Ext.Window({
    title:'Sobregiros de Nomina',
    modal:true,
    constrain:true,
width:1024,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.gridPanel_
    ]
});
this.winformPanel_.show();
SobregiroLista.main.mascara.hide();

this.store_lista.baseParams.co_nomina=SobregiroLista.main.OBJ.id_tbrh013_nomina;
this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/NominaMovimiento/storelistaEmpleadoSinCalculo',
    root:'data',
    fields:[
    {name: 'id_tbrh013_nomina'},
    {name: 'id_tbrh002_ficha'},
    {name: 'id_tbrh015_nom_trabajador'},
    {name: 'nu_ficha'},
    {name: 'nu_cedula'},
    {name: 'inicial'},
    {
        name: 'documento',
        convert: function(v, r) {
                return r.inicial + ' - ' + r.nu_cedula;
        }
    },
    {name: 'nombre'},
    {name: 'nu_ficha'},
    {name: 'mo_pago'},
    {name: 'tx_cargo'},
    {name: 'tx_nom_situacion'},
    ]
    });
    return this.store;
}
};
Ext.onReady(SobregiroLista.main.init, SobregiroLista.main);
</script>
<div id="contenedorSobregiroLista"></div>
<div id="formularioNominaPeriodo"></div>
<div id="filtroNominaPeriodo"></div>
