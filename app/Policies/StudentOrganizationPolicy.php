<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\StudentOrganization;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentOrganizationPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:StudentOrganization');
    }

    public function view(AuthUser $authUser, StudentOrganization $studentOrganization): bool
    {
        return $authUser->can('View:StudentOrganization');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:StudentOrganization');
    }

    public function update(AuthUser $authUser, StudentOrganization $studentOrganization): bool
    {
        return $authUser->can('Update:StudentOrganization');
    }

    public function delete(AuthUser $authUser, StudentOrganization $studentOrganization): bool
    {
        return $authUser->can('Delete:StudentOrganization');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:StudentOrganization');
    }

    public function restore(AuthUser $authUser, StudentOrganization $studentOrganization): bool
    {
        return $authUser->can('Restore:StudentOrganization');
    }

    public function forceDelete(AuthUser $authUser, StudentOrganization $studentOrganization): bool
    {
        return $authUser->can('ForceDelete:StudentOrganization');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:StudentOrganization');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:StudentOrganization');
    }

    public function replicate(AuthUser $authUser, StudentOrganization $studentOrganization): bool
    {
        return $authUser->can('Replicate:StudentOrganization');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:StudentOrganization');
    }

}