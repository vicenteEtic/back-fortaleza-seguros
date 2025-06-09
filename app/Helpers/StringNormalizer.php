<?php

namespace App\Helpers;

class StringNormalizer
{
    public static function normalize($string)
    {
        $string = str_replace(['Á', 'À', 'Â', 'Ã', 'Ä'], 'A', $string);
        $string = str_replace(['É', 'È', 'Ê', 'Ë'], 'E', $string);
        $string = str_replace(['Í', 'Ì', 'Î', 'Ï'], 'I', $string);
        $string = str_replace(['Ó', 'Ò', 'Ô', 'Õ', 'Ö'], 'O', $string);
        $string = str_replace(['Ú', 'Ù', 'Û', 'Ü'], 'U', $string);
        $string = str_replace(['Ç'], 'C', $string);
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
        return $string;
    }

    public static function validateDomain($attribute, $value, $fail)
    {
        $blacklist = [
            'www', 'http', 'https', 'arquivo', 'arquivos', 'sgbr', 'sgbrsistemas', 'sgmaster', 'certomei',
            'certosistemas', 'meusg', 'ftp', 'site', 'anus', 'baba-ovo', 'babaovo', 'babaca', 'bacura', 'bagos', 'baitola',
            'bebum', 'besta', 'bicha', 'bisca', 'bixa', 'boazuda', 'boceta', 'boco', 'boiola', 'bolagato', 'boquete', 'bolcat',
            'bosseta', 'bosta', 'bostana', 'brecha', 'brexa', 'brioco', 'bronha', 'buca', 'buceta', 'bunda', 'bunduda', 'burra', 'burro',
            'busseta', 'cadela', 'caga', 'cagado', 'cagao', 'cagona', 'canalha', 'caralho', 'casseta', 'cassete', 'checheca', 'chereca',
            'chibumba', 'chibumbo', 'chifruda', 'chifrudo', 'chota', 'chochota', 'chupada', 'chupado', 'clitoris', 'cocaina', 'coca-na',
            'coco', 'corna', 'corno', 'cornuda', 'cornudo', 'corrupta', 'corrupto', 'cretina', 'cretino', 'cruz-credo', 'culhao', 'curalho',
            'cuzao', 'cuzuda', 'cuzudo', 'debil', 'debiloide', 'defunto', 'demonio', 'difunto', 'doida', 'doido', 'egua', 'escrota', 'escroto',
            'esporrada', 'esporrado', 'esporro', 'estupida', 'estupidez', 'estupido', 'fedida', 'fedido', 'fedor', 'fedorenta', 'feia', 'feio',
            'feiosa', 'feioso', 'feioza', 'feiozo', 'felacao', 'fenda', 'foda', 'fodao', 'fode', 'fodida', 'fodido', 'fornica', 'fudendo',
            'fudecao', 'fudida', 'fudido', 'furada', 'furado', 'furao', 'furnica', 'furnicar', 'furo', 'furona', 'gaiata', 'gaiato', 'gay',
            'gonorrea', 'gonorreia', 'gosma', 'gosmenta', 'gosmento', 'grelinho', 'grelo', 'homo-sexual', 'homosexual', 'homossexual', 'idiota',
            'idiotice', 'imbecil', 'iscrota', 'iscroto', 'ladra', 'ladrao', 'ladroeira', 'ladrona', 'lalau', 'leprosa', 'leproso', 'lesbica',
            'macaca', 'macaco', 'maconha', 'machona', 'machorra', 'manguaca', 'masturba', 'meleca', 'merda', 'mija', 'mijada', 'mijado', 'mocrea',
            'mocreia', 'xaninha', 'penis', 'porno', 'putao', 'putona', 'sexo', 'sgmaster', 'sgmasterweb', 'sgmw', 'piroca', 'xereca', 'xerequinha',
            'fdp', 'filhodaputa', 'puteiro', 'putaria', 'putinha', 'milf', 'stdb', 'pvdb', 'undefined'
        ];


        $urlExata = ['cu', 'puta', 'hom', 'pp', 'mijo', 'cachorro', 'cachorra', 'bd', 'pinto', 'drogas', 'teste'];
        $lowercase = strtolower($value);
        $special_chars = preg_match('/[^a-z0-9]/', $lowercase);

        if (in_array($value, $urlExata)) {
            $fail("O campo $attribute é uma palavra proibida");
        }
        foreach ($blacklist as $string) {
            if (strpos($lowercase, $string) !== false) {
                $fail("O campo $attribute contém uma palavra proibida.");
            }
        }
        if ($special_chars) {
            $fail("O campo $attribute não deve conter caracteres especiais.");
        }
        if ($value !== $lowercase) {
            $fail("O campo $attribute deve estar todo em minúsculas.");
        }
    }
}