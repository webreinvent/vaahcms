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

        foreach ($this->files->directories($this->getPath()) as $item)
        {

            if (is_null($class = $this->initTheme($item)))
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

        $config_path = $directory.'/Config/config.php';

        $config = require $config_path;

        return $config;
    }


}
