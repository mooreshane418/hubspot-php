<?php

namespace SevenShores\Hubspot\Tests\integration\Resources;

use SevenShores\Hubspot\Http\Client;
use SevenShores\Hubspot\Resources\EcommerceBridge;

/**
 * Class EcommerceBridgeTest.
 *
 * @group ecommerceBridge
 *
 * @internal
 * @coversNothing
 */
class EcommerceBridgeTest extends \PHPUnit_Framework_TestCase
{
    const STORE_ID = 'ecommercebridge-test-store';
    
    /** @var EcommerceBridge */
    protected $resource;
    
    /**
     *
     * @var int $timestamp
     */
    protected $timestamp;

    public function setUp()
    {
        parent::setUp();
        $this->resource = new EcommerceBridge(new Client(['key' => getenv('HUBSPOT_TEST_API_KEY')]));
        sleep(1);
    }
    
    /** @test */
    public function upsertSettings()
    {
        $response = $this->resource->upsertSettings($this->getData());

        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /** @test */
    public function getSettings()
    {
        $response = $this->resource->getSettings();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('mappings', $response->toArray());
    }
    
    /** @test */
    public function createOrUpdateStore() {
        $response = $this->resource->createOrUpdateStore([
            'id' => static::STORE_ID,
            'label' => 'Ecommerce Bridge Test Store '.uniqid(),
            'adminUri' => 'https://ecommercebridge-test-store.myshopify.com'
        ]);
        
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /** @test */
    public function allStores()
    {
        $response = $this->resource->allStores();
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertGreaterThanOrEqual(1, count($response->getData()->results));
    }
    
    /** @test */
    public function getStore()
    {
        $response = $this->resource->getStore(static::STORE_ID);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains(static::STORE_ID, $response->toArray());
    }
    
    /** @test */
    public function sendSyncMessages()
    {
        $response = $this->resource->sendSyncMessages(
                static::STORE_ID,
                'CONTACT',
                [
                    [
                        'action' => 'UPSERT',
                        'changedAt' => $this->getTimestamp(),
                        'externalObjectId' => '12345',
                        'properties' => [
                            'firstname' => 'Jeff' . uniqid(),
                            'lastname' => 'David',
                            'customer_email' => 'test@example.com'
                        ]
                    ]
                ]
            );
        
        $this->assertEquals(204, $response->getStatusCode());
        sleep(1);
    }
    
    /** @test */
    public function getAllSyncErrorsAccount()
    {
        $response = $this->resource->getAllSyncErrorsAccount();
        var_dump($response->getData());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('results', $response->toArray());
    }
    
    /** @test */
    public function checkSyncStatus()
    {
        $response = $this->resource->checkSyncStatus(
                static::STORE_ID,
                'CONTACT',
                '12345'
            );
        
        $this->assertEquals(200, $response->getStatusCode());
    }
    
    /** @test */
    public function importData()
    {
        $response = $this->resource->importData(
                time(),
                1,
                [
                    [
                        'externalObjectId' => '123487878',
                        'properties' => [
                            'firstname' => 'Jeff' . uniqid(),
                            'phone_number' => '+375441234567',
                            'familyname' => 'David',
                            'customer_email' => 'test1@example.com',
                        ]
                    ]
                ],
                static::STORE_ID,
                'CONTACT'
            );
        
            //var_dump($response->getStatusCode(), $response->getReasonPhrase());
        $this->assertEquals(204, $response->getStatusCode());
    }
    
    /** @test */
    public function signalImportEnd()
    {
        $response = $this->resource->signalImportEnd(
                $this->getTimestamp(),
                1,
                1,
                static::STORE_ID,
                'DEAL'
            );
        
        $this->assertEquals(204, $response->getStatusCode());
    }

    /** @test */
    public function deleteSettings()
    {
        $response = $this->resource->deleteSettings();

        $this->assertEquals(204, $response->getStatusCode());
    }
    
    protected function getTimestamp()
    {
        if (is_null($this->timestamp)) {
            $this->timestamp = time();
        }
        
        return $this->timestamp;
    }


    protected function getData()
    {
        return [
            'enabled' => true,
            'importOnInstall' => true,
            'webhookUri' => null,
            'mappings' => [
                'CONTACT' => [
                    'properties' =>  [
                        [
                            'externalPropertyName' => 'firstname',
                            'hubspotPropertyName'  => 'firstname',
                            'dataType' => 'STRING',
                        ],
                        [
                            'externalPropertyName' => 'phone_number',
                            'hubspotPropertyName' => 'mobilephone',
                            'dataType' => 'STRING'
                        ],
                        [
                            'externalPropertyName' => 'familyname',
                            'hubspotPropertyName' => 'lastname',
                            'dataType' => 'STRING'
                        ],
                        [
                            'externalPropertyName' => 'customer_email',
                            'hubspotPropertyName' => 'email',
                            'dataType' => 'STRING'
                        ],
                    ]
                ],
                'DEAL' => [
                    'properties' =>  [
                        [
                            'externalPropertyName' => 'purchase_date',
                            'hubspotPropertyName' => 'closedate',
                            'dataType' => 'STRING'
                        ],
                        [
                            'externalPropertyName' => 'name',
                            'hubspotPropertyName' => 'dealname',
                            'dataType' => 'STRING'
                        ],
                        [
                            'externalPropertyName' => 'stage',
                            'hubspotPropertyName' => 'dealstage',
                            'dataType' => 'STRING'
                        ],
                        [
                            'externalPropertyName' => 'abandoned_cart_url',
                            'hubspotPropertyName' => 'ip__ecomm_bride__abandoned_cart_url',
                            'dataType' => 'STRING'
                        ]
                    ],
                ],
                'PRODUCT' => [
                    'properties' =>  [
                        [
                            'externalPropertyName' => 'product_name',
                            'hubspotPropertyName' => 'name',
                            'dataType' => 'STRING'
                        ],
                        [
                            'externalPropertyName' => 'product_description',
                            'hubspotPropertyName' => 'description',
                            'dataType' => 'STRING'
                        ],
                        [
                            'externalPropertyName' => 'price',
                            'hubspotPropertyName' => 'price',
                            'dataType' => 'NUMBER'
                        ]
                    ],
                ],
                'LINE_ITEM' => [
                    'properties' =>  [
                        [
                            'externalPropertyName' => 'discount_amount',
                            'hubspotPropertyName' => 'discount',
                            'dataType' => 'NUMBER'
                        ],
                        [
                            'externalPropertyName' => 'num_items',
                            'hubspotPropertyName' => 'quantity',
                            'dataType' => 'NUMBER'
                        ],
                        [
                            'externalPropertyName' => 'price',
                            'hubspotPropertyName' => 'price',
                            'dataType' => 'NUMBER'
                        ],
                        [
                            'externalPropertyName' => 'tax_amount',
                            'hubspotPropertyName' => 'tax',
                            'dataType' => 'NUMBER'
                        ]
                    ],
                ],
            ]
        ];
    }
}
