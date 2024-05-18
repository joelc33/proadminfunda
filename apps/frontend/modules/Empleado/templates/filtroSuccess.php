<script type="text/javascript">
Ext.ns("EmpleadoFiltro");
EmpleadoFiltro.main = {
init:function(){




this.cedula_titular = new Ext.form.TextField({
	fieldLabel:'Cedula titular',
	name:'cedula_titular',
	value:''
});

this.nombre_apellido = new Ext.form.TextField({
	fieldLabel:'Nombre apellido',
	name:'nombre_apellido',
	value:''
});

this.nacionalidad = new Ext.form.TextField({
	fieldLabel:'Nacionalidad',
	name:'nacionalidad',
	value:''
});

this.parentesco = new Ext.form.TextField({
	fieldLabel:'Parentesco',
	name:'parentesco',
	value:''
});

this.cedula = new Ext.form.TextField({
	fieldLabel:'Cedula',
	name:'cedula',
	value:''
});

this.fe_nacimiento = new Ext.form.TextField({
	fieldLabel:'Fe nacimiento',
	name:'fe_nacimiento',
	value:''
});

this.sexo = new Ext.form.TextField({
	fieldLabel:'Sexo',
	name:'sexo',
	value:''
});

this.tipo_empleado = new Ext.form.TextField({
	fieldLabel:'Tipo empleado',
	name:'tipo_empleado',
	value:''
});

this.organismo = new Ext.form.TextField({
	fieldLabel:'Organismo',
	name:'organismo',
	value:''
});

    this.tabpanelfiltro = new Ext.TabPanel({
       activeTab:0,
       defaults:{layout:'form',bodyStyle:'padding:7px;',height:135,autoScroll:true},
       items:[
               {
                   title:'Información general',
                   items:[
                                                                                this.cedula_titular,
                                                                                this.nombre_apellido,
                                                                                this.nacionalidad,
                                                                                this.parentesco,
                                                                                this.cedula,
                                                                                this.fe_nacimiento,
                                                                                this.sexo,
                                                                                this.tipo_empleado,
                                                                                this.organismo,
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
                     EmpleadoFiltro.main.aplicarFiltroByFormulario();
                }
            },
            {
                text:'Limpiar',
                handler:function(){
                    EmpleadoFiltro.main.limpiarCamposByFormFiltro();
                }
            },
            {
                text:'Cerrar',
                handler:function(){
                    EmpleadoFiltro.main.win.close();
                    EmpleadoLista.main.filtro.setDisabled(false);
                }
            }
        ]
    });
    this.win.show();
    EmpleadoLista.main.mascara.hide();
},
limpiarCamposByFormFiltro: function(){
    EmpleadoFiltro.main.panelfiltro.getForm().reset();
    EmpleadoLista.main.store_lista.baseParams={}
    EmpleadoLista.main.store_lista.baseParams.paginar = 'si';
    EmpleadoLista.main.gridPanel_.store.load();
},
aplicarFiltroByFormulario: function(){
    //Capturamos los campos con su value para posteriormente verificar cual
    //esta lleno y trabajar en base a ese.
    var campo = EmpleadoFiltro.main.panelfiltro.getForm().getValues();
    EmpleadoLista.main.store_lista.baseParams={};

    var swfiltrar = false;
    for(campName in campo){
        if(campo[campName]!=''){
            swfiltrar = true;
            eval("EmpleadoLista.main.store_lista.baseParams."+campName+" = '"+campo[campName]+"';");
        }
    }

        EmpleadoLista.main.store_lista.baseParams.paginar = 'si';
        EmpleadoLista.main.store_lista.baseParams.BuscarBy = true;
        EmpleadoLista.main.store_lista.load();


}

};

Ext.onReady(EmpleadoFiltro.main.init,EmpleadoFiltro.main);
</script>