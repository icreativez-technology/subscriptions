<?php

namespace Botble\Subscription\Tables;

use BaseHelper;
use Botble\Subscription\Repositories\Interfaces\SubscriptionInterface;
use Botble\Table\Abstracts\TableAbstract;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class SubscriptionTable extends TableAbstract
{
    protected $hasActions = true;

    protected $hasFilter = true;

    public function __construct(DataTables $table, UrlGenerator $urlGenerator, SubscriptionInterface $SubscriptionRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $SubscriptionRepository;

        if (! Auth::user()->hasAnyPermission(['subscription.edit', 'subscription.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (! Auth::user()->hasPermission('subscription.edit')) {
                    return $item->question;
                }
                return Html::link(route('subscription.edit', $item->id), $item->name);
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('subscription.edit', 'subscription.destroy', $item);
            });

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this->repository->getModel()->select([
            'id',
            'name',
            'category_id',
            'amount',
            'product_upload_limit',
            'duration',
            'addons',
            'created_at',
            'status',
        ]);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            'id' => [
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'title' => trans('Name'),
                'class' => 'text-start',
            ],
            'amount' => [
                'title' => trans('Amount'),
                'class' => 'text-start',
            ],
            'product_upload_limit' => [
                'title' => trans('Product Limit'),
                'class' => 'text-start',
            ],
            'duration' => [
                'title' => trans('Duration'),
                'class' => 'text-start',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('subscription.create'), 'subscription.create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('subscription.deletes'), 'subscription.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('plugins/subscription::subscription.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type' => 'datePicker',
            ],
        ];
    }
}
