<?php
session_start();
header("Content-Type:text/html; charset=utf-8");
session_unset( );
session_destroy( );
echo "<script>alert('您已成功登出')</script>";
echo "<script>document.location.href=\"login.php\";</script>";
