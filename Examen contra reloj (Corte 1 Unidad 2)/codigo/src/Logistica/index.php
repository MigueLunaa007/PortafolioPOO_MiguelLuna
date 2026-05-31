<?php
    //importamos los archivos de las clases que creamos usando require_once
    require_once 'Paquete.php';
    require_once 'Sensor.php';

    //instanciamos los 2 objetos diferentes de la clase paquete
    $paqueteA = new Paquete ();
    $paqueteB = new Paquete ();

    //asignamos valores a las propiedades publicas del paquete A
    $paqueteA->codigoSeguimiento = "LUCM-070926";
    $paqueteA->pesoKilogramos = 6.5;
    $paqueteA->esFragil = true;

    //asignamos valor a una propiedad privada
    //$paqueteA->costoInterno = 100.50; 
    // Al ejecutar la línea anterior, 
    // PHP arrojaria un "Fatal Error" porque no se puede acceder 
    // a una propiedad privada desde fuera de la clase

    //instanciamos un objeto sensor
    //y para la propiedad utlimaLectura
    //le asignamos una nueva instancia de la clase predefinida
    //DateTime
    $sensor = new Sensor ();
    $sensor->id = 1;
    $sensor->marca = "EcoTemp";
    $sensor->ultimaLectura = new DateTime();
    $sensor->rangoMaximo = 45.1;

    // Mostrar en el navegador el contenido del paquete A
    echo "<h3>Datos del Paquete A:</h3>";
        var_dump($paqueteA);

    // Mostrar en el navegador el contenido del sensor
    echo "<h3>Datos del Sensor:</h3>";
    var_dump($sensor);
?>
