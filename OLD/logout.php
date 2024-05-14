<?
setcookie("userId", $user[0], time() - (3600 * 24*365), "/");
				setcookie("userName", $user[1], time() - (3600 * 24*365), "/");
				header ("Location: /");