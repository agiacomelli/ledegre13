<!DOCTYPE html>
<?php
	/*VARIABLEN ZUR ALLGEMEINEN SACHE*/

	$thisProgram = "Le degré 13 de la littérature";
	$derUrheber = "Adrian Giacomelli";
	$annoDomini = "2017";

	/* VARIABLEN ZUR AUSLESE */

		$alleZeilen = array();
		$alleTitel = array();
		$incipit = "/INCIPITANTUM/";

	/* VARIABLEN ZUR AUSLESE DES CLIENTS */

	$serverInfo = array();
	$serverInfo[0] = $_SERVER['REMOTE_ADDR'];
	$serverInfo[1] = $_SERVER['SERVER_ADDR'];
	$serverInfo[2] = $_SERVER['SERVER_SOFTWARE'];
	$serverInfo[3] = $_SERVER['SERVER_PORT'];
	$serverInfo[4] = $_SERVER['REQUEST_TIME'];
	$serverInfo[5] = $_SERVER['HTTP_CONNECTION'];
	
	$storageFile ="ledegre13data.csv";
	$TO_MAIL = "giacomelli@explicor.de";
	$SUBJ_MAIL = "NEW COPY DOWNLOADED";

?>

	<html>
	<head>
		<meta charset="UTF8">
		<title>Le Degré 13 de la Littérature (edited by Adrian Giacomelli - 2017)</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/0.5.14/p5.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
	<script src="js/clientjs.js"></script>
	<link rel="stylesheet" href="style/style.css">
	</head>
<body>

<div id="kopf">
	<div id="menu">
		</div>
	<h1><?php echo "$thisProgram";?></h1>
</div>

<?php
foreach ( glob("texts/*.txt") as $textDatei ) {

	array_push($alleTitel, $textDatei);
	
	$einText = file($textDatei);
	$length = count($einText);

	for ( $i = 0; $i < $length; $i++ ) {

		if ( preg_match($incipit, $einText[$i]) ) {
			array_push($alleZeilen, $einText[$i+13]);
			break 1;
		}
	}
}
?>

<div id="leinwand">

<script>
var i = 0;
var speed = 2.3;
var count = 0;
var x;
var y;
/* Schriftfarbe in ze Animation */
var s = 20;

/* Dada for ze imprint */

var d = new Date();
var c = new ClientJS();
var browser = c.getBrowser();
var browserVer = c.getBrowserVersion();
var os = c.getOS();
var osVer = c.getOSVersion();
var timeZone = c.getTimeZone();
var res = c.getCurrentResolution();
var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
var downloadData;

/* Übertragung der serverseitigen Auslese von PHP in JS */
	<?php
			$temp = json_encode($alleZeilen);
			echo "var alle_Zeilen = ". $temp .";";
			echo "var alle_Zeilen_Copy = ". $temp .";";
			
			$temp = json_encode($alleTitel);
			echo "var alle_Titel = ". $temp .";";
			
			$temp = json_encode($serverInfo);
			echo "var serverInfo = ". $temp .";";
	?>

function setup() {
	var theCanvas = createCanvas(380,510);
	theCanvas.parent("leinwand");
	background(250);
	fill(s);
	stroke(255);
	textFont("Georgia");

	x = width;
	y = height/2;
	
	//Array wird durchenander gewürfelt

		shuffle(alle_Zeilen, true);

}

function printDetails() {


	if (alle_Zeilen_Copy.length == alle_Titel.length) {

		for (var ii = 0; ii < alle_Zeilen_Copy.length; ii++) {
				console.log(alle_Zeilen_Copy[ii] + " ("+ alle_Titel[ii]+")\n");
			}
		} else {
			console.log("ERROR: Arrays not of the same length, du Spast!");
		}	
}


function draw() {
	
	background(250);
	textSize(18);
	fill(s);
	var tmp = alle_Zeilen[i];
	text(tmp, x, y);

	x = x - speed;
	var w = textWidth(tmp);

	if ( x  < -20 ) {
		s = s + 1;
		fill(s);
	}
	if ( x < -w ) {
		x = width;
		s = 20;
		i = (i+1) % alle_Zeilen.length;
	}

}

function saveCopy() {

	var doc = new jsPDF();

	doc.setProperties({
    title: 'Le degré 13 de la littérature',
    subject: 'anthology',
    author: 'Adrian Giacomelli (ed.)',
    keywords: 'Numerology, Christianity, CCL (Computational Comparative Literature)',
    creator: 'littera ea ipsa'
	});

	var left_offset = 50;
	var l = 40;

	/* Cover */
	doc.setPage(1);

	/* Cover Design */
	doc.setFillColor(30);

	for (var y=0; y<=320; y+=8) {
		doc.rect(0,y,30+(y*0.05),2, "F");
	}

	/** Title */

	doc.setFont("Helvetica");
	doc.setTextColor(19,171,205);
	doc.setFontSize(24);
	doc.text(left_offset, 80, "le degré 13 de la littérature ()");
	doc.setFontSize(18);
	doc.text(left_offset+20, 110, "{ an ant[i]hology");
  	doc.text(left_offset+25, 132, "computed && edited");
	doc.text(left_offset+30, 154, "by :: adrian giacomelli }");
	left_offset = 15;

	doc.setPage(2);
	doc.addPage();

	/** Foreword */

	doc.text(left_offset, l, "_FOREWORD")
	doc.setFontSize(14);
	doc.text(left_offset, (l+=20), "If the myths that surround  the number 13 are still alive");
	doc.text(left_offset, (l+=10), "in all western cultures and beyond, then it is because");
	doc.text(left_offset, (l+=10), "such a thing as western culture is radically rooted");
	doc.text(left_offset, (l+=10), "in these myths, which represent nothing less than the");
	doc.text(left_offset, (l+=10), "foundation myths of western culture itself.");
	doc.text(left_offset, (l+=10), "");
	doc.text(left_offset, (l+=10), "Hence it is a legitimate – not to say crucial – task of literary");
	doc.text(left_offset, (l+=10), "research to scrutinize the role of the number 13 in western");
	doc.text(left_offset, (l+=10), "literature. One could for example compare the thirteenth line");
	doc.text(left_offset, (l+=10), "of the most spoken-of and most written-about, let's say the");
	doc.text(left_offset, (l+=10), "top 100.");
	doc.text(left_offset, (l+=10), "");
	doc.text(left_offset, (l+=10), "The editor would like to thank Daniel Shiffman for his inspiring");
	doc.text(left_offset, (l+=10), "lessons and for the scrolling algorithm used on the website.");
	doc.text(left_offset, (l+=10), "Thanks go also to Nick Montfort for his inspiring work at the");
	doc.text(left_offset, (l+=10), "boundaries of code and literature.");
	doc.text(left_offset, (l+=10), "");
	doc.text(left_offset, (l+=10), "This book is dedicated to the memory of Werner Hamacher.");
	doc.text(left_offset, (l+=10), "");
	doc.text(left_offset, (l+=10), "The source text sources used in this comparative research are all");
	doc.text(left_offset, (l+=10), "taken from Project Gutenberg, the 13th line of each text");
	doc.text(left_offset, (l+=10), "appearing here as it is held in that digital repository.");
	doc.text(left_offset, (l+=10), "");
	doc.text(left_offset, (l+=10), "                                                             - Adrian Giacomelli");
	
	/**END OF FOREWORD**/

	/* Main Content */

	//empty Page
	doc.setPage(3);

	//Font-Style of Main Content
	doc.setTextColor(0);
	doc.setFont("Georgia");

	var line_counter = 1;
	var top_padding = 100;

/*
* Loop on all the lines and fill the pages:
*/

	for ( var j = 0; j < alle_Zeilen.length; j++ ) {

		var line = alle_Zeilen[j];
			doc.addPage();
			top_padding = top_padding - int(random(-10,+10));

		if (top_padding > 190 || top_padding < 69) {
			top_padding = 90;
		}

			doc.text(left_offset, top_padding, line);
}

/*End of Loop and END OF MAIN CONTENT*/

/*
* Code is like life:
* the most important things happen in a blink of an eye.
*/

/*
	The show is not over yet:
*/

	/* Last but not least: the Imprint */
	/* add empty page before adding the last one */
	doc.addPage();
	doc.addPage();

	/* cover-design adaption */

	doc.setFillColor(160);

	//Loop to generate the lines

	for (var y=0; y<=300; y+=8) {
		var width = 30+(y*0.05);
		var x_tmp = 210-width;
		doc.rect(x_tmp,y,width,2, "F");
	}

	//don't remember what this was for ...

	for (var y=295; y==0; y+=5) {

		doc.rect(150,y,30-(y*0.05),2, "F");

	}

	//Cover design fonts and colors

	l = 40;

	doc.setFontSize(18);
	doc.setTextColor(19,171,205);
	doc.setFont("Helvetica");
	doc.text(left_offset, l,"_IMPRINT");

	/*
	* Imprint content
	*/

	doc.setFontSize(12);

	doc.text(left_offset, (l+=20), "This pdf was downloaded by : ");
	doc.text(left_offset, (l+=10), "IP-Address: "+ serverInfo[0] + ",");
	doc.text(left_offset, (l+=10), "Operating System: "+ os + " (" + osVer + "),");
	doc.text(left_offset, (l+=10), "Current screen resolution: " + res + ",");
	doc.text(left_offset, (l+=10), "Browser: " + browser + " (Version: " + browserVer + "),");
	doc.text(left_offset, (l+=10), "Time: " + d.getHours() + ":" + d.getMinutes() + " (" + timeZone + "),");
	doc.text(left_offset, (l+=10), "Date: " + d.getUTCDate() + " / " + months[d.getMonth()] + " / " + d.getUTCFullYear() + ".");

	doc.text(left_offset, (l+=10), "It was downloaded from the Server: " + serverInfo[1]);
	doc.text(left_offset, (l+=10), "Server software: " + serverInfo[2]);
	doc.text(left_offset, (l+=10), "Server port: " + serverInfo[3]);
	doc.text(left_offset, (l+=10), "Server request time: " + serverInfo[4]);
	doc.text(left_offset, (l+=10), "Server protocol: " + serverInfo[5]);

	/* The End: Save to file. */

	doc.autoPrint();
	doc.save('ledegre13_ag.pdf');

<?php
mail($TO_MAIL, $SUBJ_MAIL, "A new copy was downloaded by ". $serverInfo[0].".");
?>


}

</script>
</div>

<div id="unten">
	<p>Click the button below in order to save your personalized and<br />
	   unique copy of the current randomized selection of 13-liners.</p>
	<button onclick="saveCopy()">Save a PDF!</button>
</div>

</body>
</html>
