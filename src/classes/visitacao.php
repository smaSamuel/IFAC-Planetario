<?php

    //Classe Visitacao
    class Visitacao {
        /** @var Monitor[]  */
        private Monitor $_monitores;
        /** @var PessoaFisica[] */
        private PessoaFisica $_cliente;
        private $_visitantesEpserados;
        private $_data;
        private $_id;
        
        //Metodo __construct()
        public function __construct(Monitor $monitores, PessoaFisica $pessoaFisica, $data, $id) {
            $this->SetMonitores         ($monitores);
            $this->SetPessoaFisica      ($pessoaFisica);
            $this->SetData              ($data);
            $this->SetId                ($id);
            }//Fim do metodo __construct()
            
        //Metodo SetMonitores()
        public function SetMonitores(Monitor $monitores) {
            $this->_monitores[] = $monitores;
        }//Fim do metodo SetMonitores
        
        //Metodo SetPessoaFisica()
        public function SetPessoaFisica(PessoaFisica $pessoaFisica) {
            $this->_cliente[] = $pessoaFisica;
        }//Fim do metodo SetPessoaFisica()

        //Metodo SetVisitantes()
        public function SetData($data) {
            $this->_data = $data;
        }//FIm do Metodo SetData   

        //Metodo SetID()
        public function SetID($id) {
            $this->_id = $id;
        }//Fim do Metodo SetID()

        //Metodo GetMonitores()
        public function GetMonitores() {
            return $this->_monitores;
        }//Fim do metodo GetMonitores()

        //Metodo GetPessoaFisica() 
        public function GetPessoaFisica() {
            return $this->_cliente;
        }//Fim do metodo GetPessoaFisica()

        //Metodo GetData()
        public function GetData() {
            return $this->_data;
        }//Fim do metodo GetData()

        //Metodo GetID()
        public function GetID() {
            return $this->_id;
        }//Fim do metodo GetID()
    }