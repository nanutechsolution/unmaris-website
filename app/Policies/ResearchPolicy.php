<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Research;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResearchPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Research');
    }

    public function view(AuthUser $authUser, Research $research): bool
    {
        return $authUser->can('View:Research');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Research');
    }

    public function update(AuthUser $authUser, Research $research): bool
    {
        return $authUser->can('Update:Research');
    }

    public function delete(AuthUser $authUser, Research $research): bool
    {
        return $authUser->can('Delete:Research');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Research');
    }

    public function restore(AuthUser $authUser, Research $research): bool
    {
        return $authUser->can('Restore:Research');
    }

    public function forceDelete(AuthUser $authUser, Research $research): bool
    {
        return $authUser->can('ForceDelete:Research');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Research');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Research');
    }

    public function replicate(AuthUser $authUser, Research $research): bool
    {
        return $authUser->can('Replicate:Research');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Research');
    }

}