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

    // tests
    public function testMe() {
        include "login/validate_password.php";
        function exlog_get_option($option) {
            switch ($option) {
                case 'external_login_option_db_salting_method':
                    return 'none';
                case 'external_login_option_hash_algorithm':
                    return 'phpass';
            }
        }

        $this->assertTrue(exlog_validate_password("password", '$2b$10$MaTFwF7Ov2JRTTPnV.I4X.q0KQ3VVAiwTzULlPnBYeSBkBztnXfJO', false));
    }

}