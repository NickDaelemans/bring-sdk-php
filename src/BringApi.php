<?php

namespace Bring;

use Exception;
use GuzzleHttp\Client;

const URL = 'https://api.getbring.com/rest/v2/';
class BringApi {

  private string $email;

  private string $password;

  private array $headers;

  private string $uuid;

  /**g
   *
   * @return string[]
   */
  public function getHeaders(): array {
    return $this->headers;
  }

  /**
   * @param string[] $headers
   */
  public function setHeaders(array $headers): void {
    $this->headers = $headers;
  }

  /**
   * Construct the BringApi class.
   *
   * @param $email
   *   The e-mailadress to connect with.
   * @param $password
   *   The password to connect with.
   */
  public function __construct($email, $password) {
    $this->email = $email;
    $this->password = $password;
    $this->headers = [
      'X-BRING-API-KEY' => 'cof4Nc6D8saplXjE3h3HXqHH8m7VU2i1Gs0g85Sp',
      'X-BRING-CLIENT' => 'webApp',
      'X-BRING-CLIENT-SOURCE' => 'webApp',
      'X-BRING-COUNTRY' => 'BE',
    ];
  }

  /**
   * Helper function to create requests.
   *
   * @param $url
   *   The url to make the request to.
   * @param array $options
   *   Options to pass with the request (optional).
   * @param string $method
   *   The method to use for the request. Defaults to POST.
   *
   * @return object|NULL
   *   The request response or FALSE if something goes wrong.
   */
  protected function createRequest($url, $options = [], $method = 'POST'): ?object {
    try {
      $client = new Client();
      $body = [
        'headers' => $this->headers,
      ];
      if ($options) {
        $body['form_params'] = $options;
      }
      $res = $client->request($method, $url, $body);
      return $res->getBody();
    } catch (Exception $exception) {
      echo 'Something went wrong. ' . $exception->getMessage();
      return NULL;
    }
  }

  /**
   * Login with the provided credentials.
   */
  public function login() {
    $response = $this->createRequest(URL . 'bringauth', [
      'email' => $this->email,
      'password' => $this->password,
    ]);
    $result = json_decode($response);
    $this->headers['X-BRING-USER-UUID'] = $result->uuid;
    $this->uuid = $result->uuid;
    $this->headers['Authorization'] = 'Bearer ' . $result->access_token;
  }

  /**
   * Add item to given list.
   *
   * @param $listUuid
   *   The list to add the item to.
   * @param $name
   *   The name of the item.
   * @param string $specification
   *   The specification to add to the item (optional).
   */
  public function addItem($listUuid, $name, $specification = '') {
    $this->createRequest(URL . 'bringlists/' . $listUuid, [
      'purchase' => $name,
      'specification' => $specification,
    ], 'PUT');
  }

  public function getLists() {
    return $this->createRequest(URL . 'bringusers/' . $this->uuid . '/lists', [], 'GET');
  }

  public function getItemsFromList($listUuid) { 
    return $this->createRequest(URL . 'bringlists/' . $listUuid, [], 'GET');
  }

}

