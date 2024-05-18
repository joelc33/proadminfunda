<script type="text/javascript">
Ext.ns("formularioEditar");
formularioEditar.main = {
init:function(){

this.salir = new Ext.Button({
    text:'Salir',
    //iconCls: 'icon-cancelar',
    handler:function(){
        formularioEditar.main.winformPanel_.close();
    }
});

this.Panel = new Ext.Panel ({
	baseCls : 'x-plain',
	html    : 'Formulario No Encontrado.',
	cls     : 'icon-autorizacion',
	region  : 'north',
	height  : 70
});

this.winformPanel_ = new Ext.Window({
    title:'Formulario: Aviso',
    modal:true,
	frame:false,
    constrain:true,
    width:314,
    frame:true,
    closabled:true,
    autoHeight:true,
    items:[
        this.Panel
    ],
    buttons:[
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
}
};
Ext.onReady(formularioEditar.main.init, formularioEditar.main);
</script>
<div id="requisito" ></div>
<div id="solvencia" ></div>
