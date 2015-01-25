<?php

function CouponBuildRoute( &$query )
{
	$segments = array();	
	
	if (isset($query['view'])) {
		$segments[] = $query['view'];
		$query['Itemid'] = '';	
		unset($query['view']);
	}
	if(isset($query['layout'])){
		$segments[] = $query['layout'];
		unset($query['layout']);
	}
	if(isset($query['id'])){
		$segments[] = $query['id'];
		unset($query['id']);
	}
	return $segments;
	
}

function CouponParseRoute( $segments )
{
	$vars = array();
		
	$count = count($segments);
	
	if (isset($segments[0]))
	{
		$view = $segments[0];
		$vars['view'] = $view;
		if($view=='front' && $count==2){
			$vars['layout'] = $segments[1];
		}
		if(count($segments)==3){
			$vars['layout'] = $segments[1];
			$vars['id'] = $segments[2];
		} else if(count($segments)==2){
			$vars['id'] = $segments[1];
		}
	}	
	return $vars;
}