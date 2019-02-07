<?php

interface GraphInterface {

    public function add(NodeInterface $node);

    public function getNode($id);

    public function getNodes();

}