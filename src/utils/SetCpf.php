<?php
    namespace web\utils {
        class SetCpf {
            public static function verificarValidade($cpf) {
                $cpf = str_replace(['-', '.'], '', $cpf);

                // verificar se foi informado o numero exato de digitos
                if (strlen($cpf) != 11) { throw new \InvalidArgumentException("CPF inválido: deve conter pelo menos 11 (onze) dígitos."); }
            
                // verificar se foi informado uma sequencia de digitos iguais, 111.111.111-11
                if (preg_match('/(\d)\1{10}/', $cpf)) { throw new \InvalidArgumentException("CPF inválido: sequência de digitos repetidos."); }

                // Faz o calculo para validar o CPF
                for ($t = 9; $t < 11; $t++) {
                    for ($d = 0, $c = 0; $c < $t; $c++) {
                        $d += $cpf[$c] * (($t + 1) - $c);
                    }
                    $d = ((10 * $d) % 11) % 10;
                    if ($cpf[$c] != $d) {
                        throw new \InvalidArgumentException("CPF inválido."); 
                    }
                }
                
                $cpf = hash_hmac('sha256', $cpf, getenv('HASH_SECRET_KEY'));
                return $cpf;
            }

            public static function verificarIgualdade($cpfComHash, $cpfSemHash) {
                $cpfSemHash = hash_hmac('sha256', $cpfSemHash, getenv('HASH_SECRET_KEY'));

                return hash_equals($cpfComHash, $cpfSemHash);
            }
        }
    }