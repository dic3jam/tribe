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

class notLoggedInException extends RuntimeException {
	public function __construct($message = "You are not logged in", $code = 0, Throwable $previous = null) {

		parent::__construct($message, $code, $previous);
	}
}

class invalidPictureException extends Exception {
	public function __construct($message = "Invalid picture upload", $code = 0, Throwable $previous = null) {

			parent::__construct($message, $code, $previous);
		}
}

class invalidMemberException extends InvalidArgumentException {
	public function __construct($message = "Not a member of this tribe", $code = 0, Throwable $previous = null) {

			parent::__construct($message, $code, $previous);
		}
}
?>
