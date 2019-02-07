<?php

interface NodeInterface {
    public function connect(NodeInterface $node, $distance = 1);

    public function getConnections();

    public function getId();

    public function getPotential();

    public function getPotentialFrom();

    public function isPassed();

    public function markPassed();

    public function setPotential($potential, NodeInterface $from);
}
