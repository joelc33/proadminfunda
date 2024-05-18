<script type="text/javascript">
Ext.ns("BeneficiarioLista");
BeneficiarioLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
//Mascara general del modulo
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

//objeto store
this.store_lista = this.getLista();

//Agregar un registro
this.nuevo = new Ext.Button({
    text:'Nuevo',
    iconCls: 'icon-nuevo',
    handler:function(){
        BeneficiarioLista.main.mascara.show();
        this.msg = Ext.get('formularioBeneficiario');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empleado/editarBeneficiario',
         params:{
             cedula_titular:'<?php echo $cedula; ?>'
         },
         scripts: true,
         text: "Cargando.."
        });
    }
});

//Editar un registro
this.editar= new Ext.Button({
    text:'Editar',
    iconCls: 'icon-editar',
    handler:function(){
	this.codigo  = BeneficiarioLista.main.gridPanel_.getSelectionModel().getSelected().get('cedula');
	BeneficiarioLista.main.mascara.show();
        this.msg = Ext.get('formularioBeneficiario');
        this.msg.load({
         url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empleado/editarBeneficiario',
         params:{
             cedula_titular:'<?php echo $cedula; ?>',
             cedula: BeneficiarioLista.main.gridPanel_.getSelectionModel().getSelected().get('cedula')
         },
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
	this.codigo  = BeneficiarioLista.main.gridPanel_.getSelectionModel().getSelected().get('co_empleado');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empleado/eliminar',
            params:{
                co_empleado:BeneficiarioLista.main.gridPanel_.getSelectionModel().getSelected().get('co_empleado')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    BeneficiarioLista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                BeneficiarioLista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtroBeneficiario');
        BeneficiarioLista.main.mascara.show();
        BeneficiarioLista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empleado/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de Beneficiario',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    width:1150,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
    {header: 'co_empleado',hidden:true, menuDisabled:true,dataIndex: 'co_empleado'},
    {header: 'Cédula', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'cedula'},
    {header: 'Nombre Apellido', width:350,  menuDisabled:true, sortable: true,  dataIndex: 'nombre_apellido'},
    {header: 'Parentesco', width:150,  menuDisabled:true, sortable: true,  dataIndex: 'parentesco'},
    {header: 'Fecha Nacimiento', width:100,  menuDisabled:true, sortable: true,  dataIndex: 'fe_nacimiento'},
    {header: 'Sexo', width:50,  menuDisabled:true, sortable: true,  dataIndex: 'sexo'},
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){
               
        BeneficiarioLista.main.editar.enable();
        BeneficiarioLista.main.eliminar.enable();
    
    }},    
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

//this.gridPanel_.render("contenedorBeneficiarioLista");

this.store_lista.baseParams.cedula_titular = '<?php echo $cedula; ?>';
this.store_lista.load();

this.salir = new Ext.Button({
    text:'Salir',
//    iconCls: 'icon-cancelar',
    handler:function(){
        BeneficiarioLista.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    frame:true,
    width:1170,
    autoHeight:true,  
    autoScroll:true,
    items:[this.gridPanel_]
});

this.winformPanel_ = new Ext.Window({
    title:'Beneficiario',
    modal:true,
    constrain:true,
    width:1170,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.formPanel_
    ],
    buttons:[
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();


},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Empleado/storelistaBeneficiario',
    root:'data',
    fields:[
    {name: 'co_empleado'},
    {name: 'cedula_titular'},
    {name: 'nombre_apellido'},
    {name: 'nacionalidad'},
    {name: 'parentesco'},
    {name: 'cedula'},
    {name: 'fe_nacimiento'},
    {name: 'sexo'},
    {name: 'tipo_empleado'},
    {name: 'organismo'},
           ]
    });
    return this.store;
}
};
Ext.onReady(BeneficiarioLista.main.init, BeneficiarioLista.main);
</script>
<div id="contenedorBeneficiarioLista"></div>
<div id="formularioBeneficiario"></div>
<div id="filtroBeneficiario"></div>
