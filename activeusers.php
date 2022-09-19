<?php
session_start();
echo count(glob(session_save_path().'/*'),1);
?>