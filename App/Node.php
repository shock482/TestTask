<?php

require_once("Interface/NodeInterface.php");

class Node implements NodeInterface {
    protected $id;
    protected $potential;
    protected $potentialFrom;
    protected $connections = array();
    protected $passed = false;

    public function __construct($id) {
        $this->id = $id;
    }

    public function connect(NodeInterface $node, $distance = 1) {
        $this->connections[$node->getId()] = $distance;
    }

    public function getDistance(NodeInterface $node) {
        return $this->connections[$node->getId()];
    }

    public function getConnections() {
        return $this->connections;
    }

    public function getId() {
        return $this->id;
    }

    public function getPotential() {
        return $this->potential;
    }

    public function getPotentialFrom() {
        return $this->potentialFrom;
    }

    public function isPassed() {
        return $this->passed;
    }

    public function markPassed() {
        $this->passed = true;
    }

    public function setPotential($potential, NodeInterface $from) {
        $potential = ( int ) $potential;
        if (! $this->getPotential() || $potential < $this->getPotential()) {
            $this->potential = $potential;
            $this->potentialFrom = $from;
            return true;
        }
        return false;
    }
}