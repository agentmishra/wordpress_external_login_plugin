<?php

class PasswordValidationTest extends \Codeception\TestCase\WPTestCase {

    protected $options_tools;

    public function setUp() {
        // before
        parent::setUp();

        // your set up methods here
    }

    public function tearDown()
    {
        // your tear down methods here

        // then
        parent::tearDown();
    }

    public function test_when_algorithm_is_phpass_and_no_salt_validates_a_valid_password_hash() {
        include "lib/Exlog_password_validator.php";
        include "login/validate_password.php";
        include "options/wpconfig_options.php";


        $test_fetcher = $this->make('Exlog_password_validator', [
            'get_salting_method' => 'none',
            'get_algorithm_type' => 'phpass',
        ]);
        $this->assertTrue(exlog_validate_password("password", '$2b$10$MaTFwF7Ov2JRTTPnV.I4X.q0KQ3VVAiwTzULlPnBYeSBkBztnXfJO', false, $test_fetcher));
    }

}