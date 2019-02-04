<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.02.2019
 * Time: 20:13
 */
interface GraphInterface {

    public function add(NodeInterface $node);

    public function getNode($id);

    public function getNodes();

}