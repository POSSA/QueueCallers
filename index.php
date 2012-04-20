<?php
include_once("inc/defines.php");
include_once("inc/functions.php");
include_once("inc/dbconnect.php");

$command = resolveAsteriskCommand($_POST["queue"]);
$callers = getCallers($command);
$members = getMembers($command);

//echo "Command:";
//print_r($command);
//echo "Callers:";
//print_r($callers);
//echo "Members:";
//print_r($members);

?>
<html>
<head>
  <title>Queue list</title>
  <meta http-equiv="Content-Type" content="text/html">
  <link href="css/defaultstyle.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="qform" action="" method="post">
  <div id="page">

    <div class="header">
      <div class="header-left">
      <a href="#"><img src="images/queue-small.png"/></a>
      </div>

      <div class="header-right">
      <div class="refresh">
        Refresh rate:
        <select name="refresh" onChange="document.qform.submit()">
          <?php
          $refresh=array("5", "10", "15", "20", "25", "30", "35", "40", "45", "50", "55", "60");
          foreach($refresh as $value) {
            $selected = isset($_POST['refresh']) && trim($_POST['refresh']) == $value ? 'selected="selected"' : '';
            if($value == "10" && !isset($_POST['refresh'])) { $selected = 'selected="selected"'; }
            echo '<option value="'.$value.'" '.$selected.'>'.$value.'</option>';
          }
          ?>
        </select>
      </div>

      <div class="queue">
        Please select a queue:
        <select name="queue" onChange="document.qform.submit()">
          <option value="">--- Make your choice ---</option>
          <?php
          $result = mysql_query(ASSQLQUEUE, $asdb) or die("Invalid query: ".mysql_error());
          while($row = mysql_fetch_assoc($result)) {
            $selected = isset($_POST['queue']) && trim($_POST['queue']) == $row['extension'] ? 'selected="selected"' : '';
            echo '<option value="'.$row['extension'].'" '.$selected.'>'.$row['descr'].' ('.$row['extension'].')</option>';
          }
          ?>
        </select>
      </div>
      </div>
    </div>

    <div class="content">
      <div class="htable">
        Callers in queue<?php if(count($callers) > 1) { echo ' ('.count($callers).' total)'; } ?>:
      </div>

      <div class="table-layer">
        <div class="table-row-hdr">
          <div class="cal-small-layer">
            <h5 class="colhdr">
              No.
            </h5>
          </div>
          <div class="cal-big-layer">
            <h5 class="colhdr">
              Caller ID
            </h5>
          </div>
          <div class="cal-small-layer">
            <h5 class="colhdr">
              Wait
            </h5>
          </div>
          <div class="cal-small-layer">
            <h5 class="colhdr">
              Prio
            </h5>
          </div>
          <div class="space-line"><!-- No content --></div>
        </div>
	<?php
	for($i = 0; $i < count($callers); $i++) {
	?>
        <div class="table-row" onMouseOver="this.style.backgroundColor='#F9F9F9';" onMouseOut="this.style.backgroundColor='#FFFFFF';">
          <div class="cal-small-layer">
            <p class="text">
              <?php echo $callers[$i]["no"]; ?>
            </p>
           </div>
          <div class="cal-big-layer">
            <p class="text">
              <?php echo $callers[$i]["cid"]; ?>
            </p>
          </div>
          <div class="cal-small-layer">
            <p class="text">
              <?php echo $callers[$i]["wait"]; ?>
            </p>
          </div>
          <div class="cal-small-layer">
            <p class="text">
              <?php echo $callers[$i]["prio"]; ?>
            </p>
          </div>
          <div class="space-line"><!-- No content --></div>
        </div>
	<input type="hidden" name="cal-debug" value="<?php echo $callers[$i]["debug"]; ?>" />
	<?php
	}
	?>
      </div>

      <br /><br />

      <div class="htable">
        Logged in agents:
      </div>

      <div class="table-layer">
        <div class="table-row-hdr">
          <div class="mem-big-layer">
            <h5 class="colhdr">
              Agent name
            </h5>
          </div>
          <div class="mem-big-layer">
            <h5 class="colhdr">
              Source
            </h5>
          </div>
          <div class="mem-small-layer">
            <h5 class="colhdr">
              Status
            </h5>
          </div>
          <div class="mem-small-layer">
            <h5 class="colhdr">
              Calls
            </h5>
          </div>
          <div class="mem-small-layer">
            <h5 class="colhdr">
              Last
            </h5>
          </div>
          <div class="space-line"><!-- No content --></div>
        </div>
	<?php
	for($i = 0; $i < count($members); $i++) {
	?>
        <div class="table-row" onMouseOver="this.style.backgroundColor='#F9F9F9';" onMouseOut="this.style.backgroundColor='#FFFFFF';">
          <div class="mem-big-layer">
            <p class="text">
              <?php echo $members[$i]["name"]; ?>
            </p>
           </div>
          <div class="mem-big-layer">
            <p class="text">
              <?php echo $members[$i]["source"]; ?>
            </p>
          </div>
          <div class="mem-small-layer">
            <p class="text">
              <?php echo $members[$i]["status"]; ?>
            </p>
          </div>
          <div class="mem-small-layer">
            <p class="text">
              <?php echo $members[$i]["calls"]; ?>
            </p>
          </div>
          <div class="mem-small-layer">
            <p class="text">
              <?php echo $members[$i]["last"]; ?>
            </p>
          </div>
          <div class="space-line"><!-- No content --></div>
        </div>
      </div>
      <input type="hidden" name="mem-debug" value="<?php echo $members[$i]["debug"]; ?>" />
      <?php
      }
      ?>
    </div>

    <br /><br />

    <center>[<a href="http://www.gnu.org/licenses/gpl.html">GNU General Public License</a>] Copyright &copy; <?php echo date("Y"); ?> <a href="http://www.markinthedark.nl">Mark Veenstra</a></center>

  </div>
  <?php
  if(isset($_POST['queue']) && trim($_POST['queue']) != "") {
  ?>
  <script language="JavaScript">
    <!--
    var t = <?php if(isset($_POST['refresh']) && trim($_POST['refresh']) != "") { echo ($_POST['refresh'] * 1000); } else { echo '10000'; } ?>;
    setTimeout('document.qform.submit()',t);
    //-->
  </script>
  <?php
  }
  ?>
</form>
</body>
</html>
