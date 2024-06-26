<?php
if (@is_file('config.inc.php')) {
    header('Location: main.php');
}
else {
    header('Location: setup.php');
}
?>