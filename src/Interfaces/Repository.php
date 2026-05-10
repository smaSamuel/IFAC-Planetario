<?php
    namespace web\interface {
        interface Repository {

            //Método CriarNovaLinhaTabela()
            public function CriarNovaLinhaTabela($classe, $chave_estrangeira = null);
            /*
                Instancia um novo elemento em uma tablea, e retorna o ID desse novo elemento
                IMPORTANTE:
                    -SEMPRE verificar se o valor que estar chegando em $classe e realmente a classe que será instanciada 
            */

            //Método RemoverNovaLinhaTabela()
            public function RemoverNovaLinhaTabela($id);
            /*
                Remove um elemento de uma tabela
            */

            //Método AtualizarNovaLinhaTabela()
            public function AtualizarNovaLinhaTabela($id, $classe);
            /*
                Atualiza as colunas de um elemento de uma tabela
                IMPORTANTE:
                    -SEMPRE verificar se o valor que estar chegando em $classe e realmente a classe que será instanciada 
            */
            
            //Método ListaLinhasDaTabela()
            public function ListaLinhasTabela();
            /*
                Retorna todos os elementos de uma tabela
            */

            //Método ProcurarLinhaNaTabela()
            public function ProcurarLinhaNaTabela($id);
            /*
                Retorna todas as colunas de UM elemento de uma tabela
            */

            //Método ProcurarColunaNaTabela()
            public function ProcurarColunaNaTabela($id, $valor);
            /*
                Retorna a COLUNA de UM elemento de uma tabela
            */

        }
    }