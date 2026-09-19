<?php
namespace app\Models {
    
    enum Status: string {
        case FREE = 'LIVRE';
        case RESERVED = 'RESERVADO';
        case ON_VISIT = 'EM_VISITACAO';
    }
}
