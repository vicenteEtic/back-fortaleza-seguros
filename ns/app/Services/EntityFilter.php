<?php

// App/Services/EntityFilter.php

namespace App\Services;

class EntityFilter
{
    public static function apply($query, $filters)
    {
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('social_denomination', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('customer_number', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('policy_number', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('risk_level', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('diligence', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('entity_type', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['social_denomination'])) {
            $query->where('social_denomination', 'like', '%' . $filters['social_denomination'] . '%');
        }

        if (!empty($filters['customer_number'])) {
            $query->where('customer_number', 'like', '%' . $filters['customer_number'] . '%');
        }

        if (!empty($filters['policy_number'])) {
            $query->where('policy_number', 'like', '%' . $filters['policy_number'] . '%');
        }

        if (!empty($filters['type'])) {
            $query->where('entity_type', $filters['type']);
        }

        if (isset($filters['last_evaluation'])) {



            $date = \Carbon\Carbon::parse($filters['last_evaluation'])->format('Y-m-d');
            $query->whereDate('created_at', $date);
        }

        if (isset($filters['created_at'])) {
            $date = \Carbon\Carbon::parse($filters['created_at'])->format('Y-m-d');
            $query->whereDate('created_at', $date);
        }

        return $query;
    }
}
