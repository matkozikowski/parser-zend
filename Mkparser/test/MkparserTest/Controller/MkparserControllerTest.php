<?php
namespace Mkparser\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class MkparserControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;

    public function setUp()
    {
        $this->setApplicationConfig(
            include '/xampp/htdocs/www/testweb/project-parser/config/application.config.php'
        );
        parent::setUp();
    }

  public function testIndexActionCanBeAccessed()
  {
      $this->dispatch('/mkparser');
      $this->assertResponseStatusCode(200);

      $this->assertModuleName('Mkparser');
      $this->assertControllerName('Mkparser\Controller\Mkparser');
      $this->assertControllerClass('MkparserController');
      $this->assertMatchedRouteName('mkparser');
  }

  public function testSearchActionCanBeAccessed()
  {
      $this->dispatch('/mkparser');
      $this->assertResponseStatusCode(200);

      $this->assertModuleName('Mkparser');
      $this->assertControllerName('Mkparser\Controller\Mkparser');
      $this->assertControllerClass('MkparserController');
      $this->assertMatchedRouteName('mkparser');
  }

  public function testDownloadActionCanBeAccessed()
  {
      $this->dispatch('/mkparser');
      $this->assertResponseStatusCode(200);

      $this->assertModuleName('Mkparser');
      $this->assertControllerName('Mkparser\Controller\Mkparser');
      $this->assertControllerClass('MkparserController');
      $this->assertMatchedRouteName('mkparser');
  }

}
