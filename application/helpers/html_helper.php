<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Include html_helper from system for adding functionality
 */
require_once __dir__ . '/../../system/helpers/html_helper.php';

if (!function_exists('href_nofollow')) {

    /**
     * @param string $content
     * @return string
     */
    function href_nofollow($content)
    {
        return preg_replace_callback('/<(a\s[^>]+)>/isU', 'seo_nofollow_replace', $content);
    }

}
if (!function_exists('kurs')) {
    function kurs($input = 0)
    {

        $cur_cb = file_get_contents("https://www.cbr-xml-daily.ru/daily_utf8.xml");

        preg_match_all("#<ValCurs Date=\"(.*)\" name=\"Foreign Currency Market\">#sU", $cur_cb,
            $_cur_date);
        preg_match_all("#<Valute ID=\"R01235\">.*<CharCode>(.*)</CharCode>.*<Value>(.*)</Value>.*</Valute>#sU",
            $cur_cb, $_usd);
        preg_match_all("#<Valute ID=\"R01239\">.*<CharCode>(.*)</CharCode>.*<Value>(.*)</Value>.*</Valute>#sU",
            $cur_cb, $_eur);

        $cur_date = $_cur_date[1][0];

        $eur = $_eur[2][0];
        $result = round($input / $eur, 2);
        $x=(string)$result;
        
        $result=str_replace(',','.',$x);
        return $result;

    }
}

if (!function_exists('ext_h1')) {
    function ext_h1($title = '',$url='')
    {

$CI = &get_instance();

                $suka = explode('/', $url);
                $url = $suka[0];


                $url2 = $suka[2];

                $CI->db->where('url', $url2);


                       $CI->db->where('type', 'category');

                        $CI->db->join('category', 'category.id = route.entity_id', 'left');
                        $q = $CI->db->get('route');


                        $rox = $q->row_array();
                        
                        if (is_array($rox)) {

                            $cat = mb_strtolower($rox['name'], "UTF-8");
                            $cat = 'для' . explode('для', $cat)[1];

                        }
                        return $title.' '.$cat;
                        

                

    }
}
if (!function_exists('kurs2')) {
    function kurs2($input = 0)
    {

        $cur_cb = file_get_contents("https://www.cbr-xml-daily.ru/daily_utf8.xml");

        preg_match_all("#<ValCurs Date=\"(.*)\" name=\"Foreign Currency Market\">#sU", $cur_cb,
            $_cur_date);
        preg_match_all("#<Valute ID=\"R01235\">.*<CharCode>(.*)</CharCode>.*<Value>(.*)</Value>.*</Valute>#sU",
            $cur_cb, $_usd);
        preg_match_all("#<Valute ID=\"R01239\">.*<CharCode>(.*)</CharCode>.*<Value>(.*)</Value>.*</Valute>#sU",
            $cur_cb, $_eur);

        $cur_date = $_cur_date[1][0];

        $eur = $_eur[2][0];
        $result = round($input * $eur, 2);
        
        $x=(string)$result;
        
        $result=str_replace(',','.',$x);

        return $result;

    }
}
if (!function_exists('get_filesize')) {
    function get_filesize($file)
    {

        $file = FCPATH . $file;
        // идем файл
        if (!file_exists($file)) {


            return $file;
        }
        //return "Файл  не найден";
        // теперь определяем размер файла в несколько шагов
        $filesize = filesize($file);
        // Если размер больше 1 Кб
        if ($filesize > 1024) {
            $filesize = ($filesize / 1024);
            // Если размер файла больше Килобайта
            // то лучше отобразить его в Мегабайтах. Пересчитываем в Мб
            if ($filesize > 1024) {
                $filesize = ($filesize / 1024);
                // А уж если файл больше 1 Мегабайта, то проверяем
                // Не больше ли он 1 Гигабайта
                if ($filesize > 1024) {
                    $filesize = ($filesize / 1024);
                    $filesize = round($filesize, 1);
                    return $filesize . " ГБ";
                } else {
                    $filesize = round($filesize, 1);
                    return $filesize . " MБ";
                }
            } else {
                $filesize = round($filesize, 1);
                return $filesize . " Кб";
            }
        } else {
            $filesize = round($filesize, 1);
            return $filesize . " байт";
        }
    }
}


if (!function_exists('seo_nofollow_replace')) {

    /**
     * @param array $match
     * @return string
     */
    function seo_nofollow_replace($match)
    {
        $CI = &get_instance();

        list($original, $tag) = $match;

        if (strpos($tag, 'nofollow')) {
            return $original; // уже есть
        } elseif (strpos($tag, $CI->input->server('SERVER_NAME')) || strpos($tag,
        'href="/') || strpos($tag, "href='/")) {
            return $original; // исключения
        } else {
            return "<$tag rel=\"nofollow\">";
        }
    }

}


if (!function_exists('create_tag')) {

    /**
     * Creates a html tag.
     * @param string $tagName
     * @param string $innerText
     * @param array $attributes
     * @return string
     */
    function create_tag($tagName, $innerText, array $attributes = [])
    {
        $attributesString = ' ';
        foreach ($attributes as $name => $value) {
            $attributesString .= "{$name}='{$value}' ";
        }
        $attributesString = rtrim($attributesString, ' ');
        return "<{$tagName}{$attributesString}>{$innerText}</{$tagName}>";
    }

}

if (!function_exists('form_property_select')) {

    /**
     *
     * @param string $name
     * @param array $data
     * @param array|string $selected
     * @param string $multiple
     * @return string
     */
    function form_property_select($name, $data, $selected, $multiple)
    {
        $selected = !is_array($selected) ? [$selected] : $selected;
        $multiple = $multiple === 'multiple' ? 'multiple="multiple"' : '';
        $result = "<select name='$name' $multiple>";

        if (!$multiple) {
            $result .= "<option value='' >- " . lang('Unspecified') . ' -</option>';
        }

        $data = array_map('htmlspecialchars_decode', $data);
        $selected = array_map('htmlspecialchars_decode', $selected);

        foreach ($data as $option) {
            $selectedAttr = in_array($option, $selected, true) ? 'selected="selected"' : '';
            $option_value = htmlspecialchars($option, ENT_QUOTES, ini_get('default_charset'), false);
            $option = html_entity_decode($option);
            if (strpos($option_value, '"') !== false) {
                $result .= "<option value='$option_value' $selectedAttr>$option</option>";
            } else {
                $result .= '<option value="' . $option_value . '"' . $selectedAttr . '>' . $option .
                    '</option>';
            }
        }

        $result .= '</select>';

        return $result;
    }

}
