<?php

use AlfredBez\XmlQuery\Query;

class QueryTest extends PHPUnit_Framework_TestCase
{
    protected $dummyData;
    protected function setUp()
    {
        /*
        $xmlData = file_get_contents('dummy.xml');
        $xml = simplexml_load_string($xmlData, 'SimpleXMLElement', LIBXML_NOCDATA);
        $this->xmlData = $xml;
        $this->dummyData = $this->xmlData->some->path;
        */
    }
    public function testGetSimpleAttribute()
    {
        $query = new Query();
        // $this->assertEquals('someValue', $query->path($this->dummyData->sub->path)->getAttribute());
    }
    public function testDontGetFalseAttribute()
    {
        $query = new Query();
        // $this->assertEquals('', $query->path($this->dummyData->sub->path)->getAttribute());
    }
    public function testGetAttributeWithPositiveValue()
    {
        $query = new Query();
        // $this->assertEquals('someAttribute', $query->path($this->dummyData->sub->path)->getAttribute());
    }
    public function testGetAttributes()
    {
        $query = new Query();
        // $this->assertEquals('attribute', $query->path($this->dummyData->sub->path)->getAttributes());
    }
    public function testGetValueWhereSpecificAttribute()
    {
        /*
        $query = new Query();
        $res = $query
                ->path($this->dummyData->sub)
                ->nodeName('path')
                ->whereAttribute('color', 'red')
                ->get();
        $this->assertEquals(
            'true',
            $res
        );
        */
    }
    public function testGetMultipleElements()
    {
        /*
        $query = new Query();
        $res = $query
                ->path($this->dummyData->parentElement)
                ->nodeName('childElement')
                ->whereAttribute('type', 'someType')
                ->getRaw();

        $arr = (array) $res;
        $this->assertEquals(8, count($arr));

        $expectedData = ['a','b','c'];
        foreach ($arr as $dataset) {
            $someValue = (string) $dataset->someValue;
            $this->assertContains($someValue, $expectedData);
        }
        */
    }
}
