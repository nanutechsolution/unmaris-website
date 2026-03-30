<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\PopupPromo;
use Illuminate\Auth\Access\HandlesAuthorization;

class PopupPromoPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:PopupPromo');
    }

    public function view(AuthUser $authUser, PopupPromo $popupPromo): bool
    {
        return $authUser->can('View:PopupPromo');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:PopupPromo');
    }

    public function update(AuthUser $authUser, PopupPromo $popupPromo): bool
    {
        return $authUser->can('Update:PopupPromo');
    }

    public function delete(AuthUser $authUser, PopupPromo $popupPromo): bool
    {
        return $authUser->can('Delete:PopupPromo');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:PopupPromo');
    }

    public function restore(AuthUser $authUser, PopupPromo $popupPromo): bool
    {
        return $authUser->can('Restore:PopupPromo');
    }

    public function forceDelete(AuthUser $authUser, PopupPromo $popupPromo): bool
    {
        return $authUser->can('ForceDelete:PopupPromo');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:PopupPromo');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:PopupPromo');
    }

    public function replicate(AuthUser $authUser, PopupPromo $popupPromo): bool
    {
        return $authUser->can('Replicate:PopupPromo');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:PopupPromo');
    }

}