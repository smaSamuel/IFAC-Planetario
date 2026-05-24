<?php
    namespace web\util {
        use Exception;

        class LogError {
            public static function logarError(Exception $e) {
                $log = sprintf("[%s] %s em %s:%d\n",
                    date('Y-m-d H:i:s'),
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine(),
                );

                file_put_contents('/logs/error.log', $log, FILE_APPEND);
            }
        }
    }