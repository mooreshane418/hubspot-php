<?php namespace Fungku\HubSpot\Api;

class MarketPlace extends Api
{
    /**
     * Get all blogs.
     *
     * @param array $params Optional parameters ['limit', 'offset', 'created', 'deleted_at', 'name']
     * @return mixed
     */
    public function all(array $params = [])
    {
        $endpoint = '/content/api/v2/blogs';

        $options['query'] = $params;

        return $this->request('get', $endpoint, $options);
    }

    /**
     * Get information about a specific blog.
     *
     * @param string $id
     * @return mixed
     */
    public function getById($id)
    {
        $endpoint = "/content/api/v2/blogs/{$id}";

        return $this->request('get', $endpoint);
    }

    /**
     * Get previous versions of the blog.
     *
     * @param string $id     Blog id.
     * @param array  $params Optional parameters.
     * @return mixed
     */
    public function versions($id, array $params = [])
    {
        $endpoint = "/content/api/v2/blogs/{$id}/versions";

        $options['query'] = $params;

        return $this->request('get', $endpoint, $options);
    }

    /**
     * Get a previous version of the blog.
     *
     * @param string $id         Blog id.
     * @param string $version_id Version id.
     * @param array  $params     Optional parameters.
     * @return mixed
     */
    public function getVersionById($id, $version_id, array $params = [])
    {
        $endpoint = "/content/api/v2/blogs/{$id}/versions/{$version_id}";

        $options['query'] = $params;

        return $this->request('get', $endpoint, $options);
    }
}
