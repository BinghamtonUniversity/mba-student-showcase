<?php
require_once 'DataBoundObject.php';
require_once 'include_top.php'
/**
 * 
 * This class helps us to do operations with Admin Table
 * @author Adarsha
 */

class StudentExpertise extends DataBoundObject {

	protected $SID;
	protected $Tag;

	public function __construct(array $idVals = array()) {
		parent::__construct($idVals);
	}

	function __destruct() {
		parent::__destruct();
	}

	/**
	 * 
	 * @see DataBoundObject::DefineAutoIncrementField()
	 */
	protected function DefineAutoIncrementField() {	
		return null;	
	}
	
	/**
	 * 
	 * @see DataBoundObject::DefineTableName()
	 */
	protected function DefineTableName() {
		return 'SOM_STUDENT_EXPERTISE';
	}
	
	/**
	 * 
	 * @see DataBoundObject::DefineRelationMap()
	 */
	protected function DefineRelationMap() {
	
	return array(
			"SID" => "SID",
			"TAG" => "Tag"
		);
	}
	
	/**
	 * 
	 * @see DataBoundObject::DefineID()
	 */
	protected function DefineID() {
		return array('SID','TAG');
	}

	public function insert() {
		try{
			new StudentExpertise(array($this->getSID(),$this->getTag));
			throw new Exception("Duplicate Entry in tag/suid", 1);
			
		}
		catch (Exception $e) {
			//ok not a duplicate
			parent::insert();
		}

	}

	public function setSID($id) {
		try {
			new Student(array($id));
			parent::setSID($id);
		}
		catch(Exception $e) {
			throw new Exception("Wrong user ID!", 2);
		}
	}

	public function setTag($tag) {
		$tag = trim($tag);
		if(strlen($tag) > 0 && strlen($tag) <= 255)
			parent::setTag($tag);
		else
			throw new Exception("Tag name too long.", 3);
			
	}
}
?>