<?php
    require_once '../usuario.php'; //TEMPORARIO

    //Classe Cliente
    abstract class Cliente extends Usuario {
        //Ações de todos os clientes
        abstract public function ocuparEspaco(); 
        abstract public function desocuparEspaco(); 

    }