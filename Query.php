<?php

namespace AlfredBez\XmlQuery;

class Query
{
    protected $path;
    protected $nodeName = false;
    protected $wheres = [];
    protected $attribute = false;
    protected $results = [];
    protected $raw = false;
    protected $debug = false;

    public function path($path)
    {
        $this->path = $path;

        return $this;
    }
    public function whereAttribute($name, $value)
    {
        $this->wheres[] = [$name, $value];

        return $this;
    }
    public function getRaw()
    {
        $this->raw = true;

        return $this->get();
    }
    public function attribute($attribute)
    {
        $this->attribute = $attribute;

        return $this;
    }
    public function nodeName($nodeName)
    {
        $this->nodeName = $nodeName;

        return $this;
    }

    protected function clear()
    {
        $this->path = false;
        $this->nodeName = false;
        $this->wheres = [];
        $this->attribute = false;
        $this->results = [];
        $this->raw = false;
    }

    protected function getResults()
    {
        if ($this->nodeName) {
            foreach ($this->path->children() as $key => $value) {
                if ($key === $this->nodeName) {
                    $this->results[] = $value;
                }
            }
        } else {
            $this->results[] = $this->path;
        }
    }

    protected function enableDebug()
    {
        $this->debug = true;
    }
    protected function isDebug()
    {
        return $this->debug;
    }

    protected function filterWhere()
    {
        for ($i = 0, $count = count($this->results); $i < $count; $i++) {
            $result = $this->results[$i];
            $attributes = (array) $result;
            $unsetCurrent = true;
            foreach ($this->wheres as list($whereName, $whereValue)) {
                if (in_array($whereName, array_keys($attributes['@attributes']))) {
                    if ($attributes['@attributes'][$whereName] === $whereValue) {
                        $unsetCurrent = false;
                    }
                } else {
                    $unsetCurrent = false;
                }
            }
            if ($unsetCurrent) {
                unset($this->results[$i]);
            }
        }
        $this->results = array_values($this->results);
    }

    public function get()
    {
        $this->getResults();
        if (count($this->wheres) > 0) {
            $this->filterWhere();
        }
        if ($this->raw) {
            $return = $this->results;
        } else {
            $return = (string) $this->results[0];
        }
        $this->clear();

        return $return;
    }

    public function getAttribute()
    {
        if ($this->path->count() === 0) {
            return false;
        }
        $attributes = (array) $this->path->attributes();

        $trueValues = ['true', 'JA'];

        foreach ($attributes['@attributes'] as $key => $value) {
            if (!in_array($value, $trueValues)) {
                unset($attributes['@attributes'][$key]);
            }
        }
        $this->clear();

        return reset(array_keys($attributes['@attributes']));
    }

    public function getAttributes()
    {
        $attributes = [];

        foreach ($this->path->attributes() as $attribute => $value) {
            $value = (string) $value;
            if ($value === 'true') {
                $attributes[] = $attribute;
            }
        }
        $this->clear();

        return implode(',', $attributes);
    }
}
