<?php

require_once '../../../CombinationStatistics.php';

class CombinationStatisticsTest extends PHPUnit_Framework_TestCase
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
        $this->C = new CombinationStatistics('562418013744');

    }

    public function test_find_cRd() {
        print_r($this->C->cRd);

        $this->assertEquals($this->C->cRd, '111111');
    }

    public function test_find_cRf() {
        $this->assertEquals($this->C->cRf, '21111');
    }

    public function test_find_cDd() {
        print_r($this->C->print_cDd());

        $this->assertEquals($this->C->print_cDd(), '012345');
    }

    public function test_find_cDf() {
        print_r($this->C->print_cDf());

        $this->assertEquals($this->C->print_cDf(), '14(2)678');
    }
    public function test_find_cRd_cRf() {
        print_r($this->C->cRd_cRf);

        $this->assertEquals($this->C->cRd_cRf, '111111-21111');
    }
    public function test_foe() {
        print_r($this->C->foe);

        $this->assertEquals($this->C->foe, '1678');
    }
    public function test_public_sample() {
        print_r($this->C);
    }
}
