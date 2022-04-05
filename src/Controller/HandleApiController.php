<?php

namespace App\Controller;

use App\Entity\AccessTokenExpiration;
use App\Entity\Address;
use App\Entity\Customer;
use App\Entity\Data;
use App\Entity\DeliveryTimeslot;
use App\Entity\Dimension;
use App\Entity\Item;
use App\Entity\Order;
use App\Entity\ParcelJob;
use App\Entity\PickupTimeslot;
use App\Entity\ReferenceOrder;
use App\Repository\AccessTokenExpirationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HandleApiController extends AbstractController
{ 
  
  
  private function getDataFromGraphql()
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
    curl_setopt($chObj, CURLOPT_VERBOSE, true);
    curl_setopt($chObj, CURLOPT_POSTFIELDS, $json);
    curl_setopt(
      $chObj,
      CURLOPT_HTTPHEADER,
      array(
        'User-Agent: PHP Script',
        'Content-Type: application/json;charset=utf-8',
        'Authorization: Jwt eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VybmFtZSI6ImNocm9ub2RpYWxpdXNlckB3YXNhbC5jb20iLCJleHAiOjE2NDczNTIwMjAsIm9yaWdJYXQiOjE2NDczNTE3MjB9.DkUa6WqSWhSuzRXE7HDqq_937nbjz781L8XRu5HWSyI'
      )
    );

    $response = curl_exec($chObj);
    $ordersJsonDecoded = json_decode($response);
    return $ordersJsonDecoded;
    // dd($ordersJsonDecoded->data->shipments->edges);
  }


  private function generateTokenChronoDiali()
  {
    $chAuth = curl_init();
    curl_setopt($chAuth, CURLOPT_URL, 'https://api.chronodiali.ma/MA/2.0/oauth/access_token?client_id=c2c16b2d7e8d4af7b93e6e5d68bb8fe8&client_secret=1a6465eda7d547d0ac826905414ed560&grant_type=client_credentials');
    curl_setopt($chAuth, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($chAuth, CURLOPT_CUSTOMREQUEST, 'POST');
    //curl_setopt($chObj, CURLOPT_HEADER, true);
    curl_setopt($chAuth, CURLOPT_VERBOSE, true);
    //curl_setopt($chAuth, CURLOPT_POSTFIELDS, $jsonAuth);
  

    $response = curl_exec($chAuth);
    dd($response);
    $chAuthdecode = json_decode($response);
    //dd($chAuthdecode);
    $chAccessToken = $chAuthdecode->access_token;
    $expireAccessToken = $chAuthdecode->expires;
    //dd();
    $expiresAccessToDate = date('Y-m-d H:i:s', $expireAccessToken);
    
    return ["expireAccessToken"=>$expiresAccessToDate, "chAccessToken"=>$chAccessToken ];

    
  }

  private function insertDataInNinjaVan($ordersJsonDecoded)
  {
    $ch = curl_init();

    foreach ($ordersJsonDecoded as $order) {
      //dd($order->node);
      $testAddressFrom = new Address();
      $testAddressFrom->setAddress1($order->node->fulfillmentlocation->address)
        ->setAddress2("")
        ->setArea("")
        ->setcity("")
        ->setState("")
        ->setAddressType("")
        ->setCountry("MY")
        ->setPostcode("");

      $testAddressTo = new Address();
      $testAddressTo->setAddress1($order->node->shippingAddress->address1)
        ->setAddress2("")
        ->setArea("")
        ->setcity($order->node->shippingAddress->city)
        ->setState("")
        ->setAddressType("")
        ->setCountry("MY")
        ->setPostcode($order->node->shippingAddress->postalCode);

      $testFrom = new Customer();
      $testFrom->setName($order->node->fulfillmentlocation->name)
        ->setPhoneNumber($order->node->shippingAddress->phone)
        ->setEmail("")
        ->setAddress($testAddressFrom);

      $testTo = new Customer();
      $testTo->setName($order->node->shippingAddress->fullName)
        ->setPhoneNumber($order->node->shippingAddress->phone)
        ->setEmail("")
        ->setAddress($testAddressTo);

      $testTimeSlot = new PickupTimeslot();
      $testTimeSlot->setStartTime("09:00")
                    ->setEndTime("12:00")
                    ->setTimezone("Asia/Kuala_Lumpur");

      $testDelivert = new DeliveryTimeslot();
      $testDelivert->setStartTime("09:00")
        ->setEndTime("12:00")
        ->setTimezone("Asia/Kuala_Lumpur");

      $testDimension = new Dimension();
      if ($order->node->fulfillmentOrderColisRecords->edgeCount > 0) 
      {
        $testDimension->setWeight($order->node->fulfillmentOrderColisRecords->edges[0]->node->weight);
      } 
      else 
      {
        $testDimension->setWeight(2);
      }
      $items = [];
      $testItem = new Item();
      $testItem->setItemDescription("testtest")
        ->setQuantity(5)
        ->setIsDangerousGood(false);
      array_push($items, $testItem);
      $testParcelJob = new ParcelJob();
      $testParcelJob->setIsPickupRequired(true)
        ->setPickupAddressId("9905505")
        ->setPickupServiceType("Parcel")
        ->setPickupServiceLevel("Nextday")
        ->setPickupDate("")
        ->setPickupTimeslot($testTimeSlot)
        ->setPickupInstructions("pick up with care")
        ->setDeliveryInstructions($order->node->shippingInfo->carrierSpecialNotes)
        ->setDeliveryStartDate("")
        ->setDeliveryTimeslot($order->node->shippingInfo->prefferedDeliveryDate)
        ->setDimensions($testDimension)
        ->setItems($items);

      $testReference = new ReferenceOrder();
      $testReference->setMerchantOrderNumber($order->node->internalReference);
      $testData = new Data();
      if ($order->node->fulfillmentOrderColisRecords->edgeCount > 0) {
        foreach ($order->node->fulfillmentOrderColisRecords->edges as $package) {
          $testData->setServiceType("Parcel")
            ->setServiceLevel("Nextday")
            ->setRequestedTrackingNumber($package->node->trackingNumber)
            ->setReference($testReference)
            ->setFrom($testFrom)
            ->setTo($testTo)
            ->setParcelJob($testParcelJob);
        }
      }
      $jayParsedAry = json_encode($testData);

      curl_setopt($ch, CURLOPT_URL, "https://api.chronodiali.ma/ma/4.1/orders");
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $jayParsedAry);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        [
          'User-Agent: PHP Script',
          'Content-Type: application/json;charset=utf-8',
          'Authorization: Bearer '.$this->generateTokenChronoDiali()["chAccessToken"]
        ]
      );

      $response = curl_exec($ch);
      $decodedResponse = json_decode($response);
      // dd($decodedResponse);
      curl_close($ch);
    }
  }
  

  #[Route('/handle/api', name: 'app_handle_api')]
  public function index(ManagerRegistry $doctrine, AccessTokenExpirationRepository $AccessTokenExpirationRepository)
  {
    
    $accessTokenRepo = $AccessTokenExpirationRepository->findAll();
    $getCreatedAtOfAccessTokenExpirationRepository = $accessTokenRepo[0]->getCreatedAt()->format("Y-m-d H:i:s");
    if(empty($this->generateTokenChronoDiali()))
    {
      return ;
    }
    else{
      $generateTokenChronoDialiDate = $this->generateTokenChronoDiali()["expireAccessToken"];
      $generateTokenChronoDialiToken = $this->generateTokenChronoDiali()["chAccessToken"];
      
        /*if($getCreatedAtOfAccessTokenExpirationRepository <= date("Y-m-d H:i:s"))
        {*/
          $setTokenInfo = $accessTokenRepo[0]->setCreatedAt(new \DateTime($generateTokenChronoDialiDate))->setToken($generateTokenChronoDialiToken);
          $doctrine->getManager()->persist($setTokenInfo);
          $doctrine->getManager()->flush();
        /*}
        else{
          //dd("already used");
        }*/
    }
    $ordersJsonDecoded = $this->getDataFromGraphql()->data->shipments->edges;
    $this->insertDataInNinjaVan($ordersJsonDecoded);
    //dd($ordersJsonDecoded);
    dd($ordersJsonDecoded);
  }

}
