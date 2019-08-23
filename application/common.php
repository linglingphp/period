<?php

//渲染json
function renderData($code, $data = [])
{
    if (!is_numeric($code)) {
        return '';
    }
    $result = [
        'errorCode' => $code,
        'message' => config("errorCode.{$code}"),
        'data' => $data
    ];
    return json($result);
}


function floattoint($float_value){
    return (int)round($float_value*10000)/100;
}


if (!function_exists('transforms')) {
    function transforms($data, $filters, $single = false)
    {
        if ($single) {
            $data = [$data];
        }

        if (isset($filters[0]) && !is_array($filters[0])) {
            $filters = [$filters];
        }

        $relations = array_keys($filters);

        foreach ($data as &$item) {
            foreach ($filters as $field => $filter) {
                if (is_numeric($field)) {
                    $item = array_intersect_key($item, array_flip(array_merge($relations, $filter)));
                } elseif (!empty($item[$field])) {
                    foreach ($item[$field] as $k => $v) {
                        if (!in_array($k, $filter)) {
                            unset($item[$field][$k]);
                        }
                    }
                }
            }
        }

        return !$single ? $data : $data[0];
    }
}

if (!function_exists('transform')) {
    function transform($data, $filters, $inverse = false)
    {
        if (!is_array($data)) {
            if (!method_exists($data, 'toArray')) {
                return $data;
            }
            $data = $data->toArray();
        }

        $normal = [];
        $recursives = [];
        foreach ($filters as $key => $filter) {
            if (is_array($filter)) {
                $recursives[] = $key;
            } else {
                $normal[] = $filter;
            }
        }

        $copy = call_user_func(!$inverse ? 'array_intersect_key' : 'array_diff_key', $data, array_flip($normal));

        foreach ($recursives as $recursive) {
            if (isset($data[$recursive])) {
                $copy[$recursive] = transform($data[$recursive], $filters[$recursive], $inverse);
            }
        }

        return $copy;
    }
}