<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
include '../trait/trait-password.php';

final class testPassword extends TestCase {
  use password;

  private object $mockPassword;

  public function setUp() : void {
    $mockPassword = $this->getMockForTrait(password::class);
  }

  public function testFailValidPassword() : void {
    $this->expectException(passwordLengthException::class);
    $mockPassword->validPassword("thcngjkquthgyqtdgcjkbnahe");
  }

  public function testPassValidPassword() : void {
    $this->assertTrue($mockPassword->validPassword("password"));
  }


}
?>