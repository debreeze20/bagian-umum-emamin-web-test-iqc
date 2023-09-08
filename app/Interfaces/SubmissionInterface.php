<?php

namespace App\Interfaces;

interface SubmissionInterface
{
    public function getAll($select = [], $withRelations = [], $join = [], $where = null, $search = null, $sortOption = [], $paginateOption = [], $reformat = null);
    // public function findById($id, $withRelations = [], $method = 'findOrFail');
    // public function findByIdHash($id, $withRelations = [], $method = 'firstOrFail');
    // public function create($data);
    // public function updateById($id, $data);
    // public function updateByIdHash($id, $data);
    // public function deletedById($id);
    // public function deletedByIdHash($id);
    // public function switchActiveById($id);
    // public function switchActiveByIdHash($id);
}
