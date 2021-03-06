<?php

/**
 * Ehex
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2015 - 20.., Xamtax Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	Ehex (EX)
 * @author	Samson Iyanu (Xamtax Technnology)
 * @copyright	Copyright (c) Xamtax, Inc. (https://xamtax.com/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://ehex.xamtax.com
 * @since	Version 2.0
 * @filesource
 */





class DemoSchool{
    static function getDepartmentList(){
        return FileManager1::getDatasetFile("school_department.json", true);
    }
}


class DemoBook{
    static function getGenres(){ FileManager1::getDatasetFile("book_genre.json", true); }
}




class DemoProduct{


    /**
     * @return array
     * Sub Category item separated with coma means they share same property
     */
    static function getProductCategoryList() {
        $product_category = FileManager1::getDatasetFile("product_category.json", true);
        $product_category['Mobile Phones and Tablets']['brandType'] = self::getBrandMobilePhoneElectronicsList();
        $product_category['Electronics / Computer']['brandType'] = self::getBrandComputerElectronicsList();
        $product_category['Fashion']['brandType'] = self::getBrandFashionList();
        $product_category['Automobile (Vehicles)']['brandType'] = self::getBrandVehicleList();
        return $product_category;
    }


    static function getProductPropertyList(){
        return FileManager1::getDatasetFile("product_property.json", true);
    }




    static function getBrandMobilePhoneElectronicsList(){
        return FileManager1::getDatasetFile("product_phone_electronics_brand.json", true);
    }


    static function getBrandComputerElectronicsList(){
        return FileManager1::getDatasetFile("product_computer_electronics_brand.json", true);
    }

    static function getBrandFashionList(){
        return FileManager1::getDatasetFile("product_fashion_brand.json", true);
    }

    static function getBrandVehicleList(){
        return FileManager1::getDatasetFile("product_vehicle_brand.json", true);
    }

}




















/**
 * Class EasyDataSetGenerator is a Faker Class
 */
class DemoGenerator {


    /**
     * function to generate and print all N! permutations of $str. (N = strlen($str)).
     * $str = "hey";
     */
    public function permutateString($string){
        // function to swap the char at pos $i and $j of $str.
        $swap = function(&$str,$i,$j) {
            $temp = $str[$i];
            $str[$i] = $str[$j];
            $str[$j] = $temp;
        };

        $permute = null;
        $permute = function($str,$i,$n) use ($swap, $permute){
            if ($i == $n)
                print "$str\n";
            else {
                for ($j = $i; $j < $n; $j++) {
                    $swap($str,$i,$j);
                    $permute ($str, $i+1, $n);
                    $swap($str,$i,$j); // backtrack.
                }
            }
        };

        return $permute($string,0,strlen($string)); // call the function.
    }


    public static function numerify($numberString){
        return preg_replace_callback("/#/", function () {
            return rand(0, 9);
        }, $numberString);
    }

    public static function letterify($letterString){
        return preg_replace_callback("/\?/", function () {
            return chr(rand(97, 122));
        }, $letterString);
    }

    public static function bothify($string)
    {
        return self::letterify(self::numerify($string));
    }



    public static function words($num = 3){
        $words = FileManager1::getDatasetFile("word.json", true);
        shuffle($words);
        return array_slice($words, 0, $num);
    }



    /**
     * Return a random first name.
     *
     * @access public
     * @static
     * @return string First name
     */
    public static function firstName(){
        return Array1::pickOne(FileManager1::getDatasetFile("first_name.json", true));
    }

    /**
     * Return a random last name.
     *
     * @access public
     * @static
     * @return string Last name
     */
    public static function lastName(){
        return Array1::pickOne(FileManager1::getDatasetFile("last_name.json", true));
    }

    public static function quote(){
        return Array1::pickOne(FileManager1::getDatasetFile("quote.json", true));
    }


    /**
     * Generate a random full name.
     *
     * @access public
     * @static
     * @return string Full name
     */
    public static function fullName()
    {
        return sprintf(
            Array1::pickOne(array(
                '%1$s %2$s %3$s',
                '%2$s %3$s %4$s',
                '%2$s %3$s',
                '%2$s %3$s',
                '%2$s %3$s',
                '%2$s %3$s',
            )),
            self::namePrefix(),
            self::firstName(),
            self::lastName(),
            self::nameSuffix()
        );
    }

    /**
     * Return a random title, e.g. "Mr." or "Dr.".
     *
     * @access public
     * @static
     * @return string Prefix
     */
    public static function namePrefix()
    {
        return Array1::pickOne(array('Mr.', 'Mrs.', 'Ms.', 'Miss', 'Dr.'));
    }

    /**
     * Return a random name suffix, e.g. "Jr." or "MD".
     *
     * @access public
     * @static
     * @return string Suffix
     */
    public static function nameSuffix(){
        return Array1::pickOne(array('Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V', 'MD', 'DDS', 'PhD', 'DVM'));
    }


    /**
     * Generate a random sentence.
     *
     * Optionally, supply a base number of words to includes. The actual number of words in the
     * sentence will be a random number between $wordCount and $wordCount + 6.
     *
     * @access public
     * @static
     * @param int $wordCount Minimum number of words in the sentence (default: 4)
     * @return string Sentence
     */
    public static function sentence($wordCount = 4)
    {
        return ucfirst(implode(' ', self::words(rand($wordCount, $wordCount + 6)))) . '.';
    }

    /**
     * Generate random sentences.
     *
     * @access public
     * @static
     * @param int $sentenceCount Number of sentences (default: 3)
     * @return array Sentences
     */
    public static function sentences($sentenceCount = 3)
    {
        $ret = array();
        for ($i = 0; $i < $sentenceCount; $i++) {
            $ret[] = self::sentence();
        }
        return $ret;
    }

    /**
     * Generate a random paragraph.
     *
     * Optionally, supply a base number of sentences to includes. The actual number of sentences
     * in the paragraph will be a random number between $sentenceCount and $sentenceCount + 3.
     *
     * @access public
     * @static
     * @param int $sentenceCount Minimum number of sentences to includes (default: 3)
     * @return string Paragraph
     */
    public static function paragraph($sentenceCount = 3)
    {
        return implode(' ', self::sentences(rand($sentenceCount, $sentenceCount + 3)));
    }

    /**
     * Generate random paragraphs.
     *
     * @access public
     * @static
     * @param int $paragraphCount Number of paragraphs (default: 3)
     * @return array Paragraphs
     */
    public static function paragraphs($paragraphCount = 3)
    {
        $ret = array();
        for ($i = 0; $i < $paragraphCount; $i++) {
            $ret[] = self::paragraph();
        }
        return $ret;
    }


    /**
     * Generate a random IPv4 address.
     *
     * @access public
     * @static
     * @return string IPv4 address
     */
    public static function ipv4Address()
    {
        return implode('.', array(rand(0, 255), rand(0, 255), rand(0, 255), rand(0, 255)));
    }

    /**
     * Generate a random IPv4 address.
     *
     * @access public
     * @static
     * @param bool $onlineImage
     * @param int $onlineWidth
     * @param int $onlineHeight
     * @return string IPv4 address
     */
    public static function imageUrl($onlineImage = false, $onlineWidth = 200, $onlineHeight = 300){
        return !$onlineImage? HtmlAsset1::getImageThumb(): "https://picsum.photos/id/".(Math1::getRandomNumber(1000, 1))."/$onlineWidth/$onlineHeight";
    }


    /**
     * Generate a random US phone number.
     *
     * @access public
     * @static
     * @return string Phone number
     */
    public static function phoneNumber()
    {
        return self::numerify(Array1::pickOne(array(
            '###-###-####', '(###)###-####', '1-###-###-####', '###.###.####', '###-###-####', '(###)###-####',
            '1-###-###-####', '###.###.####', '###-###-#### x###', '(###)###-#### x###', '1-###-###-#### x###',
            '###.###.#### x###', '###-###-#### x####', '(###)###-#### x####', '1-###-###-#### x####',
            '###.###.#### x####', '###-###-#### x#####', '(###)###-#### x#####', '1-###-###-#### x#####',
            '###.###.#### x#####'
        )));
    }

    /**
     * Generate a random Year address.
     *
     * @access public
     * @param string $start
     * @return string year
     */
    public static function year($start = '20'){
        return $start . rand(0, 9) . rand(0, 9);
    }


    /**
     * Generate a random Year address.
     *
     * @access public
     * @static
     * @param string $start
     * @param int $min
     * @param int $max
     * @return string year
     */
    public static function number($start = '',$min = 0, $max = 9){
        return $start . rand($min, $max);
    }

    /**
     * Generate a random Year address.
     *
     * @access public
     * @static
     * @return string year
     */
    public static function boolean(){
        return Array1::pickOne([true, true, false]);
    }


    function changeNumbersToRandom($numberString) {
        return preg_replace_callback("/[0-9]/", function () {
            return rand(0, 9);
        }, $numberString);
    }


    public static function subject(){
        return Array1::pickOne(FileManager1::getDatasetFile("school_subject.json", true));
    }


    public static function password(){
        $pass = Array1::pickOne(FileManager1::getDatasetFile("school_subject.json", true));
    }



    public static function questionAndAnswer($Demo_QUESTION_TYPE = '-1', $optionCount_abcd = 4){
        if ($Demo_QUESTION_TYPE === Demo_QUESTION_TYPE::$type_random)
            $Demo_QUESTION_TYPE = Array1::pickOne(Demo_QUESTION_TYPE::all());

        // boolean or yes no
        if (($Demo_QUESTION_TYPE === Demo_QUESTION_TYPE::$type_boolean) || ($Demo_QUESTION_TYPE === Demo_QUESTION_TYPE::$type_yesNo))
            $optionCount_abcd = 2;


        $abcdOptions = [];
        if ($Demo_QUESTION_TYPE === Demo_QUESTION_TYPE::$type_abcd) {
            for ($i = 0; $i < $optionCount_abcd; $i++) {
                $abcdOptions[] = Array1::pickOne(['It is a ', 'simply known as ', 'Yes, it is ', '', '']) . self::sentence(4);
            }
        }


        $prefixArr = array(
            Demo_QUESTION_TYPE::$type_abcd => array(
                'question' => Array1::pickOne(['What is ', 'Define ', 'Explain ']),
                'option' => $abcdOptions,
            ),

            Demo_QUESTION_TYPE::$type_boolean => array(
                'question' => Array1::pickOne(['Is ', self::words(1)[0] . ' is also ', 'Answer True or No ', '', '', '']),
                'option' => ['True', 'False'],
            ),

            Demo_QUESTION_TYPE::$type_yesNo => array(
                'question' => Array1::pickOne(['Is ', self::words(1)[0] . ' is also ', 'Answer Yes or No, Yes or no if ', '', '', '']),
                'option' => ['Yes', 'No'],
            ),

            Demo_QUESTION_TYPE::$type_image => array(
                'question' => Array1::pickOne(['Select a ', 'Which of this is ', 'Identify  ',]) . self::sentence(2),
                'option' => [DemoGenerator::imageUrl(), DemoGenerator::imageUrl(), DemoGenerator::imageUrl(), DemoGenerator::imageUrl()],
            ),

        );


        $question = $prefixArr[$Demo_QUESTION_TYPE]['question'] . trim(self::sentence(10), '.') . '?';
        $options = [];
        for ($i = 0; $i < count($prefixArr[$Demo_QUESTION_TYPE]['option']); $i++) {
            $options[] = $prefixArr[$Demo_QUESTION_TYPE]['option'][$i];
        }


        return array('question' => $question, 'answer' => Array1::pickOne($options), 'options' => $options, 'type' => $Demo_QUESTION_TYPE);
    }


    static function email($name = null, $host = ['gmail', 'yahoo', 'ymail', 'rocketmail', 'hotmail', 'outlook']){
        $suffix = RegEx1::getSanitizeAlphaNumeric($name?$name:self::userName() );
        return $suffix."@".Array1::pickOne($host).".com";
    }

    static function userName($fullName = null){
        $suffix = Array1::pickOne( array_merge(range(01, 70), array('Sexy', 'Pretty', 'Money', 'Dollar')) );
        $name = $fullName? explode(' ', $fullName)[0]: self::firstName();
        return String1::convertWordToSlug($name. Array1::pickOne(['_', '']).$suffix);
    }

    static function placeAddress(){
        $num = range(01, 70);
        $alpha = range('A', 'Z');
        $no = Array1::pickOne($num).Array1::pickOne($num)    .   Array1::pickOne($alpha).Array1::pickOne($alpha);
        return 'No '.$no.' '.self::lastName().' street, '.Array1::pickOne(self::words(2)).', '.Array1::pickOne(DemoCountry::getNigeriaStateRegionList()).', '.Array1::pickOne(DemoCountry::getCountries()).'.';
    }


    static function getRandomBitcoinAddress(){
        $length = 34;
        $comb = '1P3uw7rmFvdug9vsJUF95XXeRS9hcHASmn34gLJ9NwNMDAC45V2Jk2gB7vbKiR99Fqes1ETjNhTMZyUTCQ2Bcp97zTb9jYVCjrzXJY1HCA7p2SkqsRAUpEwm8F43L6uPzEMTkT4m1BLFzpEpj3xD4kjqGqB5Tw1CKxWd8qKrVgspjEW5xcdD8UuSm583YBQAHJf59ZBzLH2i14tz2uid19ZwQMHaRVDyCRsgpoDqJvd3xQ';
        $newComb = str_shuffle($comb);
        $newBitAddr = substr($newComb, 0, $length);
        return trim($newBitAddr);
    }


    /**
     *
     * For Model Fake Data
     *  Use fillModelArray( Db2::getTableColumnAndTypeList($tableName, false) ) for LARAVEL
     *  Use fillModelArray( Db1::getTableColumnAndTypeList($tableName, false) ) for Ehex
     *
     * @param int $returnList
     * @param array $tableColumnAndDataTypeList
     * @param array $ignoreField
     * @param array $fieldAndPossibleValueArrayList,  Example $fieldAndPossibleValueArrayList = ['user_name'=>['dolapo', 'tobi'], 'age'=>['20','12', '65']]
     * @return array
     */
    static function fillModelArray($tableColumnAndDataTypeList = ['user_name'=>'varchar'], $ignoreField =['id'], $fieldAndPossibleValueArrayList = [], $returnList = 1){
        $data_list = [];
        foreach (range(0, $returnList-1) as $_){
            $newModel = [];
            $fieldList = Array1::except($tableColumnAndDataTypeList, $ignoreField);
            foreach ($fieldList as $columnName=>$columnType){
                if(isset($fieldAndPossibleValueArrayList[$columnName])) $newModel[$columnName] = Array1::pickOne(Array1::toArray($fieldAndPossibleValueArrayList[$columnName]));
                else $newModel[$columnName] = self::generateSmartValue($columnName, String1::convertMySqlDataTypeToPhp($columnType, 'string'));
            }
            $data_list[] = $newModel;
        }

        return  $data_list;
    }


    static function generateSmartValue($variableName, $dataType = "string"){
        $variableName = strtolower($variableName);

        // Basic Info
        if(String1::endsWith($variableName, 'id')) return Array1::pickOne(range(1, 10));
        else if(String1::containsMany(['user', 'name'], $variableName, 'and') && ($dataType == 'string')) return DemoGenerator::userName();
        else if(String1::containsMany(['first', 'name'], $variableName, 'and') && ($dataType == 'string')) return DemoGenerator::firstName();
        else if(String1::containsMany(['last', 'name'], $variableName, 'and') && ($dataType == 'string')) return DemoGenerator::lastName();
        else if(String1::containsMany(['full', 'name'], $variableName, 'and') && ($dataType == 'string')) return DemoGenerator::fullName();
        else if(String1::containsMany(['email'], $variableName) && ($dataType == 'string')) return DemoGenerator::email();
        else if(String1::containsMany(['number', 'phone', 'tel', 'office'], $variableName)) return DemoGenerator::phoneNumber();
        else if(String1::containsMany(['wallet', 'bit'], $variableName)) return DemoGenerator::getRandomBitcoinAddress();
        else if(String1::containsMany(['sex', 'gender'], $variableName)) return Array1::pickOne(['male', 'female']);
        else if(String1::containsMany(['address'], $variableName)) return DemoGenerator::placeAddress();
        else if(String1::containsMany(['password'], $variableName)) return '123456';//Hash::make('123456');
        else if(String1::containsMany(['occupation', 'work', 'job', 'position'], $variableName)) return DemoGenerator::lastName();

        // Bank
        else if(String1::containsMany(['bank', 'account', 'name'], $variableName, 'and') && ($dataType == 'string')) return DemoGenerator::fullName();
        else if(String1::containsMany(['bank', 'name'], $variableName, 'and') && ($dataType == 'string')) return Array1::pickOne(['zenite bank', 'diamond bank', 'keystone bank', 'first bank']);
        else if((String1::containsMany(['bank', 'account'], $variableName, 'and') || String1::containsMany(['bank', 'number'], $variableName, 'and')) && ($dataType == 'string')) return DemoGenerator::number('', 10,20);

        // Bank
        else if(String1::containsMany(['state'], $variableName) && ($dataType == 'string')) return Array1::pickOne(DemoCountry::getNigeriaState());
        else if(String1::containsMany(['city', 'region', 'place'], $variableName) && ($dataType == 'string')) return Array1::pickOne(DemoCountry::getNigeriaStateRegionList());
        else if(String1::containsMany(['country'], $variableName) && ($dataType == 'string')) return Array1::pickOne(DemoCountry::getCountries());


        // Date Time
        else if(String1::containsMany(['_at', '_on'], $variableName) || ($dataType === 'timestamp')) return date(DateManager1::$dateTimeInverse_asNumber);
        else if(String1::containsMany(['date'], $variableName) || ($dataType === 'date')) return date(DateManager1::$dateInverse_asNumber);
        else if(String1::containsMany(['time'], $variableName) || ($dataType === 'time')) return date(DateManager1::$time_as24Hours);
        else if(String1::containsMany(['year'], $variableName)) return self::year();


        // Others
        else if(String1::containsMany(['name', 'author', 'user'], $variableName, 'or')) return DemoGenerator::fullName();
        else if(String1::containsMany(['amount'], $variableName)) return DemoGenerator::number('', 10, 100);
        else if(String1::containsMany(['price'], $variableName)) return DemoGenerator::number('', 2000, 50000);
        else if(String1::containsMany(['about', 'message', 'description', 'body', 'info'], $variableName)) return DemoGenerator::sentence(200);

        // Website
        else if(String1::containsMany(['url', 'website', 'link', 'picture', 'image', 'img'], $variableName, 'or') && ($dataType == 'string')) return self::imageUrl().'?app=ehex';

        // datatype
        else if($dataType === 'string')  return DemoGenerator::sentence(ctype_upper($dataType)? 5: 1);
        else if($dataType === 'boolean')  return Array1::pickOne([0,1]);
        else if($dataType === 'integer')  return DemoGenerator::number('', 2000, 50000);
        else return null;
    }
}









class Demo_QUESTION_TYPE{
    static public $type_random = '-1';
    static public $type_abcd = '0';
    static public $type_boolean = '1';
    static public $type_yesNo = '2';
    static public $type_image = '3';


    static function all()
    {
        return [
            self::$type_abcd,
            self::$type_boolean,
            self::$type_yesNo,
            self::$type_image,
        ];
    }
}









class DemoCountry{


    /**
     * @return array get All Town In Nigeria
     */
    static function getNigeriaStateRegionList(){
        return FileManager1::getDatasetFile("nigeria_state_region.json", true);
    }


    /**
     * @param bool $countryNameOnly
     * @return array get World list of country
     */
    static function getCountries($countryNameOnly = false){
        $data =  FileManager1::getDatasetFile("country.json", true);
        return $countryNameOnly? array_values($data): $data;
    }



    /**
     * All Nigeria State
     * @param bool $stateNameOnly
     * @return array
     */
    static function getNigeriaState($stateNameOnly = false){
        $stateList = FileManager1::getDatasetFile("nigeria_state.json", true);
        return ($stateNameOnly) ? array_values($stateList) : $stateList;
    }


    /**
     * Country Number Code
     * @param bool $numberCodeOnly
     * @return array
     */
    static function getCountryPhoneNumberCode($numberCodeOnly = false){
        $data = FileManager1::getDatasetFile("country_phone_number_code.json", true);
        return $numberCodeOnly? array_values($data): $data;
    }


    /**
     * e.g
     *  $phone_number = DemoCountry::normalizePhoneNumber($_REQUEST['phone_number']);
        $_REQUEST['phone_number'] = String1::startsWith($phone_number, '+')?
            $phone_number :
            DemoCountry::getCountryPhoneNumberCode()[ $_REQUEST['country_code'] ].$phone_number;
     *
     *
     * @param $phoneNumber
     * @param string $countryAbbrev
     * @param string $addPrefix
     * @return string
     */
    static function normalizePhoneNumber($phoneNumber, $countryAbbrev = "NG", $addPrefix = "+"){
        $countryAbbrev = strtoupper($countryAbbrev);
        $purePhoneNumber = null;
        if(String1::startsWith($phoneNumber, "+")) $purePhoneNumber = String1::replaceStart($phoneNumber, "+", "");
        if(String1::startsWith($phoneNumber, self::getCountryPhoneNumberCode()[$countryAbbrev])) $purePhoneNumber = $phoneNumber;
        if(String1::startsWith($phoneNumber, "0")) $purePhoneNumber = String1::replaceStart($phoneNumber, "0", self::getCountryPhoneNumberCode()[$countryAbbrev]);
        return $purePhoneNumber? $addPrefix.$purePhoneNumber: $phoneNumber; ResultStatus1::make(!!$purePhoneNumber, !!$purePhoneNumber? "Successful": "Failed" , $purePhoneNumber? $addPrefix.$purePhoneNumber: $phoneNumber);
    }


}




