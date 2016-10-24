<?php

class Graph
{
    private $nodes;
    
    public function addNode($name)
    {
        $this->nodes[$name] = [];
    }
    
    public function getNodes()
    {
        return array_keys($this->nodes);
    }
    
    public function getNeighbours($name)
    {
        return array_keys($this->nodes[$name]);
    }
    
    public function addNeighbour($node, $name, $cost)
    {
        $this->nodes[$node][$name] = $cost;
    }
    
    public function getCost($node, $neighbour)
    {
        return $this->nodes[$node][$neighbour];
    }
}
