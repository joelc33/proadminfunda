<script type="text/javascript">
Ext.ns("EstructuraOrganizativaLista");
EstructuraOrganizativaLista.main = {
condicion:function(codigo){
    return (codigo=='0')?'NO':'SI';
},
init:function(){
this.mascara = new Ext.LoadMask(Ext.getBody(), {msg:"Cargando..."});

if('<?php echo $nivel_cero?>'!='0'){
    
var arbol_estructura = new Ext.tree.TreePanel({
        id:'im-tree-estructura',
        loader: new Ext.tree.TreeLoader(),
        rootVisible:false,
        lines:true,
        autoScroll:true,
        border: false,
        height:580,
        animate:true,
        useArrows: true,
        animCollapse:true,
        iconCls:'nav',
        root: new Ext.tree.AsyncTreeNode({
            text:'Inicio',
             expanded: true,
            children:[<?php echo $Empresa; ?>]

        })
});

this.formPanel_ = new Ext.form.FormPanel({
    title: 'Estructura Organización',
    width:1050,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
            
            arbol_estructura                    
          ]
});
}else{

this.tx_nom_estructura_administrativa = new Ext.form.TextField({
	fieldLabel:'Nombre de la Organizacion',
	name:'tbrh005_estructura_administrativa[tx_nom_estructura_administrativa]',
	allowBlank:false,
	width:400
});

this.nu_centro_costo = new Ext.form.TextField({
	fieldLabel:'Centro de Costo',
	name:'tbrh005_estructura_administrativa[nu_centro_costo]',
	width:400
});

this.guardar = new Ext.Button({
    text:'Guardar',
    iconCls: 'icon-guardar',
    handler:function(){

        if(!EstructuraOrganizativaLista.main.formPanel_.getForm().isValid()){
            Ext.Msg.alert("Alerta","Debe ingresar los campos en rojo");
            return false;
        }
        EstructuraOrganizativaLista.main.formPanel_.getForm().submit({
            method:'POST',
            url:'<?php echo $_SERVER["SCRIPT_NAME"] ?>/EstructuraOrganizativa/guardar',
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
                                var msg = Ext.get('tabPrincipal');
                msg.load({
                        url: 'EstructuraOrganizativa',
                        scripts: true,
                        text: 'Cargando...'
                });
             }
        });

   
    }
});

this.formPanel_ = new Ext.form.FormPanel({
    title: 'Estructura Organización',
    width:900,
    autoHeight:true,  
    autoScroll:true,
    bodyStyle:'padding:10px;',
    items:[
    this.tx_nom_estructura_administrativa,
    this.nu_centro_costo
        
          ],
    buttons:[
        this.guardar
    ],
    buttonAlign:'center'          
});

}

this.formPanel_.render("contenedorEstructuraOrganizativaLista");

}
};
Ext.onReady(EstructuraOrganizativaLista.main.init, EstructuraOrganizativaLista.main);
</script>
<div id="contenedorEstructuraOrganizativaLista"></div>
<div id="formularioEstructuraOrganizativa"></div>
<div id="filtroEstructuraOrganizativa"></div>
