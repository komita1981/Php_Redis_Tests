<?php
// prepend a base path if Predis is not present in your "include_path".
require 'predis/lib/Predis/Autoloader.php';

Predis\Autoloader::register();

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
		$this->redis = new Predis\Client(array(
		    'host'     => '127.0.0.1',
		    'port'     => 6379,
		    'database' => 0
		));
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
		for ($i = 0; $i < 20000; $i++)
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
			$result[] = $this->redis->get($i);
		}
		return $result;
	}

	function get_pipeline_strings($iterations = 20000)
	{
		$pipe = $this->redis->pipeline();
		for ($i = 0; $i < $iterations; $i++)
		{
			$pipe->get($i);
		}
		return $pipe->execute();
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

	// sets
	function set_pipeline_sets($iterations = 1000)
	{
		$pipe = $this->redis->pipeline();
		for ($j = 0; $j < 20; $j++)
		{
			for ($i = 0; $i < 1000; $i++)
			{
				$pipe->sadd('tester_set'.$j, $i);
			}
		}
		$pipe->execute();
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
		$pipe = $this->redis->pipeline();
		for ($j = 0; $j < 20; $j++)
		{
			$pipe->smembers('tester_set'.$j);
		}
		return $pipe->execute();
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
		$pipe = $this->redis->pipeline();
		$time = time();
		for ($j = 0; $j < 20; $j++)
		{
			for ($i = 0; $i < 1000; $i++)
			{
				$pipe->zadd('tester_sortedset'.$j, $time, $i);
			}
		}
		$pipe->execute();
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
		$pipe = $this->redis->pipeline();
		for ($j = 0; $j < 20; $j++)
		{
			$pipe->zrevrange('tester_sortedset'.$j, 0, -1);
		}
		return $pipe->execute();
	}

	// Methods for list testing

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
		for ($j = 0; $j < 20; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$pipe->rpush('tester_sortedset'.$j, $i);
			}
		}
		return $pipe->execute();
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
		$pipe = $this->redis->pipeline();
		for ($j = 0; $j < 20; $j++)
		{
			$pipe->lrange('tester_sortedset'.$j, 0, -1);
		}
		return $pipe->execute();
	}

	// Methods for hash testing

	function set_basic_hashes($iterations = 15000)
	{
		for ($i = 0; $i < $iterations; $i++)
		{
			$this->redis->hmset($this->hash_variable.$i, array('first_name' => 'Iwork', 'second_name' => 'Hardy', 'salary' => $i*1000));
		}
	}

	function set_pipeline_hashes($iterations = 15000)
	{
		$pipe = $this->redis->pipeline();
		for ($i = 0; $i < $iterations; $i++)
		{
			$pipe->hmset($this->hash_variable.$i, array('first_name' => 'Iwork', 'second_name' => 'Hardy', 'salary' => $i*1000));
		}
		$pipe->execute();
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
		return $pipe->execute();
	}
}
?>

