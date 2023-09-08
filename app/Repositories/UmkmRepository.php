<?php

namespace App\Repositories;

use App\Interfaces\UmkmInterface;
use App\Models\Umkm;

class UmkmRepository implements UmkmInterface
{
    public function getAll($select = [], $withRelations = [], $join = [], $where = null, $search = null, $sortOption = [], $paginateOption = [], $reformat = null)
    {
        $umkm = Umkm::query();

        if (isset($select) && count($select) > 0) {
            $umkm->select($select);
        }

        if (isset($withRelations) && count($withRelations) > 0) {
            $umkm->with($withRelations);
        }

        if (isset($join) && count($join) > 0) {
            foreach ($join as $key => $value) {
                $umkm->{$value['method']}($value['table'], $value['value']);
            }
        }

        if (isset($where) && is_callable($where)) {
            $umkm->where($where);
        }

        if (isset($search) && is_callable($search)) {
            $umkm->where($search);
        }

        if (isset($sortOption['orderCol']) && !empty($sortOption['orderCol'])) {
            $umkm->orderBy($sortOption['orderCol'], $sortOption['orderDir'] ?? 'ASC');
        }

        if (isset($paginateOption['method']) && !empty($paginateOption['method']) && $paginateOption['method'] == 'selectList') {
            $umkm = $umkm->limit($paginateOption['length'])->get();
        } elseif (isset($paginateOption['method']) && !empty($paginateOption['method'])) {
            $umkm = $umkm->{$paginateOption['method']}(perPage: $paginateOption['length'] ?? 10, page: $paginateOption['page'] ?? 1);
        } else {
            $umkm = $umkm->get();
        }

        if (isset($reformat) && is_callable($reformat)) {
            $umkm = $reformat($umkm);
        }

        return $umkm;
    }

    public function findById($id, $withRelations = [], $method = 'findOrFail')
    {
        $umkm = Umkm::with($withRelations)->$method($id);

        return $umkm;
    }

    public function findByIdHash($id, $withRelations = [], $method = 'firstOrFail')
    {
        $umkm = Umkm::with($withRelations)->where('id_hash', $id)->$method();
        return $umkm;
    }

    public function create($data)
    {
        $umkm = new Umkm();

        foreach ($data as $key => $value) {
            $umkm->$key = $value;
        }

        $umkm->save();

        return $umkm;
    }

    public function updateById($id, $data)
    {
        $umkm = $this->findById($id);

        foreach ($data as $key => $value) {
            $umkm->$key = $value;
        }

        $umkm->save();

        return $umkm;
    }

    public function updateByIdHash($id, $data)
    {
        $umkm = $this->findByIdHash($id);

        foreach ($data as $key => $value) {
            $umkm->$key = $value;
        }

        $umkm->save();

        return $umkm;
    }

    public function deletedById($id)
    {
        $umkm = $this->findById($id);

        return $umkm->delete();
    }

    public function deletedByIdHash($id)
    {
        $umkm = $this->findByIdHash($id);

        return $umkm->delete();
    }

    public function switchActiveById($id)
    {
        $umkm = $this->findById($id);
        $umkm->is_active = !$umkm->is_active;
        $umkm->save();

        return $umkm;
    }

    public function switchActiveByIdHash($id)
    {
        $umkm = $this->findByIdHash($id);
        $umkm->is_active = !$umkm->is_active;
        $umkm->save();

        return $umkm;
    }
}
