<?php
use PHPUnit\Framework\TestCase;

require_once "src/Dijkstra.php";

class DijkstraTest extends TestCase
{
    public function testNewDijkstra()
    {
        $dijkstra = new Dijkstra();

        $this->assertInstanceOf(Dijkstra::class, $dijkstra);
    }
    
    public function testShortestPath()
    {

        $dijkstra = new Dijkstra();
        
        $graph = new Graph();
        
        $graph->addNode("a");
        $graph->addNode("b");
        $graph->addNode("c");
        $graph->addNode("d");

        $graph->addNeighbour("a", "b", 4);
        $graph->addNeighbour("a", "c", 2);
        $graph->addNeighbour("b", "d", 2);
        $graph->addNeighbour("c", "d", 4);
        $graph->addNeighbour("c", "b", 1);
        
        $this->assertEquals
        (
            ["a", "c", "b", "d"],
            $dijkstra->shortestPath($graph, "a", "d")
        );
    }
    
    /**
    * @expectedExceptionMessage No Path!
    */
    public function testThrowsIfNoPath()
    {
        $this->setExpectedException('InvalidArgumentException', 'There is no path from a to d.');

        $dijkstra = new Dijkstra();
        $graph = new Graph();
        
        $graph->addNode("a");
        $graph->addNode("b");
        $graph->addNode("c");
        $graph->addNode("d");

        $graph->addNeighbour("a", "b", 4);
        $graph->addNeighbour("c", "d", 4);
        $dijkstra->shortestPath($graph, "a", "d");
    }
}
