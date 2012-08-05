<?php
require_once 'redisent/src/redisent/Redis.php';

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
		$this->redis = new redisent\Redis('redis://localhost');
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
		$pipe = $this->redis->pipeline();
		for ($i = 0; $i < $iterations; $i++)
		{
			$pipe->set($i, $i);
		}
		$pipe->uncork();
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
		$pipe = $this->redis->pipeline();
		for ($i = 0; $i < $iterations; $i++)
		{
			$pipe->get($i);
		}
		return $result = $pipe->uncork();
	}

	// Methods for set testing

	function set_basic_sets($iterations = 1000)
	{
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$this->redis->sadd($this->set_variable.$j, $i);
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
				$pipe->sadd($this->set_variable.$j, $i);
			}
		}
		$pipe->uncork();
	}

	function get_basic_sets($iterations = 1000)
	{
		$result = array();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$result[$j] = $this->redis->smembers($this->set_variable.$j);
		}
		return $result;
	}

	function get_pipeline_sets($iterations = 1000)
	{
		$pipe = $this->redis->pipeline();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$pipe->smembers($this->set_variable.$j);
		}
		return $result = $pipe->uncork();
	}
	
	// Methods for sortedset testing

	function set_basic_sortedsets($iterations = 1000)
	{
		$time = time();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$this->redis->zadd($this->sortedset_variable.$j, $time, $i);
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
				$pipe->zadd($this->sortedset_variable.$j, $time, $i);
			}
		}
		$pipe->uncork();
	}

	function get_basic_sortedsets($iterations = 1000)
	{
		$result = array();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$result[$j] = $this->redis->zrevrange($this->sortedset_variable.$j, 0, -1);
		}
		return $result;
	}

	function get_pipeline_sortedsets($iterations = 1000)
	{
		$pipe = $this->redis->pipeline();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$pipe->zrevrange($this->sortedset_variable.$j, 0, -1);
		}
		return $result = $pipe->uncork();
	}
	
	// Methods for lists testing

	function set_basic_lists($iterations = 1000)
	{
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$this->redis->rpush($this->list_variable.$j, $i);
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
				$pipe->rpush($this->list_variable.$j, $i);
			}
		}
		$pipe->uncork();
	}

	function get_basic_lists($iterations = 1000)
	{
		$result = array();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$result[$j] = $this->redis->lrange($this->list_variable.$j, 0, -1);
		}
		return $result;
	}

	function get_pipeline_lists($iterations = 1000)
	{
		$pipe = $this->redis->pipeline();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$pipe->lrange($this->list_variable.$j, 0, -1);
		}
		return $result = $pipe->uncork();
	}

	// Methods for hashes testing

	function set_basic_hashes($iterations = 15000)
	{
		for ($i = 0; $i < $iterations; $i++)
		{
			$this->redis->hmset($this->hash_variable.$i, 'first_name', 'Iwork', 'second_name', 'Hardy', 'salary', $i*1000);
		}
	}

	function set_pipeline_hashes($iterations = 15000)
	{
		$pipe = $this->redis->pipeline();
		for ($i = 0; $i < $iterations; $i++)
		{
			$pipe->hmset($this->hash_variable.$i, 'first_name', 'Iwork', 'second_name', 'Hardy', 'salary', $i*1000);
		}
		$pipe->uncork();
	}

	function get_basic_hashes($iterations = 15000)
	{
		$result = array();
		for ($i = 0; $i < $iterations; $i++)
		{
			$result[] = $this->redis->hgetall($this->hash_variable.$i);
		}
		return $result;
	}

	function get_pipeline_hashes($iterations = 15000)
	{
		$pipe = $this->redis->pipeline();
		for ($i = 0; $i < $iterations; $i++)
		{
			$pipe->hgetall($this->hash_variable.$i);
		}
		return $result = $pipe->uncork();
	}	
}