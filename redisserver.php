<?php
include 'redisserver/RedisServer.php';

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
		$this->redis = new RedisServer();
		$this->redis->connect('localhost', 6379);
	}

	// Methods for string testing
	function set_basic_strings($iterations = 20000)
	{
		for ($i = 0; $i < $iterations; $i++)
		{
			$this->redis->send_command('set',$i, $i);
		}
	}

	function set_pipeline_strings($iterations = 20000)
	{
		$this->redis->send_command('multi');
		for ($i = 0; $i < $iterations; $i++)
		{
			$this->redis->send_command('set', $i, $i);
		}
		$this->redis->send_command('exec');
	}

	function get_basic_strings($iterations = 20000)
	{
		$result = array();
		for ($i = 0; $i < $iterations; $i++)
		{
			$result[] = $this->redis->send_command('get', $i);
		}
		return $result;
	}

	function get_pipeline_strings($iterations = 20000)
	{
		$this->redis->send_command('multi');
		for ($i = 0; $i < $iterations; $i++)
		{
			$this->redis->send_command('get', $i);
		}
		return $this->redis->send_command('exec');
	}

	// Methods for sets testing
	function set_basic_sets($iterations = 1000)
	{
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$this->redis->send_command('sadd',$this->set_variable.$j, $i);
			}
		}
	}

	function set_pipeline_sets($iterations = 1000)
	{
		$this->redis->send_command('multi');
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$this->redis->send_command('sadd', $this->set_variable.$j, $i);
			}
		}
		$this->redis->send_command('exec');
	}

	function get_basic_sets($iterations = 1000)
	{
		$result = array();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$result[] = $this->redis->send_command('smembers', $this->set_variable.$j);
		}
		return $result;
	}

	function get_pipeline_sets($iterations = 1000)
	{
		$this->redis->send_command('multi');
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$this->redis->send_command('smembers', $this->set_variable.$j);
		}
		return $this->redis->send_command('exec');
	}
	
	// Methods for sortedset testing
	function set_basic_sortedsets($iterations = 1000)
	{
		$time = time();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$this->redis->send_command('zadd',$this->sortedset_variable.$j, $time, $i);
			}
		}
	}

	function set_pipeline_sortedsets($iterations = 1000)
	{
		$time = time();
		$this->redis->send_command('multi');
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$this->redis->send_command('zadd', $this->sortedset_variable.$j, $time, $i);
			}
		}
		$this->redis->send_command('exec');
	}

	function get_basic_sortedsets($iterations = 1000)
	{
		$result = array();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$result[] = $this->redis->send_command('zrevrange', $this->sortedset_variable.$j, 0, -1);
		}
		return $result;
	}

	function get_pipeline_sortedsets($iterations = 1000)
	{
		$this->redis->send_command('multi');
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$this->redis->send_command('zrevrange', $this->sortedset_variable.$j, 0, -1);
		}
		return $this->redis->send_command('exec');
	}

	// Methods for sortedset testing
	function set_basic_lists($iterations = 1000)
	{
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$this->redis->send_command('rpush',$this->list_variable.$j, $i);
			}
		}
	}

	function set_pipeline_lists($iterations = 1000)
	{
		$this->redis->send_command('multi');
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			for ($i = 0; $i < $iterations; $i++)
			{
				$this->redis->send_command('rpush', $this->list_variable.$j, $i);
			}
		}
		$this->redis->send_command('exec');
	}

	function get_basic_lists($iterations = 1000)
	{
		$result = array();
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$result[] = $this->redis->send_command('lrange', $this->list_variable.$j, 0, -1);
		}
		return $result;
	}

	function get_pipeline_lists($iterations = 1000)
	{
		$this->redis->send_command('multi');
		for ($j = 0; $j < $this->set_iteration; $j++)
		{
			$this->redis->send_command('lrange', $this->list_variable.$j, 0, -1);
		}
		return $this->redis->send_command('exec');
	}

	// Methods for string testing
	function set_basic_hashes($iterations = 15000)
	{
		for ($i = 0; $i < $iterations; $i++)
		{
			$this->redis->send_command('hmset', $this->hash_variable.$i, 'first_name', 'Iwork', 'second_name', 'Hardy', 'salary', $i*1000);
		}
	}

	function set_pipeline_hashes($iterations = 15000)
	{
		$this->redis->send_command('multi');
		for ($i = 0; $i < $iterations; $i++)
		{
			$this->redis->send_command('hmset', $this->hash_variable.$i, 'first_name', 'Iwork', 'second_name', 'Hardy', 'salary', $i*1000);
		}
		$this->redis->send_command('exec');
	}

	function get_basic_hashes($iterations = 15000)
	{
		$result = array();
		for ($i = 0; $i < $iterations; $i++)
		{
			$result[] = $this->redis->send_command('hgetall', $this->hash_variable.$i);
		}
		return $result;
	}

	function get_pipeline_hashes($iterations = 15000)
	{
		$this->redis->send_command('multi');
		for ($i = 0; $i < $iterations; $i++)
		{
			$this->redis->send_command('hgetall', $this->hash_variable.$i);
		}
		return $this->redis->send_command('exec');
	}	
}