<?php 
namespace Buerxiaojie\Console;

use Illuminate\Console\GeneratorCommand;

/**
* 
*/
class OauthServerCommand extends GeneratorCommand
{
	
	/**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:oauthServer {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate a oauth server for system';

    protected $type = 'OauthServer';

    protected function getStub()
    {
        return __DIR__.'/stubs/server.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Oauth\Servers';
    }
}