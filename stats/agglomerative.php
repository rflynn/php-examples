<?php

# Agglomerative Clustering Algorithm
# Iteratively build a hierarchical cluster between all data points based on distance.
# Author: Ryan Flynn
# Port of the much clearer python version at https://github.com/rflynn/python-examples/blob/master/src/stats/cluster/agglomerative.py

error_reporting(E_ALL);

# remove array[index] and return it, modifying array
# clone python's list.pop[i])
function pop(&$a, $i)
{
	$foo = $a[$i];
	array_splice($a, $i, 1);
	return $foo;
}

class Cluster
{

public $left, $right, $distance;

function __construct($distance)
{
	$this->distance = $distance;
}

function __toString()
{
	return sprintf("(%s, %s)", $this->left, $this->right);
}

function add($clusters, $grid, $lefti, $righti)
{
	$this->left = $clusters[$lefti];
	$this->right = pop($clusters, $righti);
	# merge columns grid[row][righti] and row grid[righti] into corresponding lefti
	for ($i = 0; $i < count($grid); $i++)
	{
		for ($j = 0; $j < count($grid); $j++)
		{
			$grid[$i][$lefti] = min($grid[$i][$lefti], $grid[$i][$righti]);
		}
		pop($grid[$i], $righti);
	}
	$r = pop($grid, $righti);
	for ($i = 0; $i < count($grid); $i++)
	{
		$grid[$lefti][$i] = min($grid[$lefti][$i], $r[$i]);
	}
	return array($clusters, $grid);
}

# list all members of this cluster
function members()
{
	$m = array();
	foreach (array($this->left, $this->right) as $x)
	{
		if (method_exists($x, 'members'))
			$m = array_merge($m, $x->members());
		else
			$m[] = $x;
	}
	return $m;
}

# split a cluster into n sub-clusters based on the order they were built (and thus distance)
function splitInto($n)
{
	$clusters = array($this);
	while (count($clusters) < $n)
	{
		# find the cluster with the highest nth
		usort($clusters,
			function ($a, $b)
			{
				if (!property_exists($a, 'distance'))
					return 1;
				if (!property_exists($b, 'distance'))
					return -1;
				return $a->distance - $b->distance;
			});
 		if (!property_exists($clusters[0], 'left'))
			break; # none left to split, bail out
		# highest nth is at [0], split it into left and right
		# note: it's always guarenteed to be splittable since
		# we check n/nth at the top
		$c = array_shift($clusters);
		$clusters[] = $c->left;
		$clusters[] = $c->right;
	}
	return $clusters;
}

private function sortByDistance($clusters)
{
	# find the cluster with the highest nth
	usort($clusters,
		function ($a, $b)
		{
			if (!property_exists($a, 'distance'))
				return 1;
			if (!property_exists($b, 'distance'))
				return -1;
			return $a->distance - $b->distance;
		});
	return $clusters;
}

# split a cluster into n sub-clusters based on the distance
function splitBy($distance)
{
	$clusters = array($this);
	while (true)
	{
 		if (!property_exists($clusters[0], 'distance') || $clusters[0]->distance < $distance)
			break;
		# highest nth is at [0], split it into left and right
		# note: it's always guarenteed to be splittable since
		# we check n/nth at the top
		$c = array_shift($clusters);
		$clusters[] = $c->left;
		$clusters[] = $c->right;
	}
	return $clusters;
}

}

# given a list of labels and a 2-D grid of distances, iteratively agglomerate
# hierarchical Cluster
function agglomerate($labels, $grid)
{
	$clusters = $labels;
	while (count($clusters) > 1)
	{
		$distances = array(array(1, 0, $grid[1][0]));
		for ($i = 2; $i < count($grid); $i++)
		{
			for ($j = 0; $j < $i; $j++)
			{
				$distances[] = array($i, $j, $grid[$i][$j]);
			}
		}
		usort($distances,
			function ($a, $b) { return $b[2] < $a[2]; });
		list($j, $i, $d) = $distances[0];
		# merge i⇐j
		$c = new Cluster($d);
		list($clusters, $grid) = $c->add($clusters, $grid, $i, $j);
		$clusters[$i] = $c;
	}
	return $clusters[min(0, count($clusters)-1)];
}

$ItalyCities = array('BA', 'FI', 'MI', 'NA', 'RM', 'TO');
$ItalyDistances = array(
	array(   0, 662, 877, 255, 412, 996),
	array( 662,   0, 295, 468, 268, 400),
	array( 877, 295,   0, 754, 564, 138),
	array( 255, 468, 754,   0, 219, 869),
	array( 412, 268, 564, 219,   0, 669),
	array( 996, 400, 138, 869, 669,   0),
);
$a = agglomerate($ItalyCities, $ItalyDistances);
echo $a . "\n";
print_r($a);
echo "members: ";
print_r($a->members());
echo "splitInto(4): ";
print_r($a->splitInto(4));
echo "splitInto(10): ";
print_r($a->splitInto(10));

?>
