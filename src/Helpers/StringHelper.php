<?php
declare(strict_types=1);

namespace Simply\SyTemplate\Helpers;

/**
* @author André Teles
*/

class StringHelper 
{
    public function excerpt(string $text, int $length, string $tail='...'): string
    {
        $tail ?? '...';
        
        if( strlen($text) > $length ){
            return substr(preg_replace("/(<\/?)(\w+)([^>]*>)/", "", $text), 0, $length). $tail;
        } 
            
        return preg_replace("/(<\/?)(\w+)([^>]*>)/", "", $text);
    }
}