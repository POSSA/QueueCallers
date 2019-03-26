<?php
function resolveAsteriskCommand() {
	$array = array();
	if(isset($_POST['queue']) && trim($_POST['queue'])) {
		$cli = str_replace("?", $_POST["queue"], ASCLI);
		exec($cli, $output, $return_var);
		//remove colors from CLI output
		$output = preg_replace("/\x1b\[[0-9;]*[a-zA-Z]/", "", $output);
		$output = preg_replace("/\x1b\[[0-9;]*[mGKH]/", "", $output);
		$output = preg_replace("/\x1b\[[0-9;]*m/", "", $output);
		$output = preg_replace("/\x1b\[[0-9;]*[mGKF]/", "", $output);
		
		//for($i=0; $i<=(count($output) - 3); $i++) {
		for($i=0; $i<=(count($output) - 2); $i++) {          //changed by lcg to display all callers in queue
			array_push($array, trim($output[$i]));
		}
	}
	else {
		array_push($array, ASCLINOMEM);
		array_push($array, ASCLINOCAL);
	}
	return $array;
}

function getCallers($command) {
	$array = array();
	if(in_array(ASCLINOCAL, $command)) {
	      $array[0] = array();
	      $array[0]["no"] = "";
	      $array[0]["cid"] = "No callers yet!";
	      $array[0]["wait"] = "";
	      $array[0]["prio"] = "";
	      $array[0]["debug"] = "";
	}
	else {
		$ckeys = array_keys($command, ASCLICAL);

		$mkeys = array_keys($command, ASCLIMEM);
                if(trim($mkeys[0]) == "") {
                        $mkeys = array_keys($command, ASCLINOMEM);
                }
		if($ckeys[0] > $mkeys[0]) {
			$goto = count($command);
		}
		else {
			$goto = $mkeys[0];
		}
		$x = 0;
		for($i = ($ckeys[0] + 1); $i < $goto; $i++) {
			$no = preg_replace('/ .*/', "", $command[$i]);
			$temp = preg_replace('/^[0-9]*\. /', "", $command[$i]);
			$cid = preg_replace('/ \(.*/', "", $temp);
			$temp = preg_replace('/.* \(wait: /', "", $command[$i]);
			$wait = preg_replace('/,.*/', "", $temp);
			$temp = preg_replace('/.*, prio: /', "", $command[$i]);
			$prio = preg_replace('/\).*/', "", $temp);

			$array[$x] = array();
			$array[$x]["no"] = $no;
			$array[$x]["cid"] = $cid;
			$array[$x]["wait"] = $wait;
			$array[$x]["prio"] = $prio;
			$array[$x]["debug"] = $command[$i];

			$x++;
		}
	}
	return $array;
}

function getMembers($command) {
        $array = array();
        if(in_array(ASCLINOMEM, $command)) {
                $array[0] = array();
                $array[0]["name"] = "No agent logged in!";
                $array[0]["source"] = "";
                $array[0]["status"] = "";
                $array[0]["calls"] = "";
                $array[0]["last"] = "";
                $array[0]["debug"] = "";
        }
        else {
                $ckeys = array_keys($command, ASCLICAL);
                if(trim($ckeys[0]) == "") {
                  $ckeys = array_keys($command, ASCLINOCAL);
                }
                $mkeys = array_keys($command, ASCLIMEM);
                if($ckeys[0] > $mkeys[0]) {
                        $goto = ($ckeys[0] - 1);
                }
                else {
                        $goto = count($command);
                }
                $x = 0;
                for($i = ($mkeys[0] + 1); $i <= $goto; $i++) {
                      preg_match('/(.*)\ \(Local\/(\d+)(.*)\d+m(Unavailable|Not in use|Ringing|in use)(.*)taken (\d+|no) calls(.*)(was (\d+)|yet)/i', $command[$i], $m);
                      $last = $m[6] == 'no' ? 'N/A' : sec2hms($m[9]);
                      $array[$x] = array();
                      $array[$x]["name"] = trim($m[1]);
                      $array[$x]["source"] = trim($m[2]);
                      $array[$x]["status"] = trim($m[4]);
                      $array[$x]["calls"] = trim($m[6]);
                      $array[$x]["last"] = trim($last);
                      $array[$x]["debug"] = trim($command[$i]);
                      $x++;
                }
        }
        return $array;
}

  function sec2hms ($sec, $padHours = false) 
  {

    // start with a blank string
    $hms = "";
    
    // do the hours first: there are 3600 seconds in an hour, so if we divide
    // the total number of seconds by 3600 and throw away the remainder, we're
    // left with the number of hours in those seconds
    $hours = intval(intval($sec) / 3600); 

    // add hours to $hms (with a leading 0 if asked for)
    $hms .= ($padHours) 
          ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":"
          : $hours. ":";
    
    // dividing the total seconds by 60 will give us the number of minutes
    // in total, but we're interested in *minutes past the hour* and to get
    // this, we have to divide by 60 again and then use the remainder
    $minutes = intval(($sec / 60) % 60); 

    // add minutes to $hms (with a leading 0 if needed)
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";

    // seconds past the minute are found by dividing the total number of seconds
    // by 60 and using the remainder
    $seconds = intval($sec % 60); 

    // add seconds to $hms (with a leading 0 if needed)
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

    // done!
    return $hms;
    
  }
?>
