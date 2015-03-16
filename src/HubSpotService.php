<?php namespace Fungku\HubSpot;

use Fungku\HubSpot\Exceptions\HubSpotException;
use Fungku\HubSpot\Http\Client;

/**
 * Class HubSpotService
 * @package Fungku\HubSpot
 *
 * @method blogs()
 * @method blogPosts()
 * @method contacts()
 * @method email()
 * @method emailEvents()
 * @method files()
 * @method forms()
 * @method keywords()
 * @method lists()
 * @method marketPlace()
 * @method properties()
 * @method settings()
 * @method socialMedia()
 * @method workflows()
 */
class HubSpotService
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var array
     */
    private $apiClasses = [
        'blogs',
        'blogPosts',
        'contacts',
        'contactLists',
        'contactProperties',
        'email',
        'emailEvents',
        'files',
        'forms',
        'keywords',
        'marketPlace',
        'settings',
        'socialMedia',
        'workflows',
    ];

    /**
     * @param string|null $apiKey
     * @throws HubSpotException
     */
    protected function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey ?: getenv('HUBSPOT_API_KEY');

        if (empty($this->apiKey)) {
            throw new HubSpotException("You must provide a HubSpot api key.");
        }
    }

    /**
     * @param string $apiKey
     * @return static
     */
    public static function make($apiKey = null)
    {
        return new static($apiKey);
    }

    /**
     * @param string $name
     * @return string
     * @throws HubSpotException
     */
    protected function getApiClassName($name)
    {
        if (! in_array($name, $this->apiClasses)) {
            throw new HubSpotException("Api class not found.");
        }

        return 'Fungku\\HubSpot\\Api\\' . ucfirst($name);
    }

    /**
     * @param string $name
     * @param null $arguments
     * @return mixed
     */
    public function __call($name, $arguments = null)
    {
        $apiClass = $this->getApiClassName($name);

        return new $apiClass($this->apiKey, new Client);
    }
}
