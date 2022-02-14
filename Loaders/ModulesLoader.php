<?php namespace WebReinvent\VaahCms\Loaders;


use Illuminate\Filesystem\Filesystem;

class ModulesLoader {

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;
    /**
     * @var string
     */
    protected $path;

    /**
     * @var bool
     */
    protected $init = false;

    /**
     * @var array
     */
    protected $activated = [];

    /**
     * @var array
     */
    protected $findModules = [];

    /**
     * @param Filesystem $files
     * @param string $path
     */

    public function __construct(Filesystem $files, $path=null)
    {
        $this->path = $path;
        $this->files = $files;
    }



    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }



    /**
     * @return array
     */
    public function getActivated()
    {
        return $this->activated;
    }


    /**
     * @return array
     */
    public function findModules()
    {

        $arr = $this->files->directories($this->getPath());

        foreach ($arr as $key => $module)
        {

            /*
             * This will handle windows and linux OS
             */
            if (strpos($module, 'Modules'.DIRECTORY_SEPARATOR.'Cms') !== false) {

                $temp = $module;
                unset($arr[$key]);

                array_push($arr, $temp);

            }

        }

        foreach ($arr as $module)
        {

            if (is_null($class = $this->initModule($module)))
            {
                continue;
            }

            $this->findModules[] = $class;
        }

        return $this->findModules;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isActivated($name)
    {
        foreach($this->getActivated() as $module)
        {
            if ($module->getName() == $name)
            {
                return true;
            }
        }

        return false;
    }



    /**
     * @param string $directory
     * @return BasePluginContainer|null
     */
    protected function initModule($directory)
    {

        $config_path = $directory.'/Config/config.php';

        $config = require $config_path;

        return $config;
    }


    /**
     * @param string $key
     * @return bool
     */
    protected function moduleExists($key)
    {
        return $this->files->isDirectory($this->path . DIRECTORY_SEPARATOR . $key);
    }
}
