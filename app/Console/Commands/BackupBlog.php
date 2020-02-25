<?php

namespace App\Console\Commands;

use App\Helper\BlogHelper;
use App\Helper\MainHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BackupBlog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:blog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup Blog';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mainHelper = new MainHelper();
        $blogHelper = new BlogHelper();
        $dataContexts = DB::table("table_install_infor")->select("context")->get();
        foreach ($dataContexts as $dataContext) {
            $param = $mainHelper->getInfFromContext($dataContext->context);
            $blogHelper->deleteOldData($param);
            $blogHelper->backUp($param);
        }
        return;
    }
}
