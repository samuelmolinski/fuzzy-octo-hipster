<?php

require_once ABSPATH.'simpletest/autorun.php';
require_once ABSPATH.'Number.php';

class NumberTest extends UnitTestCase
{
    /**
     * @var CombinationGenerator
     */
    protected $N;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown()
    {
    }

    public function testCreateNewNumberWithNumber() {
        echo("<h3>Testing testCreateNewNumberWithNumber</h3>");
        $n = new Number(12);
        $this->standard($n);
    }

    public function testCreateNewNumberWithNumber2() {
        echo("<h3>Testing testCreateNewNumberWithNumber2</h3>");
        $n = new Number(1);
        $this->standard($n);
    }

    public function testCreateNewNumberWitString() {
        echo("<h3>Testing testCreateNewNumberWitString</h3>");
        $n = new Number('02');
        $this->standard($n);
    }

    public function standard($n) {        
        $this->assertNotNull($n);
        $this->assertEqual(strlen($n->n), 2);
    }

}
