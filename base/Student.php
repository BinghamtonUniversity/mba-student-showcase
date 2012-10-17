<?php
require_once 'DataBoundObject.php';
require_once 'include_top.php';
/**
 * 
 * This class helps us to do operations with Admin Table
 * @author Adarsha
 */

class Student extends DataBoundObject {

	protected $UserID;
	protected $Name;
	protected $Description;
	protected $URL;
	protected $Status;

	//protected $Expertises = array();

	const STATUS_PUBLISHED = 1;
	const STATUS_NOT_PUBLISHED = 0;
	
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
		return 'ID';	
	}
	
	/**
	 * 
	 * @see DataBoundObject::DefineTableName()
	 */
	protected function DefineTableName() {
		return 'SOM_STUDENT';
	}
	
	/**
	 * 
	 * @see DataBoundObject::DefineRelationMap()
	 */
	protected function DefineRelationMap() {
	
	return array(
			"ID" => "UserID",
			"NAME" => "Name",
			"DESCRIPTION" => "Description",
			"RESUME_URL" => "URL",
			"STATUS" => "Status"
		);
	}
	
	/**
	 * 
	 * @see DataBoundObject::DefineID()
	 */
	protected function DefineID() {
		return array('ID');
	}

	public function markForDeletion() {
		//delete all references first
		parent::markForDeletion();
	}

	private function setUserID() {
		throw new Exception("cant set ID");
	}

	public function setName($name) {
		$name = trim($name);
		if(strlen($name) > 1 && strlen($name) <= 999)
			parent::setName($name);
		else
			throw new Exception("Name can be between 2 and 999 charecters only", 1);
	}

	public function setDescription($desc) {
		$desc = trim($desc);
		if(strlen($desc) > 1 && strlen($desc) <= 999)
			parent::setDescription($desc);
		else
			throw new Exception("Description can be between 2 and 999 charecters only", 2);
	}

	public function setStatus($sta)
	{
		if($sta != self::STATUS_PUBLISHED && $sta != self::STATUS_NOT_PUBLISHED)
			throw new Exception ("Wrong status");
		parent::setStatus($sta);
	}

	public static function checkResumeValidity($resume) {
		if($resume['type'] == "application/pdf" || $resume['type'] == "text/pdf") {
			return true;
		}
		return false;
	}

	public static function ALlStudents($sort = false) {
		$query = "SELECT * FROM SOM_STUDENT";
		if($sort) $query .=" ORDER BY NAME ASC ";

		$result = Database::query($query);

		$ans = array();
		for($row = $result->fetch();$row;$row = $result->fetch())
		{
			$e = new Student();
			$e->populateData($row);
			$ans[] = $e;
		}
		
		return $ans;
	}
}
?>