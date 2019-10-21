<?php
define('__EX_SITE_LANGUAGE_SESSION_KEY', '__lang');
/**
 * Created by PhpStorm.
 * User: samtax
 * Date: 08/07/2018
 * Time: 7:47 AM
 */


/************************************************
 *  Language
 *      Set A list of Language in config -> language()...
 *      Then at the beginning of your page, use set_language(from, to) to set a default language to use
 *          e,g set_language('en', 'ru');
 *      Usage
 *       get_language('signup')
 *       Or  __('signup')
 *          You can also translate a new word
 *          __('Hello world')
 ***********************************************
 * @param string $oldAndDefault_language
 * @param string $new_language
 * @param string $default_key
 */
    function set_language($oldAndDefault_language = 'en', $new_language = 'en', $default_key = 'default'){
        global $__ENV; $__ENV['__language_old'] = $oldAndDefault_language;$__ENV['__language_new'] = $new_language;
        $toLanguage = ($new_language === 'auto')? String1::isset_or($_SESSION[__EX_SITE_LANGUAGE_SESSION_KEY], $oldAndDefault_language): $new_language;    // default
        $__ENV['__language_content'] = String1::translateLanguageKeyAndManyValues(Config1::language(), $oldAndDefault_language, $toLanguage, true, $default_key);
    }

    /**
     * language translator
     * You can translate any words with ```String1::translateLanguage()``` or array of words in key value format ```String1::translateLanguageKeyValue()```
     * @see get_language()
     * @param $languageText_or_translateKey
     * @return mixed|null|string|string[]
     */
    function __($languageText_or_translateKey){ return get_language($languageText_or_translateKey); }

    /**
     * language translator
     * @see __()
     * @param $languageText_or_translateKey
     * @return mixed|null|string|string[]
     */
    function get_language($languageText_or_translateKey){
        global $__ENV;
        if(!isset($__ENV['__language_new']) || !isset($__ENV['__language_old'])) die(Console1::println('Error: To Use get_language(), Please init "set_language(default, new)" on your page or in your template'));
        $langList = Config1::language();
        $selectedLanguageList = $__ENV['__language_content'];
        if(isset($langList[$languageText_or_translateKey]) && isset($selectedLanguageList[$languageText_or_translateKey])) return $selectedLanguageList[$languageText_or_translateKey];
        else return String1::translateLanguage($languageText_or_translateKey, $__ENV['__language_old'], ($__ENV['__language_new'] === 'auto')? String1::isset_or($_SESSION[__EX_SITE_LANGUAGE_SESSION_KEY], $__ENV['__language_old']): $__ENV['__language_new'], true);
    }


