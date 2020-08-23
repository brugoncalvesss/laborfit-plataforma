<?php
session_start();
session_destroy();
header("location: /?status=". md5(date()));
exit();