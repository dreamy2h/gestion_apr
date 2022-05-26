<?php
    function tipo_dte($tipo_documento) {
        define("BOLETA_EXENTA_H", 41);
        define("BOLETA_ELECTRONICA", 39);
        define("FACTURA_EXENTA_H", 34);
        define("FACTURA_ELECTRONICA", 33);
        define("BOLETA_EXENTA_APR", 1);
        define("BOLETA_ELECTRONICA_APR", 3);
        define("FACTURA_EXENTA_APR", 2);
        define("FACTURA_ELECTRONICA_APR", 4);

        switch ($tipo_documento) {
            case BOLETA_EXENTA_APR:
                return $tipo_dte = BOLETA_EXENTA_H;
            case FACTURA_EXENTA_APR:
                return $tipo_dte = FACTURA_EXENTA_H;
            case BOLETA_ELECTRONICA_APR:
                return $tipo_dte = BOLETA_ELECTRONICA;
            case FACTURA_ELECTRONICA_APR:
                return $tipo_dte = FACTURA_ELECTRONICA;
        }
    }
?>