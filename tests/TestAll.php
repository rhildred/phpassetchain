<?php
require_once(dirname(__FILE__) . '/simpletest/autorun.php');

class TestOfTemplates extends UnitTestCase {
    function TestURLRewriting() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/public/urlRewrite");
    	$this->assertEqual($sTest, "Rich was here");
    }
    function TestHtmlInstead() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/public/htmlFile");
    	$this->assertEqual($sTest, "Rich was here");
    }
    function TestCompiler() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/public/newFile");
    	$this->assertEqual($sTest, "Rich was here");
    }
    function TestYear() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/public/YearTest");
    	$this->assertEqual($sTest, "The Year is 2014");
    }
    function TestTemplate() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/public/templated");
    	$this->assertEqual($sTest, "Rich was here, \nSo There!");
    }
    function TestIndex() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/public/");
    	$this->assertEqual($sTest, "Rich was here, \nSo There you go!");
    }
}
?>
