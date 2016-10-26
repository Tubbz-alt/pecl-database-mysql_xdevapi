--TEST--
xmysqlnd basic collection operations
--SKIPIF--
--INI--
error_reporting=0
--FILE--
<?php
        require_once("connect.inc");

        $nodeSession = mysql_xdevapi\getNodeSession($host, $user, $passwd);

function verify_doc($doc,$name,$job,$age){
    $result = (strpos($doc,$name) != false);
    $result = ($result && (strpos($doc,$job) != false));
    $result = ($result && (strpos($doc,$age) != false));
    return $result;
}

        $nodeSession->createSchema("test_schema");
        $schema = $nodeSession->getSchema("test_schema");

        $schema->createCollection("test_collection");
        $coll = $schema->getCollection("test_collection");

        $coll->add('{"name": "Sakila", "age": 15, "job": "Programmer"}')->execute();
        $coll->add('{"name": "Sakila", "age": 17, "job": "Singer"}')->execute();
        $coll->add('{"name": "Sakila", "age": 18, "job": "Student"}')->execute();
        $coll->add('{"name": "Susanne", "age": 24, "job": "Plumber"}')->execute();
        $coll->add('{"name": "Mike", "age": 39, "job": "Manager"}')->execute();

        $res = $coll->find('name like "Sakila"')->execute();
        $data = $res->fetchAll();

        $test = "0000";
        for($i = 0;$i < count($data);$i++){
            if(verify_doc($data[$i]["doc"],"Sakila","Programmer","15"))
                $test[0] = "1";
            if(verify_doc($data[$i]["doc"],"Sakila","Singer","17"))
                $test[1] = "1";
            if(verify_doc($data[$i]["doc"],"Sakila","Student","18"))
                $test[2] = "1";
        }

        $coll->remove('name like "Sakila"')->execute();
        $res = $coll->find('name like "Sakila"')->execute();
        $data = $res->fetchAll();
        if(is_bool($data) && $data == false)
            $test[3] = "1";

        $nodeSession->dropCollection("test_schema","test_collection");
        $nodeSession->dropSchema("test_schema");

        var_dump($test);
        print "done!\n";
?>
--EXPECTF--
%s(4) "1111"
done!
%a
