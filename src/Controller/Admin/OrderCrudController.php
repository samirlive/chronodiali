<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

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
            IdField::new("id")->onlyOnIndex(),
            ChoiceField::new('service_type')->setChoices([
                "Parcel"=>"Parcel",
                "Other"=>"Other"
            ]),
            ChoiceField::new('service_level')->setChoices([
                "Standard"=>"Standard",
                "Other"=>"Other"
            ]),
            TextField::new('requested_tracking_number'),

            FormField::addTab('From'),
            TextField::new('fromExpediter.name'),
            TextField::new('fromExpediter.phone_number')->onlyOnForms(),
            TextField::new('fromExpediter.email')->onlyOnForms(),
            TextField::new('fromExpediter.address1')->onlyOnForms(),
            TextField::new('fromExpediter.address2')->onlyOnForms(),
            TextField::new('fromExpediter.country')->setDisabled(true)->onlyOnForms(),
            TextField::new('fromExpediter.postcode')->onlyOnForms(),

            FormField::addTab('To'),
            TextField::new('toRecipient.name'),
            TextField::new('toRecipient.phone_number')->onlyOnForms(),
            TextField::new('toRecipient.email')->onlyOnForms(),
            TextField::new('toRecipient.address1')->onlyOnForms(),
            TextField::new('toRecipient.address2')->onlyOnForms(),
            TextField::new('toRecipient.country')->setDisabled(true)->onlyOnForms(),
            TextField::new('toRecipient.postcode')->onlyOnForms(),

            FormField::addTab('Parcel JOB'),
            BooleanField::new('parcel_job.is_pickup_required'),
            Field::new('parcel_job.pickup_service_level'),
            Field::new('parcel_job.pickup_address_id')->onlyOnForms(),
            Field::new('parcel_job.pickup_date'),
            Field::new('parcel_job.delivery_start_date'),

            NumberField::new('parcel_job.weight'),
            ChoiceField::new('parcel_job.size')->setChoices([
                "XS"=>"XS",
                "S"=>"S",
                "M"=>"M",
                "L"=>"L",
                "XL"=>"XL",
                "XXL"=>"XXL",

            ]),

            FormField::addTab('Rest API'),
           
            CodeEditorField::new('restApiQuery')->setLanguage("js")->setNumOfRows(30),
            FormField::addTab('graphQL'),
           
            CodeEditorField::new('graphqlApiQuery')->setLanguage("js")->setNumOfRows(30),
            
        ];
    }
    
}
