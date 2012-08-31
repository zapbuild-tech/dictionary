<?php 
if(empty($_POST)){
        exit('No direcxt access allowed here');
}
include 'configure.php';

//-- the string value to look up the words
$lookUpString		=	$_POST['lookupfor'];
//-- declare array
$resultArr		=	array();
                                
$input 			=	str_split( $lookUpString ); //user input from the form
$handle 		=	@fopen("dict-file/".DICTIONARY_FILE_NAME, "r");

// -- file open and match the word
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        if(strlen($buffer) > MINIMUM_CHARACTER_IN_RESULT_WORD ){
			$word = str_split(trim($buffer)); //
			$result = array_diff($word, $input);
			if(!$result) $resultArr[]	=	 rtrim($buffer,"\n");
		}
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}

//asort($resultArr);
//-- to sort by length

function sortByLength($a,$b){
  if($a == $b) return 0;
  return (strlen($a) > strlen($b) ? -1 : 1);
}
usort($resultArr,'sortByLength');

//-- response display as json
echo json_encode($resultArr);

?>
