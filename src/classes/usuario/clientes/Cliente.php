<?php

namespace web\classes\usuario\clientes {
    use web\classes\usuario\Usuario;

    //Classe Cliente
    abstract class Cliente extends Usuario {
        //Ações de todos os clientes
        abstract public function ocuparEspaco(); 
        abstract public function desocuparEspaco(); 

    }

}