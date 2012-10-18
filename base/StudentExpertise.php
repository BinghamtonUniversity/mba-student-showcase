<?php
require_once 'DataBoundObject.php';
require_once 'include_top.php';
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

	public function setSID($id,$skipTest = false) {
		if($skipTest) {
			parent::setSID($id);
			return;
		}
		try {
			new Student(array($id));
			parent::setSID($id);
		}
		catch(Exception $e) {
			throw new Exception("Wrong user ID!", 2);
		}
	}

	public function setTag($tag,$skipTest = false) {
		$tag = trim($tag);
		//check if tag exist
		if($skipTest) {
			parent::setTag($tag);
			return;
		}
		try {
			new Expertise(array($tag));
			//it exist!
			parent::setTag($tag);
		}
		catch(Exception $e) {
			throw new Exception("Tag name doesnt exist");
		}
			
	}

	public static function deleteExpertise($tag) {
		$query = "DELETE FROM SOM_STUDENT_EXPERTISE WHERE TAG = ?";
		return Database::query($query,$tag);
	}

	public static function deleteExpertiseForSid($sid) {
		echo $sid;
		$query = "DELETE FROM SOM_STUDENT_EXPERTISE WHERE SID = ?";
		return Database::query($query,$sid);
	}

	public static function getExpertises($sid) {
		$query = "SELECT * FROM SOM_STUDENT_EXPERTISE WHERE SID = ?";
		$result = Database::query($query,$sid);

		$ans = array();
		for($row = $result->fetch();$row;$row = $result->fetch())
		{
			$e = new StudentExpertise();
			$e->populateData($row);
			$ans[] = $e;
		}
		
		return $ans;

	}

	public static function setExpertises($sid,$expertises = array()) {
		//does sid exist?
		try {
			new Student(array($sid));
		}
		catch (Exception $e) {
			//doesnt exist?
			throw new Exception("The student doesnt exist!", 1);
		}
		foreach ($expertises as $key => $value) {
			try {
				new StudentExpertise(array($sid,$value));
				//does the entry exist?
				//then ignore
				continue;
			}
			catch(Exception $e) {
				//do Nothing
			}
				
			//entry doesnt exist.. then add
			$tmp = new StudentExpertise();
			$tmp->setTag($value);
			$tmp->setSID($sid);
			//var_dump($tmp);
			$tmp->insert();
		}
	}
}
?>