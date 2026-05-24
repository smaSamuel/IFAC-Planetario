<?php
    namespace web\utils {
        use DateTime;

        class SetIdade {
            public static function CalcularIdade($dataNascimento) {
                $dataNascimentoObj = DateTime::createFromFormat('d/m/Y', $dataNascimento);
                //$dataNascimentoDB = $dataNascimentoObj->format('Y-m-d');  //Formartar a data para o padrão do banco de dados
                $dataAtual = new DateTime();
                $idade = $dataAtual->diff($dataNascimentoObj);
                $idade = $idade->y;
            
                if($idade > 17 && $idade < 120) {
                    return $idade;
                } else {
                    throw new \InvalidArgumentException('Voce nao tem a idade minima para se registrar nesse site!');    
                }
            }

            public static function FormartarDataNascimento($dataNascimento) {
                return DateTime::createFromFormat('d/m/Y', $dataNascimento);
            }
        }
    }