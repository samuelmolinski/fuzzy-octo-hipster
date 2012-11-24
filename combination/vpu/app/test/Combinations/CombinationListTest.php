<?php

require_once '../../../CombinationList.php';

class CombinationListTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CombinationGenerator
     */
    protected $CL = new CombinationList;
    protected $staticC1;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
       
    }

    public function testAddSingleNumber() {
        $C = $this->randCombination();
        print_r($C->print_id());
        assertEquals(true, $CL->add($C), 'Add random combination');
        print_r($CL->list);
    }

    public function randCombination() {
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
