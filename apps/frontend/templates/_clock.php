<?php
/* Входные аргументы:
 * $id		string		идентификатор часов, должен быть уникальным на странице
 * $time	string		стартовое значение часов в формате 'ЧЧ:ММ:СС'
 */
if ( ! isset($time) )
{
	$decodedTime = localtime(Timing::getActualTime(), true);
	$h = $decodedTime['tm_hour'];
	$m = $decodedTime['tm_min'];
	$s = $decodedTime['tm_sec'];
}
else
{
	$parts = explode(':', $time);
	$h = $parts[0];
	$m = $parts[1];
	$s = $parts[2];
}

$domId = (isset($id) ?  $id : 'server').'Clock';
$funcId = $domId.'Func';
?>
<span id="<?php echo $domId ?>"><?php echo $time ?></span><script type="text/javascript">
	var <?php echo $funcId ?> =
	{
		h: <?php echo $h ?>,
		m: <?php echo $m ?>,
		s: <?php echo $s ?>,

		func: function() {
			this.s = this.s + 1;
			if (this.s >= 59) {
				this.s = 0;
				this.m = this.m + 1;
				if (this.m >= 59) {
					this.m = 0;
					this.h = this.h + 1;
					if (this.h >= 23) { this.h = 0; }
				}
			}
			document.getElementById("<?php echo $domId ?>").innerHTML = ((this.h>9) ? this.h : "0"+this.h) + ":" + ((this.m>9) ? this.m : "0"+this.m) + ":" + ((this.s>9)? this.s : "0"+this.s);
			setTimeout('<?php echo $funcId ?>.func()', 1000);
		}
	}
	setTimeout('<?php echo $funcId ?>.func()', 1);
</script>