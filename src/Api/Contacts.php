<?php namespace Fungku\HubSpot\Api;

use Fungku\HubSpot\Exceptions\HubSpotException;

class Contacts extends Api
{
    /**
     * @param array $contact Array of contact properties.
     * @return mixed
     * @throws HubSpotException
     */
    public function create(array $contact)
    {
        if (! has_required_property('email', $contact)) {
            throw new HubSpotException("You need an email address to create a Contact");
        }

        $endpoint = "/contacts/v1/contact";

        $options['json'] = $contact;

        return $this->request('post', $endpoint, $options);
    }

    /**
     * @param int $id The contact id.
     * @param array $contact The contact properties to update.
     * @return mixed
     */
    public function update($id, array $contact)
    {
        $endpoint = "/contacts/v1/contact/vid/{$id}/profile";

        $options['json'] = $contact;

        return $this->request('post', $endpoint, $options);
    }

    /**
     * @param array $contact The contact properties.
     * @return mixed
     */
    public function createOrUpdate(array $contact)
    {
        $endpoint = "/contacts/v1/contact/createOrUpdate/email/{$contact['email']}";

        $options['json'] = $contact;

        return $this->request('post', $endpoint, $options);
    }

    /**
     * @param array $contacts The contacts and properties.
     * @return mixed
     */
    public function createOrUpdateBatch(array $contacts)
    {
        $endpoint = "/contacts/v1/contact/batch";

        $options['json'] = $contacts;

        return $this->request('post', $endpoint, $options);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        $endpoint = "/contacts/v1/contact/vid/{$id}";

        return $this->request('delete', $endpoint);
    }

    /**
     * @param array $params Optional parameters ['count', 'property', 'offset']
     * @return mixed
     */
    public function all($params)
    {
        $endpoint = "/contacts/v1/lists/all/contacts/all";

        $options['query'] = $this->getQuery($params);

        return $this->request('get', $endpoint, $options);
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function recent($params)
    {
        $endpoint = "/contacts/v1/lists/recently_updated/contacts/recent";

        $options['query'] = $this->getQuery($params);

        return $this->request('get', $endpoint, $options);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getById($id)
    {
        $endpoint = "/contacts/v1/contact/vid/{$id}/profile";

        return $this->request('get', $endpoint);
    }

    /**
     * @param array $vids
     * @param array $params
     * @return mixed
     */
    public function getBatchByIds(array $vids, $params)
    {
        $endpoint = "/contacts/v1/contact/vids/batch/";

        $queryString = $this->generateBatchQuery('vid', $vids);

        $options['query'] = $this->getQuery($params);

        return $this->request('get', $endpoint, $options, $queryString);
    }

    /**
     * @param string $email
     * @return mixed
     */
    public function getByEmail($email)
    {
        $endpoint = "/contacts/v1/contact/email/{$email}/profile";

        return $this->request('get', $endpoint);
    }

    /**
     * @param array $emails
     * @param array $params
     * @return mixed
     */
    public function getBatchByEmails(array $emails, $params)
    {
        $endpoint = "/contacts/v1/contact/vids/batch/";

        $queryString = $this->generateBatchQuery('email', $emails);

        $options['query'] = $this->getQuery($params);

        return $this->request('get', $endpoint, $options, $queryString);
    }

    /**
     * @param string $utk
     * @return mixed
     */
    public function getByToken($utk)
    {
        $endpoint = "/contacts/v1/contact/utk/{$utk}/profile";

        return $this->request('get', $endpoint);
    }

    /**
     * @param array $utks
     * @param array $params
     * @return mixed
     */
    public function getBatchByTokens(array $utks, $params)
    {
        $endpoint = "/contacts/v1/contact/utks/batch/";

        $queryString = $this->generateBatchQuery('utk', $utks);

        $options['query'] = $this->getQuery($params);

        return $this->request('get', $endpoint, $options, $queryString);
    }

    /**
     * @param string $query
     * @param array  $params
     * @return mixed
     */
    public function search($query, $params)
    {
        $endpoint = "/contacts/v1/search/query";

        $params['q'] = $query;

        return $this->request('get', $endpoint, $params);
    }

    /**
     * @return mixed
     */
    public function statistics()
    {
        $endpoint = "/contacts/v1/contacts/statistics";

        return $this->request('get', $endpoint);
    }

}
