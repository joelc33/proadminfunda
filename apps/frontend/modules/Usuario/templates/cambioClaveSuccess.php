<script type="text/Javascript" >

    Ext.ns('cambioClave');

    cambioClave.formulario = {

        init: function(){

           this.clave_actual = new Ext.form.TextField({
                fieldLabel : 'Contraseña Actual',
                inputType:'password',
                id : 'clave_actual',
                name : 'clave_actual',
                width: '150px',
                allowBlank:false

           });

           this.clave = new Ext.form.TextField({
                fieldLabel : 'Contraseña Nueva',
                inputType:'password',
                id : 'clave',
                name : 'clave',
                width: '150px',
                allowBlank:false

           });

           this.confirmacion = new Ext.form.TextField({
                fieldLabel : 'Confirmación',
                inputType:'password',
                id : 'confirmacion',
                name : 'confirmacion',
                width: '150px',
                allowBlank:false

           });

           var form = new Ext.FormPanel({
               url: '<?php echo $_SERVER['SCRIPT_NAME'];?>/Usuario/edit',
               width: 300,
               height:130,
               padding:'10px',
               frame:true,
               items:[this.clave_actual,
                      this.clave,
                      this.confirmacion],             

           });

           this.win =new Ext.Window({
              title: 'Cambio de Clave del Usuario',
              constrain:true,
              width: 300,
              modal:true,
              items:[form],
              buttonAlign:'center',
              buttons: [
                     {text: 'Guardar',iconCls: 'icon-login',
                        handler: function(){
                             if (form.form.isValid() ) {
                                  Ext.MessageBox.show({
                                       msg: 'Guardando Registro, por favor espere...',
                                       progressText: 'Guardando...',
                                       width:300,
                                       wait:true,
                                       waitConfig: {interval:200}
                                   });
                                    form.form.submit({

                                    failure: function(form, action) {
                                        // this.error_code = action.result.error_code;
                                        // if(error_code == 1) {
                                             Ext.MessageBox.alert('Mensaje', action.result.message);
                                        // }
                                     },
                                     success: function(form, action) {
                                         Ext.MessageBox.show({
                                             title: 'Mensaje',
                                             msg: action.result.message,
                                             closable: false,
                                             resizable: false,
					     animEl: document.body,
                                             buttons: Ext.MessageBox.OK
                                         });
                                         cambioClave.formulario.win.close();

                                     }
                                 });
                             } else {
                                 Ext.Msg.show({
                                    title:'Mensaje',
                                     msg: 'Debe llenar los campos requeridos',
                                     buttons: Ext.Msg.OK,
                                     animEl: document.body,
                                     icon: Ext.MessageBox.INFO
                                 });
                             }
                         }

                 }]
           }).show();


        }

    }
    
   Ext.onReady(cambioClave.formulario.init,cambioClave.formulario);
</script>
