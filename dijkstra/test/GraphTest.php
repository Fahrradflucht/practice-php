<?php
use PHPUnit\Framework\TestCase;

require_once "src/Graph.php";

class GraphTest extends TestCase
{
    public function testNewGraph()
    {
        $this->assertInstanceOf(Graph::class, new Graph);
    }
    
    public function testAddNode()
    {
        $graph = new Graph;
        
        $graph->addNode("a");
        
        $this->assertEquals(["a"], $graph->getNodes());
    }
    
    public function testGetNodes()
    {
        $graph = new Graph;
        
        $graph->addNode("a");
        $graph->addNode("b");
        
        $this->assertEquals(["a", "b"], $graph->getNodes());
        $this->assertContains("a", $graph->getNodes());
        $this->assertContains("b", $graph->getNodes());
    }
    
    public function testGetNeighbours()
    {
        $graph = new Graph;
        
        $graph->addNode("a");
        $graph->addNode("b");
        $graph->addNode("c");
        
        $graph->addNeighbour("a", "b", 3);
        $graph->addNeighbour("a", "c", 2);
        
        $this->assertContains("b", $graph->getNeighbours("a"));
        $this->assertContains("c", $graph->getNeighbours("a"));
    }
    
    public function testGetCost()
    {
        $graph = new Graph;
        
        $graph->addNode("a");
        $graph->addNode("b");
        
        $graph->addNeighbour("a", "b", 3);

        $this->assertEquals(3, $graph->getCost("a", "b"));
    }
}
