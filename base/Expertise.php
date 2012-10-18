<?php
require_once 'DataBoundObject.php';
require_once 'include_top.php';
/**
 * 
 * This class helps us to do operations with Admin Table
 * @author Adarsha
 */

class Expertise extends DataBoundObject {

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
		return 'SOM_EXPERTISE';
	}
	
	/**
	 * 
	 * @see DataBoundObject::DefineRelationMap()
	 */
	protected function DefineRelationMap() {
	
	return array(
			"TAG" => "Tag"
		);
	}
	
	/**
	 * 
	 * @see DataBoundObject::DefineID()
	 */
	protected function DefineID() {
		return array('TAG');
	}

	public function setTag($tag) {
		$tag = trim($tag);
		if(strlen($tag) > 0 && strlen($tag) <= 255)
			parent::setTag($tag);
		else
			throw new Exception("Tag should be between 1 and 255 charecters", 1);
	}

	public static function AllTags() {
		$result = Database::query("SELECT * FROM SOM_EXPERTISE");
		$ans = array();
		for($row = $result->fetch();$row;$row = $result->fetch())
		{
			$e = new Expertise();
			$e->populateData($row);				
			$ans[] = $e;
		}
		
		return $ans;
	}
}
?>