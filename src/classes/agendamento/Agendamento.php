<?php
namespace web\classes\agendamento {
    use web\classes\agendamento\Horario;
    use web\classes\usuario\Administrador;
    use web\classes\usuario\clientes\ClientePessoaJuridica;
    use web\classes\usuario\monitores\MonitorProfessor;

    abstract class Agendamento 
    {
        protected Horario $_horario;

        //Método CadastrarHorario()
        public function CadastrarHorario(Horario $horario, MonitorProfessor $professor = null) {        

        }

    }
    
}