<?php
// api/src/EventSubscriber/OrderMailSubscriber.php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Customer;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Mime\Email;

final class OrderSubscriber implements EventSubscriberInterface
{
    
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['postDataApi', EventPriorities::POST_WRITE],
        ];
    }

    public function postDataApi(ViewEvent $event): void
    {
        $order = $event->getControllerResult();
       
        $method = $event->getRequest()->getMethod();

        


        if (!$order instanceof Order || Request::METHOD_POST !== $method) {
            return;
        }
        
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
dd(json_decode($response));

           
    }


 


}