<?php
namespace parser;

/*******************
* Author: Alex Skovrup
* Date: 03-05-2019
*******************/

class TemplateParser{
	/*****
	* Class parses html 
	*****/
	
	function __construct(){
		//Sets placeholder 
		$this->setPlaceholder(':');
		//Sets if data is file or string
		$this->setHtmlFile(false);
	}
	
	/***
	* Variables
	***/
	private $placeholder;
	private $htmlIsFile;
	
	/***
	* Setters
	***/
	function setPlaceholder($type){
		$this->placeholder = $type;
	}
	
	function setHtmlFile($fileStatus){
		$this->htmlIsFile = $fileStatus;
	}
	
	/***
	* Functional methods
	***/
	function prepareData($data){
		/*Checks if data is object or array
		If data is array, make object*/
		if(is_array($data)){
			$arr = $data;
			$data = new \stdClass();
			
			foreach($arr as $key=>$val){
				$data->$key = $val;
			}
			
		}elseif(!is_object($data)){
			return 'Placeholders must be either array or objects';
		}
		
		return $data;
	}
	
	function prepareHtml($input){
		//Check if html is file or string
		if(file_exists($input)){
			$html = file_get_contents($input);
		}elseif($this->htmlIsFile){
			return 'could not find file '.$input;
		}else{
			$html = $input;
		}
		
		//Return as string
		return $html;
	}
	
	function validateHtml($html){
		//Remove exstra white space
		$html = trim(preg_replace('/\s+/',' ', $html));
		
		//Check characters
		if(preg_match('/[^A-Za-z0-9.#\\-$(?<=<).*?(?=>):;,!?\/@ ]/', $html)){
			return false;
		}
		
		return $html;
	}
	
	function parseHtml($data, $html, $returnType=""){
		//Prepare data
		$data = $this->prepareData($data);
		$html = $this->prepareHtml($html);
		
		//Placeholder type
		$placeholder = $this->placeholder;
		
		//Replace placeholders
		foreach($data as $key => $value){
			$html = str_replace($placeholder.$key, $value, $html, $count);
			
			if($count == 0){
				// Error, missing placeholder
				return 'Error '.$key.' not found';
			}
		}
		
		//Validate html and return
		if($html = $this->validateHtml($html)){
			if(!$returnType){
				return $html;
			}else{
				return $this->export($returnType);
			}
		}else{
			return 'non valid characters found!';
		}
	}
	
	function export($returnType){
		//Can be used for different exports. (Such as pdf or html file)
	}
}