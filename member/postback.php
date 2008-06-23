<?PHP
//post back program
error_reporting(E_ALL);
require_once('../phpinclude/classStats.inc.php');
/*
2004-05-03 09:19:51
Array
(
    [session_id] => 8704000924839629335
    [password] => engine63
    [x_price] => 3
    [ipaddress] => 67.86.79.31
    [address] => null
    [username] => nbshadow
    [state] => null
    [payment_type] => CC
    [x_hitsid] => 20040503_1526
    [pi_code] => iasm27t1
    [phone] => null
    [amount] => 1.00
    [x_pkg] => 1
    [co_code] => m27
    [x_SID] => 22
    [x_customer_id] => 355088
    [product_id] => iasm27t1
    [site] => 4PENT1
    [age] => Y
    [ans] => Y060735YM ,2623059,APPROVED|77855529
    [email] => nb_jossem@hotmail.com
    [country] => 840
    [city] => null
    [order_id] => 77855529
    [transaction_id] => 112925963
    [zip] => 06854
    [x_session_id] => 345415
    [user1] => null
    [submit_count] => 1
    [name] => Nicholas Jossem
)
*/
 ob_start();
print date("Y-m-d H:i:s") . "\n";
print_r($this->form);
$stuff = ob_get_contents();
ob_end_clean();

$fp = fopen("/tmp/signup.log", "a");
fputs($fp, $stuff);
fclose($fp);


$stats = new Stats();
$sale_id = $stats->addSale();

//add member	
$db = $stats->db;

$res = $db->query("insert into members (username, password, email, exp_date, status, siteid, ip_address, sale_id) values (?,?,?,date_add(now(), interval 1 month), 'ACTIVE', ?,?,?)", array($_REQUEST['username'], $_REQUEST['password'], $_REQUEST['email'], $_REQUEST['x_sid'], $_REQUEST['ipaddress'], $sale_id));

?>