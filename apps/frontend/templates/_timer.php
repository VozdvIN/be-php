<?php
/* Входные аргументы:
 * $id			string		идентификатор таймера, должен быть уникальным на странице
 * $time		string		стартовое значение таймера в формате 'ЧЧ:ММ:СС'
 * $command		string		JavaScript-команда при истечении времени
 */
$parts = explode(':', $time);
$domId = isset($id) ?  $id : 'untitled'.'Timer';
$funcId = $domId.'Func';
?>
<span id="<?php echo $domId ?>"><?php echo $time ?></span><script type="text/javascript">
	var <?php echo $funcId ?> = {
		d: 0,
		h: <?php echo $parts[0] ?>,
		m: <?php echo $parts[1] ?>,
		s: <?php echo $parts[2] ?>,
		done: false,

		onTimer: function() {
			<?php echo $command ?>;
		},

		func: function() {
			if (this.d == 0 && this.h == 0 && this.m == 0 && this.s == 0) {
				if ( ! this.done) { this.onTimer(); this.done = true; }
			}
			else {
				if (this.s == 0) {
					this.s = 59;
					if (this.m == 0) {
						this.m = 59;
						if (this.h == 0) { this.h = 23; this.days = this.days - 1; }
						else { this.h = this.h - 1; }
					}
					else { this.m = this.m - 1; }
				}
				else { this.s = this.s - 1; }
			}
			document.getElementById("<?php echo $domId ?>").innerHTML =
				((this.d>0) ? this.d+" days " : "")
				+ ((this.h>9) ? this.h : "0"+this.h) + ":"
				+ ((this.m>9) ? this.m : "0"+this.m) + ":"
				+ ((this.s>9) ? this.s : "0"+this.s);
			setTimeout("<?php echo $funcId ?>.func()", 1000);
		}
	}
	setTimeout('<?php echo $funcId ?>.func()', 1000);
</script>