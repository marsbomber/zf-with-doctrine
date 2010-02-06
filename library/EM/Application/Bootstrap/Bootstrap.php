<?php
/**
 * Elink Media
 *
 * Custom application bootstrap class
 *
 */
class EM_Application_Bootstrap_Bootstrap
    extends Zend_Application_Bootstrap_BootstrapAbstract
{
    protected $_containerFactory = null;

    /**
     * Constructor
     *
     * Invoke setContainerFactory, set _coantainerFactory if factory is configurated
     * Ensure FrontController resource is registered
     *
     * @param  Zend_Application|Zend_Application_Bootstrap_Bootstrapper $application
     * @return void
     */
    public function __construct($application)
    {
        $this->setContainerFactory($application->getOptions());
        
        parent::__construct($application);
        if (!$this->hasPluginResource('FrontController')) {
            $this->registerPluginResource('FrontController');
        }
    }

    /**
     * Run the application
     *
     * Checks to see that we have a default controller directory. If not, an
     * exception is thrown.
     *
     * If so, it registers the bootstrap with the 'bootstrap' parameter of
     * the front controller, and dispatches the front controller.
     *
     * @return void
     * @throws Zend_Application_Bootstrap_Exception
     */
    public function run()
    {
        $front   = $this->getResource('FrontController');
        $default = $front->getDefaultModule();
        if (null === $front->getControllerDirectory($default)) {
            throw new Zend_Application_Bootstrap_Exception(
                'No default controller directory registered with front controller'
            );
        }

        $front->setParam('bootstrap', $this);
        $front->dispatch();
    }
    
    protected function setContainerFactory(array $options)
    {
        if (isset($options['factory'])) {
            $factory = $options['factory'];
            $this->_containerFactory = new $factory($options);
        }
    }

    public function getContainer()
    {
        if (null === $this->_container) {
            if (empty($this->_containerFactory))
                $this->_container = parent::getContainer();
            else
                $this->_container = $this->_containerFactory->makeContainer();
        }
        
        return $this->_container;
    }
}
?>
