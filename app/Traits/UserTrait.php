<?php

namespace App\Traits;
use App\User;

trait UserTrait
{
    public function isSuperAdmin()
    {
        return $this->user_type_id == superAdminUserTypeId();
    }

    public function isSupervisor()
    {
        return $this->user_type_id == supervisorUserTypeId();
    }

    public function isProvider()
    {
        return $this->user_type_id == providerUserTypeId();
    }

    public function isParticipant()
    {
        return $this->user_type_id == participantUserTypeId();
    }

    public function isOrganizationAdmin()
    {
        return $this->user_type_id == organizationAdminUserTypeId();
    }

    public function getProviders()
    {
        $providers = [];

        if ($this->isSuperAdmin()) {
            $providers = User::whereUserTypeId(providerUserTypeId())->orderByName()->get();
        } else if ($this->isSupervisor()) {
            $providers = $this->supervisorProviders()->orderByName()->get();
        } else if ($this->isProvider()) {
            $providers = User::whereId($this->id)->get();
        } else if ($this->isOrganizationAdmin()) {
            $providers = User::whereUserTypeId(providerUserTypeId())->whereOrganizationId($this->organization_id)->orderByName()->get();
        } else if ($this->isParticipant()) {
            $providers = User::whereUserTypeId(providerUserTypeId())->whereId($this->userDetail->provider_id)->orderByName()->get();
        }
        return $providers;
    }
}