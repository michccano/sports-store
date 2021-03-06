<?php

namespace App\Providers;

use App\Models\MakeupToken;
use App\Models\User;
use App\Repository\Base\BaseRepository;
use App\Repository\Base\IBaseRepository;
use App\Repository\BonusToken\BonusTokenRepository;
use App\Repository\BonusToken\IBonusTokenRepository;
use App\Repository\Category\CategoryRepository;
use App\Repository\Category\ICategoryRepository;
use App\Repository\MakeupToken\IMakeupTokenRepository;
use App\Repository\MakeupToken\MakeupTokenRepository;
use App\Repository\Order\IOrderRepository;
use App\Repository\Order\OrderRepository;
use App\Repository\Product\IProductRepository;
use App\Repository\Product\ProductRepository;
use App\Repository\PurchaseToken\IPurchaseTokenRepository;
use App\Repository\PurchaseToken\PurchaseTokenRepository;
use App\Repository\User\IUserRepository;
use App\Repository\User\UserRepository;
use App\Services\BonusToken\BonusTokenServiceService;
use App\Services\BonusToken\IBonusTokenService;
use App\Services\Checkout\CheckoutService;
use App\Services\Checkout\ICheckoutService;
use App\Services\MakeupToken\IMakeupTokenService;
use App\Services\MakeupToken\MakeupTokenService;
use App\Services\Order\IOrderService;
use App\Services\Order\OrderService;
use App\Services\Payment\IPaymentService;
use App\Services\Payment\PaymentService;
use App\Services\PurchaseToken\IPurchaseTokenService;
use App\Services\PurchaseToken\PurchaseTokenService;
use App\Services\User\IUserService;
use App\Services\User\UserService;
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
        $this->app->bind(IPurchaseTokenRepository::class,PurchaseTokenRepository::class);
        $this->app->bind(IBonusTokenRepository::class,BonusTokenRepository::class);
        $this->app->bind(IMakeupTokenRepository::class,MakeupTokenRepository::class);
        $this->app->bind(ICheckoutService::class,CheckoutService::class);
        $this->app->bind(IUserService::class,UserService::class);
        $this->app->bind(IPurchaseTokenService::class,PurchaseTokenService::class);
        $this->app->bind(IBonusTokenService::class,BonusTokenServiceService::class);
        $this->app->bind(IOrderRepository::class,OrderRepository::class);
        $this->app->bind(IOrderService::class,OrderService::class);
        $this->app->bind(IMakeupTokenService::class,MakeupTokenService::class);
        $this->app->bind(IPaymentService::class,PaymentService::class);
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
