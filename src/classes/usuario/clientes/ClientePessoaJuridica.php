<?php
namespace web\classes\usuario\clientes {

    use web\classes\usuario\Usuario;
    use web\utils\SetCnpj;

    //Classe PessoaJuridica
    class ClientePessoaJuridica extends Usuario{
        private $id;
        private $_cnpj;
        private $_localizacao;

        //Método Construct
        public function __construct($nome, $cnpj, $email, $telefone, $localizacao, $senha) {
            parent::__construct         ($nome, $email, $telefone, $senha);
            $this-> setCnpj             ($cnpj);
            $this-> setLocalizacao      ($localizacao);
            
            }//Fim do Método Construct


        //Método SetId()
        public function SetId($id) {
            $this->id = $id;
        }//Fim do método SetId()

        //Método validarCnpj
        protected function setCnpj($cnpj) {
            $this->_cnpj = SetCnpj::verificarCNPJ($cnpj);
        } //Fim do Método de ValidarCnpj

        //Método setLocalizacao
        protected function setLocalizacao ($localizacao) {
            $this->_localizacao = $localizacao;
        }//Fim do Método setLocalizacao

        //Método getCnpj
        public function getCnpj() {
            return $this-> _cnpj;
        }//Fim do Método getCnpj

        //Método getLocalizacao
        public function getLocalizacao() {
            return $this-> _localizacao;
        }//Fim do Método getLocalizacao

        //Método GetUsuario()
        public function GetUsuario() {
            return parent::class;
        }//Fim do método GetUsuario()

        //Método GetId()
        public function GetId(){
            return $this->id;
        }//Fim do método GetId()

    }//Fim da classe PessoaJuridica 

}