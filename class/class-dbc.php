<?php
/* class-dbc
 * creates a mysqli database
 * connection
 */
class dbc extends mysqli {
	private string $DB_NAME;
	private string $charset;
	private string $DB_USER;
	private string $DB_PASSWORD;
	private string $DB_HOST;
	public array $queries;

	public function __construct(array $queries){
		$this->queries = $queries;
		$DB_NAME = 'tribe';
		$charset = 'utf8';
		//$DB_USER = 'root';
		//$DB_PASSWORD = 'hIqBb6IMqdtO';
		//$DB_HOST = '127.0.0.1';
		$DB_USER = 'dic3jam';
		$DB_PASSWORD = 'password';
		$DB_HOST = 'localhost';
		parent::__construct($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
		if($this->connect_errno)
			throw new RuntimeException('mysqli connection error: ' . $this->connect_error);
		else
			$this->set_charset($charset);	
	}

	public function toString() : string {
		return "DBC: " . $this->connect_errno;
	}
}
?>

