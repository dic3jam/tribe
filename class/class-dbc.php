<?php
/* class-dbc
 * creates a mysqli database
 * connection
 */
class dbc extends mysqli {
	private string $DB_USER = 'root';
	private string $DB_PASSWORD = 'hIqBb6IMqdtO';
	private string $DB_HOST = '127.0.0.1';
	private string $DB_NAME = 'tribe';
	private string $charset = 'utf8';

	public function __construct(){
		parent::__construct($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
		if($this->connect_errno)
			throw new RuntimeException('mysqli connection error: ' . $this->connect_error);
		else
			$this->set_charset($charset);	
	}


}
?>

