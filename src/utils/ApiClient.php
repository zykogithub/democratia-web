<?php
class ApiClient {
    private const BASE_URL = 'https://projets.iut-orsay.fr/saes3-mmarti32/API/Api.php';
    private $lastError = '';
    private $lastCode = 0;
    private $lastResult = null;

    public function get($params = [], $query = null) {
        return $this->request('GET', $params, $query);
    }

    public function post($params = [], $query = null) {
        return $this->request('POST', $params, $query);
    }
    
    public function patch($params = [], $query = null) {
        return $this->request('PATCH', $params,  $query);
    }

    public function delete($params = [], $query = null) {
        return $this->request('DELETE', $params,  $query);
    }

    public function getValeurRetourne() {
        return $this->lastResult;
    }

    public function getMessaDerreur() {
        return $this->lastError;
    }

    public function getCodDeRetourApi() {
        return $this->lastCode;
    }

    private function request($method, $params=[], $query) {
        $data = [
            'parameters' => $params,
            'requete' => $query
        ];

        $options = [
            'http' => [
                'method' => $method,
                'header' => 'Content-Type: application/json',
                'content' => json_encode($data)
            ]
        ];

        $context = stream_context_create($options);
        
        try {
            $response = file_get_contents(urldecode(self::BASE_URL), false, $context);
            
            if ($response === false) {
                $this->lastError = 'Failed to connect to API';
                $this->lastCode = 500;
                $this->lastResult = null;
                return false;
            }

            $result = json_decode($response, true);
            
            if (!$result) {
                $this->lastError = 'Invalid response from API';
                $this->lastCode = 500;
                $this->lastResult = null;
                return false;
            }

            $this->lastResult = $result['data'] ?? null;
            $this->lastCode = $result['code'] ?? 500;
            $this->lastError = $result['message'] ?? '';

            return $result['success'] ?? false;

        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            $this->lastCode = 500;
            $this->lastResult = null;
            return false;
        }
    }
}