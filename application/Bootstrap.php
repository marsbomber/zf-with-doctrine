<?php

class Bootstrap extends EM_Application_Bootstrap_Bootstrap
{
    /**
     * Setup include file cache to increase performance
     *
     * @return void
     * @author Jim Li
     */
    protected function _initFileInlcudeCache()
    {
        $classFileIncCacheOptions = $this->getOption('cache');
        $classFileIncCache = $classFileIncCacheOptions['classFileIncludeCache'];

        if(file_exists($classFileIncCache)) {
            include_once $classFileIncCache;
        }
        Zend_Loader_PluginLoader::setIncludeFileCache($classFileIncCache);
    }

	/**
     * Autoload stuff from the default module (which is not in a `modules` subfolder in this project)
     * (Api_, Form_, Model_, Model_DbTable, Plugin_)
     * */
    protected function _initAutoload()
    {
        $moduleLoader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => APPLICATION_PATH));

        return $moduleLoader;
    }

    public function _initDoctrine()
    {
        // Autoload doctrine
        $this->getApplication()->getAutoloader()
                               ->pushAutoloader(array('Doctrine', 'autoload'));

        $manager = Doctrine_Manager::getInstance();

        // Enable Doctrine DQL callbacks, enables SoftDelete behavior
        $manager->setAttribute(Doctrine_Core::ATTR_USE_DQL_CALLBACKS, true);

        // Set models loading style
        $manager->setAttribute(Doctrine_Core::ATTR_MODEL_LOADING, Doctrine_Core::MODEL_LOADING_PEAR);

        // Enable attr validation
        $manager->setAttribute(Doctrine_Core::ATTR_VALIDATE, Doctrine_Core::VALIDATE_ALL);

        // Disable attr overwrite issue
        // http://trac.doctrine-project.org/ticket/990
        $manager->setAttribute(Doctrine::ATTR_HYDRATE_OVERWRITE, false);

        // Creating named connection
        $doctrineConfig = $this->getOption('doctrine');
        $manager->openConnection($doctrineConfig['connection_string'], 'doctrine');
        $manager->getConnection('doctrine')->setCharset('utf8');

        return $manager;
    }
    
    /**
     * Initialize the ZFDebug Bar
     */
    protected function _initZFDebug()
    {
        $zfdebugConfig = $this->getOption('zfdebug');

        if ($zfdebugConfig['enabled'] != 1) {
            return;
        }

        // Ensure Doctrine connection instance is present, and fetch it
        $this->bootstrap('Doctrine');
        $doctrine = $this->getResource('Doctrine');

		// not in the .ini because we don't always need it
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('ZFDebug_');

        $options = array(
            'plugins' => array('Variables',
                               'Danceric_Controller_Plugin_Debug_Plugin_Doctrine',
                               'File',
                               'Memory',
                               'Time',
                               'Exception'),
            //'jquery_path' => '/js/jquery-1.3.2.min.js'
            );
        $debug = new ZFDebug_Controller_Plugin_Debug($options);

        $this->bootstrap('frontController');
        $frontController = $this->getResource('frontController');
        $frontController->registerPlugin($debug);
    }

    protected function _initContainer()
    {
        return $this->getContainer();
    }
}

