<?php

require_once("Interface/GraphInterface.php");

class Graph implements GraphInterface {

    protected $nodes = array();

    public function add(NodeInterface $node) {
        if (array_key_exists($node->getId(), $this->getNodes())) {
            throw new Exception('Unable to insert multiple Nodes with the same ID in a Graph');
        }
        $this->nodes[$node->getId()] = $node;
        return $this;
    }

    public function getNode($id) {
        $nodes = $this->getNodes();
        if (! array_key_exists($id, $nodes)) {
            throw new Exception("Unable to find $id in the Graph");
        }
        return $nodes[$id];
    }

    public function getNodes() {
        return $this->nodes;
    }
}