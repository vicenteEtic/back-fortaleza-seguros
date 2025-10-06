<?php
namespace App\Repositories\Permission;

use App\Models\Permission\Role;
use App\Repositories\AbstractRepository;

class RoleRepository extends AbstractRepository
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function update(array $data, int $id)
    {

      
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return $model;
    }
}