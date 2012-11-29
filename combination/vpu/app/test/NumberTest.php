<?php

//require_once ABSPATH.'simpletest/autorun.php';
require_once '../../../Number.php';

class NumberTest extends PHPUnit_Framework_TestCase
{
    public function test_Create_New_Number_With_number_Single_digit() {
        $n = new Number(1);
        $this->standard($n);
    }

    public function test_Create_New_Number_With_number_double_digit() {
        $n = new Number(12);
        $this->standard($n);
    }

    public function test_Create_New_Numbe_rWith_String_leading_0() {
        $n = new Number('02');
        $this->standard($n);
    }

    public function standard($n) {        
        //$this->assertNotNull($n);
        $this->assertEquals(strlen($n->n), 2);
        $this->assertThat(
          $n,
          $this->logicalNot(
            $this->equalTo(NULL)
          )
        );
    }

}
