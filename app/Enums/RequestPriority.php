<?php

namespace App\Enums;



enum RequestPriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::LOW => 'Low',
            self::MEDIUM => 'Medium',
            self::HIGH => 'High',
        };
    }
}

// enum RequestPriority: string
// {
//     case LOW = 'low';
//     case MEDIUM = 'medium';
//     case HIGH = 'high';

//     public static function values(): array
//     {
//         return array_column(self::cases(), 'value');
//     }

//     public function label(): string
//     {
//         return match($this) {
//             self::LOW => 'Low',
//             self::MEDIUM => 'Medium',
//             self::HIGH => 'High',
//         };
//     }
// }