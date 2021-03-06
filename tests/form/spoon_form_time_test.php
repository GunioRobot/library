<?php

// spoon charset
if(!defined('SPOON_CHARSET')) define('SPOON_CHARSET', 'utf-8');

// includes
require_once 'spoon/spoon.php';
require_once 'PHPUnit/Framework/TestCase.php';

// timezone
date_default_timezone_set('Europe/Brussels');

class SpoonFormTimeTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var	SpoonForm
	 */
	private $frm;

	/**
	 * @var	SpoonFormTime
	 */
	private $txtTime;

	public function setup()
	{
		$this->frm = new SpoonForm('timefield');
		$this->txtTime = new SpoonFormTime('time', date('H:i'));
		$this->frm->add($this->txtTime);
	}

	public function testGetDefaultValue()
	{
		$this->assertEquals(date('H:i'), $this->txtTime->getDefaultValue());
	}

	public function testErrors()
	{
		$this->txtTime->setError('You suck');
		$this->assertEquals('You suck', $this->txtTime->getErrors());
		$this->txtTime->addError(' cock');
		$this->assertEquals('You suck cock', $this->txtTime->getErrors());
		$this->txtTime->setError('');
		$this->assertEquals('', $this->txtTime->getErrors());
	}

	public function testAttributes()
	{
		$this->txtTime->setAttribute('rel', 'bauffman.jpg');
		$this->assertEquals('bauffman.jpg', $this->txtTime->getAttribute('rel'));
		$this->txtTime->setAttributes(array('id' => 'specialID'));
		$this->assertEquals(array('id' => 'specialID', 'name' => 'time','maxlength' => 5, 'class' => 'inputTimefield', 'rel' => 'bauffman.jpg'), $this->txtTime->getAttributes());
	}

	public function testIsFilled()
	{
		$this->assertEquals(false, $this->txtTime->isFilled());
		$_POST['time'] = '14:55';
		$this->assertEquals(true, $this->txtTime->isFilled());
	}

	public function testIsValid()
	{
		$this->assertEquals(false, $this->txtTime->isValid());
		$_POST['time'] = 'Boobies';
		$this->assertEquals(false, $this->txtTime->isValid());
		$_POST['time'] = '13:37';
		$this->assertEquals(true, $this->txtTime->isValid());
		$_POST['time'] = '25:60';
		$this->assertEquals(false, $this->txtTime->isValid());
		//$_POST['time'] = 'pipi00:01asshole';
		//$this->assertFalse($this->txtTime->isValid()); // @todo this assertion is currently invalid.
	}

	public function testGetTimestamp()
	{
		$_POST['time'] = '10:44';
		$this->assertEquals('25/10/2009 ' . date('H:i') . ':00', date('d/m/Y H:i:s', $this->txtTime->getTimestamp(2009, 10, 25)));
	}

	public function testGetValue()
	{
		$_POST['form'] = 'timefield';
		$_POST['time'] = '14:55';
		$this->assertEquals('14:55', $this->txtTime->getValue());
	}
}

?>