<?php

class Dijkstra {
    protected $startingNode;
    protected $endingNode;
    protected $graph;
    protected $paths = array();
    protected $solution = false;

    public function __construct(Graph $graph) {
        $this->graph = $graph;
    }

    public function getDistance() {
        if (! $this->isSolved()) {
            throw new Exception("Cannot calculate the distance of a non-solved algorithm:\nDid you forget to call ->solve()?");
        }
        return $this->getEndingNode()->getPotential();
    }

    public function getEndingNode() {
        return $this->endingNode;
    }

    public function getLiteralShortestPath() {
        $path = $this->solve();
        $literal = '';
        foreach ( $path as $p ) {
            $literal .= "{$p->getId()} - ";
        }
        return substr($literal, 0, count($literal) - 4);
    }

    public function getShortestPath() {
        $path = array();
        $node = $this->getEndingNode();
        while ( $node->getId() != $this->getStartingNode()->getId() ) {
            $path[] = $node;
            $node = $node->getPotentialFrom();
        }
        $path[] = $this->getStartingNode();
        return array_reverse($path);
    }

    public function getStartingNode() {
        return $this->startingNode;
    }

    public function setEndingNode(Node $node) {
        $this->endingNode = $node;
    }

    public function setStartingNode(Node $node) {
        $this->paths[] = array($node);
        $this->startingNode = $node;
    }

    public function solve() {
        if (! $this->getStartingNode() || ! $this->getEndingNode()) {
            throw new Exception("Cannot solve the algorithm without both starting and ending nodes");
        }
        $this->calculatePotentials($this->getStartingNode());
        $this->solution = $this->getShortestPath();
        return $this->solution;
    }

    protected function calculatePotentials(Node $node) {
        $connections = $node->getConnections();
        $sorted = array_flip($connections);
        krsort($sorted);
        foreach ( $connections as $id => $distance ) {
            $v = $this->getGraph()->getNode($id);
            $v->setPotential($node->getPotential() + $distance, $node);
            foreach ( $this->getPaths() as $path ) {
                $count = count($path);
                if ($path[$count - 1]->getId() === $node->getId()) {
                    $this->paths[] = array_merge($path, array($v));
                }
            }
        }
        $node->markPassed();
        // Get loop through the current node's nearest connections
        // to calculate their potentials.
        foreach ( $sorted as $id ) {
            $node = $this->getGraph()->getNode($id);
            if (! $node->isPassed()) {
                $this->calculatePotentials($node);
            }
        }
    }

    protected function getGraph() {
        return $this->graph;
    }

    protected function getPaths() {
        return $this->paths;
    }

    protected function isSolved() {
        return ( bool ) $this->solution;
    }
}