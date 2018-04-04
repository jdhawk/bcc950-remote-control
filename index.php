<?php
	$Command = $_REQUEST['command'];
	$Device = "/dev/video1";
	$SleepStep = 100000;
	if ($Command == 'move') {
		echo $_REQUEST['action'];
		switch ($_REQUEST['action']) {
			case 'up':
				exec ("v4l2-ctl -d {$Device} -c tilt_speed=1 && usleep {$SleepStep} && v4l2-ctl -d {$Device} -c tilt_speed=0");
				break;
			case 'down':
				exec ("v4l2-ctl -d {$Device} -c tilt_speed=-1 && usleep {$SleepStep} && v4l2-ctl -d {$Device} -c tilt_speed=0");
				break;
			case 'left':
				exec ("v4l2-ctl -d {$Device} -c pan_speed=-1 && usleep {$SleepStep} && v4l2-ctl -d {$Device} -c pan_speed=0");
				break;
			case 'right':
				exec ("v4l2-ctl -d {$Device} -c pan_speed=1 && usleep {$SleepStep} && v4l2-ctl -d {$Device} -c pan_speed=0");
				break;
			case 'in':
				$CurrentZoom = preg_replace("#[^\d]+#",'',`v4l2-ctl -d {$Device} -C zoom_absolute`);
				if ($CurrentZoom < 500) {
					exec ("v4l2-ctl -d {$Device} -c zoom_absolute=".min($CurrentZoom + 10,500));
				}
				break;
			case 'out':
				$CurrentZoom = preg_replace("#[^\d]+#",'',`v4l2-ctl -d {$Device} -C zoom_absolute`);
				if ($CurrentZoom > 100) {
					exec ("v4l2-ctl -d {$Device} -c zoom_absolute=".max($CurrentZoom - 10,100));
				}
				break;
		}
	} else {

		?>

		<html>
		<head>
			<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
			<script>
				$(document)
					.ready(function() {
						$('body')
							.on('click', 'button', function(event) {
								event.preventDefault;
								$.ajax({
									type : "POST",
									url  : "/",
									data : {
										command: 'move',
										action : $(this).data("action")
									},
									error: function(result) {
										alert('error');
									}
								});
							})
					});
			</script>
		</head>
		<body>
		<table>
			<tr>
				<td>&nbsp;</td>
				<td>
					<button data-action='up' id="up">Up</button>
				</td>
				<td>&nbsp;</td>
				<td>
					<button data-action='in' id="in">+</button>
				</td>
			</tr>
			<tr>
				<td>
					<button data-action='left' id="left">Left</button>
				</td>
				<td>&nbsp;</td>
				<td>
					<button data-action='right' id="right">Right</button>
				</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<button data-action='down' id="down">Down</button>
				</td>
				<td>&nbsp;</td>
				<td>
					<button data-action='out' id="out">-</button>
				</td>
			</tr>
		</table>
		<BR><BR><BR><BR><BR><BR><BR><BR>
		<a href='https://hangouts.google.com/call/oeKxaorMywZ7XQVY5AA5AAEE'>https://hangouts.google.com/call/oeKxaorMywZ7XQVY5AA5AAEE</a>
		</body>
		</html>
		<?php
	}
