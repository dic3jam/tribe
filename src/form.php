<?php
//ini_set('display_errors',1);
//variables
$saveSuccess = $outName = $outFlavor = $readError = "";
$people = array();
$xmlPath = "icecream/";

function clearGlobals(){
	$saveSuccess = $outName = $outFlavor = $readError = "";
	$people = array();
}

function new_icecream($filename, $name, $flavor, $xmlPath) {
	$dom = new DOMDocument('1.0', 'UTF-8');
	$dom->formatOutput = true;

	$root = $dom->createElement('person');
	$dom->appendChild($root);

	$att1 = $dom->createElement('name', $name);
	$root->appendChild($att1);

	$att2 = $dom->createElement('flavor', $flavor);
	$root->appendChild($att2);

	echo '<xmp>' . $dom->saveXML() . '</xmp>';
	$dom->save($xmlPath . $filename) or die ('Unable to create XML file');
	if(rename(( $xmlPath . $filename), ($xmlPath . $filename)))
		return True;
	else
		return False;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	clearGlobals();
	//if write is set, create save a new xml file with the info
	if($_POST["write"]){
		$name = $_POST["name"];
		$flavor = $_POST["flavor"];
		$filename = "CCV_" . $name . ".xml";
		$filepath = $xmlPath . $filename;

		if(file_exists($filepath))
			unlink($filepath);
			//write_icecream($filename, $flavor);
		if(new_icecream($filename, $name, $flavor, $xmlPath))
			$saveSuccess = "File saved successfully";
		else
			$saveSuccess = "Unable to save file";
	}	

	//if read is set, fetch the XML file, read in the values, and dislay below
	if($_POST["read"]){
		$name = $_POST["name"];
		$filename = "CCV_" . $name . ".xml";
		$filepath = $xmlPath . $filename;
		$dom = new DOMDocument;
		if($dom->load($filepath)){
			$children = $dom->documentElement->childNodes;
			foreach($children as $chitlins) {
				if($chitlins->nodeName == "name")
					$outName = $chitlins->nodeValue;
				if($chitlins->nodeName == "flavor")
					$outFlavor = $chitlins->nodeValue;
			}
		} else {
			$readError = "Unable to locate file";
		}
	}
	//if lookup is set, return all of the currently saved XML files
	if($_POST["lookup"]){
		$dh = dir($xmlPath);
		while (($file = $dh->read()) != False){
			array_push($people, $file);	
		}
	}
}
?>

<h2>Choose your favorite ice cream</h2>
<form method="post" action="<?php $_SERVER["PHP_SELF"];?>">
	Name: <input type="text" name="name">
	Flavor:
		<input type="radio" id="flavor" name="flavor" value="vanilla">Vanilla
		<input type="radio" id="flavor" name="flavor" value="chocolate">Chocolate	
		<input type="radio" id="flavor" name="flavor" value="strawberry">Strawberry
	<!--	<input type="text" id="flavor" name="flavor" value="vanilla">Other -->
		<input type="submit" name="write" value="write" target="_self">
</form>
<?php echo $saveSuccess;?>

<h2>Look up your favorite flavor</h2>
<form method="post" action="<?php $_SERVER["PHP_SELF"];?>">
	 Name: <input type="text" name="name">
	<input type="submit" name="read" value="read" target="_self">
</form>

<?php 
      echo "<h2>Your Results</h2>";
      echo $outName;  
      echo "<br>";
      echo $outFlavor;
      echo "<br>";
      echo $readError;
?>

<h2>List currently recorded preferences</h2>
<form method="post" action="<?php $_SERVER["PHP_SELF"];?>">
	<input type="submit" name="lookup" value="lookup" target="_self">
</form>

<?php
      foreach($people as $peeps){
	      echo $peeps;
      	      echo "<br>";
      }

?>

<br>
<br>
