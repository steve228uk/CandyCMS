<?

/**
* @package CandyCMS
* @version 1.0
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Extends PDO
*/

class CandyDB extends PDO {

	private static $dbh;

	/**
	 * @var PDOStatement $pdo_statement
	 */
	protected $pdo_statement;
	protected $fetch_mode;

	/**
	 * @method __construct()
	 * @returns nothing
	 * 
	 * Connects to the database using defined constants
	 */
	
	function __construct(){
		parent::__construct(DB_DRIVER.':dbname='.DB_NAME.';host='.DB_HOST, DB_USERNAME, DB_PASSWORD);
		$this->fetch_mode = PDO::FETCH_OBJ;
	}

	public static function get() {
		if(!isset(self::$dbh)) {
			self::$dbh = new CandyDB();
		}
		return self::$dbh;
	}

	public function do_query($sql, $parameters = array()) {
		$db = CandyDB::get();
		if($this->pdo_statement != null) {
			$this->pdo_statement->closeCursor();
		}
		$this->pdo_statement = $db->prepare($sql);
		$this->pdo_statement->setFetchMode( $this->fetch_mode );
		try{ 
			if (!empty($parameters)) {
				$this->pdo_statement->execute( $parameters );
			} else {
				$this->pdo_statement->execute();
			}
			return true;
		} catch(Exception $e) {
			var_dump($e->getTrace());
			return false;
		}
	}

	public static function q($sql, $parameters = array()) {
		$db = CandyDB::get();
		return $db->do_query($sql, $parameters);
	}

	public static function results($sql, $parameters = array()) {
		$db = CandyDB::get();
		$db->fetch_mode = PDO::FETCH_OBJ;
		$db->do_query($sql, $parameters);
		return $db->pdo_statement->fetchAll();
	}

	public static function row($sql, $parameters = array()) {
		$db = CandyDB::get();
		$db->fetch_mode = PDO::FETCH_OBJ;
		$db->do_query($sql, $parameters);
		return $db->pdo_statement->fetch();
	}

	public static function col($sql, $parameters = array()) {
		$db = CandyDB::get();
		$db->do_query($sql, $parameters);
		return $db->pdo_statement->fetch(PDO::FETCH_COLUMN);
	}

	public static function val($sql, $parameters = array()) {
		$db = CandyDB::get();
		$db->fetch_mode = PDO::FETCH_NUM;
		$db->do_query($sql, $parameters);
		$row = $db->pdo_statement->fetch();

        if($row)
		    return reset($row);
        else
            return $row;
	}

	public static function keyvalue($sql, $parameters = array()) {
		$db = CandyDB::get();
		$db->fetch_mode = PDO::FETCH_NUM;
		$db->do_query($sql, $parameters);
		$result = $db->pdo_statement->fetchAll();
		$output = array();
		foreach ( $result as $item ) {
			$output[$item[0]] = $item[1];
		}
		return $output;
	}

	public static function last_insert_id() {
		$db = CandyDB::get();
		return $db->lastInsertId();
	}

}