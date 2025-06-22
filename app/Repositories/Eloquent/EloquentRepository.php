<?php

namespace App\Repositories\Eloquent;

use Carbon\Carbon;

abstract class EloquentRepository implements RepositoryInterface
{
    protected $_model;

    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Abstract models
     *
     * @return mixed
     */
    abstract public function getModel();

    /**
     * Set model function
     */
    public function setModel()
    {
        $this->_model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Method get all record and order by id using param $orderBy
     *
     * @param int $paginate
     * @param string $orderBy ASC or DESC and default ASC
     * @return collection list object
     */
    public function getAll($paginate = null, $orderBy = null)
    {
        $data = $this->_model->orderBy('id', !is_null($orderBy) ? $orderBy : 'ASC');
        if (!is_null($paginate)) {
            $data = $data->paginate(!is_null($paginate) ? $paginate : config('constant.paginate'));
        } else {
            $data = $data->get();
        }
        return $data;
    }

    /**
     * Method find an record using id param
     *
     * @param int $id object
     * @return collection an object
     */
    public function find($id)
    {
        return $this->_model->find($id);
    }

    /**
     * Method create an record using array attribute
     *
     * @param array $attribute object
     * @return bool | collection a object
     */
    public function create(array $attribute)
    {
        $create = $this->_model->create($attribute);
        if ($create) {
            return $create;
        }
        return false;
    }

    /**
     * Method update an record using attribute and id object
     *
     * @param array $attribute object
     * @param int $id object
     * @return bool
     */
    public function update(array $attribute, $id)
    {
        $model = $this->_model->findOrFail($id);
        $model->fill($attribute);
        if ($model->save()) {
            return true;
        }
        return false;
    }

    /**
     * Method soft delete data in DB record using id
     *
     * @param int $id object
     * @return bool
     */
    public function delete($id)
    {
        $result = $this->_model->find($id);
        if (!$result) {
            return false;
        }
        $result->deleted_at = Carbon::now();
        $result->update();
        return true;
    }

    /**
     * Method delete permanently data in DB record using id
     *
     * @param int $id object
     * @return bool
     */
    public function destroy($id)
    {
        $result = $this->_model->find($id);
        if (!$result) {
            return false;
        }
        $result->delete();
        return true;
    }

    /**
     * Method get all data of table with relations
     *
     * @param null | $relations
     * @return mixed | list object
     */
    public function getList($relations = null)
    {
        $model = $this->_model;
        if ($relations) {
            $model = $model->with($relations);
        }
        return $model->get();
    }
}