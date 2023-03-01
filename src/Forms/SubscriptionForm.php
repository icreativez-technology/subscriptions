<?php

namespace Botble\Subscription\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Faq\Repositories\Interfaces\FaqCategoryInterface;
use Botble\Subscription\Http\Requests\SubscriptionRequest;
use Botble\Subscription\Models\Subscription;

class SubscriptionForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new Subscription())
            ->setValidatorClass(SubscriptionRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => trans('Name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'rows' => 4,
                ],
            ])
            ->add('amount', 'number', [
                'label' => trans('Amount'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'rows' => 4,
                ],
            ])
            ->add('product_upload_limit', 'number', [
                'label' => trans('Product Upload Limit'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'rows' => 4,
                ],
            ])
            ->add('duration', 'text', [
                'label' => trans('Duration'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'rows' => 4,
                ],
            ])
            // ->add('addons', 'select', [
            //     'label' => trans('Addons'),
            //     'label_attr' => ['class' => 'control-label required'],
            //     'attr' => [
            //         'rows' => 4,
            //     ],
            // ])
            ->add('category_id', 'customSelect', [
                'label' => trans('Addons'),
                'label_attr' => ['class' => 'control-label required'],
                'choices' => ['' => trans('Select Addons')] + app(FaqCategoryInterface::class)->pluck('name', 'id'),
            ])
            ->add('image', 'file', [
                'label' => trans('Image'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'rows' => 4,
                ],
            ])
            ->setBreakFieldPoint('status');
    }
}
