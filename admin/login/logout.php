<?php
session_destroy();
header("location: /admin/login/?status=logout");
exit();