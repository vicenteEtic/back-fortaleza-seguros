<?php
namespace App\Services;

use App\Models\Entity;
use Illuminate\Support\Facades\Auth;

class EntityUpdateService
{
    protected $entitieHistorie;
    protected $craftHistory;

    public function __construct($entitieHistorie, $craftHistory)
    {
        $this->entitieHistorie = $entitieHistorie;
        $this->craftHistory = $craftHistory;
    }

    public function updateField(Entity $entity, $field, $newValue)
    {
        // Armazenar o valor antigo
        $oldValue = $entity->{$field};

        // Atualizar o campo
        $entity->{$field} = $newValue;
        $entity->save();

        // Registrar os logs
        $this->logUpdate($entity, $field, $oldValue, $newValue);

        return $entity;
    }

    protected function logUpdate(Entity $entity, $field, $oldValue, $newValue)
    {
        $user = Auth::user();

        $logMessage = "Foi atualizado no sistema pelo Usuário {$user->first_name}: "
            . "Trocou o campo '{$field}' de '{$oldValue}' para '{$newValue}'";

        // Registrar o log
        $this->entitieHistorie->log('info', $logMessage, $entity->id, $user->id);
        $this->craftHistory->log('info', "Editou o campo '{$field}' da entidade {$entity->id}", $user->name, $user->id);
    }
}
