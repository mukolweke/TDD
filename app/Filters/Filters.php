<?php
/**
 * Created by PhpStorm.
 * User: molukaka
 * Date: 31/07/2018
 * Time: 16:44
 */

namespace App\Filters;


use Illuminate\Http\Request;

abstract class Filters
{
    protected $request, $builder;
    protected $filters = ['by'];


    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value){
            if (method_exists($this, $filter)){
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function getFilters()
    {
        return $this->request->intersect($this->filters);
    }
}