<?php

namespace App\Repositories;

use App\Interfaces\SubmissionInterface;
use App\Models\Order;

class SubmissionRepository implements SubmissionInterface
{
    public function getAll($select = [], $withRelations = [], $join = [], $where = null, $search = null, $sortOption = [], $paginateOption = [], $reformat = null)
    {
        $order = Order::query();

        if (isset($select) && count($select) > 0) {
            $order->select($select);
        }

        if (isset($withRelations) && count($withRelations) > 0) {
            $order->with($withRelations);
        }

        if (isset($join) && count($join) > 0) {
            foreach ($join as $key => $value) {
                $order->{$value['method']}($value['table'], $value['value']);
            }
        }

        if (isset($where) && is_callable($where)) {
            $order->where($where);
        }

        if (isset($search) && is_callable($search)) {
            $order->where($search);
        }

        if (isset($sortOption['orderCol']) && !empty($sortOption['orderCol'])) {
            $order->orderBy($sortOption['orderCol'], $sortOption['orderDir'] ?? 'ASC');
        }

        if (isset($paginateOption['method']) && !empty($paginateOption['method']) && $paginateOption['method'] == 'selectList') {
            $order = $order->limit($paginateOption['length'])->get();
        } elseif (isset($paginateOption['method']) && !empty($paginateOption['method'])) {
            $order = $order->{$paginateOption['method']}(perPage: $paginateOption['length'] ?? 10, page: $paginateOption['page'] ?? 1);
        } else {
            $order = $order->get();
        }

        if (isset($reformat) && is_callable($reformat)) {
            $order = $reformat($order);
        }

        return $order;
    }

    public function findById($id, $withRelations = [], $method = 'findOrFail')
    {
        $order = Order::with($withRelations)->$method($id);

        return $order;
    }

    public function findByIdHash($id, $withRelations = [], $method = 'firstOrFail')
    {
        $order = Order::with($withRelations)->where('id_hash', $id)->$method();
        return $order;
    }

    public function create($data)
    {
        $order = new Order();

        foreach ($data as $key => $value) {
            $order->$key = $value;
        }

        $order->save();

        return $order;
    }

    public function updateById($id, $data)
    {
        $order = $this->findById($id);

        foreach ($data as $key => $value) {
            $order->$key = $value;
        }

        $order->save();

        return $order;
    }

    public function updateByIdHash($id, $data)
    {
        $order = $this->findByIdHash($id);

        foreach ($data as $key => $value) {
            $order->$key = $value;
        }

        $order->save();

        return $order;
    }

    public function deletedById($id)
    {
        $order = $this->findById($id);

        return $order->delete();
    }

    public function deletedByIdHash($id)
    {
        $order = $this->findByIdHash($id);

        return $order->delete();
    }

    public function switchActiveById($id)
    {
        $order = $this->findById($id);
        $order->is_active = !$order->is_active;
        $order->save();

        return $order;
    }

    public function switchActiveByIdHash($id)
    {
        $order = $this->findByIdHash($id);
        $order->is_active = !$order->is_active;
        $order->save();

        return $order;
    }
}
