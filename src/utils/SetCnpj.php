<?php
    namespace web\utils {
        class SetCnpj {
            public static function verificarCNPJ($cnpj) {
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

                return $cnpj;
            }
        }
    }