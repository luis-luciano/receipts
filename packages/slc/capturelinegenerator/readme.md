Capture Line Generator - Auxiliar para generar una línea de captura

Introducción
	Este paquete es una propuesta para generar una línea de captura utilizando el algoritmo modulo 57 base 2013.

Instalación.
	Para añadir paquetes creados de manera local a un proyecto en laravel es bueno crear un directorio llamado "packages" en la raíz del proyecto:
	En esta carpeta se almacenará el paquete slc/capturelinegenerator, así que la carpeta con nombre "slc" se copiará a la carpeta "packages" quedando la siguiente estructura:
	packages/slc/capturelinegenerator/...

	De esta manera ya se tiene el paquete en la estructura del proyecto pero hay que registrarlo en composer.json y esto es de la siguiente manera:
	En la sección de carga utilizando PSR-4 y files, se agrega como se muestra:

	"autoload": {
        "files": [
            "packages/slc/capturelinegenerator/src/helpers.php"
        ],
        "psr-4": {
            "CaptureLineGenerator\\": "packages/slc/capturelinegenerator/src/"
        }
    }

    Se realiza un volcado del autoloader de la siguiente manera:
    	composer dumpautoload

    Y realmente ya está el paquete listo para su uso.

Iniciando.
	Se recomienda crear un wrapper para la aplicación de tal manera que pueda utilizarse este paquete comodamente.
	Una propuesta es la siguiente:

	// app/CaptureLineGenerator.php
	<?php

	namespace App;

	use CaptureLineGenerator\Algorithms\Mod57B2013;
	use CaptureLineGenerator\Generator;
	use CaptureLineGenerator\ReferenceLineGenerator\Generator as ReferenceLineGenerator;
	use CaptureLineGenerator\ReferenceLineGenerator\ReferenceLines\PredialReferenceLine;

	class CaptureLineGenerator
	{

	    /**
	     * Generate the capture line.
	     *
	     * @param  string  $resource
	     * @param  string  $account
	     * @param  string  $childAccount
	     * @param  string  $dateString
	     * @param  string  $amount
	     * @return void
	     */
	    public static function generate($resource, $account, $childAccount, $dateString, $amount)
	    {
	        $generator = new Generator(
	            new Mod57B2013(
	                ReferenceLineGenerator::generate(
	                    new PredialReferenceLine($resource, $account, $childAccount)
	                ),
	                $dateString,
	                $amount
	            )
	        );

	        return $generator->generate();
	    }
	}

Implementación.
	Si se tiene el wrapper un ejemplo de implmenetación es la siguiente:
	// app/Http/routes.php
	use App\CaptureLineGenerator;

	Route::get('/', function () {
	    return CaptureLineGenerator::generate("176", "U0000205", "U0000205", "20141119", "532.72");
	});

	De no ser así, prácticamente hay que realizar una declaración completa:
	
	// app/Http/routes.php
	use CaptureLineGenerator\Algorithms\Mod57B2013;
	use CaptureLineGenerator\Generator;
	use CaptureLineGenerator\ReferenceLineGenerator\Generator as ReferenceLineGenerator;
	use CaptureLineGenerator\ReferenceLineGenerator\ReferenceLines\PredialReferenceLine;

	Route::get('/', function () {
		$generator = new Generator(
            new Mod57B2013(
                ReferenceLineGenerator::generate(
                    new PredialReferenceLine($resource, $account, $childAccount)
                ),
                $dateString,
                $amount
            )
        );
	    return $generator->generate();
	});
