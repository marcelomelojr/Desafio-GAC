<?php

namespace App\Enums;

use App\Traits\EnumsToArray;

enum StatusTransactionEnum: string
{
    use EnumsToArray;
    case COMPLETED = 'Concluído';
    case ROLLED_BACK = 'Estornado';
    case PENDING = 'Pendente';
    case CANCELED = 'Cancelado';
    case PENDING_ROLLBACK = 'Estorno Pendente';

    public function label(): string
    {
        return match ($this) {
            self::COMPLETED => "Concluído",
            self::ROLLED_BACK => "Estornado",
            self::PENDING => "Pendente",
        };
    }


}
