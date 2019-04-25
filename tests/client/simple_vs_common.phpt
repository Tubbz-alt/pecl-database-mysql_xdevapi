--TEST--
mysqlx get one session from client, then check common session
--SKIPIF--
--INI--
error_reporting=E_ALL
default_socket_timeout=4
--FILE--
<?php
require_once(__DIR__."/../connect.inc");
require_once(__DIR__."/client_utils.inc");

$pooling_options = '{
	"enabled": true,
  	"maxSize": 10,
  	"maxIdleTime": 3600,
  	"queueTimeOut": 1000
}';

$client = mysql_xdevapi\getClient($connection_uri, $pooling_options);
$session = $client->getSession();
create_test_db($session);
assert_session_valid($session);

$common_session = mysql_xdevapi\getSession($connection_uri);
assert_session_valid($common_session);

verify_expectations();
print "done!\n";
?>
--CLEAN--
<?php
	require_once(__DIR__."/../connect.inc");
	clean_test_db();
?>
--EXPECTF--
done!%A
