<?php
	$fromX = isset($_POST['fromX']) ? $_POST['fromX'] : 0;
	$fromY = isset($_POST['fromY']) ? $_POST['fromY'] : 0;
	$toX = isset($_POST['toX']) ? $_POST['toX'] : 0;
	$toY = isset($_POST['toY']) ? $_POST['toY'] : 0;
	$command = isset($_POST['command']) ? $_POST['command'] : 0;
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
			<form name="Show" action="index.php" method="post">
				<input type="text" name="currentX" value="0" size="4"/>current X<br/>
				<input type="text" name="currentY" value="0" size="4"/>current Y<br/>
				<input type="text" name="fromX" value="0" size="4"/>start point X<br/>
				<input type="text" name="fromY" value="0" size="4"/>start point Y<br/>
				<input type="text" name="toX" value="0" size="4"/>end point X<br/>
				<input type="text" name="toY" value="0" size="4"/>end point Y<br/>
				<input type="hidden" name="command" value="shift"/><br/>
				<input type="reset" name="reset" value="clear" onclick="resetAll()"/>
				<input type="submit" value="Draw Line" />
			</form>
			</div>
			<div style="width: 1600px; height: 1000px; background-image: url(square.png); float: left;" onmousemove="getMouseXY(event)" onclick="getData(event)">
				<?php
					$fromX -= 150;
					$toX -= 150;
					echo '<img src="main.php?fromX=' . $fromX . '&amp;fromY=' . $fromY . '&amp;toX=' . $toX . '&amp;toY=' . $toY . ' &amp;command=shift"/><br/>'."\n";
					$fromX += 150;
					$toX += 150;
					echo "				start point: ($fromX,$fromY)<br/>\n
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
			switch (flag) {
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
		</script>
	</body>
</html>