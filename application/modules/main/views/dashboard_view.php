<?php
// MAIN VIEW (DASHBOARD)
$username = $this->subdomain;
if (empty($username)) $username = "[not defined]";
?>
<h2>Crown Holiday's Member Site</h2>
<p>You are: <?= $username ?></p>


