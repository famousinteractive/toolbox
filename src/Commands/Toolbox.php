<?php

namespace Jeremy379\Toolbox\Commands;
use Jeremy379\Toolbox\Library\EnvFile;
use Illuminate\Console\Command;

class Toolbox extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jeremy379:toolbox {--config=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install library in the project';

    /**
     * Create a new command instance.
     *
     * @return $this
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
        $config = $this->getLibConfig( $this->option('config'));

        $this->info('-------------------- WELCOME --------------------');
        $this->info('-------------- FAMOUS LIB INSTALLER --------------');
        $this->info('>> Which library do you want to install ? ');

        foreach($config as $libName => $data) {

            $this->info( ' - '. $libName . ' ( ' . $data['description'] . ')' );
        }

        $libKey = $this->ask('>> Enter the name of the lib to install : ');

        $lib = isset($config[$libKey]) ? $config[$libKey] : null;

        if(!is_null($lib) && !empty($lib)) {

            $targetPath = $this->ask('Where do you want to write the library ? ', app_path('Libraries/' . ucfirst($libKey)) );

            if(!is_dir($targetPath)) {
                $this->warn('Directory ' . $targetPath . ' don\'t exists');
                if($this->confirm('Do you want to create it ? ')) {
                    mkdir($targetPath, 0755, true);
                } else {
                    $this->warn('We can\'t install the lib to an unexisting directory');
                    die('Exit');
                }
            }

            //Get the files
            $this->info('Download from '. $lib['path'] .'...');
            $this->getLibraries( $targetPath .'/tmp.zip', $lib['path']);

            $this->checkEnvFile($lib['configkeys']);

            exec('cd '.$targetPath.' && unzip ' . $targetPath.'/tmp.zip -d . && unlink ' . $targetPath .'/tmp.zip && mv *-master/* . && rm -rf *-master');

           $this->info('Library copied !');

            if(isset($lib['post-install'])) {
                $this->info( $lib['post-install']);
            }

        }

    }

    protected function getLibConfig($configFile) {

        if(is_null($configFile)) {
            $configFile = file_get_contents( __DIR__ .'/../.lib_config.json');
        } else {
            $configFile = file_get_contents(  $configFile);
        }

        return json_decode($configFile, true);
    }

    protected function checkEnvFile($envKeys) {

        if (!EnvFile::isFileExists()) {
            if ($this->confirm('The .env file don\'t exists, do you want to create one ? ')) {
                EnvFile::createEnvFile();
            }
        }

        if (EnvFile::isFileExists()) {
            foreach($envKeys as $key) {
                if(! EnvFile::isKeyExistsAndFilled( $key )) {
                    $this->warn('The key ' . $key .' is not in your .env');
                    EnvFile::setKey($key, $this->ask('Enter the value for ' . $key, 0));
                }
            }
        }
    }

    protected function getLibraries($target, $source) {
        file_put_contents( $target, file_get_contents(  $source ));
    }
}