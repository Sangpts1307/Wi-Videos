<?php

namespace App\Repositories\Eloquent;

interface RepositoryInterface
{
    // Param orderBy: asc or desc string
    public function getAll($paginate = null, $orderBy = null);

    // Detail a record
    public function find($id);

    // Create a record, param an array attribute
    public function create(array $attribute);

    // Update a record, param an array attribute and id of the record
    public function update(array $attribute, $id);

    // Soft delete a record, param an id of the record
    public function delete($id);

    // Permanently delete a record, param an id of the record
    public function destroy($id);

    // Get list data of table with relations
    public function getList($relations = null);
}