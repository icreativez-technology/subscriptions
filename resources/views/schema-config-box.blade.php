<a href="#" class="add-subscription-schema-items @if ($hasValue) hidden @endif">{{ trans('plugins/subscription::subscription.add_item') }}</a>

<div class="subscription-schema-items @if (!$hasValue) hidden @endif">
    {!! Form::repeater('subscription_schema_config', $value, [
        [
            'type'       => 'textarea',
            'label'      => trans('plugins/subscription::subscription.question'),
            'label_attr' => ['class' => 'control-label required'],
            'attributes' => [
                'name'    => 'question',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'data-counter' => 1000,
                    'rows'         => 1,
                ],
            ],
        ],
        [
            'type'       => 'textarea',
            'label'      => trans('plugins/subscription::subscription.answer'),
            'label_attr' => ['class' => 'control-label required'],
            'attributes' => [
                'name'    => 'answer',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'data-counter' => 1000,
                    'rows'         => 1,
                ],
            ],
        ],
    ]) !!}
</div>
