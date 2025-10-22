<?php

use Illuminate\Http\Request;

if (! function_exists('datatable')) {
    function datatable($model, Request $request, $searchColumn = [], $mapResponse = null)
    {
        $query = $model;

        foreach ($request->except(['page', 'rows', 'search', 'orderBy', 'orderDirection']) as $column => $value) {
            if (! empty($value)) {
                if ($value === 'null') {
                    $query->whereNull($column);
                } else {
                    $query->whereIn($column, explode(',', $value));
                }
            }
        }

        if (isset($request->search) && is_array($searchColumn)) {
            $query->where(function ($query) use ($request, $searchColumn) {
                foreach ($searchColumn as $column) {
                    $query->orWhere($column, 'like', '%'.$request->search.'%');
                }
            });
        }

        if (isset($request->orderBy)) {
            $orderColumn = explode(',', $request->orderBy);

            foreach ($orderColumn as $column) {
                $query->orderBy($column, $request->orderDirection ?? 'asc');
            }
        }

        $response = $request->rows ? $query->paginate($request->rows) : $query->get();

        if (is_callable($mapResponse)) {
            $response->map($mapResponse);
        }

        $data = $request->rows ? $response : ['data' => $response];

        return encryption($data);
    }
}