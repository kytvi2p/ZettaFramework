<?php

// @todo пересобрать нормально форму

class Zetta_Form extends Zend_Form {
	
	protected $_formID = null;
	
	protected $_rus = array(
		Zend_Validate_Alnum::NOT_ALNUM => 'Введенное значение "%value%" неправильное. Разрешены только латинские символы и цифры', 
		Zend_Validate_Alnum::STRING_EMPTY => 'Поле не может быть пустым. Заполните его, пожалуйста', 
		Zend_Validate_Alpha::NOT_ALPHA => 'Введите в это поле только латинские символы', 
		Zend_Validate_Alpha::STRING_EMPTY => 'Поле не может быть пустым. Заполните его, пожалуйста', 
		//Zend_Validate_Barcode_UpcA::INVALID => '"%value% неправильный UPC-A штрих-код"', 
		//Zend_Validate_Barcode_UpcA::INVALID_LENGTH => 'Неправильное значение "%value%". Введите 12 символов',
		//Zend_Validate_Barcode_Ean13::INVALID => '"%value% неправильный EAN-13 штрих-код', 
		//Zend_Validate_Barcode_Ean13::INVALID_LENGTH => 'Неправильное значение "%value%". Введите 13 символов', 
		Zend_Validate_Between::NOT_BETWEEN => '"%value%" не находится между "%min%" и "%max%", включительно',
		Zend_Validate_Between::NOT_BETWEEN_STRICT => '"%value%" не находится строго между "%min%" и "%max%"',
		Zend_Validate_Ccnum::LENGTH => '"%value%" должно быть численным значением от 13 до 19 цифр длинной', 
		Zend_Validate_Ccnum::CHECKSUM => 'Подсчёт контрольной суммы неудался. Значение "%value%" неверно', 
		//Zend_Validate_Date::NOT_YYYY_MM_DD => '"%value%" не подходит под формат год-месяц-день(напр. 2008-11-03)', 
		Zend_Validate_Date::INVALID => '"%value%" - неверная дата', 
		Zend_Validate_Date::FALSEFORMAT => '"%value%" - не подходит по формату', 
		Zend_Validate_Digits::NOT_DIGITS => 'Значение "%value%" неправильное. Введите только цифры', 
		Zend_Validate_Digits::STRING_EMPTY => 'Поле не может быть пустым. Заполните его, пожалуйста', 
		Zend_Validate_EmailAddress::INVALID => '"%value%" неправильный адрес електронной почты. Введите его в формате имя@домен', 
		Zend_Validate_EmailAddress::INVALID_HOSTNAME => '"%hostname%" неверный домен для адреса "%value%"', 
		Zend_Validate_EmailAddress::INVALID_MX_RECORD => 'Домен "%hostname%" не имеет MX-записи об адресе "%value%"', 
		Zend_Validate_EmailAddress::DOT_ATOM => '"%localPart%" не соответствует формату dot-atom', 
		Zend_Validate_EmailAddress::QUOTED_STRING => '"%localPart%" не соответствует формату указанной строки', 
		Zend_Validate_EmailAddress::INVALID_LOCAL_PART => '"%localPart%" не правильное имя для адреса "%value%", вводите адрес вида имя@домен', 
		Zend_Validate_Float::NOT_FLOAT => '"%value%" не является дробным числом', 
		Zend_Validate_GreaterThan::NOT_GREATER => '"%value%" не превышает "%min%"', 
		Zend_Validate_Hex::NOT_HEX => '"%value%" содержит в себе не только шестнадцатеричные символы', 
		Zend_Validate_Hostname::IP_ADDRESS_NOT_ALLOWED => '"%value%" - это IP-адрес, но IP-адреса не разрешены ', 
		Zend_Validate_Hostname::UNKNOWN_TLD => '"%value%" - это DNS имя хоста, но оно не дожно быть из TLD-списка', 
		Zend_Validate_Hostname::INVALID_DASH => '"%value%" - это DNS имя хоста, но знак "-" находится в неправильном месте', 
		Zend_Validate_Hostname::INVALID_HOSTNAME_SCHEMA => '"%value%" - это DNS имя хоста, но оно не соответствует TLD для TLD "%tld%"', 
		Zend_Validate_Hostname::UNDECIPHERABLE_TLD => '"%value%" - это DNS имя хоста. Не удаётся извлечь TLD часть', 
		Zend_Validate_Hostname::INVALID_HOSTNAME => '"%value%" - не соответствует ожидаемой структуре для DNS имени хоста', 
		Zend_Validate_Hostname::INVALID_LOCAL_NAME => '"%value%" - адрес является недопустимым локальным сетевым адресом', 
		Zend_Validate_Hostname::LOCAL_NAME_NOT_ALLOWED => '"%value%" - адрес является сетевым расположением, но локальные сетевые адреса не разрешены', 
		Zend_Validate_Identical::NOT_SAME => 'Значения не совпадают', 
		Zend_Validate_Identical::MISSING_TOKEN => 'Не было введено значения для проверки на идентичность', 
		Zend_Validate_InArray::NOT_IN_ARRAY => '"%value%" не найдено в перечисленных допустимых значениях', 
		Zend_Validate_Int::NOT_INT => '"%value%" не является целочисленным значением', 
		Zend_Validate_Ip::NOT_IP_ADDRESS => '"%value%" не является правильным IP-адресом', 
		Zend_Validate_LessThan::NOT_LESS => '"%value%" не меньше, чем "%max%"', 
		Zend_Validate_NotEmpty::IS_EMPTY => 'Введённое значение пустое, заполните поле, пожалуйста', 
		Zend_Validate_Regex::NOT_MATCH => 'Значение "%value%" не подходит под шаблон регулярного выражения "%pattern%"', 
		Zend_Validate_StringLength::TOO_SHORT => 'Длина введённого значения "%value%", меньше чем %min% симв.', 
		Zend_Validate_StringLength::TOO_LONG => 'Длина введённого значения "%value%", больше чем %max% симв.', 
		Router_Framework_Validator_Uri::ERROR => '"%value%" должен быть уникальным в рамках родительского подраздела',
		Publications_Framework_Validator_UniqPublicationType::ERROR => '"%value%" должен быть уникальным типом публикации',
		Publications_Framework_Validator_UniqField::ERROR => '"%value%" должен быть уникальным полем в рамках типа публикации',
		Access_Framework_Validator_UniqResource::ERROR => '"%value%" уже в списке привелегий',
		Access_Framework_Validator_UniqRole::ERROR => 'Роль "%value%" уже существует',
		Access_Framework_Validator_RePassword::ERROR => 'Введённые пароли не совпадают',
		Access_Framework_Validator_UniqLogin::ERROR => 'Пользователь "%value%" уже существует',
		Access_Framework_Validator_UniqEmail::ERROR   => 'Такой E-mail ("%value%") уже существует',
		Publications_Framework_Validator_CustomRegexp::ERROR => '"%value%" не является коррекнтым значением',
		Zend_Captcha_Word::BAD_CAPTCHA   => 'Введённые символы не совпадают.',
	); 
	
	protected $elementDecorators = array(
	    'ViewHelper',
	    'Errors',
	    array(array('data'  => 'HtmlTag'), array('tag' => 'div', 'class' => 'element text')),
	    array(array('label' => 'Label'), array('class' => 'label')),
	    array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form_row clearfix')),
	);
	
	protected $elementCheckboxDecorators = array(
	     'ViewHelper',
	    'Errors',
	    array(array('data'  => 'HtmlTag'), array('tag' => 'div', 'class' => 'element checkbox')),
	    array(array('label' => 'Label'), array('class' => 'label checkbox_label', 'placement' => 'append')),
	    array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form_row clearfix')),
	);
	
	protected $elementRadioDecorators = array(
		'ViewHelper',
	    'Errors',
	    array(array('data'  => 'HtmlTag'), array('tag' => 'div', 'class' => 'element radio')),
	    array(array('label' => 'Label'), array('class' => 'label radio_label', 'placement' => 'prepend')),
	    array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form_row form_row_radio clearfix')),
	);
	
	protected $elementSubmitDecorators = array(
	    'ViewHelper',
	    'Errors',
	    array(array('data'  => 'HtmlTag'), array('tag' => 'div', 'class' => 'element submit')),
	    array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form_row z_buttons_placehoder clearfix')),
	);
	
	protected $elementCaptchaDecorators = array(
	    'Captcha',
	    'Errors',
	    array(array('data'  => 'HtmlTag'), array('tag' => 'div', 'class' => 'element captcha')),
	    array(array('label' => 'Label'), array('class' => 'label')),
	    array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form_row clearfix')),
	);
	
	protected $elementFileDecorators = array(
	    'File',
	    'Errors',
	    array(array('data'  => 'HtmlTag'), array('tag' => 'div', 'class' => 'element file')),
	    array(array('label' => 'Label'), array('class' => 'label')),
	    array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'form_row clearfix')),
	);
	
	
	protected $elementHiddenDecorators = array(
	    'ViewHelper',
	    'Errors',
	    array(array('data'  => 'HtmlTag'), array('tag' => 'div', 'class' => 'element file')),
	    array(array('label' => 'Label'), array('class' => 'label')),
	    array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'hidden')),
	);
	
	
	public function addElement($element, $name = null, $options = null) {
		
		switch ($element) {
			case 'checkbox':
					$options['decorators'] = $this->elementCheckboxDecorators;
				break;
			case 'multiCheckbox':
			case 'radio':
					$options['decorators'] = $this->elementRadioDecorators;
				break;
			case 'submit':
					$options['decorators'] = $this->elementSubmitDecorators;
				break;
			case 'captcha':
					$options['decorators'] = $this->elementCaptchaDecorators;
				break;
			case 'file':
					$options['decorators'] = $this->elementFileDecorators;
				break;
			case 'hidden':
					$options['decorators'] = $this->elementHiddenDecorators;
				break;
			default:
					$options['decorators'] = $this->elementDecorators;
				break;
		}
		
		//if ($element != 'captcha' && $element != 'file') {
			$options['decorators'][sizeof($options['decorators']) - 1][1]['id'] = 'row_' . $name;
			$options['decorators'][sizeof($options['decorators']) - 2][1]['class'] = 'label_' . $element;
		//}
		
		return parent::addElement($element, $name, $options);
		
	}
	
	public function __construct($options = null) {
		
		parent::__construct($options);
		
		if (is_array($options) && isset($options['id'])) {
			$this->_formID = $options['id'];
			$this->addElement('hidden', 'form_name', array(
				'value'	=> $this->_formID
			));
		}
		
	}
	
	public function hasErrors() {
		
		$request = Zend_Controller_Front::getInstance()->getRequest();

		if ($this->_formID == $request->getParam('form_name') || $this->_formID === null) {
			return parent::hasErrors();
		}
		
		
	}
	
}