<?php
require 'rediska/library/Rediska.php';

class Testredis
{

	protected $redis;
	protected $set_iteration = 20;
	protected $set_variable = 'tester_set';
	protected $sortedset_variable = 'tester_sortedset';
	protected $list_variable = 'tester_list';
	protected $hash_variable = 'tester_hash';

	public function __construct()
	{
		$this->redis = new Rediska();
	}

	// Methods for string testing

	function set_basic_strings($iterations = 20000)
	{
		for ($i = 0; $i < $iterations; $i++)
		{
			$key = new Rediska_Key($i);
			$key->setValue($i);
		}
	}

	function set_pipeline_strings($iterations = 20000)
	{
		$pipe = $this->redis->pipeline();
		for ($i = 0; $i < $iterations; $i++)
		{
			$pipe->set($i, $i);
		}
		$pipe->execute();
	}

	function get_basic_strings($iterations = 20000)
	{
		$result = array();
		for ($i = 0; $i < $iterations; $i++)
		{
			$key = new Rediska_Key($i);
			$result[] = $key->getValue();
		}
	}

	function get_pipeline_strings($iterations = 20000)
	{
		$pipe = $this->redis->pipeline();
		for ($i = 0; $i < $iterations; $i++)
		{
			$pipe->get($i);
		}
		return $result = $pipe->execute();
	}

	// Methods for set testing

	function set_basic_sets($iterations = 1000)
	{
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$set = new Rediska_Key_Set($this->set_variable.$j);
			for ($i = 0; $i < $iterations; $i++)
			{
				$set[] = $i;
			}
		}
	}

	function set_pipeline_sets($iterations = 1000)
	{
		$pipe = $this->redis->pipeline();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$pipe->addToSet($this->set_variable.$j, $i);
			}
		}
		$pipe->execute();
	}

	function get_basic_sets($iterations = 1000)
	{
		$result = array();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$set = new Rediska_Key_Set($this->set_variable.$j);
			$result[$j] = $set->getValues();
		}
		return $result;
	}

	function get_pipeline_sets($iterations = 1000)
	{
		$pipe = $this->redis->pipeline();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$pipe->getSet($this->set_variable.$j);
		}
		return $result = $pipe->execute();
	}

	// Methods for sortedset testing

	function set_basic_sortedsets($iterations = 1000)
	{
		$time = time();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$zset = new Rediska_Key_SortedSet($this->sortedset_variable.$j);
			for ($i = 0; $i < $iterations; $i++)
			{
				$zset->add($i, $time);
			}
		}
	}

	function set_pipeline_sortedsets($iterations = 1000)
	{
		$time = time();
		$pipe = $this->redis->pipeline();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$pipe->addToSortedSet($this->sortedset_variable.$j, $i, $time);
			}
		}
		$pipe->execute();
	}

	function get_basic_sortedsets($iterations = 1000)
	{
		$result = array();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$set = new Rediska_Key_SortedSet($this->sortedset_variable.$j);
			$result[$j] = $set->getByRank();
		}
		return $result;
	}

	function get_pipeline_sortedsets($iterations = 1000)
	{
		$pipe = $this->redis->pipeline();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$pipe->getSortedSet($this->sortedset_variable.$j);
		}
		return $result = $pipe->execute();
	}

	// Methods for list testing

	function set_basic_lists($iterations = 1000)
	{
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$list = new Rediska_Key_List($this->list_variable.$j);
			for ($i = 0; $i < $iterations; $i++)
			{
				$list[] = $i;
			}
		}
	}

	function set_pipeline_lists($iterations = 1000)
	{
		$pipe = $this->redis->pipeline();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$pipe->AppendToList($this->list_variable.$j, $i);
			}
		}
		$pipe->execute();
	}

	function get_basic_lists($iterations = 1000)
	{
		$result = array();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$list = new Rediska_Key_List($this->list_variable.$j);
			$result[$j] = $list->getValues();
		}
		return $result;
	}

	function get_pipeline_lists($iterations = 1000)
	{
		$pipe = $this->redis->pipeline();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$pipe->getList($this->list_variable.$j);
		}
		return $result = $pipe->execute();
	}

	// Methods for hash testing

	function set_basic_hashes($iterations = 15000)
	{
		for ($i = 0; $i < $iterations; $i++)
		{
			$hash = new Rediska_Key_Hash($this->hash_variable.$i);
			$hash->first_name = 'Iwork';
			$hash->second_name = 'Hardy';
			$hash->salary = $i*1000;
		}
	}

	function set_pipeline_hashes($iterations = 15000)
	{
		$pipe = $this->redis->pipeline();
		for ($i = 0; $i < $iterations; $i++)
		{
			$pipe->setToHash($this->hash_variable.$i, array('first_name' => 'Iwork', 'second_name' => 'Hardy', 'salary' => $i*1000));
		}
		$pipe->execute();
	}

	function get_basic_hashes($iterations = 15000)
	{
		$result = array();
		for ($i = 0; $i < $iterations; $i++)
		{
			$hash = new Rediska_Key_Hash($this->hash_variable.$i);
			$result[] = $hash->getValues();
		}
		return $result;
	}

	function get_pipeline_hashes($iterations = 15000)
	{
		$pipe = $this->redis->pipeline();
		for ($i = 0; $i < $iterations; $i++)
		{
			$pipe->getHash($this->hash_variable.$i);
		}
		return $result = $pipe->execute();
	}
}
?>

