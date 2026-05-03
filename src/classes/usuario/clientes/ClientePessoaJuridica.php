<?php
namespace web\classes\usuario\clientes {
    
    //Classe PessoaJuridica
    class ClientePessoaJuridica extends Cliente{
        private $_cnpj;
        private $_tel;
        private $_localizacao;
        
        //Método Construct
        public function __construct($nome, $cnpj, $email, $telefone, $localizacao) {
            parent::__construct         ($nome, $email, $telefone);
            $this-> setCnpj             ($cnpj);
            $this-> setLocalizacao      ($localizacao);
            
            }//Fim do Método Construct

        //Método validarCnpj
        protected function setCnpj($cnpj) {
            // Etapa 1: Limpeza
            $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

            //Etapa 2: Verificar tamanho
            if (strlen($cnpj) !== 14) {
                throw new \InvalidArgumentException("CNPJ inválido!");
            }

            //Etapa 3: Verificar dígitos repetidos
            if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
                throw new \InvalidArgumentException("CNPJ inválido!");
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
                throw new \InvalidArgumentException("CNPJ inválido!");
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
                throw new \InvalidArgumentException("CNPJ inválido!");
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

        //Ações
        //Reservar espaço
        public function ocuparEspaco() { 
            /*
                Implementar método de reservar espaço
                Vincular uma data
                Vincular um MonitorProfessor 

            */

        }
        //Desfazer reserva de espaço
        public function desocuparEspaco() { 
            return false; 
        }
    }//Fim da classe PessoaJuridica 

}