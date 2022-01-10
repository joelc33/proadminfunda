   Ext.ns("datos_contribuyente");

   datos_contribuyente.main = {
              getDatosContribuyenteConsulta: function(OBJ){
           
             this.codigo = OBJ.tx_dist_contribuyente;
              if(OBJ.tx_razon_social==null){
                      var datos = '<p class="registro_detalle"><b>Apellidos y Nombres: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nombre_contribuyente)+' </p>';
                      datos += '<p class="registro_detalle"><b>C&eacute;dula: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_tp_doc)+'-'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_cedula)+'</p>';
                      datos += '<p class="registro_detalle"><b>Sexo: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nb_sexo)+'</p>';
                      datos += '<p class="registro_detalle"><b>Profesi&oacute;n: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_profesion)+'</p>';
                      datos += '<p class="registro_detalle"><b>Tel&eacute;fono Habitaci&oacute;n: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_hab)+'</p>';
                      datos += '<p class="registro_detalle"><b>Tel&eacute;fono Tel&eacute;fono: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_movil)+'</p>';
                      datos += '<p class="registro_detalle"><b>Correo Electronico: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_email)+'</p>';
                      var ubicacion_contrib = '<p class="registro_detalle"><b>Estado: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_estado)+' </p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Municipio: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_municipio)+'</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Parroquia: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_parroquia)+'</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Direcci&oacute;n: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_direccion)+'</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Referencia: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_referencia)+'</p>';

                      var datos_contribuyente = new Ext.form.FieldSet({
                                title: 'Datos Personales',
                                html: datos

                      });

                      var ubicacion = new Ext.form.FieldSet({
                                title: 'Ubicacion',
                                html: ubicacion_contrib
                      });

                      this.p = new Ext.Panel({
                        autoWidth: true,
                        autoHeight:true,
                        bodyStyle: 'padding: 10px',                        
                        items: [datos_contribuyente,ubicacion]
                     });
             }
             else
             {

                      var datos = '<p class="registro_detalle"><b>RIF: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_tp_doc)+'-'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_rif)+'<b>  &nbsp;&nbsp;&nbsp; NIT: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_nit)+' </p>';
                      datos += '<p class="registro_detalle"><b>Denominaci&oacute;n Comercial: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_denom_comercial)+'</p>';
                      datos += '<p class="registro_detalle"><b>Razon Social: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_razon_social)+'</p>';
                      datos += '<p class="registro_detalle"><b>Siglas: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_siglas)+'</p>';
                      datos += '<p class="registro_detalle"><b>Email: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_email)+'</p>';
                      datos += '<p class="registro_detalle"><b>Teléfono: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_movil)+'</p>';
                      datos += '<p class="registro_detalle"><b>Fax: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_hab)+'</p>';


                      var ubicacion_contrib = '<p class="registro_detalle"><b>Parroquia: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_parroquia)+'</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Direcci&oacute;n: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_direccion)+'</p>';

                      var registro_mercantil = '<p class="registro_detalle"><b>Tipo de Sociedad: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_tp_sociedad)+' </p>';
                      registro_mercantil += '<p class="registro_detalle"><b>Capital Suscrito: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.mo_capital)+'</p>';
                      registro_mercantil += '<p class="registro_detalle"><b>Nro Reg. de Comercio: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_reg_comercio)+'&nbsp;&nbsp;&nbsp;<b>Nro Tomo: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_tomo)+'</p>';
                      registro_mercantil += '<p class="registro_detalle"><b>Fecha Reg. Comercio: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.fe_reg_empresa)+'</p>';
                      registro_mercantil += '<p class="registro_detalle"><b>Representante Legal: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nb_representante_legal)+'</p>';
                      registro_mercantil += '<p class="registro_detalle"><b>Telf. Representante: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_representante)+'</p>';

                      var actividad_economica = '<p class="registro_detalle"><b>Actividad: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nb_actividad)+' </p>';
                      actividad_economica += '<p class="registro_detalle"><b>Descripci&oacute;n de la Actividad: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_act_economica)+'</p>';


                      var datos_contribuyente = new Ext.form.FieldSet({
                                title: 'Datos de la Empresa',
                              //  collapsible: true,
                                html: datos

                      });

                      var ubicacion = new Ext.form.FieldSet({
                                title: 'Ubicacion',
                              //  collapsible: true,
                                html: ubicacion_contrib

                      });

                       var registro = new Ext.form.FieldSet({
                                title: 'Datos del Registro Mercantil',
                              //  collapsible: true,
                                html: registro_mercantil

                      });

                      var actividad = new Ext.form.FieldSet({
                                title: 'Datos de la Actividad Economica',
                              //  collapsible: true,
                                html: actividad_economica

                      });

                      this.p = new Ext.Panel({
                        autoWidth: true,
                        autoHeight:true,                        
                        bodyStyle: 'padding: 10px',
                        items: [datos_contribuyente, ubicacion, registro,actividad]

                     });

             }

       },
       getDatosContribuyente: function(OBJ){
           
             this.codigo = OBJ.tx_dist_contribuyente;
             
              var monto_favor = '<p class="registro_detalle"><b>Monto a Favor: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.saldo)+' </p>';
                      
              var saldos = new Ext.form.FieldSet({
                                title: 'Saldo a Favor',
                                html: monto_favor
                      });
             
              if(OBJ.tx_razon_social==null){
                      var datos = '<p class="registro_detalle"><b>Apellidos y Nombres: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nombre_contribuyente)+' </p>';
                      datos += '<p class="registro_detalle"><b>C&eacute;dula: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_tp_doc)+'-'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_cedula)+'</p>';
                      datos += '<p class="registro_detalle"><b>Sexo: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nb_sexo)+'</p>';
                      datos += '<p class="registro_detalle"><b>Profesi&oacute;n: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_profesion)+'</p>';
                      datos += '<p class="registro_detalle"><b>Tel&eacute;fono Habitaci&oacute;n: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_hab)+'</p>';
                      datos += '<p class="registro_detalle"><b>Tel&eacute;fono Tel&eacute;fono: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_movil)+'</p>';
                      datos += '<p class="registro_detalle"><b>Correo Electronico: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_email)+'</p>';
                      var ubicacion_contrib = '<p class="registro_detalle"><b>Estado: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_estado)+' </p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Municipio: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_municipio)+'</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Parroquia: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_parroquia)+'</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Direcci&oacute;n: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_direccion)+'</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Referencia: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_referencia)+'</p>';



                      var datos_contribuyente = new Ext.form.FieldSet({
                                title: 'Datos Personales',
                                html: datos

                      });

                      var ubicacion = new Ext.form.FieldSet({
                                title: 'Ubicacion',
                                html: ubicacion_contrib
                      });
                      
                    
                      this.p = new Ext.Panel({
                        autoWidth: true,
                        autoHeight:true,
                        tbar: new Ext.Toolbar({
                                items: [{
                                xtype:'button',
                                text: 'Editar',
                               iconCls: 'icon-editar',
                               handler: Detalle.main.onEditar
                            }]
                        }),
                        bodyStyle: 'padding: 10px',
                       items: [datos_contribuyente,ubicacion,saldos]
                     });
             }
             else
             {

                      var datos = '<p class="registro_detalle"><b>RIF: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_tp_doc)+'-'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_rif)+'</p>';
                      datos += '<p class="registro_detalle"><b>Denominaci&oacute;n Comercial: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_denom_comercial)+'</p>';
                      datos += '<p class="registro_detalle"><b>Razon Social: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_razon_social)+'</p>';
                      datos += '<p class="registro_detalle"><b>Siglas: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_siglas)+'</p>';
                      datos += '<p class="registro_detalle"><b>Email: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_email)+'</p>';
                      datos += '<p class="registro_detalle"><b>Teléfono: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_movil)+'</p>';
                      datos += '<p class="registro_detalle"><b>Fax: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_hab)+'</p>';
					  datos += '<p class="registro_detalle"><b>Fecha de Actualizacion: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.fecha_actualizacion)+'</p>';
					 //datos += '<p class="registro_detalle"><b>Fecha de Inicio De Fiscalizacion: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.fe_fiscalizacion)+'</p>';
		             //datos += '<p class="registro_detalle"><b>Fecha Fin De Fiscalizacion: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.fecha_fiscalizacion_fin)+'</p>';
 		             datos += '<p class="registro_detalle"><b>Observacion: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_pagina)+'</p>';

                      var ubicacion_contrib = '<p class="registro_detalle"><b>Parroquia: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_parroquia)+'</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Direcci&oacute;n: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_direccion)+'</p>';

                      var registro_mercantil = '<p class="registro_detalle"><b>Tipo de Sociedad: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_tp_sociedad)+' </p>';
                      registro_mercantil += '<p class="registro_detalle"><b>Capital Suscrito: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.mo_capital)+'</p>';
                      registro_mercantil += '<p class="registro_detalle"><b>Nro Reg. de Comercio: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_reg_comercio)+'&nbsp;&nbsp;&nbsp;<b>Nro Tomo: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_tomo)+'</p>';
                      registro_mercantil += '<p class="registro_detalle"><b>Fecha Reg. Comercio: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.fe_reg_empresa)+'</p>';
		      registro_mercantil += '<p class="registro_detalle"><b>Representante Legal: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nb_representante_legal)+'</p>';
                      registro_mercantil += '<p class="registro_detalle"><b>Telf. Representante: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_representante)+'</p>';

                      var actividad_economica = '<p class="registro_detalle"><b>Actividad: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nb_actividad)+' </p>';
                      actividad_economica += '<p class="registro_detalle"><b>Descripci&oacute;n de la Actividad: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_act_economica)+'</p>';


                      var datos_contribuyente = new Ext.form.FieldSet({
                                title: 'Datos de la Empresa',
                              //  collapsible: true,
                                html: datos

                      });

                      var ubicacion = new Ext.form.FieldSet({
                                title: 'Ubicacion',
                              //  collapsible: true,
                                html: ubicacion_contrib

                      });

                       var registro = new Ext.form.FieldSet({
                                title: 'Datos del Registro Mercantil',
                              //  collapsible: true,
                                html: registro_mercantil

                      });

                      var actividad = new Ext.form.FieldSet({
                                title: 'Datos de la Actividad Economica',
                              //  collapsible: true,
                                html: actividad_economica

                      });

                      this.p = new Ext.Panel({
                        autoWidth: true,
                        autoHeight:true,
                        tbar: new Ext.Toolbar({
                                items: [{
                                xtype:'button',
                                text: 'Editar',
                               iconCls: 'icon-editar',
                               handler: Detalle.main.onEditar
                            }]
                        }),
                        bodyStyle: 'padding: 10px',
                        items: [datos_contribuyente, ubicacion, registro,actividad,saldos]

                     });

             }

      },
             getDatosBeneficiarioBansur: function(OBJ){
           
             this.codigo = OBJ.tx_dist_contribuyente;
             
             // var monto_favor = '<p class="registro_detalle"><b>Monto a Favor: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.saldo)+' </p>';
                      
              /*var saldos = new Ext.form.FieldSet({
                                title: 'Saldo a Favor',
                                html: monto_favor
                      });*/
             
              if(OBJ.tx_razon_social==null){
                      var datos = '<p class="registro_detalle"><b>Apellidos y Nombres: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nombre_contribuyente)+' </p>';
                      datos += '<p class="registro_detalle"><b>C&eacute;dula: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_tp_doc)+'-'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_cedula)+'</p>';
                      datos += '<p class="registro_detalle"><b>Sexo: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nb_sexo)+'</p>';
                      datos += '<p class="registro_detalle"><b>Profesi&oacute;n: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_profesion)+'</p>';
                      datos += '<p class="registro_detalle"><b>Tel&eacute;fono Habitaci&oacute;n: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_hab)+'</p>';
                      datos += '<p class="registro_detalle"><b>Tel&eacute;fono Tel&eacute;fono: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_movil)+'</p>';
                      datos += '<p class="registro_detalle"><b>Correo Electronico: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_email)+'</p>';
                      var ubicacion_contrib = '<p class="registro_detalle"><b>Estado: </b>Zulia</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Municipio: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_municipio)+'</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Parroquia: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_parroquia)+'</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Direcci&oacute;n: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_direccion)+'</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Referencia: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_referencia)+'</p>';



                      var datos_contribuyente = new Ext.form.FieldSet({
                                title: 'Datos Personales',
                                html: datos

                      });

                      var ubicacion = new Ext.form.FieldSet({
                                title: 'Ubicacion',
                                html: ubicacion_contrib
                      });
                      
                    
                      this.p = new Ext.Panel({
                        autoWidth: true,
                        autoHeight:true,
                        tbar: new Ext.Toolbar({
                                items: [{
                                xtype:'button',
                                text: 'Editar',
                               iconCls: 'icon-editar',
                               handler: Detalle.main.onEditar
                            }]
                        }),
                        bodyStyle: 'padding: 10px',
                       items: [datos_contribuyente,ubicacion]
                     });
             }
             

      },
      getDatosContribuyentetipotablet: function(OBJ,OBJPAGO,OBJACT){
           
             this.codigo = OBJ.tx_dist_contribuyente;
              if(OBJ.tx_razon_social==null){
                      var datos = '<p class="contrib_detalle"><b>Apellidos y Nombres: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nombre_contribuyente)+' </p>';
                      datos += '<p class="contrib_detalle"><b>C&eacute;dula: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_tp_doc)+'-'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_cedula)+'</p>';
                    
                    var pago = '<p class="contrib_detalle"><b>Motivo: </b>'+paqueteComunJS.funcion.IsNotNull(OBJPAGO.tx_motivo)+'</p>';
                      pago += '<p class="contrib_detalle"><b>Estatus: </b>'+paqueteComunJS.funcion.IsNotNull(OBJPAGO.in_solvente)+'</p>';

                    var act = '<p class="contrib_detalle"><b>Actividades: </b>'+paqueteComunJS.funcion.IsNotNull(OBJACT.tx_actividad)+'</p>';


                      var datos_contribuyente = new Ext.form.FieldSet({
                                title: 'Datos Personales',
                                html: datos

                      });

                      var pago_act = new Ext.form.FieldSet({
                                title: 'Datos Ultimo Pago',
                                html: pago
                      });

                      var datos_act = new Ext.form.FieldSet({
                                title: 'Datos Actividades',
                                html: act
                      });

                      this.p = new Ext.Panel({
                        autoWidth: true,
                        autoHeight:true,
                        bodyStyle: 'padding: 10px',
                       items: [datos_contribuyente,datos_act,pago_act]
                     });
             }
             else
             {

                      var datos = '<p class="contrib_detalle"><b>RIF: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_tp_doc)+'-'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_rif)+'</p>';
                      datos += '<p class="contrib_detalle"><b>Razon Social: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_razon_social)+'</p>';

                    var pago = '<p class="contrib_detalle"><b>Motivo: </b>'+paqueteComunJS.funcion.IsNotNull(OBJPAGO.tx_motivo)+'</p>';
                      pago += '<p class="contrib_detalle"><b>Estatus: </b>'+paqueteComunJS.funcion.IsNotNull(OBJPAGO.in_solvente)+'</p>';

                    var act = '<p class="contrib_detalle"><b>Actividades: </b>'+paqueteComunJS.funcion.IsNotNull(OBJACT.tx_actividad)+'</p>';

                      var datos_contribuyente = new Ext.form.FieldSet({
                                title: 'Datos de la Empresa',
                              //  collapsible: true,
                                html: datos

                      });

                      var pago_act = new Ext.form.FieldSet({
                                title: 'Datos Ultimo Pago',
                                html: pago
                      });

                      var datos_act = new Ext.form.FieldSet({
                                title: 'Datos Actividades',
                                html: act
                      });

                      this.p = new Ext.Panel({
                        autoWidth: true,
                        autoHeight:true,
                        bodyStyle: 'padding: 10px',
                        items: [datos_contribuyente,datos_act,pago_act]

                     });

             }

      },
         getDatosContribuyenteCenso: function(OBJ){
           
             this.codigo = OBJ.tx_dist_contribuyente;
                      var datos = '<p class="registro_detalle"><b>RIF: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_tp_doc)+'-'+paqueteComunJS.funcion.IsNotNull(OBJ.ci_rif)+'</p>';
                      datos += '<p class="registro_detalle"><b>Denominaci&oacute;n Comercial: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_denom_comercial)+'</p>';
                      datos += '<p class="registro_detalle"><b>Razon Social: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nombre_razon)+'</p>';
                      datos += '<p class="registro_detalle"><b>Representante Legal: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nb_representante)+'</p>';
                      datos += '<p class="registro_detalle"><b>Email: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_email)+'</p>';
                      datos += '<p class="registro_detalle"><b>Teléfono: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_movil)+'</p>';
                //      datos += '<p class="registro_detalle"><b>Fax: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_hab)+'</p>';
					 // datos += '<p class="registro_detalle"><b>Fecha de Actualizacion: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.fecha_actualizacion)+'</p>';
					 //datos += '<p class="registro_detalle"><b>Fecha de Inicio De Fiscalizacion: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.fe_fiscalizacion)+'</p>';
		             //datos += '<p class="registro_detalle"><b>Fecha Fin De Fiscalizacion: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.fecha_fiscalizacion_fin)+'</p>';
 		             datos += '<p class="registro_detalle"><b>Observacion: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_pagina)+'</p>';

                      var ubicacion_contrib = '<p class="registro_detalle"><b>Parroquia: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_parroquia)+'</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Direcci&oacute;n: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_direccion)+'</p>';

                      var actividad_economica = '<p class="registro_detalle"><b>Actividad: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nb_actividad)+' </p>';
                      actividad_economica += '<p class="registro_detalle"><b>Descripci&oacute;n de la Actividad: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_act_economica)+'</p>';


                      var datos_contribuyente = new Ext.form.FieldSet({
                                title: 'Datos de la Empresa',
                              //  collapsible: true,
                                html: datos

                      });

                      var ubicacion = new Ext.form.FieldSet({
                                title: 'Ubicacion',
                              //  collapsible: true,
                                html: ubicacion_contrib

                      });

                      var actividad = new Ext.form.FieldSet({
                                title: 'Datos de la Actividad Economica',
                              //  collapsible: true,
                                html: actividad_economica

                      });

                      this.c = new Ext.Panel({
                        autoWidth: true,
                        autoHeight:true,
                        tbar: new Ext.Toolbar({
                                items: [{
                                xtype:'button',
                                text: 'Editar',
                               iconCls: 'icon-editar',
                               handler: Detalle.main.onEditar
                            }]
                        }),
                        bodyStyle: 'padding: 10px',
                        items: [datos_contribuyente, ubicacion, actividad]

                     });

      }
            
   }

 datos_contribuyente.main2 = {
       getDatosContribuyente: function(OBJ){
              var monto_favor = '<p class="registro_detalle"><b>Monto a Favor: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.saldo)+' </p>';
                      
              var saldos = new Ext.form.FieldSet({
                                title: 'Saldo a Favor',
                                html: monto_favor
              });
             this.codigo = OBJ.tx_dist_contribuyente;
              if(OBJ.tx_razon_social==null){
                      var datos = '<p class="registro_detalle"><b>Apellidos y Nombres: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nombre_contribuyente)+' </p>';
                      datos += '<p class="registro_detalle"><b>C&eacute;dula: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_tp_doc)+'-'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_cedula)+'</p>';
                      datos += '<p class="registro_detalle"><b>Sexo: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nb_sexo)+'</p>';
                      datos += '<p class="registro_detalle"><b>Profesi&oacute;n: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_profesion)+'</p>';
                      datos += '<p class="registro_detalle"><b>Tel&eacute;fono Habitaci&oacute;n: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_hab)+'</p>';
                      datos += '<p class="registro_detalle"><b>Tel&eacute;fono Tel&eacute;fono: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_movil)+'</p>';
                      datos += '<p class="registro_detalle"><b>Correo Electronico: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_email)+'</p>';
                      var ubicacion_contrib = '<p class="registro_detalle"><b>Estado: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_estado)+' </p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Municipio: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_municipio)+'</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Parroquia: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_parroquia)+'</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Direcci&oacute;n: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_direccion)+'</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Referencia: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_referencia)+'</p>';

                      var datos_contribuyente = new Ext.form.FieldSet({
                                title: 'Datos Personales',
                                html: datos

                      });

                      var ubicacion = new Ext.form.FieldSet({
                                title: 'Ubicacion',
                                html: ubicacion_contrib
                      });

                      this.p = new Ext.Panel({
                        autoWidth: true,
                        autoHeight:true,
                        bodyStyle: 'padding: 10px',
                        tbar: new Ext.Toolbar({
                                items: [{
                                xtype:'button',
                                text: 'Editar',
                                iconCls: 'icon-editar',
                                handler: Detalle.main.onEditar
                            }]
                        }),
                       items: [datos_contribuyente,ubicacion,saldos]
                     });
             }
             else
             {

                      var datos = '<p class="registro_detalle"><b>RIF: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_tp_doc)+'-'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_rif)+'</p>';
                      datos += '<p class="registro_detalle"><b>Denominaci&oacute;n Comercial: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_denom_comercial)+'</p>';
                      datos += '<p class="registro_detalle"><b>Razon Social: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_razon_social)+'</p>';
                      datos += '<p class="registro_detalle"><b>Siglas: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_siglas)+'</p>';
                      datos += '<p class="registro_detalle"><b>Email: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_email)+'</p>';
                      datos += '<p class="registro_detalle"><b>Teléfono: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_movil)+'</p>';
                      datos += '<p class="registro_detalle"><b>Fax: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_hab)+'</p>';
				//	  datos += '<p class="registro_detalle"><b>Fecha de Actualizacion: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.fecha_actualizacion)+'</p>';
					  datos += '<p class="registro_detalle"><b>Fecha de Inicio De Fiscalizacion: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.fe_fiscalizacion)+'</p>';
					  datos += '<p class="registro_detalle"><b>Fecha Fin De Fiscalizacion: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.fecha_fiscalizacion_fin)+'</p>';
				//	  datos += '<p class="registro_detalle"><b>Observacion: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_pagina)+'</p>';

                      var ubicacion_contrib = '<p class="registro_detalle"><b>Parroquia: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_parroquia)+'</p>';
                      ubicacion_contrib += '<p class="registro_detalle"><b>Direcci&oacute;n: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_direccion)+'</p>';

                      var registro_mercantil = '<p class="registro_detalle"><b>Tipo de Sociedad: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_tp_sociedad)+' </p>';
                      registro_mercantil += '<p class="registro_detalle"><b>Capital Suscrito: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.mo_capital)+'</p>';
                      registro_mercantil += '<p class="registro_detalle"><b>Nro Reg. de Comercio: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_reg_comercio)+'&nbsp;&nbsp;&nbsp;<b>Nro Tomo: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_tomo)+'</p>';
                      registro_mercantil += '<p class="registro_detalle"><b>Fecha Reg. Comercio: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.fe_reg_empresa)+'</p>';
		      registro_mercantil += '<p class="registro_detalle"><b>Representante Legal: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nb_representante_legal)+'</p>';
                      registro_mercantil += '<p class="registro_detalle"><b>Telf. Representante: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nu_telf_representante)+'</p>';

                      var actividad_economica = '<p class="registro_detalle"><b>Actividad: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.nb_actividad)+' </p>';
                      actividad_economica += '<p class="registro_detalle"><b>Descripci&oacute;n de la Actividad: </b>'+paqueteComunJS.funcion.IsNotNull(OBJ.tx_act_economica)+'</p>';


                      var datos_contribuyente = new Ext.form.FieldSet({
                                title: 'Datos de la Empresa',
                              //  collapsible: true,
                                html: datos

                      });

                      var ubicacion = new Ext.form.FieldSet({
                                title: 'Ubicacion',
                              //  collapsible: true,
                                html: ubicacion_contrib

                      });

                       var registro = new Ext.form.FieldSet({
                                title: 'Datos del Registro Mercantil',
                              //  collapsible: true,
                                html: registro_mercantil

                      });

                      var actividad = new Ext.form.FieldSet({
                                title: 'Datos de la Actividad Economica',
                              //  collapsible: true,
                                html: actividad_economica

                      });

                      this.p = new Ext.Panel({
                        autoWidth: true,
                        autoHeight:true,
                        tbar: new Ext.Toolbar({
                                items: [{
                                xtype:'button',
                                text: 'Editar',
                                iconCls: 'icon-editar',
                                handler: Detalle.main.onEditar
                            }]
                        }),
                        bodyStyle: 'padding: 10px',
                        items: [datos_contribuyente, ubicacion, registro,actividad,saldos]

                     });

             }

      }
   }
