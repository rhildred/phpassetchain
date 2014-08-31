<?php
require_once(dirname(__FILE__) . '/simpletest/autorun.php');

/**
 * Generic class autoloader.
 *
 * @param string $class_name
 */
function autoload_class($class_name) {
    $directories = array(
        '../lib/classes/',
        '../lib/classes/controllers/',
        '../lib/classes/models/'
    );
    foreach ($directories as $directory) {
        $filename = $directory . $class_name . '.php';
        if (is_file($filename)) {
            require($filename);
            break;
        }
    }
}

/**
 * Register autoloader functions.
 */
spl_autoload_register('autoload_class');


class TestOfFilter extends UnitTestCase {
  function TestTrivial()
  {
    $this->assertEqual(true, true);
  }
  function TestOfDBOpen()
  {
        // Create (connect to) SQLite database in file
    $file_db = new PDO('sqlite:messaging.sqlite3');
    // Set errormode to exceptions
    $file_db->setAttribute(PDO::ATTR_ERRMODE,
                            PDO::ERRMODE_EXCEPTION);
    $this->assertNotNull($file_db);
  }
  function TestRecurse()
  {
    $ite=new RecursiveDirectoryIterator("../public");

    $bytestotal=0;
    $nbfiles=0;
    foreach (new RecursiveIteratorIterator($ite) as $filename=>$cur) {
      if(preg_match("/md$/", $filename)){
        $filesize=$cur->getSize();
        $bytestotal+=$filesize;
        $nbfiles++;
        echo "$filename => $filesize\n";
      }
    }
    $this->assertEqual(531, $bytestotal);
  }
  function TestParser(){
    $value = file_get_contents("../public/tests/test1.md");
    $aKeyWords = preg_split('/(<\s*p\s*\/?>)|(<\s*br\s*\/?>)|[\s,\-\/]/i', $value);
    $this->assertEqual("HEllo,=====,,Rich,was,here,", join(',', $aKeyWords));
  }
  function TestStopWords(){
    $aFiltered = array();
    $value = file_get_contents("../public/tests/test1.md");
    $aKeyWords = preg_split('/(<\s*p\s*\/?>)|(<\s*br\s*\/?>)|[\s,\-\/]/i', $value);
    foreach($aKeyWords as $sKeyWord){
      if(preg_match("/[a-zA-Z']/", $sKeyWord) && !StopWords::bStopWord($sKeyWord) )
        array_push($aFiltered, $sKeyWord);
    }
    $this->assertEqual("HEllo,Rich", join(',', $aFiltered));
  }
  function TestStemmer(){
    $sWord = PorterStemmer::Stem("individually");
    $this->assertEqual($sWord, "individu");
  }
  function TestInsert(){
    ReverseIndex::CreateIndex("../public", "md");
  }
}
?>
