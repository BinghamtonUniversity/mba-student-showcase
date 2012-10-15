<?php
require_once 'DataBoundObject.php';
require_once 'include_top.php'
/**
 * 
 * This class helps us to do operations with Admin Table
 * @author Adarsha
 */

class ResumeInfo extends DataBoundObject {

	protected $SID;
	protected $Data;

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
		return 'SOM_RESUME_INFO';
	}
	
	/**
	 * 
	 * @see DataBoundObject::DefineRelationMap()
	 */
	protected function DefineRelationMap() {
	
	return array(
			"SID" => "SID",
			"DATA" => "Data"
		);
	}
	
	/**
	 * 
	 * @see DataBoundObject::DefineID()
	 */
	protected function DefineID() {
		return null;
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
}
?>