<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of interpretePropelModel
 *
 * @author LE
 */
class InterpretePropelModel {
    /**
     * Esta función se encarga de devolver el nombre de la función
     * dependiendo del tipo de $tipoMetodo devolvera estructurado segun
     * Propel el nombre de la función del campo (estos son getter o setter
     * del campo).
     * <br><b>Ejemplo:</b>
     * <code>
     * <?php
     *    $interpretePropelModel = new InterpretePropelModel();
     *    (1) $nombreFuncionGET = $interpretePropelModel->getNbFuncionByNbCampo("get","nb_nombre");
     *    (2) $nombreFuncionSET = $interpretePropelModel->getNbFuncionByNbCampo("set","nb_nombre");
     *    Salida (1): $nombreFuncionGET: getNbNombre().
     *    Salida (2): $nombreFuncionSET: setNbNombre().
     * ?>
     * </code>
     *
     * @param string $tipoMetodo Indica el tipo de Metodo: GET ó SET
     * @param string $NbCampo Indica el nombre del campo
     * de tabla de la base de datos.
     * @return string
     */
    public function getNbFuncionByNbCampo($tipoMetodo, $NbCampo){
        $nuevoNbCampo = self::formaterNbCampo($NbCampo);
        return $tipoMetodo.$nuevoNbCampo;
    }

    /**
     * Esta función elimina cualquier caracter especial ( _ )
     * para llevarlo a la forma segun Propel.
     * <code>
     *  Ejemplo:
     *      nb_nombre
     *      NbNombre
     * </code>
     * @param string $NbCampo Nombre de campo a formatear.
     * @return string
     */ 
    public static function formaterNbCampo($referencia){
        $separadorBy_ = explode("_",$referencia);
        $nombre = "";
        foreach ($separadorBy_ as $posicion => $valor) {
            $nombre .= ucfirst($valor);
        }
        return $nombre;
    }
    

}
?>