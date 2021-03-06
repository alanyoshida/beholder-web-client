<?php

use BeholderWebClient\Eyes\Db\DbStatus as Status;

require_once '/var/www/vendor/autoload.php';

class PostgreSQLConnectTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {

    }

    protected function _after()
    {
    }

    public function testInvalidConnect() {

      $eyeName = 'PostgreSQLConnect';

      $conf = [
        'eyes' => [
            $eyeName => [
              'type' => 'Db\PostgreSQL',
              'host' => 'beholder-test-postgresql',
              'user' => 'root',
              'password' => 'initial123456',
              'dbname' => 'beholder_test',
              'port' => '5432'
            ]
        ]
      ];

      $beholder = new BeholderWebClient\Observer();
      $beholder->setConf($conf);
      $beholder->run();

      $result = $beholder->getResult();

      $message = substr($result[$eyeName]['message'],0,strlen(Status::COULD_NOT_CONNECT_TO_SGBD));

      $this->assertArrayHasKey($eyeName, $result);
      $this->assertEquals(Status::COULD_NOT_CONNECT_TO_SGBD_NUMBER, $result[$eyeName]['status']);
      $this->assertEquals(Status::COULD_NOT_CONNECT_TO_SGBD, $message);

    }

    public function testValidConnect() {

      $eyeName = 'PostgreSQLConnect';

      $conf = [
        'eyes' => [
            $eyeName => [
              'type' => 'Db\PostgreSQL',
              'host' => 'beholder-test-postgresql',
              'user' => 'root',
              'password' => 'initial1234',
              'dbname' => 'beholder_test',
              'port' => '5432'
            ]
        ]
      ];

      $beholder = new BeholderWebClient\Observer();
      $beholder->setConf($conf);
      $beholder->run();

      $result = $beholder->getResult();

      $this->assertArrayHasKey($eyeName, $result);
      $this->assertEquals(Status::OK_NUMBER, $result[$eyeName]['status']);
      $this->assertEquals(Status::OK, $result[$eyeName]['message']);

    }

}
