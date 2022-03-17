<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Order'),
            TextField::new('service_type'),
            TextField::new('service_level'),
            TextField::new('requested_tracking_number'),

            FormField::addTab('From'),
            TextField::new('fromExpediter.name'),
            TextField::new('fromExpediter.phone_number'),
            TextField::new('fromExpediter.email'),
            TextField::new('fromExpediter.address1'),
            TextField::new('fromExpediter.address2'),
            TextField::new('fromExpediter.country'),
            TextField::new('fromExpediter.postcode'),

            FormField::addTab('To'),
            TextField::new('toRecipient.name'),
            TextField::new('toRecipient.phone_number'),
            TextField::new('toRecipient.email'),
            TextField::new('toRecipient.address1'),
            TextField::new('toRecipient.address2'),
            TextField::new('toRecipient.country'),
            TextField::new('toRecipient.postcode'),

            FormField::addTab('Parcel JOB'),
            BooleanField::new('parcel_job.is_pickup_required'),
            Field::new('parcel_job.pickup_service_level'),
            Field::new('parcel_job.pickup_address_id'),
            Field::new('parcel_job.pickup_date'),
            Field::new('parcel_job.delivery_start_date'),

            Field::new('parcel_job.weight'),
            Field::new('parcel_job.size'),

            FormField::addTab('Rest API'),
           
            CodeEditorField::new('restApiQuery')->setLanguage("js")->setNumOfRows(30),
            FormField::addTab('graphQL'),
           
            CodeEditorField::new('graphqlApiQuery')->setLanguage("js")->setNumOfRows(30),
            
        ];
    }
    
}
