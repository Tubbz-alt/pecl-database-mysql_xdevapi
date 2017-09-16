--TEST--
mysqlx table row locking parallel exclusive write before exclusive write
--SKIPIF--
--INI--
error_reporting=0
--FILE--
<?php
	require_once(__DIR__."/../connect.inc");
	require_once(__DIR__."/mysqlx_row_locking.inc");

	assert_mysql_xdevapi_loaded();

	$session = mysql_xdevapi\getSession($connection_uri);
	$tab = createTestTable($session);

	$worker_process = run_worker(__FILE__);
	if (is_resource($worker_process))
	{
		recv_worker_started();

		$session->startTransaction();
		check_select_lock_all($tab, ['1', '2'], [1, 2], $Lock_exclusive);
		update_row($tab, '1', 11);
		update_row($tab, '2', 22);
		check_select_lock_all($tab, ['1', '2'], [11, 22], $Lock_exclusive);

		send_let_worker_modify();

		$session->commit(); // worker should unblock now

		check_select_lock_one($tab, '1', 11, $Lock_exclusive);
		check_select_lock_one($tab, '2', 22, $Lock_exclusive);

		send_let_worker_commit();
		recv_worker_committed();

		check_select_lock_one($tab, '1', 111, $Lock_exclusive);
		check_select_lock_one($tab, '2', 222, $Lock_exclusive);
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
let worker commit
worker committed
done!%A