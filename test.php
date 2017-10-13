<?php
function createSchema(){
	$error='';
	$cmd="service nginx restart";
	$descriptorspec=array(
		0=>array('pipe',"r"),
		1=>array('pipe',"w"),
		2=>array('pipe',"w"),
	);
	$process=proc_open($cmd,$descriptorspec,$pipes);
	if(is_resource($process)){
		$error=stream_get_contents($pipes[2]);
		fclose($pipes[1]);
		$return_value=proc_close($process);
	}else{
	}
	if($return_value!==0){
		throw new \Exception($error,$return_value);
	}
	echo $return_value;
}
createSchema();
