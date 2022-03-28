<?php

namespace App\Controller;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

class HandleApiController extends AbstractController
{
    #[Route('/handle/api', name: 'app_handle_api')]
    public function index(ManagerRegistry $doctrine): Response
    {
        //GRAPHQL request
        $query = <<<'GRAPHQL'
        {
            shipments {
              edges {
                node {
                  internalReference
                  shippingAddress {
                    id
                    companyName
                    fullName
                    jobTitle
                    address1
                    address2
                    city
                    stateCode
                    countryCode
                    phone
                    postBox
                    postalCode
                    salutation
                    suffix
                    suite
                    title
                  }
                  fulfillmentlocation {
                    name
                    address
                    latitude
                    longitude
                  }
                  shippingInfo {
                    prefferedDeliveryDate
                    shippingMethod
                    codValue
                    shipmentValue
                    carrierName
                    packagingType
                    carrierSpecialNotes
                    customerSpecialNotes
                  }
                  trackingNumber
                  externalTrackingNumber
                  deliveryStatus
                  deliveryStatusCode
                  deliveryDate
                  creationDate
                  modifiedDate
                  fulfillmentOrderColisRecords {
                    edgeCount
                    edges {
                      node {
                        packageId
                        weight
                        trackingNumber
                        externalTrackingNumber
                        creationDate
                        modifiedDate
                      }
                    }
                  }
                }
              }
            }
          }
        GRAPHQL;

$variables = '';

$json = json_encode(['query' => $query, 'variables' => $variables]);

$chObj = curl_init();
curl_setopt($chObj, CURLOPT_URL, 'https://pms-staging.ayourworld.com/graphql/carrierapis');
curl_setopt($chObj, CURLOPT_RETURNTRANSFER, true);    
curl_setopt($chObj, CURLOPT_CUSTOMREQUEST, 'GET');
//curl_setopt($chObj, CURLOPT_HEADER, true);
curl_setopt($chObj, CURLOPT_VERBOSE, true);
curl_setopt($chObj, CURLOPT_POSTFIELDS, $json);
curl_setopt($chObj, CURLOPT_HTTPHEADER,
     array(
            'User-Agent: PHP Script',
            'Content-Type: application/json;charset=utf-8',
            'Authorization: Jwt eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6ImNocm9ub2RpYWxpdXNlckB3YXNhbC5jb20iLCJleHAiOjE2NDczNTIwMjAsIm9yaWdJYXQiOjE2NDczNTE3MjB9.DkUa6WqSWhSuzRXE7HDqq_937nbjz781L8XRu5HWSyI' 
        )
    ); 

$response = curl_exec($chObj);
$ordersJsonDecoded = json_decode($response);

// Version Array a eviter
//$orders = $ordersJsonDecoded["data"]["shipments"]["edges"];

//dd($orders[0]["node"]["fulfillmentOrderColisRecords"]["edges"][0]["node"]["packageId"]);

    foreach($ordersJsonDecoded->data->shipments->edges as $singleOrder){

/*
        $order = new Order();

        // les setters



        $doctrine->getManager()->persist($order);
        $doctrine->getManager()->flush();
*/
      dump($singleOrder);


      
    }

    

    $response = new JsonResponse("DONE");

    return $response;

    }

    
}
