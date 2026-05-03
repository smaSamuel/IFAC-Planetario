<?php
namespace web\classes\agendamento {
    interface Agendamento
    {
        //Método CadastrarHorario()
        public function CadastrarHorario();

        //Método AlterarCadastroHorario
        public function AlterarCadastroHorario();

        //Método RemoverCadastroHorario()
        public function RemoverCadastroHorario();

    }
    
}