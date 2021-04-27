<?php
/* Exceptions.php
 * Contains the custom exceptions
 * for tribe.com
 */
class invalidUsernameException extends InvalidArgumentException {

	public function __construct($message = "Invalid Username", $code = 0, Throwable $previous = null) {
    
		parent::__construct($message, $code, $previous);
	}
}

class passwordLengthException extends InvalidArgumentException {

	public function __construct($message = "Password is too long", $code = 0, Throwable $previous = null) {
    
		parent::__construct($message, $code, $previous);
	}
}

class invalidPasswordException extends InvalidArgumentException {

	public function __construct($message = "Invalid Password", $code = 0, Throwable $previous = null) {
    
		parent::__construct($message, $code, $previous);
	}
}

class queryFailedException extends RuntimeException {

	public function __construct($message = "Query failed", $code = 0, Throwable $previous = null) {
    
		parent::__construct($message, $code, $previous);
	}
}

class badLoginException extends RuntimeException {

	public function __construct($message = "Login failed", $code = 0, Throwable $previous = null) {
    
		parent::__construct($message, $code, $previous);
	}
}

?>
