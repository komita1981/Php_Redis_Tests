<?php
class Testredis
{

	protected $redis;

	protected $set_iteration = 20;
	protected $set_variable = 'tester_set';
	protected $sortedset_variable = 'tester_sortedset';
	protected $list_variable = 'tester_list';
	protected $hash_variable = 'tester_hash';

	/**
	 * Method setting up properties with given data
	 *
	 * @param array $data
	 *
	 * @return bool
	 */
	public function __construct()
	{
		$this->redis = new Redis();
		$this->redis->connect('127.0.0.1', 6379);
	}

	// Methods for string testing

	function set_basic_strings($iterations = 20000)
	{
		for ($i = 0; $i < $iterations; $i++)
		{
			$this->redis->set($i, $i);
		}
	}

	function set_pipeline_strings($iterations = 20000)
	{
		$multi = $this->redis->multi();
		for ($i = 0; $i < $iterations; $i++)
		{
			$multi->set($i, $i);
		}
		$multi->exec();
	}

	function get_basic_strings($iterations = 20000)
	{
		$result = array();
		for ($i = 0; $i < $iterations; $i++)
		{
			$result[] = $this->redis->get($i);
		}
	}

	function get_pipeline_strings($iterations = 20000)
	{
		$multi = $this->redis->multi();
		for ($i = 0; $i < $iterations; $i++)
		{
			$multi->get($i);
		}
		$result = $multi->exec();
		return $result;
	}

	// Methods for set testing

	function set_basic_sets($iterations = 1000)
	{
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$this->redis->sAdd($this->set_variable.$j, $i);
			}
		}
	}

	function set_pipeline_sets($iterations = 1000)
	{
		$multi = $this->redis->multi();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$multi->sAdd($this->set_variable.$j, $i);
			}
		}
		$multi->exec();
	}

	function get_basic_sets($iterations = 1000)
	{
		$result = array();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$result[$j][] = $this->redis->smembers($this->set_variable.$j);
		}
		return $result;
	}

	function get_pipeline_sets($iterations = 1000)
	{
		$multi = $this->redis->multi();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$multi->smembers($this->set_variable.$j);
		}
		$result = $multi->exec();
		return $result;
	}
	
	// Methods for sorted set testing

	function set_basic_sortedsets($iterations = 1000)
	{
		$time = time();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$this->redis->zAdd($this->sortedset_variable.$j, $time, $i);
			}
		}
	}

	function set_pipeline_sortedsets($iterations = 1000)
	{
		$time = time();
		$multi = $this->redis->multi();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$multi->zAdd($this->sortedset_variable.$j, $time, $i);
			}
		}
		$multi->exec();
	}

	function get_basic_sortedsets($iterations = 1000)
	{	
		$result = array();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$result[$j][] = $this->redis->zrevrange($this->sortedset_variable.$j, 0, -1);
		}
		return $result;
	}

	function get_pipeline_sortedsets($iterations = 1000)
	{
		$multi = $this->redis->multi();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$multi->zrevrange($this->sortedset_variable.$j, 0, -1);
		}
		$result = $multi->exec();
		return $result;
	}

	// Methods for list testing

	function set_basic_lists($iterations = 1000)
	{
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$this->redis->rPush($this->list_variable.$j, $i);
			}
		}
	}

	function set_pipeline_lists($iterations = 1000)
	{
		$multi = $this->redis->multi();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$multi->rPush($this->list_variable.$j, $i);
			}
		}
		$multi->exec();
	}

	function get_basic_lists($iterations = 1000)
	{	
		$result = array();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$result[$j][] = $this->redis->lrange($this->list_variable.$j, 0, -1);
		}
		return $result;
	}

	function get_pipeline_lists($iterations = 1000)
	{
		$multi = $this->redis->multi();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$multi->lrange($this->list_variable.$j, 0, -1);
		}
		$result = $multi->exec();
		return $result;
	}

	// Methods for hash testing

	function set_basic_hashes($iterations = 15000)
	{
		for ($i = 0; $i < $iterations; $i++)
		{
			$this->redis->hMset($this->hash_variable.$i, array('first_name' => 'Iwork', 'second_name' => 'Hardy', 'salary' => $i*1000));
		}
	}

	function set_pipeline_hashes($iterations = 15000)
	{
		$multi = $this->redis->multi();
		for ($i = 0; $i < $iterations; $i++)
		{
			$multi->hMset($this->hash_variable.$i, array('first_name' => 'Iwork', 'second_name' => 'Hardy', 'salary' => $i*1000));
		}
		$multi->exec();
	}

	function get_basic_hashes($iterations = 15000)
	{
		$result = array();
		for ($i = 0; $i < $iterations; $i++)
		{
			$result[] = $this->redis->hGetAll($this->hash_variable.$i);
		}
		return $result;
	}

	function get_pipeline_hashes($iterations = 15000)
	{
		$multi = $this->redis->multi();
		for ($i = 0; $i < $iterations; $i++)
		{
			$multi->hGetAll($this->hash_variable.$i);
		}
		$result = $multi->exec();
		return $result;
	}	
}