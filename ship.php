<?php
	session_start();
	$fromX = isset($_POST['fromX']) ? $_POST['fromX'] : 0;
	$fromY = isset($_POST['fromY']) ? $_POST['fromY'] : 0;
	$toX = isset($_POST['toX']) ? $_POST['toX'] : 0;
	$toY = isset($_POST['toY']) ? $_POST['toY'] : 0;
	$command = isset($_POST['command']) ? $_POST['command'] : 0;
	$extraX = isset($_POST['extraX']) ? $_POST['extraX'] : 0;
	$extraY = isset($_POST['extraY']) ? $_POST['extraY'] : 0;
	$axisX = isset($_POST['axisX']) ? $_POST['axisX'] : 0;
	$axisY = isset($_POST['axisY']) ? $_POST['axisY'] : 0;
	if (!isset($_SESSION['loadFile']))
	{
		// run the parser written in C and save the arrays from "data.txt" into this php session
		exec("./parser", $output);
		for ($i=0; $i<19; $i++)
		{
			$dataarr[] = explode('  ', $output[$i]);
		}
		$_SESSION['lines'] = $dataarr;
		$_SESSION['loadFile'] = 1;
	}
	if (isset($_POST['destroy']))
	{
		session_destroy();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head>
		<title>ship manipulation</title>
	</head>
	<body style="margin:0; padding:0;">
		<div style="width:1800px; height: 1000px;">
			<div style="width:150px; height:1000px; background-image: url(square_small.png); float:left;">
			<form name="Show" action="ship.php" method="post">
				<input type="text" name="currentX" value="0" size="4"/>current X<br/>
				<input type="text" name="currentY" value="0" size="4"/>current Y<br/>
				<input type="text" name="fromX" value="0" size="4"/>start point X<br/>
				<input type="text" name="fromY" value="0" size="4"/>start point Y<br/>
				<input type="text" name="toX" value="0" size="4"/>end point X<br/>
				<input type="text" name="toY" value="0" size="4"/>end point Y<br/>
				<input type="radio" name="command" value="shift" id="shift" onClick="hideExtra()"/>shift<br/>
				<input type="radio" name="command" value="scale" id="scale" onClick="hideExtra()"/>scale<br/>
				<input type="radio" name="command" value="rotate" id="rotate" onClick="showExtra()"/>rotate<br/>
				<input type="radio" name="command" value="horcut" id="horcut" onClick="hideExtra()"/>Hor-Cut<br/>
				<input type="radio" name="command" value="vercut" id="vercut" onClick="hideExtra()"/>Ver-Cut<br/>
				<input type="radio" name="command" value="reflection" id="reflection" onclick="showChecks()"/>reflection<br/>
				<input type="radio" name="command" value="reset" id="resetsession" onClick="hideExtra()"/>reset ship<br/>
				<div id="extraPoint">
					<input type="text" name="extraX" value="0" size="4"/>extra X<br/>
					<input type="text" name="extraY" value="0" size="4"/>extra Y<br/>
				</div>
				<div id="checkboxes">
					<input type="checkbox" name="axisX" value="1"/>axis X<br/>
					<input type="checkbox" name="axisY" value="2"/>axis Y<br/>
				</div>
				<input type="reset" name="reset" value="clear" onclick="resetAll()"/>
				<input type="submit" value="Draw ship" onclick="getData(event)"  />
			</form>
			<form name="killsession" action="ship.php" method="post">
				<input type="submit" name="destroy" value="destroy" />
			</form>
			</div>
			<div style="width: 1600px; height: 1000px; background-image: url(square.png); float: left;" onmousemove="getMouseXY(event)" onclick="getData(event)">
				<?php
					$fromX -= 150;
					$toX -= 150;
					$extraX -= 150;
					// Set data into session so it will be available for main.php
					$_SESSION['fromX'] = $fromX;
					$_SESSION['fromY'] = $fromY;
					$_SESSION['toX'] = $toX;
					$_SESSION['toY'] = $toY;
					$_SESSION['command'] = $command;
					$_SESSION['extraX'] = $extraX;
					$_SESSION['extraY'] = $extraY;
					$_SESSION['axisX'] = $axisX;
					$_SESSION['axisY'] = $axisY;
					// display the image
					echo '<img src="main.php"/><br/>';
					//include("main.php");
					$fromX += 150;
					$toX += 150;
					echo "start point: ($fromX,$fromY)<br/>\n
				end point: ($toX,$toY)<br/>\n";
				?>
			</div>
			<div style="clear: both;"></div>
		</div>
		<script type="text/javascript">
		var flag = 0;
		
		// Main function to retrieve mouse x-y pos.s
		function getMouseXY(event) {
			document.Show.currentX.value = (event.clientX<0)? 0: event.clientX;
			document.Show.currentY.value = (event.clientY<0)? 0: event.clientY;
		}
		
		function resetAll (){
			document.Show.fromX.value = 0;
			document.Show.fromY.value = 0;
			flag = 0;
		}
		
		
		function getData(event) {
			var curX = event.clientX, curY = event.clientY;
			var isExtra = document.getElementById("extraPoint");
			if (isExtra.style.visibility == "visible")
			{
				document.Show.extraX.value = (curX<0)? 0: curX;
				document.Show.extraY.value = (curY<0)? 0: curY;
				isExtra.style.visibility = "hidden";
			}
			else
			{
				switch (flag)
				{
					case 0:
						document.Show.fromX.value = (curX<0)? 0: curX;
						document.Show.fromY.value = (curY<0)? 0: curY;
						flag++;
						break;
					case 1:
						document.Show.toX.value = (curX<0)? 0: curX;
						document.Show.toY.value = (curY<0)? 0: curY;
						document.Show.submit();
				}
			}
		}
		var extraDiv = document.getElementById("extraPoint");
		var checkDiv = document.getElementById("checkboxes");
		function hideExtra()
		{
			extraDiv.style.visibility = "hidden";
			checkDiv.style.visibility = "hidden";
		}
		function showExtra()
		{
			extraDiv.style.visibility = "visible";
			checkDiv.style.visibility = "hidden";
		}
		function showChecks()
		{
			hideExtra();
			checkDiv.style.visibility = "visible";
		}
		function defaultChoise()
		{
			document.getElementById("shift").checked=true;
		}
		window.onload=defaultChoise();
		window.onload=hideExtra();
		</script>
	</body>
</html>