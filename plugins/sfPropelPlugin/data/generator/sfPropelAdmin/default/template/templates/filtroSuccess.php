<script type="text/javascript">
Ext.ns("<?php echo $this->getModuleName() ?>Filtro");
<?php echo $this->getModuleName() ?>Filtro.main = {
init:function(){

<?php foreach ($this->getColumns('filtro.display') as $column): ?>
<?php if ($column->isPrimaryKey()) continue ?>
<?php if($column->isForeignKey()): ?>
//<Stores de fk>
this.store<?php echo $column->getRelatedColumnName() ?> = this.getStore<?php echo $column->getRelatedColumnName() ?>();
//<Stores de fk>
<?php endif; ?>
<?php endforeach; ?>


<?php foreach ($this->getColumns('filtro.display') as $column): ?>
<?php if ($column->isPrimaryKey()) continue ?>
<?php echo $this->getColumnEditTag($column,false) ?>
<?php endforeach; ?>

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                        <?php foreach ($this->getColumns('filtro.display') as $column): ?>
                            <?php if ($column->isPrimaryKey()) continue ?>
                            this.<?php echo $column->getName() ?>,
                        <?php endforeach; ?>
                   ]
               }
            ]
    });

    this.panelfiltro = new Ext.form.FormPanel({
        frame:true,
        autoWidth:true,
        border:false,
        items:[
            this.tabpanelfiltro
        ]
    });

    this.win = new Ext.Window({
        title:'Parametros de busqueda',
        iconCls: 'icon-buscar',
        width:600,
        autoHeight:true,
        constrain:true,
        closable:false,
        buttonAlign:'center',
        items:[
            this.panelfiltro
        ],
        buttons:[
            {
                text:'Filtrar',
                handler:function(){
                     <?php echo $this->getModuleName() ?>Filtro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    <?php echo $this->getModuleName() ?>Filtro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    <?php echo $this->getModuleName() ?>Filtro.main.win.close();
                    <?php echo $this->getModuleName() ?>Lista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    <?php echo $this->getModuleName() ?>Lista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    <?php echo $this->getModuleName() ?>Filtro.main.panelfiltro.getForm().reset();
    <?php echo $this->getModuleName() ?>Lista.main.store_lista.baseParams={}
    <?php echo $this->getModuleName() ?>Lista.main.store_lista.baseParams.paginar = 'si';
    <?php echo $this->getModuleName() ?>Lista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = <?php echo $this->getModuleName() ?>Filtro.main.panelfiltro.getForm().getValues();
    <?php echo $this->getModuleName() ?>Lista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("<?php echo $this->getModuleName() ?>Lista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        <?php echo $this->getModuleName() ?>Lista.main.store_lista.baseParams.paginar = 'si';
        <?php echo $this->getModuleName() ?>Lista.main.store_lista.baseParams.BuscarBy = true;
        <?php echo $this->getModuleName() ?>Lista.main.store_lista.load();


}
<?php foreach ($this->getColumns('filtro.display') as $column): ?>
<?php if ($column->isPrimaryKey()) continue ?>
<?php if($column->isForeignKey()): ?>
,getStore<?php echo $column->getRelatedColumnName() ?>:function(){
    this.store = new Ext.data.JsonStore({
        url:'[?= $_SERVER["SCRIPT_NAME"] ?]/<?php echo $this->getModuleName() ?>/storefk<?php echo strtolower($column->getPhpName()) ?>',
        root:'data',
        fields:[
            {name: '<?php echo strtolower($column->getRelatedColumnName()) ?>'}
            ]
    });
    return this.store;
}
<?php endif; ?>
<?php endforeach; ?>

};

Ext.onReady(<?php echo $this->getModuleName() ?>Filtro.main.init,<?php echo $this->getModuleName() ?>Filtro.main);
</script>