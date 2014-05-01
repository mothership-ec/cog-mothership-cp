<?php

namespace Message\Mothership\ControlPanel\Statistic;

class Collection implements \IteratorAggregate, \Countable
{
	protected $_items = array();

	public function addDatasets(array $datasets)
	{
		foreach ($datasets as $dataset) {
			$this->add($dataset);
		}
	}

	/** TEMP **/
	public function __construct(array $items = array())
	{
		foreach ($items as $item) {
			$this->add($item);
		}
	}

	public function add(Dataset $item)
	{
		if ($this->exists($item->getName())) {
			throw new \InvalidArgumentException(sprintf(
				'Dataset `%s` is already defined',
				$item->getName()
			));
		}

		$this->_items[$item->getName()] = $item;

		return $this;
	}

	public function get($name)
	{
		if (!$this->exists($name)) {
			throw new \InvalidArgumentException(sprintf('Dataset `%s` not set on collection', $name));
		}

		return $this->_items[$name];
	}

	public function all()
	{
		return $this->_items;
	}

	public function exists($name)
	{
		return array_key_exists($name, $this->_items);
	}

	public function count()
	{
		return count($this->_items);
	}

	public function getIterator()
	{
		return new \ArrayIterator($this->_items);
	}
}