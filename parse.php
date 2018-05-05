<pre>
<?php
	exec("./parser", $output);
	for ($i=0; $i<19; $i++)
	{
		$firstarr[] = explode('  ', $output[$i]);
	}
	print_r($firstarr);
	system("gcc -Wall parser.c -o parser");
	system("./parser");
?>
</pre>