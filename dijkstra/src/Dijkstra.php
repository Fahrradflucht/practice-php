<?php

class Dijkstra
{
    private $distanceStore;
    private $unevaluated;

    public function shortestPath($graph, $start, $dest)
    {
        $this->populateDistanceStore($graph->getNodes());
        
        $this->distanceStore[$start]["distance"] = 0;
        
        $this->setUnevaluated($start);
        
        while (!empty($this->unevaluated)) {
            $currentNode = $this->getUnevaluatedNodeWithShortestDistance();
            
            $this->setEvaluated($currentNode);

            foreach ($graph->getNeighbours($currentNode) as $neighbour) {
                $currentNodesDistance = $this->distanceStore[$currentNode]["distance"];
                $cost = $graph->getCost($currentNode, $neighbour);
                
                $newDistance = $currentNodesDistance + $cost;
                
                $neighbourDistance = $this->distanceStore[$neighbour]["distance"];
                
                if ($neighbourDistance == NULL) {
                    $this->unevaluated[] = $neighbour;
                    $this->distanceStore[$neighbour] =
                    [
                        "distance" => $newDistance,
                        "origin" => $currentNode
                    ];
                    
                } else {
                    if ($this->isUnevaluated($neighbour) && $neighbourDistance > $newDistance) {
                        $this->distanceStore[$neighbour] =
                        [
                            "distance" => $newDistance,
                            "origin" => $currentNode
                        ];
                    }
                }
            }
        }
        
        $path = [$dest];
        $node = $dest;
        while ($node != $start && $this->distanceStore[$node]["origin"] != NULL) {
            $path = array_merge([$this->distanceStore[$node]["origin"]], $path);
            $node = $this->distanceStore[$node]["origin"];
        }
        
        return $path;
    }
    
    private function setUnevaluated($node)
    {
        $this->unevaluated[] = $node;
    }
    
    private function setEvaluated($node)
    {
        $this->unevaluated = array_diff($this->unevaluated, [$node]);
    }
    
    private function populateDistanceStore($nodes)
    {
        foreach ($nodes as $node) {
            $this->distanceStore[$node] =
            [
                "origin" => NULL,
                "distance" => NULL
            ];
        }
        
    }
    
    private function getUnevaluatedNodeWithShortestDistance()
    {
        $nodeWithShortestDistance = NULL;
        $shortestDistance = NULL;
        
        foreach ($this->unevaluated as $node) {
            $nodeDistance = $this->distanceStore[$node]["distance"];
            
            if ($shortestDistance == NULL || $nodeDistance < $shortestDistance) {
                $nodeWithShortestDistance = $node;
                $shortestDistance = $nodeDistance;
            }
        }
        
        return $nodeWithShortestDistance;
    }
    
    private function isUnevaluated($node)
    {
        return in_array($node, $this->unevaluated);
    }
}