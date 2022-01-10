<script type="text/javascript">
Ext.ns("buscarNegocio");
buscarNegocio.main = {
init:function(){

//this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>



this.opciones = new Ext.tree.TreePanel({
                    id:'im-tree',
                    loader: new Ext.tree.TreeLoader(),
                    rootVisible:false,
                    lines:true,
                    autoScroll:true,
                    border: false,
                    height:300,
                    iconCls:'nav',
                    expanded: false,
                    root: new Ext.tree.AsyncTreeNode({
                        text:'Inicio',
                        children:[<?php echo $estructura; ?>]

                    })
});

this.fielsetOP = new Ext.form.FieldSet({
              title:'Buscar Estructura',
              items:[this.opciones]});





this.salir = new Ext.Button({
    text:'Salir',
    handler:function(){
        buscarNegocio.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
//    frame:true,
    width:400,
    autoHeight:true,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[this.fielsetOP]
});

this.winformPanel_ = new Ext.Window({
    title:'Negocios',
    modal:true,
    constrain:true,
	width:410,
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
//this.opciones.getRootNode().expand(true);

},
getEnviarNegocio: function(){
                var check = new Array();
                var selNodes =  buscarNegocio.main.opciones.getChecked();
                var i = 0;
                Ext.each(selNodes, function(node){
                     check[i]=node.id;
                     i++;
                });
                var array = buscarNegocio.main.array1dToJson(check,'opcion');
                
                this.msg = Ext.get('enviar_negocio');
                this.msg.load({
                 url:"<?php echo $_SERVER["SCRIPT_NAME"] ?>/ModuloReporte/seleccinarEstructura",
                 params:{json_array:array,
                         paquete: '<?php echo $paquete;?>'},
                 scripts: true,
                 text: "Cargando.."
                });
                
                buscarNegocio.main.winformPanel_.close();
},
array1dToJson: function(a, p) {
	  var i, s = '[';
	  for (i = 0; i < a.length; ++i) {
	    if (typeof a[i] == 'string') {
	      s += '"' + a[i] + '"';
	    }
	    else { // assume number type
	      s += a[i];
	    }
	    if (i < a.length - 1) {
	      s += ',';
	    }
	  }
	  s += ']';
	  if (p) {
	    return '{"' + p + '":' + s + '}';
	  }
	  return s;
}
};
Ext.onReady(buscarNegocio.main.init, buscarNegocio.main);
</script>
<div id="enviar_negocio"></div>
