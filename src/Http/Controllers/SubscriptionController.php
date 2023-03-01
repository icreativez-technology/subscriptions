<?php

namespace Botble\Subscription\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Traits\HasDeleteManyItemsTrait;
use Botble\Subscription\Http\Requests\SubscriptionRequest;
use Botble\Subscription\Repositories\Interfaces\SubscriptionInterface;
use Botble\Base\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Request;
use Botble\Subscription\Tables\SubscriptionTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Subscription\Forms\SubscriptionForm;
use Botble\Base\Forms\FormBuilder;

class SubscriptionController extends BaseController
{
    use HasDeleteManyItemsTrait;

    protected SubscriptionInterface $SubscriptionRepository;

    public function __construct(SubscriptionInterface $SubscriptionRepository)
    {
        $this->SubscriptionRepository = $SubscriptionRepository;
    }

    public function index(SubscriptionTable $table)
    {
        page_title()->setTitle(trans('Subscription'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('New Subscription'));

        return $formBuilder->create(SubscriptionForm::class)->renderForm();
    }

    public function store(SubscriptionRequest $request, BaseHttpResponse $response)
    {
        $Subscription = $this->SubscriptionRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(SUBSCRIPTION_MODULE_SCREEN_NAME, $request, $Subscription));

        return $response
            ->setPreviousUrl(route('subscription.index'))
            ->setNextUrl(route('subscription.edit', $Subscription->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(int $id, FormBuilder $formBuilder, Request $request)
    {
        $Subscription = $this->SubscriptionRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $Subscription));

        page_title()->setTitle(trans('Edit Subscription'));

        return $formBuilder->create(SubscriptionForm::class, ['model' => $Subscription])->renderForm();
    }

    public function update(int $id, SubscriptionRequest $request, BaseHttpResponse $response)
    {
        $Subscription = $this->SubscriptionRepository->findOrFail($id);

        $Subscription->fill($request->input());

        $this->SubscriptionRepository->createOrUpdate($Subscription);

        event(new UpdatedContentEvent(SUBSCRIPTION_MODULE_SCREEN_NAME, $request, $Subscription));

        return $response
            ->setPreviousUrl(route('subscription.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Request $request, int $id, BaseHttpResponse $response)
    {
        try {
            $Subscription = $this->SubscriptionRepository->findOrFail($id);

            $this->SubscriptionRepository->delete($Subscription);

            event(new DeletedContentEvent(SUBSCRIPTION_MODULE_SCREEN_NAME, $request, $Subscription));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->SubscriptionRepository, SUBSCRIPTION_MODULE_SCREEN_NAME);
    }
}
