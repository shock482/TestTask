<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
</head>
<body>

<?php
error_reporting(0);
require("Graph.php");
require("Node.php");
require("Dijkstra.php");

    function printShortestPath($from_name, $to_name, $routes)
    {
        $graph = new Graph();
        foreach ($routes as $route) {
            $from = $route['from'];
            $to = $route['to'];
            $price = $route['price'];
            if (!array_key_exists($from, $graph->getNodes())) {
                $from_node = new Node($from);
                $graph->add($from_node);
            } else {
                $from_node = $graph->getNode($from);
            }
            if (!array_key_exists($to, $graph->getNodes())) {
                $to_node = new Node($to);
                $graph->add($to_node);
            } else {
                $to_node = $graph->getNode($to);
            }
            $from_node->connect($to_node, $price);
        }

        $g = new Dijkstra($graph);
        $start_node = $graph->getNode($from_name);
        $end_node = $graph->getNode($to_name);
        $g->setStartingNode($start_node);
        $g->setEndingNode($end_node);
        echo "From: " . $start_node->getId() . "<br>";
        echo "To: " . $end_node->getId() . "<br>";
        echo "Route: " . $g->getLiteralShortestPath() . "<br>";
        echo "Total: " . $g->getDistance() . "<br>";
    }

$buffer = file_get_contents("data.json");
$data = json_decode($buffer, True);
//print_r($data);

//$routes = array();
//$routes[] = array('from' => 'a', 'to' => 'b', 'price' => 100);
//$routes[] = array('from' => 'c', 'to' => 'd', 'price' => 300);
//$routes[] = array('from' => 'b', 'to' => 'c', 'price' => 200);
//$routes[] = array('from' => 'a', 'to' => 'd', 'price' => 900);
//$routes[] = array('from' => 'b', 'to' => 'd', 'price' => 300);

printShortestPath('a', 'd', $data);
echo('<br>');

//print_r($routes);
echo '<pre>';
//var_dump($routes);
//print_r($routes);
echo '<pre>';
echo('<br>');

//$json = json_encode($routes);
//echo '<pre>';
//print_r($json);
//echo '<pre>';
//echo('<br>');

//$buffer = file_get_contents("data.json");
//$data = json_decode($buffer, True);
////$data = json_decode(json_encode($buffer), True);
//print_r($data);

?>

<h1>TEST</h1>
<p><?
//    printShortestPath('a', 'd', $routes);
?></p>
</body>
</html>