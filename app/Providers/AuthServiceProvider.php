<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\Company;
use App\Models\SalesFunnel;
use App\Policies\ContactPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\SalesFunnelPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Contact::class      => ContactPolicy::class,
        Company::class      => CompanyPolicy::class,
        SalesFunnel::class  => SalesFunnelPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
