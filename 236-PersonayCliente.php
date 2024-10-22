<?php
    class Persona{
        private $DNI;
        private $nombre;
        private $apellido;

        //CONSTRUCTOR
        function __construct($DNI, $nombre, $apellido){
            $this -> DNI = $DNI;
            $this -> nombre = $nombre;
            $this -> apellido = $apellido;
        }

        //GETTERS
        public function getNombre(){
            return $this -> nombre;
        }

        public function getApellido(){
            return $this -> apellido;
        }


        //SETTERS
        public function setNombre($nombre){
            $this -> nombre = $nombre;
        }

        public function setApellido($apellido){
            $this -> apellido = $apellido;
        }

        public function __toString(){
            return "Persona: " . $this->nombre . " " . $this->apellido;
        }
    }

    class Cliente extends Persona{
        private $saldo = 0;

        function __construct($DNI, $nombre, $apellido, $saldo){
            parent::__construct($DNI, $nombre, $apellido);
            $this -> $saldo = $saldo;
        }

        public function gestSaldo(){
            return $this -> saldo;
        }

        public function setSaldo($saldo){
            $this -> saldo = $saldo;
        }

        public function __toString(){
            return "Cliente: " . $this -> getNombre();
        }
    }

    //Creamos una persona
    $persona = new Persona("11111111A", "Ana", "Puertas");

    //Mostrarla, usando el metodo __toString
    echo $persona . "<br>";

    //Le cambiamos de apellido
    $persona -> setApellido("Montes");

    //Volver a mostrar
    echo $persona . "<br>";

    //Creamos un cliente
    $cliente = new Cliente("22222222A", "Pedro", "Sales", 100);

    //Lo mostramos
    echo $cliente . "<br>";
?>