<script type="text/javascript">
Ext.ns("rolTramiteEditar");
rolTramiteEditar.main = {
init:function(){

this.OBJ = paqueteComunJS.funcion.doJSON({stringData:'<?php echo $data ?>'});

//<ClavePrimaria>
this.co_usuario = new Ext.form.Hidden({
    name:'co_usuario',
    value:this.OBJ.co_usuario});

this.opciones = new Ext.tree.TreePanel({
                    id:'im-tree',
                    loader: new Ext.tree.TreeLoader(),
                    rootVisible:false,
                    lines:true,
                    autoScroll:true,
                    border: false,
                    height:300,
                    iconCls:'nav',
                    root: new Ext.tree.AsyncTreeNode({
                        text:'Inicio',
                        children:[<?php echo $tramite; ?>]

                    })
});

this.fielsetOP = new Ext.form.FieldSet({
              title:'Lista de Tramites',
              items:[this.opciones]});

function array1dToJson(a, p) {
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

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

                var check = new Array();
                var selNodes =  rolTramiteEditar.main.opciones.getChecked();
                var i = 0;
                Ext.each(selNodes, function(node){
                     check[i]=node.id;
                     i++;
                });
                var array = array1dToJson(check,'opcion');

        if(!rolTramiteEditar.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        rolTramiteEditar.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/Usuario/guardarTramite',
	    params:{arreglo:array},
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
                 rolTramiteEditar.main.winformPanel_.hide();
             }
        });

   
    }
});

this.salir = new Ext.Button({
    text:'Salir',
    handler:function(){
        rolTramiteEditar.main.winformPanel_.close();
    }
});

this.formPanel_ = new Ext.form.FormPanel({
//    frame:true,
    width:400,
    autoHeight:true,
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[

                this.co_usuario,
		this.fielsetOP
            ]
});

this.winformPanel_ = new Ext.Window({
    title:'Lista de Tramites',
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
        this.guardar,
        this.salir
    ],
    buttonAlign:'center'
});
this.winformPanel_.show();
this.opciones.getRootNode().expand(true);
UsuarioLista.main.mascara.hide();
}
};
Ext.onReady(rolTramiteEditar.main.init, rolTramiteEditar.main);
</script>
