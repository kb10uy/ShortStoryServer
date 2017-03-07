<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;

use App\Post;
use Redis;
use Log;

class SyncPostInfoToDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $updateLeastMinutes = 60;

    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $now = Carbon::now();
        $last = Carbon::parse(Redis::get(config('database.keys.post-index-refreshed_at')) ?: '1970-01-01 00:00:00');
        if ($now->diffInMinutes($last) < $this->updateLeastMinutes) return;
        
        $posts = Post::all();
        foreach($posts as $post) $post->applyCachedInfo()->save();

        Log::info('Post info updated at' . $now);
        Redis::set(config('database.keys.post-index-refreshed_at'), $now->toDateTimeString()); 
    }
}
