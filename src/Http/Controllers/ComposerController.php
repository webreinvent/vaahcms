<?php

namespace WebReinvent\VaahCms\Http\Controllers;

use Composer\Console\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Process\Process;


use Symfony\Component\Console\Output\BufferedOutput as Output;
use Symfony\Component\Console\Output\OutputInterface;

class ComposerController extends Controller
{

    public $theme;

    //----------------------------------------------------------
    public function __construct()
    {
        ini_set('memory_limit', '2G');
        set_time_limit(300); // 5 minutes execution
        $this->theme = vh_get_backend_theme();
    }

    //----------------------------------------------------------
    public function commands($command)
    {

        header('Content-Type: text/html; charset=utf-8');

        $allowedCommands = [
            'update',
            'install',
            'dump-autoload',
            'dump-autoload -o',
        ];

        $cmdRaw = $_GET['cmd'];

        if ( !in_array($cmdRaw, $allowedCommands) ) {
            exit;
        }

        $path = base_path() . '/vendor/bin/composer';

        putenv('COMPOSER_HOME=' . $path);

        $cmdRawArray = explode(' ', $cmdRaw);
        $inputArray = ['command' => array_shift($cmdRawArray) ] + $cmdRawArray;

        $isDebug = isset($_GET['debug']) ? true : false;


        $output = new Output(
            $isDebug ? OutputInterface::VERBOSITY_DEBUG : OutputInterface::VERBOSITY_NORMAL
        );


        $input = new ArrayInput( $inputArray );
        $application = new Application();
        $application->setAutoExit(false);
        $application->run($input, $output);


        echo '<pre>' . $output->fetch() . '</pre>';




    }

    //----------------------------------------------------------
    //----------------------------------------------------------


}
