<?php 

/**
 * ErrorController
 * 
 * @author     Philip Iezzi
 * @copyright  Authors
 * @copyright  Copyright (c) 2007-2009 Onlime Webhosting, www.onlime.ch
 */
class ErrorController extends Zend_Controller_Action 
{ 
    /**
     * errorAction() is the action that will be called by the "ErrorHandler" 
     * plugin.  When an error/exception has been encountered
     * in a ZF MVC application (assuming the ErrorHandler has not been disabled
     * in your bootstrap) - the Errorhandler will set the next dispatchable 
     * action to come here.  This is the "default" module, "error" controller, 
     * specifically, the "error" action.  These options are configurable, see 
     * {@link http://framework.zend.com/manual/en/zend.controller.plugins.html#zend.controller.plugins.standard.errorhandler the docs on the ErrorHandler Plugin}
     *
     * @return void
     */
    public function errorAction() 
    {
        // Disable ZFDebug plugin
        $frontController = Zend_Controller_Front::getInstance();
        $frontController->unregisterPlugin('ZFDebug_Controller_Plugin_Debug');
        
        // Ensure the default view suffix is used so we always return good 
        // content
        $this->_helper->viewRenderer->setViewSuffix('phtml');
        
        // use shiny exception handler view, if configured as:
        // resources.frontController.errorview = shiny
        if ($this->getInvokeArg('errorview') && $this->getInvokeArg('errorview') != 'error') {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer($this->getInvokeArg('errorview'));
        }

        // Grab the error object from the request
        $errors = $this->_getParam('error_handler'); 

        // $errors will be an object set as a parameter of the request object, 
        // type is a property
        switch ($errors->type) { 
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER: 
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION: 

                // 404 error -- controller or action not found 
                $this->getResponse()->setHttpResponseCode(404); 
                $this->view->message = '404 Page not found'; 
                break; 
            default: 
                // application error 
                $this->getResponse()->setHttpResponseCode(500); 
                $this->view->message = '500 Application error'; 
                break; 
        } 

        // pass the environment to the view script so we can conditionally 
        // display more/less information
        $this->view->env       = $this->getInvokeArg('env'); 
        
        // pass the actual exception object to the view
        $this->view->exception = $errors->exception; 
        
        // pass the request to the view
        $this->view->request   = $errors->request; 
    } 
}
