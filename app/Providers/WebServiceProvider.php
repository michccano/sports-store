<?php

namespace App\Providers;

use App\Models\MakeupToken;
use App\Repository\Base\BaseRepository;
use App\Repository\Base\IBaseRepository;
use App\Repository\BonusToken\BonusTokenRepository;
use App\Repository\BonusToken\IBonusTokenRepository;
use App\Repository\Category\CategoryRepository;
use App\Repository\Category\ICategoryRepository;
use App\Repository\MakeupToken\IMakeupTokenRepository;
use App\Repository\Product\IProductRepository;
use App\Repository\Product\ProductRepository;
use App\Repository\User\IUserRepository;
use App\Repository\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class WebServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IBaseRepository::class,BaseRepository::class);
        $this->app->bind(IUserRepository::class,UserRepository::class);
        $this->app->bind(IProductRepository::class,ProductRepository::class);
        $this->app->bind(ICategoryRepository::class,CategoryRepository::class);
        $this->app->bind(IBonusTokenRepository::class,BonusTokenRepository::class);
        $this->app->bind(IMakeupTokenRepository::class,MakeupToken::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
