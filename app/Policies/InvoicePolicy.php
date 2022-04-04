<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    //this method is called before any other method below,
    //if return true, other policy methods are intercepted
    public function before(User $user)
    {
        if ($user->isAdmin()) return true;

        return null;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->isCustomer();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Invoice $invoice)
    {
        return $user->email === $invoice->customer->email;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Invoice $invoice)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Invoice $invoice)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Invoice $invoice)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Invoice $invoice
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Invoice $invoice)
    {
        //
    }
}
