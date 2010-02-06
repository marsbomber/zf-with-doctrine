# Zend Framework 1.9.5, Doctrine 1.2 and ZFDebug

## The application structure is highly inspired by [Eric Leclerc's zfdebugdoctrine project](http://github.com/danceric/) and [Jon Lebensold's video cast on "Writing Doctrine Unit Tests with Zend_Test"](http://www.zendcasts.com/writing-doctrine-unit-tests-with-zend_test/2009/12/).

To try this demo project, please follow the instruction below by [Eric Leclerc](http://github.com/danceric/)

You need to put these libs in the `library` folder (or in your php include path)

- [Zend Framework](http://framework.zend.com/) 1.9.x
- [ZFDebug](http://code.google.com/p/zfdebug/) 1.5.x
- [Doctrine](http://www.doctrine-project.org/) (Doctrine AND vendor folder) 1.2.x

It should look like:

    library/
      Danceric/
      Doctrine/
      vendor/
      ZFDebug/
      Zend/

Edit: This sample application now incorporates more stuff

- Agavi style error handler page
- [Symfony Dependency Injection Container](http://components.symfony-project.org/dependency-injection/)

More details from my blog posts

- [ZF, Doctrine and Unit Tests](http://blog.elinkmedia.net.au/2009/12/03/zf-doctrine-and-unit-tests/)
- [Zend Framework integrate with Symfony DI Container](http://blog.elinkmedia.net.au/2010/02/06/zend-framework-integrate-with-symfony-di-container)
