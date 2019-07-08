<?php namespace WebReinvent\VaahCms\Loaders;

use Illuminate\Filesystem\Filesystem;

class ThemesLoader {

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
    protected $list = [];

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
    public function findList()
    {

        foreach ($this->files->directories($this->getPath()) as $module)
        {

            if (is_null($class = $this->initTheme($module)))
            {
                continue;
            }

            $this->list[] = $class;
        }

        return $this->list;
    }


    /**
     * @param string $directory
     * @return BasePluginContainer|null
     */
    protected function initTheme($directory)
    {

        $settings_path = $directory."\settings.json";

        if (!\File::exists($settings_path)) {
            return null;
        }

        $file = \File::get($settings_path);
        $settings_path = json_decode($file);
        $settings = (array)$settings_path;

        return $settings;
    }


}