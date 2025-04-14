<?php

namespace App\Enums;

enum RequestStatus: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case REJECTED = 'rejected';
    case COMPLETED = 'completed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::NEW => 'New',
            self::IN_PROGRESS => 'In Progress',
            self::REJECTED => 'Rejected',
            self::COMPLETED => 'Completed',
        };
    }
}