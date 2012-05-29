<?php
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Platform
 * @version    1.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Extensions;

use Exception;

class Dependency
{
	public static function sort($extensions = array())
	{
		// The class below requires that we have
		// at least 1 dependency for each module.
		foreach ($extensions as $extension => &$dependencies)
		{
			if (empty($dependencies))
			{
				$dependencies[] = 'core';
			}
		}

		$t = new TopologicalSort($extensions, true);
		$sorted = $t->tsort();

		if ( ! $sorted)
		{
			throw new Exception('Error in sorting dependencies');
		}

		// Search for core (the most basic placehodler
		// dependency we provided)
		if (in_array('core', $sorted))
		{
			// Try keep keys sorted nicely
			if (($key = array_search('core', $sorted)) === 0)
			{
				array_shift($sorted);
			}
			else
			{
				unset($sorted[array_search('core', $sorted)]);
			}
		}

		return $sorted;
	}
}


/**
 * @todo refactor and implement the below class proprly.
 */





/**
* Sorts a series of dependency pairs in linear order
*
* usage:
* $t = new TopologicalSort($dependency_pairs);
* $load_order = $t->tsort();
*
* where dependency_pairs is in the form:
* $name => (depends on) $value
*
*/
class TopologicalSort
{
	public $nodes = array();

	/**
	* Dependency pairs are a list of arrays in the form
	* $name => $val where $key must come before $val in load order.
	*
	*/
	public function __construct($dependencies=array(), $parse=false)
	{
		if ($parse) $dependencies = $this->parseDependencyList($dependencies);
		// turn pairs into double-linked node tree

		foreach($dependencies as $key => $dpair) {
			list($module, $dependency) = each($dpair);

			if (! isset($this->nodes[$module]))
				$this->nodes[$module] = new TSNode($module);

			if (! isset($this->nodes[$dependency]))
				$this->nodes[$dependency] = new TSNode($dependency);

			if (! in_array($dependency,$this->nodes[$module]->children))
				$this->nodes[$module]->children[] = $dependency;

			if (! in_array($module,$this->nodes[$dependency]->parents))
				$this->nodes[$dependency]->parents[] = $module;
		}
	}

	/**
	* Perform Topological Sort
	*
	* @param array $nodes optional array of node objects may be passed.
	* Default is  $this->nodes created in constructor.
	* @return sorted array
	*/
	public function tsort($nodes=array())
	{
		// use this->nodes if it is populated and no param passed
		if (! @count($nodes) && count($this->nodes))
		$nodes = $this->nodes;

		// get nodes without parents
		$root_nodes = array_values($this->getRootNodes($nodes));

		// begin algorithm
		$sorted = array();
		while(count($nodes)>0) {
			// check for circular reference
			if (count($root_nodes) == 0) return false;

			// remove this node from root_nodes
			// and add it to the output
			$n = array_pop($root_nodes);
			$sorted[] = $n->name;

			// for each of its  children
			// queue the new node finally remove the original
			for($i=(count($n->children)-1); $i >= 0; $i--) {
				$childnode = $n->children[$i];
				// remove the link from this node to its
				// children ($nodes[$n->name]->children[$i]) AND
				// remove the link from each child to this
				// parent ($nodes[$childnode]->parents[?]) THEN
				// remove this child from this node
				unset($nodes[$n->name]->children[$i]);
				$parent_position = array_search($n->name,$nodes[$childnode]->parents);
				unset($nodes[$childnode]->parents[$parent_position]);
				// check if this child has other parents
				// if not, add it to the root nodes list
				if (!count($nodes[$childnode]->parents))array_push($root_nodes,$nodes[$childnode]);
			}

			// nodes.Remove(n);
			unset($nodes[$n->name]);
		}
		return $sorted;
	}

	/**
	* Returns a list of node objects that do not have parents
	*
	* @param array $nodes array of node objects
	* @return array of node objects
	*/
	public function getRootNodes($nodes)
	{
	$output = array();
	foreach($nodes as $name => $node)
	 if (!count($node->parents)) $output[$name] = $node;
	return $output;
	}

	/**
	* Parses an array of dependencies into an array of dependency pairs
	*
	* The array of dependencies would be in the form:
	* $dependency_list = array(
	*  "name" => array("dependency1","dependency2","dependency3"),
	*  "name2" => array("dependencyA","dependencyB","dependencyC"),
	*  ...etc
	* );
	*
	* @param array $dlist Array of dependency pairs for use as parameter in tsort method
	* @return array
	*/
	public function parseDependencyList($dlist=array())
	{
	$output = array();
		foreach($dlist as $name => $dependencies)
			foreach($dependencies as $d)
				array_push($output, array($d => $name));
		return $output;
	}
}

/**
* Node class for Topological Sort Class
*
*/
class TSNode
{
	public $name;
	public $children = array();
	public $parents = array();

	public function __construct($name="") {
		$this->name = $name;
	}
}
