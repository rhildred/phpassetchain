<?php
require_once(dirname(__FILE__) . '/simpletest/autorun.php');

class TestOfTemplates extends UnitTestCase {
    function TestURLRewriting() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/public/tests/urlRewrite");
    	$this->assertEqual($sTest, "Rich was here");
    }
    function TestHtmlInstead() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/public/tests/htmlFile");
    	$this->assertEqual($sTest, "Rich was here");
    }
    function TestCompiler() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/public/tests/newFile");
    	$this->assertEqual($sTest, "Rich was here");
    }
    function TestTemplate() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/public/tests/templated");
    	$this->assertEqual($sTest, "Rich was here, \nSo There!");
    }
    function TestTemplateDirect() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/public/tests/templated.phtml");
    	$this->assertEqual($sTest, "Rich was here,\nSo There!");
    }
    function TestIndex() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/public/tests/");
    	$this->assertEqual($sTest, "Rich was here, \nSo There you go!");
    }
    function TestPing() {
    	$sResult = file_get_contents("http://localhost/~rhildred/phpassetchain/public/api/Ping");
    	$this->assertEqual($sResult, '{"result":"success"}');
    }
    function TestRenderMarkdown() {
      $sResult = file_get_contents("http://localhost/~rhildred/phpassetchain/public/tests/renderMarkdown.phtml");
      $sExpected = <<<EOF
Rich was here,
Rich was here!

<h1>HEllo</h1>

<p>Rich was here</p>

EOF;
        $this->assertEqual($sResult, $sExpected);
    }
    function TestRenderPartial() {
      $sResult = file_get_contents("http://localhost/~rhildred/phpassetchain/public/tests/renderPartial.phtml");
      $sExpected = <<<EOF
Rich was here,
<ul>
  <li>
1</li>
<li>
2</li>
<li>
3</li>
</ul>

EOF;
      $this->assertEqual($sResult, $sExpected);
    }
}
?>
