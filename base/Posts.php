<?php
require_once 'DataBoundObject.php';
require_once 'Admin.php';
/**
 * 
 * This class helps us to do operations with Admin Table
 * @author Adarsha
 */

class Posts  {

	protected $User;
	protected $Title;
	protected $Data;
	protected $RelativePath;

	protected $UserObject;

	const FILE_TO_STORE_DATA = "SOM_letter.html";
	const FILE_TO_STORE_TITLE = "SOM_letter_title.html";
	
	public function __construct($relativePath = null) {
		$this->User = null;
		$this->Title = null;
		$this->Data = null;

		if(file_exists($relativePath.self::FILE_TO_STORE_DATA)) {
			$this->setData(file_get_contents($relativePath.self::FILE_TO_STORE_DATA));
		}
		if(file_exists($relativePath.self::FILE_TO_STORE_TITLE)) {
			$this->setTitle(file_get_contents($relativePath.self::FILE_TO_STORE_TITLE));	
		}
		$this->RelativePath = $relativePath;
	}

	public function setUser($name) {
		try {
			$this->UserObject = new Admin(array($name));
		}
		catch (Exception $e) {
			throw new Exception("The user you are trying to assign doesnt exist");
		}
	}

	public function save() {
		if(file_put_contents($this->RelativePath.self::FILE_TO_STORE_DATA, $this->getData(), LOCK_EX) === false)
			throw new Exception("Writing to main file failed to save post data.");
		if(file_put_contents($this->RelativePath.self::FILE_TO_STORE_TITLE, $this->getTitle(), LOCK_EX) === false)
			throw new Exception("Writing to title file failed to save post title.");
	}

	/**
	 * General calling function
	 * Creates the getXX() and setXX() method for class variaibles.
	 * This can be overided for class specific behaviour.
	 * @param sting $strFunction
	 * @param ArrayObject $arArguments
	 * @throws Exception
	 */
	public function __call($strFunction, $arArguments) {
		$strMethodType = substr ( $strFunction, 0, 3 );
		$strMethodMember = substr ( $strFunction, 3 );
		switch ($strMethodType) {
			case "set" :
				if (property_exists ( $this, $strMethodMember )) {
						//echo '$this->' . $strMethodMember . " = $arArguments[0];";
						eval ( '$this->' . $strMethodMember . ' = $arArguments[0];' );
				} else {
					throw new Exception ( "Property name doesnt exist!" );
				}
				break;
			case "get" :
				
				if (property_exists ( $this, $strMethodMember )) {
						eval ( '$tmp = $this->' . $strMethodMember . ';' );
						return $tmp;
				} else {
					throw new Exception ( "Property name doesnt exist!" );
				}
				break;
			default :
				throw new Exception ( "Non existent method call!" );
		}
		return false;
	}
}
?>