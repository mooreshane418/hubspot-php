<?php namespace Fungku\HubSpot\Api;

class Forms extends Api
{
    /**
     * Submit form data.
     *
     * @param int $portal_id
     * @param string $form_guid
     * @param array $form
     * @return mixed
     */
    public function submit($portal_id, $form_guid, array $form)
    {
        $url = "https://forms.hubspot.com/uploads/form/v2/{$portal_id}/{$form_guid}";

        $options['body'] = $form;

        return $this->requestUrl('post', $url, $options);
    }

    /**
     * Get all forms.
     *
     * @return mixed
     */
    public function all()
    {
        $endpoint = "/contacts/v1/forms";

        return $this->request('get', $endpoint);
    }

    /**
     * Get a single form.
     *
     * @param string $form_guid
     * @return mixed
     */
    public function getById($form_guid)
    {
        $endpoint = "/contacts/v1/forms/{$form_guid}";

        return $this->request('get', $endpoint);
    }

    /**
     * Create a new form.
     *
     * @param array $form
     * @return mixed
     */
    public function create(array $form)
    {
        $endpoint = "/contacts/v1/forms";

        $options['json'] = $form;

        return $this->request('post', $endpoint, $options);
    }

    /**
     * Update a form.
     *
     * @param string $form_guid
     * @param array $form
     * @return mixed
     */
    public function update($form_guid, array $form)
    {
        $endpoint = "/contacts/v1/forms/{$form_guid}";

        $options['json'] = $form;

        return $this->request('post', $endpoint, $options);
    }

    /**
     * Delete a form.
     *
     * @param string $form_guid
     * @return mixed
     */
    public function delete($form_guid)
    {
        $endpoint = "/contacts/v1/forms/{$form_guid}";

        return $this->request('delete', $endpoint);
    }

    /**
     * Get all fields from a form.
     *
     * @param string $form_guid
     * @return mixed
     */
    public function getFields($form_guid)
    {
        $endpoint = "/contacts/v1/fields/{$form_guid}";

        return $this->request('get', $endpoint);
    }

    /**
     * Get a single field from a form.
     *
     * @param string $form_guid
     * @param string $name
     * @return mixed
     */
    public function getFieldByName($form_guid, $name)
    {
        $endpoint = "/contacts/v1/fields/{$form_guid}/{$name}";

        return $this->request('get', $endpoint);
    }
}
