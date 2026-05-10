<?php
namespace web\classes\usuario\clientes {

    use web\classes\usuario\Usuario;
    use DateTime;
    use web\classes\agendamento\ReservaEspaco;
    use web\classes\usuario\monitores\MonitorProfessor;
    use web\classes\agendamento\Horario;

    //Classe PessoaJuridica
    class ClientePessoaJuridica extends Usuario implements Cliente{
        private $_cnpj;
        private $_localizacao;
        private array $_reservasAtivas = [];

        //Método Construct
        public function __construct($nome, $cnpj, $email, $telefone, $localizacao, $senha) {
            parent::__construct         ($nome, $email, $telefone, $senha);
            $this-> setCnpj             ($cnpj);
            $this-> setLocalizacao      ($localizacao);
            
            }//Fim do Método Construct

        //Método validarCnpj
        protected function setCnpj($cnpj) {
            // Etapa 1: Limpeza
            $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

            //Etapa 2: Verificar tamanho
            if (strlen($cnpj) !== 14) {
                //throw new \InvalidArgumentException("CNPJ inválido!");
                return false;    
            }

            //Etapa 3: Verificar dígitos repetidos
            if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
                //throw new \InvalidArgumentException("CNPJ inválido!");
                return false;    
            }

            //Etapa 4: Validar primeiro dígito verificador
            $pesos1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
            $soma = 0;
            for ($i = 0; $i < 12; $i++) {
                $soma += (int)$cnpj[$i] * $pesos1[$i];
            }
            $resto = $soma % 11;
            $digito1 = $resto < 2 ? 0 : 11 - $resto;

            if ((int)$cnpj[12] !== $digito1) {
                //throw new \InvalidArgumentException("CNPJ inválido!");
                return false;    
            }

            //Validar segundo dígito verificador
            $pesos2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
            $soma = 0;
            for ($i = 0; $i < 13; $i++) {
                $soma += (int)$cnpj[$i] * $pesos2[$i];
            }
            $resto = $soma % 11;
            $digito2 = $resto < 2 ? 0 : 11 - $resto;

            if ((int)$cnpj[13] !== $digito2) {
               // throw new \InvalidArgumentException("CNPJ inválido!");
                return false;    
           }

            $this->_cnpj = $cnpj;
        } //Fim do Método de ValidarCnpj

        //Método setLocalizacao
        protected function setLocalizacao ($localizacao) {
            if (is_string($localizacao)) {
                $this->_localizacao = $localizacao;
            }
        }//Fim do Método setLocalizacao

        //Método getCnpj
        public function getCnpj() {
            return $this-> _cnpj;
        }//Fim do Método getCnpj

        //Método getLocalizacao
        public function getLocalizacao() {
            return $this-> _localizacao;
        }//Fim do Método getLocalizacao

        //Método getReservasAtivas
        public function getReservasAtivas() {
            return $this->_reservasAtivas;
        }//Fim do Método getReservasAtivas

        //Ações
        //Reservar espaço
        public function ocuparEspaco(Horario $horario, MonitorProfessor $professor = null) { 
            $reserva = new ReservaEspaco($this, 20, $professor);
            array_push($this->_reservasAtivas, $reserva);
            return $reserva;
        }
        //Desfazer reserva de espaço
        public function desocuparEspaco(Horario $horario) { 
            //$horario->Desagendar();
        }
    }//Fim da classe PessoaJuridica 

}