<?php

if(!defined("WHMCS")) {
    exit("This file cannot be accessed directly");
}

// Configuración del módulo sin verificación de licencia
function email_verifier_config()
{
    return [
        "name" => "Email Verifier",
        "description" => "Módulo de verificación de correos que optimiza el proceso, mejorando la seguridad y la fiabilidad al validar direcciones de correo.",
        "version" => "1.1.0",
        "author" => "<a href='https://elearningcloud.org/' target='_blank'>Elearning Cloud</a>",
        "language" => "english",
        "fields" => [
            "nodeletedb" => [
                "FriendlyName" => "Tabla de base de datos",
                "Type" => "yesno",
                "Size" => "25",
                "Description" => "Marcar esta casilla para eliminar las tablas de la base de datos al desactivar"
            ]
        ]
    ];
}

// Sistema básico de logging (opcional)
function logEmailVerifierActivity($message)
{
    $logFile = __DIR__ . '/logs/email_verifier.log';
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - " . $message . PHP_EOL, FILE_APPEND);
}
