<?php

require_once ABSPATH.'simpletest/autorun.php';
require_once ABSPATH.'CombinationStatistics.php';
//require_once ABSPATH.'CombinationGenerator.php';

class CombinationStatisticsTest extends UnitTestCase
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

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown()
    {
    }

    public function testIdLength() {
        echo("<h3>Testing the string length of the id is always 12</h3>");
        $n = new Combination($this->staticC1);
        d($n->id);
        $this->assertEqual(strlen($n->id),12);
    }

    public function testSort(){
        $ns = $this-> randNumbers();
        //d($ns);
        $C = new Combination($ns);
        for ($i=0; $i < 5; $i++) { 
            //d($C->d[$i]->n); 
            //d($C->d[$i+1]->n);
            if($C->d[$i]->n > $C->d[$i+1]->n) {
                $this->error('sort error');
            }
        }
    }

    public function randNumbers() {
        $comb = array();
        $list = array();
        for ($i=0; $i < 6; $i++) { 
            $comb[$i] = CombinationGenerator::genUniqueRand($list, 1, 60);
            $list[] = $comb[$i];
        }
        return $comb;
    }

}
