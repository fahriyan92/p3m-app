<?php 


class Data_api {
  public function get_data($query = '')
  {
    $token = $this->get_token();
    $client = new GuzzleHttp\Client();
    $testing = $client->request('GET', 'http://api.polije.ac.id/resources/kepegawaian/pegawai?'.$query,
    [
      'headers' => [
        'Accept' => 'application/json',
        'Authorization' => 'Bearer '. $token
      ]
    ]);

    $result =  $testing->getBody();
    return $result;
  }

  public function get_token()
  {
    $client = new GuzzleHttp\Client();
    $url = 'http://api.polije.ac.id/oauth/token';
    try {
      $response = $client->request('POST', $url,
      ['form_params' => [
        'grant_type' => 'client_credentials',
        'client_id' => 15,
        'client_secret' => 'mBZ2WUtk6HEj0zHB24mX3EN2YAL6orRh1yjuOmW7'
      ]]);
 
      
      return json_decode($response->getBody(),true)['access_token'];
    } catch (GuzzleHttp\Exception\BadResponseException $e) {
      $result = $e->getResponse();
      $woi = $result->getBody()->getContents();
      print_r($woi);
    }
  }


}