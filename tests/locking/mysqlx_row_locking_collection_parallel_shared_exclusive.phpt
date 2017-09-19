--TEST--
mysqlx collection row locking parallel shared read before exclusive write
--SKIPIF--
--INI--
error_reporting=0
--FILE--
<?php
	require_once(__DIR__."/../connect.inc");
	require_once(__DIR__."/mysqlx_row_locking.inc");

	assert_mysql_xdevapi_loaded();

	$session = mysql_xdevapi\getSession($connection_uri);
	$coll = create_test_collection($session);

	$worker_process = run_worker(__FILE__);
	if (is_resource($worker_process))
	{
		recv_worker_started();

		$session->startTransaction();
		check_find_lock_all($coll, ['1', '2', '3'], [1, 2, 3], $Lock_shared);

		send_let_worker_modify();

		send_let_worker_block();

		$session->commit();

		check_find_lock_all($coll, ['4', '5'], [4, 5], $Lock_shared);
		send_let_worker_commit();
		recv_worker_committed();
		check_find_lock_all($coll, ['1', '2', '3'], [11, 22, 3], $Lock_shared);
		check_find_lock_all($coll, ['4', '5'], [44, 55], $Lock_shared);

		recv_msg_from_worker("ok");
		send_let_worker_end();
	}

	verify_expectations();
	print "done!\n";
?>
--CLEAN--
<?php
	require(__DIR__."/../connect.inc");
	clean_test_db();
?>
--EXPECTF--
worker cmd-line:%s
worker started
let worker modify
let worker block
let worker commit
worker committed
ok
let worker end
done!%A
