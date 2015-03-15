<?php namespace Fungku\HubSpot\Api;

class Emails extends Api
{
    /**
     * Get email subscription types for a portal.
     *
     * @param int $portal_id
     * @return mixed
     */
    public function subscriptionDefinitions($portal_id)
   {
       $endpoint = "/email/public/v1/subscriptions";

       $options['query'] = ['portalId' => $portal_id];

       return $this->request('get', $endpoint, $options);
   }

    /**
     * View subscriptions timeline for a portal.
     *
     * @param array $params Optional parameters
     * @return mixed
     */
    public function subscriptionsTimeline(array $params = [])
    {
        $endpoint = "/email/public/v1/subscriptions/timeline";

        $options['query'] = $params;

        return $this->request('get', $endpoint, $options);
    }

    /**
     * Get email subscription status for an email address.
     *
     * @param int $portal_id
     * @param string $email
     * @return mixed
     */
    public function subscriptionStatus($portal_id, $email)
    {
        $endpoint = "/email/public/v1/subscriptions/{$email}";

        $options['query'] = ['portalId' => $portal_id];

        return $this->request('get', $endpoint, $options);
    }

    /**
     * Update email subscription status for an email address.
     *
     * @param int $portal_id
     * @param string $email
     * @param array $params
     * @return mixed
     */
    public function updateSubscription($portal_id, $email, array $params = [])
    {
        $endpoint = "/email/public/v1/subscriptions/{$email}";

        $options['query'] = ['portalId' => $portal_id];
        $options['json'] = $params;

        return $this->request('put', $endpoint, $options);
    }

}
