<?php namespace WebReinvent\VaahCms\Modules;


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
        foreach ($this->files->directories($this->getPath()) as $module)
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

        $module_settings_path = $directory."\settings.json";

        if (!\File::exists($module_settings_path)) {
            return null;
        }

        $file = \File::get($module_settings_path);
        $module_settings_path = json_decode($file);
        $settings = (array)$module_settings_path;

        return $settings;
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