<?php

require 'config.php';

function similar($rgb1, $rgb2) {
	$r1 = ($rgb1 >> 16) & 0xFF;
	$g1 = ($rgb1 >> 8) & 0xFF;
	$b1 = $rgb1 & 0xFF;
	$r2 = ($rgb2 >> 16) & 0xFF;
	$g2 = ($rgb2 >> 8) & 0xFF;
	$b2 = $rgb2 & 0xFF;
	return abs($r1 - $r2) < 10 && abs($b1 - $b2) < 10 && abs($g1 - $g2) < 10;
}

function getStart() {
	global $image;
	$width  = imagesx($image);
	$height = imagesy($image);
	for ($i = $height / 3; $i < $height / 3 * 2; $i++) {
		for ($j = 0; $j < $width - 75; $j++) {
			if (checkStart($i, $j)) {
				$x = $i;
				$y = $j + 37;
			}
		}
	}
	return array($x, $y);
}

function getEnd() {
	global $image;
	global $sx, $sy;
	$width  = imagesx($image);
	$height = imagesy($image);
	for ($i = $height / 3; $i < $sx; $i++) {
		$demo  = imagecolorat($image, 0, $i);
		$count = 0;
		for ($j = 0; $j < $width; $j++) {
			$c = imagecolorat($image, $j, $i);
			if (!similar($c, $demo)) {
				$count++;
			} else {
				if ($count > BODY_WIDTH * 1.1) {
					$x = $i;
					$y = $j - $count / 2;
					if (abs($y - $sy) > 20) {
						return [$x, $y];
					}
				}
				$count = 0;
			}
		}
	}
	return [0, 0];
}

$cheet = [
    2829129, 2829129, 2829129, 2829129, 2829387, 2960716, 2960461,
    2960463, 3026256, 3026256, 3092563, 3092563, 3158614, 3158615,
    3224408, 3290202, 3356252, 3356252, 3356252, 3356767, 3357024,
    3553376, 3618913, 3618913, 3553891, 3684707, 3750243, 3684706,
    3684707, 3684707, 3684707, 3750243, 3618914, 3618913, 3684450,
    3750243, 3750243, 3750243, 3750243, 3750243, 3684706, 3618913,
    3618913, 3618913, 3684450, 3684706, 3684706, 3684450, 3684450,
    3750243, 3750243, 3684450, 3684706, 3750243, 3618913, 3618913,
    3618913, 3684448, 3749727, 3749727, 3749727, 3749727, 3749727,
    3749470, 3749469, 3749469, 3749721, 3749720, 3749720, 3814998,
    3814997, 3880534, 3880533, 3946835, 3881042
];

function checkStart($sx, $sy) {
	global $cheet;
	global $image;
	for ($i = 0; $i < 75; $i++) {
		$rgb = imagecolorat($image, $sy + $i, $sx);
		if (!similar($rgb, $cheet[$i])) {
			return false;
		}
	}
	return true;
}

function screencap() {
    ob_start();
	system('adb shell screencap -p /sdcard/screen.png');
	system('adb pull /sdcard/screen.png .');
    ob_end_clean();
}

function press($time) {
    system('adb shell input swipe 500 1600 500 1601 ' . $time);
}

for ($id = 0; ; $id++) {
    echo sprintf("#%05d: ", $id);
    // 截图
	screencap();
    // 获取坐标
	$image = imagecreatefrompng('screen.png');
	list($sx, $sy) = getStart();
	list($tx, $ty) = getEnd();
    if ($sx == 0) break;
	echo sprintf("(%d, %d) -> (%d, %d) ", $sx, $sy, $tx, $ty);
    // 图像描点
	imagefilledellipse($image, $sy, $sx, 10, 10, 0xFF0000);
	imagefilledellipse($image, $ty, $tx, 10, 10, 0xFF0000);
	imagepng($image, sprintf("screen/%05d.png", $id));
    // 计算按压时间
	$time = sqrt(pow($tx - $sx, 2) + pow($ty - $sy, 2)) * PRESS_TIME;
	$time = round(max(300, $time));
    echo sprintf("time: %f\n", $time);
	press($time);
    // 等待下一次截图
	sleep(SLEEP_TIME);
}
