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





/*********************************************************************************************************************************************************************************
 *
 * [ FORM ]
 *
 *********************************************************************************************************************************************************************************/

class HtmlForm1{
    public static $FLAG_SHOW_EXEC_ARRAY = false;
    public static $BREAK_DELIMITER = '<h4 style="border-bottom: 2px solid #9f9f9f;color: #757575;margin-top:45px;padding-bottom:5px;"> %s </h4><br/>';
    public $tagName = null;

    /**
     * @var Model1
     */
    public $model = null;
    public $title = [];
    public $allowFields = [];
    public $denyFields = [];
    public $breakFields = [];

    public $manualModel = [];

    public $fieldGroup_equals_properties = [];
    public $fieldName_equals_properties = [];
    public $fieldName_equals_displayName = [];
    public $tag_equals_attribute = [];


    /**
     * HtmlForm1 constructor.
     * @param Model1 $model1
     * @param array $visibleField
     * @param array $invisibleField
     * @param array $hiddenField
     */
    public function __construct($model1, $visibleField = [], $invisibleField = [], $hiddenField = ['id', 'created_at', 'updated_at', 'last_login_at']) {
        $this->setModel($model1)
            ->setTitle((($model1 && String1::isset_or($model1->{'id'}, 0) > 0)? 'Update ': 'New ').  String1::convertToCamelCase(String1::convertToSnakeCase(((string) get_class($model1))), ' '))
            ->setInvisibleField($invisibleField)
            ->setVisibleField($visibleField)
            ->setHiddenField($hiddenField);
    }


    function addFields(Array $fieldName_equals_defaultValue = []){ foreach ($fieldName_equals_defaultValue as $key=>$value) $this->manualModel[$key] = $value; return $this; }


    function addBreakBeforeField(Array $fieldName_equals_breakTitle = []){ foreach ($fieldName_equals_breakTitle as $key=> $value) $this->breakFields[$key] = $value; return $this;  }

    function setModel($model1){ $this->model = $model1; return $this; }

    function setTitle($title){ $this->title = $title; return $this; }

    function setVisibleField(array $fieldNameList = []){ $this->allowFields = array_merge($this->allowFields, static::arrayNormalizer($fieldNameList)); return $this;  }

    //function setFieldOrder(array $fieldNameList = []){ $this->fields = array_merge($this->allowFields, ...); return $this;  }

    function setHiddenField(array $fieldNameList = []){ $this->setSimilarFieldAttribute($fieldNameList, ['type'=>'hidden']); return $this; } //foreach ($fieldNameList as $field) $this->setFieldAttribute([$field=>['type'=>'hidden']]);  return $this;

    function setInvisibleField(array $fieldNameList = []){  $this->denyFields = array_merge($this->denyFields, static::arrayNormalizer($fieldNameList)); return $this;  }

    function setLabelNames(array $fieldName_equals_displayName = ['oldName'=>'newName', ]){ $this->fieldName_equals_displayName = array_merge($this->fieldName_equals_displayName, $fieldName_equals_displayName); return $this;  }

    /**
     * Set Property of Field, Like Html Attribute Property, All Control Make use of value attr for there value
     * multi attribute is allowed with coma separated, e.g
     * ->setFieldAttribute([
     *      'about, address'=>['style'=>'height:200px;'],
     *      'phone_number'=>['type'=>'number']
     * ])
     * @param array $fieldName_equals_properties
     * @return $this
     */
    function setFieldAttribute(Array $fieldName_equals_properties = ['user_name'=>['type'=>'text', 'tag'=>'input', 'style'=>'color:black']] ){ foreach ($fieldName_equals_properties as $field_key_orKeys => $field_value)  foreach (explode(',', $field_key_orKeys) as $key) $this->fieldName_equals_properties[trim($key)]  = $field_value; return $this; }

    function setValue($fieldName, $fieldValue){ $this->fieldName_equals_properties[$fieldName]['value'] = $fieldValue; return $this;}

    function setSimilarFieldAttribute(array $fieldNameList = ['user_name', 'full_name'], array $attribute_equals_value = ['type'=>'text', 'required']){ foreach ($fieldNameList as $field) $this->setFieldAttribute([$field=>$attribute_equals_value]);  return $this; }

    function setFieldGroupAttribute(Array $fieldName_equals_properties = ['user_name'=>['class'=>'form-group']] ){ $this->fieldGroup_equals_properties = array_merge($this->fieldGroup_equals_properties, $fieldName_equals_properties); return $this;  }

    /**
     * @param bool $filter_hidden_out
     * @return array|mixed
     */
    function getFields($filter_hidden_out = false){
        $this->isModelSet();

        // process $this->models value
        $allColumns = array_merge($this->manualModel, $this->model->toArray());//get_class($this->models)::toColumnValueArray());
        if(!$filter_hidden_out) return $allColumns;


        // allow
        if(!empty($this->allowFields)) $allColumns = Array1::getCommonField(null, $allColumns, array_flip($this->allowFields));

        // deny
        if(!empty($this->denyFields)) $allColumns = Array1::removeKeys($allColumns,  $this->denyFields);
        return $allColumns;
    }

    /**
     *
     */
    private function isModelSet(){ if((!$this->model) || (!$this->model instanceof Model1) ) die('Error, Model1 Object Not Valid/Set!. '); }


    /**
     * @param string|array $value
     * @return array
     *  Explode Column List if String or leave if Array
     */
    private static function arrayNormalizer($value = ''){ return is_array($value)? $value:  (($value && !empty($value))? explode(',', $value): []); }



    static function process($btnSubmitName = 'btn_submit', $modelClass = 'User', $id = "-1", $uniqueColumn = []){
        if(isset($_REQUEST[$btnSubmitName])){
            // save or Update Data
            $result = ($id > 0)? $modelClass::find($id)->update($_REQUEST): $modelClass::insert($_REQUEST, $uniqueColumn);
        }
    }

    /**
     *  Display All Allowed Model Field
     *
     * @param null $overrideTag This will force all element to display will the tag[ could be 'label', 'input', 'textarea', or other control tagName]
     * @param string $defaultValueIfNull
     * @return null|string
     */
    function render($overrideTag = null, $defaultValueIfNull = ''){
        $this->tagName = $overrideTag;
        $allColumns = $this->getFields(true);

        if(String1::isset_or($this->title, null)) echo '<h3>'.$this->title.'</h3>';
        foreach ($allColumns as $key=>$value ) {
            if(isset($this->breakFields[$key])) echo sprintf(static::$BREAK_DELIMITER, $this->breakFields[$key]);
            echo $this->makeTagAndFormType($key, $value, (isset($this->model->{$key})?$this->model->{$key}: String1::isset_or($defaultValueIfNull, $value))); // $allControl .= $this->makeTagAndFormType($key, $value);
        }
        return '';
    }


    function renderAsArray($listAsMenu = false, $renameOldName_equals_newName = []){
        $dataArray = [];
        $allColumns = $this->getFields(true);

        if(!empty($renameOldName_equals_newName))  {
            $allColumns = Array1::replaceKeyNames($allColumns, $renameOldName_equals_newName);
            $this->fieldName_equals_properties = Array1::replaceKeyNames($this->fieldName_equals_properties, $renameOldName_equals_newName);
        }

        foreach ($allColumns as $variableName=>$value ){
            $control_attr = (isset($this->fieldName_equals_properties[ $variableName]))?  $this->fieldName_equals_properties[$variableName]: [];
            $keyData    = trim(($listAsMenu)? ucwords(String1::convertToCamelCase($variableName, ' ')): $variableName);
            $valueData  =  String1::isset_or($control_attr['value'], $value);   //String1::isSetOr(, (isset($this->model->{$variableName})?$this->model->{$variableName}: String1::isset_or($defaultValueIfNull, $value)));
            $dataArray[$keyData] = $valueData;
        }

        return Object1::toArrayObject(true, $dataArray);
    }



    function renderTable(array $column_list = [], $column_list_as_invisible = false, $whereRawClause = '', callable $onCreate = null, callable $onUpdate = null, callable $onDelete = null){
        echo '<div class="panel panel-default"> 
                <div class="panel-heading">'.$this->title.'</div>
                   <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">';


        if(!$column_list) $column_list = array_keys($this->getFields(true));
        else $column_list = ($column_list_as_invisible)? array_diff( array_keys($this->getFields(false)), $column_list): $column_list;

        $data = get_class($this->model)::selectMany(true, $whereRawClause, $column_list);

        // Header
        echo "<thead><tr><th>#</th>"; foreach ($column_list as $column_name ){ echo "<th>$column_name</th>"; } echo "</tr></thead>";


        // Body
        echo "<tbody>";
            foreach ($data as $rowIndex=>$rowArray ) {
                echo "<tr><td>".($rowIndex + 1)."</td>"; foreach ($column_list as $column_name ){ echo "<td>$rowArray[$column_name]</td>"; }; echo "</tr>";
            }
        echo "</tbody>";
        echo '    </table>
                </div>
              </div>
            </div>';
        return '';
    }




    private function dataType($variableName = '', $variableValue = ''){
        // variable data type
        ///$modelClass = get_class( $this->model ); //->getModel() // ->toArray()
        //dd($variableValue, 'jgdahkfa');
        //$dataType = gettype(   isset((new $modelClass)->{$variableName})?   $variableValue : (new $modelClass)->{$variableName}   );
        $dataType = gettype(   @$this->model->toArray()[$variableName]  );

        if($dataType === 'double' || $dataType === 'integer') $dataType = 'number';
        else if( $dataType === 'boolean' )  $dataType = 'checkbox';
        else if( $dataType === 'string' )  $dataType = 'text';


        // auto assistance
        if(String1::endsWith($variableName, '_at') || String1::endsWith($variableName, '_datetime')) {$dataType = 'datetime-local'; }
        else if(String1::endsWith($variableName, 'password')) {$dataType = 'password'; }
        //else if($dataType == 'NULL'){
        if(String1::endsWith($variableName, '_date')) $dataType = 'date';
        else if(String1::endsWith($variableName, '_time')) $dataType = 'time';
        //}
        return $dataType;
    }


    private function makeTagAndFormType($variableName = '', $variableValue = '', $defaultValue = ''){


        // if type not set in $control_attr['tag'] And $control_attr['type'] not set, then
        $dataType = $this->dataType($variableName, $variableValue);

        switch ($dataType){

            case 'date': case 'time': case 'datetime-local': case 'password': case 'checkbox':

            case 'double': case 'integer':  case 'boolean':   case 'text': case 'number':     $inputType = $dataType;     $tagName = 'input'; break;

            case 'array':                                                                     $inputType = 'select';      $tagName = 'select'; break;

            default:                                                                          $inputType = 'textarea';    $tagName = 'textarea';
        }


        // get control attribute
        $control_attr = (isset($this->fieldName_equals_properties[$variableName]))?  $this->fieldName_equals_properties[$variableName]: [];
        $control_group_attr = (isset($this->fieldGroup_equals_properties[$variableName]))?  $this->fieldGroup_equals_properties[$variableName]: [];

        // init some field
        $control_attr['tag'] = String1::isset_or($control_attr['tag'], $tagName);
        $control_attr['type'] = String1::isset_or($control_attr['type'], $inputType);
        $control_attr['name'] = String1::isset_or($control_attr['name'], $variableName);
        $control_attr['value'] = String1::isset_or($control_attr['value'], $defaultValue);
        $displayName = String1::isset_or($this->fieldName_equals_displayName[$variableName], String1::convertToCamelCase($control_attr['name'], ' '));


        // fix
        if($this->tagName) $control_attr['tag'] = $this->tagName;
        $control_attr['tag'] = strtolower($control_attr['tag']);

        // check if tag
        $isForTag = function ($control_attr, $tag){
            return (  $control_attr['tag'] === $tag || $control_attr['type'] === $tag );
        };




        // form control type
        if(static::$FLAG_SHOW_EXEC_ARRAY) {Console1::println(['<strong>-'.$displayName.'-</strong>'=>$control_attr['type'], 'control-attribute'=>$control_attr, 'group-attribute'=>$control_group_attr], false, $displayName);  return '';};

        if( $isForTag($control_attr, 'label')) return static::addLabel($displayName, ($dataType == 'checkbox')? String1::toBoolean($control_attr['value'], 'Yes', 'No'): $control_attr['value'] );
        else if($isForTag($control_attr, 'select') || is_array($control_attr['value']) ) return static::addSelect($displayName, array_merge($control_attr, (!isset($control_attr['selected'])? ['selected'=>$variableValue]: [])), $control_group_attr);
        else if($isForTag($control_attr, 'textarea') ) return static::addTextArea($displayName, $control_attr, $control_group_attr);
        else if($isForTag($control_attr, 'input')) {
            return static::addInput($displayName, $control_attr, $control_group_attr);
        }


        else return static::make($displayName, $control_attr['tag'], $control_attr['value'], $control_attr, $control_group_attr);
    }


































    public static $USE_REQUEST_VALUE = true;
    public static $AUTO_PLACEHOLDER = true;
    public static $ENABLE_TOGGLE_PASSWORD_INPUT = false;
    public static $AUTO_ID_SET_FROM_NAME = true;
    public static $AUTO_LABEL = false;
    public static $THEME = 'bootstrap';
    public static $AS_VERTICAL = true;

    public static $THEME_FORM_INPUT_CLASS = 'form-control'; //form-control-lg  input-lg
    public static $THEME_LABEL_CLASS = 'control-label';
    public static $THEME_FORM_GROUP_CLASS = 'form-group';
    public static $THEME_COL_CLASS = 'col col-';
    public static $THEME_BUTTON_CLASS = 'btn btn-'; // btn-lg

    private static function makeColSize($size = 'md-4'){ return static::$THEME_COL_CLASS.$size.' '; }

    private static function makeButton($colorType = 'primary'){ return static::$THEME_BUTTON_CLASS.$colorType.' '; }


    static function open ($actionOrControllerMethod="HtmlForm1@process()", $formAttribute = ['']){
        $option = ['class'=>'', 'method'=>'POST', 'enctype'=>'multipart/form-data', 'action'=>String1::contains('/', $actionOrControllerMethod)? $actionOrControllerMethod: Form1::callController($actionOrControllerMethod), 'accept-charset'=>'UTF-8'];
        $attr = Array1::toHtmlAttribute(array_merge($option, $formAttribute));
        $attr = (!$formAttribute)? '': $attr;
        return "<form  $attr>".form_token();
    }


    static function close ($submitValue = 'Submit', $submitButtonAttribute = ['name'=>'btn_submit']) { if(empty($submitValue)) return "</form>"; return '<div class="row"><div class="'.static::makeColSize('md-12').'">'.static::submit($submitValue, $submitButtonAttribute).'</div></div></form>'; }

    //Submit Button
    static function submit ($value = '', $inputAttribute = ['name'=>'btn_submit']){
        $option = ['class'=>static::makeButton('primary')/*.static::makeColSize('md-4')*/, 'name'=>'btn_submit', 'type'=>'submit'];
        $attr = Array1::toHtmlAttribute(array_merge($option, $inputAttribute));
        $attr = (!$inputAttribute)? '': '<button '.$attr.'>'.$value.'</button>';
        return $attr;
    }

    //Add component
    static function addLabel($title = '', $value = ''){
        $rowClass = (static::$AS_VERTICAL? static::makeColSize('md-6'):  static::makeColSize('md-12')); //control-label
        $rowStyle = (static::$AS_VERTICAL? 'margin-bottom:20px;width: 50% !important;float: left;':  'width: 100%'); //control-label
        $labelRight = (static::$AS_VERTICAL?'text-align: right':'');
        $labelValue = (static::$AS_VERTICAL? '<strong>'.$title.'</strong> &nbsp;&nbsp; : &nbsp;&nbsp;': '');

        // resolve value
        $value = (is_array($value) || $value instanceof  ArrayAccess)? (isset($value['value'])? $value['value']:''): $value;

        $pageContents = <<< EOSTRING
            <div class="row" style="border:0 solid gray; height:auto; overflow-x: auto">
                <div class="$rowClass" style="$rowStyle $labelRight"> $labelValue </div>
                <div class="$rowClass" style="$rowStyle"> $value </div>
            </div>
EOSTRING;

        return self::outputAs($pageContents);
    }



    //Add component
    /**@Raw*/
    static function add($name = '', $input_raw_code){
        if(empty($name)) return $input_raw_code;

        $pageContents = <<< EOSTRING
        <div class="form-group">
            <label class="control-label">$name</label>
            $input_raw_code
        </div> 
EOSTRING;
        return self::outputAs($pageContents);
    }


    //Add component

    /**
     * Turn Simple Array to Html Control and Assign Attribute
     *
     * @param string $labelName
     * @param string $tagName
     * @param string $data
     * @param array $inputAttribute
     * @param array $formGroupAttribute
     * @return string
     */
    static function make($labelName = null, $tagName = '', $data = '', $inputAttribute = [], $formGroupAttribute = []){


        // if checkbox, remove form-control
        $inputType = String1::isset_or($inputAttribute['type'], null);
        $isCheckBox = ( $inputType === 'checkbox' || $inputType === 'radio');
        $inputAttribute['class'] = $isCheckBox && isset($inputAttribute['class'])? String1::replace($inputAttribute['class'], static::$THEME_FORM_INPUT_CLASS, ''): String1::isset_or($inputAttribute['class']);

        // init control value with old()
        if(!isset($inputAttribute['value']) && isset($inputAttribute['name']) && !empty(old($inputAttribute['name']))) {
            if($tagName == "input") $inputAttribute['value'] = old($inputAttribute['name']);
            else if($tagName == "select") $inputAttribute['selected'] = old($inputAttribute['name']);
            else if($tagName == "textarea") $data = old($inputAttribute['name']);
        }

        // Control
        unset($inputAttribute['label']);
        $attr = @Array1::toHtmlAttribute($inputAttribute);
        $attr = (!$inputAttribute)? '': ((strtolower(trim($tagName)) === 'input')? "<$tagName $attr />": "<$tagName $attr>$data</$tagName>");

        // Label
        if(empty($labelName) && !static::$AUTO_LABEL) return $attr;
        else $labelAttr =  @Array1::toHtmlAttribute(['class'=>static::$THEME_LABEL_CLASS, 'for'=>String1::isset_or($inputAttribute['name'], '')]);
        $makeLabelName = @String1::convertToCamelCase(rtrim($inputAttribute['name'], "[]"), ' '); $labelName = String1::isset_or($labelName, String1::isset_or($makeLabelName, ''));

        // output
        $formGroupAttribute['id'] = isset($formGroupAttribute['id'])? $formGroupAttribute['id']: String1::if_empty($inputAttribute['id'], Math1::getUniqueId(), $inputAttribute['id'].'_group');
        $optionGroupAttr = @Array1::toHtmlAttribute(@array_merge(['class'=>static::$THEME_FORM_GROUP_CLASS], $formGroupAttribute));
        $pageContents = "<div $optionGroupAttr> <label $labelAttr>".($isCheckBox? " &nbsp; ".$attr: '')."$labelName</label> ".($isCheckBox? '': $attr)."</div> ";
        return self::outputAs($pageContents);
    }


    static function outputAs($data = null){
        if(self::$FLAG_SHOW_EXEC_ARRAY) Console1::println( (new SimpleXMLElement($data) ));
        return $data;
    }






    //Upload File Button
    static function addFile($labelName = null, $inputAttribute = [], $formGroupAttribute = []){
        return self::addInput($labelName,  array_merge(['type'=>'file'], $inputAttribute), $formGroupAttribute);
    }

    //Add Hidden
    static function addHidden($name_orNameValueList, $value = ''){
        if(is_array($name_orNameValueList)) {
            $pie = ''; foreach ($name_orNameValueList as $keyName=>$keyValue) $pie .= self::addHidden($keyName, $keyValue); return $pie;
        }

        $value = (is_array($value) || $value instanceof  ArrayAccess)? (isset($value[$name_orNameValueList])? $value[$name_orNameValueList]:''): $value;
        return  self::outputAs("<input type='hidden' name='$name_orNameValueList' value='$value' />");
    }



    /**
     * get value from $_REQUEST or ArrayData Passed to Control Value ($userInfo)
     * @param array $attribute
     * @return array
     */
    static function extractValue($attribute = ['value' => null, 'name'=>null]){
        $dataArray = (static::$USE_REQUEST_VALUE && (@isset($attribute['name']) && @isset($_REQUEST[$attribute['name']]))) ? $_REQUEST : (@isset($attribute['value'])? $attribute['value']: null);
        if ($dataArray && @isset($attribute['name']) && (is_array($dataArray) || ($dataArray instanceof ArrayAccess))) {
            if (@isset($dataArray[$attribute['name']]) && ($dataArray[$attribute['name']] !== 'NULL')  && !@String1::is_empty($dataArray[$attribute['name']])) $attribute['value'] = $dataArray[$attribute['name']];
            else $attribute['value'] = '';
        }

        // add placeholder
        if(static::$AUTO_PLACEHOLDER && !@isset($attribute['placeholder']) && @isset($attribute['name'])) $attribute['placeholder'] =  strtolower(preg_replace("/[^a-zA-Z0-9 ]+/", "", String1::convertToCamelCase($attribute['name'], ' ')));
        // add id
        if(static::$AUTO_ID_SET_FROM_NAME && !@isset($attribute['id']) && @isset($attribute['name'])) $attribute['id'] =  $attribute['name'];
        return $attribute;
    }


    /**
     * Add Input (default text)
     *  add toggle=true for password input to show toggleable password field... or use HtmlForm1::addPassword(...) instead
     * @param null $labelValueOrAttr
     * @param array $inputAttribute
     * @param array $formGroupAttribute
     * @return null|string
     *
     */
    static function addInput($labelValueOrAttr = null, $inputAttribute = [], $formGroupAttribute = []){
        // for password widget
        if(String1::isset_or($inputAttribute['toggle'], self::$ENABLE_TOGGLE_PASSWORD_INPUT) && (strtolower(String1::isset_or($inputAttribute['type'], null)) == 'password'))  Page1::printOnce(" 
        <style>  .ex_flag_show_password{ position: absolute; top: 50%; right: 10px; z-index: 1; color: #f36c01; margin-top: -10px; cursor: pointer; transition: .3s ease all; }  .ex_flag_show_password:hover{color: #333333;} </style>
        <script>  $(function(){  $('input[type=\"password\"]').parent().append('<span class=\"ex_flag_show_password\" style=\"padding:4px;margin:0 auto; \">See</span>').css(\"position\", \"relative\");  $('.ex_flag_show_password').click(function(){ $(this).text($(this).text() === \"See\" ? \"Hide\" : \"See\");     $(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; }); });    });  </script> ", 'ex_flag_show_password');

        // init fields
        if(is_array($labelValueOrAttr)) { $inputAttribute = $labelValueOrAttr; $labelValueOrAttr = String1::isset_or($inputAttribute['label'], ''); }
        if(isset($inputAttribute['type']) && ($inputAttribute['type'] === 'hidden')) return self::addHidden(String1::isset_or($inputAttribute['name'], ''), String1::isset_or($inputAttribute['value'], ''));

        // init attribute
        $inputAttribute = array_merge(['class'=>static::$THEME_FORM_INPUT_CLASS, 'type'=>'text'], static::extractValue(array_merge(['label'=>$labelValueOrAttr], $inputAttribute)));
        $groupAttribute = array_merge(['class'=>static::$THEME_FORM_GROUP_CLASS], $formGroupAttribute);

        // Control
        return static::make($inputAttribute['label'], 'input', '', $inputAttribute, $groupAttribute);
    }




    /**
     * this enable toggle attribute for input field and type=password
     * @param null $LabelValueOrAttr
     * @param array $inputAttribute
     * @param array $formGroupAttribute
     * @return null|string
     *
     */
    static function addPassword($LabelValueOrAttr = null, $inputAttribute = [], $formGroupAttribute = []){ return self::addInput($LabelValueOrAttr, array_merge($inputAttribute, ['type'=>'password', 'toggle'=>'true']), $formGroupAttribute); }


    /**
     * Add TextArea component
     * @param null $LabelValueOrAttr
     * @param array $textAreaAttribute
     * @param array $formGroupAttribute
     * @return string
     */
    static function addTextArea($LabelValueOrAttr = null, $textAreaAttribute = [], $formGroupAttribute = []){
        // init
        if(is_array($LabelValueOrAttr)) { $textAreaAttribute = $LabelValueOrAttr; $LabelValueOrAttr = String1::isset_or($textAreaAttribute['label'], ''); }
        $newOption = array_merge(['class'=>static::$THEME_FORM_INPUT_CLASS], static::extractValue(array_merge(['label'=>$LabelValueOrAttr], $textAreaAttribute)));
        $textAreaContent = String1::isset_or($newOption['value'], ''); unset($newOption['value']);
        $groupAttribute = array_merge(['class'=>static::$THEME_FORM_GROUP_CLASS], $formGroupAttribute);

        // Control
        return static::make($newOption['label'], 'textarea', $textAreaContent, $newOption, $groupAttribute);
    }


    /**
     * Multiply Form Control Widget. Automatic Add More Button and Delete Button
     * @param $controlId
     * @param int $initCount
     * @param string $title
     * @return string
     */
    static function addMany($controlId, $initCount = 2, $title = "Add More"){
        $uniqueId = String1::random(10);
        $initPrint = String1::repeat("add_{$uniqueId}();", $initCount);
        return <<< HTML
            <span id="containner_{$uniqueId}">  </span> 
            <script>
                function add_{$uniqueId}(){
                   Html1.cloneElement('$controlId', 'containner_{$uniqueId}', function(data){
                        return "<span class='clone_deleteable'><a href=\"javascript:void(0)\" onclick=\"Html1.getClosestElement(this, '.clone_deleteable').remove()\" style=\"float:right\"><i style=\"background: #ba4525;border-radius:10px;padding:2px;color:white;\" class=\"fa fa-times\" aria-hidden=\"true\"></i> remove </a>" + data + "</span>";
                    }); 
                }
                $initPrint
            </script>
            <button type="button" onclick="add_{$uniqueId}()" class="btn btn-success" style="margin:5px 0 10px 0; padding: 3px 18px 6px 5px; border-radius:50px;"><span class="fa fa-plus img-circle text-success" style="padding:8px; background:#ffffff; margin-right:4px; border-radius:50%;"></span>  $title </button>
HTML;
    }






    //Add Combo/Select

    /**
     * @param string $LabelValueOrAttr
     * @param bool $useValueAsKey
     * @param array $selectAttribute
     *
     *  Default Select value:
     *       selected = value to be selected
     *       link = api data link
     *
     * @param array $formGroupAttribute
     * @return string '';
     */
    static function addSelect($LabelValueOrAttr = '', $selectAttribute = [], $formGroupAttribute = [], $useValueAsKey = false){
        // init
        if(is_array($LabelValueOrAttr)) { $selectAttribute = $LabelValueOrAttr; $LabelValueOrAttr = String1::isset_or($selectAttribute['label'], ''); }
        $option_column_key_value = isset($selectAttribute['value'])? Array1::toArray($selectAttribute['value']): [];
        $useValueAsKey = isset($selectAttribute['useValueAsKey'])? $selectAttribute['useValueAsKey']: $useValueAsKey;
        unset($selectAttribute['value'], $selectAttribute['useValueAsKey']);

        // unique Id fo AJAX
        //d($selectAttribute);
        $containerId = isset($selectAttribute["id"]) ? $selectAttribute["id"] : ((!(isset($selectAttribute["name"]) && self::$AUTO_ID_SET_FROM_NAME) && !isset($selectAttribute["id"]))? 'ajax_box_'.Math1::getUniqueId(): $selectAttribute["name"]);
        $selectAttribute['id'] = $containerId;

        // select
        $newOption = array_merge(['label'=>$LabelValueOrAttr, 'class'=>static::$THEME_FORM_INPUT_CLASS, 'selected'=>''], $selectAttribute);

        // option list
        $optionData = '';
        $newOption['selected'] = (is_array($newOption['selected']) || $newOption['selected'] instanceof  ArrayAccess)? String1::isset_or($newOption['selected'][$newOption['name']], ''): $newOption['selected'];

        foreach ($option_column_key_value as $key => $value){
            if($useValueAsKey) $key = $value;
            $isSelected = (
                ((isset($newOption['name']) && isset($_REQUEST[$newOption['name']]))? (($key == $_REQUEST[$newOption['name']]) || ($value == $_REQUEST[$newOption['name']])):false) ||
                ($key == $newOption['selected']) || ($value == $newOption['selected']) ? "  selected='selected' " :"");
            $optionData .= "<option value='$key' $isSelected>$value</option>";
        }



        // Control
        $selectBox = static::make($newOption['label'], 'select', $optionData, $newOption, @array_merge(['class'=>static::$THEME_FORM_GROUP_CLASS], $formGroupAttribute));


        // Ajax Fetch (it use the link attribute of $selectAttribute)
        $optionDataLink = '';
        if (isset($selectAttribute['link'])) {
            $optionDataLink = $selectAttribute['link'];
        }

        if(trim($optionDataLink) != '') {
            $selectBox .= <<< EOS
            <script>
                var containerId = '$containerId';
                var ajaxLink = '$optionDataLink';
                
              
                $(function(){
                    var selectBox = document.getElementById(containerId);
                    
                   $.ajax({type: 'get', url: ajaxLink}).done(function (data) {  
                       data = Object1.fromJsonString(data);;
                       for(var _key in data){
                           //alert(_key);
                           
                           var key = _key;
                           var value = _key;
                           
                           if(Object.prototype.hasOwnProperty.call(data, _key)){ //data.hasOwnProperty(_key)
                             value = data[_key];
                             key = (('$useValueAsKey' == true)?  data[_key]: key);
                           }
                            
                           selectBox.insertAdjacentHTML('beforeend', '<option value="' + key + '">' + value + '</option>' ); 
                       }
                       
                    }).error(function(error) {
                       selectBox.insertAdjacentHTML('beforeend', '<option>Failed to load data</option>' );  
                       console.log('Cannot fetch ajax data: $optionDataLink [ Due to ]');
                       console.dir(error);
                    });
                    
                });
            </script>
EOS;
        }

        return $selectBox;
    }


    // Add Panel Component
    static function addPanel($label, $content){
        $pageContents = <<< EOSTRING
       <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">$label</h3></div>
        <div class="panel-body">
            $content
        </div>
    </div>
EOSTRING;
        return $pageContents;
    }


    // Add Modal
    static function addModal($label, $content){
        $pageContents = <<< EOSTRING
       <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">$label</h3></div>
        <div class="panel-body">
            $content
        </div>
    </div>
EOSTRING;
        return $pageContents;
    }

    /*private $CONTROL_BUFFER = '';
    function __call($func, $params){
        if(isset($this->$func)) {
            $this->CONTROL_BUFFER .= static::{$func}(...$params); // ; //call_user_func_array($func, $params[0]);
            return $this;
        }
    }
    function renderFormInput(){ return $this->CONTROL_BUFFER; }*/


}






//class HtmlForm extends HtmlForm1 {}










/*********************************************************************************************************************************************************************************
 *
 * [ WIDGET ]
 *
 *********************************************************************************************************************************************************************************/


class HtmlWidget1 {

    /**
     * Widget to delete file
     * @param int $model1FileLocatorId
     * @param string $filePath
     * @param null $previewUrl
     * @param string $style
     * @param string $labelName
     * @return string
     */
    public static function fileDeleteBox($model1FileLocatorId = -1, $filePath = '/public_html/image.jpg', $previewUrl = null,  $style = 'height:150px;width:150px;', $labelName = 'Delete Image'){
        $uniqueImageId = 'image_preview_'.Math1::getUniqueId();
        $fileName = FileManager1::getFileName($filePath);
        $ajaxLink = Form1::callApi(exApiController1::class, "deleteFile()?_token=".token()."&file_locator_id=$model1FileLocatorId&file_path=".urlencode($filePath) );
        $previewUrl = $previewUrl? $previewUrl: HtmlAsset1::getImageThumb();
        return <<< EOSTRING
            <!-- Call delete api-->
            <script>
                function $uniqueImageId() {
                    Popup1.confirmAjax('Delete File?', "This action cannot be undo, Press yes to continue. <br/><hr><strong>Filename : $fileName</strong> <hr><a target='_blank' href='$previewUrl'><img style='height:100px' src='$previewUrl' alt='delete image' /></a><hr>", "$ajaxLink", function(data){
                        if(data == 'true') {
                            Popup1.alert('Action Successful!', '', 'success');
                            $("#container-$uniqueImageId").remove();
                        }
                        else  Popup1.alert('Action failed', 'error ['+data+']', 'error');
                    })
                }
            </script>
            
            <!-- Delete Interface-->
            <label title="$fileName" class="btn btn-danger" id="container-$uniqueImageId" onclick="$uniqueImageId()">
                <img style="$style"  src="$previewUrl">
                <div style="clear:both"></div>
                <div style="margin-top:5px;c"><i class="fa fa-trash"></i> $labelName </div>
            </label>
EOSTRING;
    }

    /**
     * File Upload Widget. with url field. if $imageButtonName is feature_image, then input box would be feature_image_url
     * so as for feature_images[] would be feature_images_url[]
     * // HtmlWidget1::imageUploadBox('feature_image',  ($model->id > 0) ? $model->feature_image_url: null, 'height:150px;width:100% !important', '')
     * @see HtmlWidget1::fileUploadBox()
     * @param string $fileInputName
     * @param null $demoImage
     * @param string $image_style
     * @param string $labelName
     * @return string
     */
    public static function imageUploadBox($fileInputName = 'feature_image', $demoImage = null, $image_style = 'height:150px;max-width:100%;', $labelName = 'Upload Image'){
        // delete button
        $existingImagePath = Url1::urlToPath($demoImage);


        // init field
        $demoImage = ($demoImage)? $demoImage: HtmlAsset1::getImageThumb(); //layout_asset('/image/thumb.png');
        $demoPreviewImage = $demoImage !== HtmlAsset1::getImageThumb()? Url1::getFileImagePreview($demoImage, HtmlAsset1::getSuccessIcon()): $demoImage; //layout_asset('/image/thumb.png');
        $fileUrl_filterOutDemoImage = (($demoImage !== HtmlAsset1::getImageThumb()) && ($demoImage !== HtmlAsset1::getImageAvatar()))? $demoImage: null; //layout_asset('/image/thumb.png');
        $defaultImageForNotImageFile = shared_asset('images/icons/success.png');

        //dd($existingImagePath);
        $deleteButton = ($fileUrl_filterOutDemoImage && $existingImagePath && !String1::contains('/shared/', $existingImagePath))? "<button type='button' onclick='Popup1.confirmLink(`Delete File`, `Will you like to delete file and refresh page?`, `".Form1::callController(exApiController1::class, "deleteFile()?_token=".token()."&file_path=".urlencode($existingImagePath) )."`)' class='btn btn-danger  file_action' style='font-weight:800;'><!-- display: none -->X</button>": '';
        $fileUrlInputName = String1::endsWith('[]', trim($fileInputName))? String1::replaceEnd(trim($fileInputName), '[]', '').'_url[]': trim($fileInputName).'_url';
        $labelName = !empty($labelName)? '<div style="margin-top:3px;"><i class="fa fa-upload"></i> '.$labelName.'</div>': '';
        $noHeightInStyle = String1::replace($image_style, 'height','hgt');


        return <<< HTML
            <label class="btn btn-default" style="border:1px dotted #aaa;border-radius: 20px; overflow: auto; $noHeightInStyle"> <!--  onmousemove="$(this).find('.file_action').show()" onmouseout="$(this).find('.file_action').hide()" -->
                <input style="display: none; width:99%;" onchange="Picture1.uploadPreview(this, null, '$defaultImageForNotImageFile')" type="file" name="$fileInputName" />
                <img style="$image_style"  src="$demoPreviewImage" id="$demoImage" />
                <div> <div class="input-group"><input name="$fileUrlInputName" class="form-control field_url" placeholder="or paste file url" value="$fileUrl_filterOutDemoImage" />$deleteButton</div> $labelName </div>
            </label>
HTML;
    }


    /**
     * File Upload Widget. with url field. if $imageButtonName is feature_image, then input box would be feature_image_url
     * // HtmlWidget1::fileUploadBox('feature_image',  ($model->id > 0) ? $model->feature_image_url: null, 'height:150px;width:100% !important', '')
     * @see HtmlWidget1::imageUploadBox()
     *
     * @param string $buttonName
     * @param null $demoImage
     * @param string $image_style
     * @param string $labelName
     * @return string
     */
    public static function fileUploadBox($buttonName = 'download_file', $demoImage = null, $image_style = 'height:150px;width:150px;', $labelName = 'Upload Image'){ return static::imageUploadBox($buttonName, $demoImage, $image_style, $labelName); }

    /**
     * Multiple upload box. i.e you have add more button that could be used to add more files
     * @param string $imageButtonName
     * @param null $modelFilePath
     * @param string $box_style
     * @param string $labelName
     * @param array $hideByFilePath
     * @return string
     */
    public static function imagesUploadBox($imageButtonName = 'uploadImages[]', $modelFilePath = null, $box_style = 'height:150px;width:150px;', $labelName = 'Upload Image', $hideByFilePath = []) {
        $loadedImages = '';
        foreach(FileManager1::getDirectoriesFiles($modelFilePath) as $imagePath) $loadedImages .= (!in_array($imagePath, $hideByFilePath) && !in_array(exUrl1::convertPathToUrl($imagePath), $hideByFilePath) )? HtmlWidget1::fileDeleteBox(-1, $imagePath, exUrl1::convertPathToUrl($imagePath), $box_style): '';
        $widget = HtmlWidget1::imageUploadBox($imageButtonName, null, $box_style, $labelName);
        return <<< HTML
            <div style="margin:10px;">
                <div id="all_images">
                    $loadedImages
                    <span id="main_image" style="display:none">$widget</span>
                    <span>$widget</span>
                </div>
                <button type="button" onclick="Html1.cloneInnerElement('main_image', 'all_images')" class="btn btn-lg btn-success" style="margin-top:10px; padding: 3px 18px 6px 5px; border-radius:50px;"><span class="fa fa-plus img-circle text-success" style="padding:8px; background:#ffffff; margin-right:4px; border-radius:50%;"></span> Add More </button>
            </div>
HTML;
    }


    /**
     * Add wrapper Panel box around your text
     * @param $title
     * @param string $description
     * @param string $type
     * @param string $boxPanelContentStyle
     * @return string
     */
    public static function panelBox($title, $description = '', $type='primary', $boxPanelContentStyle = 'padding:10px;'){
        $uniqueId = 'box_'.Math1::getUniqueId();
        $bg = Color1::get($type) or "#2980b9";
        return <<< HTML
        <style> div#$uniqueId {margin-top: 15px; border:1px solid $bg; }  div#$uniqueId .box-top { color: #fff; text-shadow: 0 1px #000;font-weight: 300; background: $bg;padding: 5px; padding-left: 15px; } </style>
        <div id="$uniqueId"> <div class="box-top"> $title </div> <div class="box-panel" style="$boxPanelContentStyle"> $description </div> </div>
HTML;
    }

    /**
     * Visit https://loading.io/spinner/ for custom spin
     * @param int $styleType
     * @param string $color
     * @return string
     */
    static function loader($color = 'gray'){
        Page1::printOnce("<style>.lds-dual-ring{display:inline-block;width:64px;height:64px}.lds-dual-ring:after{content:\" \";display:block;width:46px;height:46px;margin:1px;border-radius:50%;border:5px solid $color;border-color:$color transparent $color transparent;animation:lds-dual-ring 1.2s linear infinite}@keyframes lds-dual-ring{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}</style>", 'ex_loader_style');
        return '<span class="lds-dual-ring"></span>';
    }

    /**
     *
     *  Create a css tab in easy way.
         echo HtmlWidget1::createTabs([
            'Home'=> HtmlForm1::addInput('User Name'),
            'Church'=> HtmlForm1::addTextArea('User Address'),
         ]);
     * @param array $taName_equal_tabContent
     * @param string $styleTabItem
     * @param int $selectedIndex
     * @return string
     */
    static function createTabs($taName_equal_tabContent = [], $styleTabItem = '', $selectedIndex = 0){
        Page1::printOnce('<style>.ex_css_tabs{width:650px;float:none;list-style:none;position:relative;margin:80px 0 0 10px}.ex_css_tabs li.ex_tab_item{float:left;display:block; $styleTabItem}.ex_css_tabs input[type="radio"].ex_tab_radio{position:absolute;top:-9999px;left:-9999px}.ex_css_tabs label.ex_tab_label{display:block;padding:14px 21px;border-radius:2px 2px 0 0;font-size:20px;background:#ccc;cursor:pointer;position:relative;top:4px;-moz-transition:all .2s ease-in-out;-o-transition:all .2s ease-in-out;-webkit-transition:all .2s ease-in-out;transition:all .2s ease-in-out}.ex_css_tabs [id^="tab"]:checked+p{color:black;-moz-transition:all 2.2s ease-in-out;-o-transition:all 2.2s ease-in-out;-webkit-transition:all 2.2s ease-in-out;transition:all 2.2s ease-in-out}.ex_css_tabs label.ex_tab_label:hover{background:#fff}.ex_css_tabs .tab-content{z-index:2;display:none;overflow:hidden;width:100%;font-size:17px;line-height:25px;padding:25px;position:absolute;top:53px;left:0;background:#fff}.ex_css_tabs [id^="tab"]:checked+label.ex_tab_label{background:#fff}.ex_css_tabs [id^="tab"]:checked ~ [id^="tab-content"]{display:block}</style>', '__ex_css_tabs');
        $buff = '';
        $indexCount = 0;
        foreach ($taName_equal_tabContent as $key=>$value){
            $tab_id = Math1::getUniqueId();
            $checked = ($indexCount === $selectedIndex)?'checked':'';
            $buff .= "<li class='ex_tab_item'><input type=radio class='ex_tab_radio' name='ex_css_tabs' id='tab_$tab_id' $checked><label class='ex_tab_label' for='tab_$tab_id'> $key </label><div id='tab-content_$tab_id' class=tab-content>$value</div></li>";
            $indexCount++;
        }
        return "<ul class=ex_css_tabs> $buff </ul>";
    }


    /**
     * use to Make Component active based on   Active Url when is the current Url
     * @param null $urlLink
     * @param string $innerHtmlDataHyperLinkWithUrl
     * @param string $onActiveAddClassName
     * @param string $otherClassNames
     * @param array $tagAttribute
     * @param string $tagName
     * @param bool $isUrlAbsolute  e.g if url is home, like url('/'). that is absolute and should not be active with other url
     * @return string
     */
    static function urlActiveTag($urlLink = null, $innerHtmlDataHyperLinkWithUrl = '<a> hello world </a>', $onActiveAddClassName="active", $otherClassNames='', $tagAttribute = [], $tagName = 'li', $isUrlAbsolute = false){
        if( isset($tagAttribute['class']) ) return Console1::println(['Error<hr/> HtmlWidget::activeUrl() $attribute cannot contain class again', $tagAttribute], true);
        $classList = ltrim($otherClassNames.' '.Url1::ifExistInUrl($urlLink, $onActiveAddClassName, '', $isUrlAbsolute));
        return "<$tagName ".Array1::toHtmlAttribute( array_merge($tagAttribute, ['class'=>$classList]) ).">$innerHtmlDataHyperLinkWithUrl</$tagName>";
    }


    static function dropMenu($linkNameLocation=['Dashboard'=>'#'], $buttonName = 'Menu', $buttonAttribute = [], $tagName = 'button'){
        Page1::printOnce('<style>.ex_dropdown{position:relative;display:inline-block}.ex_dropdown-content{display:none;position:absolute;background-color:#f1f1f1;min-width:160px;box-shadow:0 8px 16px 0 rgba(0,0,0,0.2);z-index:202939}.ex_dropdown-content a{color:black;padding:12px 16px;text-decoration:none;display:block}.ex_dropdown-content a:hover{background-color:#ddd}.ex_dropdown:hover .ex_dropdown-content{display:block}</style>', 'ex_dropbtn_123_widget')
        ?> <div class="ex_dropdown"><<?=$tagName.' '.Array1::toHtmlAttribute($buttonAttribute) ?>><?= $buttonName ?></<?= $tagName ?>> <div class="ex_dropdown-content"><?php foreach ($linkNameLocation as $key=>$value) echo "<a href='$key'>$value</a>"; ?></div></div>
        <?php return '';
    }

    public static function listAndMarkActiveLink($linkNameLocation = ['home'=>'#'], $selectedListStyle = 'font-weight: bolder;', $normalListStyle = '', callable $callBack = null){
        $buffer = ''; $currentPath = Url1::getPageFullUrl();
        foreach ($linkNameLocation as $key=>$value) {
            $selectedStyle = Url1::existInUrl($value, $currentPath)? $selectedListStyle: $normalListStyle;
            $buffer .= "<li style='$selectedStyle'><a href='$value'>". String1::convertToCamelCase($callBack? $callBack($key): $key, ' ')."</a></li>";
        }
        return $buffer;
    }

    public static function menuHorizontalBar($title='App Name', $linkNameLocation=['Home Page'=>'#'], $selectedMenuStyle='color: #14a3ff;font-weight: bolder;', $menuStyle='', $navClass=''){
        $buffer = self::listAndMarkActiveLink($linkNameLocation, $selectedMenuStyle, $menuStyle);
        return <<<HTML
            <div class="row"><div class="col-md-12"><nav class="navbar $navClass" role="navigation"><div class="col-md-12"><div class="navbar-header"><a class="navbar-brand" href="#">$title</a></div><ul class="nav navbar-nav navbar-right">$buffer</ul></div></nav></div></div>
HTML;
    }

    public static function menuHorizontalBarAdmin($title='App Name', $linkNameLocation=['Dashboard'=>'#'], $selectedMenuStyle='color: #14a3ff;font-weight: bolder;', $menuStyle='', $navClass='navbar-inverse navbar-fixed-top', $seachAction = '#'){
        $buffer = self::listAndMarkActiveLink($linkNameLocation, $selectedMenuStyle, $menuStyle);
        $userInfo = User::getLogin();
        return <<<HTML
            <nav class="navbar $navClass">
                <div class="container-fluid">
                    <div class="navbar-header"><button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><a class="navbar-brand" href="#">$title ( Welcome, $userInfo->user_name )</a></div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">$buffer</ul>
                        <form class="navbar-form navbar-right" method="get" action="$seachAction"><input name="q" type="text" class="form-control" placeholder="Search..."></form>
                    </div>
                </div>
            </nav>
HTML;
    }

    public static function menuOverlay($linkNameLocation=['Dashboard'=>'#'], $selectedMenuStyle='color: tomato;font-weight: bolder;', $menuStyle=''){
        $buffer = self::listAndMarkActiveLink($linkNameLocation, $selectedMenuStyle, $menuStyle);
        $script = '<script> $(function(){ var $icon=$(".ex_overlay_menu_con .icon");var $menu=$(".ex_overlay_menu");$icon.on("click",function(){if(!$menu.hasClass("active")){$menu.fadeIn().toggleClass("active")}else{$menu.fadeOut().removeClass("active")}}); });</script>';
        $style = '<style> @import url(https://fonts.googleapis.com/css?family=Droid+Sans);.ex_overlay_menu{display:none; z-index:9999; width:100%;height:100%;position:absolute;top:0;left:0;background:#34495e}.ex_overlay_menu ul{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)}.ex_overlay_menu ul li{list-style-type:none;margin:20px 0;font-size:26px;text-transform:uppercase;transition:all .2s ease;cursor:pointer;}.ex_overlay_menu ul li:hover{transform:translateX(-10px)}.ex_overlay_menu_con .icon *{position:absolute;top:20px;right:20px;width:50px;z-index:99999;cursor:pointer}</style>';
        return <<<HTML
            <div class="ex_overlay_menu_con">
                $style
                  <div class="icon"><i style="font-size:45px; $selectedMenuStyle;" class="fa">&#xf0c9;</i></div>
                  <div class="ex_overlay_menu"> <div class="text"> <ul>  $buffer </ul>  </div>  </div>
                $script
            </div>
HTML;
    }



    public static function rating($ratingName = 'rating'){
        $uniqueImageId = 'starrating_'.Math1::getUniqueId();
        $codeStyle = '<style>.'.$uniqueImageId.'>input{display:none}.'.$uniqueImageId.'>label:before{content:"\\f005";margin:2px;font-size:8em;font-family:FontAwesome;display:inline-block}.'.$uniqueImageId.'>label{color:#222}.'.$uniqueImageId.'>input:checked ~ label{color:#ffca08}.'.$uniqueImageId.'>input:hover ~ label{color:#ffca08}</style>';
        $code = '<div class="'.$uniqueImageId.' risingstar d-flex justify-content-center flex-row-reverse">'."\n".'<input type="radio" id="'.$ratingName.'5" name="'.$ratingName.'" value="5" /><label for="'.$ratingName.'5" title="5 star">5</label>'."\n".'<input type="radio" id="'.$ratingName.'4" name="'.$ratingName.'" value="4" /><label for="'.$ratingName.'4" title="4 star">4</label>'."\n".'<input type="radio" id="'.$ratingName.'3" name="'.$ratingName.'" value="3" /><label for="'.$ratingName.'3" title="3 star">3</label>'."\n".'<input type="radio" id="'.$ratingName.'2" name="'.$ratingName.'" value="2" /><label for="'.$ratingName.'2" title="2 star">2</label>'."\n".'<input type="radio" id="'.$ratingName.'1" name="'.$ratingName.'" value="1" /><label for="'.$ratingName.'1" title="1 star">1</label>'."\n".'</div>';
        return $codeStyle.$code;
    }


    public static function toast($title, $description = '', $type='warning'){
        $uniqueId = "snack_bar_".Math1::getUniqueId();
        $bg = Color1::get($type);
        return <<< EOSTRING
        <style>
            #$uniqueId {visibility: hidden;min-width: 250px;margin-left: -125px;background-color:$bg;color:white !important; text-align: center;border-radius: 2px;padding: 16px;position: fixed;z-index: 10099986765;left: 50%;bottom: 30px;font-size: 17px;}
            #$uniqueId.show { visibility: visible; -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s; animation: fadein 0.5s, fadeout 0.5s 2.5s;}
            @-webkit-keyframes fadein {from {bottom: 0; opacity: 0;} to {bottom: 30px; opacity: 1;}}
            @keyframes fadein {from {bottom: 0; opacity: 0;}to {bottom: 30px; opacity: 1;}}
            @-webkit-keyframes fadeout {from {bottom: 30px; opacity: 1;} to {bottom: 0; opacity: 0;}}
            @keyframes fadeout {from {bottom: 30px; opacity: 1;}to {bottom: 0; opacity: 0;}}
        </style>
         <!--<i class="fa fa-$ type" style="border:2px solid white;border-radius:50%;height:50px;width:50px;padding:8px;"></i>&nbsp;&nbsp;  -->
        <div id="$uniqueId"><h2 style="color:#f7f7f7">$title</h2> <p style="color:#f5f5f5">$description</p></div>
        <script> function myFunction() { var x = document.getElementById("$uniqueId"); x.className = "show"; setTimeout(function(){ x.className = x.className.replace("show", ""); }, 5000); }; myFunction();</script>
EOSTRING;
    }

    public static function box1($title='Add New Category', $body='Create new Category Now', $number = '', $actionLink='#', $buttonName = 'Click Here', $class='col-md-3'){
        $shadow = HtmlStyle1::getShadow2x();
        return <<<HTML
            <div class="$class" style="$shadow; box-shadow:inset 0px 0px 15px rgba(0, 0, 0, .14); padding:10px;color: #636c71 !important;">
                <h3 style="">$title</h3>
                <div> <p>$body</p> <div class="clearfix"></div> </div>
                <div style="border-top:1px solid #eeeeee;"> <span class="badge badge-danger pull-left" style="margin-top:10px;">$number</span> <div class="text-right"><strong><a href="$actionLink" class="btn" style="font-weight:800;font-size: larger">$buttonName <i class="fa fa-chevron-circle-right fa-lg" aria-hidden="true"></i></a></strong></div> </div>
            </div>
HTML;
    }


    public static function box2($title='Create new Category Now', $number = '26', $panelStyleType = 'panel-primary', $panelIcon = 'fa fa-comments', $actionLink='#', $buttonName = 'View Details', $colAndClass='col-md-3'){
        return <<<HTML
            <div class="$colAndClass">
                <div class="panel $panelStyleType">
                    <div class="panel-heading"> <div class="row">  <div class="col-xs-3"> <i class="$panelIcon  fa-5x"></i> </div> <div class="col-xs-9 text-right"> <div class="huge">$number</div> <div>$title</div> </div> </div> </div>
                    <a href="$actionLink"> <div class="panel-footer"> <span class="pull-left">$buttonName</span>  <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span> <div class="clearfix"></div> </div> </a>
                </div>
            </div>
HTML;
    }


    /**
     * example ob_start(); $userInfo->form()->render(); $dd = ob_get_clean();
     * echo footerPopup($dd, 'click me 1', '0'); echo footerPopup($dd, 'click me 1', '25');
     * @param string $content
     * @param string $name
     * @param string $align
     * @param string $contentStyle
     * @param string $widgetStyle
     * @param string $onClickScript
     * @return string
     */
    static function footerPopup($content = '', $name = 'Click Me!', $align = 'center', $contentStyle = '', $widgetStyle = '', $onClickScript = 'console.dir("dialog clicked");'){
        $uniqueId = 'footer_popup_'.Math1::getUniqueId();
        $script = '<script>$(function(){    $("#'.$uniqueId.' .body").hide(); $("#'.$uniqueId.' .button").click(function () { $(this).next("#'.$uniqueId.' div").slideToggle(400); $(this).toggleClass("expanded"); '.$onClickScript.'  });  });</script>';
        $style = "<style>#$uniqueId{z-index:200000;position:fixed; bottom:0;left:3%;width:94%; ".HtmlStyle1::getMarginCenter($align, true)."; $widgetStyle}#$uniqueId .button:before{content:'+ '}#$uniqueId .expanded:before{content:'- '}#$uniqueId .button{font-size:1.1em;cursor:pointer;margin-left:auto;margin-right:auto;border:2px solid #e25454;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px 5px 0 0;padding:5px 20px 5px 20px;background-color:#e25454;color:#fff;display:inline-block;text-align:center;text-decoration:none;-webkit-box-shadow:4px 0 5px 0 rgba(0,0,0,0.3);-moz-box-shadow:4px 0 5px 0 rgba(0,0,0,0.3);box-shadow:4px 0 5px 0 rgba(0,0,0,0.3)}#$uniqueId .body{background-color:#fff;border-radius:5px;border:2px solid #e25454;margin-bottom:16px;padding:10px;-webkit-box-shadow:4px 4px 5px 0 rgba(0,0,0,0.3);-moz-box-shadow:4px 4px 5px 0 rgba(0,0,0,0.3);box-shadow:4px 4px 5px 0 rgba(0,0,0,0.3)}@media only screen and (min-width:768px){#$uniqueId .button{margin:0}#$uniqueId{left:20px;width:390px;text-align:left}#$uniqueId .body{overflow: auto !important; padding:30px;border-radius:0 5px 5px 5px; max-height:700px;$contentStyle}}</style>";
        return <<<HTML
                        <section id="$uniqueId"> $style.$script<div class="button">$name</div> <div class="body">$content</div></section>
HTML;
    }


    public static function listData($title='My List', $valueArray = []){
        $class = "list_".Math1::getUniqueId();
        $buffer = '<style>.'.$class. '{border-bottom:2px inset whitesmoke; list-style-type:none; padding:10px; padding-left:-20px !important; text-decoration: none !important; }' .'</style>
                    <ul class="list-group" style="'.HtmlStyle1::getShadow2x().';border-radius:10px; "> 
                        <li style="font-weight:800;font-size:larger; " class="'.$class.'">'.$title.'</li>';
                        foreach ($valueArray as $value) $buffer .= "<li class='$class'>$value</li>";
        $buffer .= '</ul>';
        return $buffer;
    }


    public static function listDataKeyValue($title='My List', $keyValueArray = []){
        $class = "list_".Math1::getUniqueId();
        $buffer = '<style>.'.$class. '{border-bottom:2px inset whitesmoke; list-style-type:none; padding:10px; padding-left:-20px !important;}' .'</style>
                    <ul class="list-group" style="display: table;'.HtmlStyle1::getShadow2x().';box-shadow:inset 0px 0px 15px rgba(0, 0, 0, .14);border-radius:10px;"> 
                        <li style="font-weight:800;font-size:larger;" class="'.$class.'">'.$title.'</li>';
                        foreach ($keyValueArray as $key=>$value) $buffer .= "<li style='display: table-row' class='$class'><span class='display: table-cell'>$key</span>    <span class='display: table-cell'>$value</span></li>";
        $buffer .= '</ul>';
        return $buffer;
    }


    public static function listLink($title='My List', $listItem_menuNameEqualsMenuLink=[]){
        $currentPath = Url1::getPageFullUrl();
        $itemBuffer = [];
        foreach($listItem_menuNameEqualsMenuLink as $item=> $value) {
            if(is_numeric($item)) $itemBuffer[] = $value;
            else {
                $isSelectedStyle = Url1::existInUrl($value, $currentPath)? 'font-weight:800;': null;
                $itemBuffer[] = "<a class='btn btn-link' href='$value' style='$isSelectedStyle'>$item</a>";
            }
        }
        return self::listData($title, $itemBuffer);
    }

    public static function listCheckBox($title='My List', $name='', $listItem=[]){
        $itemBuffer = [];
        foreach($listItem as $item) $itemBuffer[] = "<label><input type='checkbox' name='".$name."[]' value='$item' /> &nbsp;$item</label>";
        return self::listData($title, $itemBuffer);
    }

    public static function listRadioButton($title='My List', $name='', $listItem=[]){
        $itemBuffer = [];
        foreach($listItem as $item) $itemBuffer[] = "<label><input type='radio' name='".$name."' value='$item' /> &nbsp;$item</label>";
        return self::listData($title, $itemBuffer);
    }

    static function textHeader($title = '', $description = ''){
            echo '<pre style="'.HtmlStyle1::getShadow2x().';direction: ltr; max-width: 90%; margin: 30px auto;overflow:auto; font-family: Monaco, Consolas, \'Lucida Console\',monospace;font-size: 16px;padding: 20px;
                       border-left:20px solid #2295bc;border-right:20px solid #2295bc; border-radius:20px; height:auto !important; 
                       white-space: pre-wrap;  white-space: -moz-pre-wrap;  white-space: -pre-wrap;  white-space: -o-pre-wrap;  word-wrap: break-word;
                       clear:both;top:0;background:#e4e7e7;color:#2295bc">'.(($title !== '')?"<h2 align='left'>".$title.'</h2><hr/>': '').print_r($description, true).'</pre>';
    }

    static function flipperWidget($frontContent = '', $backContent = ''){

    }


    function articlePage($title = '',  $body = '', $footer = ''){
        $code = '<style>body{text-align:center;padding:150px}h1{font-size:50px}body{font:20px Helvetica,sans-serif;color:#636363}article{display:block;text-align:left;width:650px;margin:0 auto}a{color:#dc8100;text-decoration:none}a:hover{color:#333;text-decoration:none}</style>';
        return "$code<article> <h1>$title</h1> <div>  <p>$body</p> <p>&mdash; $footer</p> </div> </article>";
    }
}





/*********************************************************************************************************************************************************************************
 *
 * [ STYLE ]
 *
 *********************************************************************************************************************************************************************************/

class HtmlStyle1 {
    /**
     * Use for container centralizing, just passed in center, left or right
     * e.g <div style="<?php HtmlStyle1::getMarginCenter('right') ?>"> Hello world</div>
     * @param string $align
     * @param bool $userPercentage
     * @return string
     */
    static function getMarginCenter($align='center', $userPercentage = false){
        if(is_numeric($align)) return "margin-left:$align% !important;";
        switch (trim(strtolower($align))) {
            case 'center':  return $userPercentage? 'margin-left:40% !important; ': "margin:0  !important;";
            case 'left':    return $userPercentage? 'margin-left:0% !important; ':  "margin-left: 0 !important; margin-right: auto  !important;";
            case 'right':   return $userPercentage? 'margin-left:80% !important; ': "margin-left: auto  !important; margin-right: 0  !important;";
            default : return static::getMarginCenter('left', true);
        }
    }

    public static function enablePreWrap($selector = '', $initStyle = 'outline: 1px solid #e2e2e2;  padding: 10px;  margin: 5px'){
        return <<< EOSTRING
        <style> $selector pre{ $initStyle; white-space: pre-wrap;  white-space: -moz-pre-wrap;  white-space:-pre-wrap;  white-space: -o-pre-wrap;  word-wrap: break-word;} </style>
EOSTRING;
    }


    public static function enableCenter($selector = '.middle'){
        return <<< EOSTRING
        <style> $selector {  height: 100%;  display: flex;  align-items: center;  justify-content: center;  } </style>
EOSTRING;
    }

    public static function enable3DButton($selector = '.btn'){
        return <<< EOSTRING
        <style> $selector{position:relative;top:-6px;border:0;transition:all 40ms linear;margin-top:10px;margin-bottom:10px;margin-left:2px;margin-right:2px}$selector:active:focus,$selector:focus:hover,$selector:focus{-moz-outline-style:none;outline:medium none}$selector:active,$selector.active{top:2px}$selector.btn-white{color:#666;box-shadow:0 0 0 1px #ebebeb inset,0 0 0 2px rgba(255,255,255,0.10) inset,0 8px 0 0 #f5f5f5,0 8px 8px 1px rgba(0,0,0,.2);background-color:#fff}$selector.btn-white:active,$selector.btn-white.active{color:#666;box-shadow:0 0 0 1px #ebebeb inset,0 0 0 1px rgba(255,255,255,0.15) inset,0 1px 3px 1px rgba(0,0,0,.1);background-color:#fff}$selector.btn-default{color:#666;box-shadow:0 0 0 1px #ebebeb inset,0 0 0 2px rgba(255,255,255,0.10) inset,0 8px 0 0 #BEBEBE,0 8px 8px 1px rgba(0,0,0,.2);background-color:#f9f9f9}$selector.btn-default:active,$selector.btn-default.active{color:#666;box-shadow:0 0 0 1px #ebebeb inset,0 0 0 1px rgba(255,255,255,0.15) inset,0 1px 3px 1px rgba(0,0,0,.1);background-color:#f9f9f9}$selector.btn-primary{box-shadow:0 0 0 1px #417fbd inset,0 0 0 2px rgba(255,255,255,0.15) inset,0 8px 0 0 #4D5BBE,0 8px 8px 1px rgba(0,0,0,0.5);background-color:#4274d7}$selector.btn-primary:active,$selector.btn-primary.active{box-shadow:0 0 0 1px #417fbd inset,0 0 0 1px rgba(255,255,255,0.15) inset,0 1px 3px 1px rgba(0,0,0,0.3);background-color:#4274d7}$selector.btn-success{box-shadow:0 0 0 1px #31c300 inset,0 0 0 2px rgba(255,255,255,0.15) inset,0 8px 0 0 #5eb924,0 8px 8px 1px rgba(0,0,0,0.5);background-color:#78d739}$selector.btn-success:active,$selector.btn-success.active{box-shadow:0 0 0 1px #30cd00 inset,0 0 0 1px rgba(255,255,255,0.15) inset,0 1px 3px 1px rgba(0,0,0,0.3);background-color:#78d739}$selector.btn-info{box-shadow:0 0 0 1px #00a5c3 inset,0 0 0 2px rgba(255,255,255,0.15) inset,0 8px 0 0 #348FD2,0 8px 8px 1px rgba(0,0,0,0.5);background-color:#39b3d7}$selector.btn-info:active,$selector.btn-info.active{box-shadow:0 0 0 1px #00a5c3 inset,0 0 0 1px rgba(255,255,255,0.15) inset,0 1px 3px 1px rgba(0,0,0,0.3);background-color:#39b3d7}$selector.btn-warning{box-shadow:0 0 0 1px #d79a47 inset,0 0 0 2px rgba(255,255,255,0.15) inset,0 8px 0 0 #D79A34,0 8px 8px 1px rgba(0,0,0,0.5);background-color:#feaf20}$selector.btn-warning:active,$selector.btn-warning.active{box-shadow:0 0 0 1px #d79a47 inset,0 0 0 1px rgba(255,255,255,0.15) inset,0 1px 3px 1px rgba(0,0,0,0.3);background-color:#feaf20}$selector.btn-danger{box-shadow:0 0 0 1px #b93802 inset,0 0 0 2px rgba(255,255,255,0.15) inset,0 8px 0 0 #AA0000,0 8px 8px 1px rgba(0,0,0,0.5);background-color:#d73814}$selector.btn-danger:active,$selector.btn-danger.active{box-shadow:0 0 0 1px #b93802 inset,0 0 0 1px rgba(255,255,255,0.15) inset,0 1px 3px 1px rgba(0,0,0,0.3);background-color:#d73814}$selector.btn-magick{color:#fff;box-shadow:0 0 0 1px #9a00cd inset,0 0 0 2px rgba(255,255,255,0.15) inset,0 8px 0 0 #9823d5,0 8px 8px 1px rgba(0,0,0,0.5);background-color:#bb39d7}$selector.btn-magick:active,$selector.btn-magick.active{box-shadow:0 0 0 1px #9a00cd inset,0 0 0 1px rgba(255,255,255,0.15) inset,0 1px 3px 1px rgba(0,0,0,0.3);background-color:#bb39d7} </style>
EOSTRING;
    }

    public static function getFixBackgroundAttr(){ return " no-repeat center center fixed; background-size: cover; "; }
    public static function getShadow2x(){ return "box-shadow: 0 2px 2px 0 rgba(0, 0, 0, .14), 0 3px 1px -2px rgba(0, 0, 0, .2), 0 1px 5px 0 rgba(0, 0, 0, .12);"; }
    public static function zoomOut($className = 'img-zoom'){  Page1::printOnce("<style>.$className{margin:10px 10px 10px 10px;-webkit-transform:scale(1,1);-ms-transform:scale(1,1);transform:scale(1,1);transition-duration:.3s;-webkit-transition-duration:.3s}.$className:hover{cursor:pointer;-webkit-transform:scale(2,2);-ms-transform:scale(2,2);transform:scale(2,2);transition-duration:.3s;-webkit-transition-duration:.3s;box-shadow:10px 10px 5px #888;z-index:100;position:absolute}</style>"); }
}











class HtmlAsset1{
    static function getImageAvatar(){   return FileManager1::urlPathExistsOr( function_exists('shared_asset')? shared_asset('images/icons/avatar.png')      : '',"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAMAAABHPGVmAAAAtFBMVEUAAADMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMz////MzMz4+Pj8/Pzm5ubj4+P19fXX19fo6Oje3t7x8fHs7OzS0tLg4ODOzs7Z2dnu7u7Q0NDU1NT6+vrq6urb29sQYYLgAAAAJnRSTlMAFPzv4if03KZEI/ixmodrLfLIzZB1XDW/55VuZFUGAR3YrLRRA8h6NQkAAAQfSURBVGjetNXdUuJAEAXgCQkBlIBEVAoof25OT2aSCflH9/3fa4tdt9ZSOkwIfPfUoaebg7DlTDbLaThyfSLfHYXT5WbiiEu6mY+9ptKmjmUUAVEk49roqvHG8xtxEcPZKC8yiSNkVuSj2VD05MzDvZJoIdU+nDt9hghudYyTYn0bDM+NGA9MBCuRGYzPiXHWA4MOzGDd9dFetq5CR8rdvnS62VURo7O4WHW46MeFwlnU4lHYeQ7SHc60S4Nnq42HGj3o8FWcdOcp9KK8O3HCk/uBnj7cJ9Fq4mfoLfMnrXMwGR1li5ZZ7twMF5G57F5evQ/w3muVJnlZEpVNkqpd1LoXj7mx51CBlVX0TZnW4Knw+O8l0PwXy+mYRvHj6OBol6RgyIQ4TQZO+nikExc7ripKapFG3McWNz+6faW4bVC75J1by+p7828LHFfTKXsupdh+a0U3Zoam0xLmxWLXEV+tucfKyQJ3MmotvhgOwA1ihXuwwVD8NzbctZMV7pDN2GIQJGSlwOlRAgNGSVYSMEwgPjk+94OSZKcEI/L/HdiDBr/3fpuHfhB/vUkwMrIUgyHfPv8OE3AUWarBSZ7EwUyBo8mSAUfNxMFIgpOSJQWOHP3p+BysiixpsPJD488LsBKylIJVzA+VkoG1J0u/wMoO1eJJsHKyVIElPSGcBrySLCXgNY6YVOCRrRy8aiI2+toheiOWBqyIbDXgmaWY1pcIKcHbTcV9DJa8SEh833rBkqyh9Ybd6NohkSsWLSHvlwnxBeHaiwf9bsVedxMEgigAT0yrJRAlRU1pgrFedgRRvEvl/d+rTdrk/JFhGfZ7AM0uuzszh9i4uPEnI2BsV6envhK3Cx++U40/ih8eR7hLQSmNfISj3AhytnIw8mUMbkaS6YsvnhU8kPoNO6VGsh/jqa+R6zcLT713NbJCW3pRtFB+62zULSrKL85wnUpX3nGChZbIdv59GNnxDc1dvfSimBpgO0KbKqhUu4U2FQ23INNeRDTcNNwb2UE3mWB0wBCkLJDYBmEIwjinq11GtvnCYCorFSURgylGbFGlOFwYsREWiApF3UVYgNhDtFUEHog9xAAHroonGAEOlqK+Jwd5IXKoBmmpfVayz4Z4EArF4It40CrozHfcoNoIQacc2X7nt/22Ki9s4bQrssdhkzZEtgif0/yWna8la9x3xfb3z/63AOEzTIs8K3Z3dqCszo+0mNIT7+zUBwG89tih3is9lbBDCdWYsDMTqjVkR4YkGLMTYxINHa1DNuLORtTI87kT3yML85g7iOdkZb1gtcWabK36rNJfUQuzgBWCGbUTDrilQUjtJTG3ECekkwysV5GQXrj0uZG/DKmjaeSL/xBNyQlv8dLjJ3ovC49cCidBFPf9vx/3+3EUTEKy9APHsaFQQqfcJwAAAABJRU5ErkJggg=="); }
    static function getImageThumb(){    return FileManager1::urlPathExistsOr( function_exists('shared_asset')? shared_asset('images/icons/thumb.png')       : '', "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAH0AAABsCAYAAABHCr0bAAAACXBIWXMAAAsSAAALEgHS3X78AAAEiUlEQVR4nO3cP0vzahiA8escIvSFCBbaoUOHDB0yuAguHRwcOvg1/Fr2Q9ghYIcKHTooOOjQIUOHCqlEaCCFFgycM0g97zl6tE3b5Gnu+xo1CQ/+ePKnfeIfV1dXf6GJ6s+8B6Bln6ILTNEFpugCU3SBKbrArO9+eXl5mdU4tB3Ubre//LnOdIEpusAUXWCKLjBFF5iiC0zRBaboAlN0gSm6wBRdYIouMEUXmKILTNEFpugCU3SBKbrAFF1gii6wbxdGavk0m83o9/ssFotvt3NdF9d11z6+ohvWbDaj0+kwn89X2jZNeno3qHXAN0nRDSkrcFB0I8oSHBQ997IGB0XPtTzAQe/ecyuKIjzPyxwcdKbnUp7gsAczPQgCfN/n9fWV6XQKQLlcplKp0Gg0qNVqOY9wvfIGB4PRF4sFg8GA0Wj06XfT6ZTpdIrv+ziOQ7PZpFQq5TDK9TIBHAxFH4/H9Ho9kiT5cdvRaMR4POb8/Jx6vZ7B6NJlCjgYeE0Pw3Bl8GVJktDr9QjDcIcjS59J4GAg+u3t7Vrgy5IkSb3vLjMNHAxDHw6HxHGcev84jhkOh1sc0WaZCA6Gofu+v/Exvrrxy6Moiri+vjYOHAxCXywWW7kmh2H44/fQu24JbtqlZplR6CYea91MBweDHtne3t6MPNY6hWGI53lGg4NBM/3Xr19GHmvV9gUcDEK3bRvL2vzEY1kWtm1vYUSrt0/gYBA6gOM4Wz/Grq/v+wYOhqGnWdn50zF2+Zn8PoKDYejVanUjeNd1qVarWxzR/7ev4GAYOkCz2Uz1dWmtVqPZbO5gRJ/bZ3AwEB2g1WrRaDRW3r5er9NqtXY4on/ad3Aw6Dn99yzL4uzsDMdxuL+//1g88d/K5TKnp6eZfaVaBHAwFH1ZvV6nXq8zm80IguDjj21ZFrVaLdNHs6KAg+Hoy2zbXut0v+2KBA6GXtNNaPlRbtHAQdG/7O3tjYODg0KCg6J/WZHBYU+u6VkXBAHdbreQ4KAz/VOTyaTQ4KDo/+rl5YWbm5tCg8MGp/dOp7PR8ibLsri4uMjss/KfmkwmIsAhx5meJAme5xFFUV5D+CgIAjHgkPPpPUkSut1urmvain7T9lW5X9PjOMbzvFzgJYKDAejw/kJip9NJ/d+S0iQVHAxBh/cZv+nN4aqNx2Ox4GAQOsB8PsfzvJ2+mrTOG7FFzSh0eL+5GwwG9Hq9rV/nn56exIODwR/DLt87Pzk5wXXdjZZHR1FEv9839lXmrDMWHd5n/d3dHQ8PDziOs/bCxzAMGQ6HW3kxskgZjb4sSRJ838f3fQ4PD3EcB9u2sW2bUqlEtVr9mMVRFBEEAc/Pz0a+MWpCe4H+e3Ec8/j4mPcw9jrjbuS03afoAlN0gSm6wBRdYIouMEUXmKILTNEFpugCU3SBKbrAFF1gii4wRReYogtM0QWm6AJLvVzKcRyOjo62ORZtzSqVSqr9UqMfHx+n3VXLOT29C0zRBaboAlN0gSm6wBRdYN8+srXb7azGoWWYznSBKbrAFF1gii4wRReYogvsb4sBa+dQCD+CAAAAAElFTkSuQmCC"); }
    static function getSuccessIcon(){   return FileManager1::urlPathExistsOr( function_exists('shared_asset')? shared_asset('images/icons/success.png')     : '', static::getImageThumb()); }
    static function getCloseIcon(){     return FileManager1::urlPathExistsOr( function_exists('shared_asset')? shared_asset('images/icons/close.png')       : '', static::getImageThumb()); }
    static function getError404(){     return FileManager1::urlPathExistsOr( function_exists('shared_asset')? shared_asset('images/error/error404.jpg')     : '', static::getImageThumb()); }
}






































































/*********************************************************************************************************************************************************************************
 *
 * [ HTML to TEXT ]
 *
 *********************************************************************************************************************************************************************************/






