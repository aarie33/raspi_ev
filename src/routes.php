<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

// $db=mysqli_connect('localhost','u6566546_test','testpass','u6566546_test');
date_default_timezone_set('Asia/Jakarta');

return function (App $app) {
    $container = $app->getContainer();

    // $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
    //     // Sample log message
    //     $container->get('logger')->info("Slim-Skeleton '/' route");

    //     // Render index view
    //     return $container->get('renderer')->render($response, 'index.phtml', $args);
    // });
    $app->get('/getstatus', function (Request $request, Response $response, $args){
        $sql = "SELECT * FROM raspi_evacuate";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });
    $app->get('/updatestatus/{id}/{status}', function (Request $request, Response $response, $args){
    	$id = $args["id"];
    	$status = $args["status"];
    	$updated = date('Y-m-d H:i:s');
        $sql = "UPDATE raspi_evacuate SET status='$status', updated='$updated' WHERE id='$id'";
        $stmt = $this->db->prepare($sql);
        $fields = array(':id'=>$id,
        	':status'=>$status,
	        ':updated'=>$updated);
        $stmt->execute($fields);
        $sts = 0;
        if($stmt->execute($fields))
        	$sts = 1;
        return $response->withJson(["status" => "success", "data" => $sts], 200);
    });
};
