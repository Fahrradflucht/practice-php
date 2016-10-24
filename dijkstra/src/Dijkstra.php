<?php

class Dijkstra
{
    private $distanceStore;
    private $unevaluated;

    public function shortestPath($graph, $start, $dest)
    {
        $this->populateDistanceStore($graph->getNodes());
        $this->calculateDistances($graph, $start);
        
        if ($this->getOrigin($dest) == NULL) {
            $msg = 'There is no path from '.$start.' to '.$dest.'.';
            throw new InvalidArgumentException($msg);
        }
        
        return $this->getPathFromCalculatedOrigins($start, $dest);
    }
    
    private function calculateDistances($graph, $start)
    {
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
                    $this->setUnevaluated($neighbour);
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
    }
    
    private function getPathFromCalculatedOrigins($start, $dest)
    {
        $path = [$dest];
        $node = $dest;
        while ($node != $start) {
            $path = array_merge([$this->getOrigin($node)], $path);
            $node = $this->getOrigin($node);
        }
        return $path;
    }
    
    private function setUnevaluated($node)
    {
        $this->unevaluated[] = $node;
    }
    
    private function isUnevaluated($node)
    {
        return in_array($node, $this->unevaluated);
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
        return array_reduce
        (
            $this->unevaluated,
            function($shortest, $current)
            {
                if($shortest == NULL
                || $this->getDistance($current) < $this->getDistance($shortest))
                {
                    return $current;
                }
                return $shortest;
            }
        );
    }
    
    private function getDistance($node)
    {
        return $this->distanceStore[$node]["distance"];
    }
    
    private function getOrigin($node)
    {
        return $this->distanceStore[$node]["origin"];
    }
}