<?php
class Users extends Doctrine_Record {
/////
	public function setTableDefinition() {
		$this->hasColumn('fname', 'varchar', 255);
		$this->hasColumn('lname', 'varchar', 255);
		$this->hasColumn('email', 'string', 255, array('unique' => 'true'));
		$this->hasColumn('username', 'string', 255, array('unique' => 'true'));
		$this->hasColumn('password', 'string', 255);
		$this->hasColumn('usertype_id', 'integer', 11);
		$this->hasColumn('telephone', 'varchar', 255);
		$this->hasColumn('district', 'varchar', 255);
		$this->hasColumn('facility', 'varchar', 255);
		$this->hasColumn('status', 'int', 11);
		$this->hasColumn('county_id', 'int', 11);
		
	}
	
	public function setUp() {
		$this->setTableName('user');
		$this->actAs('Timestampable');
		$this->hasMutator('password', '_encrypt_password');
		$this -> hasMany('Facilities as Codes', array('local' => 'facility', 'foreign' => 'facility_code'));
		$this -> hasMany('access_level as u_type', array('local' => 'usertype_id', 'foreign' => 'id'));
		$this -> hasMany('facilities as hosi', array('local' => 'facility', 'foreign' => 'facility_code'));
	    $this -> hasOne('Facility_Issues as idid', array('local' => 'id', 'foreign' => 'issued_by'));
		
		
	}

	protected function _encrypt_password($value) {
		$salt = '#*seCrEt!@-*%';
		$this->_set('password', md5($salt . $value));
		
	}
	public static function login($username, $password) {
		
		$salt = '#*seCrEt!@-*%';
		$value=( md5($salt . $password));
		$query = Doctrine_Query::create() -> select("*") -> from("Users") -> where("username = '" . $username . "' and password='". $value ."'");

		$x = $query -> execute();
		return $x[0];
		
		
	}
	public static function getsome($id) {
		$query = Doctrine_Query::create() -> select("fname") -> from("users")->where("id='$id' ");
		$level = $query -> execute();
		return $level;
	}
	



}
