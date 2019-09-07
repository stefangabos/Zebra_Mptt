<?php

namespace ZebraTests\Mptt;
/**
 * Created by PhpStorm.
 * User: writ3it
 * Date: 06.09.19
 * Time: 21:35
 */

use PHPUnit\Framework\TestCase;
use ZebraTests\Mptt\Utility\Environment;
use ZebraTests\Mptt\Utility\InMemoryDriver;

class Zebra_Mptt_Test extends TestCase
{
    /**
     * @var InMemoryDriver
     */
    private $db;

    public function setUp(): void
    {
        parent::setUp();
        $this->db = new InMemoryDriver();
        $this->db->query(Environment::getInstallFileContent());
    }

    public function test_addNode()
    {
        $zebra = new \Zebra_Mptt($this->db);

        $before = $this->countRows();
        $nodeId = $zebra->add(0, "root");
        $after = $this->countRows();

        $this->assertEquals(1, $after - $before);

        $node = $this->getRow($nodeId);
        $this->assertEquals('root', $node['title']);
    }

    private function countRows(): int
    {
        return (int)$this->db->query("SELECT count(*) FROM mptt")->fetchAssoc()[0];
    }

    private function getRow(int $id): array
    {
        return $this->db->query("SELECT * FROM mptt WHERE id={$id}")->fetchAssoc();
    }

    public function test_getDescendants()
    {
        $zebra = new \Zebra_Mptt($this->db);

        $parentId = $zebra->add(0, "root");
        $aId = $zebra->add($parentId, "A");
        $aaId = $zebra->add($aId, "AA");
        $bId = $zebra->add($parentId, "B");
        $bbId = $zebra->add($bId, "BB");

        $expected = [(int)$aId, (int)$bId];

        $children = $zebra->get_descendants($parentId);

        $this->assertEquals($expected, $this->getFieldAsArray($children, 'id'));
    }

    private function getFieldAsArray(array $children, $property)
    {
        return array_values(array_map(function ($item) use ($property) {
            return intval($item[$property]);
        }, $children));
    }

    public function test_getDescendantsCount()
    {
        $zebra = new \Zebra_Mptt($this->db);

        $parentId = $zebra->add(0, "root");
        $aId = $zebra->add($parentId, "A");
        $aaId = $zebra->add($aId, "AA");
        $bId = $zebra->add($parentId, "B");
        $bbId = $zebra->add($bId, "BB");

        $expected = 2;

        $count = $zebra->get_descendant_count($parentId);

        $this->assertEquals($expected, $count);
    }

    public function test_copy()
    {
        $zebra = new \Zebra_Mptt($this->db);

        $A = $zebra->add(0, "rootA");
        $B = $zebra->add(0, "rootB");

        $C = $zebra->add($A, "toCopy");
        $E = $zebra->add($C, "someChild");

        $D = $zebra->copy($C, $B);

        $this->assertEquals(1, $zebra->get_descendant_count($A));
        $this->assertEquals(1, $zebra->get_descendant_count($B));
        $this->assertEquals(1, $zebra->get_descendant_count($C));
        $this->assertEquals(1, $zebra->get_descendant_count($D));
    }

    public function test_move()
    {
        $zebra = new \Zebra_Mptt($this->db);

        $A = $zebra->add(0, "rootA");
        $B = $zebra->add(0, "rootB");

        $C = $zebra->add($A, "toCopy");
        $E = $zebra->add($C, "someChild");

        $D = $zebra->move($C, $B);

        $this->assertEquals(0, $zebra->get_descendant_count($A));
        $this->assertEquals(1, $zebra->get_descendant_count($B));
        $this->assertEquals(1, $zebra->get_descendant_count($C));
    }

    public function test_deleteOnce()
    {
        $zebra = new \Zebra_Mptt($this->db);

        $A = $zebra->add(0, "A");
        $B = $zebra->add($A, "B");

        $before = $this->countRows();
        $this->assertGreaterThanOrEqual(2, $before);

        $this->assertEquals(true, $zebra->delete($B));
        $after = $this->countRows();

        $this->assertEquals(true, $zebra->delete($A));
        $again = $this->countRows();

        $this->assertEquals(1, $before - $after);
        $this->assertEquals(1, $after - $again);
    }

    public function test_deleteSubtree()
    {
        $zebra = new \Zebra_Mptt($this->db);

        $A = $zebra->add(0, "A");
        $B = $zebra->add($A, "B");

        $before = $this->countRows();
        $this->assertGreaterThanOrEqual(2, $before);

        $this->assertEquals(true, $zebra->delete($A));
        $after = $this->countRows();

        $this->assertEquals(2, $before - $after);
    }

    public function test_nextSibling()
    {
        $zebra = new \Zebra_Mptt($this->db);

        $A = $zebra->add(0, "A");
        $B = $zebra->add($A, "B");
        $C = $zebra->add($A, "C");
        $D = $zebra->add($A, "D");

        $this->assertEquals(false, $zebra->get_next_sibling($A));
        $this->assertEquals($C, $zebra->get_next_sibling($B)['id']);
        $this->assertEquals($D, $zebra->get_next_sibling($C)['id']);
    }

    public function test_previousSibling()
    {
        $zebra = new \Zebra_Mptt($this->db);

        $A = $zebra->add(0, "A");
        $B = $zebra->add($A, "B");
        $C = $zebra->add($A, "C");
        $D = $zebra->add($A, "D");

        $this->assertEquals(false, $zebra->get_previous_sibling($A));
        $this->assertEquals($B, $zebra->get_previous_sibling($C)['id']);
        $this->assertEquals($C, $zebra->get_previous_sibling($D)['id']);
    }

    public function test_Siblings()
    {
        $zebra = new \Zebra_Mptt($this->db);

        $A = $zebra->add(0, "A");
        $B = $zebra->add($A, "B");
        $C = $zebra->add($A, "C");
        $D = $zebra->add($A, "D");

        $this->assertEquals(2, count($zebra->get_siblings($B)));
        $this->assertEquals(3, count($zebra->get_siblings($B, true)));
    }

    public function test_getParent()
    {
        $zebra = new \Zebra_Mptt($this->db);

        $A = $zebra->add(0, "A");
        $B = $zebra->add($A, "B");


        $this->assertEquals($A, $zebra->get_parent($B)['id']);
        $this->assertEquals(false, $zebra->get_parent($A));
    }

    public function test_getPath()
    {
        $zebra = new \Zebra_Mptt($this->db);

        $A = $zebra->add(0, "A");
        $B = $zebra->add($A, "B");
        $C = $zebra->add($B, "C");
        $D = $zebra->add($B, "D");

        $expected = [$A, $B, $D];


        $this->assertEquals($expected, $this->getFieldAsArray($zebra->get_path($D), 'id'));
    }

    public function test_update()
    {
        $zebra = new \Zebra_Mptt($this->db);

        $A = $zebra->add(0, "A");
        $B = $zebra->add($A, "B");

        $zebra->update($B,'test');

        $this->assertEquals('test', $this->getRow($B)['title']);
        $this->assertEquals('A', $this->getRow($A)['title']);
    }

    public function test_getTree()
    {
        $zebra = new \Zebra_Mptt($this->db);

        $A = (int)$zebra->add(0, "A");
        $B = (int)$zebra->add($A, "B");
        $C = (int)$zebra->add($A, "C");
        $D = (int)$zebra->add($B, "D");


        $tree = $zebra->get_tree($A);
        $this->assertEquals(2, count($tree));
        $this->assertEquals(true, array_key_exists($B,$tree));
        $this->assertEquals(true, array_key_exists($C,$tree));
        $subtree = $tree[$B]['children'];
        $this->assertEquals(1, count($subtree));
        $this->assertEquals(true, array_key_exists($D,$subtree));

    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->db->close();
    }

    private function getTree()
    {

    }

}