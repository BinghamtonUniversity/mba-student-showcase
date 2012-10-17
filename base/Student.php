<?php
require_once 'DataBoundObject.php';
require_once 'include_top.php';
/**
 * 
 * This class helps us to do operations with Admin Table
 * @author Adarsha
 */

class Student extends DataBoundObject {

	protected $UserID = null;
	protected $Name = null;
	protected $Description = null;
	protected $URL = null;
	protected $Status = null;

	//protected $Expertises = array();

	const STATUS_PUBLISHED = 1;
	const STATUS_NOT_PUBLISHED = 0;

	protected $ResumeInfoObj = null;
	
	public function __construct(array $idVals = array()) {
		parent::__construct($idVals);
		if($this->UserID !== null) {
			try {
				$this->ResumeInfoObj = new ResumeInfo(array($this->UserID));
			}
			catch(Exception $e) {
				//no resume found for this user.. no problem
			}
		}
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

	private function setResumeInfoObj($filePath) {
		throw new Exception("cant set it explicitly", 1);
		
	}

	public function getResumeInfoObj() {
		if( $this->ResumeInfoObj !== null )
			return parent::getResumeInfoObj();
		else {
			//will throw an error if unable to load
			$this->ResumeInfoObj = new ResumeInfo(array($this->UserID));
			return parent::getResumeInfoObj();
		}
	}

	public function updateResumeInfo($uploadedFile ,$relativePath = "") {

		if($this->UserID === null)
			throw new Exception("Cant call it directly without data association with an user id", 1);
			
		$filePath = $relativePath."resume-pdfs/".$this->getUserID().".pdf";
		//if(file_exists($filePath))
		//	unlink($filePath);
		if(move_uploaded_file($uploadedFile['tmp_name'], $filePath) !== true) {
			throw new Exception("Couldnt move the resume to the destination directory. $filePath Resume not updated", 1);
		}
		try {

			include_once 'pdf2text.php';

			try {
				//does an entry already exist?
				$tmp = new ResumeInfo(array($this->UserID));
				//yes if it continues!
				$tmp->setData(pdf2text($filePath));
				$tmp->setSID($this->UserID,true);
				$tmp->save();
			}
			catch(Exception $e) {
				echo "<br/>here<br/>";
				$tmp = new ResumeInfo();
				$tmp->setData(pdf2text($filePath));
				$tmp->setSID($this->UserID,true);
				$tmp->insert();
			}
		}
		catch(Exception $e) {
			//silently fail all errors as we donot know every thing about php's pdf to text conversion
			$this->ResumeInfoObj = null;
			return;
		}

		//continued without errors :)
		$this->ResumeInfoObj = $tmp;
	}

	public static function checkResumeValidity($resume) {
		if($resume['error'] !== UPLOAD_ERR_OK )
			throw new Exception("Error in uploading resume", 1);
			

		if(!($resume['type'] == "application/pdf" || $resume['type'] == "text/pdf")) {
			throw new Exception("Wrong type of input file");
		}

		if($resume['size'] == 0 || $resume['size'] > (52428800)) { // 50MB 
			throw new Exception("File size must be maximum of 50MB", 1);
			
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