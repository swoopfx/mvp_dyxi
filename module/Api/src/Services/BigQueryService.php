<?php

namespace Api\Services;

class BigQueryService
{
    private string $projectId;
    private string $dataset;
    private array $credentials;

    private ?string $accessToken = null;
    private int $expires = 0;

    public function __construct(array $config)
    {
        $this->projectId = $config['project_id'];
        $this->dataset   = $config['dataset'];

        $this->credentials = json_decode(
            file_get_contents($config['key_file']),
            true
        );
    }

    /**
     * Execute SQL
     */
    public function query(string $sql)
    {
        $url = sprintf(
            "https://bigquery.googleapis.com/bigquery/v2/projects/%s/queries",
            $this->projectId
        );

        return $this->request(
            "POST",
            $url,
            [
                "query"=>$sql,
                "useLegacySql"=>false
            ]
        );
    }

    /**
     * Insert rows
     */
    public function insertRows(string $table,array $rows)
    {
        $url=sprintf(
            "https://bigquery.googleapis.com/bigquery/v2/projects/%s/datasets/%s/tables/%s/insertAll",
            $this->projectId,
            $this->dataset,
            $table
        );

        return $this->request(
            "POST",
            $url,
            [
                "rows"=>$rows
            ]
        );
    }

    /**
     * Get Table
     */
    public function getTable(string $table)
    {
        $url=sprintf(
            "https://bigquery.googleapis.com/bigquery/v2/projects/%s/datasets/%s/tables/%s",
            $this->projectId,
            $this->dataset,
            $table
        );

        return $this->request("GET",$url);
    }

    /**
     * Generic REST call
     */
    private function request($method,$url,$body=null)
    {
        $token=$this->getAccessToken();

        $headers=[
            "Authorization: Bearer ".$token,
            "Content-Type: application/json"
        ];

        $ch=curl_init($url);

        curl_setopt_array($ch,[

            CURLOPT_RETURNTRANSFER=>true,

            CURLOPT_HTTPHEADER=>$headers,

            CURLOPT_CUSTOMREQUEST=>$method

        ]);

        if($body!==null){

            curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($body));

        }

        $response=curl_exec($ch);

        if(curl_errno($ch)){
            throw new \Exception(curl_error($ch));
        }

        $status=curl_getinfo($ch,CURLINFO_HTTP_CODE);

        curl_close($ch);

        if($status>=300){
            throw new \Exception($response);
        }

        return json_decode($response,true);
    }

    /**
     * OAuth2 Access Token
     */
    private function getAccessToken()
    {
        if($this->accessToken && time()<$this->expires){
            return $this->accessToken;
        }

        $jwt=$this->createJWT();

        $ch=curl_init("https://oauth2.googleapis.com/token");

        curl_setopt_array($ch,[

            CURLOPT_RETURNTRANSFER=>true,

            CURLOPT_POST=>true,

            CURLOPT_POSTFIELDS=>http_build_query([

                "grant_type"=>"urn:ietf:params:oauth:grant-type:jwt-bearer",

                "assertion"=>$jwt

            ])

        ]);

        $response=curl_exec($ch);

        curl_close($ch);

        $json=json_decode($response,true);

        $this->accessToken=$json['access_token'];

        $this->expires=time()+3500;

        return $this->accessToken;
    }

    /**
     * Create JWT manually
     */
    private function createJWT()
    {
        $header=[
            "alg"=>"RS256",
            "typ"=>"JWT"
        ];

        $now=time();

        $claims=[

            "iss"=>$this->credentials['client_email'],

            "scope"=>"https://www.googleapis.com/auth/bigquery",

            "aud"=>"https://oauth2.googleapis.com/token",

            "iat"=>$now,

            "exp"=>$now+3600

        ];

        $base64Header=$this->base64url(json_encode($header));
        $base64Claims=$this->base64url(json_encode($claims));

        $signature='';

        openssl_sign(
            $base64Header.".".$base64Claims,
            $signature,
            $this->credentials['private_key'],
            OPENSSL_ALGO_SHA256
        );

        return
            $base64Header.".".
            $base64Claims.".".
            $this->base64url($signature);
    }

    private function base64url($data)
    {
        return rtrim(
            strtr(base64_encode($data),'+/','-_'),
            '='
        );
    }

}