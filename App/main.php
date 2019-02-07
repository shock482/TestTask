<?php
error_reporting(0);
require("Graph.php");
require("Node.php");
require("Dijkstra.php");

if(isset($_POST['my_button']))
{
    $start = $_POST["selectStart"];
    $finish = $_POST["selectFinish"];
}

if($start == $finish){
    echo 'Начальная и конечная точка маршрута совпадают!';
} else {
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

    $jsonerror = 'Неизвестная ошибка';
    switch (json_last_error())
    {
        case JSON_ERROR_NONE:
            $jsonerror = '';
            break;
        case JSON_ERROR_DEPTH:
            $jsonerror = 'Достигнута максимальная глубина стека';
            break;
        case JSON_ERROR_STATE_MISMATCH:
            $jsonerror = 'Некорректные разряды или не совпадение режимов';
            break;
        case JSON_ERROR_CTRL_CHAR:
            $jsonerror = 'Некорректный управляющий символ';
            break;
        case JSON_ERROR_SYNTAX:
            $jsonerror = 'Синтаксическая ошибка, не корректный JSON';
            break;
        case JSON_ERROR_UTF8:
            $jsonerror = 'Некорректные символы UTF-8, возможно неверная кодировка';
            break;
        default:
            $jsonerror = 'Неизвестная ошибка';
            break;
    }
    if ($jsonerror != '')
    {
        echo $jsonerror;
    } else {
        printShortestPath($start, $finish, $data);
    }
    echo('<br>');
}