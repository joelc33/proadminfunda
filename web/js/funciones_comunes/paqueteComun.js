Ext.ns("paqueteComunJS");

paqueteComunJS.funcion = {
    /**
     * Esta funcion permite Cargar un combo de un modulo
     */
    cargarComboStoreBy:function(opcion){
        var ObjStore = new Ext.data.JsonStore({
                url:opcion.url+'/'+opcion.accion,
		root:'data',
		fields: ['value','label']
        });
        return ObjStore;
    },
    mostrarVentana: function(opcion){
        ruta = opcion.url;
        this.msg = Ext.get('muestra_contrib');
        if(opcion.parametro=='si'){
            this.msg.load({
             url: opcion.url,
             scripts: true,
             params:'id='+opcion.pByCod,
             text: "Cargando.."
            });
        }else{
            this.msg.load({
             url: opcion.url,
             waitMsg: 'Cargando..',
             scripts: true,
             text: "Cargando.."
            });
        }


        this.msg.show();

    },

        IsNotNull: function (cadena)
     {
        if(cadena == null)
            return '';
        else
            return cadena;

     },
    /**
     * Esta funcion permite cargar un combo a partir
     * de un <<valor>>.
     */
    seleccionComboBy: function(opcion){
        //{valor:,objetoField: , objetoStore:}
         opcion.objetoStore.on('load', function(){
                if(opcion.valor!=""){
                       opcion.objetoField.setValue(opcion.valor);
                       try{
                          objetoField.selectByValue(opcion.valor);
                       }
                       catch(err){

                       }


                }

      });
    },
    /**
     *  Esta funcion devuelve un objeto JSON.
     *  @param String stringData String de arreglo tipo json para ser deficado.
     *  Ejemplo:
     *  <code>
     *  doJSON({stringData:'{
     *      nombre  :   "usuario",
     *      correo  :   "personal[AT]persona.com"}'
     *  });
     *  </code>
     *  @return return OBJ-JSON
     */
    doJSON:function(opcion){
        try {
                //stringData = stringData.split('\r').join('\\r');
                //stringData = stringData.split('\n').join('\\n');
                var jsonData = Ext.util.JSON.decode(opcion.stringData);
                  return jsonData;
        }
        catch (err) {
                //Ext.MessageBox.alert('ERROR', 'No es posible interpretar los datos recibidos.<br>Vuelva a intentarlo' + stringData);
                //Variables de la excepcion serian, err.message, err.description
                Ext.MessageBox.alert('ERROR', 'No es posible interpretar los datos recibidos.<br>Vuelva a intentarlo. '+err.description);
        }
    },
    /**
     * Esta funcion valida si el obj cadena contiene valor o no
     * , de no contener valor, returna vacio.
     */
    verificarSiNull:function(opcion){
        if(opcion.cadena == null){
            return '';
        }else{
            return opcion.cadena;
        }
    },
/**
 * Esta funcion carga un combo, sus parametros son
 * @param obj objCMB Objeto del comboBox
 * @param string value Valor a buscar en el cmb y ser posicionado previamente
 * @param obj objStore Objeto store que validara el evento load
 * <code>
 * paqueteComunJS.funcion.seleccionarComboByCo({objCMB:vehiculo.mainVehiculo.cmbClasificacion,
 *                       value:vehiculo.mainVehiculo.OBJ.co_clase_veh
 *                       objStore:vehiculo.mainVehiculo.storeClasificacion});
 * </code>
 */
    seleccionarComboByCo: function(opcion){
        opcion.objStore.on("load",function(){
               valueOPT = opcion.value;
               objCmb   = opcion.objCMB;
               if(valueOPT!=''){
                    objCmb.setValue(valueOPT);
                    try{
                      objCmb.selectByValue(valueOPT);
                    }catch(err){};
               }
        });
    },
    /**
     * Esta funcion itera un store y devuelve la suma de la columna.
     * return sum.
     */
    getSumaColumnaGrid: function(opcion){
        var sum =0;
            opcion.store.each(function(record){
                    record.fields.each(function(field){
                        if(field.name==opcion.campo){
                            sum += parseFloat(record.get(field.name));
                        }
                });
            }, this);
        return sum.toFixed(2);
    },
    //paqueteComunJS.funcion.getSumaColumnaGrid
    getNumeroFormateado: function(num){
        num = num.toString().replace(/\$|\,/g,'');
        if(isNaN(num))
        num = "0";
        sign = (num == (num = Math.abs(num)));
        num = Math.floor(num*100+0.50000000001);
        cents = num%100;
        num = Math.floor(num/100).toString();
        if(cents<10)
        cents = "0" + cents;
        for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
        num = num.substring(0,num.length-(4*i+3))+','+
        num.substring(num.length-(4*i+3));
        return (((sign)?'':'-') + num + '.' + cents);
    },
    getJsonByObjStore: function(opcion){
            var json = '';
            opcion.store.each(function(store){
              json += Ext.util.JSON.encode(store.data) + ',';
            });
            json = json.substring(0, json.length - 1);
            return "["+json+"]";
    }

}//paqueteComunJS.funcion
function formatoNumero(val){
	    return paqueteComunJS.funcion.getNumeroFormateado(val);
return val;
}

function textoLargo(value, metadata) {
    metadata.attr = 'style="white-space: normal;"';
    return value;
}
