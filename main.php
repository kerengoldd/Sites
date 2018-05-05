<?php
	session_start();
	header ('Content-type: image.png');
/**
 *
 */
function drawImage()
	{
		global $_SESSION;
		global $im;
		global $color;
		for ($i = 0 ; $i < count($_SESSION['lines']) ; $i++)
		{
			if ($_SESSION['lines'][$i][2] != (-999))
			{
				imageline($im, $_SESSION['lines'][$i][0], $_SESSION['lines'][$i][1], $_SESSION['lines'][$i][2], $_SESSION['lines'][$i][3], $color);
			}
			else
			{
				imagearc($im, $_SESSION['lines'][$i][0], $_SESSION['lines'][$i][1], ($_SESSION['lines'][$i][3]) * 2, ($_SESSION['lines'][$i][3]) * 2,  0, 360, $color);
			}
		}
		imagepng($im);
		imagedestroy($im);
	}
	function shifting($fromX, $fromY, $toX, $toY)
	{
		global $_SESSION;
		$dx = $toX - $fromX;
		$dy = $toY - $fromY;
		for ($i = 0 ; $i < count($_SESSION['lines']) ; $i++)
		{
			$_SESSION['lines'][$i][0] = ($_SESSION['lines'][$i][0] + $dx);
			$_SESSION['lines'][$i][1] = ($_SESSION['lines'][$i][1] + $dy);
			if ($_SESSION['lines'][$i][2] != (-999))
			{
				$_SESSION['lines'][$i][2] = ($_SESSION['lines'][$i][2] + $dx);
				$_SESSION['lines'][$i][3] = ($_SESSION['lines'][$i][3] + $dy);
			}
		}
	}
	function rotate($fromX, $fromY, $toX, $toY, $centerX, $centerY)
	{
		// calculate angle of rotation ($t = angle)
		global $_SESSION;
		$dx = $toX - $fromX;
		$dy = $toY - $fromY;
		if ($dy == $dx) die ("illegal parameters, can't perform rotation");
		$t = atan($dy / $dx); // angle to rotate in radians
		$cteta = cos($t);
		$steta = sin($t);
		// move the image to center of axis
		shifting($centerX, $centerY, 0, 0);
		for ($i = 0 ; $i < count($_SESSION['lines']) ; $i++)
		{
			if ($_SESSION['lines'][$i][2] != (-999))
			{
				$x1 = $_SESSION['lines'][$i][0];
				$y1 = $_SESSION['lines'][$i][1];
				$x2 = $_SESSION['lines'][$i][2];
				$y2 = $_SESSION['lines'][$i][3];
				// Multiplying in rotation matrix to get new coordinates
				$newX1 = $x1 * $cteta - $y1 * $steta;
				$newY1 = $x1 * $steta + $y1 * $cteta;
				$newX2 = $x2 * $cteta - $y2 * $steta;
				$newY2 = $x2 * $steta + $y2 * $cteta;
				// saving new coordinates over the old ones
				$_SESSION['lines'][$i][0] = $newX1;
				$_SESSION['lines'][$i][1] = $newY1;
				$_SESSION['lines'][$i][2] = $newX2;
				$_SESSION['lines'][$i][3] = $newY2;
			}
			else
			{
				// It's a circle. Changing center point location without change to the radius
				$x1 = $_SESSION['lines'][$i][0];
				$y1 = $_SESSION['lines'][$i][1];
				// Multiplying in rotation matrix to get new coordinates
				$newX1 = $x1 * $cteta - $y1 * $steta;
				$newY1 = $x1 * $steta + $y1 * $cteta;
				// saving new coordinates over the old ones
				$_SESSION['lines'][$i][0] = $newX1;
				$_SESSION['lines'][$i][1] = $newY1;
			}
		}
		// moving rotated image to its old center location
		shifting(0, 0, $centerX, $centerY);
	}
	function horcut($fromX, $toX)
	{
		global $_SESSION;
		$dx = $toX - $fromX;
		// find both maximum y and minumum y
		for ($i = 0 ; $i < count($_SESSION['lines']) ; $i++)
		{
			if ($_SESSION['lines'][$i][2] != (-999))					// make sure it's a line and not a circle
			{															// Get the minimum and maximum Y values
				if ($maxY < $_SESSION['lines'][$i][1])
					$maxY = $_SESSION['lines'][$i][1];
				else if ($minY > $_SESSION['lines'][$i][1])
					$minY = $_SESSION['lines'][$i][1];
				if ($maxY < $_SESSION['lines'][$i][3])
					$maxY = $_SESSION['lines'][$i][3];
				else if ($minY > $_SESSION['lines'][$i][3])
					$minY = $_SESSION['lines'][$i][3];
			}
		}
		// start transformation. the closer the point to the top - the farther it will go on X axis.
		for ($i = 0 ; $i < count($_SESSION['lines']) ; $i++)
		{
			$x = $_SESSION['lines'][$i][0];
			$y = $_SESSION['lines'][$i][1];
			$_SESSION['lines'][$i][0] += $dx * (1 - $y / $maxY);		// add to each x the relative value according to its height
			if ($_SESSION['lines'][$i][2] != (-999))					// make sure it's a point and not a circle
			{
				$x = $_SESSION['lines'][$i][2];
				$y = $_SESSION['lines'][$i][3];
				$_SESSION['lines'][$i][2] += $dx * (1 - $y / $maxY);	// add to each x the relative value according to its height
			}
		}
	}
	function vercut($fromY, $toY)
	{
		global $_SESSION;
		$dy = $toY - $fromY;
		// find both maximum y and minumum y
		for ($i = 0 ; $i < count($_SESSION['lines']) ; $i++)
		{
			if ($_SESSION['lines'][$i][2] != (-999))					// make sure it's a line and not a circle
			{															// Get the minimum and maximum Y values
				if ($maxX < $_SESSION['lines'][$i][0])
					$maxX = $_SESSION['lines'][$i][0];
				else if ($minX > $_SESSION['lines'][$i][0])
					$minX = $_SESSION['lines'][$i][0];
				if ($maxX < $_SESSION['lines'][$i][2])
					$maxX = $_SESSION['lines'][$i][2];
				else if ($minX > $_SESSION['lines'][$i][2])
					$minX = $_SESSION['lines'][$i][2];
			}
		}
		// start transformation. the closer the point to the top - the farther it will go on Y axis.
		for ($i = 0 ; $i < count($_SESSION['lines']) ; $i++)
		{
			$x = $_SESSION['lines'][$i][0];
			$y = $_SESSION['lines'][$i][1];
			$_SESSION['lines'][$i][1] += $dy * (1 - $x / $maxX);		// add to each y the relative value according to its width
			if ($_SESSION['lines'][$i][2] != (-999))					// make sure it's a point and not a circle
			{
				$x = $_SESSION['lines'][$i][2];
				$y = $_SESSION['lines'][$i][3];
				$_SESSION['lines'][$i][3] += $dy * (1 - $x / $maxX);	// add to each y the relative value according to its width
			}
		}
	}
	function scale($centerX, $centerY, $multiplier)
	{
		global $_SESSION;
		if ($multiplier >= 1)	// The ship is getting enormous!
		{
			for ($i = 0 ; $i < count($_SESSION['lines']) ; $i++)
			{
				if ($_SESSION['lines'][$i][2] != (-999))	// its a line
				{
					$_SESSION['lines'][$i][0] = $_SESSION['lines'][$i][0] * $multiplier - $centerX;
					$_SESSION['lines'][$i][1] = $_SESSION['lines'][$i][1] * $multiplier - $centerY;
					$_SESSION['lines'][$i][2] = $_SESSION['lines'][$i][2] * $multiplier - $centerX;
					$_SESSION['lines'][$i][3] = $_SESSION['lines'][$i][3] * $multiplier - $centerY;
				}
				else
				{
					$_SESSION['lines'][$i][0] = $_SESSION['lines'][$i][0] * $multiplier - $centerX;
					$_SESSION['lines'][$i][1] = $_SESSION['lines'][$i][1] * $multiplier - $centerY;
					$_SESSION['lines'][$i][3] *= $multiplier;
				}
			}
		}
		else if ($multiplier > 0 && $multiplier < 1)	// The ship is getting small
		{
			for ($i = 0 ; $i < count($_SESSION['lines']) ; $i++)
			{
				if ($_SESSION['lines'][$i][2] != (-999))	// its a line
				{
					$_SESSION['lines'][$i][0] = ($_SESSION['lines'][$i][0] + $centerX) * $multiplier;
					$_SESSION['lines'][$i][1] = ($_SESSION['lines'][$i][1] + $centerY) * $multiplier;
					$_SESSION['lines'][$i][2] = ($_SESSION['lines'][$i][2] + $centerX) * $multiplier;
					$_SESSION['lines'][$i][3] = ($_SESSION['lines'][$i][3] + $centerY) * $multiplier;
				}
				else	// its a circle
				{
					$_SESSION['lines'][$i][0] = ($_SESSION['lines'][$i][0] + $centerX) * $multiplier;
					$_SESSION['lines'][$i][1] = ($_SESSION['lines'][$i][1] + $centerY) * $multiplier;
					$_SESSION['lines'][$i][3] *= $multiplier;
				}
			}
		}
	}
	function reflection ($fromX, $fromY, $dir)
	{
		global $_SESSION;
		if ($dir == 1)										// Reflection through x axis
		{
			
			for ($i = 0 ; $i < count($_SESSION['lines']) ; $i++)
			{
				$_SESSION['lines'][$i][1] = $fromY - ($_SESSION['lines'][$i][1] - $fromY);
				if ($_SESSION['lines'][$i][2] != (-999))
					$_SESSION['lines'][$i][3] = $fromY - ($_SESSION['lines'][$i][3] - $fromY);
			}
		}
		else if ($dir == 2)									// Reflection through y axis
		{
			for ($i = 0 ; $i < count($_SESSION['lines']) ; $i++)
			{
				$_SESSION['lines'][$i][0] = $fromX - ($_SESSION['lines'][$i][0] - $fromX);
				if ($_SESSION['lines'][$i][2] != (-999))
					$_SESSION['lines'][$i][2] = $fromX - ($_SESSION['lines'][$i][2] - $fromX);
			}
		}
	}
	// Get data from session
	$fromX = $_SESSION['fromX'];
	$fromY = $_SESSION['fromY'];
	$toX = $_SESSION['toX'];
	$toY = $_SESSION['toY'];
	$command = $_SESSION['command'];
	$extraX = $_SESSION['extraX'];
	$extraY = $_SESSION['extraY'];
	$axisX = $_SESSION['axisX'];
	$axisY = $_SESSION['axisY'];
	$canvasX = 1000;
	$canvasY = 1000;
	// Creating the image and setting colors
	$im = @imagecreatetruecolor ($canvasX, $canvasY) or die('Cannot Initialize new GD image stream');
	$color = imagecolorallocate($im, 255, 0, 0);								// color of the drawn polygon
	$transparent_color = imagecolorallocate($im, 255, 0, 0);				// color that will represent transparency
	imagecolortransparent($im, $transparent_color);							// set transparency color
	imagefilledrectangle($im,0,0,$canvasX,$canvasY,$transparent_color);		// fill image with transparent color
	// If session has no points (due to lack of data file) a default ship will be set
		
	if ($command == "shift")
	{
		shifting($fromX, $fromY, $toX, $toY);
	}
	else if ($command == "rotate")
	{
		rotate($fromX, $fromY, $toX, $toY, $extraX, $extraY);
	}
	else if ($command == "horcut")
	{
		horcut($fromX, $toX);
	}
	else if ($command == "vercut")
	{
		vercut($fromY, $toY);
	}
	else if ($command == "scale")
	{
		scale($fromX, $fromY, $toY);
	}
	else if ($command == "reflection")
	{
		if ($axisX == 1)
		{
			reflection($fromY, $toY, $axisX);
		}
		if ($axisY == 2)
		{
			reflection($fromX, $toX, $axisY);
		}
	}
	else if ($command == "reset")
	{
		exec("./parse", $output);
		for ($i=0; $i<19; $i++)
		{
			$dataarr[] = explode('  ', $output[$i]);
		}
		$_SESSION['lines'] = $dataarr;
	}
	drawImage();
?>