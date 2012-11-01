<?php

require_once '../../../Combination.php';
//require_once '../../../CombinationGenerator.php';

class CombinationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CombinationGenerator
     */
    protected $C;
    protected $staticC1;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $this->staticC1 = array(new Number(9),new Number(2),new Number(3),
                          new Number(4),new Number(5),new Number(6));
    }

    public function test_Create_new_from_array_of_N() {        
        $this->C = new Combination($this->staticC1);
        $this->assertEquals($this->C->id, '020304050609');
    }

    public function test_Create_new_from_string_id() {        
        $this->C = new Combination('020304050609');
        $this->assertEquals($this->C->id, '020304050609');
    }

    public function testIdLength() {
        $n = new Combination($this->staticC1);
        $this->assertEquals(strlen($n->id),12);
    }

    public function testSort(){
        $ns = $this-> randNumbers();
        $C = new Combination($ns);
        for ($i=0; $i < 5; $i++) { 
            print_r($C->d[$i]->n);
            $this->assertLessThan($C->d[$i+1]->n,$C->d[$i]->n);
        }
    }

    public function randNumbers() {
        $comb = array();
        $list = array();
        for ($i=0; $i < 6; $i++) { 
            $comb[$i] = $this->genUniqueRand($list, 1, 60);
            $list[] = $comb[$i];
        }
        return $comb;
    }

    public function genUniqueRand($comb, $min, $max) {
            
        $N = new Number(mt_rand($min, $max));

        while (in_array($N, $comb)) {
            unset($N);
            $N = new Number(mt_rand($min, $max));
        }
        return $N;
    }

}
