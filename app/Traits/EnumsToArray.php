<?php

namespace App\Traits;

use Illuminate\Support\Arr;

trait EnumsToArray
{
    public static function getAllValues(): array
    {
        return array_column(self::cases(), 'value');
    }
    
    public static function fromName(string $name): string
    {
        foreach (self::cases() as $status) {
            if( $name === $status->name ){
                return $status->value;
            }
        }
        throw new \ValueError("$name is not a valid backing value for enum " . self::class );
    }

    public static function tryFromName(string $name): string|null
{
    try {
        return self::fromName($name);
    } catch (\ValueError $error) {
        return null;
    }
}


    public static function toArray(): array
    {
        return array_map(
            fn (self $enum) => $enum->toHtml(),
            self::cases()
        );
    }

    public static function casesBadge(): array
    {
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->toBadge() ;
        }
  
        return $array;
    }

    public static function casesLabel(): array
  {
    foreach (self::cases() as $case) {
      $array[$case->value] =$case->label();
    }

    
    return $array;
  }

    public static function toAssocArray(): array
    {
        $items = Arr::map(self::cases(), fn($enum) => $enum->toHtml());
        $keys = Arr::map(self::cases(), fn($enum) => $enum->value);
        return array_combine($keys, $items);
    }
}
