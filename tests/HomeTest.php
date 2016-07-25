<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../vendor/phpunit/phpunit/src/Framework/TestCase.php';

class HomeTest extends PHPUnit_Framework_TestCase
{
	// testing that testing works
    // public function testPushAndPop()
    // {
    //     $stack = [];
    //     $this->assertEquals(0, count($stack));

    //     array_push($stack, 'foo');
    //     $this->assertEquals('foo', $stack[count($stack)-1]);
    //     $this->assertEquals(1, count($stack));

    //     $this->assertEquals('foo', array_pop($stack));
    //     $this->assertEquals(0, count($stack));
    // }

	/**
	 * Some quick unit tests for the Date Differ
	 **/
    public function testDateDiffer()
    {
    	// single day difference
    	$start_year = 2016;
    	$start_month = 7;
    	$start_day = 20;
    	$start = array($start_year, $start_month, $start_day);
    	$end_year = 2016;
    	$end_month = 7;
    	$end_day = 21;
    	$end = array($end_year, $end_month, $end_day);
    	$dateDiffer = new DateDiffer($start, $end);
    	$dateDiff = $dateDiffer->getDateDiff();
    	$this->assertEquals(1, $dateDiff);

    	//inter month difference - should be 3 days different
    	$start = array(2016, 01, 30);
    	$end = array(2016, 02, 02);
    	$dateDiffer = new DateDiffer($start, $end);
    	$dateDiff = $dateDiffer->getDateDiff();
    	$this->assertEquals(3, $dateDiff);

    	// inter year difference with leap calculation involved - expectign 67
    	$start = array(2007, 12, 25);
    	$end = array(2008, 03, 01);
		$dateDiffer = new DateDiffer($start, $end);
    	$dateDiff = $dateDiffer->getDateDiff();
    	$this->assertEquals(67, $dateDiff);

    	// one more testing with wolfram alpha
    	// 2012-02-01 and 2015-09-09
    	// -> 1316
		$start = array(2012, 2, 1);
    	$end = array(2015, 9, 9);
		$dateDiffer = new DateDiffer($start, $end);
    	$dateDiff = $dateDiffer->getDateDiff();
    	$this->assertEquals(1316, $dateDiff);
    }

}

