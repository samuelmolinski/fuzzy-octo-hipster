<?php

require_once '../../../CombinationList.php';
require_once '../../../CombinationStatistics.php';

class CombinationListTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CombinationGenerator
     */
    protected $CL;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
       $this->CL = new CombinationList;
       $this->CL2 = new CombinationList;
    }

    public function testAddSingleCombinationObjs() {
        $C = new Combination($this->randCombination());
        $CS = new CombinationStatistics($this->randCombination());
        $this->assertEquals(true, $this->CL->addCombination($C), 'Add random Combination');
        $this->assertEquals(1, count($this->CL->list), 'List count is equal to 1');
        $this->assertEquals(true, $this->CL->addCombination($CS), 'Add random CombinationStatistics');
        $this->assertEquals(2, count($this->CL->list), 'List count is equal to 2');
        print_r($this->CL->list);
    }

    public function testAddSingleCombinationString() {
        // reset $CL
        $r_str = '01-14-28-34-47-51, 013233515556,02-09-18-30-48-50,203039414356 09-25-32-48-49-58, 172332434654';
        $this->CL = new CombinationList;
        $C = new Combination($this->randCombination());

        $this->assertEquals(true, $this->CL->addString($C->print_id()), 'Add random combination string');
        $this->assertEquals(1, count($this->CL->list), 'List count is equal to 1');
        $this->assertEquals(true, $this->CL->addString($r_str), 'Add multiple random combination strings');
        $this->assertEquals(7, count($this->CL->list), 'List count is equal to 1');
        print_r($this->CL->list);
    }

    public function testAdd() {
        // reset $CL
        $this->CL = new CombinationList;
        $C = new Combination($this->randCombination());
        $CS = new CombinationStatistics($this->randCombination());
        $r_str = array('01-14-28-34-47-51,',' 013233515556,02-09-18-30-48-50,','203039414356 09-25-32-48-49-58, 172332434654');
        $r_Cs = array($C, $CS);
        $r_all = array($r_str, $C, $CS, $r_Cs);

        $this->assertEquals(true, $this->CL->add($r_str), 'Add random combination strings');
        $this->assertEquals(6, count($this->CL->list), 'List count is equal to 6');
        $this->assertEquals(true, $this->CL->add($r_Cs), 'Add random combination strings');
        $this->assertEquals(8, count($this->CL->list), 'List count is equal to 8');
        $this->assertEquals(true, $this->CL->add($r_all), 'Add random combination strings');
        $this->assertEquals(18, count($this->CL->list), 'List count is equal to 18');
        //can add itself
        $this->assertEquals(true, $this->CL->add($this->CL->list), 'Add combinationlist array');
        $this->assertEquals(36, count($this->CL->list), 'List count is equal to 18');
        $this->assertEquals(true, $this->CL->add($this->CL), 'Add CombinationList');
        $this->assertEquals(72, count($this->CL->list), 'List count is equal to 18');
        print_r(count($this->CL->list)."\n");
        print_r($this->CL->list);
    }
    public function testOnlyUnique(){
        $this->CL = new CombinationList;
        $this->CL2 = new CombinationList;
        $C = new Combination($this->randCombination());
        $CS = new CombinationStatistics($this->randCombination());
        $r_str = array('01-14-28-34-47-51,',' 013233515556,02-09-18-30-48-50,','203039414356 09-25-32-48-49-58, 172332434654');
        $r_Cs = array($C, $CS);
        $r_all = array($r_str, $C, $CS, $r_Cs);
        $this->CL->add($r_str);
        $this->CL->add($r_Cs);
        $this->CL->add($r_all);
        $this->CL->add($this->CL->list);
        $this->CL->add($this->CL);

        $this->CL2->add($r_str);
        $this->CL2->add($r_Cs);

        $this->assertEquals(72, count($this->CL->list), 'List count is equal to 72');
        $this->assertEquals($this->CL2->list, $this->CL->onlyUnique(), 'List count is equal to 18');        
        $this->assertEquals(8, count($this->CL->list), 'List count is equal to 8');
    }

    public function testToCombination(){
        $sample = unserialize('a:6:{i:0;O:21:"CombinationStatistics":9:{s:3:"cRd";s:6:"111111";s:3:"cRf";s:4:"2211";s:3:"cDd";a:6:{i:0;i:1;i:1;i:1;i:2;i:1;i:3;i:1;i:4;i:1;i:5;i:1;}s:3:"cDf";a:10:{i:0;i:0;i:1;i:2;i:2;i:0;i:3;i:0;i:4;i:2;i:5;i:0;i:6;i:0;i:7;i:1;i:8;i:1;i:9;i:0;}s:7:"cRd_cRf";s:11:"111111-2211";s:3:"foe";s:3:"DNE";s:8:"group2_2";N;s:2:"id";s:12:"011428344751";s:1:"d";a:6:{i:0;O:6:"Number":3:{s:1:"n";s:2:"01";s:1:"D";i:0;s:2:"DF";s:1:"1";}i:1;O:6:"Number":3:{s:1:"n";s:2:"14";s:1:"D";i:1;s:2:"DF";s:1:"4";}i:2;O:6:"Number":3:{s:1:"n";s:2:"28";s:1:"D";i:2;s:2:"DF";s:1:"8";}i:3;O:6:"Number":3:{s:1:"n";s:2:"34";s:1:"D";i:3;s:2:"DF";s:1:"4";}i:4;O:6:"Number":3:{s:1:"n";s:2:"47";s:1:"D";i:4;s:2:"DF";s:1:"7";}i:5;O:6:"Number":3:{s:1:"n";s:2:"51";s:1:"D";i:5;s:2:"DF";s:1:"1";}}}i:1;O:21:"CombinationStatistics":9:{s:3:"cRd";s:3:"321";s:3:"cRf";s:5:"21111";s:3:"cDd";a:6:{i:0;i:1;i:1;i:0;i:2;i:0;i:3;i:2;i:4;i:0;i:5;i:3;}s:3:"cDf";a:10:{i:0;i:0;i:1;i:2;i:2;i:1;i:3;i:1;i:4;i:0;i:5;i:1;i:6;i:1;i:7;i:0;i:8;i:0;i:9;i:0;}s:7:"cRd_cRf";s:9:"321-21111";s:3:"foe";s:8:"1(2)2356";s:8:"group2_2";i:4;s:2:"id";s:12:"013233515556";s:1:"d";a:6:{i:0;O:6:"Number":3:{s:1:"n";s:2:"01";s:1:"D";i:0;s:2:"DF";s:1:"1";}i:1;O:6:"Number":3:{s:1:"n";s:2:"32";s:1:"D";i:3;s:2:"DF";s:1:"2";}i:2;O:6:"Number":3:{s:1:"n";s:2:"33";s:1:"D";i:3;s:2:"DF";s:1:"3";}i:3;O:6:"Number":3:{s:1:"n";s:2:"51";s:1:"D";i:5;s:2:"DF";s:1:"1";}i:4;O:6:"Number":3:{s:1:"n";s:2:"55";s:1:"D";i:5;s:2:"DF";s:1:"5";}i:5;O:6:"Number":3:{s:1:"n";s:2:"56";s:1:"D";i:5;s:2:"DF";s:1:"6";}}}i:2;O:21:"CombinationStatistics":9:{s:3:"cRd";s:4:"2211";s:3:"cRf";s:4:"2211";s:3:"cDd";a:6:{i:0;i:2;i:1;i:1;i:2;i:1;i:3;i:0;i:4;i:2;i:5;i:0;}s:3:"cDf";a:10:{i:0;i:2;i:1;i:0;i:2;i:1;i:3;i:0;i:4;i:0;i:5;i:0;i:6;i:0;i:7;i:0;i:8;i:2;i:9;i:1;}s:7:"cRd_cRf";s:9:"2211-2211";s:3:"foe";s:10:"0(2)28(2)9";s:8:"group2_2";i:1;s:2:"id";s:12:"020918304850";s:1:"d";a:6:{i:0;O:6:"Number":3:{s:1:"n";s:2:"02";s:1:"D";i:0;s:2:"DF";s:1:"2";}i:1;O:6:"Number":3:{s:1:"n";s:2:"09";s:1:"D";i:0;s:2:"DF";s:1:"9";}i:2;O:6:"Number":3:{s:1:"n";s:2:"18";s:1:"D";i:1;s:2:"DF";s:1:"8";}i:3;O:6:"Number":3:{s:1:"n";s:2:"30";s:1:"D";i:2;s:2:"DF";s:1:"0";}i:4;O:6:"Number":3:{s:1:"n";s:2:"48";s:1:"D";i:4;s:2:"DF";s:1:"8";}i:5;O:6:"Number":3:{s:1:"n";s:2:"50";s:1:"D";i:4;s:2:"DF";s:1:"0";}}}i:3;O:21:"CombinationStatistics":9:{s:3:"cRd";s:5:"21111";s:3:"cRf";s:5:"21111";s:3:"cDd";a:6:{i:0;i:0;i:1;i:1;i:2;i:1;i:3;i:1;i:4;i:2;i:5;i:1;}s:3:"cDf";a:10:{i:0;i:2;i:1;i:1;i:2;i:0;i:3;i:1;i:4;i:0;i:5;i:0;i:6;i:1;i:7;i:0;i:8;i:0;i:9;i:1;}s:7:"cRd_cRf";s:11:"21111-21111";s:3:"foe";s:8:"12351369";s:8:"group2_2";i:2;s:2:"id";s:12:"203039414356";s:1:"d";a:6:{i:0;O:6:"Number":3:{s:1:"n";s:2:"20";s:1:"D";i:1;s:2:"DF";s:1:"0";}i:1;O:6:"Number":3:{s:1:"n";s:2:"30";s:1:"D";i:2;s:2:"DF";s:1:"0";}i:2;O:6:"Number":3:{s:1:"n";s:2:"39";s:1:"D";i:3;s:2:"DF";s:1:"9";}i:3;O:6:"Number":3:{s:1:"n";s:2:"41";s:1:"D";i:4;s:2:"DF";s:1:"1";}i:4;O:6:"Number":3:{s:1:"n";s:2:"43";s:1:"D";i:4;s:2:"DF";s:1:"3";}i:5;O:6:"Number":3:{s:1:"n";s:2:"56";s:1:"D";i:5;s:2:"DF";s:1:"6";}}}i:4;O:21:"CombinationStatistics":9:{s:3:"cRd";s:5:"21111";s:3:"cRf";s:4:"2211";s:3:"cDd";a:6:{i:0;i:1;i:1;i:0;i:2;i:1;i:3;i:1;i:4;i:2;i:5;i:1;}s:3:"cDf";a:10:{i:0;i:0;i:1;i:0;i:2;i:1;i:3;i:0;i:4;i:0;i:5;i:1;i:6;i:0;i:7;i:0;i:8;i:2;i:9;i:2;}s:7:"cRd_cRf";s:10:"21111-2211";s:3:"foe";s:10:"258(2)9(2)";s:8:"group2_2";i:3;s:2:"id";s:12:"092532484958";s:1:"d";a:6:{i:0;O:6:"Number":3:{s:1:"n";s:2:"09";s:1:"D";i:0;s:2:"DF";s:1:"9";}i:1;O:6:"Number":3:{s:1:"n";s:2:"25";s:1:"D";i:2;s:2:"DF";s:1:"5";}i:2;O:6:"Number":3:{s:1:"n";s:2:"32";s:1:"D";i:3;s:2:"DF";s:1:"2";}i:3;O:6:"Number":3:{s:1:"n";s:2:"48";s:1:"D";i:4;s:2:"DF";s:1:"8";}i:4;O:6:"Number":3:{s:1:"n";s:2:"49";s:1:"D";i:4;s:2:"DF";s:1:"9";}i:5;O:6:"Number":3:{s:1:"n";s:2:"58";s:1:"D";i:5;s:2:"DF";s:1:"8";}}}i:5;O:21:"CombinationStatistics":9:{s:3:"cRd";s:5:"21111";s:3:"cRf";s:5:"21111";s:3:"cDd";a:6:{i:0;i:0;i:1;i:1;i:2;i:1;i:3;i:1;i:4;i:2;i:5;i:1;}s:3:"cDf";a:10:{i:0;i:0;i:1;i:0;i:2;i:1;i:3;i:2;i:4;i:1;i:5;i:0;i:6;i:1;i:7;i:1;i:8;i:0;i:9;i:0;}s:7:"cRd_cRf";s:11:"21111-21111";s:3:"foe";s:8:"12352467";s:8:"group2_2";i:2;s:2:"id";s:12:"172332434654";s:1:"d";a:6:{i:0;O:6:"Number":3:{s:1:"n";s:2:"17";s:1:"D";i:1;s:2:"DF";s:1:"7";}i:1;O:6:"Number":3:{s:1:"n";s:2:"23";s:1:"D";i:2;s:2:"DF";s:1:"3";}i:2;O:6:"Number":3:{s:1:"n";s:2:"32";s:1:"D";i:3;s:2:"DF";s:1:"2";}i:3;O:6:"Number":3:{s:1:"n";s:2:"43";s:1:"D";i:4;s:2:"DF";s:1:"3";}i:4;O:6:"Number":3:{s:1:"n";s:2:"46";s:1:"D";i:4;s:2:"DF";s:1:"6";}i:5;O:6:"Number":3:{s:1:"n";s:2:"54";s:1:"D";i:5;s:2:"DF";s:1:"4";}}}}');
        $this->CL = new CombinationList;
        $r_str = array('01-14-28-34-47-51,',' 013233515556,02-09-18-30-48-50,','203039414356 09-25-32-48-49-58, 172332434654');
        $this->CL->add($r_str);
        //print_r(serialize($this->CL->toCombinations()));
        $this->assertEquals($sample, $this->CL->toCombinations(), 'message');
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
