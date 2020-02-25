<?php

namespace App\Jobs;

use App\Helper\MainHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */

    private $param;
    private $mainHelper;

    public function __construct($param)
    {
        $this->param = $param;
        //
    }

    public function handle()
    {
        $this->mainHelper = new MainHelper();
        echo("aaaaaaaaaaaaaaaaaa");
        $this->mainHelper->backup($this->param);
    }
}
