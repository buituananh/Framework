<?php
namespace System;

class Translator
{
    // this is the API endpoint, as specified by Google
    const ENDPOINT = 'http://translate.google.com/translate_a/t';

    // holder for you API key, specified when an instance is created
    protected $_apiKey;

    // translate the text/html in $data. Translates to the language
    // in $target. Can optionally specify the source language
    public static function Translate($data, $DestLang, $SrcLang = 'auto')
    {
        if($SrcLang == '') $SrcLang = 'auto';
        // this is the form data to be included with the request
        $values = array(
            'client' => 'p',
            'sl' => $SrcLang,
            'tl' => $DestLang,
            'hl' => 'auto',
            'ie' => 'UTF-8',
            'oe' => 'UTF-8',
            'sc' => 2,
            'ssel' => 0,
            'tsel' => 0,
            'q' => $data
        );
        
        $ch = curl_init();
        $post = http_build_query($values);
        curl_setopt ($ch, CURLOPT_URL, self::ENDPOINT);
        curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded"));
        
        // execute the HTTP request
        $json = curl_exec($ch);
          
        curl_close($ch);

        // decode the response data
        $data = json_decode($json, true);

        if (!is_array($data))
        {
            throw new \System\Exception('Translate fail');
        }

        $Text = '';        
        foreach ($data['sentences'] as $value) {
            $Text = $Text.$value['trans'];
        }
        return $Text;
    }    
}

