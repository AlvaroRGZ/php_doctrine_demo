<?php

namespace MiW\Results\Utility;

class JSONResponse
{
    private string $estado;
    private string $mensaje;

    public function __construct(string $estado = '', string $mensaje = '')
    {
        $this->estado = $estado;
        $this->mensaje = $mensaje;
    }

    /**
     * @param string $estado
     */
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @param string $mensaje
     */
    public function setMensaje(string $mensaje): void
    {
        $this->mensaje = $mensaje;
    }

    public function __toString()
    {
        return json_encode([
            'estado' => $this->estado,
            'mensaje' => $this->mensaje,
        ]);
    }
}