<script type="text/javascript">

    Ext.ns("documento");

    //----- Función que bloquea los dias en el calendario de la fecha fin dependiendo de la fecha de inicio --//
    Ext.apply(Ext.form.VTypes, {
        daterange: function (val, field) {
            var date = field.parseDate(val);

            if (!date) {
                return false;
            }
            if (field.startDateField && (!this.dateRangeMax || (date.getTime() != this.dateRangeMax.getTime()))) {
                var start = Ext.getCmp(field.startDateField);
                start.setMaxValue(date);
                start.validate();
                this.dateRangeMax = date;
            }
            else if (field.endDateField && (!this.dateRangeMin || (date.getTime() != this.dateRangeMin.getTime()))) {
                var end = Ext.getCmp(field.endDateField);
                end.setMinValue(date);
                end.validate();
                this.dateRangeMin = date;
            }
            return true;
        }
    });

    //-------------------------------------------------------------------------------------------// 

    documento.presupuesto = {
        init: function () {


            this.fe_inicio = new Ext.form.DateField({
                fieldLabel: 'Fecha de inicio',
                id: 'fe_inicio',
                name: 'fe_inicio',
                format: 'Y-m-d',
                vtype: 'daterange',
                //allowBlank:false,
                style: { width: '10%' },
                endDateField: 'fe_fin',
                allowBlank: false
            });
            this.fe_fin = new Ext.form.DateField({
                fieldLabel: 'Fecha de fin',
                id: 'fe_fin',
                name: 'fe_fin',
                format: 'Y-m-d',
                //allowBlank:false,
                style: { width: '10%' },
                vtype: 'daterange',
                startDateField: 'fe_inicio',
                allowBlank: false

            });




            this.tipo_planilla = new Ext.form.FieldSet({
                title: 'Seleccione Parametros',
                items: [this.fe_inicio, this.fe_fin]
            });

            this.Descripcion = new Ext.Panel({
                title: 'Descripcion',
                autoWidth: true,
                border: false,
                padding: 10,
                html: '<FONT SIZE=2><p><b>Muestra un listado de Creditos Adicionales.</p></b></font><FONT SIZE=2><p>1.Seleccione el rango de fecha</p></font>',
            });

            this.exportar = new Ext.Button({
                text: 'Exportar',
                iconCls: 'icon-descargar',
                handler: function () {

                    if (!documento.presupuesto.formpanel.getForm().isValid()) {
                        Ext.Msg.alert("Alerta", "Debe ingresar correctamente los parametros de búsqueda requeridos");
                        return false;
                    }


                    window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/relacion_ODP_XLS.php?' + documento.presupuesto.formpanel.getForm().getValues(true));
                }
            });

            this.formpanel = new Ext.form.FormPanel({
                bodyStyle: 'padding:10px',
                autoWidth: true,
                autoHeight: true,
                id: 'forma',
                iconCls: 'icon-reporteVeh',
                title: 'Reporte de Lista de Creditos Adicionales',
                url: '',
                defaults: { style: 'margin-bottom:10px' },
                items: [

                    this.tipo_planilla, this.Descripcion

                ],
                buttonAlign: 'center',
                buttons: [
                    {
                        text: 'Consultar',  // Generar la impresión en pdf
                        iconCls: 'icon-buscar',
                        handler: this.onImprimir
                    },
                    {
                        text: 'Limpiar',  // Limpiar campos del formulario
                        iconCls: 'icon-limpiar',
                        handler: this.onLimpiar
                    },
                    this.exportar]

            });


            this.formpanel.render('mainPrincipal');


        },
        onImprimir: function () {

            window.open('<?php echo $_SERVER['SCRIPT_SERVER']; ?>/proadmin/web/reportes/ListaCreditoAdicional_XLS.php?' + documento.presupuesto.formpanel.getForm().getValues(true));

        },

        onLimpiar: function () {
            documento.presupuesto.formpanel.getForm().reset();
        }
    }
    Ext.onReady(documento.presupuesto.init, documento.presupuesto);

</script>
<div id="mainPrincipal"></div>