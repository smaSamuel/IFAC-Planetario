<?php
    namespace web\classes {
        use DateTime;    

        class Eventos {
            private $_nome;
            private $_data;
            private $_descricao;

            public function __construct($nome, $data, $descricao) {
                $this->SetNome($nome);
                $this->SetData($data);
                $this->SetDescricao($descricao);
            }

            private function SetNome($nome) {
                if (is_string($nome)) {
                    $this->_nome = $nome;
                }
            }

            private function SetData($data) {
                $data = DateTime::createFromFormat('d/m/Y', $data);
                $datadb = $data->format('Y-m-d'); //Formatando a data para o padrão do banco de dados

                $this->_data = $datadb;
            }

            private function SetDescricao($descricao) {
                if (is_string($descricao)) {
                    $this->_descricao = $descricao;
                }                
            }

//-------------------------------------------------------------------------------------------------------------------

            public function GetNome() {
                return $this->_nome;
            }

            public function GetData() {
                return $this->_data;
            }

            public function GetDescricao() {
                return $this->_descricao;
            }
        }
    }