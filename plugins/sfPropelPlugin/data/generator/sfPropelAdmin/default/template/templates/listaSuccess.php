<script type="text/javascript">
Ext.ns("<?php echo $this->getModuleName() ?>Lista");
<?php echo $this->getModuleName() ?>Lista.main = {
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
        <?php echo $this->getModuleName() ?>Lista.main.mascara.show();
        this.msg = Ext.get('formulario<?php echo $this->getModuleName() ?>');
        this.msg.load({
         url:'[?= $_SERVER["SCRIPT_NAME"] ?]/<?php echo $this->getModuleName() ?>/editar',
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
<?php //CLAVES PRIMARIAS ?>
<?php foreach ($this->getPrimaryKey() as $pk): ?>
<?php $campoPK = strtolower($pk->getName()) ?>
	this.codigo  = <?php echo $this->getModuleName() ?>Lista.main.gridPanel_.getSelectionModel().getSelected().get('<?php echo $campoPK ?>');
	<?php echo $this->getModuleName() ?>Lista.main.mascara.show();
<?php endforeach; ?>
        this.msg = Ext.get('formulario<?php echo $this->getModuleName() ?>');
        this.msg.load({
         url:'[?= $_SERVER["SCRIPT_NAME"] ?]/<?php echo $this->getModuleName() ?>/editar/codigo/'+this.codigo,
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
	this.codigo  = <?php echo $this->getModuleName() ?>Lista.main.gridPanel_.getSelectionModel().getSelected().get('<?php echo $campoPK ?>');
	Ext.MessageBox.confirm('Confirmación', '¿Realmente desea eliminar este registro?', function(boton){
	if(boton=="yes"){
        Ext.Ajax.request({
            method:'POST',
            url:'[?= $_SERVER["SCRIPT_NAME"] ?]/<?php echo $this->getModuleName() ?>/eliminar',
            params:{
                <?php echo $campoPK ?>:<?php echo $this->getModuleName() ?>Lista.main.gridPanel_.getSelectionModel().getSelected().get('<?php echo $campoPK ?>')
            },
            success:function(result, request ) {
                obj = Ext.util.JSON.decode(result.responseText);
                if(obj.success==true){
		    <?php echo $this->getModuleName() ?>Lista.main.store_lista.load();
                    Ext.Msg.alert("Notificación",obj.msg);
                }else{
                    Ext.Msg.alert("Notificación",obj.msg);
                }
                <?php echo $this->getModuleName() ?>Lista.main.mascara.hide();
            }});
	}});
    }
});

//filtro
this.filtro = new Ext.Button({
    text:'Filtro',
    iconCls: 'icon-buscar',
    handler:function(){
        this.msg = Ext.get('filtro<?php echo $this->getModuleName() ?>');
        <?php echo $this->getModuleName() ?>Lista.main.mascara.show();
        <?php echo $this->getModuleName() ?>Lista.main.filtro.setDisabled(true);
        this.msg.load({
             url: '[?= $_SERVER["SCRIPT_NAME"] ?]/<?php echo $this->getModuleName() ?>/filtro',
             scripts: true
        });
    }
});

this.editar.disable();
this.eliminar.disable();

//Grid principal
this.gridPanel_ = new Ext.grid.GridPanel({
    title:'Lista de <?php echo $this->getModuleName() ?>',
    iconCls: 'icon-libro',
    store: this.store_lista,
    loadMask:true,
//    frame:true,
    height:550,
    tbar:[
        this.nuevo,'-',this.editar,'-',this.eliminar,'-',this.filtro
    ],
    columns: [
    new Ext.grid.RowNumberer(),
<?php //CLAVES PRIMARIAS ?>
<?php foreach ($this->getPrimaryKey() as $pk): ?>
<?php $campoPK = strtolower($pk->getName()) ?>
    {header: '<?php echo $campoPK ?>',hidden:true, menuDisabled:true,dataIndex: '<?php echo $campoPK ?>'},
<?php endforeach; ?>
<?php $cantidadRegistros =count($this->getAllColumns()); ?>
<?php foreach ($this->getColumns('lista.display') as $column): ?>
<?php if ($column->isPrimaryKey()) continue ?>
    {header: '<?php echo $this->getParameterValue("lista.fields.".$column->getName().".name") ?>', width:100, <?php if($column->getName()=='in_delete'){ echo "renderer: ".$this->getModuleName()."Lista.main.condicion, "; } ?> menuDisabled:true, sortable: true,  dataIndex: '<?php echo $column->getName() ?>'},
<?php endforeach; ?>
    ],
    stripeRows: true,
    autoScroll:true,
    stateful: true,
    listeners:{cellclick:function(Grid, rowIndex, columnIndex,e ){<?php echo $this->getModuleName() ?>Lista.main.editar.enable();<?php echo $this->getModuleName() ?>Lista.main.eliminar.enable();}},
    bbar: new Ext.PagingToolbar({
        pageSize: 20,
        store: this.store_lista,
        displayInfo: true,
        displayMsg: '<span style="color:black">Registros: {0} - {1} de {2}</span>',
        emptyMsg: "<span style=\"color:black\">No se encontraron registros</span>"
    })
});

this.gridPanel_.render("contenedor<?php echo $this->getModuleName() ?>Lista");


this.store_lista.load();
},
getLista: function(){
    this.store = new Ext.data.JsonStore({
    url:'[?= $_SERVER["SCRIPT_NAME"] ?]/<?php echo $this->getModuleName() ?>/storelista',
    root:'data',
    fields:[
<?php foreach ($this->getPrimaryKey() as $pk): ?>
<?php $campoPK = strtolower($pk->getName()) ?>
    {name: '<?php echo $campoPK ?>'},
<?php endforeach; ?>
<?php foreach ($this->getColumns('lista.display') as $column): ?>
<?php if ($column->isPrimaryKey()) continue ?>
    {name: '<?php echo $column->getName() ?>'},
<?php endforeach; ?>
           ]
    });
    return this.store;
}
};
Ext.onReady(<?php echo $this->getModuleName() ?>Lista.main.init, <?php echo $this->getModuleName() ?>Lista.main);
</script>
<div id="contenedor<?php echo $this->getModuleName() ?>Lista"></div>
<div id="formulario<?php echo $this->getModuleName() ?>"></div>
<div id="filtro<?php echo $this->getModuleName() ?>"></div>
