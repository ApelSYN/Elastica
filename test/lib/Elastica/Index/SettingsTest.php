<?php
require_once dirname(__FILE__) . '/../../../bootstrap.php';

class Elastica_Index_SettingsTest extends PHPUnit_Framework_TestCase
{
	public function setUp() {
	}

	public function tearDown() { }

	public function testGet() {
		$indexName = 'elasticatest';

		$client = new Elastica_Client();
		$index = $client->getIndex($indexName);
		$index->create(array(), true);
		$index->refresh();
		$settings = $index->getSettings();

		$this->assertInternalType('array', $settings->get());
		$this->assertNotNull($settings->get('index.number_of_replicas'));
		$this->assertNotNull($settings->get('index.number_of_shards'));
		$this->assertNull($settings->get('kjqwerjlqwer'));
	}

	public function testSetNumberOfReplicas() {
		$indexName = 'test';

		$client = new Elastica_Client();
		$index = $client->getIndex($indexName);
		$index->create(array(), true);
		$settings = $index->getSettings();

		$settings->setNumberOfReplicas(2);
		$index->refresh();
		$this->assertEquals(2, $settings->get('index.number_of_replicas'));

		$settings->setNumberOfReplicas(3);
		$index->refresh();
		$this->assertEquals(3, $settings->get('index.number_of_replicas'));
	}

	public function testSetNumberOfShards() {
		$indexName = 'test';

		$client = new Elastica_Client();
		$index = $client->getIndex($indexName);
		$index->create(array(), true);
		$settings = $index->getSettings();

		$settings->setNumberOfShards(2);
		$index->refresh();
		$this->assertEquals(2, $settings->get('index.number_of_shards'));

		$settings->setNumberOfShards(3);
		$index->refresh();
		$this->assertEquals(3, $settings->get('index.number_of_shards'));
	}

	public function testSetRefreshInterval() {
		$indexName = 'test';

		$client = new Elastica_Client();
		$index = $client->getIndex($indexName);
		$index->create(array(), true);


		$settings = $index->getSettings();

		$settings->setRefreshInterval('2s');
		$index->refresh();
		$this->assertEquals('2s', $settings->get('index.refresh_interval'));

		$settings->setRefreshInterval('5s');
		$index->refresh();
		$this->assertEquals('5s', $settings->get('index.refresh_interval'));
	}
}