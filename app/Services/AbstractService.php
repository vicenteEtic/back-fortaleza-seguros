<?php

namespace App\Services;

use App\Repositories\AbstractRepository;

abstract class AbstractService
{
    protected AbstractRepository $repository;

    public function __construct(AbstractRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(?int $paginate, ?array $filterParams, ?array $orderByParams)
    {
        return $this->repository->index($paginate, $filterParams, $orderByParams);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(array $data)
    {
        return $this->repository->store($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(int|string $id)
    {
        return $this->repository->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(array $data, int $id)
    {
        return $this->repository->update($data, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->repository->destroy($id);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(int $id)
    {
        return $this->repository->restore($id);
    }

}
