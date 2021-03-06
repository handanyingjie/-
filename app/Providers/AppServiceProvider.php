<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Taggable;
use App\Observes\PostObserver;
use App\Observes\TagObserver;
use Carbon\Carbon;
use Illuminate\Cache\TaggableStore;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use App\Models\Tag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Post::observe(PostObserver::class);
        Tag::observe(TagObserver::class);

//        Gate::define('create-post', function ($user) {
//            return $user->hasAccess('create-post');
//        });
//        Gate::define('update-post', function ($user, Post $post) {
//            return $user->hasAccess('update-post') or $user->id == $post->user_id;
//        });
//        Gate::define('publish-post', function ($user, Post $post) {
//            return $user->hasAccess('publish-post') or $user->id == $post->user_id;
//        });
//        Gate::define('delete-post', function ($user, Post $post) {
//            return $user->hasAccess('delete-post') or $user->id == $post->user_id;
//        });
//        Gate::define('see-all-drafts', function ($user) {
//            return $user->inRole('editor');
//        });

        //本地化Carbon
        Carbon::setLocale('zh');

        //打印SQL语句
        DB::listen(function ($query){
            $str = preg_replace("/\?/","%s",$query->sql);
            $sql = vsprintf($str,$query->bindings);
            Log::info($sql);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
