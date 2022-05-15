<?php
require '/usr/local/cpanel/php/cpanel.php';

$cpanel = new CPANEL();
print $cpanel->header( "Blacklist Checker" );
?> 

<link rel="stylesheet" type="text/css" href="assets/css/main.css" media="screen" />

<div class="container" style="width: auto">
        <div v-model=""></div>
        <div class="content">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <ul class="nav navbar-nav">
<li><a href="?ip=<?php echo $_SERVER['REMOTE_ADDR'];?>">Your current IP address is: <b><?php echo $_SERVER['REMOTE_ADDR'];?></b></a></li>                        
<li><a href="?ip=<?php echo $_SERVER['SERVER_ADDR'];?>">Server IP address is: <b><?php echo $_SERVER['SERVER_ADDR'];?></b></a></li>
                    </ul>
                </div>
            </nav>

<p>The blacklist check will test an IP address against over 100 DNS based email blacklists. (Commonly called Realtime blacklist, DNSBL or RBL).</p>
<p>Email blacklists are used by email providers to reduce spam. If your mail server has been blacklisted, some email you send may not be delivered. <a href="#" target="_blank">Learn more</a></p>
<hr>
<form action="" method="get">
<p>Enter an IP address or a hostname to start the check:
<input type="text" value="" name="ip" placeholder="Insert Your IP ..." />
<input type="submit" value="LOOKUP" /></p>
</form>

<?php
function dnsbllookup($ip){
        $dnsbl_lookup=array(
        "bl.spamcop.net",
        "cbl.abuseat.org",
        "dnsbl.justspam.org",
        "dnsbl.sorbs.net",
        "relays.mail-abuse.org",
        "spam.dnsbl.sorbs.net",
        "spamguard.leadmon.net",
        "zen.spamhaus.org"); // Add your preferred list of DNSBL's

if($ip){
        $reverse_ip=implode(".",array_reverse(explode(".",$ip)));
foreach($dnsbl_lookup as $host){
        if(checkdnsrr($reverse_ip.".".$host.".","A")){
                $listed.='<font color="red">🔴 </font>'.$reverse_ip.'.'.$host.' <font color="red">Listed</font><br />';
                }
        }
}

if($listed){
        echo $listed;
}else{
        echo "IP $ip <font color='green'>not listed</font> in SPAM list";
        }
}

$ip=$_GET['ip'];

if(isset($_GET['ip']) && $_GET['ip']!=null){
        if(filter_var($ip,FILTER_VALIDATE_IP)){
                echo dnsbllookup($ip);
}else{
        echo "Please enter a valid IP";
        }
}

?>

<br>
<hr>
<br>
<p>You can use this check to see whether your IP address is listed within the following RBLs:</p>
<table border="0">
        <tr><td>bl.spamcop.net</td></tr>
        <tr><td>cbl.abuseat.org</td></tr>
        <tr><td>dnsbl.justspam.org</td></tr>
        <tr><td>dnsbl.sorbs.net</td></tr>
        <tr><td>relays.mail-abuse.org</td></tr>
        <tr><td>spam.dnsbl.sorbs.net</td></tr>
        <tr><td>spamguard.leadmon.net</td></tr>
        <tr><td>zen.spamhaus.org</td></tr>
</table>







<?php
echo $cpanel->footer();
$cpanel->end();
