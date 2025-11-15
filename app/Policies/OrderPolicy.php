<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Vendor hanya bisa melihat order yang berisi produknya.
     */
    public function view(User $user, Order $order)
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'vendor') {
            return $order->items->contains(function ($item) use ($user) {
                return $item->product->vendor_id === $user->id;
            });
        }

        return false;
    }
}
