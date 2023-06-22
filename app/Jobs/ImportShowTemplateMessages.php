<?php

namespace App\Jobs;

use App\Models\ShowTemplate;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportShowTemplateMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $rawData,
        protected ShowTemplate $model,
        protected User $user,
    ) {
        $this->rawData = collect($rawData);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get all Existing Users

        // Map the data.

        // Insert the data.
    }
}
