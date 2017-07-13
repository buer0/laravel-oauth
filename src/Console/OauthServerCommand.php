<?php 
namespace Buerxiaojie\Console;

use Illuminate\Console\Command;

/**
* 
*/
class OauthServerCommand extends Command
{
	
	/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:oauthServer
                            {servername}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate a oauth server for system';

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
        $name = $this->arguments();

    }
}