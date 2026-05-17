<?php
    namespace web\Interfaces {
        interface Repository {

            //Método CriarEntidade()
            public function CriarEntidade($classe);
            /*
                Instancia um novo elemento em uma tablea, e retorna o ID desse novo elemento
                IMPORTANTE:
                    -SEMPRE verificar se o valor que estar chegando em $classe e realmente a classe que será instanciada 
            */

            //Método RemoverEntidade()
            public function RemoverEntidade($id);
            /*
                Remove um elemento de uma tabela
            */

            //Método AtualizarEntidade()
            public function AtualizarEntidade($id, $classe);
            /*
                Atualiza as colunas de um elemento de uma tabela
                IMPORTANTE:
                    -SEMPRE verificar se o valor que estar chegando em $classe e realmente a classe que será instanciada 
            */
            
            //Método ListarEntidade()
            public function ListarEntidade();
            /*
                Retorna todos os elementos de uma tabela
            */

            //Método ProcurarEntidade()
            public function ProcurarEntidade($id);
            /*
                Retorna todas as colunas de UM elemento de uma tabela
            */

            //Método ProcurarAtributoEntidade()
            public function ProcurarAtributoEntidade($id, $valor);
            /*
                Retorna a COLUNA de UM elemento de uma tabela
            */

        }
    }