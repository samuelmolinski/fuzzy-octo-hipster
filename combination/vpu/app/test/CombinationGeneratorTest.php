<?php

require_once '../../../CombinationGenerator.php';
require_once '../../../CombinationStatistics.php';
require_once '../../../CombinationList.php';

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-10-31 at 01:27:14.
 */
class CombinationGeneratorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CombinationGenerator
     */
    protected $combGen;
    protected $CL;
    protected $rule_1a1_ranges;
    protected $winningNumbers;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        set_time_limit(0);
        
        // n. 1446
        $this->winningNumbers = unserialize('a:100:{i:0;s:12:"091945465456";i:1;s:12:"071238394556";i:2;s:12:"091920505160";i:3;s:12:"030429364555";i:4;s:12:"133336415056";i:5;s:12:"091824353659";i:6;s:12:"031113273247";i:7;s:12:"020838424849";i:8;s:12:"111724394649";i:9;s:12:"061321223146";i:10;s:12:"011924265255";i:11;s:12:"031516353747";i:12;s:12:"061012172853";i:13;s:12:"021617255054";i:14;s:12:"232730373844";i:15;s:12:"021219223658";i:16;s:12:"253542455257";i:17;s:12:"101320404453";i:18;s:12:"022426323550";i:19;s:12:"122737445459";i:20;s:12:"020713293843";i:21;s:12:"102126293238";i:22;s:12:"051624323846";i:23;s:12:"020405274959";i:24;s:12:"030408114749";i:25;s:12:"033640465860";i:26;s:12:"072739525557";i:27;s:12:"062128313343";i:28;s:12:"142528455358";i:29;s:12:"091121495354";i:30;s:12:"020512132535";i:31;s:12:"020517185459";i:32;s:12:"051236455058";i:33;s:12:"031452555760";i:34;s:12:"112730404457";i:35;s:12:"051316172755";i:36;s:12:"070923444655";i:37;s:12:"021830314556";i:38;s:12:"273536374259";i:39;s:12:"122838395156";i:40;s:12:"182732435052";i:41;s:12:"222931435054";i:42;s:12:"011628394457";i:43;s:12:"041927282931";i:44;s:12:"071219344053";i:45;s:12:"020812283343";i:46;s:12:"041824283944";i:47;s:12:"111624354650";i:48;s:12:"051117194448";i:49;s:12:"294852545558";i:50;s:12:"030407152756";i:51;s:12:"143233404251";i:52;s:12:"343943565760";i:53;s:12:"092634435354";i:54;s:12:"111225334854";i:55;s:12:"020910212738";i:56;s:12:"131620263942";i:57;s:12:"070827313251";i:58;s:12:"031417323739";i:59;s:12:"071017243857";i:60;s:12:"182931424353";i:61;s:12:"041920243943";i:62;s:12:"061926475058";i:63;s:12:"182940425054";i:64;s:12:"081232444648";i:65;s:12:"060824374145";i:66;s:12:"131533455455";i:67;s:12:"213744464957";i:68;s:12:"263640464951";i:69;s:12:"031922243549";i:70;s:12:"051245525659";i:71;s:12:"070810122756";i:72;s:12:"172130485258";i:73;s:12:"021116183645";i:74;s:12:"193139445359";i:75;s:12:"020513173944";i:76;s:12:"030821252743";i:77;s:12:"030715293860";i:78;s:12:"071629363850";i:79;s:12:"061518243044";i:80;s:12:"083944475356";i:81;s:12:"071519343755";i:82;s:12:"091222394860";i:83;s:12:"021922304652";i:84;s:12:"050913334054";i:85;s:12:"162425424559";i:86;s:12:"041314404652";i:87;s:12:"031822345558";i:88;s:12:"041545475052";i:89;s:12:"011323243057";i:90;s:12:"222326373848";i:91;s:12:"071431333649";i:92;s:12:"023435424355";i:93;s:12:"020628365156";i:94;s:12:"172936385356";i:95;s:12:"121320303449";i:96;s:12:"122032485254";i:97;s:12:"020527284855";i:98;s:12:"051932414958";i:99;s:12:"061324324051";}');

        $this->combGen = new CombinationGenerator(array('winningCombinations'=>$this->winningNumbers));
        //$this->combGen = new CombinationGenerator();
        $this->rule_1a1_ranges = array(
                    array('min'=>1,'max'=>30),
                    array('min'=>2,'max'=>40),
                    array('min'=>4,'max'=>49),
                    array('min'=>11,'max'=>55),
                    array('min'=>18,'max'=>59),
                    array('min'=>31,'max'=>60)
                );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown()
    {

    }

    public function testSetWinningCombinations(){
        //print_r($this->combGen);
/*
        $path = 'http://localhost/fuzzy-octo-hipster/combination/d_megasc.htm';
        //d($path);
        $megaSc = mLoadXml($path);
        //d($megaSc);
        $megaSc = $megaSc->body->table->xpath('tr');
        //d($megaSc);
        array_shift($megaSc);

        $this->winningNumbers = array();
        foreach($megaSc as $k=>$combination) {
            $d = (string)$combination->td[2].(string)$combination->td[3].(string)$combination->td[4].(string)$combination->td[5].(string)$combination->td[6].(string)$combination->td[7];
            //print_r($d.'.');
            $c = new CombinationStatistics($d);
            $this->winningNumbers[] = $c;
            unset($c);
        }
        

        $li = array();
        foreach ($settings->winningCombinations as $key => $value) {
            $li[] = $value->id;
        }
        print_r( serialize($li));*/

        //print_r(serialize($settings->winningCombinations));
        $combGen = new CombinationGenerator(); 
        $combGen2 = new CombinationGenerator(array('winningCombinations'=>$this->winningNumbers));        
        $combGen->setWinningCombinations($this->winningNumbers);
        print_r($this->combGen->wCombs[0]);
        $this->assertNotNull($combGen->wCombs, 'Init the wCombs');
        $this->assertEquals($this->combGen->wCombs, $combGen->wCombs, 'does it match the already init CG');
        $this->assertEquals($combGen2->wCombs, $combGen->wCombs, 'does it match the already init CG');
       // print_r($this->combGen);
    }

    /**
     * @covers CombinationGenerator::rule_1a1
     * @todo   Implement testRule_1a1().
     */
    public function testRule_1a1_generation()
    {
        $list = array();
        $ranges = $this->rule_1a1_ranges;
        // Remove the following lines when you implement this test.
        $c = $this->combGen->rule_1a1(array(), true);
        //print_r($c->d);
        //print_r($c);
        $this->assertEquals(FALSE, empty($c->d), 'Ensure the Combination is not empty after generation');
        foreach ($c->d as $key => $value) {
            $list[] = $value->n;
        }
        foreach ($c->d as $k => $Num) {
            $t = $Num->n;
            $this->assertTrue((($ranges[$k]['min']<=$t)&&($ranges[$k]['max']>=$t)), 'Check if all value are inside their proper ranges');
        }
    }

    /**
     * @covers CombinationGenerator::rule_1a1
     */
    public function testRule_1a1_generate_from_seed()
    {
        $list = array();
        $ranges = $this->rule_1a1_ranges;
        // Remove the following lines when you implement this test.
        $C = new CombinationStatistics('123742434448');
        $c = $this->combGen->rule_1a1($C, true);
        $this->assertEquals(FALSE, empty($c->d), 'Ensure the Combination is not empty after generation');
        foreach ($c->d as $key => $value) {
            $list[] = $value->n;
        }
        foreach ($c->d as $k => $Num) {
            $t = $Num->n;
            $this->assertTrue((($ranges[$k]['min']<=$t)&&($ranges[$k]['max']>=$t)), 'Check if all value are inside their proper ranges');
        }
    }

    /**
     * @covers CombinationGenerator::rule_1a1
     * @todo   Implement testRule_1a1().
     */
    public function testRule_1a1_checking()
    {        
        print_r("test(true): 123742434448\n");
        print_r("test: 010203374348\n");
        $C = new CombinationStatistics('123742434448');
        $ranges = $this->rule_1a1_ranges;
        $r = $this->combGen->rule_1a1($C);
        $this->assertEquals(true, $r, 'Did the check pass (true)');

        $C = new CombinationStatistics('013703430248');
        $ranges = $this->rule_1a1_ranges;
        $r = $this->combGen->rule_1a1($C);
        $this->assertEquals(false, $r, 'Did the check pass (true)');
    }

    /**
     * @covers CombinationGenerator::rule_1a2
     * @todo   Implement testRule_1a2().
     */
    public function testRule_1a2()
    {
        print_r("test: 123642464448\n");
        print_r("test: 113741434559\n");
        $C1 = new CombinationStatistics('123642464448');
        $C2 = new CombinationStatistics('113741434559');
        // Remove the following lines when you implement this test.
        $this->assertTrue(!$this->combGen->rule_1a2($C1), 'Does it reject all even N');
        $this->assertTrue(!$this->combGen->rule_1a2($C2), 'Does it reject all odd N');
    }

    /**
     * @covers CombinationGenerator::rule_1a3
     * @todo   Implement testRule_1a3().
     */
    public function testRule_1a3()
    {
        print_r("test: 273642464448\n");
        print_r("test(true): 113741434559\n");
        $C1 = new CombinationStatistics('273642464448');
        $C2 = new CombinationStatistics('113741434559');
        // Remove the following lines when you implement this test.
        $this->assertTrue(!$this->combGen->rule_1a3($C1), 'Does it prevent 6N from being in 3 tens groups (false)');
        $this->assertTrue($this->combGen->rule_1a3($C2), 'Does it prevent 6N from being in 3 tens groups (true)');
    }

    /**
     * @covers CombinationGenerator::rule_1a4
     * @todo   Implement testRule_1a4().
     */
    public function testRule_1a4()
    {
       /* print_r("test: 011122334454\n");
        print_r("test(true): 113741434559\n");
        $C1 = new CombinationStatistics('011122334454');
        $C2 = new CombinationStatistics('113741434559');
        // Remove the following lines when you implement this test.
        $this->assertTrue(!$this->combGen->rule_1a4($C1), 'Does it prevent all DF consecutive from being in 3 tens groups (false)');
        $this->assertTrue($this->combGen->rule_1a4($C2), 'Does it prevent all DF consecutive from being in 3 tens groups (true)');*/
        print_r("test: 112021305052\n");
        print_r("test: 050615284547\n");
        print_r("test: 031516222554\n");
        print_r("test: 050613344453\n");
        print_r("test: 113741434559\n");
        $C1 = new CombinationStatistics('112021305052');
        $C2 = new CombinationStatistics('050615284547');
        $C3 = new CombinationStatistics('031516222554');
        $C4 = new CombinationStatistics('050613344453');
        $C5 = new CombinationStatistics('062433354257');
        // Remove the following lines when you implement this test.
        $this->assertTrue(!$this->combGen->rule_1a4($C1), 'Does it prevent all DF consecutive from being in 3 tens groups (false)');
        $this->assertTrue(!$this->combGen->rule_1a4($C2), 'Does it prevent all DF consecutive from being in 3 tens groups (false)');
        $this->assertTrue(!$this->combGen->rule_1a4($C3), 'Does it prevent all DF consecutive from being in 3 tens groups (false)');
        $this->assertTrue(!$this->combGen->rule_1a4($C4), 'Does it prevent all DF consecutive from being in 3 tens groups (false)');
        $this->assertTrue(!$this->combGen->rule_1a4($C5), 'Does it prevent all DF consecutive from being in 3 tens groups (true)');
    
    }

    /**
     * @covers CombinationGenerator::rule_1a5
     * @todo   Implement testRule_1a5().
     */
    public function testRule_1a5()
    {
        print_r("test: 011122334352\n");
        print_r("test: 193746474859\n");
        print_r("test(true): 113741434559\n");
        $C1 = new CombinationStatistics('011122334352');
        $C2 = new CombinationStatistics('193746474859');
        $C3 = new CombinationStatistics('113741434559');
        // Remove the following lines when you implement this test.
        $this->assertTrue(!$this->combGen->rule_1a5($C1), 'Does it prevent all DF from being in less than or equal 4 (false)');
        $this->assertTrue(!$this->combGen->rule_1a5($C2), 'Does it prevent all DF from being in greater than  or equal 5 (false)');
        $this->assertTrue($this->combGen->rule_1a5($C3), 'Does it allow DF to be less than and greater than 4/5 (true)');
    }

    /**
     * @covers CombinationGenerator::rule_1a6
     * @todo   Implement testRule_1a6().
     */
    public function testRule_1a6()
    {
        /*print_r("test: 07-17-18-33-41-42\n");
        print_r("test: 010223244454\n");
        print_r("test(true): 040612192339\n");
        $C1 = new CombinationStatistics('071718334142');
        $C2 = new CombinationStatistics('040506192339');
        $C3 = new CombinationStatistics('040612192339');
        // Remove the following lines when you implement this test.
        $this->assertTrue(!$this->combGen->rule_1a6($C1), 'Does it prevent 2 pairs consecutive from occuring (false)');
        $this->assertTrue(!$this->combGen->rule_1a6($C2), 'Does it prevent 2 pairs consecutive from occuring (false)');
        $this->assertTrue($this->combGen->rule_1a6($C3), 'Does it prevent 2 pairs consecutive from occuring (true)');*/

        print_r("test: 071718334142\n");
        print_r("test: 040506192339\n");
        print_r("test(true): 040612192339\n");
        $C1 = new CombinationStatistics('071718334142');
        $C2 = new CombinationStatistics('040506192339');
        $C3 = new CombinationStatistics('040612192339');
        // Remove the following lines when you implement this test.
        $this->assertTrue(!$this->combGen->rule_1a6($C1), 'Does it prevent 2 pairs consecutive from occuring (false)');
        $this->assertTrue(!$this->combGen->rule_1a6($C2), 'Does it prevent 2 pairs consecutive from occuring (false)');
        $this->assertTrue($this->combGen->rule_1a6($C3), 'Does it prevent 2 pairs consecutive from occuring (true)');
    
    }

    /**
     * @covers CombinationGenerator::rule_1a7
     * @todo   Implement testRule_1a7().
     */
    public function testRule_1a7()
    {
        /*print_r("test: 010407234447\n");
        print_r("test(true): 010223234454\n");
        $C1 = new CombinationStatistics('010407234447');
        $C2 = new CombinationStatistics('010223234454');
        // Remove the following lines when you implement this test.
        $this->assertTrue(!$this->combGen->rule_1a7($C1), 'Does it prevent 3NDif != 6 (false)');
        $this->assertTrue($this->combGen->rule_1a7($C2), 'Does it prevent 3NDif != 6 (true)');*/
        print_r("test: 010407234447\n");
        print_r("test(true): 010223234454\n");
        $C1 = new CombinationStatistics('122730335255');
        $C2 = new CombinationStatistics('081624395259');
        $C2 = new CombinationStatistics('152024272833');
        // Remove the following lines when you implement this test.
        $this->assertTrue(!$this->combGen->rule_1a7($C1), 'Does it prevent 3NDif != 6 (false)');
        $this->assertTrue($this->combGen->rule_1a7($C2), 'Does it prevent 3NDif != 6 (true)');
    
    }

    /**
     * @covers CombinationGenerator::rule_1a8
     * @todo   Implement testRule_1a8().
     */
    public function testRule_1a8()
    {        
        print_r("test: 010421234347\n");
        print_r("test(true): 010223234454\n");
        $C1 = new CombinationStatistics('010421234347');
        $C2 = new CombinationStatistics('010223234454');
        //print_r($C1);
        //print_r('"'.$C2->cRd_cRf.'"');
        // Remove the following lines when you implement this test.
        $this->assertTrue(!$this->combGen->rule_1a8($C1), 'Does it prevent 3NDif != 6 (222-2211:false)');
        $this->assertTrue($this->combGen->rule_1a8($C2), 'Does it prevent 3NDif != 6 (true)');
    }

    /**
     * @covers CombinationGenerator::numElementsEqual
     * @todo   Implement testNumElementsEqual().
     */
    public function testNumElementsEqual()
    {        
        print_r("test: 010421234347\n");
        print_r("test: 010421234347\n");
        print_r("test: 010522234347\n");
        $C1 = new CombinationStatistics('010421234347');
        $C2 = new CombinationStatistics('010421234347');
        $C3 = new CombinationStatistics('010522234347');
        //print_r($C1);
        //print_r('"'.$C2->cRd_cRf.'"');
        // Remove the following lines when you implement this test.
        print_r($this->combGen->numElementsEqual($C1, $C2));
        print_r($this->combGen->numElementsEqual($C1, $C3));
        $this->assertEquals(6, $this->combGen->numElementsEqual($C1, $C2), 'Counts then number of matching N in two Combinations (value:6)');
        $this->assertEquals(4, $this->combGen->numElementsEqual($C1, $C3), 'Counts then number of matching N in two Combinations (value:4)');
    }

    /**
     * @covers CombinationGenerator::rule_matchingNumberThreshold
     * @todo   Implement testRule_matchingNumberThreshold().
     */
    public function testRule_1b1()
    {
        print_r("test(true): 010421234347\n");
        print_r("test: 091920505159\n");
        $C1 = new CombinationStatistics('010421234347');
        $C2 = new CombinationStatistics('091920505159');
        //print_r($this->combGen);
        $this->assertTrue($this->combGen->rule_1b1($C1, $this->combGen->wCombs));
        $this->assertTrue(!$this->combGen->rule_1b1($C2, $this->combGen->wCombs));
    }

    /**
     * @covers CombinationGenerator::rule_1b2
     * @todo   Implement testRule_1b2().
     */
    public function testRule_1b2()
    {
        print_r("test(true): 010421234347\n");
        print_r("test(true): 171928454755\n");
        print_r("test: 091920505159\n");
        $C1 = new CombinationStatistics('010421234347');
        $C2 = new CombinationStatistics('171928454755');
        $C3 = new CombinationStatistics('091920505159'); //040530334152
        //$C4 = new CombinationStatistics('040530334152'); //040530334152
        $this->combGen->rule_1b2($C3, $this->combGen->wCombs);
        $this->assertTrue($this->combGen->rule_1b2($C1, $this->combGen->wCombs));
        $this->assertTrue($this->combGen->rule_1b2($C2, $this->combGen->wCombs));
        $this->assertTrue(!$this->combGen->rule_1b2($C3, $this->combGen->wCombs));
    }

    /**
     * @covers CombinationGenerator::rule_1b3
     * @todo   Implement testRule_1b3().
     */
    public function testRule_1b3()
    {
        print_r("test: 010421234347\n");
        print_r("test(true): 171928454755\n");
        //print_r("test: 040530334257\n");
        $C1 = new CombinationStatistics('010421234347');
        $C2 = new CombinationStatistics('171928454755');
        //$C3 = new CombinationStatistics('040530334257');
        //print_r($C1);
        //print_r($C2);
        //print_r($C3);
        $this->assertTrue(!$this->combGen->rule_1b3($C1, $this->combGen->wCombs));
        $this->assertTrue($this->combGen->rule_1b3($C2, $this->combGen->wCombs));
    }

    /**
     * @covers CombinationGenerator::generate2_1cLimit
     * @todo   Implement testGenerate2_1cLimit().
     */
    public function testGenerate2_1cLimit()
    {
        $r = '{"c1":["1258","2349","3789","2367","0147","0247","2345","0236","2469","0459","0568","0789","1578","0127","0268","1469","2489","1289","0239","0134","3456"],"c2":["0(2)2(2)45","1(2)345(2)","123(2)5(2)","0(2)235(2)","03(2)4(2)5","12(2)4(2)5"],"c3":["0123(2)5","0134(2)5","01235(2)"],"c4":["012346","134679","346789","035789","234579","145678","012789","123458","034679","145789","023479","146789","012349","012568","345679","023457","245789","134789","012689","024567","023678"],"c5":["58","25","29","57","28"],"c6":["1(3)234","013(3)4","012(3)5","014(3)5","01(3)34","0(3)125"],"c7":["2(3)3(2)4","0(2)2(3)4","01(2)3(3)","0(3)2(2)3","3(2)45(3)","01(3)4(2)","0(3)14(2)","02(3)3(2)","2(3)3(2)4","0(2)34(3)"]}';
        //  $r = '{"c1":["1346","1368","2459","2359","2567","1347","0137","1257","0147","0278","1678","1389","3468","2568","0124","2348","0156","0249","3489","1589","0569"],"c2":["12(2)4(2)5","01(2)35(2)","02(2)3(2)5","02(2)35(2)","134(2)5(2)","0(2)123(2)"],"c3":["12(2)345","0(2)2345","01234(2)"],"c4":["014689","024678","012469","345789","012458","135689","145679","123468","013458","012579","024578","012346","134679","256789","235678","045789","024678","034679","034568","013568","125679"],"c5":["13","46","57","04","37"],"c6":["034(3)5","0125(3)","023(3)4","0134(3)","2345(3)","1(3)245"],"c7":["1(2)3(3)4","0(3)2(2)5","0(3)3(2)5","0(3)23(2)","2(2)3(3)4","2(3)45(2)","12(3)4(2)","0(3)14(2)","04(3)5(2)","1(3)35(2)","24(2)5(3)","13(2)5(3)"]}';
        
        //print_r($C1);
        echo json_encode($this->combGen->limit_2_1c);
        //print_r($this->combGen->wCombs);
        // Remove the following lines when you implement this test.
        //$this->combGen->generate2_1cLimit();
        print_r($this->combGen->limit_2_1c);
        //echo '.';
        $a = (array)json_decode($r);
        print_r($a);
        $this->assertEquals($this->combGen->limit_2_1c['c1'], $a['c1'], 'Check that it reproduces the same values');
        $this->assertEquals($this->combGen->limit_2_1c['c2'], $a['c2'], 'Check that it reproduces the same values');
        $this->assertEquals($this->combGen->limit_2_1c['c3'], $a['c3'], 'Check that it reproduces the same values');
        $this->assertEquals($this->combGen->limit_2_1c['c4'], $a['c4'], 'Check that it reproduces the same values');
        $this->assertEquals($this->combGen->limit_2_1c['c5'], $a['c5'], 'Check that it reproduces the same values');
        $this->assertEquals($this->combGen->limit_2_1c['c6'], $a['c6'], 'Check that it reproduces the same values');
        $this->assertEquals($this->combGen->limit_2_1c['c7'], $a['c7'], 'Check that it reproduces the same values');
    }

    /**
     * @covers CombinationGenerator::rule_2_1c
     * @todo   Implement testRule_2_1c().
     */
    public function testRule_2_1c()
    {
        print_r("test: 051632414658\n");
        print_r("test: 021728444851\n");
        print_r("test: 020527284855\n");
        print_r("test: 162425424559\n");
        print_r("test: 011527284548\n");
        print_r("test: 040726375156\n");
        print_r("test(true): 040518344558\n");
        $C1 = new CombinationStatistics('051632414658');
        $C2 = new CombinationStatistics('021728444851');
        $C3 = new CombinationStatistics('020527284855');
        $C4 = new CombinationStatistics('162425424559');
        $C5 = new CombinationStatistics('011527284548');
        $C6 = new CombinationStatistics('040726375156');
        $C9 = new CombinationStatistics('040518344558');
        print_r($this->combGen->limit_2_1c);
        //$this->combGen->rule_2_1c($C2, $this->combGen->limit_2_1c);
        //$this->assertTrue(!$this->combGen->rule_2_1c($C1), 'Does it match one of the last forms forbidden by 2.1c (FALSE)');
        //$this->assertTrue(!$this->combGen->rule_2_1c($C2), 'Does it match one of the last forms forbidden by 2.1c (FALSE)');
        $this->assertTrue(!$this->combGen->rule_2_1c($C3), 'Does it match one of the last forms forbidden by 2.1c (FALSE)');
        //$this->assertTrue(!$this->combGen->rule_2_1c($C4), 'Does it match one of the last forms forbidden by 2.1c (FALSE)');
        //$this->assertTrue(!$this->combGen->rule_2_1c($C5), 'Does it match one of the last forms forbidden by 2.1c (FALSE)');
        //$this->assertTrue(!$this->combGen->rule_2_1c($C6), 'Does it match one of the last forms forbidden by 2.1c (FALSE)');
        //$this->assertTrue($this->combGen->rule_2_1c($C9), 'Does it match one of the last forms forbidden by 2.1c (pass)');
    }

    /**
     * @covers CombinationGenerator::check_rule_2_2_1a
     * @todo   Implement testCheck_rule_2_2_1a().
     */
    public function testCheck_rule_2_1_2a()
    {   
        print_r($this->combGen->groups_2_1_2);
        //$this->assertequals( null, $this->combGen->rule_2_1_2d(), 'Is the rule 2.2.1a valid (FALSE)');
    }

    public function testcheck_rule_2_2_1a() {
        //:84;s:12:"050913334054";i:85;s:12:"162425424559";i:86;s:12:"041314404652";i:87;s:12:"031822345558";i:
        // 88;s:12:"041545475052";i:89;s:12:"011323243057";i:90;s:12:"222326373848";i:91;s:12:"071431333649";i
        //:92;s:12:"023435424355";i:93;s:12:"020628365156";i:94;s:12:"172936385356";i:95;s:12:"121320303449";i
        //:96;s:12:"122032485254";i:97;s:12:"020527284855";i:98;s:12:"3";i:99;s:12:"061324324051";}');
        $cl  = new CombinationList(array('041545475052','011323243057')); // 1435,1436,1437
        $cl2  = new CombinationList(array('051932414958','061324324051')); // 1445,1446
        $cg = new CombinationGenerator(array('winningCombinations'=>$cl));
        $cg2 = new CombinationGenerator(array('winningCombinations'=>$cl2));
        print_r($cg->check_rule_2_2_1a());
        print_r($cg2->check_rule_2_2_1a());
    }

    /**
     * @covers CombinationGenerator::check_rule_2_2_1a
     * @todo   Implement testCheck_rule_2_2_1a().
     */
    public function testCheck_rule_2_2_1d()
    {   
        print_r($this->combGen->rule_2_2_1a_invalid);
        $this->assertequals( -1, $this->combGen->rule_2_2_1a_invalid, 'Is the rule 2.2.1a valid (FALSE)');
    }

    /**
     * @covers CombinationGenerator::rule_2_2_1a
     * @todo   Implement testRule_2_2_1a().
     */
    public function testRule_2_2_1a()
    {
        print_r("test: 010423254556\n");
        print_r("test: 131535464956\n");
        $C1 = new CombinationStatistics('010423254556');
        $C2 = new CombinationStatistics('131535464956');

        print_r("\ntest: ");
        print_r($C1);
        print_r("\ntest: ");
        print_r($C2);
        print_r("\rule_2_2_1a_invalid: ");
        print_r($this->combGen->rule_2_2_1a_invalid);

        //$this->assertTrue($this->combGen->rule_2_2_1a($C1), 'pass the rule 2.2.1a valid (true)');
        $this->combGen->rule_2_2_1a_invalid = 1;
        print_r("\nrule_2_2_1a_invalid: ");
        print_r($this->combGen->rule_2_2_1a_invalid);
        print_r("\nrule_2_2_1a_invalid group: ");
        print_r($this->combGen->groups_2_2[$this->combGen->rule_2_2_1a_invalid]);
        $this->assertTrue(!$this->combGen->rule_2_2_1a($C2), 'pass the rule 2.2.1a valid (false)');
    }

    /**
     * @covers CombinationGenerator::rule_2_2_1b
     * @todo   Implement testRule_2_2_1b().
     */
    public function testRule_2_2_1b()
    {
        print_r("test: 010423242556\n");
        print_r("test: 153137464956\n");
        $C1 = new CombinationStatistics('010423242556');
        $C2 = new CombinationStatistics('153137464956');
        $C3 = new CombinationStatistics('152137464956');
        $this->assertTrue(!$this->combGen->rule_2_2_1b($C1, true), 'pass the rule 2.2.1b valid (false)');
        $this->assertTrue(!$this->combGen->rule_2_2_1b($C2, true), 'pass the rule 2.2.1b valid (false)');
        $this->assertTrue($this->combGen->rule_2_2_1b($C3, true), 'pass the rule 2.2.1b valid (true)');
    }

    /**
     * @covers CombinationGenerator::rule_2_2_1c
     * @todo   Implement testRule_2_2_1c().
     */
    public function testRule_2_2_1c()
    {
        print_r("test: 010423242556\n");
        print_r("test: 153137464956\n");
        print_r("test(true): 152137464956\n");
        $C1 = new CombinationStatistics('010422242856');
        $C2 = new CombinationStatistics('153137434956');
        $C3 = new CombinationStatistics('152137464956');
        $this->assertTrue(!$this->combGen->rule_2_2_1c($C1, true), 'pass the rule 2.2.1c valid (false)');
        $this->assertTrue(!$this->combGen->rule_2_2_1c($C2, true), 'pass the rule 2.2.1c valid (false)');
        $this->assertTrue($this->combGen->rule_2_2_1c($C3, true), 'pass the rule 2.2.1c valid (true)');
    }

    /**
     * @covers CombinationGenerator::ruleb_2_2_1d
     * @todo   Implement testRule_2_2_1d().
     */
    public function testRule_2_2_1d()
    {
        print_r("test(true): 010423242556\n");
        print_r("test(true): 153137464956\n");
        print_r("test: 152137464956\n");
        $C1 = new CombinationStatistics('010422235556');
        $C2 = new CombinationStatistics('153137434456');
        $C3 = new CombinationStatistics('152137464956');
        $this->assertEquals(1, $this->combGen->rule_2_2_1d($C1, true), 'pass the rule 2.2.1d valid (2)');
        $this->assertEquals(1, $this->combGen->rule_2_2_1d($C2, true), 'pass the rule 2.2.1d valid (1)');
        $this->assertEquals(0, $this->combGen->rule_2_2_1d($C3, true), 'pass the rule 2.2.1d valid (0)');
    }

    /**
     * @covers CombinationGenerator::rule_2_2_1d
     * @todo   Implement testRule_2_2_1d().
     */
    public function testRule_2_2_1e()
    {
        $listRule_2_2_1e = array('05', '45');
        print_r("test(true): 010423242556\n");
        print_r("test: 153137454956\n");
        $C1 = new CombinationStatistics('010423242556');
        $C2 = new CombinationStatistics('153137454956');


        print_r($this->combGen->listRule_2_2_1e);

        $this->assertEquals(array(), $this->combGen->listRule_2_2_1e, 'pass the rule 2.2.1d valid (2)');
        $this->combGen->listRule_2_2_1e = $listRule_2_2_1e;
        print_r("\nlistRule_2_2_1e: ");
        print_r($this->combGen->listRule_2_2_1e);

        $this->assertEquals(true, $this->combGen->rule_2_2_1e($C1), 'pass the rule 2.2.1d valid (1)');
        $this->assertEquals(false, $this->combGen->rule_2_2_1e($C2), 'pass the rule 2.2.1d valid (0)');
    } 
    public function testRule_2_2(){
        
    }
}