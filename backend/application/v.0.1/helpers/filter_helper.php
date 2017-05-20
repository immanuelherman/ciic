<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function adjust_filter(array $params)
{
	// prepare filter
	$filter = array();

	// set params as parameter request. set default if not set
	$params['default'] = array_filter($params['default'], 'strlen');
    $filter['parameter'] = array_merge($params['default'], $params['parameter']);

    // clean anymous parameter by look up key of parameter
	$all_field = (!empty($params['opt_field'])) 
	? 
		array_merge($params['def_field'], $params['opt_field'])
	:
		array_merge($params['def_field'], $params['def_field']);

    $filter['parameter'] = 
		array_intersect_key(
			$filter['parameter'], 
			array_merge(
				array_flip($all_field), $params['default']
			)
		);

    // validate select table. make sure field of table are defined. so we can select with dynamic query
    // and more secure than set select by user input
	$filter['select'] = validate_select(
		$params['def_field'], 
		$params['opt_field'], 
		$filter['parameter']['fields'], 
		$filter['parameter']['fields_str']
	);
    // get filter array
    $filter['filter'] = validate_filter($filter['parameter']['filter'], $all_field);

    // add str date second to parameter. by default input parameter date have format 'Y-m-d H:i'
    // dateFrom append with :00 and dateTo append with :59
    //var_dump($selector);
    $filter['parameter']['date_from'] .= ':00'; 
    $filter['parameter']['date_to'] .= ':59';

    if (!validate_date('Y-m-d H:i:s', $filter['parameter']['date_from']) OR !validate_date('Y-m-d H:i:s', $filter['parameter']['date_to'])) 
    {
        response(400, 'date_from or date_to must in valid date');
    }

    // filter['parameter'] order by
    if (substr($filter['parameter']['order'], 0, 1) == "-")
    {
        $filter['parameter']['order'] = substr($filter['parameter']['order'], 1);
    }
    else
    {
        $filter['parameter']['sort'] = 'ASC';
    }

    // check aliases on order. if is a one of alias, then replace it
    if (($keystr = array_search($filter['parameter']['order'], $all_field)) && (!is_int($keystr))) 
    {
        $filter['parameter']['order'] = $keystr;
    }

    if (!(!empty($filter['parameter']['deletion']) && in_array($filter['parameter']['deletion'], array(0,1))))
	{
    	$filter['parameter']['deletion'] = 0;
    }

    return $filter;
}

function validate_select($default, $optional, $selector = NULL, $convertToStr = TRUE)
{
	$result = "*";

	$allField = array_merge($default, $optional);

	if (is_null($selector))
	{
		$selector = $optional;
	}
	
	if ($selector == "All")
	{
		$selector = $optional;
	}

	if (is_string($selector))
	{
		$selector = explode(",", $selector);
		$selector = array_map("trim", $selector);
	}

	$opt = "";
	$count = count($selector)-1;
	foreach ($selector as $key => $value) {
		$find = array_find($value, $optional);
		$opt .= ($count == $key)?$find:($find.",");
	}

	$selector = array_map('trim', explode(",", $opt));
	$selector = array_map('strval', explode(",", $opt));

	if (is_array($selector))
	{
		$selector = array_filter($selector);
		$result = array_intersect($selector, $optional);
		$result = array_keys(array_merge(array_flip($default), array_flip($result)));
	}

	// set alias if field have alias
	$newResult = array();
	
	foreach ($result as $key => $value) 
	{
		if (!is_int($keystr = array_search($value, $allField)))
		{
			$newResult[] = $keystr;
		}
		else
		{
			$newResult[] = $value;
		}
	}

	if ($convertToStr === TRUE)
	{
		$result = (($impl = implode(',', $newResult)) != '') ? $impl : '';
	}
	
	return $result;
}

function validate_filter($strFilter = NULL, $allField = array(), $flip = false, $like = TRUE)
{
	$result = array();

	if (empty($strFilter))
	{
		return "";
	}

	if (is_string($strFilter))
	{
		$strFilter = explode(",", $strFilter);
	}

	foreach ($strFilter as $key => $value) 
	{
		$temp = explode("|", $value);
		
		if (count($temp) !== 2) continue;

		if (!empty($result[$temp[0]])) 
		{
			if (is_array($result[$temp[0]]))
			{
				$result[$temp[0]][] = $temp[1];
			}
			else
			{
				$result[$temp[0]] = array($result[$temp[0]], $temp[1]);
			}
		}
		else
		{
			$result[$temp[0]] = $temp[1];
		}
	}
	// if all field defined. clear all parameter
	if (!empty($allField))
	{
        $result = array_intersect_key($result, array_flip($allField));
	}

	// set alias if field have alias
	$newResult = array();
	
	if (!$flip)
	{
		foreach ($result as $key => $value) 
		{
			if (!is_int($keystr = array_search($key, $allField)))
			{
				$newResult[$keystr] = $value;
			}
			else
			{
				$newResult[$key] = $value;
			}
		}
	}
	else
	{
		$newResult = $result;
	}

	$allResult = array();
	$allResult['query'] = "";
	$allResult['binding'] = "";
	$allResult['origin'] = $newResult;


	foreach ($newResult as $placeholder => $val) 
    {
    	if (is_array($val))
    	{
    		$allResult["query"] .= "AND ( ";
    		foreach ($val as $key => $value) 
    		{
				$like = (ctype_digit((string) $val)) ? 0 : 1; 

    			if (!empty($allField[$placeholder]))
    			{
    				if (is_int($value)) $value = intval($value);
	    			$allResult["query"] .= $placeholder;
	    			$allResult["query"] .= ($like) ? " LIKE " : " = ";
	    			$allResult["query"] .= ":".$allField[$placeholder].$key." OR ";
	    			$allResult['binding'][$allField[$placeholder].$key] = ($like) ? "%".$value."%" : $value;
    			}
    			else if(in_array($placeholder, $allField))
    			{
    				$allResult["query"] .= $placeholder;
	    			$allResult["query"] .= ($like) ? " LIKE " : " = ";
	    			$allResult["query"] .= ":".$placeholder.$key." OR ";
	    			$allResult['binding'][$placeholder.$key] = ($like) ? "%".$value."%" : $value;	
    			}
    		}
    		
    		if (strlen($allResult["query"]) > 8) 
			{
				$allResult["query"] = substr($allResult["query"], 0, -4);
    			$allResult["query"] .= " )";
    		}
    		else
    		{
    			$allResult["query"] = substr($allResult["query"], 0, -5);
    		}
    	}
    	else
    	{
			$like = (ctype_digit((string) $val)) ? 0 : 1; 

    		if (in_array($placeholder, array_keys($allField)) OR in_array($placeholder, $allField))
    		{
				if (is_int($val)) $val = intval($val);
				$allResult['binding'][$placeholder] = ($like) ? "%".$val."%" : $val;
				$allResult["query"] .= " AND ".$placeholder;
				$allResult["query"] .= ($like) ? " LIKE " : " = "; 
				if ($flip)
				{
					$allResult["query"] .= ":".$placeholder;
    			}
    			else
    			{
    				if (empty($allField[$placeholder]))
    				{
						$allResult["query"] .= ":".$placeholder;
    				}
    				else
    				{
    					$allResult["query"] .= ":".$allField[$placeholder];
						if (!empty($allResult['binding'][$placeholder]))
						{
							$allResult['binding'][$allField[$placeholder]] = $allResult['binding'][$placeholder];
							unset($allResult['binding'][$placeholder]);
						}
    				}
    			}
    		}
    	}
    }
	return $allResult;
}

function validate_date($format, $date)
{
    $d = new DateTime($date);
    return $d && ($d->format($format) == $date);
}

function array_find($needle, array $haystack)
{
    foreach ($haystack as $key => $value) {
        if (false !== stripos($value, $needle)) {
            return $value;
        }
    }
    return false;
}