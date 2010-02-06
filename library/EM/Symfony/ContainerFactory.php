<?php

class EM_Symfony_ContainerFactory
{

    /**
     * Contains the options for the factory.
     * @var array
     */
    private $_options;

    private function flattenParameters($params, $key = null)
    {
        if(is_array($params)) {
            $result = array();
            foreach($params as $subKey => $value) {
                $newKey = empty($key) ? $subKey : "$key.$subKey";
                if(is_array($value)) {
                    $value = $this->flattenParameters($value, $newKey);
                    $result = array_merge($result, $value);
                }
                else {
                    $result[$newKey] = $value;
                }
            }
        }
        else {
            $result = $params;
        }
        return $result;
    }

    private function getParameters()
    {
        if(isset($this->_options['parameters'])) {
            return $this->flattenParameters($this->_options['parameters']);
        }
        return null;
    }

    /**
     * Construct a factory that created containers for Zend_Bootstrap
     * based on the Symfony DI framework component.
     *
     * @param array $options Options for factory
     */
    public function __construct(array $options = array())
    {
        $this->_options = $options;
        /**
         * Must manually require here because the autoloader does not
         * (yet) know how to find this.
         */
        require_once 'Symfony/dependency_injection/sfServiceContainerAutoloader.php';
        sfServiceContainerAutoloader::register();
    }

    /**
     * Create a container object.
     * The configuration may be specified in the 'config_file'
     * component of the options. If not specified, an empty container
     * will be generated.
     * If 'dump_file' is specified and we did not generate an empty
     * container, the specification is compiled into a PHP file that
     * can later be loaded instead of the configuration (performance).
     *
     * @return sfServiceContainerInterface The container
     */
    public function makeContainer()
    {
        if(!isset($this->_options['config_file'])) {
            return new sfServiceContainer();
        }

        /**
         * Attempt to load the generated PHP file, if defined
         * and exists. If succesful, the class we need should be
         * defined, so create and return it.
         */
        $file = $this->_options['config_file'];
        $class = isset($this->_options['class']) ? $this->_options['class'] : 'Container';
        if(isset($this->_options['dump_file'])) {
            $dumpFile = $this->_options['dump_file'];
            if(file_exists($dumpFile)) {
                require_once $dumpFile;
                return new $class();
            }
        }

        /**
         * Create a builder to which we attach a loader so
         * we can load the configuration file.
         */
        $parameters = $this->getParameters();
        $sc = new sfServiceContainerBuilder($parameters);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        switch($ext) {
            case 'xml':
                $loader = new sfServiceContainerLoaderFileXml($sc);
                break;
            case 'init':
                $loader = new sfServiceContainerLoaderFileIni($sc);
                break;
            case 'yaml':
                $loader = new sfServiceContainerLoaderFileYaml($sc);
                break;
            default:
                throw new Exception(
                "No loader available for extension '$ext'");
                break;
        }
        $loader->load($file);

        /**
         * If a dump file was specified, make the dump
         * so that it can be loaded in the future.
         */
        if(isset($dumpFile)) {
            $dumper = new sfServiceContainerDumperPhp($sc);
            file_put_contents(
                $dumpFile,
                $dumper->dump(
                    array('class' => $class)
                )
            );
        }
        return $sc;
    }
}
