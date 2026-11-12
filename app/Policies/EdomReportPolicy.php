<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\EdomReport;
use Illuminate\Auth\Access\HandlesAuthorization;

class EdomReportPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:EdomReport');
    }

    public function view(AuthUser $authUser, EdomReport $edomReport): bool
    {
        return $authUser->can('View:EdomReport');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:EdomReport');
    }

    public function update(AuthUser $authUser, EdomReport $edomReport): bool
    {
        return $authUser->can('Update:EdomReport');
    }

    public function delete(AuthUser $authUser, EdomReport $edomReport): bool
    {
        return $authUser->can('Delete:EdomReport');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:EdomReport');
    }

    public function restore(AuthUser $authUser, EdomReport $edomReport): bool
    {
        return $authUser->can('Restore:EdomReport');
    }

    public function forceDelete(AuthUser $authUser, EdomReport $edomReport): bool
    {
        return $authUser->can('ForceDelete:EdomReport');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:EdomReport');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:EdomReport');
    }

    public function replicate(AuthUser $authUser, EdomReport $edomReport): bool
    {
        return $authUser->can('Replicate:EdomReport');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:EdomReport');
    }

}